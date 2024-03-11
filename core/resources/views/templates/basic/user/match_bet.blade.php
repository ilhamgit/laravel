@extends($activeTemplate.'layouts.userfrontend')
@section('content')
	@php
		$offset=9*60*60;
		$loc = (new DateTime)->getTimezone();

		$elt = new DateTime($gdata['current_match']->betEndDate, new DateTimeZone('UTC'));
        $elt->setTimezone($loc);

        $endlive = strtotime($elt->format('Y-m-d H:i:s T'));
        $endlive = $endlive - $offset;
	@endphp

	<section class="bg--section">
		<div class="position-relative" style="background-image: url('{{url('assets/images/bets/metahorse game bg.png')}}'); background-repeat: no-repeat; background-size: auto 100%; background-position: center;">
			<div class="row pt-3 px-3">
				<div class="col-12 col-sm-2 position-relative">
					<div class="text-white mb-2 text-center">
						TIME LEFT: 
						<span class="countdown" data-end="{{ date('d M Y h:i a', $endlive) }}">
							<div id="minutes" class="d-inline-block"></div> <div id="seconds" class="d-inline-block"></div>
						</span>
					</div>

					<img src="{{url('assets/images/bets/left-chart.png')}}" class="w-100 position-absolute bottom-0"></a>

					@foreach($gdata['current_match']->pastOdds as $key => $pastOdds)
					<div class="position-absolute result-box result-row-{{ $key+1 }}">
						<div class="position-relative text-white w-100 h-100">
							<div class="position-absolute result-horse-1">{{ $pastOdds->odd_Double_Horse_1 }}</div>
							<div class="position-absolute result-horse-1-bar"><img src="{{ url('assets/images/bets/no'.$pastOdds->odd_Double_Horse_1.'.png') }}" class="w-100" /></div>
							<div class="position-absolute result-horse-2">{{ $pastOdds->odd_Double_Horse_2 }}</div>
							<div class="position-absolute result-horse-2-bar"><img src="{{ url('assets/images/bets/no'.$pastOdds->odd_Double_Horse_2.'.png') }}" class="w-100" /></div>
							<div class="position-absolute result-single">{{ $pastOdds->odd_Single }}</div>
							<div class="position-absolute result-double">{{ $pastOdds->odd_Double }}</div>
						</div>
					</div>
					@if($loop->index == 5) @break @endif
					@endforeach
				</div>
				<div class="col-12 col-sm-10 position-relative">
					<img src="{{url('assets/images/bets/metachart.png')}}" class="w-100"></a>
					{{-- Horses --}}
					@foreach($gdata['current_match']->horses as $key => $horse)
					<div class="position-absolute overflow-hidden place-bet horse-bet-box row-1 horse-column-{{ $key+1 }}" data-bet="bet_{{ $key+1 }}">
						<div class="position-absolute overflow-hidden horse horse-{{ $key+1 }}">
							<img src="https://d1k0k5uveaqxkp.cloudfront.net/fit-in/100x100/{{ $horse->fileName }}" class="position-absolute horse-image"></a>
							<div class="text-white position-absolute bottom-0 horse-font">{{ $key+1 }}</div>
						</div>
						<div class="position-absolute bet-odds">x{{ $gdata['current_match']->singleOdds->{'odd_'.($key+1)} }}</div>
						<div class="position-absolute horse_bet horse-bet-amount bet_{{ $key+1 }}" data-bet="{{ $key+1 }}" data-type="single">0</div>
						<a href="javascript:" class="position-absolute remove-bet remove-horse-bet">x</a>
					</div>
					@endforeach

					{{-- Betting Box --}}
					@for($i = 1; $i < 8; $i++)
						@for($j = $i; $j < 8; $j++)
						<div class="position-absolute overflow-hidden place-bet bet-box row-{{$i+1}} column-{{$j+1}}" data-bet="bet_{{ $i }}_{{ ($j+1) }}">
							<div class="position-absolute bet-odds">x{{ $gdata['current_match']->doubleOdds->{'odd_'.($i).'_'.($j+1)} }}</div>
							<div class="position-absolute horse_bet bet-amount bet_{{ $i }}_{{ ($j+1) }}" data-bet="{{ $i }}_{{ ($j+1) }}" data-type="double">0</div>
							<a href="javascript:" class="position-absolute remove-bet remove-horse-bet">x</a>
						</div>
						@endfor
					@endfor

					<div class="col-4 col-sm-4 position-absolute bottom-0" style="left: 3%;">
						<img src="{{url('assets/images/bets/chart.png')}}" class="w-100"></a>

						{{-- Big/Small --}}
						<div class="position-absolute bs-row-1">
							<div class="text-white position-absolute bs_odd">{{ $gdata['current_match']->evenOddBigSmallOdds->odd_Odd_1 }}</div>
						</div>

						<div class="position-absolute bs-row-2">
							<div class="text-white position-absolute bs_even">{{ $gdata['current_match']->evenOddBigSmallOdds->odd_Even_1 }}</div>
						</div>

						<div class="position-absolute bs-row-3">
							<div class="text-white position-absolute bs_big">{{ $gdata['current_match']->evenOddBigSmallOdds->odd_Big_1 }}</div>
						</div>

						<div class="position-absolute bs-row-4">
							<div class="text-white position-absolute bs_small">{{ $gdata['current_match']->evenOddBigSmallOdds->odd_Small_1 }}</div>
						</div>

						{{-- Big/Small Bet Box --}}
						@for($i = 1; $i < 4; $i++)
						<div class="position-absolute bs-row-1 bs-column-{{ $i+1 }} bs-bet-box" data-bet="odd_{{ $i }}" data-odd="{{ $gdata['current_match']->evenOddBigSmallOdds->{'odd_Odd_'.$i} }}">
							<div class="text-center odd_bet odd_{{ $i }}" data-bet="odd_{{ $i }}">0</div>
							<a href="javascript:" class="position-absolute remove-bet remove-odd-bet">x</a>
						</div>

						<div class="position-absolute bs-row-2 bs-column-{{ $i+1 }} bs-bet-box" data-bet="even_{{ $i }}" data-odd="{{ $gdata['current_match']->evenOddBigSmallOdds->{'odd_Even_'.$i} }}">
							<div class="text-center odd_bet even_{{ $i }}" data-bet="even_{{ $i }}">0</div>
							<a href="javascript:" class="position-absolute remove-bet remove-odd-bet">x</a>
						</div>

						<div class="position-absolute bs-row-3 bs-column-{{ $i+1 }} bs-bet-box" data-bet="big_{{ $i }}" data-odd="{{ $gdata['current_match']->evenOddBigSmallOdds->{'odd_Big_'.$i} }}">
							<div class="text-center odd_bet big_{{ $i }}" data-bet="big_{{ $i }}">0</div>
							<a href="javascript:" class="position-absolute remove-bet remove-odd-bet">x</a>
						</div>

						<div class="position-absolute bs-row-4 bs-column-{{ $i+1 }} bs-bet-box" data-bet="small_{{ $i }}" data-odd="{{ $gdata['current_match']->evenOddBigSmallOdds->{'odd_Small_'.$i} }}">
							<div class="text-center odd_bet small_{{ $i }}" data-bet="small_{{ $i }}">0</div>
							<a href="javascript:" class="position-absolute remove-bet remove-odd-bet">x</a>
						</div>
						@endfor
					</div>
				</div>
			</div>
			<div class="row pb-1">
				<div class="col-12 col-sm-10 position-relative">
					<img src="{{url('assets/images/bets/bar.png')}}" class="w-100"></a>

					{{-- G --}}
					<div class="position-absolute g-balance text-white">
						{{ session()->get('g'); }}
					</div>
					
					{{-- Token --}}
					<div class="position-absolute token token-5" data-token="5">
					</div>

					<div class="position-absolute token token-10" data-token="10">
					</div>

					<div class="position-absolute token token-50" data-token="50">
					</div>

					<div class="position-absolute token token-100" data-token="100">
					</div>

					<div class="position-absolute token token-500" data-token="500">
					</div>

					<div class="position-absolute btn-place-bet">
					</div>
				</div>
			</div>

			<div class="position-absolute w-100 h-100 top-0 close-bet d-none">
				<div class="text-white text-center">BET HAS BEEN ENDED.<br/>PLEASE WAIT FOR RESULT PROCESSING.</div>
			</div>
		</div>
	</section>

	<div class="modal modal-result">
		<div class="modal-content text-center">
			<span class="close mb-2">&times;</span>

			<div class="list-data"></div>
			</div>
		</div>
	</div>

	<script>
		var currentBet = '';
		var stopBetting = false;

		// Get the modal
		$(document).ready(function(){
			$('.place-bet, .bs-bet-box').click(function(){
				$('.place-bet, .bs-bet-box').removeClass('active');
				$(this).addClass('active');

				currentBet = $(this).data('bet');
			})

			$('.token').click(function(){
				if(currentBet != ''){
					let tokenValue = $(this).data('token');
					let balance = parseInt($('.g-balance').html());

					if(balance - tokenValue >= 0){
						// Deduct balance
						balance = balance - tokenValue;
						$('.g-balance').html(balance);

						// Place bet
						let currentBetValue = parseInt($('.'+currentBet).html() ?? 0);
						$('.'+currentBet).html(currentBetValue + tokenValue);
					} else {
						// Show error message
						iziToast.show({
							title: 'INSUFFICIENT FUND',
							message: "You don't have enough G to make this bet",
							color: 'red',
						});
					}
				} else {
					// Show error message
					iziToast.show({
						title: 'NO ODDS',
						message: "Please select the odds you want to bet.",
						color: 'red',
					});
				}
			})

			// Remove bets
			$('.remove-horse-bet').click(function(){
				let betvalue = parseInt($(this).parent().find('.horse_bet').first().html());
				let balance = parseInt($('.g-balance').html());

				$('.g-balance').html(balance + betvalue);
				$(this).parent().find('.horse_bet').first().html(0);
			})

			$('.remove-odd-bet').click(function(){
				let betvalue = parseInt($(this).parent().find('.odd_bet').first().html());
				let balance = parseInt($('.g-balance').html());

				$('.g-balance').html(balance + betvalue);
				$(this).parent().find('.odd_bet').first().html(0);
			})

			// Place bet
			$('.btn-place-bet').click(function(){
				let bets = [];

				// For horse
				$('.horse_bet').each(function(){
					let betValue =  parseInt($(this).html() ?? 0);
					if(betValue > 0){
						let actionType = $(this).data('type');

						let newBets = {};

						// Setting horse ID
						if(actionType == 'single'){
							newBets.horseId_1 = $(this).data('bet');
							newBets.horseId_2 = null;
						} else {
							const horses = $(this).data('bet').split("_");
							newBets.horseId_1 = parseInt(horses[0]);
							newBets.horseId_2 = parseInt(horses[1]);
						}
						
						newBets.actionType = actionType;
						newBets.value = parseInt($(this).html());

						// Push to bet
						bets.push(newBets);
					}
				})

				// For big/small
				$('.odd_bet').each(function(){
					let betValue =  parseInt($(this).html() ?? 0);
					if(betValue > 0){
						let newBets = {};
						newBets.horseId_1 = null;
						newBets.horseId_2 = null;
						newBets.actionType = $(this).data('bet');
						newBets.value = parseInt($(this).html());

						// Push to bet
						bets.push(newBets);
					}
				})

				if(bets.length > 0){
					iziToast.show({
						title: 'PLEASE WAIT',
						message: "We are placing your bets now.",
					});

					$.ajax({
						url: "{{ route('user.match-place-bet', $id) }}",
						method: "POST",
						data:{
							"_token": "{{ csrf_token() }}",
							'bets': bets,
							'dataType':'JSON'
						},
						dataType: 'JSON',
						success: function (response) {
							if(response.success){
								iziToast.show({
									title: 'PLACE BET',
									message: "Your bets has been successfully placed.",
									color: 'green',
								});

								// Clear off bets
								$('.horse_bet').each(function(){
									$(this).html('0');
								});

								$('.odd_bet').each(function(){
									$(this).html('0');
								});

								// Update G
								$('.g-balance').html(response.g);
							} else {
								iziToast.show({
									title: 'PLACE BET',
									message: "Something went wrong, please try again.",
									color: 'red',
								});
							}
						},
					});
				} else {
					// Show error message
					iziToast.show({
						title: 'NO BET',
						message: "Please place at least one bet.",
						color: 'red',
					});
				}
			})

			// Close result
			$('.close').on('click',function(){
          		$(this).closest('.modal').hide();
          		window.location = '{{ route("user.match-results") }}';
        	});

			setInterval(function() { 
				if(!stopBetting){
					makeTimer(); 
				}
			}, 1000);	
		});

		function makeTimer(e) {
			$('.countdown').each(function(){
				let eldate = $(this).attr('data-end');

				let endTime = new Date(eldate);      
				endTime = (Date.parse(endTime) / 1000);

				let now = new Date();
				now = (Date.parse(now) / 1000);

				let timeLeft = endTime - now;

				let days = Math.floor(timeLeft / 86400); 
          		let hours = Math.floor((timeLeft - (days * 86400)) / 3600);
				let minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
				let seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

				if(timeLeft <= 0) {
					stopBetting = true;
					$('.close-bet').removeClass('d-none');

					// Show result after 30s
					setTimeout(showResult, 30000);
				} else {
					if (minutes < "10") { minutes = "0" + minutes; }
					if (seconds < "10") { seconds = "0" + seconds; }

					$(this).find("#minutes").html(minutes + "<span>M</span>");
					$(this).find("#seconds").html(seconds + "<span>S</span>");
				}
			}); 
		}

		function showResult() {
			$(".modal-result .list-data").html("<h5>Result is Processing</h5>");

			$.ajax({
				url: "{{url('/user/list-result/')}}?mid={{ $id }}", 
				success: function(result){
					$(".modal-result .list-data").html(result);
				}
			});

			$('.modal-result').show();
		}
	</script>
@endsection

