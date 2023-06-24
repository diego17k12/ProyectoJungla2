<?php include("../Index.php");
if(isset($_POST['generate_pdf']))
{
	//se encarga de redireccioar a la pagina que se encarga de generar el pdf de reporte
	header('Location: crearPdfAdmin.php?IngUsuario=false');
}

if(isset($_POST['generate_pdfUSU']))
{
	//se encarga de redireccioar a la pagina que se encarga de generar el pdf de reporte de los ingresos que a echo un usuario al sistema
	//header('Location: crearPdfAdmin.php?IngUsuario=true');
}
//eliminar datos desde aquí
if(isset($_GET['idElim']))
{
	$eliminar = $_GET["idElim"];
	echo "eliminemos" . $eliminar;
	//Eliminar datos en la tabla
		$sql= "DELETE FROM Usuario
				where id = :id";

			$statement = $conexion->prepare($sql);
			$statement->bindValue('id',$_GET["idElim"]);
			$statement->execute();
			echo "Eliminado";
		
		header('Location: ../Admin/Admin.php');
		exit;
}

//pagina para ver los datos de los usuarios que se ingresaron en el sistema
if(isset($_POST['Consultar']))
	{
		$sql= "SELECT id,Usuario,Tipo
				FROM Usuario
				WHERE 1=1 and Usuario like '%".$_POST['Filtro']."%'";
	}else if (isset($_POST['ConsultarRol']))
	{
		$sql= "SELECT id,Usuario,Tipo
				FROM Usuario
				WHERE 1=1 and Usuario like '%".$_POST['ConsultarRol']."%'";
	}else
	{
		$sql= "SELECT id,Usuario,Tipo 
				FROM Usuario WHERE 1=1";
	}

	$statement = $conexion->prepare($sql);
	//en caso de que se necesite un parametro por ejemplo un where;
	//$statement->bindParam(':varTipo',$usu, PDO::PARAM_STR);
	$statement->execute();
	  //array que contiene todos lo resultados
	$lstresultados = $statement->fetchAll();
	//si se encontro un registro 
	/*if ($statement->rowCount() > 0) {
		//se recorre el array	
		
	}*/

    if($statement->rowCount() == 0){
    	 echo '<p class="error">no hay registros que coincida</p>';
    }

	if(isset($_GET["idCancel"]))
	{
		$sql = "update reservacita set estado = :estado
				where IdReserva = :idreserva";
		  $query = $conexion->prepare($sql);
		  $query->bindValue('estado',"Cancelado");
		  $query->bindValue('idreserva',$_GET["idCancel"]);
		  $query->execute();
	}	

    $slqreserva = "Select idreserva,nombre,apellido,correo,telefono,estado from reservacita
    	";
	    $query = $conexion->prepare($slqreserva);
	    $query->execute();
	    $lstReserva = $query->fetchAll();

?>

<form method="post" action="" class="container-fluid form-horizontal">
	<div class="mb-3">
		<a class="btnLogOut btn btn-danger" href="../Login/Login.php">Cerrar Session</a>
	</div>
	<div class="card">
		<div class="card-header" class="btn btn-link" data-bs-toggle="collapse" href="#Filtro" role="button" aria-expanded="false" aria-controls="Filtro">
			<a >Filtros</a>
		</div>
		<div id="Filtro" class="collapse" aria-labelledby="headingOne">
			<div class="row">
				<label class="col-sm-2 form-label">filtro nombre:</label>
				<div class="input-group col-sm-10">
					<input class="form-control" type="text" name="Filtro">
					  <input type="submit" class="input-group-addon btn btn-info" name="Consultar" value="Consultar">
					  <input type="submit" class="input-group-addon btn btn-success" name="LimpiarFiltro" value="Limpiar Filtro"> 	
				</div>
			</div>
			<div class="row">
				<label class="col-sm-2 form-label">filtro Rol:</label>
				<div class="input-group col-sm-10 col-xs-6">
					<input class="form-control" type="text" name="ConsultarRol">
					  <input type="submit" class="input-group-addon btn btn-info" name="ConsultarRol" value="ConsultarRol">
					  <input type="submit" class="input-group-addon btn btn-success" name="LimpiarFiltro" value="Limpiar Filtro"> 	
				</div>
			</div>
		</div>
	</div>	
	  <div class=" mb-3 mt-4 row">
		<h2><span>Usuarios registrados en el sistema:</span></h2>
		<div class="mb-3" style="text-align: right">
			<!--<button type="submit" id="pdf" name="generate_pdfUSU" class="btn btn-primary"><i class="fa fa-pdf" aria-hidden="true"></i>
				Exportar PDF Ingreso usuarios
			</button>-->
			<button type="submit" id="pdf" name="generate_pdf" class="btn btn-primary"><i class="fa fa-pdf" aria-hidden="true"></i>
			Exportar PDF usuarios</button>
		</div>
		<div>
			<table class="table table-striped table-bordered table-hover">
				<thead>
				<tr>
					<th>IdUsuario</th>
					<th>Nombre</th>
					<th>Rol</th>
					<th style="width: 25%;" >Administrar</th>
				</tr>	
				</thead>
				<tbody>
					<?php 
					foreach ($lstresultados as $resultado):?>
					<tr>
						<td><?php echo $resultado["id"];?></td>
						<td><?php echo $resultado["Usuario"];?></td>
						<td><?php echo $resultado["Tipo"];?></td>
						<td><a href="../Admin/ActualizaAdmin.php?id=<?php echo $resultado["id"];?>" class="btn btn-warning" id="">Actualizar</a> <a onclick="valida(event);" href="../Admin/Admin.php?idElim=<?php echo $resultado["id"];  ?>" class="btn btn-danger" id="">Eliminar</a></td>
					</tr> 
					<?php endforeach;
					 ?>
				</tbody>			
			</table>
		</div>
	</div>
	<div class="mb-3 row">
		<h3>Lista de citas reservadas</h3>
		<div>
			<table class="mt-3 table table-striped table-bordered table-hover">
				<thead>
				<tr>
					<th>IdReserva</th>
					<th>Nombre</th>
					<th>Correo</th>
					<th>Teléfono</th>
					<th>estado</th>
					<th>Administrar</th>
				</tr>	
				</thead>
				<tbody>
					<?php 
					for($i=0;$i<count($lstReserva);$i++){?>
					<tr>
						<td><?php echo $lstReserva[$i]["idreserva"];?></td>
						<td><?php echo $lstReserva[$i]["nombre"];?></td>
						<td><?php echo $lstReserva[$i]["correo"];?></td>
						<td><?php echo $lstReserva[$i]["telefono"];?></td>
						<td><?php echo $lstReserva[$i]["estado"];?></td>
						
						<td><a href="../Cliente/citas.php?id=<?php echo $lstReserva[$i]["idreserva"];?>" class="btn btn-warning" id="">Ir a citas</a> <a onclick="valida(event);" href="../Admin/Admin.php?idCancel=<?php echo $lstReserva[$i]["idreserva"];  ?>" class="btn btn-danger" id="">Eliminar</a></td>
					</tr> 
					<?php }?>
				</tbody>			
			</table>
		</div>
	</div>
</form>