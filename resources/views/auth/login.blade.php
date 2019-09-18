@extends('layouts.app')

@section('content')
    <div class="container login_div">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('titles.signIn') }}</div>

                    <div id="enter-div" class="card-body">

                        <login-component
                                action="{{ route('login') }}"
                                main="{{ route('main') }}"
                                csrf_token="{{ csrf_token() }}"
                                forget_pass="{{ route('password.request') }}">
                        </login-component>

                        <div class="dropdown-divider"></div>
                        <div class="text-center">
                            {{ __('titles.signIn') }}{{ __('parts.via') }} {{ __('parts.services') }}:
                            <div id="oauth_main">
                                <a id="42" class="btn btn-primary" href="{{ route('oauth', '42') }}">
                                    <img src="{{ asset('/images/service/42_white.svg') }}" alt="42_school" title="school42" class="oath_img"></a>
                                <a id="github" class="btn btn-primary" href="{{ route('oauth', 'github') }}">
                                    <img src="{{ asset('/images/service/git.png') }}" alt="GitHub" title="GitHub" class="oath_img"></a>
                                <a id="linkedin" class="btn btn-primary" href="{{ route('oauth', 'linkedin') }}">
                                    <img src="{{ asset('/images/service/linkedin.png') }}" alt="LinkedIn" title="LinkedIn" class="oath_img"></a>
                                <a id="google" class="btn btn-primary" href="{{ route('oauth', 'google') }}">
                                    <img src="{{ asset('/images/service/googleplus.png') }}" alt="Google+" title="Google+" class="oath_img"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
