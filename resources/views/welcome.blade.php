@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row justify-content-center">
                      <div class="col-md-12">
                        <h1 class="text-center">Fleet Managment</h1>
                        <h3 class="text-center">Join now to book your next trip!</h3>
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col-md-5">
                        <a class="btn btn-block btn-success" href="{{ route('register') }}">Register</a>
                      </div>
                      <div class="col-md-5">
                        <a class="btn btn-block btn-outline-primary" href="{{ route('login') }}">Signin</a>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
