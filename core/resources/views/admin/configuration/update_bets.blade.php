@extends('admin.layouts.app')

@section('panel')

@php

//echo '<pre>';

//print_r($bets_list);

//echo '</pre>';

function dis_date($date){

    $time=strtotime($date);

    return date('Y m d',$time);
    
}


function is_time($time){

    $time=strtotime($time);

    return date('h:i a',$time);
    
}

//echo \Route::current()->getName();

$nums=0;

@endphp
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <form action="{{url('admin/configuration/referral/update')}}" method="post">
                            @csrf
                            <input type="hidden" name="update_type" value="{{$update}}">
                            <table class="table table--light">
                                <thead>
                                <tr>
                                    <th class="text-center w-25">@lang('Day of Week')</th>
                                    <th class="text-center w-25">@lang('Hours')</th>
                                    <th class="text-center w-25">@lang('Multiplier')</th>
                                    <th class="text-center w-25">@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($bets_list as $num => $r_data)
                                        @php

                                        $nums=$num;

                                        @endphp
                                        <tr class="data-r">
                                            <td class="text-center"><input type="number" name="update[{{$num}}][dayOfWeek]" class="form-control text-center" value="{{$r_data['dayOfWeek']}}"></td>
                                            <td class="text-center"><input type="text" name="update[{{$num}}][hour]" class="form-control text-center" value="{{$r_data['hour']}}"></td>
                                            <td class="text-center"><input type="number" min="1" name="update[{{$num}}][multiplier]" class="form-control text-center" value="{{$r_data['multiplier']}}"></td>
                                            <td class="text-center"><button type="button" class="btn btn-danger delete-row">Delete</button></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table><!-- table end -->
                            <button type="submit" class="btn btn--primary my-2 w-100">Save</button>
                        </form>
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>
    <script>

            var num="{{$nums}}";

            $('body').on('click','.delete-row',function(){
                $(this).closest('tr').remove();
            });

            $('.add-row').on('click',function(){
                num++;
                $('.table tbody').append('<tr class="data-r"><td class="text-center"><input type="number" name="update['+num+'][dayOfWeek]" class="form-control text-center"></td><td class="text-center"><input type="text" name="update['+num+'][hour]" class="form-control text-center"></td><td class="text-center"><input type="number" min="1" name="update['+num+'][multiplier]" class="form-control text-center"></td><td class="text-center"><button type="button" class="btn btn-danger delete-row">Delete</button></td></tr>');
            });

            $('.save-row').on('click',function(){
                $('form').submit();
            });
    </script>

@endsection

@push('breadcrumb-plugins')
<div class="d-flex flex-wrap justify-content-end flex-gap-8">
        <button type="button" class="btn btn--primary add-row">@lang('Add')</button>
        <a href="{{route('admin.configuration.referral')}}"><button type="button" class="btn btn--primary">@lang('Back')</button></a>
    </div>
@endpush


