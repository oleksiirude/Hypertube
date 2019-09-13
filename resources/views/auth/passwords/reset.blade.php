@extends('layouts.app')

@section('content')
    <reset-password-component
            action="{{ route('password.update') }}"
            email="{{ $email }}"
            token="{{ $token }}"
            main="{{ route('main') }}"
            new_link="{{ route('password.request') }}"
            csrf_token="{{ csrf_token() }}"
            successful_reset="{{ __('messages.successfulReset') }}"
            continue="{{ __('titles.continue') }}"
            get_new_link="{{ __('titles.getNewLink') }}">
    </reset-password-component>

@endsection
