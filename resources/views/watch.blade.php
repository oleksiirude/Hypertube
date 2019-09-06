@extends('layouts.app')

@section('content')
    <div class="slider_movie">
        <div class="movie_cont">
            <div class="incont">
                <img class="poster_img" src="{{ $content->large_cover_image }}">
                <div class="movie_profile">

                    <actors-component actors="{{ json_encode($content->actors,TRUE)}}"
                                      path="{{ BASE_URL . SMALL}}"
                    ></actors-component>
{{--                    <div class="">--}}
{{--                        Cast:--}}
{{--                        <ul class="">--}}
{{--                            @foreach($content->actors as $actor)--}}
{{--                                <div class="actor">--}}
{{--                                    <li class="">{{ $actor->name }}</li>--}}
{{--                                    <img class="actors_img" src="{{ BASE_URL . SMALL . $actor->profile_path }}">--}}
{{--                                    @if($actor->order === 9)--}}
{{--                                        @break--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
                    <div class="">
                        <div>

                            <p>Studio: {{ $content->studio }}</p>
                            <p>Year: {{ $content->year }}</p>
                            <p>Rating: {{ $content->rating }}</p>
                            <p>Runtime: {{ $content->runtime }} minutes</p>

                            <h2>{{ $content->title }}</h2>
                            {{  $content->summary }}
                        </div>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/{{ $content->yt_trailer_code }}" allowfullscreen style="width: 500px; height: 300px"></iframe>
                        </div>

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
