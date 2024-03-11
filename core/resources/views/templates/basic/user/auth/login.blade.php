@extends($activeTemplate.'layouts.auth')

@section('content')
    @php
	    $authBackground = getContent('auth_page.content',true)->data_values;
    @endphp
    
@endsection

@push('script')

@endpush
