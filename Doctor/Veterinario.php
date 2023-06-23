<?php include("../Index.php");

//se trae la información del veterinario
$sqlusuario = "SELECT v.id_Asis,v.Nombre,v.apellido,v.cedula,v.telefono,v.correo
                from usuario u
                join veteusu vu
                on u.Id = vu.id_usu
                join veterinario v
                on v.id_Asis = vu.id_veterinario
                where u.Id = :idusu";

$sentenciausu = $conexion->prepare($sqlusuario);
$sentenciausu->bindValue('idusu',$_GET["id"]);
$sentenciausu->execute();
$resultadousu= $sentenciausu-> fetch();


//se traen las citas asignadas al veterinario
$sql = "select c.idCitas,cl.nombre,m.Nombre,c.fechaCitas,c.TipoServicio 
        from citas c 
        JOIN mascota m 
        on m.id_Mascota=c.id_Mascota 
        join cliente cl 
        on cl.id_usuario=m.Idcliente
        where c.id_veterinario = :idveterinario;";
$sentencia = $conexion->prepare($sql);
$sentencia->bindValue('idveterinario',$resultadousu["id_Asis"]);
$sentencia->execute();
$resultado= $sentencia-> fetchAll();

if (isset($_GET['idElim']))
{
    $sql= "delete from citas where idCitas = ".$_GET['idElim'];
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute();
    header('Location: ../Doctor/Veterinario.php');
}
?>
<form action="" class="container-fluid" method="POST">
    <a class="btnLogOut btn btn-danger" href="../Login/Login.php">Cerrar Session</a> 
    <h1>
        Mis citas
    </h1>
    <div class="mb-6 mt-3 row">
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                Información del veterinario
              </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
                <div class="row">
                    <label class="form-label col-sm-6">Nombre : <?php echo $resultadousu["Nombre"]. " ". $resultadousu["apellido"]?>
                    </label>    

                    <label class="form-label col-sm-6">Cédula : <?php echo $resultadousu["cedula"]?>
                    </label>    
                </div>
                <div class="row">
                    <label class="form-label col-sm-6">Teléfono : <?php echo $resultadousu["telefono"]?>
                    </label>
                     <label class="form-label col-sm-6">correo : <?php echo $resultadousu["correo"]?>
                    </label>
                </div>      
               </div>
            </div>
           </div>
        </div>
    </div>
    <table class="mt-4 table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>
                Id Cita
            </th>
            <th>
                Cliente
            </th>
            <th>
                Mascota
            </th>
            <th>
                Fecha Cita
            </th>
            <th>
                Tipo Servicio
            </th>
            <th>
                Acciones 
            </th>
        </tr>
    </thead>
    <tbody>
        <?php for ($i=0;$i<count($resultado);$i++) {
            echo "
        <tr>
            <td>
           ". $resultado[$i]["idCitas"].
            "</td>
            <td>".$resultado[$i]["nombre"].
            "</td>
            <td>".$resultado[$i]["Nombre"].
            "</td>
            <td>".$resultado[$i]["fechaCitas"].
            "</td>
            <td>".$resultado[$i]["TipoServicio"].
            "</td>
            <td>
            <a class='btn btn-danger' name='borrar' onclick='valida(event);' href='../Doctor/Veterinario.php?idElim=".$resultado[$i]["idCitas"]."'>
            Eliminar 
            </a>
            </td>
        </tr>"; 
        }?>
    </tbody>
    </table>
</form>

