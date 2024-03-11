@php
   $horse_statContent = getContent('horse_stat.content',true);
@endphp

<section class="about-section pt-60 pb-60 bg--section">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-5 d-none d-lg-block">
                <div class="about--thumb">
                    <img src="https://via.placeholder.com/300?text=metahorse%20placeholder" width="100%">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content pt-60 pb-60 bg-grey">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p><strong>Horse Info</strong></p>
                        </div>
                        <div class="col-md-3">
                            <p class="text-left"><strong>Action</strong></p>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-info">Breed</button>
                            <button class="btn btn-info">Super Horses</button>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-12">
                            <h4 class="text-white">About</h4>
                        </div>
                    </div>
                    <div class="row mb-5 bg-grey">
                        <div class="col-md-3 col-6 p-2">
                            <span class="text-bold">Total Race:</span>
                        </div>
                        <div class="col-md-3 col-6 p-2">
                            <span>238 races</span>
                        </div>
                        <div class="col-md-3 col-6 p-2">
                            <span class="text-bold">Lifespan:</span>
                        </div>
                        <div class="col-md-3 col-6 p-2">
                            <span>3/30 Years</span>
                        </div>
                        <div class="col-md-3 col-6 p-2">
                            <span class="text-bold">Horse Type:</span>
                        </div>
                        <div class="col-md-3 col-6 p-2">
                            <span>Normal</span>
                        </div>
                        <div class="col-md-3 col-6 p-2">
                            <span class="text-bold">Convert:</span>
                        </div>
                        <div class="col-md-3 col-6 p-2">
                            <span>Yes</span>
                        </div>
                        <div class="col-12 p-none">
                            <hr />
                        </div>
                        <div class="col-md-3">
                            <span class="text-bold">Owner:</span>
                        </div>
                        <div class="col-md-9">
                            <span>Kageyama</span>
                        </div>
                        <div class="col-md-3">
                            <span class="text-bold">Wallet ID</span>
                        </div>
                        <div class="col-md-9">
                            <span>010x1...</span>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-12">
                            <h4 class="text-white">Stats</h4>
                        </div>
                    </div>

                    <div class="row mb-3 bg-grey">
                        <div class="col-md-4 p-3">
                            <p class="stat-title text-center">Speed</p>
                            <h3 class="text-white text-center">134</h3>
                        </div>
                        <div class="col-md-4 p-3">
                            <p class="stat-title text-center">Endurance</p>
                            <h3 class="text-white text-center">140</h3>
                        </div>
                        <div class="col-md-4 p-3">
                            <p class="stat-title text-center">Stamina</p>
                            <h3 class="text-white text-center">137</h3>
                        </div>
                    </div>
                    <div class="row mb-3 bg-grey">
                        <div class="col-md-4 p-3">
                            <p class="stat-title text-center">Power</p>
                            <h3 class="text-white text-center">125</h3>
                        </div>
                        <div class="col-md-4 p-3">
                            <p class="stat-title text-center">Temper</p>
                            <h3 class="text-white text-center">140</h3>
                        </div>
                        <div class="col-md-4 p-3">
                            <button type="button" class="btn btn-info train horse mx-auto d-block">Train Horse</button>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</section>
