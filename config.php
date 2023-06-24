<?php 
$host 	   = "localhost";
$usuariobd = "root";
$password  = "";
$nombrebd  = "veterinaria";
$dsn  	   = "mysql:host=$host;dbname=$nombrebd";

try{
	$conexion = new PDO($dsn,$usuariobd,$password);
}
catch(PDOException $error){
	echo $error->getMessage();
}

//esta es otra opción de como se puede hacer la construcción para la conexión a bd

Class dbConexion{
	/* Variables de conexion */
	var $dbhost = "localhost";
	var $username = "root";
	var $password = "";
	var $dbname = "veterinaria";
	var $conn;
	//Funcion de conexion MySQL
	function getConexion() {
		$con = mysqli_connect($this->dbhost, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());

		/* Reviso la conexion */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		} else {
			$this->conn = $con;
		}
		return $this->conn;
	}
}
?>