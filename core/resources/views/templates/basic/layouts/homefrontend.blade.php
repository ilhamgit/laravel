<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Metahorse - Let the Race Begin</title>

    @include('partials.seo')

    <!--CSS -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">

    <link href="{{ asset('assets/newhome/css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/newhome/css/header.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/newhome/css/racing.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/newhome/css/about.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/newhome/css/video.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/newhome/css/gameplay.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/newhome/css/tokenomics.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/newhome/css/purchase-coin.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/newhome/css/our-nft.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/newhome/css/timeline.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/newhome/css/footer.css') }}" rel="stylesheet">

    <script src="{{ asset('assets/newhome/js/scroll-entrance.js') }}"></script>

    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>

    @stack('style-lib')

    @stack('style')
    
    <script src="https://cdn.ethers.io/lib/ethers-5.2.umd.min.js"></script>
    
    <script>
        async function web3Login() {
            if (!window.ethereum) {
                alert('MetaMask not detected. Please install MetaMask first.');
                return;
            }
    
            const provider = new ethers.providers.Web3Provider(window.ethereum);
    
            // let response = await fetch('/web3-login-message');
            const message = 'By clicking on "Sign In", you agreed to share your wallet to metahorse.ga';
    
            await provider.send("eth_requestAccounts", []);
            const address = await provider.getSigner().getAddress();
            const signature = await provider.getSigner().signMessage(message);

            console.log('address - '+address);
            
            console.log('signature - '+signature);
    
            response = await fetch('{{url("web3-login-verify")}}', {
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
            
            if(data=='false'){
                window.location.href = "{{url('register?wlt=')}}"+address;
            }else{

                const user = JSON.parse(data);

                console.log(data);

                if(user.status==1){
                    window.location.href = "{{url('user/dashboard')}}";
                }else{
                    iziToast.error({title:'Error',message: 'Your account was banned.',position: 'topRight'});
                }

                
            }
            
            console.log(data);
    
            
        }
    </script>
    <style>
        [data-entrance] { visibility: hidden; }

        .js [data-entrance] { visibility: hidden; }
    </style>

</head>
<body class="home">

    @include($activeTemplate.'newhome.header')
        @yield('content')
    @include($activeTemplate.'newhome.footer')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    
    <script src="{{asset('assets/global/js/bootstrap.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/rafcounter.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/magnific-popup.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/owl.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/yscountdown.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>

    @stack('script-lib')

    @stack('script')

    @include('partials.plugins')

    @include('partials.notify')



    <script>
        (function ($) {
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


        })(jQuery);
    </script>



</body>
</html>
