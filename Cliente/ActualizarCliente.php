<?php include("../Index.php"); ?>

<?php
$idCliente = $_GET["idCliente"];

if(isset($_GET['idusuario']))
{
	$actualizar = $_GET["idusuario"];
	//echo "Actualicemos" . $eliminar;

	$sql= "SELECT id_usuario,cedula, nombre,apellido,telefono,direccion 
			FROM cliente
			WHERE 1 = 1 and id_usuario = ".$actualizar;
	try{
		$statement = $conexion->prepare($sql);
		//en caso de que se necesite un parametro por ejemplo un where;
		//$statement->bindParam(':varTipo',$usu, PDO::PARAM_STR);
		$statement->execute();
		  //array que contiene todos lo resultados
		$lstresultados = $statement->fetch();

		//si se encontro un registro 
		/*if ($statement->rowCount() > 0) {
			//se recorre el array	
			
		}*/
	}catch(PDOException $error){
		echo $error->getMessage();
	}
}

if(isset($_POST['Actualiza']))
{
	$Cedula = $_POST['Cedula'];
	$Nombre = $_POST['Nombre'];
	$Apellido = $_POST['Apellido'];
	$Telefono = $_POST['Telefono'];
	$Direccion = $_POST['Dreccion'];

	//selecciono para validar 
	$sql= "UPDATE cliente
		   SET cedula = '".$Cedula."',
		   	   nombre = '".$Nombre."',
		   	   apellido = '".$Apellido."',
		   	   telefono = '".$Telefono."',
		   	   direccion = '".$Direccion."'
	       WHERE id_usuario = ".$_GET["id"];
	       echo $sql;
	try{
		$statement = $conexion->prepare($sql);
		//en caso de que se necesite un parametro por ejemplo un where;
		//$statement->bindParam(':varTipo',$_GET["id"], PDO::PARAM_STR);
		$statement->execute();
		header('Location: ../cliente/cliente.php?id='.$idCliente);
		exit;
	}catch(PDOException $error){
		echo $error->getMessage();
	}
}
?>

<div class="container-fluid"> 
	<form class="form-horizontal" method="post" action="">
		<div class="mb-3">
			<a href="">esto debe ser otra cosa un titlo </a>
		</div>
		<div class="mb-3">
            <label class="control-label col-sm-3">Cedula</label>
            <div class="col-sm-9">
                <input autofocus="true" class="form-control input-lg" id="Cedula" maxlength="30" name="Cedula" placeholder="Usuario" type="text" value="<?php echo $resutadocliente['cedula']; ?>" required>
            </div>
        </div>	
        <div class="mb-3">
            <label class="control-label col-sm-3">Nombre</label>
            <div class="col-sm-9">
                <input class="form-control input-lg" id="Nombre" maxlength="30" name="Nombre" placeholder="Contraseña" type="text" value="<?php echo $resutadocliente['nombre'];  ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="control-label col-sm-3">Apellido</label>
            <div class="col-sm-9">
                <input autofocus="true" class="form-control input-lg" id="Apellido" maxlength="30" name="Apellido" placeholder="Usuario" type="text" value="<?php echo $resutadocliente['apellido'];  ?>"required>
            </div>
        </div>	
        <div class="mb-3">
            <label class="control-label col-sm-3">Telefono</label>
            <div class="col-sm-9">
                <input class="form-control input-lg" id="Telefono" maxlength="30" name="Telefono" placeholder="Contraseña" type="text"  value="<?php echo $resutadocliente['telefono'];  ?>" required>
            </div>
        </div>
         <div class="mb-3">
            <label class="control-label col-sm-3">Dirección</label>
            <div class="col-sm-9">
                <input class="form-control input-lg" id="Dreccion" maxlength="30" name="Dreccion" placeholder="Contraseña" type="text"  value="<?php echo $resutadocliente['direccion'];  ?>"required>
            </div>
        </div>
        <div class="mb-3">
            <label class="control-label col-sm-3">Estado Proceso</label>
            <div class="col-sm-9">
                <select class="form-control input-lg">
                	<option>Seleccione...</option>
                	<option value="1">En proceso</option>
                	<option value="2">Terminado</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
         <input type="submit" class="btn btn-success" name="Actualiza" value="Actualizar"> 	
       
		  <a class="btn btn-danger" href="../cliente/cliente.php?id=<?php echo $idCliente?>">Regresar </a>
        </div>
	</form>
</div>

