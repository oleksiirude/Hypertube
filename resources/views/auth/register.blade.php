@extends('layouts.app')

@section('content')

    <div class="container login_div">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('titles.register') }}</div>

                    <div id="register-div" class="card-body">

                        <registration-component
                                action="{{ route('register') }}"
                                login_route="{{ route('login') }}"
                                csrf_token="{{ csrf_token() }}"
                                sign_in_title="{{ __('titles.signIn') }}"
                                successful_registration="{{ __('messages.successfulRegistration') }}">
                        </registration-component>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
