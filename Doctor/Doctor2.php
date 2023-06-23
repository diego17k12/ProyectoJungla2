
<?php include("../Index.php");
$filtro = "";
//id que se trae desde la interfaaz de login este id se usa para saber cual doctor ingreso y así poder filtrar los clientes asignados a el.
$idDoctor = $_GET["id"];
	//tabla en la que se encuentre la información de la persona de la mascota que va a ser atendida
	//recordar que el form no se debe quitar si quiero hacer una peticón a una acción se debe comprobar desde cual boton se hacer y hacer la respeciva validación
	//para eso uso $_POST['generate_pdf']) 
	if(isset($_POST['generate_pdf']))
	{
		//se encarga de redireccioar a la pagina que se encarga de generar el pdf de reporte
		header('Location: crear_pdf.php?filtrocampo='.$_POST['Filtro']);
	}

	if(isset($_POST['Consultar']))
	{
		$sql= "SELECT c.id_usuario,c.cedula, c.nombre,c.apellido,c.telefono,c.direccion 
				FROM cliente c
				join veterinario v
				on c.id_Asis = v.id_Asis
				WHERE 1=1 
				and v.id_Asis = ".$idDoctor."
				and c.nombre like '%".$_POST['Filtro']."%'";
		
		$filtro = $_POST['Filtro'];
	}else
	{
		//se debe fltrar por el id del doctor con esto traera todos los clientes que tenga asignados
		$sql= "SELECT c.id_usuario,c.cedula, c.nombre,c.apellido,c.telefono,c.direccion 
				FROM cliente c
				join veterinario v
				on c.id_Asis = v.id_Asis
				WHERE 1=1
				and v.id_Asis = ".$idDoctor;
	}
	try{
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
	}catch(PDOException $error){
		echo $error->getMessage();
	}

    if($statement->rowCount() == 0){
    	 echo '<p class="error">no hay registros que coincida</p>';
    }

    //este metodo se usa desde la pagina de doctor2.php para elimianr un registro de la bd 
	if(isset($_GET['id']))
	{

	$eliminar = $_GET["id"];
	echo "eliminemos" . $eliminar;
	//insertar datos en la tabla
			$sql= "DELETE FROM cliente
					where id_usuario = :id";
			
				$statement = $conexion->prepare($sql);
				$statement->bindValue('id',$_GET["id"]);
				$statement->execute();
	header('Location: ../Doctor/Doctor.php');
	exit;
	}
//crud para ver los clientes que tiene para atender
?>
<script type="text/javascript" src="../Scripts/Doctor.js"></script>
<style type="text/css">
th{
	text-align: center;
}
</style>
<div class="container-fluid">
	<form method="post" action="" class="form-horizontal">
		<div class="mb-3" style="margin-top: 30px; text-align: right;">
			<a class="btn btn-danger" href="../Login/Login.php">Cerrar Session</a>
		</div>
		<div class="form-control">
			<div class="card">
				<div class="card-header" class="btn btn-link" data-bs-toggle="collapse" href="#Filtro" role="button" aria-expanded="false" aria-controls="Filtro">
					<a >Filtros</a>
				</div>
				<div id="Filtro" class="collapse" aria-labelledby="headingOne">
					<div class="form-control">
						<label class="col-sm-6 col-xs-6">filtro nombre:</label>
						<div class="input-group col-sm-6 col-xs-6">
							<input class="form-control" type="text" name="Filtro" value="<?php echo $filtro ?>">
							  <input type="submit" class="input-group-addon btn btn-info" name="Consultar" value="Consultar">
							  <input type="submit" class="input-group-addon btn btn-success" name="LimpiarFiltro" value="Limpiar Filtro"> 	
						</div>
					</div>
				</div>
			</div>	
			  <div class="mb-3">
				<div class="" id="exportarPDF">
					<div class="mb-3">
			 			<h2><span>Clientes hoy</span></h2>
			 			<div style="text-align: right">
							<button type="submit" id="pdf" name="generate_pdf" class="btn btn-primary"><i class="fa fa-pdf" aria-hidden="true"></i>
							Exportar PDF</button>
			 			</div>
					</div>
				</div>
				<table class="table table-striped table-bordered table-hover dataTable no-footer" id="tblClientes">
					<thead>
					<tr>
						<th>Cedula</th>
						<th>Nombre</th>
						<th>Apellido</th>
						<th>Telefono</th>
						<th>Dirección</th>
						<th style="width: 17%;" >Administrar</th>
					</tr>	
					</thead>
					<tbody>
						<?php foreach ($lstresultados as $resultado):?>
						<tr>
							<td><?php echo $resultado["cedula"];?></td>
							<td><?php echo $resultado["nombre"];?></td>
							<td><?php echo $resultado["apellido"];?></td>
							<td><?php echo $resultado["telefono"];?></td>
							<td><?php echo $resultado["direccion"];?></td>
							<td><div style="text-align: right;"><a href="../Cliente/ActualizarCliente.php?idusuario=<?php echo $resultado["id_usuario"];?>&iddoctor=<?php echo $idDoctor;?>" class="btn btn-warning" id=""><span class="glyphicon glyphicon-collapse-up"> </span>Actualizar</a> <a onclick="valida(event);" href="../Doctor/doctor2.php?id=<?php echo $resultado["id_usuario"];  ?>" class="btn btn-danger" id=""><span class="glyphicon glyphicon-collapse-up"> </span>Eliminar</a></div></td>
						</tr> 
						<?php endforeach; ?>
						
					</tbody>			
				</table>
			</div>
		</div>
	</form>
</div>
