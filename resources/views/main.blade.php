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

        <sidebar-component action="{{ route('search.params') }}"
                           url_default="{{ route('main') }}">
        </sidebar-component>
        <div class="movies_list" id="movies_list">
            <div class="row" id="movies_catalog">
                @if(isset($content) && $content)
                    @foreach($content as $item)
                        {{--                        <div class="movie_main_div">--}}
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-12 col-xs-12 movie_main_div">
                            <a href="{{ route('watch', $item->imdb_id) }}">
                                <div class="movie">

                                    <span class="badge badge-info float-right movie_year">{{ $item->prod_year }}</span>
                                    <img class="movie_poster" src="{{ $item->poster }}">
                                    <div class="poster_slide">
                                        <div class="poster_slide_cont">
                                            <div class="poster_slide_bg"></div>
                                            <div class="poster_slide_details">
                                                <h5 class="movie_title">
                                                    {{ $item->title }}
                                                </h5>

                                                <div class="details">
                                                    @foreach($item->genres as $genre)
                                                        <span class="badge badge-secondary">{{ __('genres.' . $genre) }}</span>
                                                    @endforeach

                                                    <star-component rating="{{ $item->rating }}" rating_nbr="true"></star-component>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection

