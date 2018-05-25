/********************************************************************************************************************************/
/*	Funciones de MD5		Encode Data																							*/
/********************************************************************************************************************************/
	/* convertir  valores de ascii */ 
	var sAscii = " !\"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
	var sAscii = sAscii + "[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~"; 
	
	/* convierta el número entero*/ 
	var sHex = "0123456789ABCDEF"; 
	function hex(i) 
	{ 
	  h = ""; 
	  for(j = 0; j <= 3; j++) 
	  { 
	    h += sHex.charAt((i >> (j * 8 + 4)) & 0x0F) + 
	         sHex.charAt((i >> (j * 8)) & 0x0F); 
	  } 
	  return h; 
	} 
	
	
	function add(x, y) 
	{ 
	  return ((x&0x7FFFFFFF) + (y&0x7FFFFFFF)) ^ (x&0x80000000) ^ (y&0x80000000); 
	} 
	
	/* MD5 rounds funciones */ 
	function R1(A, B, C, D, X, S, T) 
	{ 
	  q = add(add(A, (B & C) | ((~B) & D)), add(X, T)); 
	  return add((q << S) | (q >>> (32 - S)), B); 
	} 
	
	function R2(A, B, C, D, X, S, T) 
	{ 
	  q = add(add(A, (B & D) | (C & (~D))), add(X, T)); 
	  return add((q << S) | (q >>> (32 - S)), B); 
	} 
	
	function R3(A, B, C, D, X, S, T) 
	{ 
	  q = add(add(A, B ^ C ^ D), add(X, T)); 
	  return add((q << S) | (q >>> (32 - S)), B); 
	} 
	
	function R4(A, B, C, D, X, S, T) 
	{ 
	  q = add(add(A, C ^ (B | (~D))), add(X, T)); 
	  return add((q << S) | (q >>> (32 - S)), B); 
	} 
	
	/* main entry point */ 
	function calcMD5(sInp) { 
	
	  /* Calculate length in machine words, including padding */ 
	  wLen = (((sInp.length + 8) >> 6) + 1) << 4; 
	  var X = new Array(wLen); 
	
	  /* Convert string to array of words */ 
	  j = 4; 
	  for (i = 0; (i * 4) < sInp.length; i++) 
	  { 
	    X[i] = 0; 
	    for (j = 0; (j < 4) && ((j + i * 4) < sInp.length); j++) 
	    { 
	      X[i] += (sAscii.indexOf(sInp.charAt((i * 4) + j)) + 32) << (j * 8); 
	    } 
	  } 
	
	  /* Append padding bits and length */ 
	  if (j == 4) 
	  { 
	    X[i++] = 0x80; 
	  } 
	  else 
	  { 
	    X[i - 1] += 0x80 << (j * 8); 
	  } 
	  for(; i < wLen; i++) { X[i] = 0; } 
	  X[wLen - 2] = sInp.length * 8; 
	
	  /* hard coded initial values */ 
	  a = 0x67452301; 
	  b = 0xefcdab89; 
	  c = 0x98badcfe; 
	  d = 0x10325476; 
	
	  /* Process each 16 word block in turn */ 
	  for (i = 0; i < wLen; i += 16) { 
	    aO = a; 
	    bO = b; 
	    cO = c; 
	    dO = d; 
	
	    a = R1(a, b, c, d, X[i+ 0], 7 , 0xd76aa478); 
	    d = R1(d, a, b, c, X[i+ 1], 12, 0xe8c7b756); 
	    c = R1(c, d, a, b, X[i+ 2], 17, 0x242070db); 
	    b = R1(b, c, d, a, X[i+ 3], 22, 0xc1bdceee); 
	    a = R1(a, b, c, d, X[i+ 4], 7 , 0xf57c0faf); 
	    d = R1(d, a, b, c, X[i+ 5], 12, 0x4787c62a); 
	    c = R1(c, d, a, b, X[i+ 6], 17, 0xa8304613); 
	    b = R1(b, c, d, a, X[i+ 7], 22, 0xfd469501); 
	    a = R1(a, b, c, d, X[i+ 8], 7 , 0x698098d8); 
	    d = R1(d, a, b, c, X[i+ 9], 12, 0x8b44f7af); 
	    c = R1(c, d, a, b, X[i+10], 17, 0xffff5bb1); 
	    b = R1(b, c, d, a, X[i+11], 22, 0x895cd7be); 
	    a = R1(a, b, c, d, X[i+12], 7 , 0x6b901122); 
	    d = R1(d, a, b, c, X[i+13], 12, 0xfd987193); 
	    c = R1(c, d, a, b, X[i+14], 17, 0xa679438e); 
	    b = R1(b, c, d, a, X[i+15], 22, 0x49b40821); 
	
	    a = R2(a, b, c, d, X[i+ 1], 5 , 0xf61e2562); 
	    d = R2(d, a, b, c, X[i+ 6], 9 , 0xc040b340); 
	    c = R2(c, d, a, b, X[i+11], 14, 0x265e5a51); 
	    b = R2(b, c, d, a, X[i+ 0], 20, 0xe9b6c7aa); 
	    a = R2(a, b, c, d, X[i+ 5], 5 , 0xd62f105d); 
	    d = R2(d, a, b, c, X[i+10], 9 ,  0x2441453); 
	    c = R2(c, d, a, b, X[i+15], 14, 0xd8a1e681); 
	    b = R2(b, c, d, a, X[i+ 4], 20, 0xe7d3fbc8); 
	    a = R2(a, b, c, d, X[i+ 9], 5 , 0x21e1cde6); 
	    d = R2(d, a, b, c, X[i+14], 9 , 0xc33707d6); 
	    c = R2(c, d, a, b, X[i+ 3], 14, 0xf4d50d87); 
	    b = R2(b, c, d, a, X[i+ 8], 20, 0x455a14ed); 
	    a = R2(a, b, c, d, X[i+13], 5 , 0xa9e3e905); 
	    d = R2(d, a, b, c, X[i+ 2], 9 , 0xfcefa3f8); 
	    c = R2(c, d, a, b, X[i+ 7], 14, 0x676f02d9); 
	    b = R2(b, c, d, a, X[i+12], 20, 0x8d2a4c8a); 
	
	    a = R3(a, b, c, d, X[i+ 5], 4 , 0xfffa3942); 
	    d = R3(d, a, b, c, X[i+ 8], 11, 0x8771f681); 
	    c = R3(c, d, a, b, X[i+11], 16, 0x6d9d6122); 
	    b = R3(b, c, d, a, X[i+14], 23, 0xfde5380c); 
	    a = R3(a, b, c, d, X[i+ 1], 4 , 0xa4beea44); 
	    d = R3(d, a, b, c, X[i+ 4], 11, 0x4bdecfa9); 
	    c = R3(c, d, a, b, X[i+ 7], 16, 0xf6bb4b60); 
	    b = R3(b, c, d, a, X[i+10], 23, 0xbebfbc70); 
	    a = R3(a, b, c, d, X[i+13], 4 , 0x289b7ec6); 
	    d = R3(d, a, b, c, X[i+ 0], 11, 0xeaa127fa); 
	    c = R3(c, d, a, b, X[i+ 3], 16, 0xd4ef3085); 
	    b = R3(b, c, d, a, X[i+ 6], 23,  0x4881d05); 
	    a = R3(a, b, c, d, X[i+ 9], 4 , 0xd9d4d039); 
	    d = R3(d, a, b, c, X[i+12], 11, 0xe6db99e5); 
	    c = R3(c, d, a, b, X[i+15], 16, 0x1fa27cf8); 
	    b = R3(b, c, d, a, X[i+ 2], 23, 0xc4ac5665); 
	
	    a = R4(a, b, c, d, X[i+ 0], 6 , 0xf4292244); 
	    d = R4(d, a, b, c, X[i+ 7], 10, 0x432aff97); 
	    c = R4(c, d, a, b, X[i+14], 15, 0xab9423a7); 
	    b = R4(b, c, d, a, X[i+ 5], 21, 0xfc93a039); 
	    a = R4(a, b, c, d, X[i+12], 6 , 0x655b59c3); 
	    d = R4(d, a, b, c, X[i+ 3], 10, 0x8f0ccc92); 
	    c = R4(c, d, a, b, X[i+10], 15, 0xffeff47d); 
	    b = R4(b, c, d, a, X[i+ 1], 21, 0x85845dd1); 
	    a = R4(a, b, c, d, X[i+ 8], 6 , 0x6fa87e4f); 
	    d = R4(d, a, b, c, X[i+15], 10, 0xfe2ce6e0); 
	    c = R4(c, d, a, b, X[i+ 6], 15, 0xa3014314); 
	    b = R4(b, c, d, a, X[i+13], 21, 0x4e0811a1); 
	    a = R4(a, b, c, d, X[i+ 4], 6 , 0xf7537e82); 
	    d = R4(d, a, b, c, X[i+11], 10, 0xbd3af235); 
	    c = R4(c, d, a, b, X[i+ 2], 15, 0x2ad7d2bb); 
	    b = R4(b, c, d, a, X[i+ 9], 21, 0xeb86d391); 
	
	    a = add(a, aO); 
	    b = add(b, bO); 
	    c = add(c, cO); 
	    d = add(d, dO); 
	  } 
	  return hex(a) + hex(b) + hex(c) + hex(d); 
	}  
	
	
	
	function sha(){
	  hash = hex_sha1("input string"); 
	}

	
