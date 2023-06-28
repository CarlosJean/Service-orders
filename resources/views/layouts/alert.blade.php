

{{-- Message --}}
@if (Session::has('success'))
<script type="module">
Swal.fire({
            icon: 'success',
            text: "{{Session::get('success')}}",
        });
</script>
@endif

@if (Session::has('error'))
    <script type="module"> 
    //alert("{{Session::get('error')}}");
Swal.fire({
            icon: 'error',
            text: "{{Session::get('error')}}",
        });
    </script>
@endif