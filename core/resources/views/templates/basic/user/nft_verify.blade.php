@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    @php

    $h_details=array();

    $issuper="";

    foreach($gdata['horses'] as $horse){

        $break=0;

        if($horse->horseId == $_POST['horse']){

            $h_details=$horse;

            if($h_details->isSuperHorse=='true'){
                $issuper="true";
            }else{
                $issuper="false";
            }

            @endphp

    <section class="bg--section">
        <div class="container text-right">
            <a href="{{  url('user/breed?horse='.$h_details->horseId) }}" class="btn btn-golden px-3 py-2" style="margin-top: -10%;">@lang('Back')</a>
            <div class="row justify-content-between align-items-center">
                <div class="col-12 my-5 text-center">
                    <div class="row my-5">
                        
                        <div class="col-md-4 text-center p-4">
                            <img src="https://d1k0k5uveaqxkp.cloudfront.net/fit-in/300x300/{{$h_details->fileName}}">
                        </div>

                        <div class="col-md-4 text-center p-4">
                            
                            <h4 class="text-white">@lang('REQUIRED COINS')</h4>

                            <p class="text-white mt-5">5 G</p>

                        </div>

                        <div class="col-md-4 text-center p-4">
                            <img src="https://d1k0k5uveaqxkp.cloudfront.net/fit-in/300x300/0{{$_POST['breed']}}.Female.png" alt="Option {{$_POST['breed']}}">
                        </div>

                    </div>
                    
                    <!-- Trigger/Open The Modal -->
                    <button id="startBreed" class="btn btn-golden px-4 py-3">@lang('Let&apos;s Breed')</button>

                    <!-- The Modal -->
                    <div id="nftResult" class="modal">

                      <!-- Modal content -->
                      <div class="modal-content text-center">
                        <span class="close">&times;</span>
                        
                        <h2>@lang('HORSE BREED')</h2>

                        <img src="https://d1k0k5uveaqxkp.cloudfront.net/fit-in/300x300/HS01-283.png" width="300px">

                        <h2>@lang('SUCCESSFULLY')</h2>

                      </div>

                    </div>
                    

                </div>
            </div>

        </div>
    </section>

    <script>
        // // Get the modal
        // var modal = document.getElementById("nftResult");

        // // Get the button that opens the modal
        // var btn = document.getElementById("startBreed");

        // // Get the <span> element that closes the modal
        // var span = document.getElementsByClassName("close")[0];

        // // When the user clicks on the button, open the modal
        // btn.onclick = function() {
        //   modal.style.display = "block";
        //   modal.style.display.fadeIn(1000);
        // }

        // // When the user clicks on <span> (x), close the modal
        // span.onclick = function() {
        //   modal.style.display = "none";
        //   modal.style.display.fadeOut(1000);
        // }

        // // When the user clicks anywhere outside of the modal, close it
        // window.onclick = function(event) {
        //   if (event.target == modal) {
        //     modal.style.display = "none";
        //     modal.style.display.fadeOut(1000);
        //   }
        // }
    </script>

    @php

        $break++;

        }else{

            continue;

        }

        if($break==1){
            break;
        }else{

            $notify[] = ['error', 'You dont have this horse'];
            echo back()->withNotify($notify);

        }

    }
    @endphp

    <script>

        $('#startBreed').on('click',function(){
            $.ajax({
                url: "{{ route('user.bridge.standard-breed') }}",
                method: "POST",
                data:{
                    '_token': "{{ csrf_token() }}",
                    'horse_id': '{{ $_POST["horse"] }}',
                    'breed_id': '{{ $_POST["breed"] }}',
                    'superhorse': '{{ $h_details->isSuperHorse ?? 0 }}',
                    'dataType':'JSON'
                },
                dataType: 'JSON',
                success: function (response) {
                    if(response.success){
                        window.location = response.link;
                    }
                }
            });
        });


    </script>
@endsection
