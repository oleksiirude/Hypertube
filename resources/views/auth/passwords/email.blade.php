@extends('layouts.app')

@section('content')
    <reset-password-email-component
            action="{{ route('password.email') }}"
            csrf_token="{{ csrf_token() }}"
            {{-- titles --}}
            reset_password="{{ __('constant.reset_password') }}"
            email="{{ __('constant.email') }}"
            send_link="{{ __('constant.send_link') }}"
            successful_link="{{ __('constant.successful_link') }}">
    </reset-password-email-component>
@endsection