/**************************************************************************************************************************************/
/*						Manejo de Moneda																							  */	
/**************************************************************************************************************************************/

function MoneyFormat(amount) 
{ 
	var val = parseFloat(amount); 
	
	if (isNaN(val)) 
	{ return "0.00"; } 

	if (val <= 0) 
	{ return "0.00"; } 
	
	val += ""; 

	// Next two lines remove anything beyond 2 decimal places 
	if (val.indexOf('.') == -1) 
	{ return val+".00"; } 
	else 
	{ val = val.substring(0,val.indexOf('.')+3); } 

	val = (val == Math.floor(val)) ? val + '.00' : ((val*10 == Math.floor(val*10)) ? val + '0' : val); 
	return val; 
} 

function PrecioMoneda(precio)
{
	//alert(document.getElementById(precio).value);
	document.getElementById(precio).value = MoneyFormat(Math.round((document.getElementById(precio).value) * 100) / 100);	

}

function DecimalFormat(amount) 
{ 
	var val = parseFloat(amount); 
	
	if (isNaN(val)) 
	{ return "0.00000000"; } 

	if (val <= 0) 
	{ return "0.00000000"; } 
	
	val += ""; 

	//alert(val.indexOf('.'));
	//alert(val.substring(0,val.indexOf('.')+9));
	// Next two lines remove anything beyond 2 decimal places 
	if (val.indexOf('.') == -1) 
	{ return val+".00000000"; } 
	else 
	{ val = val.substring(0,val.indexOf('.')+9); } 

	val = (val == Math.floor(val)) ? val + '.00000000' : ((val*10 == Math.floor(val*10)) ? val + '0000000' : ((val*100 == Math.floor(val*100)) ? val + '000000' : ((val*1000 == Math.floor(val*1000)) ? val + '00000' : ((val*10000 == Math.floor(val*10000)) ? val + '0000' : ((val*100000 == Math.floor(val*100000)) ? val + '000' : ((val*1000000 == Math.floor(val*1000000)) ? val + '00' : ((val*10000000 == Math.floor(val*10000000)) ? val + '0' : val))))))); 
	return val; 
}

