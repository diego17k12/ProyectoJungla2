<?php include("../Index.php"); 
 //inGRESAR DATOS DE tabla reservacita
 if (isset($_POST['btnReserva']))
 { 
    $sql = "insert into reservacita(IdReserva,nombre,apellido,correo,telefono,nombreMascota,tipoMascota,tipoServicio,estado)values(NULL,:nombre,:apellido,:correo,:telefono,:nombreMascota,:tipoMascota,:tipoServicio,:estado)";
    
     $statement = $conexion->prepare($sql);
     $statement->bindValue('nombre',$_POST["nombre"]);
     $statement->bindValue('apellido',$_POST["apellido"]);
     $statement->bindValue('correo',$_POST["correo"]);
     $statement->bindValue('telefono',$_POST["telefono"]);
     $statement->bindValue('nombreMascota',$_POST["nomMascota"]);
     $statement->bindValue('tipoMascota',$_POST["tipomascota"]);
     $statement->bindValue('tipoServicio',$_POST["servicio"]);
     $statement->bindValue('estado',"SinAsignar");
     $statement->execute();
 }

?>
<form  class="container-fluid" action="" method="POST">
  <div class="mb-3 mt-5 row">
    <label for="inputNombre" class="col-sm-2 col-form-label">Nombre</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="nombre" placeholder="Nombre" id="inputNombre" required>
    </div>
    <label for="inputApellido" class="col-sm-2 col-form-label">Apellido</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="apellido" placeholder="Apellido" id="inputApellido">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="inputTelefono" class="col-sm-2 col-form-label">Teléfono</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="telefono" placeholder="Teléfono" id="inputTelefono" required>
    </div>
      <label for="inputTelefono" class="col-sm-2 col-form-label">Correo</label>
	  <div class="col-sm-4">
	    <input type="text" class="form-control" name="correo" placeholder="Correo" id="inputCorreo" required>
	  </div>
 </div>
 <div class="mb-3 row">
    <label for="inputTelefono" class="col-sm-2 form-label">Nombre Mascota</label>
	  <div class="col-sm-4">
	    <input type="text" class="form-control" placeholder="Nombre Mascota" name="nomMascota">
	  </div>
    <label for="inputTelefono" class="col-sm-2 form-label">Tipo Mascota</label>
    <div class="col-sm-4">
      <select name="tipomascota" class="form-control" id="">
            <option value="">seleccione</option>
            <option value="perro">Perro</option>
            <option value="gato">Gato</option>
        </select>   
    </div>
 </div>
  <div class="mb-3 row">
   <label for="inputTelefono" class="col-sm-2 form-label">Tipo Servicio</label>
    <div class="col-sm-4">
       <select name="servicio" class="form-control" id="">
            <option value="">seleccione</option>
            <option value="peluqueria">peluqueria</option>
            <option value="vacunacion">vacunación</option>
            <option value="esterilizacion">esterilización</option>
        </select>   
    </div>
 </div>
  <div class="mb-3">
  	<button class="btn btn-success" name="btnReserva" type="submit">Reservar Cita</button>
  </div>
</form>
<?php include("../footer.php"); ?>