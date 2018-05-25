<?php
include('tcpdf/tcpdf.php');

class Generar_Recibo_Abono extends TCPDF
{
	
	function Header() 
	{
		
	}

	//Pie de página
	function Footer()
	{
	
	}	
	
	function Generar_Recibo ($desde, $hasta, $mensaje="" )
	{

		$pdf = new Generar_Recibo_Abono('P', 'mm', 'LETTER', false, 'ISO-8859-1', false);		

		$pdf->SetProtection($permissions=array( 'modify', 'copy', 'annot-forms', 'fill-forms', 'extract', 'assemble', 'print-high', 'owner' ), $user_pass='', $owner_pass=null, $mode=0, $pubkeys=null);

		$pdf->SetDisplayMode('fullpage','continuous');

		$pdf->SetCreator('INNOVATIONS PRINT');
		$pdf->SetAuthor('INNOVATIONS PRINT');
		$pdf->SetTitle('INNOVATIONS PRINT Recibo de Abono');
		$pdf->SetSubject('Recibo de Abono');
		$pdf->SetKeywords('Recibo de Abono');

		$pdf->setHeaderFont(Array('times', '', PDF_FONT_SIZE_MAIN));		
		//$pdf->setFooterFont(Array('helvetica', '', PDF_FONT_SIZE_DATA));		
		
		$pdf->SetMargins('13', '0', '13');
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	
		$pdf->SetAutoPageBreak(TRUE, '0');

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

		$html = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td  height="20px">
						</td>
					</tr>
					<tr>
						<td  height="356px">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="50%" align="left"><img src="../../public/images/logo_mail_firma.jpg" width="200px" alt="INNOVATIONS PRINT" /></td>
									<td width="50%" align="left">
										<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:10px;"  style="border: 1px solid black;">
											<tr>
												<td width="33%" style="border-right: 1px solid black;"><span style="font-size:12px;text-align:center;">DIA<br />'.date('d',strtotime($mensaje[3])).'</span></td>
												<td width="34%" style="border-right: 1px solid black;"><span style="font-size:12px;text-align:center;">MES<br />'.date('m',strtotime($mensaje[3])).'</span></td>
												<td width="33%" style="border-right: 1px solid black;"><span style="font-size:12px;text-align:center;">A&Ntilde;O<br />'.date('Y',strtotime($mensaje[3])).'</span></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td width="100%" align="center"><span style="font-size:12px;">CALLE JULIO BOTELLO Y AVENIDA HERRERA (EDIF. DON MANUEL - LOCAL #1 Y 2)</span></td>
								</tr>
								<tr>
									<td width="100%" align="center"><span style="font-size:12px;font-weight:bold;">T. 910-1254 F. 910-1253 | CEL. 6299-9365 (WHATSAPP)</span></td>
								</tr>
								<tr>
									<td width="100%" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="100%">
										<p style="text-align:justified;">
											Recibi de:&nbsp;<u>'.$mensaje[5].'</u>
										</p>
										<p style="text-align:justified;">
											La suma de:&nbsp;B/.<u>'.$mensaje[4].'</u>.&nbsp;&nbsp;En concepto de abono a'.(($mensaje[1])?' la Orden de Trabajo #<u>'.$mensaje[1].'</u>&nbsp;de':'').' la cotizacion #<u>'.$mensaje[0].'</u>&nbsp;.
										</p>
										<p style="text-align:justified;">
											Forma de Pago:&nbsp;<u>'.$mensaje[6].'</u>.
										</p>';
										if($mensaje[1])
										{
											$html .= '<p style="text-align:justified;">
												Fecha de Entrega Acordada:&nbsp;<u>'.$mensaje[7].'</u>.
											</p>';							
										}
										
										
							$html .= '	<p style="text-align:justified;">
											Saldo para Retirar su Trabajo:&nbsp;
											<table width="20%" border="0" cellspacing="0" cellpadding="0" style="font-size:10px;"  style="border: 1px solid black;">
												<tr>
													<td align="right">&nbsp;B/.'.$mensaje[8].'&nbsp;</td>
												</tr>
											</table>
										</p>
									</td>
								</tr>
								<tr>
									<td width="100%" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="100%" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="50%" align="left">
										<table width="80%" border="0" cellspacing="0" cellpadding="0" style="font-size:10px;"  style="border-top: 1px solid black;">
											<tr>
												<td align="center">CLIENTE
												</td>
											</tr>
										</table>
									</td>
									<td width="50%" align="left">
										<table width="80%" border="0" cellspacing="0" cellpadding="0" style="font-size:10px;"  style="border-top: 1px solid black;">
											<tr>
												<td align="center">CAJERO
												</td>
											</tr>
										</table>					
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td  height="20px">
						</td>
					</tr>
				</table>';	


		$html .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td  height="20px">
						</td>
					</tr>
					<tr>
						<td  height="356px">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="50%" align="left"><img src="../../public/images/logo_mail_firma.jpg" width="200px" alt="INNOVATIONS PRINT" /></td>
									<td width="50%" align="left">
										<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:10px;"  style="border: 1px solid black;">
											<tr>
												<td width="33%" style="border-right: 1px solid black;"><span style="font-size:12px;text-align:center;">DIA<br />'.date('d',strtotime($mensaje[3])).'</span></td>
												<td width="34%" style="border-right: 1px solid black;"><span style="font-size:12px;text-align:center;">MES<br />'.date('m',strtotime($mensaje[3])).'</span></td>
												<td width="33%" style="border-right: 1px solid black;"><span style="font-size:12px;text-align:center;">A&Ntilde;O<br />'.date('Y',strtotime($mensaje[3])).'</span></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td width="100%" align="center"><span style="font-size:12px;">CALLE JULIO BOTELLO Y AVENIDA HERRERA (EDIF. DON MANUEL - LOCAL #1 Y 2)</span></td>
								</tr>
								<tr>
									<td width="100%" align="center"><span style="font-size:12px;font-weight:bold;">T. 910-1254 F. 910-1253 | CEL. 6299-9365 (WHATSAPP)</span></td>
								</tr>
								<tr>
									<td width="100%" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="100%">
										<p style="text-align:justified;">
											Recibi de:&nbsp;<u>'.$mensaje[5].'</u>
										</p>
										<p style="text-align:justified;">
											La suma de:&nbsp;B/.<u>'.$mensaje[4].'</u>.&nbsp;&nbsp;En concepto de abono a'.(($mensaje[1])?' la Orden de Trabajo #<u>'.$mensaje[1].'</u>&nbsp;de':'').' la cotizacion #<u>'.$mensaje[0].'</u>&nbsp;.
										</p>
										<p style="text-align:justified;">
											Forma de Pago:&nbsp;<u>'.$mensaje[6].'</u>.
										</p>';
										if($mensaje[1])
										{
											$html .= '<p style="text-align:justified;">
												Fecha de Entrega Acordada:&nbsp;<u>'.$mensaje[7].'</u>.
											</p>';							
										}
										
										
							$html .= '	<p style="text-align:justified;">
											Saldo para Retirar su Trabajo:&nbsp;
											<table width="20%" border="0" cellspacing="0" cellpadding="0" style="font-size:10px;"  style="border: 1px solid black;">
												<tr>
													<td align="right">&nbsp;B/.'.$mensaje[8].'&nbsp;</td>
												</tr>
											</table>
										</p>
									</td>
								</tr>
								<tr>
									<td width="100%" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="100%" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td width="50%" align="left">
										<table width="80%" border="0" cellspacing="0" cellpadding="0" style="font-size:10px;"  style="border-top: 1px solid black;">
											<tr>
												<td align="center">CLIENTE
												</td>
											</tr>
										</table>
									</td>
									<td width="50%" align="left">
										<table width="80%" border="0" cellspacing="0" cellpadding="0" style="font-size:10px;"  style="border-top: 1px solid black;">
											<tr>
												<td align="center">CAJERO
												</td>
											</tr>
										</table>					
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td  height="20px">
						</td>
					</tr>
				</table>';							
		
		
		$pdf->writeHTML($html, true, false, true, false, '');			
		
		//Close and output PDF document
		$pdf->Output('../../tmp/Recibo_Abono_'.$mensaje[2].'_'.$desde.'.pdf', 'F');
		
	}
}
?>