function DecimalesPulgada(tamano)
{

	//alert(document.getElementById(precio).value);
	document.getElementById(tamano).value = DecimalFormat(Math.round((document.getElementById(tamano).value) * 100000000) / 100000000);	

}

function ConvertirMoneda(monto)
{
	monto = MoneyFormat(Math.round(monto * 100) / 100);	

	return monto;
}


function getURLParameter(name) 
{
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}


function mayuscula(campo)
{
	$(campo).keyup(function(){$(this).val($(this).val().toUpperCase())})
}

function minuscula(campo)
{	
	$(campo).keyup(function(){$(this).val($(this).val().toLowerCase())})
}

	
function Iniciar_Session()
{
	//alert($('#remMe:checked').val());
	//alert($('#remMe').is(':checked'));
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);
	
	//alert(recordar);
	
	$.post("library/funciones.php?action=Iniciar_Session",
	{
		usuario:$("#login").val(),		
		clave:$("#pass").val(),
		rem:$('#remMe').is(':checked')		
	}, function(data){

		console.log("Data del inicio de ssesion -> ",data);
		
		if (data == 'admin.php'){window.location.href = data;}
		if (data == "false1"){Sexy.error("Usuario est&aacute; Inactivo.");}
		if (data == 'false'){Sexy.error("Nombre de usuario y la contraseña incorrectos, compruebe su <br /> nombre de usuario y contrase&ntilde;a y vuelva a intentarlo.");}
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);	
	})
}
	

