@extends($activeTemplate.'layouts.userfrontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="bg--section">
        <div class="text-uppercase">
            <div class="text-right mb-3" style="margin-top: -7%;">
                <a href="{{  url('user/dashboard') }}"><button type="button" class="btn btn-golden px-3 py-2">Back</button></a>
            </div>

            <div class="table-responsive">
                      <table class="table table-dark text-center">
                        <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Reward (G)</th>
                              <th scope="col">Match Date</th>
                              <th scope="col">Status</th>
                              <th scope="col">Reward Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($widget['Rewards'] as $no => $r_data)
    
                                <tr>
                                    <th scope="row">{{$no+1}}</th>
                                    <td>{{$r_data['g']}}</td>
                                    <td>@php $mdate=strtotime($r_data['matchDate']); echo date('d M y',$mdate); @endphp</td>
                                    @if($r_data['isTaken'] == 1)

                                        <td class="bg-success">Taken</td>

                                    @else
                                        <td class="bg-danger">Not Taken</td>
                                    @endif

                                    <td>@php $mdate=strtotime($r_data['createdDate']); echo date('d M y (h:i a)',$mdate); @endphp</td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Reward yet.</td>
                                </tr>

                            @endforelse
                          </tbody>
                      </table>
                    </div>
        </div>
    </section>

@endsection

