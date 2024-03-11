@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    @php

    $h_details=$gdata['horses_new'];

    $lang=str_replace(' ', '', session()->get('lang'));


    if(isset($h_details->horseId)){

    @endphp

        <section class="bg--section">
        <div class="text-uppercase">
            
            <div class="row justify-content-between">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="row">
                        <div class="col-6 py-3">
                            <h4 class="text-white text-left">{{$h_details->horseName}}</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{  url('user/super-breed') }}" class="btn btn-golden px-3 py-2">@lang('Back')</a>
                        </div>
                    </div>
                    <div class="about--thumb @php if($h_details->isDestroyed===true){ echo'destroyed';} @endphp">
                        @php
                        if($h_details->isSuperHorse=='true'){

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
                                <span>{{$h_details->raceCount}} @lang('races')</span>
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
                            <div class="text-white col-md-12 px-2"><hr class="my-2" /></div>
                            <div class="col-md-3 col-6 p-2">
                                <span class="text-bold">@lang('Owner'):</span>
                            </div>
                            <div class="col-md-9 col-6 p-2">
                                {{$h_details->username}}
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
                                <button type="button" class="btn btn-golden btn-breed mx-auto d-block w-100 h-100 p-0 border-0"><img src="{{url('assets/images/button/'.$lang.'/SuperBreed_color.png')}}" class="rounded"></button>
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

                    @php

                        if($h_details->isSuperHorse=='true'){
                            echo 'var type="Super";';
                        }else{
                            echo 'var type="Super";';
                        }

                    @endphp

                    $('<form method="post">@csrf<input type="hidden" name="hid" value="'+horse+'"><input type="hidden" name="type" value="'+type+'"><input type="hidden" name="o" value="0"></form>').appendTo('body').submit();
                });
            });
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

