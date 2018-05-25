<?php
include('tcpdf/tcpdf.php');

class Generar_Orden_Trabajo extends TCPDF
{
	
	function Header() {

		//$hoy=date('Y-m-d');
		//$this->Image('../images/logo.jpg', 10, 1, 60, '', 'JPEG', '', 'C', false, 100, '', false, false, 0, false, false, false);
		//$this->Ln(8.89);

		//$objFecha =  new fecha();
		//$charhoy = $objFecha->converfecha($hoy);
		$this->SetFont('Arial', '', 10);			
		$html = '';	
		$this->writeHTML($html, true, false, true, false, '');		
		
	}

	//Pie de página
	function Footer()
	{
	
		global $NC;
		global $OT;
		global $Monto_Total;
		global $Monto_Abonado;
		global $Saldo;	
		print_r($mensaje[41]);	
		//Posición: a 1,5 cm del final
		$this->SetY(-55);
		//Arial italic 8
		//$this->SetFont('Arial','I',8);
		//Número de página
		//$this->Cell(0,10,'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(),0,0,'C');
		//$this->Ln(6);	
		//$this->Cell(0,10,'Actualizado el '.date('d-m-Y').'.',0,0,'C');
		$this->SetFont('Arial', '', 10);			
		//$html = '';
		/*$html .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="50%" align="left"><img src="../../public/images/logo_mail_firma.jpg" width="200px" alt="INNOVATIONS PRINT" /></td>
					<td width="50%" align="left">&nbsp;</td>
				</tr>				
				<tr>
					<td width="50%" align="left" colspan="2"><span style="font-size:12px;">INNOVATIONS PRINT</span></td>
					<td width="25%" align="right"><span style="font-size:12px;">Monto Total: </span></td>
					<td width="25%" align="left"><span style="font-size:12px;">&nbsp;&nbsp;B/. '.$Monto_Total.'&nbsp;</span></td>			
				</tr>
				<tr>
					<td width="50%" align="left" colspan="2"><span style="font-size:12px;">CALLE JULIO BOTELLO - CHITRE</span></td>
					<td width="25%" align="right"><span style="font-size:12px;">Monto Abonado: </span></td>
					<td width="25%" align="left"><span style="font-size:12px;">&nbsp;&nbsp;B/. '.$Monto_Abonado.'&nbsp;</span></td>				
				</tr>
				<tr>
					<td width="50%" align="left" colspan="2"><span style="font-size:12px;">T. 910-1254 F. 910-1253</span></td>
					<td width="25%" align="right"><span style="font-size:12px;">Saldo: </span></td>
					<td width="25%" align="left"><span style="font-size:12px;">&nbsp;&nbsp;B/. '.$Saldo.'&nbsp;</span></td>					
				</tr>
				<tr>
					<td width="50%" align="left"><span style="font-size:12px;">E-MAIL: artes@innovations.com.pa</span></td>
					<td width="50%" align="left">&nbsp;</td>
				</tr>
				<tr>
					<td width="50%"  align="left"><span style="font-size:12px;">OT:  '.$OT.'&nbsp;&nbsp;NC:  '.$NC.'&nbsp;</span></td>
					<td width="50%"  align="left">&nbsp;</td>						
				</tr>
				<tr>
					<td width="50%"  align="left"><span style="font-size:12px;"></span></td>
					<td width="50%"  align="left">&nbsp;</td>						
				</tr>			
				</table>';*/

				
		// $html .= '<table>
		// 			<tr>
		// 				<td width="10%" align="left">Nota:&nbsp;</td>
		// 				<td width="90%" align="left">'.addslashes($mensaje[41]).'&nbsp;</td>
		// 			</tr>
		// 		</table>';
				
		$this->writeHTML($html, true, false, true, false, '');	
	
	}	
	
