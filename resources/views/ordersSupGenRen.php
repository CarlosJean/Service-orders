@extends('layouts.orders_template')

@extends('layouts.orders_footer')

@section('screenName', 'Orden de servicios')
@push('orderNumber')
<input type="text" name="" id="" value="0" class="form-control text-end" readonly>
@endpush

@section('orderContent')
<div class="container">

    <br>
    <br>

<div class="row">
<div class="col-12">
 <label for="exampleFormControlTextarea1">Problema</label>
 <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>
</div>
<br>
<br>
<br>
<br><br>
<br>
<br>
</div>

@endsection