function Verificar_Sesion()
{
	$.post("library/funciones.php?action=Verificar_Sesion",
	 function(data){

		
		
		if (data=="false")
		{
			Sexy.error("Su tiempo de Sesi&oacute;n ha expirado, debes escribir<br /> su Usuario y Contrase&ntilde;a para Volver a entrar al Sistema.", {
			onComplete:function (returnvalue) {
				window.location.href="index.php";
				}
			});			
			
		}
		else
		{
			Nombre_Sesion();
			//Verificar_Perfil_Menu();
			//Verificar_Perfil_Menu1();
			//Verificar_Perfil_Menu2();
		}
	})
}

function Verificar_Recordar_Sesion()
{
	$.post("library/funciones.php?action=Verificar_Recordar_Sesion",
	 function(data){

		
		
		if (data!="false")
		{
			window.location.href=data;
		}

	})


}


function Cerrar_Sesion()
{
	$.post("library/funciones.php?action=Cerrar_Sesion",
	 function(data){

		

		window.location.href=data;
	
	})
}

function Nombre_Sesion()
{

	$('#usuario').load("library/funciones.php?action=Nombre_Sesion",
	 function(data){

		
		$('#usuario').html(data);
	
	})


}

function Verificar_Perfil_Menu()
{
	
	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	

	
	$.post("library/funciones.php?action=Generar_Perfil_Menu",
	 function(data){

		
		if (data == "true")
		{
			//$('#orden').show();
			$('#agregar_orden').show();
			$('#editar_cotizacion').show();
			$('#cant_orden_item').html("3");
			$('#cant_cotz_item').html("3");			
			$('#cant_tarea_item').html("2");			
			$('#agregar_tarea').show();
			$('#tareas').show();
			$('#agregar_usuario').show();
			$('#lista_usuario').show();
			$('#detalle').show();
			$('#listar_venta_rapida').show();
			$('#listar_venta_rapida1').show();			
			
			if (filename == "admin.php")
			{
				$('#UClientes').show();
				$('#UTareas').show();
				$('#UCotizacion').show();
				$('#Asignaciones').hide();
				

				Cantidad_Ordenes();
				Ultimas_Ordenes();

			
			}
	
			Tarea_Finalizada();				
		}
		else
		{
			//$('#orden').hide();
			$('#agregar_orden').hide();
			$('#editar_cotizacion').hide();
			$('#cant_orden_item').html("1");
			$('#cant_cotz_item').html("2");			
			$('#cant_tarea_item').html("1");			
			$('#agregar_tarea').hide();
			$('#tareas').hide();
			$('#agregar_usuario').hide();
			$('#lista_usuario').hide();
			$('#detalle').hide();
			$('#listar_venta_rapida').hide();
			$('#listar_venta_rapida1').hide();
			
			if (filename == "admin.php")
			{

				$('#UTareas').hide();

				$('#Asignaciones').show();
				Cantidad_Asignaciones();
				Lista_Asignaciones();		
			}			
			
			if ((filename == "agregar_orden_trabajo.html") | (filename == "editar_cotizacion.html") | (filename == "listar_usuario.html") | (filename == "agregar_usuario.html"))
			window.location = "admin.php";			
		}

		$.post("library/funciones.php?action=Verificar_Administrador",
		function(data){

			if (data == "true")
			{
				$('#agregar_usuario').show();
				$('#reporte_venta_rapida').show();
				$('#reporte_venta_rapida1').show();
				$('#materialimp').show();				
			}
			else if (data == "false")
			{
				$('#agregar_usuario').hide();
				$('#reporte_venta_rapida').hide();
				$('#reporte_venta_rapida1').hide();
				$('#materialimp').hide();				
			}
			
		});		
	})


}

function Verificar_Perfil_Menu1()
{

	$('#menu_sup').load("library/funciones.php?action=Generar_Perfil_Menu",
	 function(data){

		
		$('#menu_sup').html(data);
	
	})


}

