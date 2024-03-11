@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="bg--section">
        <div class="container text-uppercase">
            
            <div class="row justify-content-between">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="about--thumb">
                        <img src="{{url('assets/images/frontend/refer/mysterybox.png')}}" class="w-75">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="pb-3">
                        <div class="row mb-1">
                            <div class="col-md-10">
                                <h4 class="text-white pt-2">@lang('Get Your Mystery Box')</h4>
                            </div>
                            <div class="col-md-2">
                                <a href="{{  url('user/mystery-box') }}" class="btn btn-golden px-3 py-2">@lang('Back')</a>
                            </div>
                        </div>
                        <div class="row my-3 bg-grey ">
                            <div class="col-12 p-3 text-white">
                                
                                @auth

                                @php

                                    $balance = $widget['GBalance'];

                                    if($balance>0){

                                        $rrbalance = ($balance-$balance%3)/3;

                                        @endphp

                                            <p class="my-1">@lang('Purchase the mystery box here'):-</p>

                                                <form method="post" id="mystery-box-form">
                                                    
                                                    
                                                    @csrf

                                                    @php

                                                        echo '
                                                    <div class="form-group py-2">

                                                        <label for="BoxQuantity">@lang('Box Quantity') (1 @lang('Box') = 3G) : </label>
                                                        <div class="row my-3">
                                                            <div class="col-1 bg-dark">
                                                                <span class="qty-btn minus">-</span>
                                                            </div>
                                                            <div class="col-4">

                                                            <input type="number" class="form-control w-100" id="BoxQuantity" name="quantity" value="1" min="1" max="'.$rrbalance.'">
                                                            </div>
                                                            <div class="col-1 bg-dark">
                                                                <span class="qty-btn plus">+</span>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <input type="submit" class="btn bpurchase btn-golden w-50" name="mb-submit" value="Purchase">
                                                            </div> 
                                                        </div>
                                                        
                                                      </div>
                                                </form>
                                                <p id="result"></p>
                                        ';

                                    }else{
                                        echo "<p class='p-3'>@lang('You don&apos;t have any G credit.')</p>";
                                    }
                                @endphp

                                                            
                                @else
                                    <!--<a href="{{route('user.register')}}" class="cmn--btn btn--sm mr-3">@lang('Register')</a>-->
                                    <!--<a href="{{route('user.login')}}" class="text--white">-->
                                    <!--    <i class="las la-user"></i>-->
                                    <!--    <span>@lang('Login Now')</span>-->
                                    <!--</a>-->
                                    <p class="my-3">@lang('Please connect your wallet before purchase mystery box'):-</p>
                                    <a href="#" class="cmn--btn btn--sm mr-3" onclick="web3Login();">@lang('Connect To Wallet')</a> 
                                @endauth
                            </div>
                        </div>

                    </div>
                </div>            
            </div>

        </div>
    </section>

    <script>
    $(document).ready(function($){
            $('.count').prop('disabled', true);
            $(document).on('click','.plus',function(){

                var max = $('#BoxQuantity').attr('max');

                console.log(max);

                if ($('#BoxQuantity').val() == max) {
                    $('#BoxQuantity').val(max);
                }else{
                    $('#BoxQuantity').val(parseInt($('#BoxQuantity').val()) + 1 );
                }
            });
            $(document).on('click','.minus',function(){
                $('#BoxQuantity').val(parseInt($('#BoxQuantity').val()) - 1 );
                if ($('#BoxQuantity').val() == 0) {
                    $('#BoxQuantity').val(1);
                }
            });

            
        });
</script>

@endsection

