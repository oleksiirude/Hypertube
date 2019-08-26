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
            <div class="col" style="background-color: #1d643b">
                navbar
            </div>
            <div class="col-10" style="background-color: darkgrey">
{{--                @if(count($content))--}}
{{--                    content--}}
{{--                @endif--}}
            </div>
        </div>
    </div>
@endsection


















{{--    <div class="container">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">Main page</div>--}}

{{--                    <div class="card-body">--}}
{{--                        Searching films:<p>--}}

{{--                        <form method="GET" action="{{ route('imdb') }}">--}}
{{--                            <input type="text" name="request">--}}
{{--                            <button class="button-blue" type="submit">imdb api</button>--}}
{{--                        </form>--}}

{{--                        <form method="GET" action="{{ route('tmdb') }}">--}}
{{--                            <input type="text" name="request">--}}
{{--                            <button class="button-blue" type="submit">tmdb api</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
