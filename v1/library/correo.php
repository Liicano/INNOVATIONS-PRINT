<?php
include('../config/configuracion.php');
include('php_mailer/class.phpmailer.php');

// Librería

// Definición de objeto correo
// Rutinas para el envio de correos del sistema

class correo{
	////////////////////////////////////////////////////////////////////
	// Atributos
	////////////////////////////////////////////////////////////////////
	var $msg;
	var $Html;
	var $Txt;
	
	
	
	////////////////////////////////////////////////////////////////////
	// Constructor
	////////////////////////////////////////////////////////////////////
	function correo(){		
		$this->msg	= "";
		$this->Html = "";
		$this->Txt	= "";
	}
	
	
		////////////////////////////////////////////////////////////////////
	// Métodos
	///////////////////////////////////////////////////////////////////
	function enviarMensaje($P_To, $P_Asunto, $P_attachment=""){	  	
		/*global $directorioAplic;
		global $AppName;
		global $correoFrom; */
		
		$exito = false;
		$mail = new PHPMailer();
		// Establecemos el idioma en el que se mostarán los posibles errores 
		// de PHPMailer. Para saber qué idiomas están disponibles consultar
		// el directorio 'phpmailer/language/'
		/*if (!$mail->SetLanguage('es','phpmailer/language/'))	{
			echo '<p>No se ha podido cargar el fichero de idioma adecuado.</p>';
		}*/

		
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;
		$mail->Port       = 465;
		$mail->SMTPSecure = "ssl";				
		$mail->Host       = APP_CORREO_HOST_SSL;		
		$mail->Username   = APP_CORREO_USER;
		$mail->Password   = APP_CORREO_PASS;
		$mail->SMTPKeepAlive   = true;
		
		// Introducimos la información del remitente del mensaje		
		$mail->SetFrom(APP_CORREOFROM);
		$mail->FromName = APP_NOMBRE;
		$mail->AddReplyTo( APP_CORREOFROM, APP_NOMBRE);
		$mail->Sender = APP_CORREOFROM;
		$mail->AddCC(APP_CORREO_CC);
		//$mail->AddCC(APP_CORREO_CC);
		
		// y los destinatarios del mensaje. Podemos especificar más de un destinatario
		if (!is_array($P_To))
		$arrTo[]=$P_To;
		else
		$arrTo=$P_To;
		
		foreach ($arrTo as $To){
			$mail->AddAddress($To);
		}
		
		//$mail->AddEmbeddedImage($directorioAplic.'img/dintel_Izq.png', 'bannerlogo');
		
		// Establecemos los parámetros del mensaje: ancho y formato.
		$mail->WordWrap = 50; // ancho del mensaje
		$mail->IsHTML(true); // enviar como HTML
		
		// Añadimos el mensaje: asunto, cuerpo del mensaje en HTML y en formato
		// solo texto
		$mail->Subject  =  $P_Asunto;
		$mail->AddEmbeddedImage('images/logo_mail_firma.jpg','logo1','images/logo_mail_firma.jpg','base64','image/jpeg');		
		$mail->Body     =  $this->Html;
		$mail->AltBody  =  $this->Txt; // Para los queno pueden recibir en formato HTML
		
		// Añadimos los adjuntos al mensaje
		if ($P_attachment != ""){
			if (!is_array($P_attachment))
			$arrAtch[]=$P_attachment;
			else
			$arrAtch = $P_attachment;
			
			foreach ($arrAtch as $Atch){
				$mail->AddAttachment($Atch); 
			}		
		}
		//echo "<pre>"; print_r($mail); echo "<pre>";
		if($mail->Send())
		$exito = true;
		/*else
		{
		//$exito = APP_CORREOFROM;
		$exito = "Mailer Error: " . $mail->ErrorInfo;
		}*/
		
		return ($exito);		
	}
	
	
	function prepararNotificacion($mensaje, $tipo){
		
		//echo 'prueba';
		$html = '
		<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<title>Golfin Panama Online Quotes</title>
		</head>
		<body>';
		
		switch ($tipo){

			
		case 1:	//
			$html .= 
			'<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>INNOVATIONS CAFE INTERNET&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td><img src="cid:logo1" width="100%" alt="INNOVATIONS PRINT" />&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>				
				<tr>
					<td>INFORMACION</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>Correo enviado desde:</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>info@innovations.com.pa&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>infoNos puede contactar en:&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>Tel. 910-1254 | Fax. 910-1253&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>Cel. 6611-5135 (WhatsApp)&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td> SKYPE: aan_30&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>FACEBOOK: innprint&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>Web: www.innovations.com.pa&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>E-mail: info@innovations.com.pa &nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>Ofrecemos:&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>CENTRO DE COPIADO E IMPRENTA&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>IMPRESIONES DE GRAN FORMATO (BANNERS)&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>IMPRESION Y COPIAS DE PLANOS&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>VENTAS DE UTILES DE OFICINA&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>HOSTING Y DOMINIOS&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>								
			</table>';
			break;

		case 2:	//registro Usuario  
			$html .=
			'<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
				<td width="50%" valign="bottom" style="font-size:12px" align="center"><strong>INNOVATIONS CAFE INTERNET</strong></td>
				<td width="50%" valign="bottom" style="font-size:24px" align="center"><strong>PRESUPUESTO</strong></td>
				</tr>
				<tr>
				<td width="50%" valign="bottom" style="font-size:25px" align="center"><strong>RUC 7-702-2407 DV 46</strong></td>
				<td width="50%" valign="bottom" style="font-size:25px" align="center"><strong>&nbsp;</strong></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
				<td width="50%" valign="bottom" style="font-size:25px" align="center"><strong>CALLE JULIO BOTELLO - CHITRE</strong></td>
				<td width="50%" valign="bottom" style="font-size:25px" align="center"><strong>Fecha:</strong>&nbsp;'.date('d').' de '.date('m').' de '.date('Y').'</td>
				</tr>
				<tr>
				<td width="50%" valign="bottom" style="font-size:25px" align="center"><strong>T. 910-1254 F. 910-1253</strong></td>
				<td width="50%" valign="bottom" style="font-size:25px" align="center"><strong>Presupuesto Nº:</strong>&nbsp;</td>
				</tr>				
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
				<td width="50%" valign="bottom" style="font-size:25px" align="center"><strong>E-MAIL: artes@innovations.com.pa</strong></td>
				<td width="50%" valign="bottom" style="font-size:25px" align="center">&nbsp;</td>
				</tr>
				<tr>
				<td width="50%" valign="bottom" style="font-size:25px" align="center"><strong>PARA CONSULTAS, SUGERENCIAS O PEDIDOS</strong></td>
				<td width="50%" valign="bottom" style="font-size:25px" align="center">&nbsp;</td>
				</tr>				
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>					
				<tr><td colspan="2" align="center"><span style="font-size:16px" align="center">CAMPOS DE PESE, S.A.</span>&nbsp;</td></tr>
				<tr><td colspan="2" align="center"><span style="font-size:16px" align="center">LAS CABRAS DE PESÉ - HERRERA</span>&nbsp;</td></tr>
				<tr><td colspan="2" align="center"><span style="font-size:16px" align="center">RUC 0 00 000</span>&nbsp;</td></tr>				
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>				
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="2">CUALQUIER SUGERENCIA O DUDAS EN CUANTO A LO COTIZADO NO DUDE EN ACERCASE A NUESTRAS OFICINAS.</td>
				</tr>
				<tr>
					<td colspan="2">ESPERAMOS LA PROPUESTA SEA DE SU COMPLETO AGRADO.</td>
				</tr>	
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>
					<td colspan="2">FIRMA DE APROBACION.</td>
				</tr>				
			</table>';
			break;
			
		case 3:
			$html .= 
			'<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
				<td width="15%" valign="bottom" style="font-size:25px" colspan="7" align="center"><strong>INNOVATIONS CAFE INTERNET</strong></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>					
				<tr><td colspan="2" align="center"><span style="font-size:16px" align="center">ONLINE PACKAGE QUOTE</span>&nbsp;</td></tr>
				<tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>				
				<td colspan="2"><span style="font-size:16px">'.$mensaje[0].'</span><strong></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>				
				<tr>				
				<td><span style="font-size:16px">Date of Transaction:</span><strong></td>
				<td><span style="font-size:16px">'.$mensaje[1].'</span><strong></td>				
				</tr>				
			</table>';
			break;		
			
		case 4: //
			$html .= 
			'<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
				<td width="15%" valign="bottom" style="font-size:25px" colspan="7" align="center"><strong>GOLF IN PANAMA</strong></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>					
				<tr><td colspan="2" align="center"><span style="font-size:16px" align="center">ONLINE PACKAGE QUOTE</span>&nbsp;</td></tr>
				<tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>
				<tr>				
				<td colspan="2"><span style="font-size:16px">'.$mensaje[0].'</span><strong></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>				
				</tr>				
				<tr>				
				<td><span style="font-size:16px">Date of Transaction:</span><strong></td>
				<td><span style="font-size:16px">'.$mensaje[1].'</span><strong></td>				
				</tr>				
			</table>'; 
			break;																
		
//=======
			case 5: //
				$html .=
				'';
				break;
				case 6:
					$html .=
					'';
					break;
						
			case 7: //
				$html .= 
				''; 
			break;
	
		case 10: //
			$html .= 
			''; 
			break;
			
//<<<<<<< .mine
		case 11://
			$html =
			'';
			
			break;
			
		case 12://
            $html=
                '';

			break;	
			
	case 13: //
			$html .= 
			''; 
			break;																
		
//=======			
			
		}			
		
//>>>>>>> .r488
		$html .= '</body></html>'; 
		$this->Html = $html;
		
		//echo $html;
	}
	
	
} // Clase correo 

?>