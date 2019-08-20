@extends('layouts.app')

@section('content')
    <reset-password-component
            action="{{ route('password.update') }}"
            email="{{ $email }}"
            token="{{ $token }}"
            main="{{ route('main') }}"
            new_link="{{ route('password.request') }}"
            csrf_token="{{ csrf_token() }}"

            {{-- localization titles --}}
            successful_reset="{{ __('constant.successful_reset') }}"
            continue="{{ __('constant.continue') }}"
            get_new_link="{{ __('constant.get_new_link') }}">
    </reset-password-component>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('constant.set_new_password_title') }}</div>

                    <div id="reset-password-div" class="card-body">
                        <form id="reset-password-form">

                            <div id="password-div" class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('constant.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div id="password_confirmation-div" class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('constant.password_confirmation') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button id="reset-password" type="submit" class="btn btn-primary">
                                        {{ __('constant.set_new_password_action') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
