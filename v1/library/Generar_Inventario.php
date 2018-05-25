<?php
include('tcpdf/tcpdf.php');

class Generar_Inventario extends TCPDF
{
	
	function Header() 
	{
		/*$this->SetFont('Arial', '', 10);			
		$html = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="100%" align="left"><img src="../../public/images/SobreFactura.jpg" width="624px" alt="SANBEL" /></td>
				</tr>				
				</table>';		
		$this->writeHTML($html, true, false, true, false, '');*/
	}
	
	function Footer() 
	{
		$this->SetY(-10);
		//Arial italic 8
		$this->SetFont('Times','BI',10);
		//Número de página
		$this->Cell(0,10,utf8_decode('Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages()),0,0,'C');
		//$this->Ln(6);	
	}	

	function Generar_Inventario_Total_Costo ($desde, $hasta, $mensaje="")
	{
		$pdf = new Generar_Inventario('L', 'mm', 'LETTER', false, 'ISO-8859-1', false);		

		$pdf->SetProtection($permissions=array( 'modify', 'annot-forms', 'fill-forms', 'extract', 'assemble', 'print-high', 'owner' ), $user_pass='', $owner_pass=null, $mode=0, $pubkeys=null);

		$pdf->SetDisplayMode('fullpage','continuous');

		$pdf->SetCreator('INNOVATIONS PRINT');
		$pdf->SetAuthor('INNOVATIONS PRINT');
		$pdf->SetTitle('INNOVATIONS PRINT Inventario de Productos en Costo');
		$pdf->SetSubject('Inventario de Productos en Costo');
		$pdf->SetKeywords('Inventario de Productos en Costo');

		$pdf->setHeaderFont(Array('times', '', PDF_FONT_SIZE_MAIN));		
		//$pdf->setFooterFont(Array('helvetica', '', PDF_FONT_SIZE_DATA));		
		
		$pdf->SetMargins('6.4', '12.7', '6.4');
		//$pdf->SetHeaderMargin('0', '0', '101.6');
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetAutoPageBreak(TRUE, '12.7');

		//$pdf->setLanguageArray($l);
		
        //$pdf->AliasNbPages();
		
		$pdf->AddPage();

		$pdf->SetFont('Arial', '', 10);

		$html = '<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-size:10;">
					<tr>
						<td width="100%" height="39px" align="center" style="font-size:24;" >Total Costo de Inventario de Art&iacute;culos
						</td>
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-size:10;">
					<tr>					
						<td width="4%" align="center" style="font-size:10;"><strong>#</strong>
						</td>						
						<td width="20%" align="center" style="font-size:10;"><strong>Descripci&oacute;n de Categor&iacute;a</strong>
						</td>						
						<td width="21%" align="center" style="font-size:10;"><strong>Nombre de Proveedor</strong>
						</td>
						<td width="15%" align="center" style="font-size:10;"><strong>C&oacute;digo de Producto</strong>
						</td>						
						<td width="10%" align="center" style="font-size:10;"><strong>Balance en Bodega</strong>
						</td>
						<td width="10%" align="center" style="font-size:10;"><strong>Balance en Tienda</strong>
						</td>
						<td width="10%" align="center" style="font-size:10;"><strong>Balance en Inventario</strong>
						</td>
						<td width="10%" align="center" style="font-size:10;"><strong>Balance en Total Costo</strong>
						</td>						
					</tr>';
					$c = 0;
					while ($c < count($mensaje[0]))
					{	
						$html .= '<tr><td width="4%" height="20px"  style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.($c+1).'</td>';
						$html .= '<td width="20%" align="center" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.$mensaje[3][$c].'</td>';						
						$html .= '<td width="21%" align="center" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.$mensaje[0][$c].'</td>';
						$html .= '<td width="15%" align="center" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.$mensaje[1][$c].'</td>';						
						$html .= '<td width="10%" align="center" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.$mensaje[2][$c].'</td>';
						$html .= '<td width="10%" align="center" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.$mensaje[4][$c].'</td>';
						$html .= '<td width="10%" align="center" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.$mensaje[5][$c].'</td>';	
						$html .= '<td width="10%" align="center" style="font-size:10;border-bottom: 1px solid black;">'.$mensaje[6][$c].'</td>';						
						$html .= '</tr>';
						
						$c++;
					}				
					
						$html .= '<tr><td width="90%" height="20px"  style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;" colspan="8" align="right"><strong>TOTAL:&nbsp;</strong></td>';	
						$html .= '<td width="10%" align="center" style="font-size:10;border-bottom: 1px solid black;"><strong>'.$mensaje[7].'</strong></td>';						
						$html .= '</tr>';					
		$html .= '
				</table>
				';	
		
		$pdf->writeHTML($html, true, false, true, false, '');			
		
		//Close and output PDF document
		$pdf->Output('../../tmp/Inventario_Producto_Total_Costo'.$desde.'.pdf', 'F');		
	}	
	
	function Generar_Inventario_Bodega ($desde, $hasta, $mensaje="")
	{
		$pdf = new Generar_Inventario('L', 'mm', 'LETTER', false, 'ISO-8859-1', false);		

		$pdf->SetProtection($permissions=array( 'modify', 'annot-forms', 'fill-forms', 'extract', 'assemble', 'print-high', 'owner' ), $user_pass='', $owner_pass=null, $mode=0, $pubkeys=null);

		$pdf->SetDisplayMode('fullpage','continuous');

		$pdf->SetCreator('SANBEL MUEBLES');
		$pdf->SetAuthor('SANBEL MUEBLES');
		$pdf->SetTitle('SANBEL MUEBLES Inventario de Articulos en Bodega');
		$pdf->SetSubject('Inventario de Articulos en Bodega');
		$pdf->SetKeywords('Inventario de Articulos en Bodega');

		$pdf->setHeaderFont(Array('times', '', PDF_FONT_SIZE_MAIN));		
		//$pdf->setFooterFont(Array('helvetica', '', PDF_FONT_SIZE_DATA));		
		
		$pdf->SetMargins('6.4', '12.7', '6.4');
		//$pdf->SetHeaderMargin('0', '0', '101.6');
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetAutoPageBreak(TRUE, '12.7');

		//$pdf->setLanguageArray($l);
		
        //$pdf->AliasNbPages();
		
		$pdf->AddPage();

		$pdf->SetFont('Arial', '', 10);

		$html = '<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-size:10;">
					<tr>
						<td width="100%" height="39px" align="center" style="font-size:24;" >Inventario de Art&iacute;culos en Bodega
						</td>
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-size:10;">
					<tr>					
						<td width="4%" align="center" style="font-size:10;"><strong>#</strong>
						</td>						
						<td width="32%" align="center" style="font-size:10;"><strong>Descripci&oacute;n de Categor&iacute;a</strong>
						</td>						
						<td width="32%" align="center" style="font-size:10;"><strong>Nombre de Proveedor</strong>
						</td>
						<td width="17%" align="center" style="font-size:10;"><strong>C&oacute;digo de Producto</strong>
						</td>						
						<td width="15%" align="center" style="font-size:10;"><strong>Balance en Bodega</strong>
						</td>					
					</tr>';
					$c = 0;
					while ($c < count($mensaje[0]))
					{	
						$html .= '<tr><td width="4%" height="20px"  style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.($c+1).'</td>';
						$html .= '<td width="32%" align="center" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.$mensaje[3][$c].'</td>';						
						$html .= '<td width="32%" align="center" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.$mensaje[0][$c].'</td>';
						$html .= '<td width="17%" align="center" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.$mensaje[1][$c].'</td>';						
						$html .= '<td width="15%" align="center" style="font-size:10;border-bottom: 1px solid black;">'.$mensaje[2][$c].'</td>';
						$html .= '</tr>';
						
						$c++;
					}				
					
					
		$html .= '
				</table>
				';	
		
		$pdf->writeHTML($html, true, false, true, false, '');			
		
		//Close and output PDF document
		$pdf->Output('../../tmp/Inventario_Bodega_Producto_'.$desde.'.pdf', 'F');		
	}
	
	function Generar_Inventario_Tienda ($desde, $hasta, $mensaje="")
	{
		$pdf = new Generar_Inventario('L', 'mm', 'LETTER', false, 'ISO-8859-1', false);		

		$pdf->SetProtection($permissions=array( 'modify', 'annot-forms', 'fill-forms', 'extract', 'assemble', 'print-high', 'owner' ), $user_pass='', $owner_pass=null, $mode=0, $pubkeys=null);

		$pdf->SetDisplayMode('fullpage','continuous');

		$pdf->SetCreator('SANBEL MUEBLES');
		$pdf->SetAuthor('SANBEL MUEBLES');
		$pdf->SetTitle('SANBEL MUEBLES Inventario de Articulos en Tienda');
		$pdf->SetSubject('Inventario de Articulos en Tienda');
		$pdf->SetKeywords('Inventario de Articulos en Tienda');

		$pdf->setHeaderFont(Array('times', '', PDF_FONT_SIZE_MAIN));		
		//$pdf->setFooterFont(Array('helvetica', '', PDF_FONT_SIZE_DATA));		
		
		$pdf->SetMargins('6.4', '12.7', '6.4');
		//$pdf->SetHeaderMargin('0', '0', '101.6');
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetAutoPageBreak(TRUE, '12.7');

		//$pdf->setLanguageArray($l);
		
        //$pdf->AliasNbPages();
		
		$pdf->AddPage();

		$pdf->SetFont('Arial', '', 10);

		$html = '<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-size:10;">
					<tr>
						<td width="100%" height="39px" align="center" style="font-size:24;" >Inventario de Art&iacute;culos en Tienda
						</td>
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-size:10;">
					<tr>					
						<td width="4%" align="center" style="font-size:10;"><strong>#</strong>
						</td>						
						<td width="32%" align="center" style="font-size:10;"><strong>Descripci&oacute;n de Categor&iacute;a</strong>
						</td>						
						<td width="32%" align="center" style="font-size:10;"><strong>Nombre de Proveedor</strong>
						</td>
						<td width="17%" align="center" style="font-size:10;"><strong>C&oacute;digo de Producto</strong>
						</td>						
						<td width="15%" align="center" style="font-size:10;"><strong>Balance en Tienda</strong>
						</td>					
					</tr>';
					$c = 0;
					while ($c < count($mensaje[0]))
					{	
						$html .= '<tr><td width="4%" height="20px" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.($c+1).'</td>';
						$html .= '<td width="32%" align="center" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.$mensaje[3][$c].'</td>';							
						$html .= '<td width="32%" align="center" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.$mensaje[0][$c].'</td>';
						$html .= '<td width="17%" align="center" style="font-size:10;border-bottom: 1px solid black; border-right: 1px solid black;">'.$mensaje[1][$c].'</td>';						
						$html .= '<td width="15%" align="center" style="font-size:10;border-bottom: 1px solid black;">'.$mensaje[2][$c].'</td>';
						$html .= '</tr>';
						
						$c++;
					}				
					
					
		$html .= '
				</table>
				';	
		
		$pdf->writeHTML($html, true, false, true, false, '');			
		
		//Close and output PDF document
		$pdf->Output('../../tmp/Inventario_Tienda_Producto_'.$desde.'.pdf', 'F');		
	}	
	
}

?>