@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="dashboard-section">


                        <form class="profile-edit-form row mb--25 text-white my-3 text-uppercase" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="first-name">@lang('First Name') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control bg-grey" name="firstname" value="{{$user->firstname}}" minlength="3" required>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="last-name">@lang('Last Name') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control bg-grey"  name="lastname" value="{{$user->lastname}}" minlength="3" required>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="state">@lang('Username')</label>
                                <input type="text" class="form-control form--control bg-grey" value="{{$user->username}}" readonly>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="email">@lang('E-mail Address')</label>
                                <input type="text" class="form-control form--control bg-grey" value="{{$user->email}}" readonly>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="mobile">@lang('Mobile Number')</label>
                                <input type="text" class="form-control form--control bg-grey" name="mobile" value="{{$user->mobile}}">
                            </div>
                            <div class="form--group w-100 col-md-6 mb-0 text-right">
                                <button type="submit" class="btn btn-golden justify-content-center px-3">@lang('Update Profile')</button>
                            </div>
                        </form>

    </section>
@endsection
