@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Main page</div>

                    <div class="card-body">

                        Here will be main page content<p>
                        <a class="btn-light" href="{{ route('show') }}">show</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
