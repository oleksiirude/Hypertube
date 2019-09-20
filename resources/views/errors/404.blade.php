@extends('layouts.app')

@section('content')
    <div class="container fourZeroFour">
        <span class="apologies">{{ trans('titles.apologies') }}</span>
        <img class="img-fluid" src="{{ env('APP_URL') . '/images/service/404.png'}}">
    </div>
@endsection