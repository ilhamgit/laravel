@extends($activeTemplate.'layouts.homefrontend')
@section('content')

    @php
        $bannerElements = getContent('banner.element');
    @endphp

    @include($activeTemplate.'newhome.racing')
    @include($activeTemplate.'newhome.about')
    @include($activeTemplate.'newhome.video')
    @include($activeTemplate.'newhome.gameplay')
    @include($activeTemplate.'newhome.tokenomics')
    @include($activeTemplate.'newhome.our-nft')
    @include($activeTemplate.'newhome.timeline')

@endsection
