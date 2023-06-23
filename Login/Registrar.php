
<?php include("../Index.php"); ?>
<!--<div class="mb-3" style="margin-top: 30px; text-align: right;">
		<a class="btn btn-danger" href="">Volver al login</a>	
</div>-->

<form class="form-horizontal" method="post" action="">
	<div class="container">
		<div class="mb-3 mt-3">
		    <h2>Nuevo usuario</h2> 
		</div>

		<div class="mb-3 row">
            <label class="control-label col-sm-3">Usuario</label>
            <div class="col-sm-9">
                <input autofocus="true" class="form-control input-lg" id="UserId" maxlength="30" name="UserId" placeholder="Usuario" type="text"required>
            </div>
        </div>	
        <div class="mb-3 row">
            <label class="control-label col-sm-3">Tipo</label>
            <div class="col-sm-9">
            	<select class="form-control input-lg" id="Tipo" name="tipo" placeholder="Tpo de usuario" type="text" required >
            		<option value="">Seleccione...</option>
            		<option value="cliente">Cliente</option>
            		<option value="veterinario">Veterinario</option>
            	</select>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="control-label col-sm-3">Contraseña</label>
            <div class="col-sm-9">
                <input class="form-control input-lg" id="PassWord" maxlength="30" name="PassWord" placeholder="Contraseña" type="password" required>
            </div>
        </div>
        <div class="mb-3">
         <input type="submit" class="btn btn-success" name="NuevoUsuario" value="Agregar"> 	
         <a class="btn btn-danger" href="../Login/Login.php">Volver al login</a>	
        </div>	
	</div>
</form>

<?php 
if(isset($_POST['NuevoUsuario']))
{
	$usu = $_POST['UserId'];
	$pass = $_POST['PassWord'];
	$tipo = $_POST['tipo'];

	//selecciono para validar 
	$sql= "SELECT Id,Usuario,Contrasena,Tipo
	       FROM usuario
	       WHERE Usuario = :varTipo ";
	try{
		$statement = $conexion->prepare($sql);
		//en caso de que se necesite un parametro por ejemplo un where;
		$statement->bindParam(':varTipo',$usu, PDO::PARAM_STR);
		$statement->execute();
		  //array que contiene todos lo resultados
		$resultado = $statement->fetchAll();

	}catch(PDOException $error){
		echo $error->getMessage();
	}

	if ($statement->rowCount() > 0) {
        echo '<p class="error">El usuario ya esta registrado</p>';
    }

	if($statement->rowCount() == 0){
		//insertar datos en la tabla
		$sql= "INSERT INTO usuario(usuario,contrasena,Tipo)
				VALUES (:usu,:pass,:tipo)";
		try{
			$statement = $conexion->prepare($sql);
			$statement->bindParam('usu',$usu);
			$statement->bindParam('pass',$pass);
			$statement->bindParam('tipo',$tipo);
			$statement->execute();
			//header('Location: ../Login/Login.php');
			header('Location: ../Login/InformacionUsuario.php?tipo='.$tipo.'&user='.$usu);
			exit;
		}catch(PDOException $error){
			echo $error->getMessage();
		}		
	}
}
?>