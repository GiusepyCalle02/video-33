<?php
require('fpdf181/fpdf.php');

class PDF extends FPDF
{
	function Header()
	{
		global $titulo;

		// Arial bold 15px 15puntos
		$this->SetFont('Arial','B',15);
		// Calculamos ancho y posición del título.
		$w = $this->GetStringWidth($titulo)+10;
		//Centramos en un ancho de 210 = 21.6cm = 8.5in
		$this->SetX((210-$w)/2);
		// Colores de los bordes, fondo y texto RGB
		$this->SetDrawColor(0,80,180);
		$this->SetFillColor(230,230,0);
		$this->SetTextColor(220,50,50);
		// Ancho del borde 1 = 10 mm
		$this->SetLineWidth(1);
		// Título, ancho, alto, texto, borde, ln, align, fondo
		//milimetros
		$this->Cell($w,9,$titulo,1,1,'C',true);
		// Salto de línea 10 = 1cm
		$this->Ln(10);
	}

	function Footer()
	{
		// Posición a 1,5 cm del final
		$this->SetY(-15);
		// Arial itálica 8
		$this->SetFont('Arial','I',8);
		// Color del texto en gris RGB
		$this->SetTextColor(128);
		// Número de página
		$this->Cell(0,10,'Página '.$this->PageNo(),0,0,'C');
	}

	function CapituloTitulo($num, $label)
	{
		// Arial 12
		$this->SetFont('Arial','',12);
		// Color de fondo RGB
		$this->SetFillColor(200,220,255);
		// Título
		$this->Cell(0,6,"Capítulo $num : $label",0,1,'L',true);
		// Salto de línea
		$this->Ln(4);
	}

	function CapituloTexto($archivo)
	{
		// Leemos el fichero
		$txt = file_get_contents($archivo);
		// Times 12
		$this->SetFont('Times','',12);
		// Imprimimos el texto justificado
		$this->MultiCell(0,5,$txt);
		// Salto de línea
		$this->Ln();
		// Cita en itálica
		$this->SetFont('','I');
		//w=0, h=5
		$this->Cell(0,5,'(fin del extracto)');
	}

	function CapituloImprime($num, $titulo, $archivo)
	{
		$this->AddPage();
		$this->CapituloTitulo($num,$titulo);
		$this->CapituloTexto($archivo);
	}
}

$pdf = new PDF();
$titulo = '20000 Leguas de Viaje Submarino';
$pdf->SetTitle($titulo);
$pdf->SetAuthor('Julio Verne');
$pdf->CapituloImprime(1,'UN RIZO DE HUIDA','20k_c1.txt');
$pdf->CapituloImprime(2,'LOS PROS Y LOS CONTRAS','20k_c2.txt');
$pdf->Output();
?>