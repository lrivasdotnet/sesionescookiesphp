<?php
require_once("tcpdf/tcpdf.php");
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo_example.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, 'REPORTE DE ESTUDIANTES', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página  '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Luis Rivas');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', 'BI', 12);

// add a page
$pdf->AddPage();

// set some text to print
include_once("ClaseEstudiantes.php");
$objeto = new ClaseEstudiantes();
$filtro = "";
if(isset($_GET["filtro"])){
    $filtro = $_GET["filtro"];
}

$html = "<table style=\"width:600px;border:solid 1px;\">
<tr>
  <td width=\"20px\">#</td>
  <td width=\"80px\">Carnet</td>
  <td width=\"250px\">Nombre</td>
  <td width=\"250px\">Apellido</td>
</tr>";
$resultado = $objeto->obtenerEstudiantes($filtro);
if($resultado->rowCount()){
    $i=0;
    while ($cadaFila = $resultado->fetch(PDO::FETCH_ASSOC)){
      $i++;
      $html .= "
      <tr>
        <td>$i</td>
        <td>$cadaFila[carnet]</td>
        <td>$cadaFila[nombre]</td>
        <td>$cadaFila[apellido]</td>
      </tr>
      ";
    }
}
$html .= "</table>";
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('example_003.pdf', 'I');
?>
