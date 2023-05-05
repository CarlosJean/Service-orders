@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-11">
            <div class="card shadow">
                <div class="row py-5 px-5 justify-content-between">
                    <div class="col-3">
                        <img src="{{url('/drl_manufacturing.png')}}" alt="DRL Manufacturing logo" srcset="" width="100%">
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <!-- Nombre de la orden -->
                            <div class="col-12 text-end">
                                <h3>@yield('screenName', 'Órdenes de...')</h3>
                            </div>
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <p class="my-0">No.</p>
                                    </div>
                                    <div class="col-10">
                                        <!-- Input con el número de orden -->
                                        @stack('orderNumber')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 px-4">
                        <hr class="mt-3 opacity-100" />
                    </div>
                    <div class="col-12 px-5">
                        @yield('orderContent')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection