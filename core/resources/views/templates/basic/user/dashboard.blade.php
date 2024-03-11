@extends($activeTemplate.'layouts.userfrontend')
@section('content')
	@include($activeTemplate.'partials.breadcrumb')

	 @php

      $lang=str_replace(' ', '', session()->get('lang'));

     @endphp


	<section class="dashboard-section bg--section text-uppercase">
			<!-- Dashboard -->
			<div class="pb-50">
				<div class="row justify-content-center g-4">

					<div class="col-md-4">
							<div class="dashboard__item text-right bg-blue">
								<div class="dashboard__content w-100">
									<!--<h4 class="dashboard__title">{{__($general->cur_sym)}} {{showAmount($user->balance)}}</h4>-->
									<h4 class="dashboard__title">{{$widget['Summary']['bets']['unclaimedRewards']}}</h4>
									<span class="text-white">@lang('Pending Rewards')</span>
									<div class="row mt-2">
										<div class="col-md-12">
											<a href="{{  url('user/game-rewards') }}"><button type="button" class="btn text-uppercase btn-light">@lang('View All')</button></a>
											

											<button type="button" class="btn text-uppercase @php if($widget['Summary']['bets']['unclaimedRewards']>0){echo 'btn-light claim';}else{echo 'btn-secondary disabled';} @endphp">@lang('Claim')</button>
										</div>
									</div>

								</div>
							</div>
					</div>

					<div class="col-md-4">
							<div class="dashboard__item text-right bg-blue">
								<div class="dashboard__content w-100">
									<!--<h4 class="dashboard__title">{{__($general->cur_sym)}} {{showAmount($user->balance)}}</h4>-->
									<h4 class="dashboard__title">{{$widget['Summary']['pendingDeposit']}}</h4>
									<span class="text-white">@lang('Pending Deposit')</span>
									<div class="row mt-2">
										<div class="col-md-12">
											<a href="{{  url('user/game-deposit') }}"><button type="button" class="btn text-uppercase btn-light">@lang('View All')</button></a>

											<button type="button" onclick="depositG()" class="btn text-uppercase btn-light">@lang('Deposit')</button>
										</div>
									</div>
								</div>
							</div>
					</div>

					<div class="col-md-4">
							<div class="dashboard__item text-right bg-purple">
								<div class="dashboard__content w-100">
									<!--<h4 class="dashboard__title">{{__($general->cur_sym)}} {{showAmount($user->balance)}}</h4>-->
									<h4 class="dashboard__title">{{$widget['Summary']['pendingWithdrawal']}}</h4>
									<span class="text-white">@lang('Pending Withdrawal')</span>
									<div class="row mt-2">
										<div class="col-md-12">
											<a href="{{  url('user/game-withdrawal') }}"><button type="button" class="btn text-uppercase btn-light">@lang('View All')</button></a>
											<button type="button" onclick="withdrawG()" class="btn text-uppercase btn-light">@lang('Withdraw')</button>
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
	</section>

	<section class="dashboard-section bg--section text-uppercase">
		<div class="pb-50">
			<div class="row justify-content-center g-4">
				<div class="col-md-12">
					<a href="#" class="w-100 match-join"><img src="{{url('assets/images/dashboard/'.$lang.'/01.OsakaBanner.png')}}" class="w-100"></a>
				</div>

				<div class="col-md-4">
					<a href="{{  url('user/place-bet') }}" class="w-100"><img src="{{url('assets/images/dashboard/'.$lang.'/02.PlayNow.png')}}" class="w-100"></a>
				</div>
				<div class="col-md-4">
					<a href="{{  url('user/horses') }}" class="w-100"><img src="{{url('assets/images/dashboard/'.$lang.'/03.ViewHorseBanner.png')}}" class="w-100"></a>
				</div>
				<div class="col-md-4">
					<a href="{{  url('user/horse-train') }}" class="w-100"><img src="{{url('assets/images/dashboard/'.$lang.'/04.TrainHorseBanner.png')}}" class="w-100"></a>
				</div>

				<div class="col-md-4">
					<a href="{{  url('user/mystery-box') }}" class="w-100"><img src="{{url('assets/images/dashboard/'.$lang.'/05.MystertBoxBanner.png')}}" class="w-100"></a>
				</div>
				<div class="col-md-4">
					<a href="{{  url('user/items') }}" class="w-100"><img src="{{url('assets/images/dashboard/'.$lang.'/06.ViewItemBanner.png')}}" class="w-100"></a>
				</div>
				<div class="col-md-4">
					<a href="{{  url('user/canteen') }}" class="w-100"><img src="{{url('assets/images/dashboard/'.$lang.'/07.EquipItemBanner.png')}}" class="w-100"></a>
				</div>
			</div>
		</div>
	</section>

	<!-- <pre class> -->

	@php

	//print_r($widget['Summary']);

	@endphp

	<!-- </pre> -->

	<section class="dashboard-section bg-meta-light-dark text-uppercase">
		<div class="container">
			<div class="pb-50">
				<div class="row pt-4 px-2">
					<div class="col-md-6 analysis">
						<h4 class="title mb-3 mx-3">@lang('Analysis')</h4>
						<div class="row m-3 py-4 px-3 bg-light">
							<div class="col-md-3 text-center">
								<h5 class="a-results">
								<i class="las la-trophy"></i>
								@php

								echo $widget['Summary']['bets']['winningRate']*100;

								@endphp
								</h5>
								<p class="my-2 a-title">@lang('Win %')</p>
							</div>
							<div class="col-md-3 text-center">
								<h5 class="a-results"><i class="lab la-ethereum"></i>{{$widget['Summary']['bets']['rewards']}}</h5>
								<p class="my-2 a-title">@lang('Winnings')</p>
							</div>
							<div class="col-md-3 text-center">
								<h5 class="a-results"><i class="lab la-ethereum"></i>{{$widget['Summary']['bets']['profits']}}</h5>
								<p class="my-2 a-title">@lang('Profits')</p>
							</div>
							<div class="col-md-3 text-center">
								<h5 class="a-results"><i class="lab la-font-awesome-flag"></i>{{$widget['Summary']['bets']['race']}}</h5>
								<p class="my-2 a-title">@lang('# Of Races')</p>
							</div>
						</div>
						<div class="row m-3 p-3 bg-light">
							<div class="col-md-12 text-center">
								<canvas id="finalPos" style="width:100%;max-width:700px"></canvas>
							</div>
						</div>
						
						<div class="row m-3 p-3 bg-light">
							<div class="col-md-12 text-center">
								<canvas id="distance" style="width:100%;max-width:700px"></canvas>
							</div>
						</div>

						<div class="row m-3 p-3 bg-light">
							<div class="col-md-12 text-center">
								<canvas id="profits" style="width:100%;max-width:700px"></canvas>
							</div>
						</div>

						<div class="row m-3 p-3 bg-light">
							<div class="col-md-12 text-center">
								<canvas id="claimReward" style="width:100%;max-width:700px"></canvas>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						
						<h4 class="title mb-3 mx-1">@lang('Top Horses')</h4>

						@forelse ($widget['Summary']['horses'] as $horse)
							<div class="row m-1 px-3 bg-light horses-details">
								<div class="col-md-12 p-2">
									
									<div class="row py-2 bg-grey">
										<div class="col-md-3 p-none">
											<img src="https://d1k0k5uveaqxkp.cloudfront.net/fit-in/300x300/{{$horse['fileName']}}" width="100%">
										</div>
										<div class="col-md-9 d-flex">
											<h4 class="my-auto">{{$horse['horseName']}}</h4>
										</div>
									</div>

									<div class="row py-2 bg-grey">
										<div class="col-md-3 py-3 text-left">
											<p class="text-white text-bold">@lang('Total Race'):</p>
										</div>
										<div class="col-md-3 py-3 text-left">
											<p class="text-white">{{$horse['raceCount']}} @lang('Races')</p>
										</div>
										<div class="col-md-3 py-3 text-left">
											<p class="text-white text-bold">@lang('Lifespan'):</p>
										</div>
										<div class="col-md-3 py-3 text-left">
											<p class="text-white">{{$horse['age']}} @lang('Years')</p>
										</div>
										<div class="col-md-3 py-3 text-left">
											<p class="text-white text-bold">@lang('Horse Type'):</p>
										</div>
										<div class="col-md-3 py-3 text-left">
											@if ($horse['isSuperHorse']!='')
												<p class="text-white">@lang('Super')</p>
											@else
												<p class="text-white">@lang('Normal')</p>
											@endif
										</div>
									</div>

									<div class="row mt-4 bg-light">
										<div class="col-md-6 text-center">
											<h5 class="a-results">
											<i class="las la-trophy"></i>
											@php

											echo $horse['winningRate']*100;

											@endphp

											</h5>
											<p class="my-2 a-title d-inline px-3">@lang('Win %')</p>
										</div>
										<div class="col-md-6 text-center">
											<h5 class="a-results"><i class="lab la-font-awesome-flag"></i>{{$horse['bestRanking']}}</h5>
											<p class="my-2 a-title d-inline px-3">@lang('# Of Races')</p>
										</div>
									</div>

								</div>
							</div>
						@empty
							<p class="text-white py-3">N/A</p>
						@endforelse

					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
	<script>
		(function($){
			"use strict";

			$('.copytext').on('click',function(){
				var copyText = document.getElementById("referralURL");
				copyText.select();
				copyText.setSelectionRange(0, 99999);
				document.execCommand("copy");
				iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
			});

			@php

			echo 'var FPxValues = [';

			foreach($widget['Summary']['rankings'] as $ranking){
				echo '"'.$ranking['ranking'].'",';
			}

			echo '];
			var FPyValues = [';
			foreach($widget['Summary']['rankings'] as $ranking){
				echo '"'.round($ranking['quantity']).'",';
			}
			echo '];';

			@endphp

			new Chart("finalPos", {
			  type: "bar",
			  data: {
				labels: FPxValues,
				datasets: [{
				  backgroundColor: '#75A89F',
				  data: FPyValues
				}]
			  },
			  options: {
				responsive: true,
				legend: {display: false},
				title: {
				  display: true,
				  text: "@lang('Final Positions')"
				},
				animation: {
					animateScale: true
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							callback: function (value) { if (Number.isInteger(value)) { return value; } },
							stepSize: 1
						}
					}]
				}
			  }
			});


			@php

			echo 'var DxValues = [';

			foreach($widget['Summary']['distances'] as $distance){
				echo '"'.$distance['distance'].'",';
			}

			echo '];
			var DyValues = [';
			foreach($widget['Summary']['distances'] as $distance){

				$percent=$distance['winningRate']*100;

				if($percent<0){
					$percent=0;
				}

				echo '"'.$percent.'",';
			}
			echo '];';

			@endphp

			new Chart("distance", {
			  type: "bar",
			  data: {
				labels: DxValues,
				datasets: [{
				  backgroundColor: '#75A89F',
				  data: DyValues
				}]
			  },
			  options: {
				legend: {display: false},
				title: {
				  display: true,
				  text: "@lang('Winning % By Distance')"
				}
			  }
			});



			@php

			echo 'var FPxValues = [';

			foreach($widget['Summary']['profits'] as $profits){

				$date=strtotime($profits['matchDate']);

				echo strtoupper('"'.date('d M',$date).'",');
			}

			echo '];
			var FPyValues = [';
			foreach($widget['Summary']['profits'] as $profits){
				echo '"'.round($profits['totalProfits']).'",';
			}
			echo '];';

			@endphp

			new Chart("profits", {
			  type: "bar",
			  data: {
				labels: FPxValues,
				datasets: [{
				  backgroundColor: '#75A89F',
				  data: FPyValues
				}]
			  },
			  beginAtZero: true,
			  options: {
				responsive: true,
				legend: {display: false},
				title: {
				  display: true,
				  text: "@lang('Total Profits In Past 7 Days')"
				},
				animation: {
					animateScale: true
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							callback: function (value) { if (Number.isInteger(value)) { return value; } },
							stepSize: 1
						}
					}]
				}
			  }
			});


			@php

			echo 'var FPxValues = [';

			foreach($widget['Summary']['claimedRewards'] as $claim){

				$date=strtotime($claim['matchDate']);

				echo strtoupper('"'.date('d M',$date).'",');
			}

			echo '];
			var FPyValues = [';
			foreach($widget['Summary']['claimedRewards'] as $claim){
				echo '"'.round($claim['totalRewards']).'",';
			}
			echo '];';

			@endphp

			new Chart("claimReward", {
			  type: "bar",
			  data: {
				labels: FPxValues,
				datasets: [{
				  backgroundColor: '#75A89F',
				  data: FPyValues
				}]
			  },
			  beginAtZero: true,
			  options: {
				responsive: true,
				legend: {display: false},
				title: {
				  display: true,
				  text: "@lang('Total Claimed Rewards In Past 7 Days')"
				},
				animation: {
					animateScale: true
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							callback: function (value) { if (Number.isInteger(value)) { return value; } },
							stepSize: 1
						}
					}]
				}
			  }
			});

			$("button.claim").on("click", function(event){

			   var user='{{$user->username}}';

				var plink = "{{url('user/claim-reward')}}";

				$('<form action="'+plink+'" method="post">@csrf<input type="hidden" name="user" value="'+user+'"></form>').appendTo('body').submit();

			});

			$('.match-join').on('click',function(e){

				e.preventDefault();

				var plink = "{{url('user/verify-match')}}";

				$('<form action="'+plink+'" method="post">@csrf<input type="hidden" name="join" value="1"></form>').appendTo('body').submit();

			  });

		})(jQuery);

		function depositG(){
			iziToast.question({
				timeout: 20000,
				overlay: true,
				displayMode: 'once',
				id: 'inputs',
				zindex: 999,
				title: 'AMOUNT (MTBTC)',
				message: '',
				position: 'center',
				drag: false,
				inputs: [
					['<input type="number">', 'keydown', () => {}],
				],
				buttons: [
					['<button><b>DEPOSIT</b></button>', function (instance, toast, button, e, inputs) {
						processDeposit(inputs[0].value);
						instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
					}, false],
				]
			});
		}

		function processDeposit(amount) {
			$.ajax({
				url: "{{ route('user.bridge.swap-g') }}",
				method: "POST",
				data:{
					"_token": "{{ csrf_token() }}",
					'amount': amount,
					'dataType':'JSON'
				},
				dataType: 'JSON',
				success: function (response) {
					if(response.success){
						window.location = response.link;
					}else{

					}
				},
			});
		}

		function withdrawG(){
			iziToast.question({
				timeout: 20000,
				overlay: true,
				displayMode: 'once',
				id: 'inputs',
				zindex: 999,
				title: 'AMOUNT (G)',
				message: '',
				position: 'center',
				drag: false,
				inputs: [
					['<input type="number" min="1" max="{{session()->get('g')}}" class="withdraw-input">', 'keydown', () => {}],
				],
				buttons: [
					['<button type="submit"><b>WITHDRAW</b></button>', function (instance, toast, button, e, inputs) {
						processWithdraw(inputs[0].value);
						instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
					}, false],
				]
			});
		}

		function processWithdraw(amount) {
			$.ajax({
				url: "{{ route('user.bridge.swap-mbtc') }}",
				method: "POST",
				data:{
					"_token": "{{ csrf_token() }}",
					'amount': amount,
					'dataType':'JSON'
				},
				dataType: 'JSON',
				success: function (response) {
					console.log(response.res_param);
					if(response.success===true){
						window.location = response.link;
					}else{
						iziToast.error({message: response.message, position: "topRight"});
					}
				},
			});
		}
	</script>

@endsection


