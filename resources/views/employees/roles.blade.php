
@extends('layouts.app')


@section('content')


@vite(['resources/js/roles.js'])


<div class="container">
<div class="table">

<table id="dataTable" class="table table-striped table-bordered" style="font-size:11px; table-layout: fixed; width: 100%">
  </table>
  </div>
</div>


<!-- Modal -->
<div class="modal fade asignarMenu" id="asignarMenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Asignar Submenu a Rol</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="register-roles-submenu" id="reg" method="post">
        @csrf
        <div class="row">        
        <div class="col-12">
        <input type="text" class="form-control" name="rol" id="rol" disabled>
        <input type="hidden" class="form-control" name="rolId" id="rolId">

        </div>
        </div>
        <div class="row" style="margin-top:5px">        
        <div class="col-12">
        <select name="slcMenus" id="slcMenus" class="form-select slcMenus" style="width: 100%" required>
          <option value="">Seleccione un menu</option>
       </select>
        </div>
        </div>
   
        <input type="hidden" class="form-control" name="id">

        <div class="row" style="margin-top:5px">        
        <div class="col-12">
        <select multiple name="slcSubmenu[]" id="slcSubmenu" class="form-select slcSubmenu" style="width: 100%; margin-top:5px" required>
       </select>
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <input type="submit"  class="btn btn-primary" value="Guardar"/> 
      </form>
    </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Rol</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="register-role"  method="post">
        @csrf
      <div class="row">        
        <div class="col-12">
          <label for="">Nombre</label>
          <div class="form-group">
            <input type="text" class="form-control" name="nombre" required>
          </div>
        </div>
        <input type="hidden" class="form-control" name="id">

        <div class="col-12">
          <label for="">Descripción</label>
          <div class="form-group">
            <input type="text" class="form-control" name="descripcion" required>
          </div>
        </div>
        
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <input type="submit"  class="btn btn-primary" value="Guardar"/> 
      </form>
    </div>
    </div>
  </div>
</div>


@endsection


