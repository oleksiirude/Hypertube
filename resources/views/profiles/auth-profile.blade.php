@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('constant.my-profile') }}</div>

                    <div class="card-body">

                        <img src="{{ asset($profile->avatar) }}" alt="{{ __('constant.avatar') }}" style="width: 200px">

                        <p>{{ __('constant.username') }}: {{ $profile->login }}</p>

                        <p>{{ __('constant.first_name') }}: {{ $profile->first_name }}<br>
                        {{ __('constant.last_name') }}: {{ $profile->last_name }}</p>

                        <p>{{ __('constant.about') }}:
                            @if(!$profile->info)
                                {{ __('constant.not_specified') }}
                            @else
                                {{ $profile->info }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection