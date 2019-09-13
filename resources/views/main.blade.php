@extends('layouts.app')

@push('search_page_class') movie_page @endpush

@push('search')
    <search-component action="{{ route('search.title') }}"></search-component>
@endpush

<<<<<<< HEAD
@section('content')
    <div class="container search_page">
        <div class="search_menu">
            Research:
            <form method="GET" action="{{ route('research') }}">
                <select name="genre" class="browser-default custom-select m-2">
                    <option value="28" selected>Action</option>
                    <option value="12">Adventure</option>
                    <option value="16">Animation</option>
                    <option value="35">Comedy</option>
                    <option value="80">Crime</option>
                    <option value="99">Documentary</option>
                    <option value="18">Drama</option>
                    <option value="10751">Family</option>
                    <option value="14">Fantasy</option>
                    <option value="36">History</option>
                    <option value="27">Horror</option>
                    <option value="10402">Music</option>
                    <option value="9648">Mystery</option>
                    <option value="10749">Romance</option>
                    <option value="878">Science Fiction</option>
                    <option value="10770">TV Movie</option>
                    <option value="53">Thriller</option>
                    <option value="10752">War</option>
                    <option value="37">Western</option>
                </select>

                Production year:
                <input class="form-control mr-sm-2 w-50 m-1" type="text" placeholder="from" name="year_from" value="1920">
                <input class="form-control mr-sm-2 w-50 m-1" type="text" placeholder="to" name="year_to" value="2019">

                Minimum Rating:
                <select name="min_rating" class="browser-default custom-select m-2">
                    <option value="0" selected>0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                </select>

@push('scripts')
    <script src="{{ asset('nouislider/distribute/nouislider.js')}}"></script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('nouislider/distribute/nouislider.css')}}" />
@endpush

@section('content')
    <div class="search_page">
        <sidebar-component action="{{ route('research') }}"
                           url_default="{{ route('main') }}">
        </sidebar-component>
        <div class="movies_list" id="movies_list">
            <div class="row" id="movies_catalog">
                @if(isset($content) && $content)
                    @foreach($content as $item)
{{--                        <div class="movie_main_div">--}}
                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-12 col-xs-12 movie_main_div">
                            <a href="{{ route('watch', [
                                                'imdDB' => $item->imdb_code,
                                                'movie' => $item->slug
                                            ]) }}">
                                <div class="movie">

                                    <span class="badge badge-info float-right movie_year">{{ $item->year }}</span>
                                    <img class="movie_poster" src="{{ $item->large_cover_image }}">
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
