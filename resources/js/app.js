import './bootstrap';
import "typicons.font";

import jquery from 'jquery';
window.$ = jquery;

// DataTables
import DataTable from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';
import 'datatables.net-select-dt';

import '../css/createOrder.css';
import '../css/assignTechnician.css';

//Select 2
import select2 from 'select2';
select2();

//SweetAlert2
import swal from 'sweetalert2';
window.Swal = swal;

//JQuery validation
import validate from 'jquery-validation';

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});