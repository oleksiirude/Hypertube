@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
{{--            <div class="col-2" style="background-color: grey">--}}
{{--                Cast:--}}
{{--                <ul class="list-group m-2">--}}
{{--                @foreach($content->actors as $actor)--}}
{{--                    <li class="list-group-item list-group-item-light font-weight-light">{{ $actor->name }}</li>--}}
{{--                    <img class="rounded float-right img-fluid" src="{{ BASE_URL . SMALL . $actor->profile_path }}">--}}
{{--                    @if($actor->order === 9)--}}
{{--                        @break--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--            <div class="col-10" style="background-color: #353535">--}}
{{--                <img class="rounded float-left img-fluid w-50 m-2" src="{{ $content->large_cover_image }}">--}}
{{--                <div>--}}

{{--                    <p>Studio: {{ $content->studio }}</p>--}}
{{--                    <p>Year: {{ $content->year }}</p>--}}
{{--                    <p>Rating: {{ $content->rating }}</p>--}}
{{--                    <p>Runtime: {{ $content->runtime }} minutes</p>--}}

{{--                    <h2>{{ $content->title }}</h2>--}}
{{--                    {{  $content->summary }}--}}
{{--                </div>--}}
{{--                <div class="embed-responsive embed-responsive-16by9">--}}
{{--                    <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/{{ $content->yt_trailer_code }}" allowfullscreen style="width: 500px; height: 300px"></iframe>--}}
{{--                </div>--}}

{{--                Torrents:--}}
{{--                <ul class="list-group m-2">--}}
{{--                    @foreach($content->torrents as $item)--}}
{{--                        <li style="color: forestgreen;">{{ $item->url }}</li>--}}
{{--                        <li>quality: {{ $item->quality }}</li>--}}
{{--                        <li>seeds: {{ $item->seeds }}</li>--}}
{{--                        <li>peers: {{ $item->peers }}</li>--}}
{{--                        <li>size: {{ $item->size }}</li>--}}
{{--                        <li>magnet-link: {{ MAGNET . $item->hash . TRACKERS}}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
        </div>
    </div>
@endsection
