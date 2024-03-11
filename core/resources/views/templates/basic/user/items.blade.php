@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')


    <section class="bg--section">

            <div class="text-right mb-3" style="margin-top: -7%;">
                <a href="{{  url('user/canteen') }}"><button type="button" class="btn btn-golden px-3 py-2">Canteen</button>
            </div>
            <div class="row justify-content-between align-items-center">
                <div class="col-12 items-list">

                    <div class="row align-items-center">

                        @php


                        //Columns must be a factor of 12 (1,2,3,4,6,12)
                        $numOfCols = 3;
                        $rowCount = 12;
                        $bootstrapColWidth = 12 / $numOfCols;

                        if(count($gdata['items'])>0){
                            foreach ($gdata['items'] as $item){


                                $image=str_replace(' ', '', $item->itemName);
                                echo '  
                                        <div class="col-md-4 items">
                                        <a href="#" class="w-100 mb-3" iid="'.$item->itemUniqueId.'">
                                            <div class="card">
                                                <div class="card-header">
                                                    <p class="h-num text-uppercase">'.$item->itemName.'</p>
                                                </div>
                                                <div class="card-body p-5">
                                                    <img src="'.url('assets/images/items').'/'.$image.'.png" width="100%">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                ';
                                $rowCount++;
                                if($rowCount % $numOfCols == 0) echo '</div><div class="row align-items-center">';
                            }
                        }else{
                            echo "<h5 class='my-3 text-white'>NO ITEM AVAILABLE.</h5>";
                        }

                        @endphp

                    </div>

                </div>
            </div>



    </section>

    <script>

        $(document).ready(function() {
          $('.items-list').after('<div id="nav" class="text-center"></div>');
          var rowsShown = 3;
          var rowsTotal = $('.items-list .row').length;
          var numPages = rowsTotal / rowsShown;
          if(rowsTotal>1){
            for (i = 0; i < numPages; i++) {
                var pageNum = i + 1;
                $('#nav').append('<a href="#" class="btn-outline-info" rel="' + i + '">&emsp;' + pageNum + '&emsp;</a> ');
              }
              $('.items-list .row').hide();
              $('.items-list .row').slice(0, rowsShown).show();
              $('#nav a:first').addClass('active');
              $('#nav a').bind('click', function(e) {
                e.preventDefault();
                $('#nav a').removeClass('active');
                $(this).addClass('active');
                var currPage = $(this).attr('rel');
                var startItem = currPage * rowsShown;
                var endItem = startItem + rowsShown;
                $('.items-list .row').css('opacity', '0').hide().slice(startItem, endItem).
                css('display', 'flex').animate({
                  opacity: 1
                }, 300);
              });
          }

          $('.items a').on('click',function(e){

            e.preventDefault();

            var plink = "{{url('user/verify-item')}}";

            var hid = $(this).attr('iid');

            $('<form action="'+plink+'" method="post">@csrf<input type="hidden" name="iid" value="'+hid+'"></form>').appendTo('body').submit();

          });

        });
    </script>

@endsection

