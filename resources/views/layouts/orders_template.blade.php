@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow p-3">
        <div class="row">
            <div class="col-md-3">
                <img src="{{url('/drl_manufacturing.png')}}" alt="DRL Manufacturing logo" srcset="" width="100%">
            </div>
            <div class="col-md-9">
                <div class="row align-items-center justify-content-end h-100">
                    <!-- Nombre de la orden -->
                    <div class="col-12 text-center text-md-end mt-3 mt-md-0">
                        <h3><strong>@yield('screenName', 'Ordenes de...')</strong></h3>
                    </div>
                    <div class="col-4 col-md-1" id="dvOrderNumber">
                        <p class="my-0">No.</p>
                    </div>
                    <div class="col-8 col-md-4">
                        <!-- Input con el número de orden -->
                        @stack('orderNumber')
                    </div>
                </div>
            </div>
            <div class="col-12">
                @yield('orderContent')
            </div>
        </div>
    </div>
</div>
@endsection