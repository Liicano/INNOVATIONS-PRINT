		<!-- Footer line -->
		<div id="footer">
			<div class="wrapper">Todos los Derechos Reservados <a href="http://innovations.ideamospanama.com/" title="">Innovations</a></div>
		</div>
	</div>
	<div id="loading">
	</div>
</div>

<div class="clear"></div>
<script type="text/javascript" src="public/js/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="public/js/plugins/jquery/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="././public/js/plugins/modal/modal.css">

<script type="text/javascript" src="public/js/plugins/forms/chosen.jquery.min.js"></script>
<script type="text/javascript" src="public/js/plugins/ui/jquery.collapsible.min.js"></script>
<script type="text/javascript" src="public/js/plugins/ui/jquery.breadcrumbs.js"></script>

<?php
	$html = '';
	
	//$html .= '<script type="text/javascript" src="public/js/plugins/spinner/ui.spinner.js"></script>';
	//$html .= '<script type="text/javascript" src="public/js/plugins/spinner/jquery.mousewheel.js"></script>';
	
	$html .= '<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>!-->';	
	
	/*$html .= '<script type="text/javascript" src="public/js/plugins/charts/excanvas.min.js"></script>';
	$html .= '<script type="text/javascript" src="public/js/plugins/charts/jquery.flot.js"></script>';	
	$html .= '<script type="text/javascript" src="public/js/plugins/charts/jquery.flot.orderBars.js"></script>';
	$html .= '<script type="text/javascript" src="public/js/plugins/charts/jquery.flot.pie.js"></script>';	
	$html .= '<script type="text/javascript" src="public/js/plugins/charts/jquery.flot.resize.js"></script>';
	$html .= '<script type="text/javascript" src="public/js/plugins/charts/jquery.sparkline.min.js"></script>';	*/	
	
	/*$html .= '';
	$html .= '<script type="text/javascript" src="public/js/plugins/forms/jquery.cleditor.js"></script>';	
	$html .= '';
	$html .= '';	
	$html .= '<script type="text/javascript" src="public/js/plugins/forms/jquery.tagsinput.min.js"></script>';
	$html .= '<script type="text/javascript" src="public/js/plugins/forms/autogrowtextarea.js"></script>';*/

	/*';	
	$html .= '<script type="text/javascript" src="public/js/plugins/forms/jquery.dualListBox.js"></script>';
	$html .= '';*/	
	$html .= '';
	
	/*$html .= '<script type="text/javascript" src="public/js/plugins/wizard/jquery.form.js"></script>';	
	$html .= '';
	$html .= '<script type="text/javascript" src="public/js/plugins/wizard/jquery.form.wizard.js"></script>';*/

	/*$html .= '<script type="text/javascript" src="public/js/plugins/uploader/plupload.js"></script>';	
	$html .= '<script type="text/javascript" src="public/js/plugins/uploader/plupload.html5.js"></script>';
	$html .= '<script type="text/javascript" src="public/js/plugins/uploader/plupload.html4.js"></script>';	
	$html .= '<script type="text/javascript" src="public/js/plugins/uploader/jquery.plupload.queue.js"></script>';	*/
	
	
	/*$html .= '';	
	$html .= '<script type="text/javascript" src="public/js/plugins/tables/tablesort.min.js"></script>';
	$html .= '<script type="text/javascript" src="public/js/plugins/tables/resizable.min.js"></script>';	*/

	//$html .= '<script type="text/javascript" src="public/js/plugins/ui/jquery.tipsy.js"></script>';	
	$html .= '';
	/*$html .= '<script type="text/javascript" src="public/js/plugins/ui/jquery.prettyPhoto.js"></script>';	*/
	$html .= '';

	$html .= '';	
	/*$html .= '<script type="text/javascript" src="public/js/plugins/ui/jquery.colorpicker.js"></script>';
	$html .= '<script type="text/javascript" src="public/js/plugins/ui/jquery.jgrowl.js"></script>';*/	
	$html .= '';
	//$html .= '<script type="text/javascript" src="public/js/plugins/ui/jquery.sourcerer.js"></script>';
	
	$html .= '';
	//$html .= '<script type="text/javascript" src="public/js/plugins/elfinder.min.js"></script>';	

	//$html .= '<script type="text/javascript" src="public/js/custom.js"></script>';	
	$html .= '<script type="text/javascript" src="public/js/bootstrap.js"></script>';	
	
	echo $html;
?>

<!-- SexyAlertBox -->
<script type="text/javascript" charset="ISO-8859-1"  src="public/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" charset="ISO-8859-1"  src="public/js/sexyalertbox.v1.2.jquery.js"></script>		

<script type="text/javascript" src="public/js/funciones.js"></script>
	<?php
		if (isset($_GET['sec'])) {
		
		$html = "";
		
		if ((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"cliente"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"producto")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"material"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"cotizacion")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"venta"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"orden")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"proveedor"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"usuario")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"dropbox"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"subir_arte")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"abono"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"bodega")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"tienda"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"ubicacion"))))
		{
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/plugins/forms/jquery.validationEngine.js"></script>
			<script charset="ISO-8859-1" type="text/javascript" src="public/js/plugins/wizard/jquery.validate.min.js"></script>
			<script charset="ISO-8859-1" type="text/javascript" src="public/js/plugins/forms/jquery.validationEngine-es.js"></script>
			<script charset="ISO-8859-1" type="text/javascript" src="public/js/plugins/forms/jquery.inputlimiter.min_es.js"></script>
			<script charset="ISO-8859-1" type="text/javascript" src="public/js/plugins/forms/jquery.maskedinput.min.js"></script>
			<script charset="ISO-8859-1" type="text/javascript" src="public/js/plugins/forms/uniform.js"></script>
			<script charset="ISO-8859-1" type="text/javascript" src="public/js/plugins/ui/jquery.timeentry.min.js"></script>
			<script charset="ISO-8859-1" type="text/javascript" src="public/js/plugins/calendar.min.js"></script>
			<script type="text/javascript" src="public/js/plugins/spinner/jquery.mousewheel.js"></script>
			
			<script charset="ISO-8859-1" type="text/javascript" src="public/js/form_validation.js"></script>';
		}

		if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_clientes"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_productos")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_materiales"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_cotizaciones")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_ventas_rapida"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_detalles_ventas")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"reporte_venta_rapida"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_ordenes")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_proveedores"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_usuarios")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_archivos_dropbox"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_cotizaciones_server")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_bodegas"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_ubicaciones")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_tiendas"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_venta")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"movimiento_productos"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"inventario_productos")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_precios_productos"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_categorias_productos"))))
		{
			$html .=  '<script type="text/javascript" src="public/js/plugins/tables/jquery.dataTables.js"></script>
						<script type="text/javascript" src="public/js/plugins/tables/TableTools/dataTables.tableTools.min.js"></script>

						<script type="text/javascript" src="public/js/plugins/tables/Buttons/dataTablesButtons.js"></script>

						<script type="text/javascript" src="public/js/plugins/tables/Buttons/ButtonsFlash.js"></script>

						<script type="text/javascript" src="public/js/plugins/tables/Buttons/jsZip.js"></script>

						<script type="text/javascript" src="public/js/plugins/tables/Buttons/pdfMake.js"></script>

						<script type="text/javascript" src="public/js/plugins/tables/Buttons/vfs_fonts.js"></script>

						<script type="text/javascript" src="public/js/plugins/tables/Buttons/ButtonsHtml5.js"></script>

						<script type="text/javascript" src="public/js/plugins/tables/Buttons/ButtonsPrint.js"></script>

						<script type="text/javascript" src="public/js/plugins/tables/Buttons/ButtonColvis.js"></script>

			';
 		
		}
		
		if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"cliente")))
		{
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/clientes.js"></script>';
		}
		
		if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"producto")))
		{
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/productos.js"></script>';
		}

		if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"bodega")))
		{
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/bodegas.js"></script>';
		}		
		
		if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"tienda")))
		{
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/tiendas.js"></script>';
		}		
		
		if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"ubicacion")))
		{
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/ubicaciones.js"></script>';
		}			
		
		if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"material")))
		{
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/materiales.js"></script>';
		}

		if ((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"cotizacion"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"abono")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_ordenes_trabajos"))))
		{
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/cotizaciones.js"></script>';
		}

		if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"venta")))
		{
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/ventas_rapidas.js"></script>';
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/jssor.slider.mini.js"></script>';			
		}	

		if ((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"orden"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_archivos_dropbox")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"subir_arte"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"movimiento_productos"))))
		{
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/ordenes.js"></script>';
		}

		if ((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"proveedor"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"inventario_productos")))
		or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_precios_productos"))))
		{
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/proveedores.js"></script>';
		}
		
		if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"usuario")))
		{
			$html .=  '<script charset="ISO-8859-1" type="text/javascript" src="public/js/usuarios.js"></script>';
		}
		
		echo $html;
		}else{
			$html = "";
		}
	?>
