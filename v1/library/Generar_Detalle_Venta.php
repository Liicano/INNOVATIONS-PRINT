<?php
include('tcpdf/tcpdf.php');

class Generar_Detalle_Venta extends TCPDF
{
	
	function Header() {

		//$hoy=date('Y-m-d');
		//$this->Image('../images/logo.jpg', 10, 1, 60, '', 'JPEG', '', 'C', false, 100, '', false, false, 0, false, false, false);
		//$this->Ln(8.89);

		//$objFecha =  new fecha();
		//$charhoy = $objFecha->converfecha($hoy);
		$this->SetFont('Arial', '', 10);			
		$html = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="50%" align="left"><img src="../../public/images/logo_mail_firma.jpg" width="200px" alt="INNOVATIONS PRINT" /></td>
					<td width="50%" align="left">&nbsp;</td>
				</tr>				
				<tr>
					<td width="50%" align="left"><span style="font-size:12px;">INNOVATIONS PRINT</span></td>
					<td width="50%" align="right" rowspan="2"><span style="font-size:18px; font-weight:bold;">DETALLE DE VENTA</span></td>
				</tr>
				<tr>
					<td width="50%" align="left"><span style="font-size:12px;">RUC 7-702-2407 DV 46</span></td>
					<td width="50%" align="left">&nbsp;</td>
				</tr>
				</table>';		
		
		//$html = '<div  align="center" style="font-family: times, serif; font-size: 32px; font-weight: bold;">';
		//$html.= 'GOLF IN PANAMA, S.A<br /><br />';
		//$html.= '<span  align="left" style="font-family: times, serif; font-size: 24px; font-weight: bold;">';
		//$html.= 'FECHA DEL PROCESO: </span></div>';
		$this->writeHTML($html, true, false, true, false, '');		
		
	}

	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-45);
		//Arial italic 8
		//$this->SetFont('Arial','I',8);
		//Número de página
		//$this->Cell(0,10,'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(),0,0,'C');
		//$this->Ln(6);	
		//$this->Cell(0,10,'Actualizado el '.date('d-m-Y').'.',0,0,'C');
		$this->SetFont('Arial', '', 10);			
		/*$html = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left"><strong>CUALQUIER SUGERENCIA O DUDAS EN CUANTO A LO COTIZADO NO DUDE EN ACERCASE A NUESTRAS OFICINAS.</strong></td>
					</tr>
					<tr>
						<td align="left">&nbsp;</td>
					</tr>						
					<tr>
						<td align="left"><strong>ESPERAMOS LA PROPUESTA SEA DE SU COMPLETO AGRADO.</strong></td>
					</tr>
					<tr>
						<td align="left">&nbsp;</td>
					</tr>					
					<tr>
						<td align="left"><span style="text-decoration: overline;"><strong>FIRMA DE APROBACION.</strong></span></td>
					</tr>					
				</table>';*/
				
		$html = '<table>
					<tr>
						<td colspan="4" align="left">POR FAVOR VERIFICAR Y CONTAR BIEN SUS PRODUCTOS ANTES DE RETIRARSE DE ESTE ESTABLECIMIENTO COMERCIAL&nbsp;</td>					
					</tr>
					<tr>
						<td colspan="4" align="left">&nbsp;</td>						
					</tr>					
					<tr>
						<td colspan="4" align="left">ESTE DOCUMENTO ES SOLO UNA CONSTANCIA DE LOS PRODUCTOS COMPRADOS, NO ES UNA FACTURA COMERCIAL&nbsp;</td>						
					</tr>
					<tr>
						<td colspan="4" align="left">&nbsp;</td>						
					</tr>						
					<tr>
						<td width="35%" align="left">GRACIAS POR PREFERIRNOS....&nbsp;</td>
						<td width="30%" align="left">____________________________&nbsp;</td>
						<td width="5%" align="left">&nbsp;</td>
						<td width="30%" align="left">____________________________&nbsp;</td>						
					</tr>
					<tr>
						<td width="35%" align="left">&nbsp;</td>
						<td width="30%" align="center">FIRMA&nbsp;</td>
						<td width="5%" align="left">&nbsp;</td>
						<td width="30%" align="center">C&Eacute;DULA&nbsp;</td>						
					</tr>					
				</table>';	
				
		$this->writeHTML($html, true, false, true, false, '');	
	
	}	
	
	function Generar_Detalle_Venta_Imprenta ($desde, $hasta, $mensaje="" )
	{

		$pdf = new Generar_Detalle_Venta('P', 'mm', 'LETTER', false, 'ISO-8859-1', false);		

		$pdf->SetProtection($permissions=array( 'modify', 'copy', 'annot-forms', 'fill-forms', 'extract', 'assemble', 'print-high', 'owner' ), $user_pass='', $owner_pass=null, $mode=0, $pubkeys=null);

		$pdf->SetDisplayMode('fullpage','continuous');

		$pdf->SetCreator('INNOVATIONS PRINT');
		$pdf->SetAuthor('INNOVATIONS PRINT');
		$pdf->SetTitle('INNOVATIONS PRINT Detalle de Ventas');
		$pdf->SetSubject('Detalle de Ventas');
		$pdf->SetKeywords('Detalle de Ventas');

		$pdf->setHeaderFont(Array('times', '', PDF_FONT_SIZE_MAIN));		
		//$pdf->setFooterFont(Array('helvetica', '', PDF_FONT_SIZE_DATA));		
		
		$pdf->SetMargins('15', '40', '15');
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	
		$pdf->SetAutoPageBreak(TRUE, '35.4');

		//$pdf->setLanguageArray($l);
		
        //$pdf->AliasNbPages();
		
		$pdf->AddPage();
		
		/*$subrayado = "";
		
		$c = 0;
		while ($c < 50)
		{
			$subrayado .= "_";
			$c = $c + 1;
		}*/
		
		
		//$pdf->SetFont('trebuc', '', 10);
		//$pdf->SetFont('times', '', 10);
		$pdf->SetFont('Arial', '', 10);

		$html = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">
					
					<tr>
						<td width="70%" colspan="3" align="left">CALLE JULIO BOTELLO - CHITRE</td>
						<td width="18%" align="left"><strong>Fecha:</strong></td>
						<td width="12%" >'.$desde.'								
						</td>						
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">T. 910-1254 F. 910-1253</td>
						<td width="18%" align="left">Presupuesto N&deg;:</td>
						<td width="12%" >'.$mensaje[0].'								
						</td>						
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">E-MAIL: artes@innovations.com.pa</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">PARA CONSULTAS, SUGERENCIAS O PEDIDOS</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>
					<tr>
						<td width="10%"  align="left">&nbsp;</td>
						<td width="60%" colspan="2"align="left"><strong>'.$mensaje[1].'</strong></td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>
					<tr>
						<td width="10%"  align="left">&nbsp;</td>
						<td width="60%" colspan="2" align="left">'.$mensaje[2].'</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>
					<tr>
						<td width="10%"  align="left">&nbsp;</td>
						<td width="60%" colspan="2" align="left">'.((strlen($mensaje[3]) > 2) ? $mensaje[3]." DV ".$mensaje[48]:"").'</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>					
					<tr>
						<td  colspan="5" align="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:10px;"  style="border: 1px solid black;">
								<tr style="background-color:#E0E0E0;" >
								<td style="border-bottom: 1px solid black; border-right: 1px solid black;" width="10%" align="center"><strong>Cant.</strong></td>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black;" width="45%" align="left"><strong>Descripci&oacute;n</strong></td>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black;" width="15%" align="center"><strong>Precio unitario</strong></td>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black;" width="15%" align="center"><strong>Descuento</strong></td>
								<td style="border-bottom: 1px solid black;" width="15%" align="center"><strong>Total</strong></td>
								</tr>';
								
		$c = 0; $f = 0;$detalle = 0;
		while ($c < count($mensaje[7]))
		{
			
			/*if ($mensaje[11][$c] == "imprenta")
			{
				$html .= '		<tr '.(($f%2==1)?'style="background-color:#E0E0E0;"':'style="background-color:#FFF;"').'>
								<td align="center" style=" border-right: 1px solid black;">'.$mensaje[7][$c].'&nbsp;</td>
								<td align="left"  style=" border-right: 1px solid black;">'.(($mensaje[8][$c])?$mensaje[8][$c]:"Trabajo de Imprenta").'&nbsp;('.$mensaje[12][$c].',
								'.$mensaje[13][$c].','.(($mensaje[14][$c]==0)?"Original":(($mensaje[14][$c]==1)?$mensaje[14][$c]." copia":$mensaje[14][$c]." copias")).', Tinta '.$mensaje[15][$c].'
								con '.$mensaje[16][$c].', Papel Original de Color '.$mensaje[17][$c].' '.(($mensaje[18][$c])?", 1ra Copia de Color ".$mensaje[18][$c]:"").'
								'.(($mensaje[19][$c])?", 2da Copia de Color ".$mensaje[19][$c]:"").' '.(($mensaje[20][$c])?", 2da Copia de Color ".$mensaje[20][$c]:"").')&nbsp;</td>
								<td style=" border-right: 1px solid black;" align="center">'.$mensaje[10][$c].'&nbsp;</td>
								<td style=" border-right: 1px solid black;" align="center">&nbsp;</td>
								<td align="center">'.number_format(($mensaje[7][$c]*$mensaje[10][$c]),2,'.','').'&nbsp;</td>
								</tr>';	

				$detalle = 5 + $detalle;

			}
			
			else if  ($mensaje[11][$c] == "banner")
			{
				$html .= '		<tr '.(($f%2==1)?'style="background-color:#E0E0E0;"':'style="background-color:#FFF;"').'>
								<td align="center" style=" border-right: 1px solid black;">'.$mensaje[7][$c].'&nbsp;</td>
								<td align="left" style=" border-right: 1px solid black;">'.(($mensaje[8][$c])?$mensaje[8][$c]:"Trabajo de Banner").'&nbsp;( Banner de Tipo '.$mensaje[22][$c].'
								con tamaño de '.$mensaje[23][$c].' '.$mensaje[24][$c].' de Ancho x '.$mensaje[25][$c].' '.$mensaje[26][$c].' de Largo para un &Aacute;rea de '.$mensaje[27][$c].'
								pies, Forma de Pago '.$mensaje[28][$c].', Calidad de '.$mensaje[29][$c];
				
				if ($mensaje[30][$c] > 0)
				$html .= ', Incluye Instalación';
				if ($mensaje[31][$c] > 0)
				$html .= ', Incluye Recorte';
				if ($mensaje[32][$c] > 0)
				$html .= ', Incluye Arte';
				if ($mensaje[33][$c] != "")
				$html .= ', Incluye Rotulado';
				if ($mensaje[34][$c] > 0)
				$html .= ', Incluye Basta';
				if ($mensaje[35][$c] > 0)
				$html .= ', Incluye Ojetes';
				if ($mensaje[36][$c] > 0)
				$html .= ', Incluye Bulcaniza';
			
				$html .= '	)&nbsp;</td>
							<td style=" border-right: 1px solid black;" align="center">'.$mensaje[10][$c].'&nbsp;</td>
							<td style=" border-right: 1px solid black;" align="center">&nbsp;</td>
							<td align="center">'.number_format(($mensaje[7][$c]*$mensaje[10][$c]),2,'.','').'&nbsp;</td>
							</tr>';
				
				$detalle = 5 + $detalle;
				
			}
			else if (($mensaje[11][$c] != "banner") or ($mensaje[11][$c] == "imprenta"))
			{*/
				$html .= '		<tr '.(($f%2==1)?'style="background-color:#E0E0E0;"':'style="background-color:#FFF;"').'>
								<td style=" border-right: 1px solid black;" align="center">'.$mensaje[7][$c].'&nbsp;</td>
								<td style=" border-right: 1px solid black;" align="left">'.(($mensaje[9][$c] != "")?($mensaje[9][$c].'&nbsp;de&nbsp;'):"").$mensaje[8][$c].'&nbsp;</td>
								<td style=" border-right: 1px solid black;" align="center">'.number_format($mensaje[10][$c],2,'.','').'&nbsp;</td>
								<td style=" border-right: 1px solid black;" align="center">&nbsp;</td>
								<td align="center">'.number_format(($mensaje[7][$c]*$mensaje[10][$c]),2,'.','').'&nbsp;</td>
								</tr>';
			//}
			
			$c = $c + 1; $f = $f + 1;
		}
		
		$c = 0;
		while ($c < (16 - count($mensaje[7]) - $detalle))
		{		
			$html .= '			<tr '.(($f%2==1)?'style="background-color:#E0E0E0;"':'style="background-color:#FFF;"').'>
								<td style=" border-right: 1px solid black; border-right: 1px solid black;" align="center">&nbsp;</td>
								<td style=" border-right: 1px solid black; border-right: 1px solid black;" align="left">&nbsp;</td>
								<td style=" border-right: 1px solid black; border-right: 1px solid black;" align="center">&nbsp;</td>
								<td style=" border-right: 1px solid black; border-right: 1px solid black;" align="center">&nbsp;</td>
								<td style=" border-right: 1px solid black;" align="center">&nbsp;</td>
								</tr>';
			$c = $c + 1; $f = $f + 1;								
		}

		$html .= '				<tr>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;" align="center">&nbsp;</td>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;" align="left">&nbsp;</td>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;" align="center">&nbsp;</td>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;" align="center">Subtotal&nbsp;</td>
								<td style="border-bottom: 1px solid black; border-top: 1px solid black;" align="center">'.number_format($mensaje[4],2,'.','').'&nbsp;</td>
								</tr>';
								
		$html .= '				<tr>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black;" align="center">&nbsp;</td>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black;" align="left">&nbsp;</td>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black;" align="center">&nbsp;</td>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black;" align="center">ITBMS(7%)&nbsp;</td>
								<td style="border-bottom: 1px solid black;" align="center">'.number_format($mensaje[5],2,'.','').'&nbsp;</td>
								</tr>';
								
		$html .= '				<tr>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black;" align="center">&nbsp;</td>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black;" align="left">&nbsp;</td>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black;" align="center">&nbsp;</td>
								<td style="border-bottom: 1px solid black; border-right: 1px solid black;" align="center"><strong>Importe total</strong>&nbsp;</td>
								<td style="border-bottom: 1px solid black;" align="center">'.number_format($mensaje[6],2,'.','').'&nbsp;</td>
								</tr>';									
		
		$html .= '			</table>
						</td>
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>					
				</table>';

		
		$pdf->writeHTML($html, true, false, true, false, '');			
		
		//Close and output PDF document
		$pdf->Output('../../tmp/Detalle_Venta_Innovations_Print_'.$mensaje[0].'_'.$desde.'.pdf', 'F');
		
	}
}
?>