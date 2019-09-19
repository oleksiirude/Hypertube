@extends('layouts.app')

@section('content')
    <div class="slider_movie">
        <div class="movie_cont">
            <div class="incont">
                <img class="poster_img" src="{{ $content->large_cover_image }}">
                <div class="movie_profile">
                    <div class="title">{{ $content->title }}</div>


                    <genre-component genres="{{ json_encode($content->genres,TRUE)}}"></genre-component>

                    <info-component year="{{ $content->year }}"
                                    runtime="{{ $content->runtime }}"
                                    rating="{{ $content->rating }}"
                                    studio="{{ $content->studio }}">
                    </info-component>

                    <actors-component actors="{{ json_encode($content->actors, TRUE)}}"></actors-component>

                    <div class="">
                        <div class="movie_desc">
                            {{  $content->summary }}
                        </div>

                        <trailer-component trailer="http://www.youtube.com/embed/{{ $content->yt_trailer_code }}"></trailer-component>

                    <video-player-component imdb-id="{{$content->imdb_code}}" :video-srcs="{{json_encode($content->magnets, TRUE)}}"></video-player-component>

                    </div>

                    <wishlist-film-page-component
                            imdb_id="{{ $content->imdb_code }}"
                            action_add="{{ route('add.film.wishlist') }}"
                            action_delete="{{ route('delete.film.wishlist') }}"
                            action_history="{{ route('add.film.history') }}"
                            wishlist="{{ json_encode($wishlist) }}">
                    </wishlist-film-page-component>

                    <recommendations-film-page-component
                            imdb_id="{{ $content->imdb_code }}"
                            action_add="{{ route('add.film.recommendation') }}"
                            action_delete="{{ route('delete.film.recommendation') }}"
                            recommendations="{{ json_encode($recommendations) }}">
                    </recommendations-film-page-component>
                    </div>
            </div>
        </div>
        <comments-component
                action="{{ route('add.comment') }}"
                comments="{{ json_encode($comments) }}"
                prefix_avatar="{{ env('APP_URL') }}"
                prefix_profile="{{ env('APP_URL') . '/profile/' }}"
                auth_login="{{ auth()->user()->login }}"
                auth_avatar="{{ env('APP_URL') . auth()->user()->avatar }}">
        </comments-component>
    </div>
@endsection