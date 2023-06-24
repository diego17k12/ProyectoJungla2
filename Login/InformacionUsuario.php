<?php include("../Index.php"); 

if(isset($_POST["enviar"]))
{
	$tipousuario = $_POST["tipoUsua"];
 
	$sql = "Insert into ".$tipousuario."(Cedula,Nombre,Apellido,Direccion,Telefono,correo) values (:cedula,:nombre,:apellido,:telefono,:direccion,:correo)";

	$sentencia = $conexion->prepare($sql);
	$sentencia->bindParam('cedula',$_POST["cedula"]);
	$sentencia->bindParam('nombre',$_POST["Nombre"]);
	$sentencia->bindParam('apellido',$_POST["Apellido"]);
	$sentencia->bindParam('telefono',$_POST["Telefono"]);
	$sentencia->bindParam('direccion',$_POST["Direccion"]);
	$sentencia->bindParam('correo',$_POST["Correo"]);
	$sentencia->execute();

//se debe llenar las tablas de rompimiento
	if ($tipousuario == "cliente") {

		//debo consultar los respectivos ids creados(idusuario y idcliente)	
		$sqlusuario = "select id from usuario where usuario = :usuario";
		$sentenciausuario = $conexion->prepare($sqlusuario);
		$sentenciausuario->bindParam('usuario',$_POST["NomUsuar"]);
		$sentenciausuario->execute();
		$resultadousuario= $sentenciausuario->fetch();

		$sqlcliente = "select id_usuario from cliente where cedula = :cedula";
		$sentenciacliente = $conexion->prepare($sqlcliente);
		$sentenciacliente->bindParam('cedula',$_POST["cedula"]);
		$sentenciacliente->execute();
		$resultadocliente= $sentenciacliente->fetch();

		$sql = "Insert into clieusu(id_usuario,id_Cliente)values(:idusu,:idclie)";

		$sentencia = $conexion->prepare($sql);
		$sentencia->bindParam('idusu',$resultadousuario["id"]);
		$sentencia->bindParam('idclie',$resultadocliente["id_usuario"]);
		$sentencia->execute();
		
	}else
	{
		//veterinario
		//debo consultar los respectivos ids creados(idusuario y idcliente)	
		$sqlusuario = "select id from usuario where usuario = :usuario";
		$sentenciausuario = $conexion->prepare($sqlusuario);
		$sentenciausuario->bindParam('usuario',$_POST["NomUsuar"]);
		$sentenciausuario->execute();
		$resultadousuario= $sentenciausuario->fetch();

		$sqlcliente = "select id_asis from veterinario where cedula = :cedula";
		$sentenciavete = $conexion->prepare($sqlcliente);
		$sentenciavete->bindParam('cedula',$_POST["cedula"]);
		$sentenciavete->execute();
		$resultadovete= $sentenciavete->fetch();

		$sql = "Insert into veteusu(id_veterinario,id_usu)values(:idveterinario,:idusu)";

		$sentencia = $conexion->prepare($sql);
		$sentencia->bindParam('idusu',$resultadousuario["id"]);
		$sentencia->bindParam('idveterinario',$resultadovete["id_asis"]);
		$sentencia->execute();
	}
	header("Location: ../Login/Login.php");
}
?>

<form method="POST" action="" class="container-fluid">
    <div class="mb-3 row btnLogOut">
    	<div class="col-sm-12">
        <a class="btn btn-info" href="">Regresar a cliente </a>
    	</div>
    </div>
    <div class="mb-3 mt-5 row">
 		<label class="form-label col-sm-2">No. Identificación: </label>
        <div class="col-sm-4"> 
            <input type="text" class="form-control" name= "cedula" placeholder="Identificación">
        </div>

        <label class="form-label col-sm-2">Nombre: </label>
        <div class="col-sm-4"> 
            <input type="text" class="form-control" name= "Nombre" placeholder="Nombre">
        </div>
    </div>
    <div class="mb-3 row">
    	<label class="form-label col-sm-2">Apellido: </label> 
        <div class="col-sm-4">
            <input type="text" name= "Apellido" class="form-control" placeholder="Apellido">
        </div>
        <label class="form-label col-sm-2">Teléfono: </label>    
        <div class="col-sm-4">
            <input type="text" maxlength="11" name="Telefono" class="form-control" placeholder="Teléfono">   
        </div>
       
    </div> 
    <div class="mb-3 row">
    	<label class="form-label col-sm-2">Dirección: </label>    
        <div class="col-sm-4">
            <input type="text" name="Direccion" class="form-control" placeholder="Dirección">   
        </div>
        <label class="form-label col-sm-2">Correo Electrónico: </label> 
        <div class="col-sm-4">
            <input type="text" name="Correo" class="form-control" placeholder="Correo Electrónico">   
        </div>
    </div>
    <input type="hidden" name="tipoUsua" value="<?php echo $_GET["tipo"];?>">
    <input type="hidden" name="NomUsuar" value="<?php echo $_GET["user"];?>">
    <div class="mb-3">
        <button type="submit" class="btn btn-success" name="enviar"> 
            Ingresar Información 
        </button>    
    </div> 
</form>