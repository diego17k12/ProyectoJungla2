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


$db = new dbConexion();
$connString = $db->getConexion();
$display_heading = array('id_usuario'=>'ID', 'cedula' => 'cedula','nombre'=> 'Nombre', 'apellido'=> 'apellido','telefono'=> 'telefono','direccion'=> 'direccion',);

//se realiza la consulta a BD buscando un resultado para mostrar
$result = mysqli_query($connString, "SELECT id,Usuario,Tipo
					   FROM Usuario") or die("database error:". mysqli_error($connString));
$header = mysqli_query($connString, "SHOW columns FROM cliente");

$pdf = new PDF();

//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);
// Declaramos el ancho de las columnas
$w = array(30, 80, 80);
//Declaramos el encabezado de la tabla
$pdf->Cell(30,12,'Id',1);
$pdf->Cell(80,12,'Usuario',1);
$pdf->Cell(80,12,'Tipo',1);
$pdf->Ln();
$pdf->SetFont('Arial','',12);
//Mostramos el contenido de la tabla
foreach($result as $row)
{
$pdf->Cell($w[0],6,$row['id'],1);
$pdf->Cell($w[1],6,$row['Usuario'],1);
$pdf->Cell($w[2],6,$row['Tipo'],1);
/*$pdf->Cell($w[3],6,number_format($row['telefono']),1);
$pdf->Cell($w[3],6,$row['direccion'],1);*/
$pdf->Ln();
}
/* Limpiamos la salida del búfer y lo desactivamos */
ob_end_clean();
$pdf->Output('Reporte.pdf','I');
?>