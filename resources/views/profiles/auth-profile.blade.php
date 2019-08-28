@extends('layouts.app')

@section('content')
    <div class="slider">
        <div class="profile_cont">
            <div class="incont">

                <avatar-component src="{{ asset($profile->avatar) }}"
                                  alt="{{ __('titles.avatar') }}"
                                  action="{{ route('change.avatar') }}"
                                  action_delete="{{ route('delete.avatar') }}"
                                  csrf="{{csrf_token()}}"
                ></avatar-component>

                <div class="content_profile">
                    <div class="card-header title">{{ __('titles.myProfile') }}</div>

                    <div class="card-body">

                        <p>{{ __('titles.username') }}: {{ $profile->login }}</p>

                        <p>{{ __('titles.firstName') }}: {{ $profile->first_name }}<br>
                        {{ __('titles.lastName') }}: {{ $profile->last_name }}</p>

                        <p>{{ __('titles.email') }}: {{ $profile->email }}</p>

                        <p>{{ __('titles.about') }}:
                            @if(!$profile->info)
                                {{ __('titles.notSpecified') }}
                            @else
                                {{ $profile->info }}
                            @endif
                        </p>
                    </div>

{{--                    --}}{{-- Delete avatar --}}
                    <form method="POST" action="{{ route('delete.avatar') }}">
                        @csrf
                        <button type="submit">Delete avatar</button>
                    </form>

                    {{-- Change about me --}}
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('change.info') }}">
                        @csrf
                        <input type="text" name="info">
                        <button type="submit">Change about me</button>
                    </form>

                    {{-- Change login --}}
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('change.login') }}">
                        @csrf
                        <input type="text" name="login">
                        <button type="submit">Change login</button>
                    </form>

                    {{-- Change first name --}}
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('change.firstName') }}">
                        @csrf
                        <input type="text" name="first_name">
                        <button type="submit">Change first name</button>
                    </form>

                    {{-- Change last name --}}
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('change.lastName') }}">
                        @csrf
                        <input type="text" name="last_name">
                        <button type="submit">Change last name</button>
                    </form>

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