@extends('layouts.app')

@section('content')
    <login-component
            action="{{ route('login') }}"
            reset="{{ route('password.request') }}"
            main="{{ route('main') }}"
            csrf_token="{{ csrf_token() }}"
            {{-- titles --}}
            login="{{ __('constant.login') }}"
            username="{{ __('constant.username') }}"
            password="{{ __('constant.password') }}"
            remember_me="{{ __('constant.remember_me') }}"
            forgot_password="{{ __('constant.forgot_password') }}">
    </login-component>
@endsection
