@extends('layouts.app')

@section('content')
    <reset-password-component
            action="{{ route('password.update') }}"
            email="{{ $email }}"
            token="{{ $token }}"
            main="{{ route('main') }}"
            new_link="{{ route('password.request') }}"
            csrf_token="{{ csrf_token() }}"
            {{-- titles --}}
            set_new_password_title="{{ __('constant.set_new_password_title') }}"
            password="{{ __('constant.password') }}"
            password_confirmation="{{ __('constant.password_confirmation') }}"
            set_new_password_action="{{ __('constant.set_new_password_action') }}"
            successful_reset="{{ __('constant.successful_reset') }}"
            continue="{{ __('constant.continue') }}"
            get_new_link="{{ __('constant.get_new_link') }}">
    </reset-password-component>
@endsection
