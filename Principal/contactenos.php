<?php include("../Index.php"); ?>
<div class="container">
<br><br>
  <div class="mb-3 row">
    <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="inputNombre">
    </div>
    <label for="inputApellido" class="col-sm-2 col-form-label">Apellido</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="inputApellido">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="inputTelefono" class="col-sm-2 col-form-label">Teléfono</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="inputTelefono">
    </div>
      <label for="inputTelefono" class="col-sm-2 col-form-label">Correo</label>
	  <div class="col-sm-4">
	    <input type="text" class="form-control" id="inputCorreo">
	  </div>
 </div>
 <div class="mb-3 row">
    <label for="inputTelefono" class="col-sm-2 col-form-label">Descripción</label>
	  <div class="col-sm-10">
	    <textarea name="textarea" class="form-control" id="inputCorreo" rows="10" cols="50"></textarea>
	  </div>
 </div>
  <div class="mb-3">
  	<button class="btn btn-success" type="submit">Enviar</button>
  </div>
</div>
<?php include("../footer.php"); ?>