	function Generar_Orden_Trabajo_Imprenta ($desde, $hasta, $mensaje="" )
	{
		global $NC;
		global $OT;
		global $Monto_Total;
		global $Monto_Abonado;
		global $Saldo;		
		$NC = $mensaje[30];
		$OT = $mensaje[31];
		$Monto_Total = $mensaje[42];
		$Monto_Abonado = $mensaje[43];
		$Saldo = $mensaje[44];		
	
		$pdf = new Generar_Orden_Trabajo('P', 'mm', 'LETTER', false, 'ISO-8859-1', false);		

		$pdf->SetProtection($permissions=array( 'modify', 'copy', 'annot-forms', 'fill-forms', 'extract', 'assemble', 'print-high', 'owner' ), $user_pass='', $owner_pass=null, $mode=0, $pubkeys=null);

		$pdf->SetDisplayMode('fullpage','continuous');

		$pdf->SetCreator('INNOVATIONS PRINT');
		$pdf->SetAuthor('INNOVATIONS PRINT');
		$pdf->SetTitle('INNOVATIONS PRINT Orden de Trabajo');
		$pdf->SetSubject('Orden de Trabajo');
		$pdf->SetKeywords('Orden de Trabajo');

		$pdf->setHeaderFont(Array('times', '', PDF_FONT_SIZE_MAIN));		
		//$pdf->setFooterFont(Array('helvetica', '', PDF_FONT_SIZE_DATA));		
		
		$pdf->SetMargins('15', '12.7', '15');
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	
		$pdf->SetAutoPageBreak(TRUE, '12.7');

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
		$pdf->SetFont('Arial', '', 14);

		$html = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:13px;">';
		$html .= '<tr>
						<td width="100%" colspan="5" align="left">..............................................................................................................................&nbsp;</td>						
					</tr>';					
		$html .= '<tr>
						<td width="70%" colspan="3" align="left">Nombre:&nbsp;'.$mensaje[33].'</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>';
					
		$html .= '<tr>
						<td width="70%" colspan="3" align="left">Direcci&oacute;n:&nbsp;'.$mensaje[34].'</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>';
					
		/*$html .= '<tr>
						<td width="70%" colspan="3" align="left">RUC del Cliente:&nbsp;'.$mensaje[35].'</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>';*/
		$html .= '<tr>
						<td width="70%" colspan="3" align="left">Telefono:&nbsp;'.$mensaje[36].'</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>';
		$html .= '<tr>
						<td width="70%" colspan="3" align="left">Celular:&nbsp;'.$mensaje[37].'</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>';					
		$html .= '<tr>
						<td width="70%" colspan="3" align="left">Email:&nbsp;'.$mensaje[38].'</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>';
	$html .= '<tr>
						<td width="100%" colspan="5" align="left">..............................................................................................................................&nbsp;</td>						
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>';	
					
					

					$mensaje[59] = (($mensaje[59] == '') || $mensaje[59] == 0) ? 'COT - NUEVA' : "COT - ".$mensaje[59];		
		$html .= '	
					<tr>
						<td width="70%" colspan="3" align="left"><strong>COTIZACI&Oacute;N BASE:</strong></td>
						<td width="30%" align="left"><p style ="text-color: blue;">'.$mensaje[59].'</p>								
						</td>						
					</tr>
					
					<tr>
						<td width="70%" colspan="3" align="left"><strong>ORDEN DE TRABAJO N&Uacute;MERO:</strong></td>
						<td width="30%" align="left">'.$mensaje[31].'								
						</td>						
					</tr>
					<tr>
					<td width="100%" colspan="5" align="left">..............................................................................................................................&nbsp;</td></tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>		
					<tr>
						<td width="70%" align="left"><strong>FECHA:</strong></td>
						<td width="30%" align="left">'.$desde.'								
						</td>						
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>';
					
					
						
						$html.='<tr>
								<td width="70%" colspan="3" align="left"><strong>COTIZACI&Oacute;N N&Uacute;MERO: </strong></td>
								<td width="30%" align="left">COT - '.$mensaje[30].'								
								</td>						
								</tr>';
				

					$html.='<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left"><strong>FECHA DE ENTREGA:</strong></td>
						<td width="30%" align="left">'.$mensaje[57].'								
						</td>						
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>					
					<tr>
						<td width="100%" colspan="4" align="left"><strong>DETALLE DE ORDEN DE TRABAJO:</strong></td>														
					</tr>';
		if ($mensaje[0] == "imprenta")
		{					
			/*$html .= '<tr>
						<td width="100%" colspan="4" align="left">'.$mensaje[32].' '.$mensaje[2].' '.(($mensaje[1])?"Trabajo de Imprenta de ".$mensaje[1]:"Trabajo de Imprenta").'&nbsp;('.$mensaje[4].',
								'.$mensaje[5].','.(($mensaje[6]==0)?"Original":(($mensaje[6]==1)?$mensaje[6]." copia":$mensaje[6]." copias")).', Tinta '.$mensaje[7].'
								con '.$mensaje[8].', Papel Original de Color '.$mensaje[9].' '.(($mensaje[10])?", 1ra Copia de Color ".$mensaje[10]:"").'
								'.(($mensaje[11])?", 2da Copia de Color ".$mensaje[11]:"").' '.(($mensaje[12])?", 2da Copia de Color ".$mensaje[12]:"").')&nbsp;</td>						
					</tr>';*/
			$html .= '<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>					
						<td width="20%" align="left"><strong>Cantidad:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[32].' '.$mensaje[2].'&nbsp;</td>
						<td width="20%" align="left"><strong>Descripci&oacute;n:&nbsp;</strong></td>
						<td width="30%" align="left">'.(($mensaje[1])?$mensaje[1]:"Trabajo de Imprenta").'&nbsp;</td>						 
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>					
						<td width="20%" align="left"><strong>Tipo Papel:&nbsp;</strong></td>';
			//$html .= '	<td width="30%" align="left">'.$mensaje[4].' '.(($mensaje[45])?'de '.$mensaje[45]:'').' &nbsp;</td>';
			$html .= '	<td width="30%" align="left">'.$mensaje[4].'&nbsp;</td>';
			$html .= '	<td width="20%" align="left"><strong>Tama&ntilde;o Papel:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[5].'&nbsp;</td>						 
					</tr>					
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>					
						<td width="20%" align="left"><strong>Color de Tinta:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[7].'&nbsp;</td>
						<td width="20%" align="left"><strong>Cantidad de Copia:&nbsp;</strong></td>
						<td width="30%" align="left">'.(($mensaje[6]==0)?"Original":(($mensaje[6]==1)?$mensaje[6]." copia":$mensaje[6]." copias")).'&nbsp;</td>						 
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>					
						<td width="20%" align="left"><strong>Colores:&nbsp;</strong></td>
						<td width="30%" align="left">Copias '.(($mensaje[10])?" ".$mensaje[10]:"").'
						'.(($mensaje[11])?", ".$mensaje[11]:"").' '.(($mensaje[12])?", ".$mensaje[12]:"").'&nbsp;</td>
						<td width="20%" align="left"><strong>Numeraci&oacute;n de P&aacute;gina:&nbsp;</strong></td>';
						
						if(($mensaje[39] > 0) and ($mensaje[40] > 0))
						$html .= '<td width="30%" align="left">Desde '.$mensaje[39].' hasta '.$mensaje[40].'&nbsp;</td>';
						else
						$html .= '<td width="30%" align="left">Sin Numeraci&oacute;n&nbsp;</td>';
				
				$html .= '</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>					
						<td width="20%" align="left"><strong>Tipo de Forro:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[8].'&nbsp;</td>
						<td width="20%" align="left"><strong>&nbsp;</strong></td>
						<td width="30%" align="left">&nbsp;</td>						 
					</tr>';

				

					
		}
		else if ($mensaje[0] == "banner")
		{	

			$html .= '<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>						
						<td width="20%" align="left"><strong>Cantidad:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[32].' '.$mensaje[2].'&nbsp;</td>
						<td width="20%" align="left"><strong>Descripci&oacute;n:&nbsp;</strong></td>
						<td width="30%" align="left">'.(($mensaje[1])?"Banner de ".$mensaje[1]:"Trabajo de Banner").'&nbsp;</td>						 
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>						
						<td width="20%" align="left"><strong>Banner de Tipo:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[14].'&nbsp;</td>
						<td width="20%" align="left"><strong>&Aacute;rea:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[19].' Pies Cuadrado&nbsp;</td>					 
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>					
					<tr>						
						<td width="30%" align="left"><strong>Tama&ntilde;o de Banner:&nbsp;</strong></td>
						<td width="70%" align="left" colspan="3">'.$mensaje[15].' '.$mensaje[16].' de Ancho x '.$mensaje[17].' '.$mensaje[18].' de Largo&nbsp;</td>							 
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>						
						<td width="20%" align="left"><strong>Forma de Pago:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[20].'&nbsp;</td>
						<td width="20%" align="left"><strong>Calidad:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[21].'&nbsp;</td>						 
					</tr>';							
		}
		else if ($mensaje[0] == "impresion")
		{
			$html .= '<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>						
						<td width="20%" align="left"><strong>Cantidad:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[32].' '.$mensaje[2].'&nbsp;</td>
						<td width="20%" align="left"><strong>Descripci&oacute;n:&nbsp;</strong></td>
						<td width="30%" align="left">'.(($mensaje[1])?"Impresi&oacute;n de ".$mensaje[1]:"Trabajo de Impresi&oacute;n").'&nbsp;</td>						 
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>						
						<td width="20%" align="left"><strong>Material de Impresi&oacute;n:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[56].'&nbsp;</td>
						<td width="20%" align="left"><strong>&Aacute;rea:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[19].' Pulgada Cuadrada&nbsp;</td>					 
					</tr>					
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>						
						<td width="30%" align="left"><strong>Tama&ntilde;o de Arte:&nbsp;</strong></td>
						<td width="70%" align="left" colspan="3">'.$mensaje[15].' '.$mensaje[16].' de Ancho x '.$mensaje[17].' '.$mensaje[18].' de Largo&nbsp;</td>							 
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>
					<tr>					
						<td width="20%" align="left"><strong>Tama&ntilde;o de Pliego:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[5].'&nbsp;</td>
						<td width="20%" align="left"><strong>Color de Tinta:&nbsp;</strong></td>
						<td width="30%" align="left">'.$mensaje[7].'&nbsp;</td>
					</tr>
					<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" align="left">&nbsp;</td>						
					</tr>';		
		}
							
		$c = 0;
		while ($c < 4)
		{
			$html .= '<tr>
						<td width="70%" colspan="3" align="left">&nbsp;</td>
						<td width="30%" colspan="2" align="left">&nbsp;</td>						
					</tr>';		
		
		
			$c++;
		}
		

					
				
					
					
		$html .= '</table>';
		
		$html .= '<table>
					<tr>
						<td width="10%" align="left">Nota:&nbsp;</td>
						<td width="90%" align="left">'.addslashes($mensaje[41]).'&nbsp;</td>
					</tr>
				</table>';	
		
		/*$pdf->writeHTML($html, true, false, true, false, '');			
		
		$pdf->AddPage();
			
		$html .= '<table>
					<tr>
						<td width="10%" align="left">Nota:&nbsp;</td>
						<td width="90%" align="left">'.addslashes($mensaje[41]).'&nbsp;</td>
					</tr>
				</table>';	*/
					
		$pdf->writeHTML($html, true, false, true, false, '');		
		
		
		
		//Close and output PDF document
		$pdf->Output('../../tmp/Orden_Trabajo_Innovations_Print_'.$mensaje[30].'_'.$desde.'.pdf', 'F');
		
	}
}
?>