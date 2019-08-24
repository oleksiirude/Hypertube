@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('titles.profile') }} {{ $profile->login }}</div>

                    <div class="card-body">
                        <img src="{{ asset($profile->avatar) }}" alt="{{ __('titles.avatar') }}" style="width: 200px; border-radius: 100%">

                        <p>{{ __('titles.firstName') }}: {{ $profile->first_name }}<br>
                            {{ __('titles.lastName') }}: {{ $profile->last_name }}</p>

                        <p>{{ __('titles.about') }}:
                            @if(!$profile->info)
                                {{ __('titles.notSpecified') }}
                            @else
                                {{ $profile->info }}
                            @endif
                        </p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection