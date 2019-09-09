@extends('layouts.app')

@section('content')
    <reset-password-email-component
            action="{{ route('password.email') }}"
            csrf_token="{{ csrf_token() }}"

            {{-- localization titles --}}
            successful_link="{{ __('messages.successfulLink') }}">
    </reset-password-email-component>

    <div class="container login_div">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('titles.resetPassword') }}</div>

                    <div id="reset-password-div" class="card-body">
                        <form>
                            <div id="email-div" class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('titles.email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="text" autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button id="send-email" type="submit" class="btn btn-primary">
                                        {{ __('titles.sendLink') }}
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
