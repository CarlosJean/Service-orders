import './bootstrap';
import "typicons.font";

import jquery from 'jquery';
window.$ = jquery;

// DataTables
import DataTables from 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

import '../css/createOrder.css';
import '../css/assignTechnician.css';

//Select 2
import select2 from 'select2';
select2();

//SweetAlert2
import swal from 'sweetalert2';
window.Swal = swal;