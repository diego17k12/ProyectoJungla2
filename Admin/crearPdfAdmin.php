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

//se realiza la consulta a BD buscando un resultado para mostrar
$sql = "select c.idCitas,cl.nombre,cl.apellido,m.Nombre,c.fechaCitas,c.TipoServicio 
        from citas c 
        JOIN mascota m 
        on m.id_Mascota=c.id_Mascota 
        join cliente cl 
        on cl.id_usuario=m.Idcliente
        where c.id_veterinario = ".$_GET["idvete"].";";

$result = mysqli_query($connString,$sql) or die("database error:". mysqli_error($connString));
//con esto se puede traer el nombre exacto como esta en la base de datos
//$header = mysqli_query($connString, "SHOW columns FROM cliente");

$pdf = new PDF();
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);
// Declaramos el ancho de las columnas 
$w = array(40, 50, 50, 40);
//Declaramos el encabezado de la tabla
$pdf->Cell($w[0],12,'Nombre mascota',1);
$pdf->Cell($w[1],12,'Nombre cliente',1);
$pdf->Cell($w[2],12,'Fecha Cita',1);
$pdf->Cell($w[3],12,'Tipo De Servicio',1);
$pdf->Ln();
$pdf->SetFont('Arial','',12);
//Mostramos el contenido de la tabla
foreach($result as $row)
{
	$pdf->Cell($w[0],6,$row['Nombre'],1);
	$pdf->Cell($w[1],6,$row['nombre']." ".$row['apellido'],1);
	$pdf->Cell($w[2],6,$row['fechaCitas'],1);
	$pdf->Cell($w[3],6,$row['TipoServicio'],1);
	/*$pdf->Cell($w[3],6,number_format($row['telefono']),1);
	$pdf->Cell($w[3],6,$row['direccion'],1);*/
	$pdf->Ln();
}
/* Limpiamos la salida del búfer y lo desactivamos */
ob_end_clean();
$pdf->Output('Reporte.pdf','I');
?>