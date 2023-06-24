
<?php include("../Index.php"); ?>
<?php

$sql="SELECT u.id,c.id_usuario,c.nombre,c.apellido,c.cedula,c.telefono,c.correo
	from cliente c
	join clieusu cu
	on c.id_usuario = cu.id_Cliente
	join usuario u
	on u.Id = cu.id_usuario
	where u.Id =:id";
$statement = $conexion->prepare($sql);
$statement->bindValue('id',$_GET["id"]);
$statement->execute();
$resultado= $statement-> fetchAll();

?>

<div class="container-fluid">
	<div class="mb-3 row">
		<div class="col-sm-12">
			<a class="btnLogOut btn btn-danger" href="../Login/Login.php">	Cerrar Sesión</a>		
		</div>
	</div>
	<div class="mb-6 mt-3 row">
		<div class="accordion accordion-flush" id="accordionFlushExample">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="flush-headingOne">
		      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
		        Información del usuario
		      </button>
		    </h2>
		    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
		      <div class="accordion-body">
		      	<div class="row">
		      		<label class="form-label col-sm-6">Nombre usuario: <?php echo $resultado[0]["nombre"]. " ". $resultado[0]["apellido"]?>
		      		</label>	

		      		<label class="form-label col-sm-6">Cédula usuario: <?php echo $resultado[0]["cedula"]?>
		      		</label>	
		      	</div>
		      	<div class="row">
		      		<label class="form-label col-sm-6">Teléfono usuario: <?php echo $resultado[0]["telefono"]?>
		      		</label>
		      		<label class="form-label col-sm-6">Correo usuario: <?php echo $resultado[0]["correo"]?>
		      		</label>
		      	</div>
		      		
		      	<!--Esta información hay qye borrarla solo la muestro para guiarme	
		      	<label class="form-label">id usuario: <?php echo $resultado[0]["id"]?>
		      	</label>
		      	<label class="form-label">id usuario: <?php echo $resultado[0]["id_usuario"]?>
		      	</label>		-->
		      	<a class="btn btn-info" href="../cliente/ActualizarCliente.php?idCliente=<?php echo $resultado[0]["id_usuario"];?>&idUsuario=<?php echo$_GET["id"];?>">Actualizar info usuario</a>
		      </div>
		    </div>
		  </div>
		</div>
	</div>

	<div class="mt-3 row">
		<div class="col-sm-6">
			<!--estos son card bootstrap-->
			<div class="card" style="width: 18rem;">
			  <div class="card-body">
			    <h5 class="card-title">Modulo Mascota</h5>
			    <p class="card-text">En este módulo se podra agregar,actualizar,eliminar y consultar la información asociada a este usuario.</p>
			    <a class="btn btn-primary" href="../Mascota/InfoMascota.php?idCliente=<?php echo $resultado[0]["id_usuario"];?>&idusu=<?php echo $resultado[0]["id"];?>">Modulo Mascota</a>
			  </div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="card" style="width: 18rem;">
			  <div class="card-body">
			    <h5 class="card-title">Modulo Servicio</h5>
			    <p class="card-text">En este módulo se podra agendar una cita, para su mascota. Como también se podra consultar las citas ya agendadas.</p>
				<a class="btn btn-info" href="../Cliente/citas.php?idCliente=<?php echo $resultado[0]["id_usuario"];?>&idusu=<?php echo $resultado[0]["id"];?>">Modulo Servicio</a>
			  </div>
			</div>
		</div>
	</div>
</div>







