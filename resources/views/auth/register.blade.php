@extends('layouts.app')

@section('content')
    <registration-component
        action="{{ route('register') }}"
        login_route="{{ route('login') }}"
        csrf_token="{{ csrf_token() }}"
        {{-- titles --}}
        register="{{ __('constant.register') }}"
        login_title="{{ __('constant.login') }}"
        username="{{ __('constant.username') }}"
        first_name="{{ __('constant.first_name') }}"
        last_name="{{ __('constant.last_name') }}"
        email="{{ __('constant.email') }}"
        password="{{ __('constant.password') }}"
        password_confirmation="{{ __('constant.password_confirmation') }}"
        successful_registration="{{ __('constant.successful_registration') }}">
    </registration-component>
@endsection