function Verificar_Perfil_Menu2()
{

	$('#menu_der').load("library/funciones.php?action=Generar_Perfil_Menu",
	 function(data){

		
		$('#menu_der').html(data);
	
	})


}

	
function Cargar_Librerias()
{

	$.getScript("public/js/plugins/jquery/jquery.min.js");
	
	$.getScript("public/js/plugins/spinner/ui.spinner.js");
	$.getScript("public/js/plugins/spinner/jquery.mousewheel.js");

	$.getScript("public/js/plugins/jquery/jquery-ui.min.js");
	
	$.getScript("public/js/plugins/charts/excanvas.min.js");
	$.getScript("public/js/plugins/charts/jquery.sparkline.min.js");

	$.getScript("public/js/plugins/forms/uniform.js");
	$.getScript("public/js/plugins/forms/jquery.cleditor.js");
	$.getScript("public/js/plugins/forms/jquery.validationEngine-es.js");
	$.getScript("public/js/plugins/forms/jquery.validationEngine.js");
	$.getScript("public/js/plugins/forms/jquery.tagsinput.min.js");
	$.getScript("public/js/plugins/forms/autogrowtextarea.js");
	$.getScript("public/js/plugins/forms/jquery.maskedinput.min.js");
	$.getScript("public/js/plugins/forms/jquery.dualListBox.js");
	$.getScript("public/js/plugins/forms/jquery.inputlimiter.min.js");
	$.getScript("public/js/plugins/forms/chosen.jquery.min.js");

	$.getScript("public/js/plugins/wizard/jquery.form.js");
	$.getScript("public/js/plugins/wizard/jquery.validate.min.js");
	$.getScript("public/js/plugins/wizard/jquery.form.wizard.js");
	
	$.getScript("public/js/plugins/uploader/plupload.js");
	$.getScript("public/js/plugins/uploader/plupload.html5.js");
	$.getScript("public/js/plugins/uploader/plupload.html4.js");	
	$.getScript("public/js/plugins/uploader/jquery.plupload.queue.js");

	$.getScript("public/js/plugins/tables/datatable.js");
	$.getScript("public/js/plugins/tables/tablesort.min.js");
	$.getScript("public/js/plugins/tables/resizable.min.js");

	$.getScript("public/js/plugins/ui/jquery.tipsy.js");
	$.getScript("public/js/plugins/ui/jquery.collapsible.min.js");
	$.getScript("public/js/plugins/ui/jquery.prettyPhoto.js");
	$.getScript("public/js/plugins/ui/jquery.progress.js");
	$.getScript("public/js/plugins/ui/jquery.timeentry.min.js");
	$.getScript("public/js/plugins/ui/jquery.colorpicker.js");	
	$.getScript("public/js/plugins/ui/jquery.jgrowl.js");
	$.getScript("public/js/plugins/ui/jquery.breadcrumbs.js");
	$.getScript("public/js/plugins/ui/jquery.sourcerer.js");
	
	$.getScript("public/js/plugins/calendar.min.js");
	$.getScript("public/js/plugins/elfinder.min.js");

}

function Ultimas_Ordenes()
{
	$("#Ultimas_Ordenes").load("application/controllers/OrdenController.php?action=Ultimas_Ordenes",
	function(data){
	
		$("#Ultimas_Ordenes").html(data);		
		
	});
}


function Cantidad_Asignaciones()
{
	$("#Cantidad_Asignaciones").load("application/controllers/OrdenController.php?action=Cantidad_Asignaciones",
	function(data){
	
		$("#Cantidad_Asignaciones").html(data);		
		
	});
}

function Cantidad_Ordenes()
{
	$("#Cantidad_Ordenes").load("application/controllers/OrdenController.php?action=Cantidad_Ordenes",
	function(data){
	
		$("#Cantidad_Ordenes").html(data);		
		
	});
}

function Lista_Asignaciones()
{
	$("#Lista_Asignaciones").load("application/controllers/OrdenController.php?action=Lista_Asignaciones",
	function(data){
	
		$("#Lista_Asignaciones").html(data);		
		
	});
}

function Tarea_Finalizada()
{
	$("#Tarea_Finalizada").load("application/controllers/OrdenController.php?action=Tarea_Finalizada",
	function (data) {
		if (data != "")
		{
			$("#Tarea_Finalizada").show();		
			$("#Tarea_Finalizada").html(data);
		}
		else
		{
			$("#Tarea_Finalizada").html('');
			$("#Tarea_Finalizada").hide();
		}
	});





}
