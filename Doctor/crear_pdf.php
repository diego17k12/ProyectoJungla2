<?php
//Incluimos el fichero de conexion
include("../Index.php");
//Incluimos la libreria PDF
include_once('../Pdfs/fpdf/fpdf.php');

class PDF extends FPDF
{
	// Funcion encargado de realizar el encabezado
	function Header()
	{
		// Logo
		//$this->Image('logo.jpg',10,-1,70);
		$this->SetFont('Arial','B',13);
		// Move to the right
		$this->Cell(80);
		// Title
		$this->Cell(95,10,'Clientes hoy',1,0,'C');
		// Line break
		$this->Ln(20);
	}
	// Funcion pie de pagina
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}
//SE obtienen los datos que se enviaron desde el filtro
$filtro = $_GET["filtrocampo"];

$db = new dbConexion();
$connString = $db->getConexion();
$display_heading = array('id_usuario'=>'ID', 'cedula' => 'cedula','nombre'=> 'Nombre', 'apellido'=> 'apellido','telefono'=> 'telefono','direccion'=> 'direccion',);

$result = "";
//se valida el filtro para realizar la respectiva consulta en la BD
if($filtro == "")
{
	$result = mysqli_query($connString, "SELECT c.id_usuario, c.cedula,c.nombre,c.apellido,c.telefono,c.direccion FROM cliente c join veterinario v on c.id_Asis = v.id_Asis") or die("database error:". mysqli_error($connString));	
}else
{
	$result = mysqli_query($connString, "SELECT c.id_usuario, c.cedula,c.nombre,c.apellido,c.telefono,c.direccion FROM cliente c join veterinario v on c.id_Asis = v.id_Asis where c.nombre LIKE '%".$filtro."%'") or die("database error:". mysqli_error($connString));	
}

$header = mysqli_query($connString, "SHOW columns FROM cliente");

$pdf = new PDF();

//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);
// Declaramos el ancho de las columnas
$w = array(30, 50, 40, 30,30);
//Declaramos el encabezado de la tabla
$pdf->Cell(30,12,'Cedula',1);
$pdf->Cell(50,12,'Nombre',1);
$pdf->Cell(40,12,'Apellido',1);
$pdf->Cell(30,12,'Telefono',1);
$pdf->Cell(30,12,'Direccion',1);
$pdf->Ln();
$pdf->SetFont('Arial','',12);
//Mostramos el contenido de la tabla
foreach($result as $row)
{
$pdf->Cell($w[0],6,$row['cedula'],1);
$pdf->Cell($w[1],6,$row['nombre'],1);
$pdf->Cell($w[2],6,$row['apellido'],1);
$pdf->Cell($w[3],6,number_format($row['telefono']),1);
$pdf->Cell($w[3],6,$row['direccion'],1);
$pdf->Ln();
}
/* Limpiamos la salida del búfer y lo desactivamos */
ob_end_clean();
$pdf->Output('Reporte.pdf','I');
?>