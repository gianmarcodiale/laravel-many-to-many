@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="text-center">Dashboard</h2>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body bg-success text-white text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                        <h3 class="text-white">Welcome back {{ Auth::user()->name }}</h3>
                    </div>
                </div>
                <h2 class="text-center mt-5">BoolPress Administration Panel</h2>
            </div>
        </div>
    </div>
@endsection
