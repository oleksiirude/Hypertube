@extends('layouts.app')

@section('content')
    <login-component
            action="{{ route('login') }}"
            reset="{{ route('password.request') }}"
            main="{{ route('main') }}"
            token="{{ csrf_token() }}">
    </login-component>
@endsection
