@extends('layouts.app')

@section('content')
    <reset-password-component
            action="{{ route('password.update') }}"
            email="{{ $email }}"
            token="{{ $token }}"
            main="{{ route('main') }}"
            new_link="{{ route('password.request') }}"
            csrf_token="{{ csrf_token() }}">
    </reset-password-component>
@endsection
