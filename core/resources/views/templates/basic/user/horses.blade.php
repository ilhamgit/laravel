@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')


    <!-- {{ $widget['UGData'] }} -->

    <section class="bg--section">
        
            
            <div class="row justify-content-between align-items-center">
                <div class="col-12 horse-list">

                    <div class="row align-items-center">

                        @php


                        //Columns must be a factor of 12 (1,2,3,4,6,12)
                        $numOfCols = 3;
                        $rowCount = 12;
                        $bootstrapColWidth = 12 / $numOfCols;

                        /*$rows=array();

                        for($hi=1; $hi<=65; $hi++){

                            $rows[]=$hi;

                        }*/

                        if(count($gdata['horses'])>0){
                            foreach ($gdata['horses'] as $hid => $horse){


                                $horse_url=url('user/horse-stat?horse='.$horse->horseId);

                                $sh_badge=getImage(imagePath()['logoIcon']['path'] .'/SuperBreed.png');

                                $horseclass='';

                                if($horse->isSuperHorse=='true'){
                                    $horseclass='super-horse';
                                }


                                echo '  
                                        <div class="col-md-4 horses '.$horseclass.'">
                                        <a href="#" class="w-100 mb-2" hid="'.$horse->horseId.'">
                                            <div class="card">
                                                <div class="card-header">
                                                    <p class="h-num text-uppercase">'.$horse->horseName.'</p>
                                                </div>
                                                <div class="card-body p-none text-right '; if($horse->isDestroyed===true){ echo'destroyed';} echo'">
                                                    ';
                                                    if($horse->isSuperHorse=='true'){

                                                        echo '<img class="sh-badge" src="'.$sh_badge.'" width="80px">';
                                                    }
                                                    echo '
                                                    <img src="https://d1k0k5uveaqxkp.cloudfront.net/fit-in/300x300/'.$horse->fileName.'" width="100%">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                ';
                                $rowCount++;
                                if($rowCount % $numOfCols == 0) echo '</div><div class="row align-items-center">';
                            }
                        }else{
                            echo "<h5 class='my-3 text-white'>@lang('NO HORSE AVAILABLE.')</h5>";
                        }

                        

                        @endphp

                    </div>

                </div>
            </div>



    </section>

    <script>

        $(document).ready(function() {
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

          $('.horses a').on('click',function(e){

            e.preventDefault();

            var plink = "{{url('user/verify-horse')}}";

            var hid = $(this).attr('hid');

            $('<form action="'+plink+'" method="post">@csrf<input type="hidden" name="hid" value="'+hid+'"></form>').appendTo('body').submit();

          });
        });
    </script>

@endsection

