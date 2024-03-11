<div class="text-center text-uppercase p-3 sidebar">
    <div class="border border-2 border-secondary text-white fw-bold p-5">
        <p>
            <span>{{$user->username}}</span>
            <a href="{{  url('user/profile-setting') }}" class="text-white text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
            </a>
        </p>
    </div>
    <hr>
    <ul class="nav flex-column mb-auto fw-bold">
      <li class="nav-item mb-3">
        <a href="{{  url('user/dashboard') }}" class="nav-link {{ url()->current() == url('user/dashboard') ? 'active' : ''}}">@lang("Summary")</a>
      </li>
      <li class="nav-item mb-3">
        <a href="{{  url('user/horses') }}" class="nav-link {{ url()->current() == url('user/horses') ? 'active' : ''}}">@lang("My Horses")</a>
      </li>
      <li class="nav-item mb-3">
        <a href="{{  url('user/items') }}" class="nav-link {{ Request::path() === 'user/items' ? 'active' : ''}}">@lang("My Items")</a>
      </li>
      <li class="nav-item mb-3 has-submenu">
        <a href="#" class="nav-link @php if(Request::path()=='user/match-results'||Request::path()=='user/join-match'||Request::path()=='user/place-bet'){ echo 'active';}  @endphp">@lang("Gameplay")</a>
        <ul class="submenu p-0">
          <li><a class="nav-link {{ Request::path() == 'user/match-results' ? 'active' : ''}}" href="{{url('user/match-results')}}"></i>@lang("Results")</a></li>
          <li><a class="nav-link {{ Request::path() == 'user/join-match' ? 'active' : ''}}" href="{{url('user/join-match')}}"></i>@lang("My Matches")</a></li>
          <li><a class="nav-link {{ Request::path() == 'user/place-bet' ? 'active' : ''}}" href="{{url('user/place-bet')}}"></i>@lang("Place Bet")</a></li>
        </ul>
      </li>
      <li class="nav-item mb-3">
        <a href="{{  url('user/mystery-box') }}" class="nav-link {{ Request::path() === 'user/mystery-box' ? 'active' : ''}}">@lang("Mystery Box")</a>
      </li>
      <li class="nav-item mb-3">
        <a href="{{  url('user/super-breed') }}" class="nav-link {{ Request::path() === 'user/super-breed' ? 'active' : ''}}">@lang("Super Breed")</a>
      </li>
      <li class="nav-item mb-3">
        <a href="{{  url('user/profile-setting') }}" class="nav-link {{ Request::path() === 'user/profile-setting' ? 'active' : ''}}">@lang("My Account")</a>
      </li>
    </ul>
    <hr>
  </div>

  <script>
    jQuery(document).ready(function($){
      $('.sidebar .has-submenu').on('click',function(){

        var checkcol = $(this).find('.submenu').hasClass('collapse');

        if(checkcol===true){
          // $(this).find('.submenu').removeClass('collapse');
        }else{
          // $(this).find('.submenu').addClass('collapse');
        }

        //console.log(checkcol);

      });
    });
  </script>
