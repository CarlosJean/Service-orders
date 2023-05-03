@extends('layouts.app')

<div class="container">
    <div class="row">
        <div class="col-6">
            @section('content')
                <div class="card shadow">
                    @yield('orderContent')
                </div>
            @endsection
        </div>
    </div>
</div>