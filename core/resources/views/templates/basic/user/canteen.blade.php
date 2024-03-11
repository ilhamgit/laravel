@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    @php

    $h_details=array();

    $image='';


    //echo '<hr>';

    //print_r($i_details);

    //echo '<hr>';

    @endphp

    <section class="bg--section">
        <div class="container text-uppercase">
            <div class="text-right mb-3" style="margin-top: -7%;">
                <a href="{{  $gdata['back_link'] }}"><button type="button" class="btn btn-golden px-3 py-2">@lang('Back')</button></a>
            </div>
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="{{$gdata['iframe_link']}}" width="1000px" height="563px"></iframe>
            </div>

        </div>
    </section>

@endsection

