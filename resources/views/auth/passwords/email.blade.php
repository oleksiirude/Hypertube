@extends('layouts.app')

@section('content')
    <reset-password-email-component
            action="{{ route('password.email') }}"
            csrf_token="{{ csrf_token() }}"
            successful_link="{{ __('messages.successfulLink') }}">
    </reset-password-email-component>
@endsection
