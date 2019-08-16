@extends('layouts.app')

@section('content')
    <registration-component
        action="{{ route('register') }}"
        login="{{ route('login') }}"
        csrf_token="{{ csrf_token() }}">
    </registration-component>
@endsection
