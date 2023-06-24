<?php include("../Index.php");
 
 //inGRESAR DATOS DE tabla cita
 if (isset($_POST['Ingresar']))
 { 
    $sql = "insert into citas(IdCitas,fechaCitas,id_Mascota,id_Veterinario,TipoServicio)values(NULL,:Fechacita,:IdMascotas,:IdVete,:tipoServicio)";
   $statement = $conexion->prepare($sql);
   $statement->bindValue('Fechacita',$_POST["fecha"]);
   $statement->bindValue('IdMascotas',$_POST["mascotas"]);
   $statement->bindValue('IdVete',$_POST["doctor"]);
   $statement->bindValue('tipoServicio',$_POST["servicio"]);
   $statement->execute();
 }

//seleccionar de bd las masotas para poblar el select, esto debe ser solo con la mascota que perteneza a la persona
    $slqmas = "SELECT id_Mascota,Nombre FROM mascota where idCliente = :idcliente";
    $sentencia = $conexion->prepare($slqmas);
    $sentencia->bindValue('idcliente',$_GET["idCliente"]);
    $sentencia->execute();
    $resultadomas =  $sentencia->fetchAll();

//selecciona todos los veterinarios disponibles.
    $slqdoc = "SELECT id_Asis,Nombre,Apellido FROM veterinario ";
    $sentencia2 = $conexion->prepare($slqdoc);
    $sentencia2->execute();
    $resultadodoc =  $sentencia2->fetchAll();


//selecciona todas las citas que tiene actualmente reservadas
    $sql= "SELECT c.idCitas,m.Nombre, DATE(c.fechaCitas) fecha,TIME(c.fechaCitas) hora,c.TipoServicio
    FROM citas c
    join mascota m
    on m.id_Mascota=c.id_Mascota
    where m.Idcliente =".$_GET["idCliente"];
    $statement = $conexion->prepare($sql);
    $statement->execute();
    $result =  $statement->fetchAll();
    
    if (isset($_GET['ideliminar'])){
        $sql = "delete from citas 
        where idCitas= :id";
        $statement = $conexion->prepare ($sql);
        $statement->bindValue('id',$_GET['ideliminar']);
        $statement->execute();
        //redireccionar la pagina para que automaticamente se recargue la tabla
        header('Location: ../Cliente/citas.php?idCliente='.$_GET["idCliente"].'&idusu='.$_GET["idusu"]);
    }
?>
<!--<h2>consultar disponiblidad</h2>-->
<form action="" method="POST">
    <div class="container-fluid">
        <h1>Agendar citas</h1>
        <div class="mb-3 row">
            <div class="col-sm-12">
                <a class="btnLogOut btn btn-danger" href="../Cliente/Cliente.php?id=<?php echo $_GET["idusu"];?>">Regresar a usuario</a>    
            </div>
        </div>
        <div class="mb-3 row">
            <label class="form-label col-sm-2">Fecha: </label>
            <div class="col-sm-10">
                <input name="fecha" class="form-control" type="datetime-local">
            </div>
        </div>
        <br>
        <!--<button name="consultar" type="submit">consultar</button>-->
        <div class="mb-3 row">
            <label class="control-label col-sm-2">Seleccionar mascotas: </label>
            <div class="col-sm-4">
                <select name="mascotas" class="form-control" id="">
                    <option value="">seleccione</option>
                    <?php for($i=0;$i<count($resultadomas);$i++)
                    {
                        echo "<option value='".$resultadomas[$i]["id_Mascota"]."'>".$resultadomas[$i]["Nombre"]."</option>";    
                    }
                    ?>
                </select>
            </div>
             <label class="control-label col-sm-2">Tipo servicio: </label>  
             <div class="col-sm-4">
                <select name="servicio" class="form-control" id="">
                    <option value="">seleccione</option>
                    <option value="peluqueria">peluqueria</option>
                    <option value="vacunacion">vacunación</option>
                    <option value="esterilizacion">esterilización</option>
                </select>     
             </div>
        </div>
        <div class="mb-3 row">
            <label class="form-label col-sm-2">Nombre de doctor: </label>
            <div class="col-sm-10">       
                <select name="doctor" class="form-control" id="">
                    <option value="">seleccione</option>
                    <?php for($i=0;$i<count($resultadodoc);$i++)
                    {
                        echo "<option value='".$resultadodoc[$i]["id_Asis"]."'>".$resultadodoc[$i]["Nombre"]." ".$resultadodoc[$i]["Apellido"]."</option>";    
                    }
                    ?>
                </select>
            </div>
        </div>
        <button class="btn btn-success" name="Ingresar" type="submit">Agendar</button>

        <table class="mt-3 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Número de cita</th>
                    <th>Mascota</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Servicio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php for($i=0;$i<count($result);$i++){
                    echo "
                    <tr>
                        <td>".$result[$i]['idCitas']."</td> 
                        <td>".$result[$i]['Nombre']."</td> 
                        <td>".$result[$i]['fecha']."</td> 
                        <td>".$result[$i]['hora']."</td> 
                        <td>".$result[$i]['TipoServicio']."</td> 
                        <td>
                        <a class='btn btn-danger' onclick='valida(event);' href='../Cliente/citas.php?ideliminar=".$result[$i]["idCitas"]."&idCliente=".$_GET["idCliente"]."&idusu=".$_GET["idusu"]."'>Cancelar</a>
                        </td> 
                    </tr>
                    ";
                }?>
            </tbody>
        </table>
    </div>
</form>






