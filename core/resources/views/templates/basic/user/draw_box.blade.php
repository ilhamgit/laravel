@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    @endphp

    <section class="bg--section">
        <div class="container text-uppercase">
            <div class="text-right mb-3" style="margin-top: -7%;">
                <a href="{{  url('user/mystery-box') }}"><button type="button" class="btn btn-golden px-3 py-2">@lang('Back')</button></a>
            </div>
             <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="{{$gdata['iframe_link']}}" width="1000" height="563"></iframe>
            </div>

        </div>
    </section>

@endsection

