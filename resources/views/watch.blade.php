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

                    <actors-component actors="{{ json_encode($content->actors,TRUE)}}"
                                      path="{{ BASE_URL . SMALL}}"
                    ></actors-component>

                    <div class="title_info_cont">
                        <div class="title_info">Year: {{ $content->year }}</div>
                        <div class="title_info">Runtime: {{ $content->runtime }} minutes</div>
                        <div class="title_info">Rating: {{ $content->rating }}</div>
                    </div>

                    <div class="">
                        <div>

                            <p>Studio: {{ $content->studio }}</p>


                            {{  $content->summary }}
                        </div>
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
