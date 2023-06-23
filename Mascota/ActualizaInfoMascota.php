<?php include("../Index.php");

$sql= "select Nombre,Tipo_Mascota,Raza 
	   from mascota where id_mascota = :id";

	$sentencia = $conexion->prepare($sql);
	$sentencia->bindValue('id',$_GET["idMascota"]);
	$sentencia->execute();
	$resultado= $sentencia-> fetch();

if(isset($_POST["actualiza"]))
{
	$sql = "update mascota set Nombre =:nombre, Tipo_Mascota=:tipomascota, raza=:razamascota 
		where id_mascota = :idmascota";
	$sentencia = $conexion->prepare($sql);
	$sentencia->bindValue('nombre',$_POST["Nombredemascota"]);
	$sentencia->bindValue('tipomascota',$_POST["Tipodemascota"]);
	$sentencia->bindValue('razamascota',$_POST["Razademascota"]);
	$sentencia->bindValue('idmascota',$_POST["idmascota"]);
	$sentencia->execute();
	header("Location: ../Mascota/InfoMascota.php?idusu=".$_GET["idusu"]."&idCliente=".$_GET["idCliente"]);
}
?>

<form method="POST" action="" class="container-fluid">
    <div class="mb-3">
        <a class="btnLogOut btn btn-danger" href="../Mascota/InfoMascota.php?idusu=<?php echo $_GET["idusu"];?>&idCliente=<?php echo $_GET["idCliente"] ?>"><div>Regresar info <br> mascota </div></a>
    </div>
    <div class="mb-3 mt-5 row">
        <label class="form-label col-sm-2">Nombre: </label>
        <div class="col-sm-4"> 
            <input type="text" class="form-control" name= "Nombredemascota" placeholder="Nombre de mascota" value="<?php echo $resultado["Nombre"];  ?>">
        </div>

        <label class="form-label col-sm-2">Tipo de mascota: </label> 
        <div class="col-sm-4">
            <input type="text" name= "Tipodemascota" class="form-control" placeholder="Tipo de mascota" value="<?php echo $resultado["Tipo_Mascota"];  ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label class="form-label col-sm-2">Raza de mascota: </label>    
        <div class="col-sm-10">
            <input type="text" name= "Razademascota" class="form-control" placeholder="Raza de mascota" value="<?php echo $resultado["Raza"];  ?>">   
        </div>
    </div> 
    <input type="hidden" name="idmascota" value="<?php echo $_GET["idMascota"];?>">
    <div class="mb-3">
        <button type="submit" class="btn btn-success" name="actualiza"> 
            Actualizar Información 
        </button>    
    </div> 
</form>