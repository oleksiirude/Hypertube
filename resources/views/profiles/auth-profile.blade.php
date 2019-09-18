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
                                        edit="{{asset('/images/service/edit.png')}}"
                                        title_save="{{ __('titles.save') }}"
                                        title_cancel="{{ __('titles.cancel') }}"
                        ></name-component>

                        <name-component name="first_name"
                                        title="{{ __('titles.firstName') }}"
                                        value="{{ $profile->first_name }}"
                                        action="{{ route('change.firstName') }}"
                                        edit="{{asset('/images/service/edit.png')}}"
                                        title_save="{{ __('titles.save') }}"
                                        title_cancel="{{ __('titles.cancel') }}"
                        ></name-component>

                        <name-component name="last_name"
                                        title="{{ __('titles.lastName') }}"
                                        value="{{ $profile->last_name }}"
                                        action="{{ route('change.lastName') }}"
                                        edit="{{asset('/images/service/edit.png')}}"
                                        title_save="{{ __('titles.save') }}"
                                        title_cancel="{{ __('titles.cancel') }}"
                        ></name-component>

                        @if($profile->auth_provider)
                            <p class="titles">{{ __('titles.email') }}: </p>
                            <p class="profiledata">{{ $profile->email }}</p>
                        @endif

                        @if(!$profile->auth_provider)

                            <email-component name="email"
                                             title="{{ __('titles.email') }}"
                                             value="{{ $profile->email }}"
                                             action="{{ route('change.email') }}"
                                             edit="{{asset('/images/service/edit.png')}}"
                                             title_save="{{ __('titles.save') }}"
                                             title_cancel="{{ __('titles.cancel') }}"
                                             eye_show="{{asset('/images/service/eye.png')}}"
                                             eye_hide="{{asset('/images/service/hide_eye.png')}}"
                            ></email-component>

                            <paswword-component name="password"
                                                action="{{ route('change.password') }}"
                                                edit="{{asset('/images/service/edit.png')}}"
                                                title_save="{{ __('titles.save') }}"
                                                title_cancel="{{ __('titles.cancel') }}"
                                                eye_show="{{asset('/images/service/eye.png')}}"
                                                eye_hide="{{asset('/images/service/hide_eye.png')}}"
                            ></paswword-component>

                        @endif


                        <bio-component title="{{ __('titles.about') }}"
                                       bio="@if($profile->info) {{ $profile->info }} @endif"
                                       no_bio="{{ __('titles.notSpecified') }}"
                                       action="{{ route('change.info') }}"
                                       csrf="{{csrf_token()}}"
                                       placeholder="{{ __('titles.bioPlaceholder') }}"
                                       edit="{{asset('/images/service/edit.png')}}"
                                       title_save="{{ __('titles.save') }}"
                                       title_cancel="{{ __('titles.cancel') }}"
                        ></bio-component>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($wishlist)
    <div class="container">
        <h2>My wishlist</h2>
        <div class="row">
            @foreach($wishlist as $item)
                <div class="col-lg-4 col-6">
                    <a href="{{ $item->link }}">
                        <img class="img-thumbnail img-fluid" src="{{ $item->poster }}" alt="">
                    </a>
                    <form method="POST" action="{{ route('delete.film') }}">
                        <input type="text" name="imdb_id" value="{{ $item->imdb_id }}" hidden>
                        @csrf
                        <button type="submit" style="margin-bottom: 20px">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
    @endif
@endsection