<div class="row mb-3">
    <div class="col-md-12 mb-md-0 mb-2">
        <div class="bg-meta-light-dark p-3 fw-bold text-white">
            <div class="d-flex align-items-start align-middle">
                <img class="rounded-circle me-3" src="{{ getImage(imagePath()['logoIcon']['path'] .'/g_icon.png') }}" width="30px" height="30px">
                @php

                $g_balance = session()->get('g');

                $p_balance = session()->get('p');

                $w_balance = session()->get('walbal');

                @endphp


                <iframe src="http://localhost/metahorse/user/userbalance" id="iFrame1" height="30px"></iframe>
            </div>
        </div>
    </div>
<!--     <div class="col-md-6 mb-md-0 mb-2">
        <div class="bg-meta-light-dark p-3 fw-bold text-white">
            <div class="d-flex align-items-start align-middle">
                <img class="rounded-circle me-3" src="{{ getImage(imagePath()['logoIcon']['path'] .'/m_icon.png') }}" width="30px" height="30px">
                <h5 class="pt-2" data-w>{{$w_balance}} MBTC</h5>
            </div>
        </div>
    </div> -->
</div>