<script charset="ISO-8859-1">
 $(document).ready(function(){
	$(window).load(function(){
		Verificar_Sesion();
});
	<?php
		
		$html = "";	
		if (isset($_GET['sec']))
		{		
			if(!is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_venta_rapida")))
			{	
				$html .=  '	$("#leftSide").show();
							$(".statsRow").show();
							$("#LineStatsRow").show();
							$("body").css("background","transparent url(\'../images/backgrounds/bodyBg.png\') repeat-y scroll 0px 0px;");
							';	
			}		
			
			if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"cliente")))
			{
				$html .=  '
				$("#PageTitle").html("Clientes");
				$("#dashboard").removeClass("active");
				$("#dashboard").addClass("inactive");
				$("#res_dashboard").removeClass("active");
				$("#res_dashboard").addClass("inactive");			
				$("#clientes").removeClass("exp inactive");
				$("#res_clientes").removeClass("exp inactive");
				$("#clientes").addClass("active");
				$("#res_clientes").addClass("active");
				$("#ul_clientes").show();
				$("#resul_clientes").show();
				$("#inventario").removeClass("active");
				$("#inventario").addClass("exp inactive");			
				$("#ul_inventario").hide();					
				$("#productos").removeClass("active");
				$("#productos").addClass("exp inactive");
				$("#res_productos").removeClass("active");
				$("#res_productos").addClass("exp inactive");			
				$("#ul_productos").hide();
				$("#resul_productos").hide();			
				$("#agregar_producto").removeClass("this");
				$("#res_agregar_producto").removeClass("this");	
				$("#listar_productos").removeClass("this");
				$("#res_listar_productos").removeClass("this");
				$("#movimientos").removeClass("active");
				$("#movimientos").addClass("exp inactive");			
				$("#ul_movimientos").hide();			
				$("#bodegas").removeClass("active");
				$("#bodegas").addClass("exp inactive");
				$("#res_bodegas").removeClass("active");
				$("#res_bodegas").addClass("exp inactive");			
				$("#ul_bodegas").hide();
				$("#resul_bodegas").hide();			
				$("#agregar_bodega").removeClass("this");
				$("#res_agregar_bodega").removeClass("this");	
				$("#listar_bodegas").removeClass("this");
				$("#tiendas").removeClass("active");
				$("#tiendas").addClass("exp inactive");
				$("#res_tiendas").removeClass("active");
				$("#res_tiendas").addClass("exp inactive");			
				$("#ul_tiendas").hide();
				$("#resul_tiendas").hide();			
				$("#agregar_tienda").removeClass("this");
				$("#res_agregar_tienda").removeClass("this");	
				$("#listar_tiendas").removeClass("this");
				$("#res_listar_tiendas").removeClass("this");				
				$("#ubicaciones").removeClass("active");
				$("#ubicaciones").addClass("exp inactive");
				$("#res_ubicaciones").removeClass("active");
				$("#res_ubicaciones").addClass("exp inactive");			
				$("#ul_ubicaciones").hide();
				$("#resul_ubicaciones").hide();			
				$("#agregar_ubicacion").removeClass("this");
				$("#res_agregar_ubicacion").removeClass("this");	
				$("#listar_ubicaciones").removeClass("this");
				$("#res_listar_ubicaciones").removeClass("this");
				$("#ordenes").removeClass("active");
				$("#ordenes").addClass("exp inactive");
				$("#res_ordenes").removeClass("active");
				$("#res_ordenes").addClass("exp inactive");			
				$("#ul_ordenes").hide();
				$("#resul_ordenes").hide();			
				$("#agregar_orden").removeClass("this");
				$("#res_agregar_orden").removeClass("this");	
				$("#listar_ordenes").removeClass("this");
				$("#res_listar_ordenes").removeClass("this");			
				$("#materiales").removeClass("active");
				$("#materiales").addClass("exp inactive");
				$("#res_materiales").removeClass("active");
				$("#res_materiales").addClass("exp inactive");			
				$("#ul_materiales").hide();
				$("#resul_materiales").hide();			
				$("#agregar_material").removeClass("this");
				$("#res_agregar_material").removeClass("this");	
				$("#listar_materiales").removeClass("this");
				$("#res_listar_materiales").removeClass("this");
				$("#cotizaciones").removeClass("active");
				$("#cotizaciones").addClass("exp inactive");
				$("#res_cotizaciones").removeClass("active");
				$("#res_cotizaciones").addClass("exp inactive");			
				$("#ul_cotizaciones").hide();
				$("#resul_cotizaciones").hide();			
				$("#agregar_cotizacion").removeClass("this");
				$("#res_agregar_cotizacion").removeClass("this");	
				$("#listar_cotizaciones").removeClass("this");
				$("#res_listar_cotizaciones").removeClass("this");
				$("#editar_cotizacion").removeClass("this");
				$("#res_editar_cotizacion").removeClass("this");
				$("#ventas_rapidas").removeClass("active");
				$("#ventas_rapidas").addClass("exp inactive");
				$("#res_ventas_rapidas").removeClass("active");
				$("#res_ventas_rapidas").addClass("exp inactive");			
				$("#ul_ventas_rapidas").hide();
				$("#resul_ventas_rapidas").hide();			
				$("#agregar_venta_rapida").removeClass("this");
				$("#res_agregar_venta_rapida").removeClass("this");	
				$("#listar_ventas_rapidas").removeClass("this");
				$("#res_listar_ventas_rapidas").removeClass("this");
				$("#reporte_venta_rapida").removeClass("this");
				$("#res_reporte_venta_rapida").removeClass("this");	
				$("#ordenes_trabajos").removeClass("active");
				$("#ordenes_trabajos").addClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("active");
				$("#res_ordenes_trabajos").addClass("exp inactive");			
				$("#ul_ordenes_trabajos").hide();
				$("#resul_ordenes_trabajos").hide();			
				$("#agregar_orden_trabajo").removeClass("this");
				$("#res_agregar_orden_trabajo").removeClass("this");	
				$("#listar_ordenes_trabajos").removeClass("this");
				$("#res_listar_ordenes_trabajos").removeClass("this");
				$("#editar_orden_trabajo").removeClass("this");
				$("#res_orden_trabajo").removeClass("this");			
				$("#proveedores").removeClass("active");
				$("#proveedores").addClass("exp inactive");
				$("#res_proveedores").removeClass("active");
				$("#res_proveedores").addClass("exp inactive");			
				$("#ul_proveedores").hide();
				$("#resul_proveedores").hide();			
				$("#agregar_proveedor").removeClass("this");
				$("#res_agregar_proveedor").removeClass("this");	
				$("#listar_proveedores").removeClass("this");
				$("#res_listar_proveedores").removeClass("this");			
				';
				
				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_cliente"))) or (is_numeric(stripos(trim($_GET['sec']),"actualizar_cliente"))))
				{
					$html .=  '';				
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_cliente")))
				{	
					$html .=  ' $("#PageTitle").html("Agregar Cliente");
								$("#agregar_cliente").addClass("this");
								$("#res_agregar_cliente").addClass("this");	
								$("#listar_clientes").removeClass("this");
								$("#res_listar_clientes").removeClass("this");
								
								Listar_Tipo_Cliente();
								
								
								$("#NombreEmpresa").hide();				
								$("#RUCEmpresa").hide();
								$("#LogoEmpresa").hide();								
								$("#NombreCliente").hide();				
								$("#ApellidoCliente").hide();				
								$("#NombreContacto").hide();				
								$("#CelularContacto").hide();				
								$("#EmailContacto").hide();								
								$("#lstTipoCliente").val("");













								'.((base64_decode($_SESSION['id_tipo_usuario']) == 1)?'$("input[name=\'rdbCredito\']").attr("disabled",false);':'$("#rdbCredito1").attr("checked",false);$("#uniform-rdbCredito1>span").removeClass("checked");$("#rdbCredito2").attr("checked",true);$("#uniform-rdbCredito2>span").addClass("checked");$("input[name=\'rdbCredito\']").attr("disabled",true);$("input[name=\'rdbCredito\']").val(0);').'	
							
								$("#lstTipoCliente").change(function(){			
									if ($("#lstTipoCliente").prop("selectedIndex") == "1")			
									{				
										$("#NombreCliente").show();				
										$("#ApellidoCliente").show();				
										$("#NombreEmpresa").hide();				
										$("#RUCEmpresa").hide();
										$("#LogoEmpresa").hide();			
										$("#NombreContacto").hide();				
										$("#CelularContacto").hide();				
										$("#EmailContacto").hide();								
										$("#PageTitle").html("Agregar Cliente - Persona");
									
									}			
									else if ($("#lstTipoCliente").prop("selectedIndex") == "2")			
									{				
										$("#NombreEmpresa").show();				
										$("#RUCEmpresa").show();	
										$("#LogoEmpresa").show();				
										$("#NombreContacto").show();				
										$("#CelularContacto").show();				
										$("#EmailContacto").show();									
										$("#NombreCliente").hide();				
										$("#ApellidoCliente").hide();				
										$("#PageTitle").html("Agregar Cliente - Empresa");			
									}			
									else			
									{				
										$("#NombreEmpresa").hide();				
										$("#RUCEmpresa").hide();	
										$("#LogoEmpresa").hide();							
										$("#NombreCliente").hide();				
										$("#ApellidoCliente").hide();				
										$("#NombreContacto").hide();				
										$("#CelularContacto").hide();				
										$("#EmailContacto").hide();					
										$("#PageTitle").html("Agregar Cliente");						
									}
									
								});							
								
								';	
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_clientes")))
				{
					$html .=  '	$("#PageTitle").html("Listar Clientes");
								$("#listar_clientes").addClass("this");
								$("#res_listar_clientes").addClass("this");
							   $("#agregar_cliente").removeClass("this");
							   $("#res_agregar_cliente").removeClass("this");
							   
								//$("#Tipo1").html("Listar Cliente");
								$("#TablaCliente").hide();
								$("#Lista_Cliente_Persona").hide();
								$("#Lista_Cliente_Empresa").hide();
								//$("#Lista_Cliente").empty();
								
								$("#lstTipoCliente").change(function(){

									//$("#listado_cliente_persona tbody").empty();	
									//$("#listado_cliente_empresa tbody").empty();
									
									if ($("#lstTipoCliente").prop("selectedIndex") == "1")
									{			
										//$("#Lista_Cliente").empty();				
										$("#PageTitle").html("Listar Clientes - Persona");
										$("#Tipo1").html("Listar Cliente - Persona");
										$("#TablaCliente").show();
										$("#Lista_Cliente_Persona").show();
										$("#Lista_Cliente_Empresa").hide();
									}
									else if ($("#lstTipoCliente").prop("selectedIndex") == "2")
									{
										//$("#Lista_Cliente").empty();				
										$("#PageTitle").html("Listar Clientes - Empresa");
										$("#Tipo1").html("Listar Cliente - Empresa");
										$("#TablaCliente").show();
										$("#Lista_Cliente_Empresa").show();
										$("#Lista_Cliente_Persona").hide();
									}
									else
									{
										$("#PageTitle").html("Listar Clientes");	
										$("#Tipo1").html("Listar Cliente");
										$("#TablaCliente").hide();
										$("#Lista_Cliente_Persona").hide();
										$("#Lista_Cliente_Empresa").hide();
										//$("#Lista_Cliente").empty();
									}
									Listar_Clientes();

									
								});							
								';
				}
		
			}
		
			if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"producto")))
			{
				$html =  '$("#PageTitle").html("Productos");
				$("#dashboard").removeClass("active");
				$("#dashboard").addClass("inactive");
				$("#res_dashboard").removeClass("active");
				$("#res_dashboard").addClass("inactive");
				$("#clientes").removeClass("active");
				$("#clientes").addClass("exp inactive");
				$("#res_clientes").removeClass("active");
				$("#res_clientes").addClass("exp inactive");			
				$("#ul_clientes").hide();
				$("#resul_clientes").hide();			
				$("#agregar_cliente").removeClass("this");
				$("#res_agregar_cliente").removeClass("this");	
				$("#listar_clientes").removeClass("this");
				$("#res_listar_clientes").removeClass("this");
				$("#inventario").removeClass("exp inactive");
				$("#res_inventario").removeClass("exp inactive");
				$("#inventario").addClass("active");
				$("#res_inventario").addClass("active");
				$("#ul_inventario").show();
				$("#resul_inventario").show();			
				$("#productos").removeClass("exp inactive");
				$("#res_productos").removeClass("exp inactive");
				$("#productos").addClass("active");
				$("#res_productos").addClass("active");
				$("#ul_productos").show();
				$("#resul_productos").show();
				$("#movimientos").removeClass("active");
				$("#movimientos").addClass("exp inactive");			
				$("#ul_movimientos").hide();			
				$("#bodegas").removeClass("active");
				$("#bodegas").addClass("exp inactive");
				$("#res_bodegas").removeClass("active");
				$("#res_bodegas").addClass("exp inactive");			
				$("#ul_bodegas").hide();
				$("#resul_bodegas").hide();			
				$("#agregar_bodega").removeClass("this");
				$("#res_agregar_bodega").removeClass("this");	
				$("#listar_bodegas").removeClass("this");
				$("#tiendas").removeClass("active");
				$("#tiendas").addClass("exp inactive");
				$("#res_tiendas").removeClass("active");
				$("#res_tiendas").addClass("exp inactive");			
				$("#ul_tiendas").hide();
				$("#resul_tiendas").hide();			
				$("#agregar_tienda").removeClass("this");
				$("#res_agregar_tienda").removeClass("this");	
				$("#listar_tiendas").removeClass("this");
				$("#res_listar_tiendas").removeClass("this");				
				$("#ubicaciones").removeClass("active");
				$("#ubicaciones").addClass("exp inactive");
				$("#res_ubicaciones").removeClass("active");
				$("#res_ubicaciones").addClass("exp inactive");			
				$("#ul_ubicaciones").hide();
				$("#resul_ubicaciones").hide();			
				$("#agregar_ubicacion").removeClass("this");
				$("#res_agregar_ubicacion").removeClass("this");	
				$("#listar_ubicaciones").removeClass("this");
				$("#res_listar_ubicaciones").removeClass("this");
				$("#ordenes").removeClass("active");
				$("#ordenes").addClass("exp inactive");
				$("#res_ordenes").removeClass("active");
				$("#res_ordenes").addClass("exp inactive");			
				$("#ul_ordenes").hide();
				$("#resul_ordenes").hide();			
				$("#agregar_orden").removeClass("this");
				$("#res_agregar_orden").removeClass("this");	
				$("#listar_ordenes").removeClass("this");
				$("#res_listar_ordenes").removeClass("this");			
				$("#materiales").removeClass("active");
				$("#materiales").addClass("exp inactive");
				$("#res_materiales").removeClass("active");
				$("#res_materiales").addClass("exp inactive");			
				$("#ul_materiales").hide();
				$("#resul_materiales").hide();			
				$("#agregar_material").removeClass("this");
				$("#res_agregar_material").removeClass("this");	
				$("#listar_materiales").removeClass("this");
				$("#res_listar_materiales").removeClass("this");
				$("#cotizaciones").removeClass("active");
				$("#cotizaciones").addClass("exp inactive");
				$("#res_cotizaciones").removeClass("active");
				$("#res_cotizaciones").addClass("exp inactive");			
				$("#ul_cotizaciones").hide();
				$("#resul_cotizaciones").hide();			
				$("#agregar_cotizacion").removeClass("this");
				$("#res_agregar_cotizacion").removeClass("this");	
				$("#listar_cotizaciones").removeClass("this");
				$("#res_listar_cotizaciones").removeClass("this");
				$("#editar_cotizacion").removeClass("this");
				$("#res_editar_cotizacion").removeClass("this");
				$("#ventas_rapidas").removeClass("active");
				$("#ventas_rapidas").addClass("exp inactive");
				$("#res_ventas_rapidas").removeClass("active");
				$("#res_ventas_rapidas").addClass("exp inactive");			
				$("#ul_ventas_rapidas").hide();
				$("#resul_ventas_rapidas").hide();			
				$("#agregar_venta_rapida").removeClass("this");
				$("#res_agregar_venta_rapida").removeClass("this");	
				$("#listar_ventas_rapidas").removeClass("this");
				$("#res_listar_ventas_rapidas").removeClass("this");
				$("#reporte_venta_rapida").removeClass("this");
				$("#res_reporte_venta_rapida").removeClass("this");	
				$("#ordenes_trabajos").removeClass("active");
				$("#ordenes_trabajos").addClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("active");
				$("#res_ordenes_trabajos").addClass("exp inactive");			
				$("#ul_ordenes_trabajos").hide();
				$("#resul_ordenes_trabajos").hide();			
				$("#agregar_orden_trabajo").removeClass("this");
				$("#res_agregar_orden_trabajo").removeClass("this");	
				$("#listar_ordenes_trabajos").removeClass("this");
				$("#res_listar_ordenes_trabajos").removeClass("this");
				$("#editar_orden_trabajo").removeClass("this");
				$("#res_orden_trabajo").removeClass("this");			
				$("#proveedores").removeClass("active");
				$("#proveedores").addClass("exp inactive");
				$("#res_proveedores").removeClass("active");
				$("#res_proveedores").addClass("exp inactive");			
				$("#ul_proveedores").hide();
				$("#resul_proveedores").hide();			
				$("#agregar_proveedor").removeClass("this");
				$("#res_agregar_proveedor").removeClass("this");	
				$("#listar_proveedores").removeClass("this");
				$("#res_listar_proveedores").removeClass("this");			
				';
				
				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_producto"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_producto"))))
				{
					$html .=  '	$("#Ubicacion").hide();
								$("#txtPrecioVenta").attr("readonly",true);
								$("#CodigoProducto").hide();
								$("#CodigoBarra").hide();
								$("#Costo").hide();
								$("#TipoCategoria").hide();
								$("#Marca").hide();				
								$("#Modelo").hide();				
								$("#Color").hide();				
								$("#Tamano").hide();		
								$("#TipoPaquete").hide();
								$("#CantExistInicial").hide();
								$("#CantMin").hide();
								$("#CantAlertMin").hide();
								$("#txtCosto").val("0.00");
								$("#txtPrecioVenta").val("0.00");
								mayuscula("#txtModelo");
								mayuscula("#txtTamano");						
								mayuscula("#txtColor");
								mayuscula("#txtMarca");
								mayuscula("#txtTipo");
								mayuscula("#txtProveedor");
								mayuscula("#txtObservacionProducto");
								mayuscula("#txtCodigoBarra");
								Listar_Proveedor_Auto();
								Listar_Tipo_Producto();
								GenerarCategoria();
								
								
								$("#txtCosto").keydown(function(event){
									if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
										return true;
									}
									else
									{
										return false;
									}
								});	

								$("#txtPrecioVenta").keydown(function(event){
									if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
										return true;
									}
									else
									{
										return false;
									}
								});								
							
								$("#txtCosto").change(function(){
									
									PrecioMoneda(\'txtCosto\');
									Calcular_Precio();
								
								});		
								
								$("#lstTipoCategoria").change(function(){
									
									Calcular_Precio();
								
								});
								
								$("#lstTipoProducto").change(function(){
									
									$("#txtCosto").val("0.00");
									$("#txtPrecioVenta").val("0.00");
									if ($("#lstTipoProducto").prop("selectedIndex") == "1")			
									{				
										$("#Ubicacion").hide();
										$("#txtPrecioVenta").attr("readonly",false);
										$("#txtNombreProducto").attr("readonly",false);	
										$("#CodigoProducto").hide();
										$("#CodigoBarra").show();
										$("#Costo").hide();
										$("#TipoCategoria").hide();
										$("#Tipo").hide();
										$("#Proveedor").hide();	
										$("#Marca").hide();				
										$("#Modelo").hide();				
										$("#Color").hide();				
										$("#Tamano").hide();
										$("#TipoPaquete").hide();
										$("#CantExistInicial").hide();
										$("#CantMin").hide();
										$("#CantAlertMin").hide();
										
										$("#PageTitle").html("Agregar Producto - Servicio");
									
									}			
									else if ($("#lstTipoProducto").prop("selectedIndex") == "2")			
									{				
										$("#Ubicacion").show();
										$("#CodigoProducto").show();
										$("#CodigoBarra").show();
										$("#Costo").show();
										$("#TipoCategoria").show();
										$("#Tipo").show();
										$("#Proveedor").show();
										$("#Marca").show();				
										$("#Modelo").show();				
										$("#Color").show();				
										$("#Tamano").show();
										$("#TipoPaquete").show();
										$("#CantExistInicial").show();
										$("#CantMin").show();
										$("#CantAlertMin").show();
										$("#txtPrecioVenta").attr("readonly",true);
										$("#txtNombreProducto").attr("readonly",true);	
										Listar_Tipo_Descripcion_Producto_Auto();
										Listar_Proveedor_Auto();
										Listar_Marcas_Auto();
										Listar_Modelos_Auto();
										Listar_Colores_Auto();
										Listar_Tamanos_Auto();
										Listar_Ubicacion();
										GenerarTipoEmpaque();
										$("#PageTitle").html("Agregar Producto - Producto");

										$("#txtCodigoProducto,#txtProveedor,#txtMarca,#txtModelo,#txtTamano,#txtColor").change(function(){
											
											Verificar_Codigo_Producto();
											
										});
										
										$("#txtCodigoBarra").change(function(){
											
											Verificar_Codigo_Barra();										
											
										});									
									}			
									else			
									{				
										$("#Ubicacion").hide();
										$("#txtPrecioVenta").attr("readonly",true);
										$("#txtNombreProducto").attr("readonly",true);
										$("#CodigoProducto").hide();
										$("#CodigoBarra").hide();
										$("#Costo").hide();
										$("#TipoCategoria").hide();
										$("#Tipo").hide();
										$("#Marca").hide();				
										$("#Modelo").hide();				
										$("#Color").hide();				
										$("#Tamano").hide();
										$("#TipoPaquete").hide();
										$("#CantExistInicial").hide();
										$("#CantMin").hide();
										$("#CantAlertMin").hide();
										$("#PageTitle").html("Agregar Producto");						
									}
									
								});	
								
								
								';				
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_producto")))
				{	
					$html .=  ' $("#PageTitle").html("Agregar Producto");
								$("#agregar_producto").addClass("this");
								$("#res_agregar_producto").addClass("this");	
								$("#listar_productos").removeClass("this");
								$("#res_listar_productos").removeClass("this");								
								
								';	
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_producto")))
				{	
					$html .=  ' $("#PageTitle").html("Editar Producto");
								$("#agregar_producto").removeClass("this");
								$("#res_agregar_producto").removeClass("this");	
								$("#listar_productos").removeClass("this");
								$("#res_listar_productos").removeClass("this");
								
								Ver_Producto(\''.$_GET['id'].'\');
														
								';	
				}	
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_productos")))
				{
					$html .=  '	$("#PageTitle").html("Listar Productos");
								$("#listar_productos").addClass("this");
								$("#res_listar_productos").addClass("this");
							   $("#agregar_producto").removeClass("this");
							   $("#res_agregar_producto").removeClass("this");
							   
								Listar_Productos();						
								';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"inventario_productos")))
				{
					$html .=  '$("#PageTitle").html("Inventario de Productos");
					Listar_Inventario_Productos();
					GenerarCategoria();
					GenerarProveedores();
					$("#lstTipoCategoria").change(function(){
						Listar_Inventario_Productos();
					});
					$("#lstProveedor").change(function(){
						Listar_Inventario_Productos();
					});	';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_precios_productos")))
				{
					$html .=  '$("#PageTitle").html("Listado de Precios de Productos");
					Listar_Precios_Productos();
					GenerarCategoria();
					GenerarProveedores();
					$("#lstTipoCategoria").change(function(){
						Listar_Precios_Productos();
					});
					$("#lstProveedor").change(function(){
						Listar_Precios_Productos();
					});';
				}	

				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_categoria_producto"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_categoria_producto"))))
				{			
					$html .=  '
								mayuscula("#txtNombreCategoriaProducto");
								$("#txtPorcentaje").change(function(){								
									PrecioMoneda(\'txtPorcentaje\');								
								});
					';			
				
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_categoria_producto")))
				{	
					$html .=  ' $("#PageTitle").html("Agregar Categor&iacute;a de Producto");
								$("#agregar_categoria_producto").addClass("this");
								$("#res_agregar_categoria_producto").addClass("this");	
								$("#listar_categorias_productos").removeClass("this");
								$("#res_listar_productos").removeClass("this");								
								
								';	
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_categoria_producto")))
				{	
					$html .=  ' $("#PageTitle").html("Editar Categor&iacute;a de Producto");
								$("#agregar_categoria_producto").removeClass("this");
								$("#res_agregar_categoria_producto").removeClass("this");	
								$("#listar_categorias_productos").removeClass("this");
								$("#res_listar_categorias_productos").removeClass("this");

								Ver_Categoria_Producto(\''.$_GET['id'].'\');
														
								';	
				}	
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_categorias_productos")))
				{
					$html .=  '	$("#PageTitle").html("Listar Categor&iacute;as de Productos");
								$("#listar_categorias_productos").addClass("this");
								$("#res_listar_categorias_productos").addClass("this");
							   $("#agregar_categoria_producto").removeClass("this");
							   $("#res_agregar_categoria_producto").removeClass("this");
							   
								Listar_Categorias_Productos();						
								';
				}			
		
			}

			if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"bodega")))
			{
				$html = '
				$("#PageTitle").html("Bodega");
				$("#dashboard").removeClass("active");
				$("#dashboard").addClass("inactive");
				$("#res_dashboard").removeClass("active");
				$("#res_dashboard").addClass("inactive");
				$("#clientes").removeClass("active");
				$("#clientes").addClass("exp inactive");
				$("#res_clientes").removeClass("active");
				$("#res_clientes").addClass("exp inactive");			
				$("#ul_clientes").hide();
				$("#resul_clientes").hide();			
				$("#agregar_cliente").removeClass("this");
				$("#res_agregar_cliente").removeClass("this");	
				$("#listar_clientes").removeClass("this");
				$("#res_listar_clientes").removeClass("this");
				$("#inventario").removeClass("active");
				$("#inventario").addClass("exp inactive");			
				$("#ul_inventario").hide();					
				$("#productos").removeClass("active");
				$("#productos").addClass("exp inactive");
				$("#res_productos").removeClass("active");
				$("#res_productos").addClass("exp inactive");			
				$("#ul_productos").hide();
				$("#resul_productos").hide();			
				$("#agregar_producto").removeClass("this");
				$("#res_agregar_producto").removeClass("this");	
				$("#listar_productos").removeClass("this");
				$("#res_listar_productos").removeClass("this");	
				$("#movimientos").removeClass("exp inactive");
				$("#movimientos").addClass("active");			
				$("#ul_movimientos").show();
				$("#bodegas").removeClass("exp inactive");
				$("#res_bodegas").removeClass("exp inactive");
				$("#bodegas").addClass("active");
				$("#res_bodegas").addClass("active");
				$("#ul_bodegas").show();
				$("#resul_bodegas").show();
				$("#ubicaciones").removeClass("active");
				$("#ubicaciones").addClass("exp inactive");
				$("#res_ubicaciones").removeClass("active");
				$("#res_ubicaciones").addClass("exp inactive");			
				$("#ul_ubicaciones").hide();
				$("#resul_ubicaciones").hide();			
				$("#agregar_ubicacion").removeClass("this");
				$("#res_agregar_ubicacion").removeClass("this");	
				$("#listar_ubicaciones").removeClass("this");
				$("#res_listar_ubicaciones").removeClass("this");
				$("#tiendas").removeClass("active");
				$("#tiendas").addClass("exp inactive");
				$("#res_tiendas").removeClass("active");
				$("#res_tiendas").addClass("exp inactive");			
				$("#ul_tiendas").hide();
				$("#resul_tiendas").hide();			
				$("#agregar_tienda").removeClass("this");
				$("#res_agregar_tienda").removeClass("this");	
				$("#listar_tiendas").removeClass("this");
				$("#res_listar_tiendas").removeClass("this");			
				$("#ordenes").removeClass("active");
				$("#ordenes").addClass("exp inactive");
				$("#res_ordenes").removeClass("active");
				$("#res_ordenes").addClass("exp inactive");			
				$("#ul_ordenes").hide();
				$("#resul_ordenes").hide();			
				$("#agregar_orden").removeClass("this");
				$("#res_agregar_orden").removeClass("this");	
				$("#listar_ordenes").removeClass("this");
				$("#res_listar_ordenes").removeClass("this");			
				$("#materiales").removeClass("active");
				$("#materiales").addClass("exp inactive");
				$("#res_materiales").removeClass("active");
				$("#res_materiales").addClass("exp inactive");			
				$("#ul_materiales").hide();
				$("#resul_materiales").hide();			
				$("#agregar_material").removeClass("this");
				$("#res_agregar_material").removeClass("this");	
				$("#listar_materiales").removeClass("this");
				$("#res_listar_materiales").removeClass("this");			
				$("#cotizaciones").removeClass("active");
				$("#cotizaciones").addClass("exp inactive");
				$("#res_cotizaciones").removeClass("active");
				$("#res_cotizaciones").addClass("exp inactive");			
				$("#ul_cotizaciones").hide();
				$("#resul_cotizaciones").hide();			
				$("#agregar_cotizacion").removeClass("this");
				$("#res_agregar_cotizacion").removeClass("this");	
				$("#listar_cotizaciones").removeClass("this");
				$("#res_listar_cotizaciones").removeClass("this");
				$("#editar_cotizacion").removeClass("this");
				$("#res_editar_cotizacion").removeClass("this");
				$("#ventas_rapidas").removeClass("active");
				$("#ventas_rapidas").addClass("exp inactive");
				$("#res_ventas_rapidas").removeClass("active");
				$("#res_ventas_rapidas").addClass("exp inactive");			
				$("#ul_ventas_rapidas").hide();
				$("#resul_ventas_rapidas").hide();			
				$("#agregar_venta_rapida").removeClass("this");
				$("#res_agregar_venta_rapida").removeClass("this");	
				$("#listar_ventas_rapidas").removeClass("this");
				$("#res_listar_ventas_rapidas").removeClass("this");
				$("#reporte_venta_rapida").removeClass("this");
				$("#res_reporte_venta_rapida").removeClass("this");
				$("#ordenes_trabajos").removeClass("active");
				$("#ordenes_trabajos").addClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("active");
				$("#res_ordenes_trabajos").addClass("exp inactive");			
				$("#ul_ordenes_trabajos").hide();
				$("#resul_ordenes_trabajos").hide();			
				$("#agregar_orden_trabajo").removeClass("this");
				$("#res_agregar_orden_trabajo").removeClass("this");	
				$("#listar_ordenes_trabajos").removeClass("this");
				$("#res_listar_ordenes_trabajos").removeClass("this");
				$("#editar_orden_trabajo").removeClass("this");
				$("#res_orden_trabajo").removeClass("this");			
				$("#proveedores").removeClass("active");
				$("#proveedores").addClass("exp inactive");
				$("#res_proveedores").removeClass("active");
				$("#res_proveedores").addClass("exp inactive");			
				$("#ul_proveedores").hide();
				$("#resul_proveedores").hide();			
				$("#agregar_proveedor").removeClass("this");
				$("#res_agregar_proveedor").removeClass("this");	
				$("#listar_proveedores").removeClass("this");
				$("#res_listar_proveedores").removeClass("this");	
				';
				
				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_bodega"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_bodega"))))
				{
					$html .=  'mayuscula("#txtDescripcion");
					mayuscula("#txtDireccion");
					mayuscula("#txtTelefono");
					
					$("#txtTelefono").keydown(function(event){

						if(event.keyCode == 69 || event.keyCode == 84 || event.keyCode == 88 ||event.keyCode == 32 || event.keyCode == 109 || event.keyCode == 173 || event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
							return true;
						}
						else
						{
							return false;
						}
					});	
					';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_bodega")))
				{
					$html .=  ' $("#PageTitle").html("Agregar Bodega");
								$("#agregar_bodega").addClass("this");
								$("#res_agregar_bodega").addClass("this");	
								$("#listar_bodegas").removeClass("this");
								$("#res_listar_bodegas").removeClass("this");';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_bodegas")))
				{
					$html .=  ' $("#PageTitle").html("Listar Bodegas");
								$("#agregar_bodega").removeClass("this");
								$("#res_agregar_bodega").removeClass("this");	
								$("#listar_bodegas").addClass("this");
								$("#res_listar_bodegas").addClass("this");
					
								Listar_Bodegas();';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_bodega")))
				{
					$html .=  'Ver_Bodega(\''.$_GET['id'].'\');';
				}

			}

			if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"tienda")))
			{
				$html = '
				$("#PageTitle").html("Tiendas");
				$("#dashboard").removeClass("active");
				$("#dashboard").addClass("inactive");
				$("#res_dashboard").removeClass("active");
				$("#res_dashboard").addClass("inactive");
				$("#clientes").removeClass("active");
				$("#clientes").addClass("exp inactive");
				$("#res_clientes").removeClass("active");
				$("#res_clientes").addClass("exp inactive");			
				$("#ul_clientes").hide();
				$("#resul_clientes").hide();			
				$("#agregar_cliente").removeClass("this");
				$("#res_agregar_cliente").removeClass("this");	
				$("#listar_clientes").removeClass("this");
				$("#res_listar_clientes").removeClass("this");
				$("#inventario").removeClass("active");
				$("#inventario").addClass("exp inactive");			
				$("#ul_inventario").hide();			
				$("#productos").removeClass("active");
				$("#productos").addClass("exp inactive");
				$("#res_productos").removeClass("active");
				$("#res_productos").addClass("exp inactive");			
				$("#ul_productos").hide();
				$("#resul_productos").hide();			
				$("#agregar_producto").removeClass("this");
				$("#res_agregar_producto").removeClass("this");	
				$("#listar_productos").removeClass("this");
				$("#res_listar_productos").removeClass("this");
				$("#movimientos").removeClass("exp inactive");
				$("#movimientos").addClass("active");		
				$("#ul_movimientos").show();
				$("#bodegas").removeClass("active");
				$("#bodegas").addClass("exp inactive");
				$("#res_bodegas").removeClass("active");
				$("#res_bodegas").addClass("exp inactive");			
				$("#ul_bodegas").hide();
				$("#resul_bodegas").hide();			
				$("#agregar_bodega").removeClass("this");
				$("#res_agregar_bodega").removeClass("this");	
				$("#listar_bodegas").removeClass("this");
				$("#res_listar_bodegas").removeClass("this");
				$("#ubicaciones").removeClass("active");
				$("#ubicaciones").addClass("exp inactive");
				$("#res_ubicaciones").removeClass("active");
				$("#res_ubicaciones").addClass("exp inactive");			
				$("#ul_ubicaciones").hide();
				$("#resul_ubicaciones").hide();			
				$("#agregar_ubicacion").removeClass("this");
				$("#res_agregar_ubicacion").removeClass("this");	
				$("#listar_ubicaciones").removeClass("this");
				$("#res_listar_ubicaciones").removeClass("this");			
				$("#tiendas").removeClass("exp inactive");
				$("#res_tiendas").removeClass("exp inactive");
				$("#tiendas").addClass("active");
				$("#res_tiendas").addClass("active");
				$("#ul_tiendas").show();
				$("#resul_tiendas").show();
				$("#ordenes").removeClass("active");
				$("#ordenes").addClass("exp inactive");
				$("#res_ordenes").removeClass("active");
				$("#res_ordenes").addClass("exp inactive");			
				$("#ul_ordenes").hide();
				$("#resul_ordenes").hide();			
				$("#agregar_orden").removeClass("this");
				$("#res_agregar_orden").removeClass("this");	
				$("#listar_ordenes").removeClass("this");
				$("#res_listar_ordenes").removeClass("this");			
				$("#materiales").removeClass("active");
				$("#materiales").addClass("exp inactive");
				$("#res_materiales").removeClass("active");
				$("#res_materiales").addClass("exp inactive");			
				$("#ul_materiales").hide();
				$("#resul_materiales").hide();			
				$("#agregar_material").removeClass("this");
				$("#res_agregar_material").removeClass("this");	
				$("#listar_materiales").removeClass("this");
				$("#res_listar_materiales").removeClass("this");			
				$("#cotizaciones").removeClass("active");
				$("#cotizaciones").addClass("exp inactive");
				$("#res_cotizaciones").removeClass("active");
				$("#res_cotizaciones").addClass("exp inactive");			
				$("#ul_cotizaciones").hide();
				$("#resul_cotizaciones").hide();			
				$("#agregar_cotizacion").removeClass("this");
				$("#res_agregar_cotizacion").removeClass("this");	
				$("#listar_cotizaciones").removeClass("this");
				$("#res_listar_cotizaciones").removeClass("this");
				$("#editar_cotizacion").removeClass("this");
				$("#res_editar_cotizacion").removeClass("this");
				$("#ventas_rapidas").removeClass("active");
				$("#ventas_rapidas").addClass("exp inactive");
				$("#res_ventas_rapidas").removeClass("active");
				$("#res_ventas_rapidas").addClass("exp inactive");			
				$("#ul_ventas_rapidas").hide();
				$("#resul_ventas_rapidas").hide();			
				$("#agregar_venta_rapida").removeClass("this");
				$("#res_agregar_venta_rapida").removeClass("this");	
				$("#listar_ventas_rapidas").removeClass("this");
				$("#res_listar_ventas_rapidas").removeClass("this");
				$("#reporte_venta_rapida").removeClass("this");
				$("#res_reporte_venta_rapida").removeClass("this");
				$("#ordenes_trabajos").removeClass("active");
				$("#ordenes_trabajos").addClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("active");
				$("#res_ordenes_trabajos").addClass("exp inactive");			
				$("#ul_ordenes_trabajos").hide();
				$("#resul_ordenes_trabajos").hide();			
				$("#agregar_orden_trabajo").removeClass("this");
				$("#res_agregar_orden_trabajo").removeClass("this");	
				$("#listar_ordenes_trabajos").removeClass("this");
				$("#res_listar_ordenes_trabajos").removeClass("this");
				$("#editar_orden_trabajo").removeClass("this");
				$("#res_orden_trabajo").removeClass("this");			
				$("#proveedores").removeClass("active");
				$("#proveedores").addClass("exp inactive");
				$("#res_proveedores").removeClass("active");
				$("#res_proveedores").addClass("exp inactive");			
				$("#ul_proveedores").hide();
				$("#resul_proveedores").hide();			
				$("#agregar_proveedor").removeClass("this");
				$("#res_agregar_proveedor").removeClass("this");	
				$("#listar_proveedores").removeClass("this");
				$("#res_listar_proveedores").removeClass("this");
				';
				
				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_tienda"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_tienda"))))
				{
					$html .=  'mayuscula("#txtDescripcion");
					mayuscula("#txtDireccion");
					mayuscula("#txtTelefono");
					
					$("#txtTelefono").keydown(function(event){

						if(event.keyCode == 69 || event.keyCode == 84 || event.keyCode == 88 ||event.keyCode == 32 || event.keyCode == 109 || event.keyCode == 173 || event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
							return true;
						}
						else
						{
							return false;
						}
					});	
					';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_tienda")))
				{
					$html .=  ' $("#PageTitle").html("Agregar Tienda");
								$("#agregar_tienda").addClass("this");
								$("#res_agregar_tienda").addClass("this");	
								$("#listar_tiendas").removeClass("this");
								$("#res_listar_tiendas").removeClass("this");';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_tiendas")))
				{
					$html .=  ' $("#PageTitle").html("Listar Tiendas");
								$("#agregar_tienda").addClass("this");
								$("#res_agregar_tienda").addClass("this");	
								$("#listar_tiendas").removeClass("this");
								$("#res_listar_tiendas").removeClass("this");
					
								Listar_Tiendas();';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_tienda")))
				{
					$html .=  'Ver_Tienda(\''.$_GET['id'].'\');';
				}

			}
			
			if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"ubicacion")))
			{
				$html = '
				$("#PageTitle").html("Ubicaciones");
				$("#dashboard").removeClass("active");
				$("#dashboard").addClass("inactive");
				$("#res_dashboard").removeClass("active");
				$("#res_dashboard").addClass("inactive");
				$("#clientes").removeClass("active");
				$("#clientes").addClass("exp inactive");
				$("#res_clientes").removeClass("active");
				$("#res_clientes").addClass("exp inactive");			
				$("#ul_clientes").hide();
				$("#resul_clientes").hide();			
				$("#agregar_cliente").removeClass("this");
				$("#res_agregar_cliente").removeClass("this");	
				$("#listar_clientes").removeClass("this");
				$("#res_listar_clientes").removeClass("this");
				$("#inventario").removeClass("exp inactive");
				$("#res_inventario").removeClass("exp inactive");
				$("#inventario").addClass("active");
				$("#res_inventario").addClass("active");
				$("#ul_inventario").show();
				$("#resul_inventario").show();			
				$("#productos").removeClass("exp inactive");
				$("#res_productos").removeClass("exp inactive");
				$("#productos").addClass("active");
				$("#res_productos").addClass("active");
				$("#ul_productos").show();
				$("#resul_productos").show();			
				$("#agregar_producto").removeClass("this");
				$("#res_agregar_producto").removeClass("this");	
				$("#listar_productos").removeClass("this");
				$("#res_listar_productos").removeClass("this");
				$("#movimientos").removeClass("active");
				$("#movimientos").addClass("exp inactive");			
				$("#ul_movimientos").hide();
				$("#bodegas").removeClass("active");
				$("#bodegas").addClass("exp inactive");
				$("#res_bodegas").removeClass("active");
				$("#res_bodegas").addClass("exp inactive");			
				$("#ul_bodegas").hide();
				$("#resul_bodegas").hide();			
				$("#agregar_bodega").removeClass("this");
				$("#res_agregar_bodega").removeClass("this");	
				$("#listar_bodegas").removeClass("this");
				$("#res_listar_bodegas").removeClass("this");
				$("#tiendas").removeClass("active");
				$("#tiendas").addClass("exp inactive");
				$("#res_tiendas").removeClass("active");
				$("#res_tiendas").addClass("exp inactive");			
				$("#ul_tiendas").hide();
				$("#resul_tiendas").hide();			
				$("#agregar_tienda").removeClass("this");
				$("#res_agregar_tienda").removeClass("this");	
				$("#listar_tiendas").removeClass("this");
				$("#res_listar_tiendas").removeClass("this");				
				$("#ubicaciones").removeClass("exp inactive");
				$("#res_ubicaciones").removeClass("exp inactive");
				$("#ubicaciones").addClass("active");
				$("#res_ubicaciones").addClass("active");
				$("#ul_ubicaciones").show();
				$("#resul_ubicaciones").show();
				$("#ordenes").removeClass("active");
				$("#ordenes").addClass("exp inactive");
				$("#res_ordenes").removeClass("active");
				$("#res_ordenes").addClass("exp inactive");			
				$("#ul_ordenes").hide();
				$("#resul_ordenes").hide();			
				$("#agregar_orden").removeClass("this");
				$("#res_agregar_orden").removeClass("this");	
				$("#listar_ordenes").removeClass("this");
				$("#res_listar_ordenes").removeClass("this");			
				$("#materiales").removeClass("active");
				$("#materiales").addClass("exp inactive");
				$("#res_materiales").removeClass("active");
				$("#res_materiales").addClass("exp inactive");			
				$("#ul_materiales").hide();
				$("#resul_materiales").hide();			
				$("#agregar_material").removeClass("this");
				$("#res_agregar_material").removeClass("this");	
				$("#listar_materiales").removeClass("this");
				$("#res_listar_materiales").removeClass("this");			
				$("#cotizaciones").removeClass("active");
				$("#cotizaciones").addClass("exp inactive");
				$("#res_cotizaciones").removeClass("active");
				$("#res_cotizaciones").addClass("exp inactive");			
				$("#ul_cotizaciones").hide();
				$("#resul_cotizaciones").hide();			
				$("#agregar_cotizacion").removeClass("this");
				$("#res_agregar_cotizacion").removeClass("this");	
				$("#listar_cotizaciones").removeClass("this");
				$("#res_listar_cotizaciones").removeClass("this");
				$("#editar_cotizacion").removeClass("this");
				$("#res_editar_cotizacion").removeClass("this");
				$("#ventas_rapidas").removeClass("active");
				$("#ventas_rapidas").addClass("exp inactive");
				$("#res_ventas_rapidas").removeClass("active");
				$("#res_ventas_rapidas").addClass("exp inactive");			
				$("#ul_ventas_rapidas").hide();
				$("#resul_ventas_rapidas").hide();			
				$("#agregar_venta_rapida").removeClass("this");
				$("#res_agregar_venta_rapida").removeClass("this");	
				$("#listar_ventas_rapidas").removeClass("this");
				$("#res_listar_ventas_rapidas").removeClass("this");
				$("#reporte_venta_rapida").removeClass("this");
				$("#res_reporte_venta_rapida").removeClass("this");
				$("#ordenes_trabajos").removeClass("active");
				$("#ordenes_trabajos").addClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("active");
				$("#res_ordenes_trabajos").addClass("exp inactive");			
				$("#ul_ordenes_trabajos").hide();
				$("#resul_ordenes_trabajos").hide();			
				$("#agregar_orden_trabajo").removeClass("this");
				$("#res_agregar_orden_trabajo").removeClass("this");	
				$("#listar_ordenes_trabajos").removeClass("this");
				$("#res_listar_ordenes_trabajos").removeClass("this");
				$("#editar_orden_trabajo").removeClass("this");
				$("#res_orden_trabajo").removeClass("this");			
				$("#proveedores").removeClass("active");
				$("#proveedores").addClass("exp inactive");
				$("#res_proveedores").removeClass("active");
				$("#res_proveedores").addClass("exp inactive");			
				$("#ul_proveedores").hide();
				$("#resul_proveedores").hide();			
				$("#agregar_proveedor").removeClass("this");
				$("#res_agregar_proveedor").removeClass("this");	
				$("#listar_proveedores").removeClass("this");
				$("#res_listar_proveedores").removeClass("this");
				';
				
				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_ubicacion"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_ubicacion"))))
				{
					$html .=  'mayuscula("#txtDescripcion");
					Listar_Tienda();	
					';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_ubicacion")))
				{
					$html .=  ' $("#PageTitle").html("Agregar Ubicaci&oacute;n");
								$("#agregar_ubicacion").addClass("this");
								$("#res_agregar_ubicacion").addClass("this");	
								$("#listar_ubicaciones").removeClass("this");
								$("#res_listar_ubicaciones").removeClass("this");';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_ubicaciones")))
				{
					$html .=  ' $("#PageTitle").html("Listar  Ubicaciones");
								$("#agregar_ubicacion").addClass("this");
								$("#res_agregar_ubicacion").addClass("this");	
								$("#listar_ubicaciones").removeClass("this");
								$("#res_listar_ubicaciones").removeClass("this");
					
								Listar_Ubicaciones();';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_ubicacion")))
				{
					$html .=  'Ver_Ubicacion(\''.$_GET['id'].'\');';
				}

			}		
			
			if (((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"orden"))) and !((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"orden_trabajo"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"ordenes_trabajos")))))
			or ((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"movimiento_productos")))))
			{
				$html =  '$("#dashboard").removeClass("active");
				$("#inventario").removeClass("active");
				$("#movimiento").addClass("active");			
				$("#facturacion").removeClass("active");
				$("#cliente").removeClass("active");			
				$("#proveedor").removeClass("active");
				$("#usuarios").removeClass("active");';

				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"orden")))
				{
					$html .=  '$("#PageTitle").html("&Oacute;rdenes");
						$("#dashboard").removeClass("active");
						$("#dashboard").addClass("inactive");
						$("#res_dashboard").removeClass("active");
						$("#res_dashboard").addClass("inactive");
						$("#clientes").removeClass("active");
						$("#clientes").addClass("exp inactive");
						$("#res_clientes").removeClass("active");
						$("#res_clientes").addClass("exp inactive");			
						$("#ul_clientes").hide();
						$("#resul_clientes").hide();			
						$("#agregar_cliente").removeClass("this");
						$("#res_agregar_cliente").removeClass("this");	
						$("#listar_clientes").removeClass("this");
						$("#res_listar_clientes").removeClass("this");
						$("#inventario").removeClass("active");
						$("#inventario").addClass("exp inactive");			
						$("#ul_inventario").hide();							
						$("#productos").removeClass("active");
						$("#productos").addClass("exp inactive");
						$("#res_productos").removeClass("active");
						$("#res_productos").addClass("exp inactive");			
						$("#ul_productos").hide();
						$("#resul_productos").hide();			
						$("#agregar_producto").removeClass("this");
						$("#res_agregar_producto").removeClass("this");	
						$("#listar_productos").removeClass("this");
						$("#res_listar_productos").removeClass("this");
						$("#movimientos").removeClass("exp inactive");
						$("#movimientos").addClass("active");		
						$("#ul_movimientos").show();
						$("#bodegas").removeClass("active");
						$("#bodegas").addClass("exp inactive");
						$("#res_bodegas").removeClass("active");
						$("#res_bodegas").addClass("exp inactive");			
						$("#ul_bodegas").hide();
						$("#resul_bodegas").hide();			
						$("#agregar_bodega").removeClass("this");
						$("#res_agregar_bodega").removeClass("this");	
						$("#listar_bodegas").removeClass("this");
						$("#res_listar_bodegas").removeClass("this");	
						$("#tiendas").removeClass("active");
						$("#tiendas").addClass("exp inactive");
						$("#res_tiendas").removeClass("active");
						$("#res_tiendas").addClass("exp inactive");			
						$("#ul_tiendas").hide();
						$("#resul_tiendas").hide();			
						$("#agregar_tienda").removeClass("this");
						$("#res_agregar_tienda").removeClass("this");	
						$("#listar_tiendas").removeClass("this");
						$("#res_listar_tiendas").removeClass("this");						
						$("#ubicaciones").removeClass("active");
						$("#ubicaciones").addClass("exp inactive");
						$("#res_ubicaciones").removeClass("active");
						$("#res_ubicaciones").addClass("exp inactive");			
						$("#ul_ubicaciones").hide();
						$("#resul_ubicaciones").hide();			
						$("#agregar_ubicacion").removeClass("this");
						$("#res_agregar_ubicacion").removeClass("this");	
						$("#listar_ubicaciones").removeClass("this");
						$("#ordenes").addClass("active");
						$("#res_ordenes").addClass("active");
						$("#ul_ordenes").show();
						$("#resul_ordenes").show();					
						$("#materiales").removeClass("active");
						$("#materiales").addClass("exp inactive");
						$("#res_materiales").removeClass("active");
						$("#res_materiales").addClass("exp inactive");			
						$("#ul_materiales").hide();
						$("#resul_materiales").hide();			
						$("#agregar_material").removeClass("this");
						$("#res_agregar_material").removeClass("this");	
						$("#listar_materiales").removeClass("this");
						$("#res_listar_materiales").removeClass("this");			
						$("#cotizaciones").removeClass("active");
						$("#cotizaciones").addClass("exp inactive");
						$("#res_cotizaciones").removeClass("active");
						$("#res_cotizaciones").addClass("exp inactive");			
						$("#ul_cotizaciones").hide();
						$("#resul_cotizaciones").hide();			
						$("#agregar_cotizacion").removeClass("this");
						$("#res_agregar_cotizacion").removeClass("this");	
						$("#listar_cotizaciones").removeClass("this");
						$("#res_listar_cotizaciones").removeClass("this");
						$("#editar_cotizacion").removeClass("this");
						$("#res_editar_cotizacion").removeClass("this");
						$("#ventas_rapidas").removeClass("active");
						$("#ventas_rapidas").addClass("exp inactive");
						$("#res_ventas_rapidas").removeClass("active");
						$("#res_ventas_rapidas").addClass("exp inactive");			
						$("#ul_ventas_rapidas").hide();
						$("#resul_ventas_rapidas").hide();			
						$("#agregar_venta_rapida").removeClass("this");
						$("#res_agregar_venta_rapida").removeClass("this");	
						$("#listar_ventas_rapidas").removeClass("this");
						$("#res_listar_ventas_rapidas").removeClass("this");
						$("#reporte_venta_rapida").removeClass("this");
						$("#res_reporte_venta_rapida").removeClass("this");
						$("#ordenes_trabajos").removeClass("active");
						$("#ordenes_trabajos").addClass("exp inactive");
						$("#res_ordenes_trabajos").removeClass("active");
						$("#res_ordenes_trabajos").addClass("exp inactive");			
						$("#ul_ordenes_trabajos").hide();
						$("#resul_ordenes_trabajos").hide();			
						$("#agregar_orden_trabajo").removeClass("this");
						$("#res_agregar_orden_trabajo").removeClass("this");	
						$("#listar_ordenes_trabajos").removeClass("this");
						$("#res_listar_ordenes_trabajos").removeClass("this");
						$("#editar_orden_trabajo").removeClass("this");
						$("#res_orden_trabajo").removeClass("this");			
						$("#proveedores").removeClass("active");
						$("#proveedores").addClass("exp inactive");
						$("#res_proveedores").removeClass("active");
						$("#res_proveedores").addClass("exp inactive");			
						$("#ul_proveedores").hide();
						$("#resul_proveedores").hide();			
						$("#agregar_proveedor").removeClass("this");
						$("#res_agregar_proveedor").removeClass("this");	
						$("#listar_proveedores").removeClass("this");
						$("#res_listar_proveedores").removeClass("this");
					
						mayuscula("#txtLugarEntrada");
						mayuscula("#txtLugarSalida");
						mayuscula("#txtProveedor");
						mayuscula("#txtBodegaProcedencia");
						mayuscula("#txtBodegaReceptora");
						mayuscula("#txtObservaciones");';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_orden")))
				{	
					$html .=  '$("#PageTitle").html("Agregar Orden");
						$("#agregar_orden").addClass("this");
						$("#res_agregar_orden").addClass("this");	
						$("#listar_ordenes").removeClass("this");
						$("#res_listar_ordenes").removeClass("this");
						//Mostrar_Numero_Orden();
						Mostrar_Fecha_Orden();
						Mostrar_Usuario_Autoriza();
						Listar_Tipo_Orden ();
						Listar_Tipo_Orden_Entrada ();
						Listar_Proveedor_Auto();';	
						
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_ordenes")))
				{
					$html .=  '$("#PageTitle").html("Listar &Oacute;rdenes");
						$("#agregar_orden").removeClass("this");
						$("#res_agregar_orden").removeClass("this");	
						$("#listar_ordenes").addClass("this");
						$("#res_listar_ordenes").addClass("this");
						Listar_Ordenes();';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_orden")))
				{
					$html .=  'Ver_Orden(\''.$_GET['id'].'\',\''.$_GET['to'].'\',\''.$_GET['toe'].'\');';				
				}

				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"movimiento_productos")))
				{
					$html .=  'Listar_Movimiento_Productos();';
				}
			}
			
			if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"material")))
			{
				$html =  '$("#PageTitle").html("Clientes");
				$("#dashboard").removeClass("active");
				$("#dashboard").addClass("inactive");
				$("#res_dashboard").removeClass("active");
				$("#res_dashboard").addClass("inactive");
				$("#clientes").removeClass("active");
				$("#clientes").addClass("exp inactive");
				$("#res_clientes").removeClass("active");
				$("#res_clientes").addClass("exp inactive");			
				$("#ul_clientes").hide();
				$("#resul_clientes").hide();			
				$("#agregar_cliente").removeClass("this");
				$("#res_agregar_cliente").removeClass("this");	
				$("#listar_clientes").removeClass("this");
				$("#res_listar_clientes").removeClass("this");
				$("#inventario").removeClass("active");
				$("#inventario").addClass("exp inactive");			
				$("#ul_inventario").hide();					
				$("#productos").removeClass("active");
				$("#productos").addClass("exp inactive");
				$("#res_productos").removeClass("active");
				$("#res_productos").addClass("exp inactive");			
				$("#ul_productos").hide();
				$("#resul_productos").hide();			
				$("#agregar_producto").removeClass("this");
				$("#res_agregar_producto").removeClass("this");	
				$("#listar_productos").removeClass("this");
				$("#res_listar_productos").removeClass("this");	
				$("#movimientos").removeClass("active");
				$("#movimientos").addClass("exp inactive");			
				$("#ul_movimientos").hide();			
				$("#bodegas").removeClass("active");
				$("#bodegas").addClass("exp inactive");
				$("#res_bodegas").removeClass("active");
				$("#res_bodegas").addClass("exp inactive");			
				$("#ul_bodegas").hide();
				$("#resul_bodegas").hide();			
				$("#agregar_bodega").removeClass("this");
				$("#res_agregar_bodega").removeClass("this");	
				$("#listar_bodegas").removeClass("this");
				$("#tiendas").removeClass("active");
				$("#tiendas").addClass("exp inactive");
				$("#res_tiendas").removeClass("active");
				$("#res_tiendas").addClass("exp inactive");			
				$("#ul_tiendas").hide();
				$("#resul_tiendas").hide();			
				$("#agregar_tienda").removeClass("this");
				$("#res_agregar_tienda").removeClass("this");	
				$("#listar_tiendas").removeClass("this");
				$("#res_listar_tiendas").removeClass("this");				
				$("#ubicaciones").removeClass("active");
				$("#ubicaciones").addClass("exp inactive");
				$("#res_ubicaciones").removeClass("active");
				$("#res_ubicaciones").addClass("exp inactive");			
				$("#ul_ubicaciones").hide();
				$("#resul_ubicaciones").hide();			
				$("#agregar_ubicacion").removeClass("this");
				$("#res_agregar_ubicacion").removeClass("this");	
				$("#listar_ubicaciones").removeClass("this");
				$("#ordenes").removeClass("active");
				$("#ordenes").addClass("exp inactive");
				$("#res_ordenes").removeClass("active");
				$("#res_ordenes").addClass("exp inactive");			
				$("#ul_ordenes").hide();
				$("#resul_ordenes").hide();			
				$("#agregar_orden").removeClass("this");
				$("#res_agregar_orden").removeClass("this");	
				$("#listar_ordenes").removeClass("this");
				$("#res_listar_ordenes").removeClass("this");				
				$("#materiales").removeClass("exp inactive");
				$("#res_materiales").removeClass("exp inactive");
				$("#materiales").addClass("active");
				$("#res_materiales").addClass("active");
				$("#ul_materiales").show();
				$("#resul_materiales").show();
				$("#cotizaciones").removeClass("active");
				$("#cotizaciones").addClass("exp inactive");
				$("#res_cotizaciones").removeClass("active");
				$("#res_cotizaciones").addClass("exp inactive");			
				$("#ul_cotizaciones").hide();
				$("#resul_cotizaciones").hide();			
				$("#agregar_cotizacion").removeClass("this");
				$("#res_agregar_cotizacion").removeClass("this");	
				$("#listar_cotizaciones").removeClass("this");
				$("#res_listar_cotizaciones").removeClass("this");
				$("#editar_cotizacion").removeClass("this");
				$("#res_editar_cotizacion").removeClass("this");
				$("#ventas_rapidas").removeClass("active");
				$("#ventas_rapidas").addClass("exp inactive");
				$("#res_ventas_rapidas").removeClass("active");
				$("#res_ventas_rapidas").addClass("exp inactive");			
				$("#ul_ventas_rapidas").hide();
				$("#resul_ventas_rapidas").hide();			
				$("#agregar_venta_rapida").removeClass("this");
				$("#res_agregar_venta_rapida").removeClass("this");	
				$("#listar_ventas_rapidas").removeClass("this");
				$("#res_listar_ventas_rapidas").removeClass("this");
				$("#reporte_venta_rapida").removeClass("this");
				$("#res_reporte_venta_rapida").removeClass("this");
				$("#ordenes_trabajos").removeClass("active");
				$("#ordenes_trabajos").addClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("active");
				$("#res_ordenes_trabajos").addClass("exp inactive");			
				$("#ul_ordenes_trabajos").hide();
				$("#resul_ordenes_trabajos").hide();			
				$("#agregar_orden_trabajo").removeClass("this");
				$("#res_agregar_orden_trabajo").removeClass("this");	
				$("#listar_ordenes_trabajos").removeClass("this");
				$("#res_listar_ordenes_trabajos").removeClass("this");
				$("#editar_orden_trabajo").removeClass("this");
				$("#res_orden_trabajo").removeClass("this");			
				$("#proveedores").removeClass("active");
				$("#proveedores").addClass("exp inactive");
				$("#res_proveedores").removeClass("active");
				$("#res_proveedores").addClass("exp inactive");			
				$("#ul_proveedores").hide();
				$("#resul_proveedores").hide();			
				$("#agregar_proveedor").removeClass("this");
				$("#res_agregar_proveedor").removeClass("this");	
				$("#listar_proveedores").removeClass("this");
				$("#res_listar_proveedores").removeClass("this");			
				';		
			
				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_material"))) or (is_numeric(stripos(trim($_GET['sec']),"actualizar_material"))))
				{
					$html .=  '	$("#TamanoAncho").hide();
								$("#TamanoLargo").hide();
								$("#Precio").hide();
								$("#chkCalcularPliego").attr("checked",false);
								GenerarTamanoPliego();
								GenerarListadoTamanoPag();
								
								$("#txtTamanoAncho").keydown(function(event){
									if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
										return true;
									}
									else
									{
										return false;
									}
								});	
								
								$("#txtTamanoLargo").keydown(function(event){
									if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
										return true;
									}
									else
									{
										return false;
									}
								});	
									
								$("#txtPrecioPulgada").keydown(function(event){
									if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
										return true;
									}
									else
									{
										return false;
									}
								});		
							
								$("#txtPrecioPulgada").change(function(){
									
									DecimalesPulgada(\'txtPrecioPulgada\');
							
								});		
								
								$("#txtPrecioPliego").keydown(function(event){
									if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
										return true;
									}
									else
									{
										return false;
									}
								});		
							
								$("#txtPrecioPliego").change(function(){
									
									DecimalesPulgada(\'txtPrecioPliego\');
							
								});	
								
								$("#chkCalcularPliego").change(function(){
									
									if($("#chkCalcularPliego").is(\':checked\') === true)
									{
										$("#TamanoAncho").show();
										$("#TamanoLargo").show();
										$("#Precio").show();
									}
									else
									{
										$("#txtTamanoAncho").val("0.00000000");
										$("#txtTamanoLargo").val("0.00000000");
										$("#txtPrecio").val("0.00");
										$("#TamanoAncho").hide();
										$("#TamanoLargo").hide();
										$("#Precio").hide();
									}
							
								});

								$("#txtTamanoAncho").change(function(){
									Calcular_Precio_Pulgada();
								});	

								$("#TamanoLargo").change(function(){
									Calcular_Precio_Pulgada();
								});
								
								$("#txtPrecioPliego").change(function(){
									Calcular_Precio_Pulgada();
								});	
					';				
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_material")))
				{	
					$html .=  ' $("#PageTitle").html("Agregar Material");
								$("#agregar_materiale").addClass("this");
								$("#res_agregar_materiale").addClass("this");	
								$("#listar_materiales").removeClass("this");
								$("#res_listar_materiales").removeClass("this");	
								
								';	
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_materiales")))
				{
					$html .=  '	$("#PageTitle").html("Listar Materiales");
								$("#listar_materiales").addClass("this");
								$("#res_listar_materiales").addClass("this");
							   $("#agregar_material").removeClass("this");
							   $("#res_agregar_materiale").removeClass("this");
							   
								$("#PrecioPliego").hide();	
								$("#PrecioPulgada").hide();					
								$("#TamanoAncho").hide();	
								$("#TamanoLargo").hide();	
								$("#divActualizar").hide();	
							   
								GenerarMaterialEdicion(); 									
								Listar_Materiales(); 
								$("#lstMaterial").change(function() {

								$("#txtTamanoAncho").val(\'0.00\');					
								$("#txtTamanoLargo").val(\'0.00\');												
								$("#txtPrecioPliego").val(\'0.00\');									
								$("#txtPrecioPulgada").val(\'0.00000000\');		
									if ($("#lstMaterial").val() != 0)				
									{					
									
										$("#TamanoAncho").show();									
										$("#TamanoLargo").show();													
										$("#PrecioPliego").show();							
										$("#PrecioPulgada").show();						
										$("#divActualizar").show();	

										Listar_Materiales($("#lstMaterial").val()); 
									}				
									else				
									{					
										$("#PrecioPliego").hide();					
										$("#PrecioPulgada").hide();									
										$("#TamanoAncho").hide();					
										$("#TamanoLargo").hide();					
										$("#divActualizar").hide();	
										Listar_Materiales();
									}			
								});			
								
								$("#txtTamanoAncho").keydown(function(event){							
									if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 ))
									{
										return true;
									}
									else
									{
										return false;
									}
								});
								
								$("#txtTamanoLargo").keydown(function(event){
									if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 ))
									{
										return true;
									}
									else
									{
										return false;
									}
								});	

								$("#txtPrecioPulgada").keydown(function(event){
									if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 ))
									{
										return true;
									}
									else
									{
										return false;
									}
								});
								
								$("#txtPrecioPulgada").change(function(){
									DecimalesPulgada(\'txtPrecioPulgada\');
								});
				
								$("#txtPrecioPliego").keydown(function(event){
									if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){					return true;				}				else				
									{					
										return false;				
									}			
								});							
								
								$("#txtPrecioPliego").change(function(){								
									PrecioMoneda(\'txtPrecioPliego\');				
									Calcular_Precio_Pulgada();					
								});							
								
								$("#txtTamanoAncho").change(function(){				
									Calcular_Precio_Pulgada();			
								});				
								
								$("#TamanoLargo").change(function(){				
									Calcular_Precio_Pulgada();			
								});									
								
								$("#txtPrecioPulgada").change(function(){
									DecimalesPulgada(\'txtPrecioPulgada\');
									Calcular_Precio_Material();
								});					
						';
				}
		
			}
			
			if ((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"cotizacion"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"abono")))) 
			{
				$html =  '$("#PageTitle").html("Cotizaciones");
				$("#dashboard").removeClass("active");
				$("#dashboard").addClass("inactive");
				$("#res_dashboard").removeClass("active");
				$("#res_dashboard").addClass("inactive");
				$("#clientes").removeClass("active");
				$("#clientes").addClass("exp inactive");
				$("#res_clientes").removeClass("active");
				$("#res_clientes").addClass("exp inactive");			
				$("#ul_clientes").hide();
				$("#resul_clientes").hide();			
				$("#agregar_cliente").removeClass("this");
				$("#res_agregar_cliente").removeClass("this");	
				$("#listar_clientes").removeClass("this");
				$("#res_listar_clientes").removeClass("this");	
				$("#inventario").removeClass("active");
				$("#inventario").addClass("exp inactive");			
				$("#ul_inventario").hide();					
				$("#productos").removeClass("active");
				$("#productos").addClass("exp inactive");
				$("#res_productos").removeClass("active");
				$("#res_productos").addClass("exp inactive");			
				$("#ul_productos").hide();
				$("#resul_productos").hide();			
				$("#agregar_producto").removeClass("this");
				$("#res_agregar_producto").removeClass("this");	
				$("#listar_productos").removeClass("this");
				$("#res_listar_productos").removeClass("this");	
				$("#movimientos").removeClass("active");
				$("#movimientos").addClass("exp inactive");			
				$("#ul_movimientos").hide();			
				$("#bodegas").removeClass("active");
				$("#bodegas").addClass("exp inactive");
				$("#res_bodegas").removeClass("active");
				$("#res_bodegas").addClass("exp inactive");			
				$("#ul_bodegas").hide();
				$("#resul_bodegas").hide();			
				$("#agregar_bodega").removeClass("this");
				$("#res_agregar_bodega").removeClass("this");	
				$("#listar_bodegas").removeClass("this");
				$("#tiendas").removeClass("active");
				$("#tiendas").addClass("exp inactive");
				$("#res_tiendas").removeClass("active");
				$("#res_tiendas").addClass("exp inactive");			
				$("#ul_tiendas").hide();
				$("#resul_tiendas").hide();			
				$("#agregar_tienda").removeClass("this");
				$("#res_agregar_tienda").removeClass("this");	
				$("#listar_tiendas").removeClass("this");
				$("#res_listar_tiendas").removeClass("this");				
				$("#ubicaciones").removeClass("active");
				$("#ubicaciones").addClass("exp inactive");
				$("#res_ubicaciones").removeClass("active");
				$("#res_ubicaciones").addClass("exp inactive");			
				$("#ul_ubicaciones").hide();
				$("#resul_ubicaciones").hide();			
				$("#agregar_ubicacion").removeClass("this");
				$("#res_agregar_ubicacion").removeClass("this");	
				$("#listar_ubicaciones").removeClass("this");
				$("#res_listar_ubicaciones").removeClass("this");
				$("#ordenes").removeClass("active");
				$("#ordenes").addClass("exp inactive");
				$("#res_ordenes").removeClass("active");
				$("#res_ordenes").addClass("exp inactive");			
				$("#ul_ordenes").hide();
				$("#resul_ordenes").hide();			
				$("#agregar_orden").removeClass("this");
				$("#res_agregar_orden").removeClass("this");	
				$("#listar_ordenes").removeClass("this");
				$("#res_listar_ordenes").removeClass("this");			
				$("#materiales").removeClass("active");
				$("#materiales").addClass("exp inactive");
				$("#res_materiales").removeClass("active");
				$("#res_materiales").addClass("exp inactive");			
				$("#ul_materiales").hide();
				$("#resul_materiales").hide();			
				$("#agregar_material").removeClass("this");
				$("#res_agregar_material").removeClass("this");	
				$("#listar_materiales").removeClass("this");
				$("#res_listar_materiales").removeClass("this");
				$("#cotizaciones").removeClass("exp inactive");
				$("#res_cotizaciones").removeClass("exp inactive");
				$("#cotizaciones").addClass("active");
				$("#res_cotizaciones").addClass("active");
				$("#ul_cotizaciones").show();
				$("#resul_cotizaciones").show();
				$("#ventas_rapidas").removeClass("active");
				$("#ventas_rapidas").addClass("exp inactive");
				$("#res_ventas_rapidas").removeClass("active");
				$("#res_ventas_rapidas").addClass("exp inactive");			
				$("#ul_ventas_rapidas").hide();
				$("#resul_ventas_rapidas").hide();			
				$("#agregar_venta_rapida").removeClass("this");
				$("#res_agregar_venta_rapida").removeClass("this");	
				$("#listar_ventas_rapidas").removeClass("this");
				$("#res_listar_ventas_rapidas").removeClass("this");
				$("#reporte_venta_rapida").removeClass("this");
				$("#res_reporte_venta_rapida").removeClass("this");			
				$("#ordenes_trabajos").removeClass("active");
				$("#ordenes_trabajos").addClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("active");
				$("#res_ordenes_trabajos").addClass("exp inactive");			
				$("#ul_ordenes_trabajos").hide();
				$("#resul_ordenes_trabajos").hide();			
				$("#agregar_orden_trabajo").removeClass("this");
				$("#res_agregar_orden_trabajo").removeClass("this");	
				$("#listar_ordenes_trabajos").removeClass("this");
				$("#res_listar_ordenes_trabajos").removeClass("this");
				$("#editar_orden_trabajo").removeClass("this");
				$("#res_orden_trabajo").removeClass("this");			
				$("#proveedores").removeClass("active");
				$("#proveedores").addClass("exp inactive");
				$("#res_proveedores").removeClass("active");
				$("#res_proveedores").addClass("exp inactive");			
				$("#ul_proveedores").hide();
				$("#resul_proveedores").hide();			
				$("#agregar_proveedor").removeClass("this");
				$("#res_agregar_proveedor").removeClass("this");	
				$("#listar_proveedores").removeClass("this");
				$("#res_listar_proveedores").removeClass("this");			
				';
				
				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_cotizacion"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_cotizacion"))))
				{
					$html .=  'Listar_Cliente_Auto();
								Listar_Descripcion_Cotizacion_Auto();
								$.getScript("public/js/form_validation.js");
								$(\'#Contactos\').hide();	
					';				
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_cotizacion")))
				{	
					$html .=  ' $("#PageTitle").html("Agregar Cotizaci&oacute;n");
								$("#agregar_cotizacion").addClass("this");
								$("#res_agregar_cotizacion").addClass("this");	
								$("#listar_cotizaciones").removeClass("this");
								$("#res_listar_cotizaciones").removeClass("this");	
								$("#editar_cotizacion").removeClass("this");
								$("#res_editar_cotizacion").removeClass("this");
								
															
								';	
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_cotizacion")))
				{	
					$html .=  ' $("#PageTitle").html("Editar  Cotizaci&oacute;n");
								$("#agregar_cotizacion").removeClass("this");
								$("#res_agregar_cotizacion").removeClass("this");	
								$("#listar_cotizaciones").removeClass("this");
								$("#res_listar_cotizaciones").removeClass("this");
								$("#editar_cotizacion").addClass("this");
								$("#res_editar_cotizacion").addClass("this");							
								
								Listar_Cotizacion_Auto();		
								
								Buscar_Cotizacion(\''.$_GET['id'].'\');
								Buscar_Cliente(\''.$_GET['id'].'\');
								Cargar_Cotizacion(\''.$_GET['id'].'\');	

								$(\'#Listar_Cotizacion\').hide(); 
			
								';	

				}

				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_abono"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_abono"))))
				{
					$html .=  'GenerarTipoPago();
									
								//$.getScript("public/js/form_validation.js");
								
								//$(\'#Contactos\').hide();	
					';				
				}			
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_abono")))
				{	
					$html .=  ' $("#PageTitle").html("Agregar Abono");
								$("#agregar_cotizacion").removeClass("this");
								$("#res_agregar_cotizacion").removeClass("this");	
								$("#listar_cotizaciones").removeClass("this");
								$("#res_listar_cotizaciones").removeClass("this");
								$("#editar_cotizacion").addClass("this");
								$("#res_editar_cotizacion").addClass("this");
								Cargar_Saldo(\''.$_GET['id'].'\');							


			
								';	

				}

				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_abono")))
				{	
					$html .=  ' $("#PageTitle").html("Editar Abono");
								$("#agregar_cotizacion").removeClass("this");
								$("#res_agregar_cotizacion").removeClass("this");	
								$("#listar_cotizaciones").removeClass("this");
								$("#res_listar_cotizaciones").removeClass("this");
								$("#editar_cotizacion").addClass("this");
								$("#res_editar_cotizacion").addClass("this");
								Cargar_Saldo(\''.$_GET['id'].'\',\''.$_GET['ab'].'\');	
			
								';	

				}			
				
				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_cotizaciones"))) and (!is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_cotizaciones_server"))))
				{
					$html .=  '	$("#PageTitle").html("Listar  Cotizaciones");
								$("#listar_cotizaciones").addClass("this");
								$("#res_listar_cotizaciones").addClass("this");
							   $("#agregar_cotizacion").removeClass("this");
							   $("#res_agregar_cotizacion").removeClass("this");
								$("#editar_cotizacion").removeClass("this");
								$("#res_editar_cotizacion").removeClass("this");
								$( "#dialog-message" ).dialog({ autoOpen: false });
								Listar_Cotizaciones();	
								
								';
				}
				
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_cotizaciones_server")))
				{
					$html .=  '	$("#PageTitle").html("Listar  Cotizaciones");
								$("#listar_cotizaciones").addClass("this");
								$("#res_listar_cotizaciones").addClass("this");
							   $("#agregar_cotizacion").removeClass("this");
							   $("#res_agregar_cotizacion").removeClass("this");
								$("#editar_cotizacion").removeClass("this");
								$("#res_editar_cotizacion").removeClass("this");
								$( "#dialog-message" ).dialog({ autoOpen: false });
								Listar_Cotizaciones_Server();	
								
								';							
				}	
			}		
			
			if ((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"venta"))) and !(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"inventario_productos"))))
			{
				$html =  '$("#PageTitle").html("Ventas R&Aacute;pidas");
				$("#dashboard").removeClass("active");
				$("#dashboard").addClass("inactive");
				$("#res_dashboard").removeClass("active");
				$("#res_dashboard").addClass("inactive");
				$("#clientes").removeClass("active");
				$("#clientes").addClass("exp inactive");
				$("#res_clientes").removeClass("active");
				$("#res_clientes").addClass("exp inactive");			
				$("#ul_clientes").hide();
				$("#resul_clientes").hide();			
				$("#agregar_cliente").removeClass("this");
				$("#res_agregar_cliente").removeClass("this");	
				$("#listar_clientes").removeClass("this");
				$("#res_listar_clientes").removeClass("this");
				$("#inventario").removeClass("active");
				$("#inventario").addClass("exp inactive");			
				$("#ul_inventario").hide();					
				$("#productos").removeClass("active");
				$("#productos").addClass("exp inactive");
				$("#res_productos").removeClass("active");
				$("#res_productos").addClass("exp inactive");			
				$("#ul_productos").hide();
				$("#resul_productos").hide();			
				$("#agregar_producto").removeClass("this");
				$("#res_agregar_producto").removeClass("this");	
				$("#listar_productos").removeClass("this");
				$("#res_listar_productos").removeClass("this");
				$("#movimientos").removeClass("active");
				$("#movimientos").addClass("exp inactive");			
				$("#ul_movimientos").hide();			
				$("#bodegas").removeClass("active");
				$("#bodegas").addClass("exp inactive");
				$("#res_bodegas").removeClass("active");
				$("#res_bodegas").addClass("exp inactive");			
				$("#ul_bodegas").hide();
				$("#resul_bodegas").hide();			
				$("#agregar_bodega").removeClass("this");
				$("#res_agregar_bodega").removeClass("this");	
				$("#listar_bodegas").removeClass("this");
				$("#tiendas").removeClass("active");
				$("#tiendas").addClass("exp inactive");
				$("#res_tiendas").removeClass("active");
				$("#res_tiendas").addClass("exp inactive");			
				$("#ul_tiendas").hide();
				$("#resul_tiendas").hide();			
				$("#agregar_tienda").removeClass("this");
				$("#res_agregar_tienda").removeClass("this");	
				$("#listar_tiendas").removeClass("this");
				$("#res_listar_tiendas").removeClass("this");				
				$("#ubicaciones").removeClass("active");
				$("#ubicaciones").addClass("exp inactive");
				$("#res_ubicaciones").removeClass("active");
				$("#res_ubicaciones").addClass("exp inactive");			
				$("#ul_ubicaciones").hide();
				$("#resul_ubicaciones").hide();			
				$("#agregar_ubicacion").removeClass("this");
				$("#res_agregar_ubicacion").removeClass("this");	
				$("#listar_ubicaciones").removeClass("this");
				$("#res_listar_ubicaciones").removeClass("this");
				$("#ordenes").removeClass("active");
				$("#ordenes").addClass("exp inactive");
				$("#res_ordenes").removeClass("active");
				$("#res_ordenes").addClass("exp inactive");			
				$("#ul_ordenes").hide();
				$("#resul_ordenes").hide();			
				$("#agregar_orden").removeClass("this");
				$("#res_agregar_orden").removeClass("this");	
				$("#listar_ordenes").removeClass("this");
				$("#res_listar_ordenes").removeClass("this");			
				$("#materiales").removeClass("active");
				$("#materiales").addClass("exp inactive");
				$("#res_materiales").removeClass("active");
				$("#res_materiales").addClass("exp inactive");			
				$("#ul_materiales").hide();
				$("#resul_materiales").hide();			
				$("#agregar_material").removeClass("this");
				$("#res_agregar_material").removeClass("this");	
				$("#listar_materiales").removeClass("this");
				$("#res_listar_materiales").removeClass("this");
				$("#cotizaciones").removeClass("active");
				$("#cotizaciones").addClass("exp inactive");
				$("#res_cotizaciones").removeClass("active");
				$("#res_cotizaciones").addClass("exp inactive");			
				$("#ul_cotizaciones").hide();
				$("#resul_cotizaciones").hide();			
				$("#agregar_cotizacion").removeClass("this");
				$("#res_agregar_cotizacion").removeClass("this");	
				$("#listar_cotizaciones").removeClass("this");
				$("#res_listar_cotizaciones").removeClass("this");
				$("#editar_cotizacion").removeClass("this");
				$("#res_editar_cotizacion").removeClass("this");	
				$("#ventas_rapidas").removeClass("exp inactive");
				$("#res_ventas_rapidas").removeClass("exp inactive");
				$("#ventas_rapidas").addClass("active");
				$("#res_ventas_rapidas").addClass("active");
				$("#ul_ventas_rapidas").show();
				$("#resul_ventas_rapidas").show();			
				$("#ordenes_trabajos").removeClass("active");
				$("#ordenes_trabajos").addClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("active");
				$("#res_ordenes_trabajos").addClass("exp inactive");			
				$("#ul_ordenes_trabajos").hide();
				$("#resul_ordenes_trabajos").hide();			
				$("#agregar_orden_trabajo").removeClass("this");
				$("#res_agregar_orden_trabajo").removeClass("this");	
				$("#listar_ordenes_trabajos").removeClass("this");
				$("#res_listar_ordenes_trabajos").removeClass("this");
				$("#editar_orden_trabajo").removeClass("this");
				$("#res_orden_trabajo").removeClass("this");			
				$("#proveedores").removeClass("active");
				$("#proveedores").addClass("exp inactive");
				$("#res_proveedores").removeClass("active");
				$("#res_proveedores").addClass("exp inactive");			
				$("#ul_proveedores").hide();
				$("#resul_proveedores").hide();			
				$("#agregar_proveedor").removeClass("this");
				$("#res_agregar_proveedor").removeClass("this");	
				$("#listar_proveedores").removeClass("this");
				$("#res_listar_proveedores").removeClass("this");			
				';
				
				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_venta_rapida"))) or (is_numeric(stripos(trim($_GET['sec']),"editar_venta_rapida"))))
				{
					$html .=  'mayuscula("#txtNombreCliente");
								mayuscula("#txtDescripcionVenta");
								$("#rowDetalle_0").css("height","440px");
								$("#ListadoProductoCategoria").css("height","305px");
								$( "#dialog-message" ).dialog({ autoOpen: false });
								';				
				}

				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_venta_rapida")))
				{	
					$html .=  ' $("#PageTitle").html("Agregar Venta R&aacute;pida");
								$("#agregar_venta_rapida").addClass("this");
								$("#res_agregar_venta_rapida").addClass("this");	
								$("#listar_ventas_rapidas").removeClass("this");
								$("#res_listar_ventas_rapidas").removeClass("this");	
								$("#reporte_venta_rapida").removeClass("this");
								$("#res_reporte_venta_rapida").removeClass("this");
								
								$(\'#Contactos\').hide();
								
								Listar_Cliente_Auto();
								Listar_Descripcion_Venta_Auto();
								GenerarTipoVenta();	

								Listar_Producto_Buscar_Venta_Rapida_Auto();
								
								$("#txtCodigoBarra").change(function(){
								
									Agregar_Articulo_Venta_x_Codigo_Barra();
									
								});
							
								$("#leftSide").hide();
								$(".statsRow").hide();
								$("#LineStatsRow").hide();
								$("body").css("background","transparent url(\'public/images/backgrounds/bg.jpg\') repeat scroll 0% 0%");
								';

					if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
					{	
						$html .=  '$("#Exento").show();';
					}
					else
					{
						$html .=  '$("#Exento").hide();';					
					}
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"reporte_venta_rapida")))
				{	
					$html .=  ' $("#PageTitle").html("Reporte de Ventas R&aacute;pidas");
								$("#agregar_venta_rapida").removeClass("this");
								$("#res_agregar_venta_rapida").removeClass("this");	
								$("#listar_ventas_rapidas").removeClass("this");
								$("#res_listar_ventas_rapidas").removeClass("this");
								$("#reporte_venta_rapida").addClass("this");
								$("#res_reporte_venta_rapida").addClass("this");							
								
								$(\'#Contactos\').hide();
								Reporte_Venta_Rapida();							
								';	
				}			
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_ventas_rapida")))
				{
					$html .=  '	$("#PageTitle").html("Listar Ventas Rapidas");
								$("#listar_ventas_rapidas").addClass("this");
								$("#res_listar_ventas_rapidas").addClass("this");
								$("#agregar_venta_rapida").removeClass("this");
								$("#res_agregar_venta_rapida").removeClass("this");
								$("#reporte_venta_rapida").removeClass("this");
								$("#res_reporte_venta_rapida").removeClass("this");
								
								Listar_Ventas_Rapidas();				
								';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_detalles_ventas")))
				{
					$html .=  '	$("#PageTitle").html("Listar Detalles Ventas");
								$("#listar_ventas_rapidas").removeClass("this");
								$("#res_listar_ventas_rapidas").removeClass("this");
								$("#agregar_venta_rapida").removeClass("this");
								$("#res_agregar_venta_rapida").removeClass("this");
								$("#reporte_venta_rapida").removeClass("this");
								$("#res_reporte_venta_rapida").removeClass("this");
								
								Listar_Detalles_Ventas();				
								';
				}			
		
			}		
			
			if ((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"orden_trabajo"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_archivos_dropbox")))
			or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"subir_arte"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"ordenes_trabajos"))))
			{
				$html =  '$("#PageTitle").html("&Oacute;rdenes de Trabajos");
				$("#dashboard").removeClass("active");
				$("#dashboard").addClass("inactive");
				$("#res_dashboard").removeClass("active");
				$("#res_dashboard").addClass("inactive");
				$("#clientes").removeClass("active");
				$("#clientes").addClass("exp inactive");
				$("#res_clientes").removeClass("active");
				$("#res_clientes").addClass("exp inactive");			
				$("#ul_clientes").hide();
				$("#resul_clientes").hide();			
				$("#agregar_cliente").removeClass("this");
				$("#res_agregar_cliente").removeClass("this");	
				$("#listar_clientes").removeClass("this");
				$("#res_listar_clientes").removeClass("this");
				$("#inventario").removeClass("active");
				$("#inventario").addClass("exp inactive");			
				$("#ul_inventario").hide();					
				$("#productos").removeClass("active");
				$("#productos").addClass("exp inactive");
				$("#res_productos").removeClass("active");
				$("#res_productos").addClass("exp inactive");			
				$("#ul_productos").hide();
				$("#resul_productos").hide();			
				$("#agregar_producto").removeClass("this");
				$("#res_agregar_producto").removeClass("this");	
				$("#listar_productos").removeClass("this");
				$("#res_listar_productos").removeClass("this");	
				$("#movimientos").removeClass("active");
				$("#movimientos").addClass("exp inactive");			
				$("#ul_movimientos").hide();			
				$("#bodegas").removeClass("active");
				$("#bodegas").addClass("exp inactive");
				$("#res_bodegas").removeClass("active");
				$("#res_bodegas").addClass("exp inactive");			
				$("#ul_bodegas").hide();
				$("#resul_bodegas").hide();			
				$("#agregar_bodega").removeClass("this");
				$("#res_agregar_bodega").removeClass("this");	
				$("#listar_bodegas").removeClass("this");
				$("#tiendas").removeClass("active");
				$("#tiendas").addClass("exp inactive");
				$("#res_tiendas").removeClass("active");
				$("#res_tiendas").addClass("exp inactive");			
				$("#ul_tiendas").hide();
				$("#resul_tiendas").hide();			
				$("#agregar_tienda").removeClass("this");
				$("#res_agregar_tienda").removeClass("this");	
				$("#listar_tiendas").removeClass("this");
				$("#res_listar_tiendas").removeClass("this");				
				$("#ubicaciones").removeClass("active");
				$("#ubicaciones").addClass("exp inactive");
				$("#res_ubicaciones").removeClass("active");
				$("#res_ubicaciones").addClass("exp inactive");			
				$("#ul_ubicaciones").hide();
				$("#resul_ubicaciones").hide();			
				$("#agregar_ubicacion").removeClass("this");
				$("#res_agregar_ubicacion").removeClass("this");	
				$("#listar_ubicaciones").removeClass("this");
				$("#res_listar_ubicaciones").removeClass("this");
				$("#ordenes").removeClass("active");
				$("#ordenes").addClass("exp inactive");
				$("#res_ordenes").removeClass("active");
				$("#res_ordenes").addClass("exp inactive");			
				$("#ul_ordenes").hide();
				$("#resul_ordenes").hide();			
				$("#agregar_orden").removeClass("this");
				$("#res_agregar_orden").removeClass("this");	
				$("#listar_ordenes").removeClass("this");
				$("#res_listar_ordenes").removeClass("this");			
				$("#materiales").removeClass("active");
				$("#materiales").addClass("exp inactive");
				$("#res_materiales").removeClass("active");
				$("#res_materiales").addClass("exp inactive");			
				$("#ul_materiales").hide();
				$("#resul_materiales").hide();			
				$("#agregar_material").removeClass("this");
				$("#res_agregar_material").removeClass("this");	
				$("#listar_materiales").removeClass("this");
				$("#res_listar_materiales").removeClass("this");
				$("#cotizaciones").removeClass("active");
				$("#cotizaciones").addClass("exp inactive");
				$("#res_cotizaciones").removeClass("active");
				$("#res_cotizaciones").addClass("exp inactive");			
				$("#ul_cotizaciones").hide();
				$("#resul_cotizaciones").hide();			
				$("#agregar_cotizacion").removeClass("this");
				$("#res_agregar_cotizacion").removeClass("this");	
				$("#listar_cotizaciones").removeClass("this");
				$("#res_listar_cotizaciones").removeClass("this");
				$("#editar_cotizacion").removeClass("this");
				$("#res_editar_cotizacion").removeClass("this");
				$("#ventas_rapidas").removeClass("active");
				$("#ventas_rapidas").addClass("exp inactive");
				$("#res_ventas_rapidas").removeClass("active");
				$("#res_ventas_rapidas").addClass("exp inactive");			
				$("#ul_ventas_rapidas").hide();
				$("#resul_ventas_rapidas").hide();			
				$("#agregar_venta_rapida").removeClass("this");
				$("#res_agregar_venta_rapida").removeClass("this");	
				$("#listar_ventas_rapidas").removeClass("this");
				$("#res_listar_ventas_rapidas").removeClass("this");
				$("#reporte_venta_rapida").removeClass("this");
				$("#res_reporte_venta_rapida").removeClass("this");			
				$("#ordenes_trabajos").removeClass("active");
				$("#ordenes_trabajos").addClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("active");
				$("#res_ordenes_trabajos").addClass("exp inactive");			
				$("#ul_ordenes_trabajos").hide();
				$("#resul_ordenes_trabajos").hide();			
				$("#agregar_orden_trabajo").removeClass("this");
				$("#res_agregar_orden_trabajo").removeClass("this");	
				$("#listar_ordenes_trabajos").removeClass("this");
				$("#res_listar_ordenes_trabajos").removeClass("this");
				$("#editar_orden_trabajo").removeClass("this");
				$("#res_orden_trabajo").removeClass("this");			
				$("#proveedores").removeClass("active");
				$("#proveedores").addClass("exp inactive");
				$("#res_proveedores").removeClass("active");
				$("#res_proveedores").addClass("exp inactive");			
				$("#ul_proveedores").hide();
				$("#resul_proveedores").hide();			
				$("#agregar_proveedor").removeClass("this");
				$("#res_agregar_proveedor").removeClass("this");	
				$("#listar_proveedores").removeClass("this");
				$("#res_listar_proveedores").removeClass("this");
				$("#ordenes_trabajos").removeClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("exp inactive");
				$("#ordenes_trabajos").addClass("active");
				$("#res_ordenes_trabajos").addClass("active");
				$("#ul_ordenes_trabajos").show();
				$("#resul_ordenes_trabajos").show();			
				';
				
				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_orden_trabajo"))) or (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"editar_orden_trabajo"))))
				{
					$html .=  '				
						
						Listar_Cotizacion_Orden_Auto();	
						$("#txtNumeroCotizacion").keydown(function(event){
							//alert(event.keyCode);
							if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
								return true;
							}
							else
							{
								return false;
							}
							
							//Listar_Trabajo_Cotizacion(calcMD5($("#txtNumeroCotizacion").val()));
							
						});';				
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_orden_trabajo")))
				{	
					$html .=  ' $("#PageTitle").html("Agregar Orden de Trabajo");
								$("#agregar_orden_trabajo").addClass("this");
								$("#res_agregar_orden_trabajo").addClass("this");	
								$("#listar_ordenes_trabajos").removeClass("this");
								$("#res_listar_ordenes_trabajos").removeClass("this");	
								$("#editar_orden_trabajo").removeClass("this");
								$("#res_editar_orden_trabajo").removeClass("this");
								
									
								//Listar_Usuario_Auto();
								';

								if($_GET['id'] != "")
								{
									$html .=  'Buscar_Cotizacion_Orden(\''.$_GET['id'].'\');';
									$html .=  'Listar_Trabajo_Cotizacion(\''.$_GET['id'].'\');';
								}
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_archivos_dropbox")))
				{	
					$html .=  ' $("#PageTitle").html("Listar Archivos de Dropbox");
								$("#agregar_orden_trabajo").removeClass("this");
								$("#res_agregar_orden_trabajo").removeClass("this");	
								$("#listar_ordenes_trabajos").removeClass("this");
								$("#res_listar_ordenes_trabajos").removeClass("this");
								$("#listar_archivos_dropbox").addClass("this");
								$("#res_listar_archivos_dropbox").addClass("this");							
								
								Listar_Archivos_DropBox();				
								';	
				}			
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_ordenes_trabajos")))
				{
					$html .=  '	$("#PageTitle").html("Listar &Oacute;denes de Trabajo");
								$("#listar_ordenes_trabajos").addClass("this");
								$("#res_listar_ordenes_trabajos").addClass("this");
							   $("#agregar_orden_trabajo").removeClass("this");
							   $("#res_agregar_orden_trabajo").removeClass("this");
								$("#editar_orden_trabajo").removeClass("this");
								$("#res_editar_orden_trabajo").removeClass("this");
								
								Listar_Ordenes_Trabajos();					
								';
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"subir_arte")))
				{
					$html .=  '	$("#PageTitle").html("Subir Arte");
								$("#listar_ordenes_trabajos").removeClass("this");
								$("#res_listar_ordenes_trabajos").removeClass("this");
							   $("#agregar_orden_trabajo").removeClass("this");
							   $("#res_agregar_orden_trabajo").removeClass("this");
								$("#editar_orden_trabajo").removeClass("this");
								$("#res_editar_orden_trabajo").removeClass("this");
								

								Listar_Cotizacion_Auto();
								Listar_Descripcion_Cotizacion_Auto();
								Buscar_Cotizacion_Orden(\''.$_GET['id'].'\');				
								';
				}			
		
			}		
			
			if (is_numeric(stripos(trim(base64_decode($_GET['sec'])),"proveedor")))
			{
				$html =  '$("#PageTitle").html("Proveedores");
				$("#dashboard").removeClass("active");
				$("#dashboard").addClass("inactive");
				$("#res_dashboard").removeClass("active");
				$("#res_dashboard").addClass("inactive");
				$("#clientes").removeClass("active");
				$("#clientes").addClass("exp inactive");
				$("#res_clientes").removeClass("active");
				$("#res_clientes").addClass("exp inactive");			
				$("#ul_clientes").hide();
				$("#resul_clientes").hide();			
				$("#agregar_cliente").removeClass("this");
				$("#res_agregar_cliente").removeClass("this");	
				$("#listar_clientes").removeClass("this");
				$("#res_listar_clientes").removeClass("this");
				$("#inventario").removeClass("active");
				$("#inventario").addClass("exp inactive");			
				$("#ul_inventario").hide();					
				$("#productos").removeClass("active");
				$("#productos").addClass("exp inactive");
				$("#res_productos").removeClass("active");
				$("#res_productos").addClass("exp inactive");			
				$("#ul_productos").hide();
				$("#resul_productos").hide();			
				$("#agregar_producto").removeClass("this");
				$("#res_agregar_producto").removeClass("this");	
				$("#listar_productos").removeClass("this");
				$("#res_listar_productos").removeClass("this");	
				$("#movimientos").removeClass("active");
				$("#movimientos").addClass("exp inactive");			
				$("#ul_movimientos").hide();			
				$("#bodegas").removeClass("active");
				$("#bodegas").addClass("exp inactive");
				$("#res_bodegas").removeClass("active");
				$("#res_bodegas").addClass("exp inactive");			
				$("#ul_bodegas").hide();
				$("#resul_bodegas").hide();			
				$("#agregar_bodega").removeClass("this");
				$("#res_agregar_bodega").removeClass("this");	
				$("#listar_bodegas").removeClass("this");
				$("#tiendas").removeClass("active");
				$("#tiendas").addClass("exp inactive");
				$("#res_tiendas").removeClass("active");
				$("#res_tiendas").addClass("exp inactive");			
				$("#ul_tiendas").hide();
				$("#resul_tiendas").hide();			
				$("#agregar_tienda").removeClass("this");
				$("#res_agregar_tienda").removeClass("this");	
				$("#listar_tiendas").removeClass("this");
				$("#res_listar_tiendas").removeClass("this");				
				$("#ubicaciones").removeClass("active");
				$("#ubicaciones").addClass("exp inactive");
				$("#res_ubicaciones").removeClass("active");
				$("#res_ubicaciones").addClass("exp inactive");			
				$("#ul_ubicaciones").hide();
				$("#resul_ubicaciones").hide();			
				$("#agregar_ubicacion").removeClass("this");
				$("#res_agregar_ubicacion").removeClass("this");	
				$("#listar_ubicaciones").removeClass("this");
				$("#res_listar_ubicaciones").removeClass("this");
				$("#ordenes").removeClass("active");
				$("#ordenes").addClass("exp inactive");
				$("#res_ordenes").removeClass("active");
				$("#res_ordenes").addClass("exp inactive");			
				$("#ul_ordenes").hide();
				$("#resul_ordenes").hide();			
				$("#agregar_orden").removeClass("this");
				$("#res_agregar_orden").removeClass("this");	
				$("#listar_ordenes").removeClass("this");
				$("#res_listar_ordenes").removeClass("this");			
				$("#materiales").removeClass("active");
				$("#materiales").addClass("exp inactive");
				$("#res_materiales").removeClass("active");
				$("#res_materiales").addClass("exp inactive");			
				$("#ul_materiales").hide();
				$("#resul_materiales").hide();			
				$("#agregar_material").removeClass("this");
				$("#res_agregar_material").removeClass("this");	
				$("#listar_materiales").removeClass("this");
				$("#res_listar_materiales").removeClass("this");
				$("#cotizaciones").removeClass("active");
				$("#cotizaciones").addClass("exp inactive");
				$("#res_cotizaciones").removeClass("active");
				$("#res_cotizaciones").addClass("exp inactive");			
				$("#ul_cotizaciones").hide();
				$("#resul_cotizaciones").hide();			
				$("#agregar_cotizacion").removeClass("this");
				$("#res_agregar_cotizacion").removeClass("this");	
				$("#listar_cotizaciones").removeClass("this");
				$("#res_listar_cotizaciones").removeClass("this");
				$("#editar_cotizacion").removeClass("this");
				$("#res_editar_cotizacion").removeClass("this");
				$("#ventas_rapidas").removeClass("active");
				$("#ventas_rapidas").addClass("exp inactive");
				$("#res_ventas_rapidas").removeClass("active");
				$("#res_ventas_rapidas").addClass("exp inactive");			
				$("#ul_ventas_rapidas").hide();
				$("#resul_ventas_rapidas").hide();			
				$("#agregar_venta_rapida").removeClass("this");
				$("#res_agregar_venta_rapida").removeClass("this");	
				$("#listar_ventas_rapidas").removeClass("this");
				$("#res_listar_ventas_rapidas").removeClass("this");
				$("#reporte_venta_rapida").removeClass("this");
				$("#res_reporte_venta_rapida").removeClass("this");			
				$("#ordenes_trabajos").removeClass("active");
				$("#ordenes_trabajos").addClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("active");
				$("#res_ordenes_trabajos").addClass("exp inactive");			
				$("#ul_ordenes_trabajos").hide();
				$("#resul_ordenes_trabajos").hide();			
				$("#agregar_orden_trabajo").removeClass("this");
				$("#res_agregar_orden_trabajo").removeClass("this");	
				$("#listar_ordenes_trabajos").removeClass("this");
				$("#res_listar_ordenes_trabajos").removeClass("this");
				$("#editar_orden_trabajo").removeClass("this");
				$("#res_orden_trabajo").removeClass("this");			
				$("#proveedores").removeClass("active");
				$("#proveedores").addClass("exp inactive");
				$("#res_proveedores").removeClass("active");
				$("#res_proveedores").addClass("exp inactive");			
				$("#ul_proveedores").hide();
				$("#resul_proveedores").hide();			
				$("#agregar_proveedor").removeClass("this");
				$("#res_agregar_proveedor").removeClass("this");	
				$("#listar_proveedores").removeClass("this");
				$("#res_listar_proveedores").removeClass("this");
				$("#ordenes_trabajos").removeClass("active");
				$("#ordenes_trabajos").addClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("active");
				$("#res_ordenes_trabajos").addClass("exp inactive");			
				$("#ul_ordenes_trabajos").hide();
				$("#resul_ordenes_trabajos").hide();			
				$("#agregar_orden_trabajo").removeClass("this");
				$("#res_agregar_orden_trabajo").removeClass("this");	
				$("#listar_ordenes_trabajos").removeClass("this");
				$("#res_listar_ordenes_trabajos").removeClass("this");
				$("#editar_orden_trabajo").removeClass("this");
				$("#res_editar_orden_trabajo").removeClass("this");	
				$("#proveedores").removeClass("exp inactive");
				$("#res_proveedores").removeClass("exp inactive");
				$("#proveedores").addClass("active");
				$("#res_proveedores").addClass("active");
				$("#ul_proveedores").show();
				$("#resul_proveedores").show();			
				';
				
				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_proveedor"))) or (is_numeric(stripos(trim($_GET['sec']),"editar_proveedor"))))
				{
					$html .=  '	mayuscula("#txtNombreProveedor");
								mayuscula("#txtDireccion");
								mayuscula("#txtNombreVendedor");';			
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_proveedor")))
				{	
					$html .=  ' $("#PageTitle").html("Agregar Proveedor");
								$("#agregar_proveedor").addClass("this");
								$("#res_agregar_proveedor").addClass("this");	
								$("#listar_proveedores").removeClass("this");
								$("#res_listar_proveedores").removeClass("this");	
							
								';	
				}
							
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_proveedores")))
				{
					$html .=  '	$("#PageTitle").html("Listar Proveedores");
								$("#listar_proveedores").addClass("this");
								$("#res_listar_proveedores").addClass("this");
							   $("#agregar_proveedor").removeClass("this");
							   $("#res_agregar_proveedor").removeClass("this");
								
								Listar_Proveedores();						
								';
				}
		
			}		
			
			if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"usuario")))
			{
				$html =  '$("#PageTitle").html("Dashboard");
				$("#dashboard").removeClass("inactive");
				$("#dashboard").addClass("active");
				$("#res_dashboard").removeClass("inactive");
				$("#res_dashboard").addClass("active");			
				$("#clientes").removeClass("active");
				$("#clientes").addClass("exp inactive");
				$("#res_clientes").removeClass("active");
				$("#res_clientes").addClass("exp inactive");			
				$("#ul_clientes").hide();
				$("#resul_clientes").hide();			
				$("#agregar_cliente").removeClass("this");
				$("#res_agregar_cliente").removeClass("this");	
				$("#listar_clientes").removeClass("this");
				$("#res_listar_clientes").removeClass("this");
				$("#inventario").removeClass("active");
				$("#inventario").addClass("exp inactive");			
				$("#ul_inventario").hide();					
				$("#productos").removeClass("active");
				$("#productos").addClass("exp inactive");
				$("#res_productos").removeClass("active");
				$("#res_productos").addClass("exp inactive");			
				$("#ul_productos").hide();
				$("#resul_productos").hide();			
				$("#agregar_producto").removeClass("this");
				$("#res_agregar_producto").removeClass("this");	
				$("#listar_productos").removeClass("this");
				$("#res_listar_productos").removeClass("this");	
				$("#movimientos").removeClass("active");
				$("#movimientos").addClass("exp inactive");			
				$("#ul_movimientos").hide();			
				$("#bodegas").removeClass("active");
				$("#bodegas").addClass("exp inactive");
				$("#res_bodegas").removeClass("active");
				$("#res_bodegas").addClass("exp inactive");			
				$("#ul_bodegas").hide();
				$("#resul_bodegas").hide();			
				$("#agregar_bodega").removeClass("this");
				$("#res_agregar_bodega").removeClass("this");	
				$("#listar_bodegas").removeClass("this");
				$("#tiendas").removeClass("active");
				$("#tiendas").addClass("exp inactive");
				$("#res_tiendas").removeClass("active");
				$("#res_tiendas").addClass("exp inactive");			
				$("#ul_tiendas").hide();
				$("#resul_tiendas").hide();			
				$("#agregar_tienda").removeClass("this");
				$("#res_agregar_tienda").removeClass("this");	
				$("#listar_tiendas").removeClass("this");
				$("#res_listar_tiendas").removeClass("this");				
				$("#ubicaciones").removeClass("active");
				$("#ubicaciones").addClass("exp inactive");
				$("#res_ubicaciones").removeClass("active");
				$("#res_ubicaciones").addClass("exp inactive");			
				$("#ul_ubicaciones").hide();
				$("#resul_ubicaciones").hide();			
				$("#agregar_ubicacion").removeClass("this");
				$("#res_agregar_ubicacion").removeClass("this");	
				$("#listar_ubicaciones").removeClass("this");
				$("#res_listar_ubicaciones").removeClass("this");
				$("#ordenes").removeClass("active");
				$("#ordenes").addClass("exp inactive");
				$("#res_ordenes").removeClass("active");
				$("#res_ordenes").addClass("exp inactive");			
				$("#ul_ordenes").hide();
				$("#resul_ordenes").hide();			
				$("#agregar_orden").removeClass("this");
				$("#res_agregar_orden").removeClass("this");	
				$("#listar_ordenes").removeClass("this");
				$("#res_listar_ordenes").removeClass("this");			
				$("#materiales").removeClass("active");
				$("#materiales").addClass("exp inactive");
				$("#res_materiales").removeClass("active");
				$("#res_materiales").addClass("exp inactive");			
				$("#ul_materiales").hide();
				$("#resul_materiales").hide();			
				$("#agregar_material").removeClass("this");
				$("#res_agregar_material").removeClass("this");	
				$("#listar_materiales").removeClass("this");
				$("#res_listar_materiales").removeClass("this");
				$("#cotizaciones").removeClass("active");
				$("#cotizaciones").addClass("exp inactive");
				$("#res_cotizaciones").removeClass("active");
				$("#res_cotizaciones").addClass("exp inactive");			
				$("#ul_cotizaciones").hide();
				$("#resul_cotizaciones").hide();			
				$("#agregar_cotizacion").removeClass("this");
				$("#res_agregar_cotizacion").removeClass("this");	
				$("#listar_cotizaciones").removeClass("this");
				$("#res_listar_cotizaciones").removeClass("this");
				$("#editar_cotizacion").removeClass("this");
				$("#res_editar_cotizacion").removeClass("this");
				$("#ventas_rapidas").removeClass("active");
				$("#ventas_rapidas").addClass("exp inactive");
				$("#res_ventas_rapidas").removeClass("active");
				$("#res_ventas_rapidas").addClass("exp inactive");			
				$("#ul_ventas_rapidas").hide();
				$("#resul_ventas_rapidas").hide();			
				$("#agregar_venta_rapida").removeClass("this");
				$("#res_agregar_venta_rapida").removeClass("this");	
				$("#listar_ventas_rapidas").removeClass("this");
				$("#res_listar_ventas_rapidas").removeClass("this");
				$("#reporte_venta_rapida").removeClass("this");
				$("#res_reporte_venta_rapida").removeClass("this");
				$("#ordenes_trabajos").removeClass("active");
				$("#ordenes_trabajos").addClass("exp inactive");
				$("#res_ordenes_trabajos").removeClass("active");
				$("#res_ordenes_trabajos").addClass("exp inactive");			
				$("#ul_ordenes_trabajos").hide();
				$("#resul_ordenes_trabajos").hide();			
				$("#agregar_orden_trabajo").removeClass("this");
				$("#res_agregar_orden_trabajo").removeClass("this");	
				$("#listar_ordenes_trabajos").removeClass("this");
				$("#res_listar_ordenes_trabajos").removeClass("this");
				$("#editar_orden_trabajo").removeClass("this");
				$("#res_editar_orden_trabajo").removeClass("this");			
				$("#proveedores").removeClass("active");
				$("#proveedores").addClass("exp inactive");
				$("#res_proveedores").removeClass("active");
				$("#res_proveedores").addClass("exp inactive");			
				$("#ul_proveedores").hide();
				$("#resul_proveedores").hide();			
				$("#agregar_proveedor").removeClass("this");
				$("#res_agregar_proveedor").removeClass("this");	
				$("#listar_proveedores").removeClass("this");
				$("#res_listar_proveedores").removeClass("this");';

				if((is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_usuario"))) or (is_numeric(stripos(trim($_GET['sec']),"editar_usuario"))))
				{
					$html .=  '';				
				}
				
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_usuario")))
				{	
					$html .=  ' $("#PageTitle").html("Agregar Usuario");
		
								Listar_Tipo_Usuario();
								Listar_Estatus_Usuario();				
								';	
				}
							
				if(is_numeric(stripos(trim(base64_decode($_GET['sec'])),"listar_usuarios")))
				{
					$html .=  '	$("#PageTitle").html("Listar Usuarios");
								
								Listar_Usuarios();						
								';
				}
				
			}
		}
		
		if (!isset($_GET['sec']))
		{
			/*if(!is_numeric(stripos(trim(base64_decode($_GET['sec'])),"agregar_venta_rapida")))
			{	

			}*/				
			$html .=  '	$("#leftSide").show();
						$("body").css("background","transparent url(\'../images/backgrounds/bodyBg.png\') repeat-y scroll 0px 0px;");
						';	
						
			$html .=  '$("#PageTitle").html("Dashboard");
			$("#dashboard").removeClass("inactive");
			$("#dashboard").addClass("active");
			$("#res_dashboard").removeClass("inactive");
			$("#res_dashboard").addClass("active");			
			$("#clientes").removeClass("active");
			$("#clientes").addClass("exp inactive");
			$("#res_clientes").removeClass("active");
			$("#res_clientes").addClass("exp inactive");			
			$("#ul_clientes").hide();
			$("#resul_clientes").hide();			
			$("#agregar_cliente").removeClass("this");
			$("#res_agregar_cliente").removeClass("this");	
			$("#listar_clientes").removeClass("this");
			$("#res_listar_clientes").removeClass("this");
			$("#inventario").removeClass("active");
			$("#inventario").addClass("exp inactive");			
			$("#ul_inventario").hide();					
			$("#productos").removeClass("active");
			$("#productos").addClass("exp inactive");
			$("#res_productos").removeClass("active");
			$("#res_productos").addClass("exp inactive");			
			$("#ul_productos").hide();
			$("#resul_productos").hide();			
			$("#agregar_producto").removeClass("this");
			$("#res_agregar_producto").removeClass("this");	
			$("#listar_productos").removeClass("this");
			$("#res_listar_productos").removeClass("this");
			$("#movimientos").removeClass("active");
			$("#movimientos").addClass("exp inactive");			
			$("#ul_movimientos").hide();			
			$("#bodegas").removeClass("active");
			$("#bodegas").addClass("exp inactive");
			$("#res_bodegas").removeClass("active");
			$("#res_bodegas").addClass("exp inactive");			
			$("#ul_bodegas").hide();
			$("#resul_bodegas").hide();			
			$("#agregar_bodega").removeClass("this");
			$("#res_agregar_bodega").removeClass("this");	
			$("#listar_bodegas").removeClass("this");
			$("#tiendas").removeClass("active");
			$("#tiendas").addClass("exp inactive");
			$("#res_tiendas").removeClass("active");
			$("#res_tiendas").addClass("exp inactive");			
			$("#ul_tiendas").hide();
			$("#resul_tiendas").hide();			
			$("#agregar_tienda").removeClass("this");
			$("#res_agregar_tienda").removeClass("this");	
			$("#listar_tiendas").removeClass("this");
			$("#res_listar_tiendas").removeClass("this");				
			$("#ubicaciones").removeClass("active");
			$("#ubicaciones").addClass("exp inactive");
			$("#res_ubicaciones").removeClass("active");
			$("#res_ubicaciones").addClass("exp inactive");			
			$("#ul_ubicaciones").hide();
			$("#resul_ubicaciones").hide();			
			$("#agregar_ubicacion").removeClass("this");
			$("#res_agregar_ubicacion").removeClass("this");	
			$("#listar_ubicaciones").removeClass("this");
			$("#res_listar_ubicaciones").removeClass("this");
			$("#ordenes").removeClass("active");
			$("#ordenes").addClass("exp inactive");
			$("#res_ordenes").removeClass("active");
			$("#res_ordenes").addClass("exp inactive");			
			$("#ul_ordenes").hide();
			$("#resul_ordenes").hide();			
			$("#agregar_orden").removeClass("this");
			$("#res_agregar_orden").removeClass("this");	
			$("#listar_ordenes").removeClass("this");
			$("#res_listar_ordenes").removeClass("this");			
			$("#materiales").removeClass("active");
			$("#materiales").addClass("exp inactive");
			$("#res_materiales").removeClass("active");
			$("#res_materiales").addClass("exp inactive");			
			$("#ul_materiales").hide();
			$("#resul_materiales").hide();			
			$("#agregar_material").removeClass("this");
			$("#res_agregar_material").removeClass("this");	
			$("#listar_materiales").removeClass("this");
			$("#res_listar_materiales").removeClass("this");
			$("#cotizaciones").removeClass("active");
			$("#cotizaciones").addClass("exp inactive");
			$("#res_cotizaciones").removeClass("active");
			$("#res_cotizaciones").addClass("exp inactive");			
			$("#ul_cotizaciones").hide();
			$("#resul_cotizaciones").hide();			
			$("#agregar_cotizacion").removeClass("this");
			$("#res_agregar_cotizacion").removeClass("this");	
			$("#listar_cotizaciones").removeClass("this");
			$("#res_listar_cotizaciones").removeClass("this");
			$("#editar_cotizacion").removeClass("this");
			$("#res_editar_cotizacion").removeClass("this");
			$("#ventas_rapidas").removeClass("active");
			$("#ventas_rapidas").addClass("exp inactive");
			$("#res_ventas_rapidas").removeClass("active");
			$("#res_ventas_rapidas").addClass("exp inactive");			
			$("#ul_ventas_rapidas").hide();
			$("#resul_ventas_rapidas").hide();			
			$("#agregar_venta_rapida").removeClass("this");
			$("#res_agregar_venta_rapida").removeClass("this");	
			$("#listar_ventas_rapidas").removeClass("this");
			$("#res_listar_ventas_rapidas").removeClass("this");
			$("#reporte_venta_rapida").removeClass("this");
			$("#res_reporte_venta_rapida").removeClass("this");
			$("#ordenes_trabajos").removeClass("active");
			$("#ordenes_trabajos").addClass("exp inactive");
			$("#res_ordenes_trabajos").removeClass("active");
			$("#res_ordenes_trabajos").addClass("exp inactive");			
			$("#ul_ordenes_trabajos").hide();
			$("#resul_ordenes_trabajos").hide();			
			$("#agregar_orden_trabajo").removeClass("this");
			$("#res_agregar_orden_trabajo").removeClass("this");	
			$("#listar_ordenes_trabajos").removeClass("this");
			$("#res_listar_ordenes_trabajos").removeClass("this");
			$("#editar_orden_trabajo").removeClass("this");
			$("#res_editar_orden_trabajo").removeClass("this");			
			$("#proveedores").removeClass("active");
			$("#proveedores").addClass("exp inactive");
			$("#res_proveedores").removeClass("active");
			$("#res_proveedores").addClass("exp inactive");			
			$("#ul_proveedores").hide();
			$("#resul_proveedores").hide();			
			$("#agregar_proveedor").removeClass("this");
			$("#res_agregar_proveedor").removeClass("this");	
			$("#listar_proveedores").removeClass("this");
			$("#res_listar_proveedores").removeClass("this");
			
			';			
			
			if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
			{
				$html .=  '$("#UClientes").show();
						$("#UTareas").show();
						$("#UCotizacion").show();
						$("#Asignaciones").hide();
						Cantidad_Ordenes();
						Ultimas_Ordenes();
						Tarea_Finalizada();';				
			}
			else
			{
				$html .=  '$("#UTareas").hide();
						$("#Asignaciones").show();
						Cantidad_Asignaciones();
						Lista_Asignaciones();';				
				
				
			}

			

		}

		echo $html;		
	?>	

});
</script>
</body>
</html>