@extends('layouts.app')

@push('search_page_class') movie_page @endpush

@push('search')
    <search-component action="{{ route('search.title') }}"></search-component>

@endpush

@section('content')
    <div class="container search_page">
        <div class="search_menu">
            Research:
            <form method="GET" action="{{ route('research') }}">
                <select name="genre" class="browser-default custom-select m-2">
                    <option value="Action" selected>{{ __('genres.Action') }}</option>
                    <option value="Adventure">{{ __('genres.Adventure') }}</option>
                    <option value="Animation">{{ __('genres.Animation') }}</option>
                    <option value="Biography">{{ __('genres.Biography') }}</option>
                    <option value="Comedy">{{ __('genres.Comedy') }}</option>
                    <option value="Crime">{{ __('genres.Crime') }}</option>
                    <option value="Documentary">{{ __('genres.Documentary') }}</option>
                    <option value="Drama">{{ __('genres.Drama') }}</option>
                    <option value="Family">{{ __('genres.Family') }}</option>
                    <option value="Fantasy">{{ __('genres.Fantasy') }}</option>
                    <option value="History">{{ __('genres.History') }}</option>
                    <option value="Horror">{{ __('genres.Horror') }}</option>
                    <option value="Musical">{{ __('genres.Musical') }}</option>
                    <option value="Romance">{{ __('genres.Romance') }}</option>
                    <option value="Sci-Fi">{{ __('genres.Sci-Fi') }}</option>
                    <option value="Thriller">{{ __('genres.Thriller') }}</option>
                    <option value="War">{{ __('genres.War') }}</option>
                    <option value="Western">{{ __('genres.Western') }}</option>
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


                Sort by:
                <select name="sort" class="browser-default custom-select m-2">
                    <option value="year" selected>production year</option>
                    <option value="rating">rating</option>
                </select>
                <select name="order" class="browser-default custom-select m-2">
                    <option value="desc">descending</option>
                    <option value="asc">ascending</option>
                </select>

                <button class="btn btn-secondary m-2" type="submit">Research it!</button>
            </form>
        </div>
        <div class="movies_list">
            <div class="row" id="movies_catalog">
                @if(isset($content) && $content)
                    @foreach($content as $item)
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 movie_main_div">
                            <a href="{{ route('watch', [
                                                'imdDB' => $item->imdb_code,
                                                'movie' => $item->slug
                                            ]) }}">
                                <div class="movie">
                                    <div class="">
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
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
