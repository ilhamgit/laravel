@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    @php

    $h_details=array();

    $image='';

    $item_desc='';

    $item=$gdata['items_new'];


        if(isset($item->itemUniqueId)){

            $i_details=$item;

            $image=str_replace(' ', '', $item->itemName);

            switch($i_details->itemName){

                case 'Apple':

                    $item_desc='Feed your horse to increase Endurance.';

                    break;

                case 'Horse Carrot':

                    $item_desc='Feed your horse to increase Speed.';

                    break;
                case 'Banana':

                    $item_desc='Feed your horse to increase Stamina.';

                    break;

                case 'Honey Pot':

                    $item_desc='Feed your horse to increase Force.';

                    break;

                case 'Pasture Grass':

                    $item_desc='Feed your horse to increase Temper.';

                    break;

                case 'Juice':

                    $item_desc='Feed your horse to reduce Tireness.';

                    break;

                case 'Horse Brush':

                    $item_desc='Consume to increase Training SP % (one match use).';

                    break;

                case 'Blinker':

                    $item_desc='Consume to increase PVP Score % (one match use).';

                    break;

                case 'Horse Whip':

                    $item_desc='Consume to increase PVP Temper % (one match use).';

                    break;

            }

            @endphp
                <section class="bg--section">
                    <div class="text-uppercase">
                        
                        <div class="row justify-content-between">
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="row">
                                    <div class="col-6 py-3">
                                        <h4 class="text-white text-left">@lang($i_details->itemName)</h4>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{  url('user/items') }}" class="btn btn-golden px-3 py-2">@lang('Back')</a>
                                    </div>
                                </div>
                                <div class="about--thumb bg-grey p-5">
                                    <img src="@php echo url('assets/images/items').'/'.$image.'.png'; @endphp" width="100%">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="horse-stat-content pb-3">

                                    <div class="row mb-1">
                                        <div class="col-6 py-1">
                                            <h4 class="text-white">@lang('About')</h4>
                                        </div>
                                        <div class="col-6 text-right">
                                            
                                        </div>
                                    </div>
                                    <div class="row mb-5 bg-grey border-between">
                                        <div class="col-md-3 col-6 p-2">
                                            <span class="text-bold">@lang('Item Name'):</span>
                                        </div>
                                        <div class="col-md-3 col-6 p-2 bdr-right">
                                            <span>{{$i_details->itemName}}</span>
                                        </div>
                                        <div class="col-md-3 col-6 p-2">
                                            <span class="text-bold">@lang('Item Type'):</span>
                                        </div>
                                        <div class="col-md-3 col-6 p-2">
                                            <span>@lang('Edible')</span>
                                        </div>
                                        <div class="col-12 p-1">
                                            <span class="text-bold"><hr></span>
                                        </div>
                                        <div class="col-12 p-1">
                                            <span class="text-bold">{{$item_desc}}</span>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-12">
                                            <h4 class="text-white">Stats</h4>
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
                                                    <h3 class="text-white text-center">{{$i_details->speed}}</h3>
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
                                                    <h3 class="text-white text-center">{{$i_details->endurance}}</h3>
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
                                                    <h3 class="text-white text-center">{{$i_details->stamina}}</h3>
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
                                                    <h3 class="text-white text-center">{{$i_details->force}}</h3>
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
                                                    <h3 class="text-white text-center">{{$i_details->temper}}</h3>
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
                                                    <h3 class="text-white text-center">{{$i_details->tireness}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 bg-grey border-between">
                                        <div class="col-md-4 p-3 bdr-right">
                                            <p class="stat-title text-center">@lang('Training SP')</p>
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/Training_SP.png') }}" width="60px" height="60px">
                                                </div>
                                                <div class="col-md-8 text-center py-2">
                                                    <h3 class="text-white text-center">{{$i_details->trainingSPMultiplier*100}}%</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 p-3 bdr-right">
                                            <p class="stat-title text-center">@lang('PVP Score')</p>
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/pvp.png') }}" width="60px" height="60px">
                                                </div>
                                                <div class="col-md-8 text-center py-2">
                                                    <h3 class="text-white text-center">{{$i_details->pvpScoreMultiplier*100}}%</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 p-3">
                                            <p class="stat-title text-center">@lang('PVP Temper')</p>
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/temper_multiplier.png') }}" width="60px" height="60px">
                                                </div>
                                                <div class="col-md-8 text-center py-2">
                                                    <h3 class="text-white text-center">{{$i_details->pvpTemperMultiplier*100}}%</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>            
                        </div>

                    </div>
                </section>

                @php

        }else{

            $message = $item->messages;

            $notify[] = ['error', $message[0]];
            echo back()->withNotify($notify);
        }


    //echo '<hr>';

    //print_r($gdata['items_new']);

    //echo '<hr>';

    @endphp

    

@endsection

