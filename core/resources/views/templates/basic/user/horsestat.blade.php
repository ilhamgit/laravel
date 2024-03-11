@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')


    <!-- <pre class="text-white"> -->
     @php

      //print_r($gdata['horses_new']);

      $lang=str_replace(' ', '', session()->get('lang'));

     @endphp
    <!-- </pre> -->


    @php

        $h_details=$gdata['horses_new'];
        $type="";


        if(isset($h_details->horseId)){

        @endphp

            <section class="bg--section">
                <div class="container text-uppercase">
                    <div class="row justify-content-between">
                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="row">
                                <div class="col-6 py-3">
                                    <h4 class="text-white text-left">{{$h_details->horseName}}</h4>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{  url('user/horses') }}" class="btn btn-golden px-3 py-2">@lang('Back')</a>
                                </div>
                            </div>
                            <div class="about--thumb @php if($h_details->isDestroyed===true){ echo'destroyed';} @endphp">
                                @php
                                if($h_details->isSuperHorse===true){

                                    $sh_badge=getImage(imagePath()['logoIcon']['path'] .'/SuperBreed.png');

                                    echo '<img class="sh-badge" src="'.$sh_badge.'" width="80px">';
                                }
                                @endphp
                                <img src="https://d1k0k5uveaqxkp.cloudfront.net/fit-in/500x500/{{$h_details->fileName}}" width="100%">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="horse-stat-content pb-3">
                                <div class="row mb-1">
                                    <div class="col-12 py-1">
                                        <h4 class="text-white">@lang('About')</h4>
                                    </div>
                                </div>
                                <div class="row mb-5 bg-grey border-between">
                                    <div class="col-md-3 col-6 p-2">
                                        <span class="text-bold">@lang('Total Race'):</span>
                                    </div>
                                    <div class="col-md-3 col-6 p-2 bdr-right">
                                        <span>{{$h_details->raceCount}} @lang('Races')</span>
                                    </div>
                                    <div class="col-md-3 col-6 p-2">
                                        <span class="text-bold">@lang('Lifespan'):</span>
                                    </div>
                                    <div class="col-md-3 col-6 p-2">
                                        <span>{{$h_details->age}} @lang('Years')</span>
                                    </div>
                                    <div class="col-md-3 col-6 p-2">
                                        <span class="text-bold">@lang('Horse Type'):</span>
                                    </div>
                                    <div class="col-md-3 col-6 p-2 bdr-right">
                                        @if ($h_details->isSuperHorse===true)
                                            <p class="text-white">@lang('Super')</p>
                                        @else
                                            <p class="text-white">@lang('Normal')</p>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-6 p-2">
                                        <span class="text-bold">@lang('Convert'):</span>
                                    </div>
                                    <div class="col-md-3 col-6 p-2">
                                        @if ($h_details->isEligibleSuperHorse===true)
                                            <p class="text-white">@lang('Yes')</p>
                                        @else
                                            <p class="text-white">@lang('No')</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-12">
                                        <h4 class="text-white">@lang('Stats')</h4>
                                    </div>
                                </div>

                                <div class="row mb-3 bg-grey border-between">
                                    <div class="col-md-4 p-3 bdr-right">
                                        <p class="stat-title text-center">@lang('Speed')</p>
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/speed_icon.png') }}" width="60px" height="60px">
                                            </div>
                                            <div class="col-md-8 text-center py-2">
                                                <h3 class="text-white text-center">{{$h_details->speed}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-3 bdr-right">
                                        <p class="stat-title text-center">@lang('Endurance')</p>
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/endurance_icon.png') }}" width="60px" height="60px">
                                            </div>
                                            <div class="col-md-8 text-center py-2">
                                                <h3 class="text-white text-center">{{$h_details->endurance}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-3">
                                        <p class="stat-title text-center">@lang('Stamina')</p>
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/stamina.png') }}" width="60px" height="60px">
                                            </div>
                                            <div class="col-md-8 text-center py-2">
                                                <h3 class="text-white text-center">{{$h_details->stamina}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 bg-grey border-between">
                                    <div class="col-md-4 p-3 bdr-right">
                                        <p class="stat-title text-center">@lang('Force')</p>
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/power.png') }}" width="60px" height="60px">
                                            </div>
                                            <div class="col-md-8 text-center py-2">
                                                <h3 class="text-white text-center">{{$h_details->force}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-3 bdr-right">
                                        <p class="stat-title text-center">@lang('Temper')</p>
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/temper.png') }}" width="60px" height="60px">
                                            </div>
                                            <div class="col-md-8 text-center py-2">
                                                <h3 class="text-white text-center">{{$h_details->temper}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 p-3">
                                        <p class="stat-title text-center">@lang('Tiredness')</p>
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/tiredness.png') }}" width="60px" height="60px">
                                            </div>
                                            <div class="col-md-8 text-center py-2">
                                                <h3 class="text-white text-center">{{$h_details->tireness}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 bg-grey border-between button-action">
                                    <div class="col-md-4 p-3 bdr-right">
                                        @if($h_details->isEligibleSuperHorse === true && $h_details->isSuperHorse === false)
                                             <a href="javascript:" onclick="updateHorse()" class="w-100 h-100"><button class="btn mx-auto w-100 h-100 p-0 border-0"><img src="{{url('assets/images/button/'.$lang.'/SuperHorse_color.png')}}" class="rounded"></button></a>
                                        @elseif($h_details->isEligibleSuperHorse === true && $h_details->isSuperHorse === true)
                                            <button class="btn mx-auto disabled w-100 h-100 p-0 border-0"><img src="{{url('assets/images/button/'.$lang.'/SuperHorse_Grey.png')}}" class="rounded"></button>
                                        @else
                                             <button class="btn mx-auto disabled w-100 h-100 p-0 border-0"><img src="{{url('assets/images/button/'.$lang.'/SuperHorse_Grey.png')}}" class="rounded"></button>
                                        @endif
                                    </div>
                                    <div class="col-md-4 p-3 bdr-right">
                                        @php
                                            if($h_details->isSuperHorse===true&&$h_details->isRented===false){
                                                echo '<a href="#" class="w-100 h-100 btn-rent">
                                                    <button class="btn mx-auto w-100 h-100 p-0 border-0"><img src="'.url('assets/images/button/'.$lang.'/Rent_color.png').'" class="rounded"></button></a>';
                                            }else if($h_details->isSuperHorse===true&&$h_details->isRented===true){
                                                echo '<button class="btn mx-auto w-100 h-100 p-0 border-0 disabled"><img src="'.url('assets/images/button/'.$lang.'/RentED_Grey.png').'" class="rounded"></button>';
                                            }else{
                                                echo '<button class="btn mx-auto w-100 h-100 p-0 border-0 disabled"><img src="'.url('assets/images/button/'.$lang.'/Rent_Grey.png').'" class="rounded"></button>';
                                            }
                                        @endphp
                                    </div>
                                    <div class="col-md-4 p-3">
                                        @php
                                        if($h_details->hasBreed===false&&$h_details->isRetired===true&&$h_details->isSuperHorse===false){
                                                echo '<button type="button" class="btn mx-auto btn-breed w-100 h-100 p-0 border-0"><img src="'.url('assets/images/button/'.$lang.'/Breed_Color.png').'" class="rounded"></button>';
                                            } else if($h_details->hasBreed===false&&$h_details->isRetired===true&&$h_details->isSuperHorse===true){
                                                echo '<button type="button" class="btn mx-auto btn-breed w-100 h-100 p-0 border-0"><img src="'.url('assets/images/button/'.$lang.'/SuperBreed_color.png').'" class="rounded"></button>';
                                            }else{
                                              echo '<button type="button" class="btn mx-auto btn-breed disabled w-100 h-100 p-0 border-0"><img src="'.url('assets/images/button/'.$lang.'/Breed_Grey.png').'" class="rounded"></button>';
                                            }
                                        @endphp
                                    </div>
                                </div>

                                <div class="row mb-3 bg-grey border-between button-action">
                                    <div class="col-md-4 p-3 bdr-right">
                                        @php 
                                            if($h_details->isDestroyed===false){

                                        @endphp

                                            <a href="{{  url('user/horse-train?horse=') }}{{$h_details->horseId}}" class="w-100 h-100">
                                                <button type="button" class="btn train-horse mx-auto d-block w-100 h-100 p-0 border-0"><img src="{{url('assets/images/button/'.$lang.'/Train_Horse.png')}}" class="rounded"></button>
                                            </a>

                                        @php

                                            }

else{
                                            
echo '<button type="button" class="btn train-horse mx-auto d-block disabled w-100 h-100 p-0 border-0"><img src="'.url('assets/images/button/'.$lang.'/Train_Horse_Grey.png').'" class="rounded"></button>';
                                            }


                                        @endphp
                                        
                                    </div>
                                    <div class="col-md-4 p-3 bdr-right">
                                        
                                    </div>
                                    <div class="col-md-4 p-3">
                                        
                                    </div>
                                </div>

                            </div>
                        </div>            
                    </div>

                </div>
            </section>

            <script>
                $(document).ready(function($){

                        $(".btn-breed").on("click", function(event){

                            var user='{{$user->username}}';
                            var horse='{{$h_details->horseId}}';
                            var type='{{$type}}';

                            $('<form method="post">@csrf<input type="hidden" name="hid" value="'+horse+'"><input type="hidden" name="type" value="'+type+'"><input type="hidden" name="o" value="1"></form>').appendTo('body').submit();
                        });


                        $('.btn-rent').on('click',function(e){


                            var plink = "{{url('user/horse-rent')}}";

                            var hid = '{{$h_details->horseId}}';

                            $('<form action="'+plink+'" method="post">@csrf<input type="hidden" name="hid" value="'+hid+'"></form>').appendTo('body').submit();

                      });
                });

                function updateHorse(){
                    $.ajax({
                        url: "{{ route('user.bridge.update-superhorse') }}",
                        method: "POST",
                        data:{
                            '_token': "{{ csrf_token() }}",
                            'horse_id': '{{ $h_details->horseId }}',
                            'dataType':'JSON'
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            if(response.success){
                                window.location = response.link;
                            }
                        },
                    });
                }
            </script>

            @php


        }else{

            $message = $h_details->messages;

            $notify[] = ['error', $message[0]];
            echo back()->withNotify($notify);
        }



    //echo '<pre class="text-white">';

    //print_r($gdata['horses_new']);

    //echo '</pre>';

    @endphp
@endsection

