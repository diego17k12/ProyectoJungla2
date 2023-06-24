<?php include("../Index.php"); ?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		    <h1 class="text-center">Login</h1>
		</div>
		<div class="modal-body"> 
			<form class="form-horizontal" method="post" action="">
				<div class="mb-3">
                    <label class="control-label col-sm-3" for="UserId">Usuario</label>
                    <div class="col-sm-9">
                        <input autofocus="true" class="form-control input-lg" id="UserId" maxlength="30" name="UserId" placeholder="Usuario" type="text"required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="control-label col-sm-3" for="PassWord">Contraseña</label>
                    <div class="col-sm-9">
                        <input class="form-control input-lg" id="PassWord" maxlength="30" name="PassWord" placeholder="Contraseña" type="password" required>
                    </div>
                </div>
                <div class="mb-3">
                 <input type="submit" name="add" value="Ingresar"> 	
                </div>
			</form>
			<a href="../Login/Registrar.php">Registrar nuevo usuario</a>
		</div>
	</di>
</div>
<?php
if(isset($_POST['add']))
{
	$usu = $_POST['UserId'];
	$pass = $_POST['PassWord'];

	//selecciono 
	$sql= "SELECT Id,Usuario,Contrasena,Tipo
	       FROM usuario
	       WHERE Usuario = :varTipo ";

		$statement = $conexion->prepare($sql);
		//en caso de que se necesite un parametro por ejemplo un where;
		$statement->bindParam(':varTipo',$usu, PDO::PARAM_STR);
		$statement->execute();

		  //array que contiene todos lo resultados
		$resultado = $statement->fetchAll();

	if ($statement->rowCount() > 0) {
		foreach ($resultado as $Registro) {
		       /*echo '<p class="error">'. $Registro["Id"]."&nbsp;&nbsp". $Registro["Usuario"]. "&nbsp;&nbsp".$Registro["Contrasena"] .'</p>';*/
		    //validar si el usuario y contraseña son 
			if($Registro["Usuario"] == $usu && $Registro["Contrasena"] == $pass)
			{
				//a este punto lo que se hace es que se debe registrar este ingreso al sistema en BD 
				$slqinsert = "INSERT INTO logusuveterinaria(Fecha,Hora,NombreUsuario,Estado)
				VALUES(now(),concat(hour(now()),minute(now()),second(now())),'".$usu."','Ok')";
		
					$statement = $conexion->prepare($slqinsert);
					$statement->execute();
				
				echo $Registro["Tipo"];
				//se dirige a  la interfaz de usuario depnediendo del tipo
				if($Registro["Tipo"] == "cliente")
				{
					echo "tipo cliente";
					header('Location: ../Cliente/Cliente.php?id='.$Registro["Id"]);
    				exit;
				}else if ($Registro["Tipo"] == "admi") {
					echo "tipo cli";
					header('Location: ../Admin/Admin.php');
    				exit;
				}
				else
				{
					echo "tipo Veterinario";
					header('Location: ../Doctor/Veterinario.php?id='.$Registro["Id"]);
    				exit;
				}

			}else
			{
				//a este punto lo que se hace es que se debe registrar este ingreso al sistema en BD 
				$slqinsert = "INSERT INTO logusuveterinaria(Fecha,Hora,NombreUsuario,Estado)
				VALUES(now(),concat(hour(now()),minute(now()),second(now())),'".$usu."','Error password')";
				try
				{
					$statement = $conexion->prepare($slqinsert);
					$statement->execute();
				}catch(PDOException $error){
					echo $error->getMessage();
				}

				echo '<p class="error">El usuario o contraseña no son correctos</p>';
			}
		}
        //echo '<p class="error">The email address is already registered!</p>';
    }

    	if($statement->rowCount() == 0){
    		echo '<p class="error">El usuario no es correcto</p>';
    	}
	/*if($statement->rowCount() == 0){
		//insert
		$sql= "INSERT INTO usuario(usuario,contrasena,Tipo)
				VALUES ('".$usu."','".$pass."','cli')";
		try{
			$statement = $conexion->prepare($sql);
			$statement->execute();
		}catch(PDOException $error){
			echo $error->getMessage();
		}		
	}*/
}
?>