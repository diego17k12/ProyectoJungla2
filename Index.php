<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link rel="stylesheet" type="text/css" href="../Styles/Globales.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

	<script src="../Scripts/General.js"></script>
</head>
<body>
<?php 
	include("config.php");
?>
<header>
	<img src="../Recursos/jungla.jpg" width="15%">
</header>
<nav>
	<ul>
		<li><a href="../Principal/Principal.php">Inicio</a></li>
		<li><a href="../Principal/Nosotros.php">Nosotros</a></li>
		<li><a href="../Principal/Servicios.php">Servicios</a></li>
		<!--<li><a href="../Principal/contactenos.php">Contactenos</a></li>-->
		<li><a href="../Login/Login.php">Ingresar</a></li>
	</ul>	
</nav>
</body>

<script type="text/javascript">
	//debo crear una manera de llamar la pagina del login ya que si entran en esta deberia redireccionar
	/*$(document).ready(function(){
		var pagina = window.location.href;
		var NomPag = pagina.substring(pagina.lastIndexOf("/"));
		if(NomPag != "" && NomPag != null && (NomPag === "/index.php" || NomPag == "/"))
		{
			//window.location.href = "../Principal/Principal.php";
			window.location.href = "./Principal/Principal.php";
		}/*
	});*/
</script>
</html>
