@extends('layouts.app')

@section('content')
    <registration-component
        action="{{ route('register') }}"
        login="{{ route('login') }}"
        token="{{ csrf_token() }}">
    </registration-component>
@endsection
