@extends('layouts.app')

@section('content')
    <login-component
            action="{{ route('login') }}"
            main="{{ route('main') }}"
            csrf_token="{{ csrf_token() }}">
    </login-component>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('constant.login') }}</div>

                    <div id="enter-div" class="card-body">
                        <form id="login-form">

                            <div id="login-div" class="form-group row">
                                <label for="login" class="col-md-4 col-form-label text-md-right">{{ __('constant.username') }}</label>

                                <div class="col-md-6">
                                    <input id="login" type="text" class="form-control" name="login" value="">
                                </div>
                            </div>

                            <div id="password-div" class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('constant.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label" for="remember">
                                            {{ __('constant.remember_me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button id="login-btn" type="submit" class="btn btn-primary">
                                        {{ __('constant.login') }}
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('constant.forgot_password') }}
                                    </a>
                                </div>
                            </div>
                        </form>

                        <div class="dropdown-divider"></div>
                        <div class="text-center">
                            {{ __('constant.login') }}{{ __('constant.via') }} {{ __('constant.services') }}:
                            <div id="oauth">
                                <a id="42" class="btn btn-primary" href="{{ route('oauth', '42') }}">42</a>
                                <a id="github" class="btn btn-primary" href="{{ route('oauth', 'github') }}">GitHub</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
