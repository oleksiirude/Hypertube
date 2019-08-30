@extends('layouts.app')

@section('content')
    <div class="slider row">
        <div class="profile_cont">
            <div class="incont">

                <avatar-component src="{{ asset($profile->avatar) }}"
                                  alt="{{ __('titles.avatar') }}"
                                  action="{{ route('change.avatar') }}"
                                  action_delete="{{ route('delete.avatar') }}"
                                  csrf="{{csrf_token()}}"
                ></avatar-component>

                <div class="content_profile col-lg-8 col-md-6 col-sm-6 col-xs-6">
                    <div class="title">{{ __('titles.myProfile') }}</div>

                    <div class="card-body">

                        <name-component name="login"
                                        title="{{ __('titles.username') }}"
                                        value="{{ $profile->login }}"
                                        action="{{ route('change.login') }}"
                        ></name-component>

                        <name-component name="first_name"
                                        title="{{ __('titles.firstName') }}"
                                        value="{{ $profile->first_name }}"
                                        action="{{ route('change.firstName') }}"
                        ></name-component>

                        <name-component name="last_name"
                                        title="{{ __('titles.lastName') }}"
                                        value="{{ $profile->last_name }}"
                                        action="{{ route('change.lastName') }}"
                        ></name-component>


                        <p class="titles">{{ __('titles.email') }}: </p>
                        <p class="profiledata">{{ $profile->email }}</p>


                        <bio-component title="{{ __('titles.about') }}"
                                       bio="@if($profile->info) {{ $profile->info }} @endif"
                                       no_bio="{{ __('titles.notSpecified') }}"
                                       action="{{ route('change.info') }}"
                                       csrf="{{csrf_token()}}"
                                       placeholder="{{ __('titles.bioPlaceholder') }}"
                        ></bio-component>

                    </div>


                    @if(!$profile->auth_provider)
                        {{-- Change email --}}
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('change.email') }}">
                            @csrf
                            New E-mail: <input type="text" name="email"><br>
                            Password: <input type="password" name="password"><br>
                            <button type="submit">Change email</button>
                        </form>

                        {{-- Change password --}}
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('change.password') }}">
                            @csrf
                            Current password: <input type="password" name="password"><br>
                            New password: <input type="password" name="new_password"><br>
                            Confirm password: <input type="password" name="password_confirmation"><br>
                            <button type="submit">Change password</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection