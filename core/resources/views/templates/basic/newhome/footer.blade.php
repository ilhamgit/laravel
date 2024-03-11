
<div class="overlay bg-green">
  <section class="bg-stadium">
        <div class="container">

          <div class="row">
            <div class="col-md-6 py-5 px-3 d-flex align-middle align-center" data-entrance="from-left">
              <img src="{{ asset('assets/newhome/storage/img/horse-jockey.png')}}" class="w-100 m-auto">
            </div>

            <div class="col-md-6 py-5 px-3 d-flex align-middle align-center" data-entrance="from-right">
              <form class="newsletter-form m-auto">
                <h2 class="w-100" style="font-weight: 700; font-size: 40px;">@lang('Join MetaHorse Community!')</h2>
                  <div class="form-group">
                      <div class="row">
                        <div class="col-md-10">
                          <input type="email" id="subscriber" class="form-control d-inline-block my-2" placeholder="@lang('Your Email Address')" name="email" required>
                        </div>
                        <div class="col-md-2">
                          <button type="button" class="btn btn-default d-inline-block my-2">@lang('Send')</button>
                        </div>
                      </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
  </section>
</div>

<div class="py-5" id="full">
    <div class="container py-3 ">
        <img src="{{ asset('assets/newhome//storage/img/logo.png') }}" width="130px">
    </div>

    <div class="container py-3">           
        <a href="https://twitter.com/metahorsenft" class="text-white h3 m-2" target="_blank"><i class="lab la-twitter"></i></a>
        <a href="https://t.me/metahorsee" class="text-white h3 m-2" target="_blank"><i class="lab la-telegram"></i></i></a>
        <a href="http://mtbtc.io/" class="text-white h3 m-2" target="_blank"><i class="lab la-bitcoin"></i></a>
    </div>

    <div class="container py-3">           
        <p id="text"><a href="/" class="link text-white me-2">@lang('Terms of Service')</a> | <a href="/" class="link text-white ms-2"> @lang('Privacy Policy')</a></p>
    </div>
</div>

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