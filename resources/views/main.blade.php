@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Main page</div>

                    <div class="card-body">
                        Searching films:<p>

                        <form method="GET" action="{{ route('imdb') }}">
                            <input type="text" name="request">
                            <button class="button-blue" type="submit">imdb api</button>
                        </form>

                        <form method="GET" action="{{ route('tmdb') }}">
                            <input type="text" name="request">
                            <button class="button-blue" type="submit">tmdb api</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
