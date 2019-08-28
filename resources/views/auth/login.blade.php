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
                    <div class="card-header">{{ __('titles.signIn') }}</div>

                    <div id="enter-div" class="card-body">
                        <form id="login-form">

                            <div id="login-div" class="form-group row">
                                <label for="login" class="col-md-4 col-form-label text-md-right">{{ __('titles.username') }}</label>

                                <div class="col-md-6">
                                    <input id="login" type="text" class="form-control" name="login" value="">
                                </div>
                            </div>

                            <div id="password-div" class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('titles.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label" for="remember">
                                            {{ __('titles.doNotRememberMe') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button id="login-btn" type="submit" class="btn btn-primary">
                                        {{ __('titles.signIn') }}
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('titles.forgotPassword') }}
                                    </a>
                                </div>
                            </div>
                        </form>

                        <div class="dropdown-divider"></div>
                        <div class="text-center">
                            {{ __('titles.signIn') }}{{ __('parts.via') }} {{ __('parts.services') }}:

                            <div id="oauth_main">
                                <a id="42" class="btn btn-primary" href="{{ route('oauth', '42') }}"><img src="{{ asset('/images/service/42_white.svg') }}" alt="42_school" title="school42" class="oath_img"></a>
                                <a id="github" class="btn btn-primary" href="{{ route('oauth', 'github') }}"><img src="{{ asset('/images/service/git.png') }}" alt="GitHub" title="GitHub" class="oath_img"></a>
                                <a id="linkedin" class="btn btn-primary" href="{{ route('oauth', 'linkedin') }}"><img src="{{ asset('/images/service/linkedin.png') }}" alt="LinkedIn" title="LinkedIn" class="oath_img"></a>
                                <a id="google" class="btn btn-primary" href="{{ route('oauth', 'google') }}"><img src="{{ asset('/images/service/googleplus.png') }}" alt="Google+" title="Google+" class="oath_img"></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
