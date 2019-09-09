@extends('layouts.app')

@section('content')
    <div class="slider_movie">
        <div class="movie_cont">
            <div class="incont">
                <img class="poster_img" src="{{ $content->large_cover_image }}">
                <div class="movie_profile">
                    <div class="title">{{ $content->title }}</div>


                    <genre-component genres="{{ json_encode($content->genres,TRUE)}}"
                    ></genre-component>

                    <info-component year="{{ $content->year }}"
                                    runtime="{{ $content->runtime }}"
                                    rating="{{ $content->rating }}"
                                    studio="{{ $content->studio }}"
                    ></info-component>

                    <actors-component actors="{{ json_encode($content->actors,TRUE)}}"
                                      path="{{ BASE_URL . SMALL}}"
                    ></actors-component>

                    <div class="">
                        <div class="movie_desc">
                            {{  $content->summary }}
                        </div>

{{--                        <div class="sep">--}}
{{--                            <div class="watch-btn" onclick="">--}}
{{--                                <div class="icon2 trailer"></div>--}}
{{--                                <div class="caption" >trailer</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="embed-responsive embed-responsive-16by9">--}}
{{--                            <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/{{ $content->yt_trailer_code }}" allowfullscreen style="width: 500px; height: 300px"></iframe>--}}
{{--                        </div>--}}

{{--                        Torrents:--}}
{{--                        <ul class="list-group m-2">--}}
{{--                            @foreach($content->torrents as $item)--}}
{{--                                <li style="color: forestgreen;">{{ $item->url }}</li>--}}
{{--                                <li>quality: {{ $item->quality }}</li>--}}
{{--                                <li>seeds: {{ $item->seeds }}</li>--}}
{{--                                <li>peers: {{ $item->peers }}</li>--}}
{{--                                <li>size: {{ $item->size }}</li>--}}
{{--                                <li>magnet-link: {{ MAGNET . $item->hash . TRACKERS}}</li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
