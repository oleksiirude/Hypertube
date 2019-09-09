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
            successful_reset="{{ __('messages.successfulReset') }}"
            continue="{{ __('titles.continue') }}"
            get_new_link="{{ __('titles.getNewLink') }}">
    </reset-password-component>

    <div class="container login_div">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('titles.setNewPasswordTitle') }}</div>

                    <div id="reset-password-div" class="card-body">
                        <form id="reset-password-form">

                            <div id="password-div" class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('titles.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div id="password_confirmation-div" class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('titles.passwordConfirmation') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button id="reset-password" type="submit" class="btn btn-primary">
                                        {{ __('titles.setNewPasswordAction') }}
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
