@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 4%;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h2 class="title_topic">{{ $profile->login }}</h2></div>
                    <div class="card-body">
                        <img src="{{ asset($profile->avatar) }}" alt="{{ __('titles.avatar') }}" style="width: 200px; border-radius: 100%; margin-bottom: 20px">

                        <p>{{ $profile->first_name }} {{ $profile->last_name }}</p>

                        <p>{{ __('titles.about') }}:
                            @if(!$profile->info)
                                {{ __('titles.notSpecified') }}
                            @else
                                {{ $profile->info }}
                            @endif
                        </p>
                        @if($recommendations)
                            <recommendations-profile-page-component
                                    recommendations="{{ json_encode($recommendations) }}"
                                    property="{{ json_encode($property) }}"
                                    action="{{ route('delete.film.recommendation') }}">
                            </recommendations-profile-page-component>
                        @endif
                    </div>
                </div>
             </div>
        </div>
    </div>
@endsection