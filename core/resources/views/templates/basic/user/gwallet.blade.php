@extends($activeTemplate.'layouts.blankpage')
@section('content')

<div style="font-size: 20px;line-height: 26px;margin-top: -9px;font-weight: 600;padding-top: 12px;color: white;font-family: 'Nunito', sans-serif;"><span data-g>{{$walbal}}</span> G</div>

<!--<script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.0.4/socket.io.js"> </script>-->
         <script type="text/javascript">
         
            setInterval(function () {
                window.location.reload();
            }, 10000);
            
        //NOT WORKING WS
        //$(function($) {
                
          
            //  var walletid = "{{$user->wallet_id}}";
            //
            //  console.log('initiating connection....');
            // 
            //  var sock = io("http://139-59-114-178.cprapid.com:4000", {
            //      transports: ['websocket'],
            //      query: 'token='+walletid
            //  });
            //
            //   sock.on("connect", function() {
            //       console.log('connected to server');
            //
            //   });
        
        
            //sock.on('laravel_database_action-channel-one:App\\Events\\ActionEvent', function (data) {
            //    console.log('chanel 1');
            //    console.log('g= '+data.g);
            //    console.log('p= '+data.p);
            //    
            //    $('[data-g]').html(data.g);
            //    $('[data-p]').html(data.p);
            //});
        

            //$("[data-breed]").on('click',function(e){
            //    
            //    $.ajax({
            //        url: "/metahorse/wallettest",
            //        method: "POST",
            //        data:{
            //            "_token": "{{ csrf_token() }}",
            //            'id':walletid,
            //            'dataType':'html'
            //        },
            //        success: function (response) {
            //            console.log(response);
            //
            //        },
            //    });
            //
            //});
        
        //});
        </script>
@endsection

