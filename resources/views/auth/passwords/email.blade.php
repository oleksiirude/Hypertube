@extends('layouts.app')

@section('content')
    <reset-password-email-component
            action="{{ route('password.email') }}"
            csrf_token="{{ csrf_token() }}">
    </reset-password-email-component>
@endsection
