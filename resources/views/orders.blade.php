<!-- @extends('layouts.menuPrincipalTemplate')  -->


  @section('content')


 <div class="container">
 <div class="card shadow  text-center " style="width: 60rem;   margin: auto;   height: 98%;">
 <img src="../img/drlmanufactur2-removebg-preview.png" alt="" width="250px" style="margin-left:50px; margin-top:35px ;">
   <div class="card-body">
   <h3 style="font-weight: 800; margin-top: -112px;  margin-left: 578px;">Gestión de materiales</h3>
       <form>
        <br>
        <br>
        
        
         <!-- Button trigger modal -->
         <div class="modalbtn">

         <!-- Button trigger modal -->
         <div class="modalbtn">
       
   
<br>
<br>



<div class="form-group p row">
<label for="" class="col-6 col-form-label" style="margin-top: -89px; margin-left: 68px;">No. de orden</label>
<input type="text" class="form-control col-md-5" id="exampleFormControlInput1" 
style="margin-top: -89px;" readonly>
</div>
</form>
<hr>




<br>


<div class="posicionar">

<div class="form-group row">
 <label for="" class="col-5 col-form-label ">Fecha</label>
 <input type="date" class="form-control col-md-5" id="exampleFormControlInput1">
</div>

<div class="form-group row">
<label for="" class="col-5 col-form-label ">Departamento</label>
      <select id="inputState" class="form-control col-md-5">
        <option selected>Seleccione el Depto</option>
      </select>
    </div>

    <div class="form-group row">
<label for="" class="col-5 col-form-label ">Servicio</label>
      <select id="inputState" class="form-control col-md-5">
        <option selected>Seleccione el servicio</option>
      </select>
    </div>

    <div class="form-group row">
<label for="" class="col-5 col-form-label ">Nombre</label>
<select class="js-example-basic-single" id="Buscar"  style="width: 340px;">
<option> Seleccione un nombre</option>
</select>
</div>

</div>
<br>
<table class="table table-striped " id="tablita">
<thead>
 <tr>
   
   <th scope="col">Articulo</th>
   <th scope="col">Referencia</th>
   <th scope="col">Descripción</th>
   <th scope="col">Medida</th>
   <th scope="col">Cantidad</th>
</tr>
</thead>


</table>



<br>
<br>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#product"
 style="margin-top:-48px; margin-left:-750px;  ">
 + Agregar articulo
</button>
<br>
<br>
<br>
<br>



   
   
   
   

      
<div class="row">
<div class="col">
 <label for="exampleFormControlTextarea1" style="margin-right: 550px;">Comentario</label>
 <textarea class="form-control col-5" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>

</div>
<br>

<br>

<br>
<br>
<br>
<hr noshade="noshade" width="18%" style="margin-right:600px;"> 
<h6 style="margin-left:-445px ;">Requerido por</h6>


<hr noshade="noshade" width="18%" style="margin-right:200px; margin-top:-35px;  "> 
<h6 style="margin-right:-350px ;">Aprobado por</h6>



</div>

 </div>
 
<br>
</div>
  <div class="botones " style="margin-left:860px ;">
 <button type="button" class="btn btn-secondary">Cancelar</button>
 <button type="button" class="btn btn-secondary">Vista previa</button>
 <button type="button" class="btn btn-primary">Enviar</button>

<br>
<br>
<br>
<br>
<div>

<!-- Final contenido -->
        
          </div><!-- container -->
        </div><!-- az-footer -->
      </div><!-- az-content-body -->
    </div><!-- container -->
  </div><!-- az-content -->



<br>
<br>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#product" style="margin-top:-80px; margin-left:-750px;  ">
 + Agregar articulo
</button>
<br>
<br>
<br>
<br>

      
<div class="row">
<div class="col">
 <label for="exampleFormControlTextarea1" style="margin-right: 550px;">Comentario</label>
 <textarea class="form-control col-5" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>

</div>
<br>

<br>

<br>
<br>
<br>
<hr noshade="noshade" width="18%" style="margin-right:600px;"> 
<h6 style="margin-left:-445px ;">Requerido por</h6>


<hr noshade="noshade" width="18%" style="margin-right:200px; margin-top:-35px;  "> 
<h6 style="margin-right:-350px ;">Aprobado por</h6>



</div>

 </div>
 
<br>
</div>
  <div class="botones " style="margin-left:860px ;">
 <button type="button" class="btn btn-secondary">Cancelar</button>
 <button type="button" class="btn btn-secondary">Vista previa</button>
 <button type="button" class="btn btn-primary">Enviar</button>

<br>
<br>
<br>
<br>
<div>

<!-- Final contenido -->
        
          </div><!-- container -->
        </div><!-- az-footer -->
      </div><!-- az-content-body -->
    </div><!-- container -->
  </div><!-- az-content -->



  @endsection



