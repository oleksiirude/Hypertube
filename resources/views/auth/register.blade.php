@extends('layouts.app')

@section('content')
    <registration-component
        register="{{ route('register') }}"
        token="{{ csrf_token() }}">
    </registration-component>
@endsection
