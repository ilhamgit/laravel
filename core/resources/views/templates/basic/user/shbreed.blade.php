@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    @php

    $h_details=array();

    $horse=$gdata['horses'];

        $break=0;

            $h_details=$horse;

            @endphp

                <section class="bg--section">
                    <div class="container text-right">
                        <a href="{{  url('user/superhorse-stat?horse='.$h_details->horseId) }}" class="btn btn-golden px-3 py-2" style="margin-top: -10%;">@lang('Back')</a>
                        <div class="row justify-content-between align-items-center">
                            <div class="col-12 my-5 text-center">
                                
                                <form class="breed-horse w-100" action="{{  url('user/shbreed-verify') }}" method="post">
                                    @csrf <!-- {{ csrf_field() }} -->
                                    <input type="hidden" name="horse" value="@php echo $_GET['horse']; @endphp">
                                    <input type="hidden" name="o" value="@php echo $_GET['o']; @endphp">

                                    <h3 class="text-center">@lang('Select horse breed type')</h3>

                                    <div class="row mx-3 my-5">
                                        <div class="col-md-4 text-center">
                                            <label>
                                              <input type="radio" name="breed" value="1">
                                              <img src="https://d1k0k5uveaqxkp.cloudfront.net/fit-in/300x300/01.Female.png" alt="Option 1">
                                            </label>
                                            <p class="text-center my-2 text-white">A</p>

                                        </div>
                                        <div class="col-md-4 text-center">
                                            <label>
                                              <input type="radio" name="breed" value="2">
                                              <img src="https://d1k0k5uveaqxkp.cloudfront.net/fit-in/300x300/02.Female.png" alt="Option 2">
                                            </label>
                                            <p class="text-center my-2 text-white">B</p>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <label>
                                              <input type="radio" name="breed" value="3">
                                              <img src="https://d1k0k5uveaqxkp.cloudfront.net/fit-in/300x300/03.Female.png" alt="Option 3">
                                            </label>
                                            <p class="text-center my-2 text-white">C</p>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" name="breed_submit" class="btn btn-golden px-4 py-3 disabled">@lang("Let's Breed")</button>

                                </form>

                            </div>
                        </div>

                    </div>
                </section>

                <script>
                    jQuery(document).ready(function($){
                        $('input[type="radio"]').change(function(){
                            $('button.disabled').removeClass('disabled');
                        });
                    });
                </script>

                @php


    

    @endphp


@endsection

