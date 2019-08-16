@extends('layouts.app')

@section('content')
    <login-component
            action="{{ route('login') }}"
            reset="{{ route('password.request') }}"
            main="{{ route('main') }}"
            csrf_token="{{ csrf_token() }}">
    </login-component>
@endsection
