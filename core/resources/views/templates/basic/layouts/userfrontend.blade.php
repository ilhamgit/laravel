<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>

    @include('partials.seo')

    <!--CSS -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/owl.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/app.4fab7e58.css')}}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/betting.css') }}?v=2" >
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php?color1='.$general->base_color)}}">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>

    
    <script src="https://cdn.ethers.io/lib/ethers-5.2.umd.min.js"></script>
    
    <script>
        async function web3Login() {
            if (!window.ethereum) {
                alert('MetaMask not detected. Please install MetaMask first.');
                return;
            }
    
            const provider = new ethers.providers.Web3Provider(window.ethereum);
    
            // let response = await fetch('/web3-login-message');
            const message = 'By clicking on "Sign In", you agreed to share your wallet to metahorse.io';
    
            await provider.send("eth_requestAccounts", []);
            const address = await provider.getSigner().getAddress();
            const signature = await provider.getSigner().signMessage(message);

            console.log('address - '+address);
            
            console.log('signature - '+signature);
    
            response = await fetch('/metahorse/web3-login-verify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'address': address,
                    'signature': signature,
                    '_token': '{{ csrf_token() }}'
                })
            });
            const data = await response.text();
            
            if(data=='true'){
                
                window.location.href = "/metahorse/user/dashboard";
            }else{
                window.location.href = "/metahorse/register?wlt="+address;
            }
            
            console.log(data);
    
            
        }
    </script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    </head>
    <body class="bg-meta-darker px-0">
        @include($activeTemplate.'partials.header')
        <div class="container bg-meta-dark rounded mt-4">
            <div class="row">
                <div class="col-md-3 border-end border-2 border-secondary">
                    @include($activeTemplate.'layouts.sidebar')
                </div>
                <div class="col-md-9 py-3 px-4 px-md-5" style="color: #1A1A1A;">
                    @include($activeTemplate.'partials.wallet')
                    @yield('content')
                </div>
            </div>
        </div>
        @include('partials.notify')
        @include($activeTemplate.'partials.footer')

        @php
            $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
        @endphp

        @if(@$cookie->data_values->status && !session('cookie_accepted'))
            <div class="cookie-remove text-uppercase">
                <div class="cookie__wrapper bg--section">
                    <div class="container">
                        <div class="flex-wrap align-items-center justify-content-between">
                            <h4 class="title">@lang('Cookie Policy')</h4>
                            <div class="txt my-2">
                                @php echo @$cookie->data_values->description @endphp
                            </div>
                            <div class="button-wrapper">
                                <button class="btn btn-golden policy cookie">@lang('Accept')</button>
                                <a class="btn btn-golden" href="{{ @$cookie->data_values->link }}" target="_blank" class=" mt-2">@lang('Read Policy')</a>
                                <a href="javascript:void(0)" class="btn btn-golden btn--close cookie-close"><i class="las la-times"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


         <script>
            $(function($) {

                "use strict";

                $(".langSel").on("change", function() {
                    window.location.href = "{{route('home')}}/change/"+$(this).val() ;
                });

                $('.cookie').on('click',function () {
                    var url = "{{ route('cookie.accept') }}";

                    $.get(url,function(response){

                        if(response.success){
                            notify('success',response.success);
                            $('.cookie-remove').html('');
                        }
                    });
                });

                $('.cookie-close').on('click',function () {
                    $('.cookie-remove').html('');
                });

                
               
        
        });
        </script>
    </body>
</html>
