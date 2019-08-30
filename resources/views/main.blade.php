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
            <div class="col-10" style="background-color: darkgrey">
                <div class="row">
                    @if(isset($content) && $content)
                        @foreach($content as $item)
                            <div class="col-sm-4 pt-2 pb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <span class="badge badge-info float-right">{{ $item->year }}</span>
                                        <h5 class="card-title">{{ $item->title }}</h5>
                                        <a href="{{ route('watch', [
                                                'imdDB' => $item->imdb_code,
                                                'movie' => $item->slug
                                            ]) }}">
                                                <img class="img-thumbnail" src="{{ $item->large_cover_image }}">
                                        </a>
                                        <h6>Rating: <span class="badge badge-warning">{{ $item->rating }}</span></h6>

                                        <div class="card-text">
                                        @foreach($item->genres as $genre)
                                                <span class="badge badge-secondary">{{ $genre }}</span>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
