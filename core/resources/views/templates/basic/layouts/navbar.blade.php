<nav class="navbar navbar-expand-lg navbar-dark p-md-0 p-3">
    <img class="img-fluid rounded pb-md-0 pb-3" src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="logo" height="50px">
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between ps-md-3 ps-0" id="navbarCollapse">
        <div class="navbar-nav pb-md-0 pb-3">
            <a href="{{route('user.home')}}" class="text-decoration-none fw-bold text-white d-flex align-items-center">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 122.88 122.566" enable-background="new 0 0 122.88 122.566" xml:space="preserve"><g><path fill="white" fill-rule="evenodd" clip-rule="evenodd" d="M3.78,66.082h47.875c2.045,0,3.717,1.988,3.717,4.414v46.479 c0,2.43-1.671,4.416-3.717,4.416H3.78c-2.043,0-3.717-1.986-3.717-4.416V70.496C0.063,68.07,1.737,66.082,3.78,66.082L3.78,66.082z M71.224,0H119.1c2.046,0,3.717,1.986,3.717,4.415v46.479c0,2.429-1.671,4.413-3.717,4.413H71.224 c-2.045,0-3.714-1.984-3.714-4.413V4.415C67.51,1.986,69.179,0,71.224,0L71.224,0z M3.714,0h47.878 c2.045,0,3.717,1.986,3.717,4.415v46.479c0,2.429-1.671,4.413-3.717,4.413H3.714C1.671,55.307,0,53.323,0,50.894V4.415 C0,1.986,1.671,0,3.714,0L3.714,0z M71.287,67.26h47.876c2.043,0,3.717,1.986,3.717,4.416v46.479c0,2.426-1.674,4.412-3.717,4.412 H71.287c-2.045,0-3.717-1.986-3.717-4.412V71.676C67.57,69.246,69.242,67.26,71.287,67.26L71.287,67.26z"/></g></svg>
                <span class="ms-2">USER DASHBOARD</span>
            </a>
        </div>
        <div class="navbar-nav">
            <div class="d-flex align-items-center">
                <img class="rounded-circle" src="https://via.placeholder.com/20x40" width="30px" height="30px">
                <a href="#" class="nav-item nav-link text-white fw-bold mx-md-1 mx-3">MY ACCOUNT</a>
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve" width="20px" height="20px" class="verified">
                    <g id="check_x5F_alt">
                        <path style="fill:#fff;" d="M16,0C7.164,0,0,7.164,0,16s7.164,16,16,16s16-7.164,16-16S24.836,0,16,0z M13.52,23.383
                            L6.158,16.02l2.828-2.828l4.533,4.535l9.617-9.617l2.828,2.828L13.52,23.383z"/>
                    </g>
                </svg>
            </div>
        </div>
    </div>
</nav>