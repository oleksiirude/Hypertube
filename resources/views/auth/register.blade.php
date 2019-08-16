@extends('layouts.app')

@section('content')
    <registration-component
        action="{{ route('register') }}"
        login="{{ route('login') }}"
        csrf_token="{{ csrf_token() }}"
        {{-- titles --}}
        register="{{ __('constant.register') }}"
        username="{{ __('constant.username') }}"
        first_name="{{ __('constant.first_name') }}"
        last_name="{{ __('constant.last_name') }}"
        email="{{ __('constant.email') }}"
        password="{{ __('constant.password') }}"
        password_confirmation="{{ __('constant.password_confirmation') }}">
    </registration-component>
@endsection
