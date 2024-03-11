@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    @php

    $h_details=array();


    //echo '<hr>';

    //print_r($enc_data);

    //echo '<hr>';

    @endphp

    <section class="bg--section">
        <div class="container text-uppercase">
            <div class="text-right mb-3" style="margin-top: -7%;">
                <a href="{{$gdata['back_link']}}"><button type="button" class="btn btn-golden px-3 py-2">Back</button></a>
            </div>
            <div class="embed-responsive embed-responsive-1by1">
              <iframe class="embed-responsive-item" src="{{$gdata['iframe_link']}}" width="1000px" height="563px" id="iFrame1"></iframe>
            </div>

        </div>
    </section>

    <script type="application/javascript">

        function resizeIFrameToFitContent( iFrame ) {

            iFrame.width  = iFrame.contentWindow.document.body.scrollWidth;
            iFrame.height = iFrame.contentWindow.document.body.scrollHeight;
        }

        window.addEventListener('DOMContentLoaded', function(e) {

            var iFrame = document.getElementById( 'iFrame1' );
            resizeIFrameToFitContent( iFrame );

            // or, to resize all iframes:
            var iframes = document.querySelectorAll("iframe");
            for( var i = 0; i < iframes.length; i++) {
                resizeIFrameToFitContent( iframes[i] );
            }
        } );

        </script>

@endsection

