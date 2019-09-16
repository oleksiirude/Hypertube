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

{{--                        Magnets:--}}
{{--                        <ul class="list-group m-2">--}}
{{--                            <li>720: {{ $content->magnets->hd }}</li>--}}
{{--                            <li>1080: {{ $content->magnets->full }}</li>--}}
{{--                        </ul>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
