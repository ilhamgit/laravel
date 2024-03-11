@php
    $policyElements =  getContent('policy_pages.element');
    $socialIcons =  getContent('social_icon.element',false);
@endphp

<footer>
    <div class="pt-80 pb-80">
        <div class="container">
            <div class="row gy-5 justify-content-between">
                <div class="col-lg-4 col-md-6">
                    <div class="footer__widget text--white">
                        <div class="logo">
                            <a href="{{route('home')}}" class="d-block">
                                <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" class="w-100" alt="logo">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    
                </div>
                <div class="col-lg-2 col-6">
                    
                </div>
                <div class="col-lg-4 col-xl-3 col-md-6">
                    
                </div>
            </div>
        </div>
    </div>
     <!--<div class="footer-bottom text--white text-center">
        <div class="container">
           {{__(@$headerFooterContent->data_values->copyright)}} <a href="{{route('home')}}" class="text--base">{{$general->sitename}}</a>
        </div>
    </div>-->
</footer>

@push('script')
    <script>
        'use strict';

        (function ($) {
            $('.subs').on('click',function () {
                var email = $('#subscriber').val();
                var csrf = '{{csrf_token()}}'
                var url = "{{ route('subscriber.store') }}";
                var data = {email:email, _token:csrf};

                $.post(url, data,function(response){
                    if(response.success){
                        notify('success', response.success);
                        $('#subscriber').val('');
                    }else{
                        notify('error', response.error);
                    }
                });

            });
        })(jQuery);
    </script>
@endpush
