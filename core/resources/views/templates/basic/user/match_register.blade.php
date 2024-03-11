@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')



    @php

    //echo $widget['nUGData'];

    //echo '<pre class="text-white">';

    //print_r($gdata['nhorses']);

    //echo '</pre>';

    /*foreach($gdata['nhorses'] as $hid => $horse){
        if($horse->isEligibleJoin==''){

            unset($gdata['nhorses'][$hid]);
        }
    }*/

    if(count($gdata['horses'])>0){

        @endphp

                <section class="bg--section">
                    <div class="container">

                        <div class="text-right">

                            <a href="{{  url($gdata['back_link']) }}" class="btn btn-golden px-3 py-2" style="margin-top: -15%;">@lang('Back')</a>

                        </div>
                        <p class="text-white mb-4" style="margin-top: -30px;">@lang('THE RANKED CHAMPIONSHIP IS OPENED FOR REGISTRATION IN EVERY THURSDAY OF SEASON. JOIN NOW BEFORE IT'S TOO LATE!')</p>
                        <div class="row justify-content-between align-items-center">
                            <div class="col-12">

                                
                                

                                       @php


                                        //Columns must be a factor of 12 (1,2,3,4,6,12)
                                        $numOfCols = 3;
                                        $rowCount = 12;
                                        $bootstrapColWidth = 12 / $numOfCols;

                                        /*$rows=array();

                                        for($hi=1; $hi<=65; $hi++){

                                            $rows[]=$hi;

                                        }*/


                                        if(count($gdata['nhorses'])>0){

                                        @endphp

                                            <form class="match-register w-100" method="post">
                                                @csrf <!-- {{ csrf_field() }} -->

                                                <h5 class="text-left py-2">* @lang('SELECT WHICH HORSE TO COMPETE')</h5>

                                                <div class="row justify-content-between align-items-center">

                                        @php

                                            foreach ($gdata['nhorses'] as $hid => $horse){


                                                $horse_url=url('user/horse-stat?horse='.$horse->horseId);

                                                $registered=url('assets/images/match/RegisterStamp.png');
                                                $noteligible=url('assets/images/match/NotEligibleStamp.png');


                                                echo '<div class="col-md-4 my-2 horses"><label style="padding:0;">
                                                  <input type="radio" name="horse" value="'.$horse->horseId.'" '; if($horse->isRegistered=='true'||$horse->isEligibleJoin==''){ echo'disabled';} echo'>
                                                     
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <p class="h-num text-uppercase" style="text-align: left">'.$horse->horseName.'</p>
                                                                </div>
                                                                <div class="card-body p-none text-right">
                                                                    ';
                                                                    if($horse->isRegistered=='true'){

                                                                        echo '<img class="reg-sticker" src="'.$registered.'" width="80px">';
                                                                    }else if($horse->isEligibleJoin==''){
                                                                        echo '<img class="reg-sticker" src="'.$noteligible.'" width="80px">';
                                                                    }
                                                                    echo '
                                                                    <img class="horse-image '; if($horse->isRegistered=='true'){ echo'registered';} echo'" src="https://d1k0k5uveaqxkp.cloudfront.net/fit-in/300x300/'.$horse->fileName.'" width="100%">
                                                                </div>
                                                            </div>
                                                </label>
                                            </div>
                                                ';
                                                $rowCount++;
                                                if($rowCount % $numOfCols == 0) echo '</div><div class="row justify-content-between align-items-center">';
                                            }

                                            echo '</div>
                                    
                                    <button type="submit" name="breed_submit" class="btn btn-golden px-4 py-3 my-2 disabled">Register Horse</button>

                                </form>';

                                        }else{
                                            echo "<h5 class='my-3 text-white'>@lang('NO HORSE AVAILABLE.')</h5>";
                                        }

                                        

                                        @endphp

                                        
                                    

                            </div>
                        </div>

                    </div>
                </section>

                <script>
                    jQuery(document).ready(function($){
                        $('input[type="radio"]').change(function(){
                            $('button.disabled').removeClass('disabled');
                        });

                        $('.horse-list').after('<div id="nav" class="text-center"></div>');
                          var rowsShown = 3;
                          var rowsTotal = $('.horse-list .row').length;
                          console.log(rowsTotal);
                          var numPages = rowsTotal / rowsShown;

                          if(rowsTotal>1){
                            for (i = 0; i < numPages; i++) {
                                var pageNum = i + 1;
                                $('#nav').append('<a href="#" class="btn-outline-info" rel="' + i + '">&emsp;' + pageNum + '&emsp;</a> ');
                              }
                              $('.horse-list .row').hide();
                              $('.horse-list .row').slice(0, rowsShown).show();
                              $('#nav a:first').addClass('active');
                              $('#nav a').bind('click', function(e) {
                                e.preventDefault();
                                $('#nav a').removeClass('active');
                                $(this).addClass('active');
                                var currPage = $(this).attr('rel');
                                var startItem = currPage * rowsShown;
                                var endItem = startItem + rowsShown;
                                $('.horse-list .row').css('opacity', '0').hide().slice(startItem, endItem).
                                css('display', 'flex').animate({
                                  opacity: 1
                                }, 300);
                              });
                          }

                    });
                </script>

        @php

    }else{

    }    

    @endphp


@endsection

