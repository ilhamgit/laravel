@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="bg--section">

            
            <div class="row justify-content-between align-items-center">
                <div class="col-12 horse-list">

                    <div class="row justify-content-between align-items-center">

                        <div class="col-md-6 mystery-box">
                            <a href="{{url('user/draw-box')}}">
                                <div class="card">
                                    <div class="card-header">
                                        <p class="h-num text-uppercase">@lang('Draw Box')</p>
                                    </div>
                                    <div class="card-body p-3">
                                        <img src="{{url('assets/images/frontend/refer/mysterybox_.png')}}" class="w-75 mx-auto d-block">
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6 mystery-box">
                            <a href="{{url('user/purchase-box')}}">
                                <div class="card">
                                    <div class="card-header">
                                        <p class="h-num text-uppercase">@lang('Purchase Box')</p>
                                    </div>
                                    <div class="card-body p-3">
                                        <img src="{{url('assets/images/frontend/refer/mysterybox.png')}}" class="w-75 mx-auto d-block">
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                </div>
            </div>


    </section>

@endsection

