@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="form-inline md-form mr-auto mb-2" action="{{ route('search.title') }}">
            <input class="form-control mr-sm-2 w-25" type="text" placeholder="Search films..." name="title">
            <button class="btn btn-secondary" type="submit">Go!</button>
        </form>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-2">
                Research:
                <form method="GET" action="{{ route('research') }}">
                    <select name="genre" class="browser-default custom-select m-2">
                        <option value="Action" selected>Action</option>
                        <option value="Adventure">Adventure</option>
                        <option value="Animation">Animation</option>
                        <option value="Biography">Biography</option>
                        <option value="Comedy">Comedy</option>
                        <option value="Crime">Crime</option>
                        <option value="Documentary">Documentary</option>
                        <option value="Drama">Drama</option>
                        <option value="Family">Family</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="History">History</option>
                        <option value="Horror">Horror</option>
                        <option value="Musical">Musical</option>
                        <option value="Romance">Romance</option>
                        <option value="Sci-Fi">Sci-Fi</option>
                        <option value="Thriller">Thriller</option>
                        <option value="War">War</option>
                        <option value="Western">Western</option>
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
            <div class="col-10">
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
                                                            <span class="badge badge-secondary">{{ $genre }}</span>
                                                        @endforeach
{{--                                                        <div class="tools">--}}
{{--                                                            <span class="icon2 heart fav-btn "></span> &nbsp;<span class="icon2 download"></span>--}}
{{--                                                        </div>--}}
                                                            <star-component rating="{{ $item->rating }}"></star-component>
{{--                                                            <div class="title_info stars" title="{{ $item->rating }} / 10">--}}
{{--                                                                <span class="icon star"></span>--}}
{{--                                                                <span class="icon star"></span>--}}
{{--                                                                <span class="icon star"></span>--}}
{{--                                                                <span class="icon star"></span>--}}
{{--                                                                <span class="icon star"></span>--}}
{{--                                                            </div>--}}
                                                        <div class="stars">
                                                            Rating: <span class="badge badge-warning movie_rating">{{ $item->rating }}</span>
                                                            <span class="icon star"></span>
                                                            <span class="icon star"></span>
                                                            <span class="icon star"></span>
                                                            <span class="icon star"></span>
                                                            <span class="icon star_empty"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
{{--                                        <h5 class="card-title">{{ $item->title }}</h5>--}}

{{--                                        <h6>Rating: <span class="badge badge-warning">{{ $item->rating }}</span></h6>--}}

{{--                                        <div class="card-text">--}}
{{--                                        @foreach($item->genres as $genre)--}}
{{--                                                <span class="badge badge-secondary">{{ $genre }}</span>--}}
{{--                                        @endforeach--}}
{{--                                        </div>--}}

                                    </div>
                                </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
{{--            <div class="iScrollVerticalScrollbar iScrollLoneScrollbar" style="position: absolute; z-index: 9999; width: 7px; bottom: 2px; top: 2px; right: 1px; overflow: hidden; transform: translateZ(0px); transition-duration: 500ms; opacity: 0;">--}}
{{--                <div class="iScrollIndicator" style="box-sizing: border-box; position: absolute; background: rgba(0, 0, 0, 0.5); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 3px; width: 100%; transition-duration: 0ms; display: block; height: 75px; transform: translate(0px, 294px) translateZ(0px);">--}}

{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
@endsection
