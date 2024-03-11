@php
   $horsesContent = getContent('horses.content',true);
@endphp

<section class="about-section pt-60 pb-60 bg--section">
    <div class="container">
        <div class="row justify-content-between align-items-center my-4">
            <div class="col-12">
                <p>
                    {{__(@$horsesContent->data_values->details)}}
                </p>
            </div>
        </div>
        <div class="row justify-content-between align-items-center">
            <div class="col-12">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4 horses">
                        <a href="{{  url('horse-stat?horse=3008') }}">
                            <div class="card">
                                <div class="card-header">
                                    <p class="h-num">#3008</p>
                                </div>
                                <div class="card-body p-none">
                                    <img src="https://via.placeholder.com/300?text=metahorse%20placeholder" width="100%">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 horses">
                        <a href="{{  url('horse-stat?horse=3009') }}">
                            <div class="card">
                                <div class="card-header">
                                    <p class="h-num">#3009</p>
                                </div>
                                <div class="card-body p-none">
                                    <img src="https://via.placeholder.com/300?text=metahorse%20placeholder" width="100%">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 horses">
                        <a href="{{  url('horse-stat?horse=3010') }}">
                            <div class="card">
                                <div class="card-header">
                                    <p class="h-num">#3010</p>
                                </div>
                                <div class="card-body p-none">
                                    <img src="https://via.placeholder.com/300?text=metahorse%20placeholder" width="100%">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-2 t1">
  <div class="row">
    <div class="col-sm-12 col-md-4">
      <div class="card">
        <img class="card-img-top" src="assets\rajetta.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-4">
      <div class="card">
        <img class="card-img-top" src="assets\rajetta.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-4">
      <div class="card">
        <img class="card-img-top" src="assets\rajetta.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 col-md-4">
      <div class="card">
        <img class="card-img-top" src="assets\rajetta.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-4">
      <div class="card">
        <img class="card-img-top" src="assets\rajetta.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-4">
      <div class="card">
        <img class="card-img-top" src="assets\rajetta.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 col-md-4">
      <div class="card">
        <img class="card-img-top" src="assets\rajetta.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-4">
      <div class="card">
        <img class="card-img-top" src="assets\rajetta.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-4">
      <div class="card">
        <img class="card-img-top" src="assets\rajetta.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 col-md-4">
      <div class="card">
        <img class="card-img-top" src="assets\rajetta.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-4">
      <div class="card">
        <img class="card-img-top" src="assets\rajetta.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-4">
      <div class="card">
        <img class="card-img-top" src="assets\rajetta.jpg" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
      </div>
    </div>
  </div>
</div>
    
</section>
