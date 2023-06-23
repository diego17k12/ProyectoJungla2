<?php include("../Index.php"); ?>

<?php
if(isset($_GET['id']))
{
	$actualizar = $_GET["id"];
	//echo "Actualicemos" . $eliminar;

	$sql= "SELECT id,Usuario,Contrasena,Tipo
				FROM Usuario
				WHERE 1=1 and Id = ".$actualizar;

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
	$Usuario = $_POST['Usuario'];
	$Contrasena = $_POST['Contrasena'];
	$Tipo = $_POST['Tipo'];
	//selecciono para validar 
	$sql= "UPDATE Usuario
		   SET Usuario = '".$Usuario."',
		   	   Contrasena = '".$Contrasena."',
		   	   Tipo = '".$Tipo."'
	       WHERE id = ".$_GET["id"];
	       echo $sql;
	try{
		$statement = $conexion->prepare($sql);
		//en caso de que se necesite un parametro por ejemplo un where;
		//$statement->bindParam(':varTipo',$_GET["id"], PDO::PARAM_STR);
		$statement->execute();
		header('Location: ../Admin/Admin.php');
		exit;
	}catch(PDOException $error){
		echo $error->getMessage();
	}
}
?>

<div class="container"> 
	<form class="form-horizontal" method="post" action="">
		<div class="mb-3">
			<h2><label>Actualizar Información</label></h2>
		</div>
		<div class="mb-3 row">
	        <label class="control-label col-sm-3 col-form-label">Usuario</label>
	        <div class="col-sm-9">
	            <input autofocus="true" class="form-control input-lg" id="Usuario" maxlength="30" name="Usuario" placeholder="Usuario" type="text" value="<?php echo $lstresultados['Usuario']; ?>" required>
	        </div>
	    </div>	
	    <div class="mb-3 row">
	        <label class="control-label col-sm-3 col-form-label">Contraseña</label>
	        <div class="col-sm-9">
	            <input class="form-control input-lg" id="Contrasena" maxlength="30" name="Contrasena" placeholder="Contraseña" type="text" value="<?php echo $lstresultados['Contrasena'];  ?>" required>
	        </div>
	    </div>
	    <div class="mb-3 row">
	        <label class="control-label col-sm-3 col-form-label">Tipo</label>
	        <div class="col-sm-9">
	            <input class="form-control input-lg" id="Tipo" name="Tipo" placeholder="Usuario" type="text" value="<?php echo $lstresultados['Tipo'];?>" required>

	            <select class="form-control input-lg" id="Tipo" name="tipo" placeholder="Tpo de usuario" type="text" required >
	        		<option value="">Seleccione...</option>
	        		<option value="cli">Cliente</option>
	        		<option value="doc">Doctor</option>
	    		</select>
	        </div>
	    </div>	
	    <div class="mb-3">
	     <input type="submit" class="btn btn-success" name="Actualiza" value="Actualizar"> 	
	   
		  <a class="btn btn-danger" href="../Admin/Admin.php">Regresar </a>
	    </div>
	</form>
</div>

