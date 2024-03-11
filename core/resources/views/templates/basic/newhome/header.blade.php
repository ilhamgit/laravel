<nav class="navbar navbar-expand-md shadow-sm">
    <div class="row w-100 py-3">
        <div class="col-md-3 d-xs-none"></div>
        <div class="col-md-6">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item my-4 px-2"><a href="{{url('assets/whitepaper')}}/@lang('whitepaper_en').pdf" class="nav-link" target="_blank">@lang('Whitepaper')</a></li>
                    <li class="nav-item my-4 px-2"><a href="#tokenomic" class="nav-link">@lang('About Us')</a></li>
                    <li class="nav-item my-4 px-2"><a href="#video" class="nav-link">@lang('Video')</a></li>
                    <li class="nav-item my-4 px-2"><a href="#gameplay" class="nav-link">@lang('Gameplay')</a></li>
                    <li class="nav-item px-2"><a href="/" class="nav-link"><img src="{{ asset('assets/newhome/storage/img/logo.png') }}" width="90px"></a></li>
                    <li class="nav-item my-4 px-2"><a href="#tokenomic" class="nav-link">@lang('Tokenomics')</a></li>
                    <li class="nav-item my-4 px-2"><a href="#nft" class="nav-link">@lang('NFT')</a></li>
                    <li class="nav-item my-4 px-2"><a href="#roadmap" class="nav-link">@lang('Roadmap')</a></li>
                    <li class="nav-item my-4 px-2 lang-sel">
                        <select class="langSel">
                            <option value="en" @php if(session()->get('lang')=='en'){echo 'selected';}@endphp>EN</option>
                            <option value="jp" @php if(session()->get('lang')=='jp'){echo 'selected';}@endphp>JP</option>
                            <option value="zh" @php if(session()->get('lang')=='zh'){echo 'selected';}@endphp>ZH</option>
                        </select>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-3 d-xs-none d-flex align-items-center justify-content-center ">
            <div class="d-none d-md-block mx-3">
                        <a href="https://sales.meta-horse.io/" class="btn btn-default btn-md">@lang('Buy Ticket')</a>
                    </div>
            @auth
                    <div class="d-none d-md-block">
                        <a href="{{route('user.home')}}" class="btn btn-default btn-md">@lang('Dashboard')</a>
                    </div>
                @else
                    <div class="right-area d-none d-md-block">
                        <!--<a href="{{route('user.register')}}" class="cmn--btn btn--sm">@lang('Register Now')</a>-->
                        <!--<a href="{{route('user.login')}}">-->
                        <!--    <i class="las la-user"></i>-->
                        <!--    <span>@lang('Login Now')</span>-->
                        <!--</a>-->
                         <a href="#" class="btn btn-default btn-md" onclick="web3Login();">@lang('Connect To Wallet')</a> 
                    </div>
                @endguest
        </div>
    </div>
</nav>
<section class="main-banner w-100 p-none">
    <video autoplay muted loop id="main-banner-video">
      <source src="{{ asset('assets/videos/horse.mp4') }}" type="video/mp4">
    </video>
    <div class="banner-btn-section">
        <a href="https://sales.meta-horse.io/" target="_blank" class="d-flex justify-content-center"><button type="button" class="btn banner-button btn-default btn-lg" data-entrance="from-bottom">@lang('Buy Ticket')</button></a>
    </div>
</section>