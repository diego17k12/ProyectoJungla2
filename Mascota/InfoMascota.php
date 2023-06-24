<?php include("../Index.php");


//se consultan las mascotas registradas por el usuario, esto para poblar la tabla 
$sql = "select id_Mascota,Nombre,IdCliente,Tipo_Mascota,Raza 
        from Mascota where idCliente = :idClien";
$sentencia = $conexion->prepare($sql);
$sentencia->bindValue('idClien',$_GET["idCliente"]);
$sentencia->execute();
$resultado= $sentencia-> fetchAll();


if (isset($_POST['enviar'])){
    $sql = "insert into mascota (Nombre,IdCliente,Tipo_Mascota,Raza) values (:Nombre,:Cliente,:TMascota,:Raza)"; //aqui se asignan las variable(nombre, tipo, etc)

    $statement = $conexion->prepare($sql); 
       $statement->bindValue('Nombre',$_POST["Nombredemascota"]); // aqui las variable se crean
       $statement->bindValue('TMascota',$_POST["Tipodemascota"]);
       $statement->bindValue('Cliente',$_GET["idCliente"]);
       $statement->bindValue('Raza',$_POST["Razademascota"/**aqui se capturan los datos que se envian en el formulario */]);
       $statement->execute();
       header("Location: ../Mascota/InfoMascota.php?idCliente=".$_GET["idCliente"]."&idusu=".$_POST["idusuario"]);
}

if(isset($_GET["idElim"]))
{
    $sql = "Delete from mascota where id_Mascota = :idelim";
    $sentencia = $conexion->prepare($sql);
    $sentencia->bindValue("idelim",$_GET["idElim"]);
    $sentencia->execute();
    header("Location: ../Mascota/InfoMascota.php?idCliente=".$_GET["idCliente"]."&idusu=".$_GET["idusu"]);
}

?>
<form method="POST" action="" class="container-fluid">
    <div class="mb-3 row">
        <div class="col-sm-12">
            <a class="btnLogOut btn btn-danger" href="../Cliente/Cliente.php?id=<?php echo $_GET["idusu"];?>">Regresar a cliente </a>    
        </div>
    </div>
    <div class="mb-3 mt-5 row">
        <label class="form-label col-sm-2">Nombre: </label>
        <div class="col-sm-4"> 
            <input type="text" class="form-control" name= "Nombredemascota" placeholder="Nombre de mascota">
        </div>

        <label class="form-label col-sm-2">Tipo de mascota: </label> 
        <div class="col-sm-4">
            <input type="text" name= "Tipodemascota" class="form-control" placeholder="Tipo de mascota">
        </div>
    </div>
    <div class="mb-3 row">
        <label class="form-label col-sm-2">Raza de mascota: </label>    
        <div class="col-sm-10">
            <input type="text" name= "Razademascota" class="form-control" placeholder="Raza de mascota">   
        </div>
    </div> 
    <input type="hidden" name="idusuario" value="<?php echo $_GET["idusu"] ?>">
    <div class="mb-3">
        <button type="submit" class="btn btn-success" name="enviar"> 
            Ingresar Información 
        </button>    
    </div> 
    
    <table class="mb-6 table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Id Mascota</th>
            <th>Nombre Mascota</th>
            <th>Tipo de Macota</th>
            <th>Raza de  Mascota</th>
            <th>Administar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for ($i=0;$i<count($resultado);$i++){
            echo "  <tr>
            <td>".$resultado[$i]['id_Mascota']."</td>
            <td>".$resultado[$i]['Nombre']."</td>
            <td>".$resultado[$i]['Tipo_Mascota']."</td>
            <td>".$resultado[$i]['Raza']."</td>
            <td>
                <a class='btn btn-warning' href='../Mascota/ActualizaInfoMascota.php?idMascota=".$resultado[$i]["id_Mascota"]."&idusu=".$_GET["idusu"]."&idCliente=".$_GET["idCliente"]."' name='Actualizar'>
                    Actualizar 
                </a>
                <a class='btn btn-danger' name='borrar' onclick='valida(event);' href='../Mascota/InfoMascota.php?idElim=".$resultado[$i]["id_Mascota"]."&idCliente=".$_GET["idCliente"]."&idusu=".$_GET["idusu"]."'>
                Eliminar 
                </a>
            </td>
        </tr>";
        }
        ?>
    </tbody>
</table>
</form>


