<?php include("../Index.php"); 

$slqveterinario = "select cedula,nombre,apellido,telefono,direccion,correo from veterinario where id_Asis = :idVete ";
	$sentencia = $conexion->prepare($slqveterinario);
	$sentencia->bindParam("idVete",$_GET["idveterinario"]);
	$sentencia->execute();
	$resutadocliente = $sentencia->fetch();


if(isset($_POST['Actualiza']))
{
	$Cedula = $_POST['Cedula'];
	$Nombre = $_POST['Nombre'];
	$Apellido = $_POST['Apellido'];
	$Telefono = $_POST['Telefono'];
	$Direccion = $_POST['Dreccion'];
	$Correo = $_POST['correo'];

	//selecciono para validar 
	$sql= "UPDATE veterinario
		   SET cedula = :cedula,
		   	   nombre = :nombre,
		   	   apellido = :apellido,
		   	   telefono = :telefono,
		   	   direccion = :direccion,
		   	   correo = :correo
	       WHERE id_Asis = :id_veterinario ";
	try{
		$statement = $conexion->prepare($sql);
		$statement->bindParam("cedula",$Cedula);
		$statement->bindParam("nombre",$Nombre);
		$statement->bindParam("apellido",$Apellido);
		$statement->bindParam("telefono",$Telefono);
		$statement->bindParam("direccion",$Direccion);
		$statement->bindParam("correo",$Correo);
		$statement->bindParam("id_veterinario",$_GET["idveterinario"]);
		$statement->execute();
		header('Location: ../Doctor/Veterinario.php?id='.$_GET["idUsuario"]);
		exit;
	}catch(PDOException $error){
		echo $error->getMessage();
	}
}
?>

<form class="container-fluid" method="post" action="">
	<div class="mb-3 mt-4">
		<h3>Actualizar Información Veterinario</h3>
	</div>
	<div class="mb-3 row">
        <label class="control-label col-sm-2">Cedula</label>
        <div class="col-sm-4">
            <input autofocus="true" class="form-control input-lg" id="Cedula" maxlength="30" name="Cedula" placeholder="Usuario" type="text" value="<?php echo $resutadocliente['cedula']; ?>" required>
        </div>

        <label class="control-label col-sm-2">Nombre</label>
        <div class="col-sm-4">
            <input class="form-control input-lg" id="Nombre" maxlength="30" name="Nombre" placeholder="Contraseña" type="text" value="<?php echo $resutadocliente['nombre'];  ?>" required>
        </div>
    </div>
    <div class="mb-3 row">
        <label class="control-label col-sm-2">Apellido</label>
        <div class="col-sm-4">
            <input autofocus="true" class="form-control input-lg" id="Apellido" maxlength="30" name="Apellido" placeholder="Usuario" type="text" value="<?php echo $resutadocliente['apellido'];  ?>"required>
        </div>
        <label class="control-label col-sm-2">Telefono</label>
        <div class="col-sm-4">
            <input class="form-control input-lg" id="Telefono" maxlength="30" name="Telefono" placeholder="Contraseña" type="text"  value="<?php echo $resutadocliente['telefono'];  ?>" required>
        </div>
    </div>
     <div class="mb-3 row">
        <label class="control-label col-sm-2">Dirección</label>
        <div class="col-sm-4">
            <input class="form-control input-lg" id="Dreccion" maxlength="30" name="Dreccion" placeholder="Contraseña" type="text"  value="<?php echo $resutadocliente['direccion'];  ?>"required>
        </div>
        <label class="control-label col-sm-2">Correo</label>
        <div class="col-sm-4">
            <input class="form-control input-lg" id="correo" maxlength="30" name="correo" placeholder="Contraseña" type="text"  value="<?php echo $resutadocliente['correo'];  ?>"required>
        </div>
    </div>
    <div class="mb-3">
     <input type="submit" class="btn btn-success" name="Actualiza" value="Actualizar"> 	
   
	  <a class="btn btn-danger" href="../Doctor/veterinario.php?id=<?php echo $_GET["idUsuario"]?>">Regresar </a>
    </div>
</form>
