@extends('layouts.app')

@push('search_page_class') movie_page @endpush

@push('search')
    <search-component action="{{ route('search.title') }}"></search-component>
@endpush

@push('scripts')
    <script src="{{ asset('nouislider/distribute/nouislider.js')}}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('nouislider/distribute/nouislider.css')}}" />
@endpush

@section('content')
    <div class="search_page">

        <sidebar-component
                action="{{ route('search.params') }}"
                url_default="{{ route('main') }}">
        </sidebar-component>

        <pagination-component
                base_url="{{ env('APP_URL') . '/watch/' }}"
                films_top="{{ json_encode($content)}}">
        </pagination-component>

    </div>
@endsection

