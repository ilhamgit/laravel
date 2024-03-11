@php
    $referContent = getContent('refer.content',true);
    $referElements = getContent('refer.element',false,null,true);
@endphp

<section class="referral-section  bg--section pt-60 pb-60 overflow-hidden">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="referral--thumb">
                    <img src="{{ getImage('assets/images/frontend/refer/'.@$referContent->data_values->image,'655x720') }}" alt="referral">
                </div>
            </div>
            <div class="col-lg-6 col-xl-5">
                <div class="referral--content pb-60 pt-60">
                    <div class="section__header">
                        <span class="section__category">@lang('Mystery Box')</span>
                        <h3 class="section__title">{{__(@$referContent->data_values->heading)}}</h3>
                        @auth
                            <p>
                                {{__(@$referContent->data_values->details)}}
                            </p>

                                        <form id="mystery-box-form">
                                            <input type="hidden" name="user" value="{{session()->get('user')}}">
                                            <div class="form-group">
                                                <label for="BoxQuantity">Box Quantity (1 Box = 3G) : </label>
                                                <div class="row my-3">
                                                    <div class="col-1 bg-dark">
                                                        <span class="qty-btn minus">-</span>
                                                    </div>
                                                    <div class="col-4">
                                                        @php

                                                        $balance = session()->get('g');

                                                        if($balance>0){

                                                            $rrbalance = ($balance-$balance%3)/3;

                                                            echo '
                                                            <input type="number" class="form-control w-100" id="BoxQuantity" name="quantity" value="1" min="1" max="'.$rrbalance.'">
                                                            ';

                                                        }

                                                        //echo $rrbalance;

                                                        @endphp
                                                    </div>
                                                    <div class="col-1 bg-dark">
                                                        <span class="qty-btn plus">+</span>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <input type="submit" class="btn bpurchase btn-info w-50" name="mb-submit" value="Purchase">
                                                    </div>
                                                </div>
                                                
                                              </div>
                                        </form>
                                        <p id="result"></p>
                        @else
                            <!--<a href="{{route('user.register')}}" class="cmn--btn btn--sm mr-3">@lang('Register')</a>-->
                            <!--<a href="{{route('user.login')}}" class="text--white">-->
                            <!--    <i class="las la-user"></i>-->
                            <!--    <span>@lang('Login Now')</span>-->
                            <!--</a>-->
                            <p class="my-3">Please connect your wallet before purchase mystery box:-</p>
                            <a href="#" class="cmn--btn btn--sm mr-3" onclick="web3Login();">@lang('Connect To Wallet')</a> 
                        @endauth
                        
                    </div>
                    <div class="row g-3 g-sm-4">
                        @foreach($referElements as $item)
                        <div class="col-md-12">
                            <div class="referral__item">
                                <h5 class="referral__item-thumb">
                                    <span class="d-block">{{__(@$item->data_values->percentage)}}%</span>
                                </h5>
                                <div class="referral__item-content">
                                    <h6 class="title">{{__(@$item->data_values->level_no)}}</h6>
                                    <p>
                                        {{__(@$item->data_values->details)}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
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

            $("#mystery-box-form").on("submit", function(event){
                event.preventDefault();
         
                var formValues= $(this).serialize();

                console.log(formValues);
         
                // $.post("/core/api/user/boxes", formValues, function(data){
                //     // Display the returned data in browser
                //     $("#result").html(data);
                //     console.log(data);
                // });

                

                var qty=$('input[name=quantity]').val();
                var user=$('input[name=user]').val();

                var form = $('#mystery-box-form');
                var actionUrl = "/core/api/user/boxes?qty="+qty+'&usr='+user;

                console.log(qty+'|'+user);
                
                $.ajax({
                    url: actionUrl,// serializes the form's elements.
                    success: function(data)
                    {
                      alert(data); // show response from the php script.

                      //location.reload();
                    }
                });
            });
        });
</script>
