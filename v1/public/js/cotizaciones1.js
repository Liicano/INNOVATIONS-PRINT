function Listar_Cliente_Auto()
{

	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);	

	var strHtml0 = '<label>Nombre del Cliente:<span class="req">*</span></label>';
		strHtml0 += '<div class="formRight">';
		strHtml0 += '<input type="text" value="" class="validate[required]" name="txtNombreCliente" id="txtNombreCliente"  style="width:100%"/>';
		strHtml0 += '<input type="hidden" value="" name="hidIdCliente" id="hidIdCliente"/>';
		strHtml0 += '<input type="hidden" value="" name="hidIdTipoCliente" id="hidIdTipoCliente"/>';			
		strHtml0 += '</div>';
		strHtml0 += '<div class="clear">';
		strHtml0 += '</div>';
			

		strHtml0 += '<br />';			
		strHtml0 += '<div class="formRight" style="display:none;" id="VerificarCotizacion" >';
		strHtml0 += '<input type="checkbox" value="1" class="" name="chkVerificarCotizacion" id="chkVerificarCotizacion" disabled="disabled" />&nbsp;&nbsp;Buscar Cotizaciones Anteriores.&nbsp;&nbsp;&nbsp;&nbsp;';		
		strHtml0 += '<select name="lstCotizacion" id="lstCotizacion" class="validate[required]" disabled="disabled"  style="display:none;">';
		strHtml0 += '<option value="">Seleccione la Cotizaci&oacute;n</option>';			
		strHtml0 += '</select>';			
		strHtml0 += '</div>';
		strHtml0 += '<div class="clear">';
		strHtml0 += '</div>';				

	$("#NombreCliente").html(strHtml0);

	$("#txtNombreCliente").autocomplete({
		source: "application/controllers/CotizacionController.php?action=Listar_Cliente_Autocompletar",
		select:  function(event, ui) {
			//alert(ui.item.hidIdCliente);
			$("#hidIdCliente").val(ui.item.hidIdCliente);
			$("#hidIdTipoCliente").val(ui.item.hidIdTipoCliente);
			$("#chkVerificarCotizacion").attr("checked",false);
			$("#chkVerificarCotizacion").attr('disabled',true);							
			$("#VerificarCotizacion").hide();
			$("#lstCotizacion").empty();					
			$("#lstCotizacion").attr('disabled',true);					
			$("#lstCotizacion").hide();
			
			$.post("application/controllers/CotizacionController.php?action=Tiene_Cotizaciones_Anteriores",
			{
				IdCliente:ui.item.hidIdCliente,
				IdTipoCliente:ui.item.hidIdTipoCliente
			},
			function(data) {
			
				if (data == "true")
				{
					
					$("#chkVerificarCotizacion").attr('disabled',false);				
					$("#VerificarCotizacion").show();
					//$("#hidIdCliente").val(ui.item.id_cliente);
			
					$("#chkVerificarCotizacion").change(function(){
			
						if($("#chkVerificarCotizacion:checked").val() == 1)
						{
							$("#lstCotizacion").attr('disabled',false);
							$("#lstCotizacion").show();
							Listar_Cotizaciones_Anteriores();
					
						}
						else
						{
							$("#lstCotizacion").empty();
							$("#lstCotizacion").attr('disabled',true);					
							$("#lstCotizacion").hide();
						}

			
					});					
				}
				else if (data == "false")
				{
					$("#chkVerificarCotizacion").attr("checked",false);
					$("#chkVerificarCotizacion").attr('disabled',true);							
					$("#VerificarCotizacion").hide();
					$("#lstCotizacion").empty();
					$("#lstCotizacion").attr('disabled',true);					
					$("#lstCotizacion").hide();
				}					
				

			});				
		},
		change: function (event, ui) {
		
			if (ui.item === null)
			{	
				$("#txtNombreCliente").val("");
				$("#hidIdCliente").val("");
				$("#chkVerificarCotizacion").attr("checked",false);
				$("#chkVerificarCotizacion").attr('disabled',true);							
				$("#VerificarCotizacion").hide();
				$("#lstCotizacion").empty();
				$("#lstCotizacion").attr('disabled',true);					
				$("#lstCotizacion").hide();				
			}
			else
			{
				$("#hidIdCliente").val(ui.item.hidIdCliente);
				$("#hidIdTipoCliente").val(ui.item.hidIdTipoCliente);
				
				$.post("application/controllers/CotizacionController.php?action=Tiene_Cotizaciones_Anteriores",
				{
					IdCliente:ui.item.hidIdCliente,
					IdTipoCliente:ui.item.hidIdTipoCliente
				},
				function(data) {
				
					if (data == "true")
					{
						
						$("#chkVerificarCotizacion").attr('disabled',false);				
						$("#VerificarCotizacion").show();
						//$("#hidIdCliente").val(ui.item.id_cliente);
				
						$("#chkVerificarCotizacion").change(function(){
				
							if($("#chkVerificarCotizacion:checked").val() == 1)
							{
								$("#lstCotizacion").attr('disabled',false);
								$("#lstCotizacion").show();
								Listar_Cotizaciones_Anteriores();
						
							}
							else
							{
								$("#lstCotizacion").empty();
								$("#lstCotizacion").attr('disabled',true);					
								$("#lstCotizacion").hide();
							}

				
						});					
					}
					else if (data == "false")
					{
						$("#chkVerificarCotizacion").attr("checked",false);
						$("#chkVerificarCotizacion").attr('disabled',true);							
						$("#VerificarCotizacion").hide();
						$("#lstCotizacion").empty();
						$("#lstCotizacion").attr('disabled',true);					
						$("#lstCotizacion").hide();
					}
				});	
			}				
		}	
	});	
}


function Listar_Producto_Auto(oId)
{
	$("#txtProducto" + oId).autocomplete({
		source: "application/controllers/ProductoController.php?action=Listar_Producto_Autocompletar&v=",
		select:  function(event, ui) {
		//alert(ui.item.value);
		//alert($("#txtProducto" + oId).val());
			
			$("#hidDescProducto" + oId).val(ui.item.value);
			$("#hidIdProducto" + oId).val(ui.item.id_producto);
			$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
			$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
			$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
			$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
			$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
			$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
			
			Generar_Descripcion_Producto(oId);

			$("#txtCantidad" + oId).change(function(){
	
				if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == 'timp') & ($("#txtCantidad" + oId).val() > 1))
				{
					alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
					$("#txtCantidad" + oId).val('0');			
				}
				else if ($("#txtCantidad" + oId).val() == 0) 
				{
					alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
					$("#txtCantidad" + oId).val('0');			
				}					
				else
				{		
					$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
					$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
					$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
					$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
					//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
					Calcular_Total_Cotizacion ();
				}
			});	

			$.post("library/funciones.php?action=Verificar_Administrador",
			function(data){

				if (data == "true")
				{
													
					$("#txtPrecio"+oId).attr("readonly",false);
					$("#txtPrecio"+oId).attr("title","Precio Sugerido");
					
					$("#txtPrecio" + oId).keydown(function(event){
					//alert(event.keyCode);
						if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
							return true;
						}
						else
						{
							return false;
						}
					});
					
					$("#txtPrecio" + oId).change(function(){

						$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
						$("#txtPrecio"+oId).attr("title","Precio Especial");
						$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

						$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
						$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
						$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
	
						Calcular_Total_Cotizacion ();
					});

				}
				else
				{
					$("#txtPrecio"+oId).attr("readonly",true);
				}
			});				
			
			Calcular_Total_Cotizacion ();				
			//BuscarID_Producto(oId);
		},
		change: function (event, ui) {

			if (ui.item === null)
			{	
				$("#txtProducto" + oId).val("");					
				$("#hidDescProducto" + oId).val("");
				$("#hidIdProducto" + oId).val("");
				$("#txtTipoEmpaque" + oId).val("");
				$("#hidTipoEmpaque" + oId).val("");
				$("#txtPrecio" + oId).val("0.00");
				$("#hidPrecio" + oId).val("0.00");
				$("#txtTotal" + oId).val("0.00");
				$("#hidTotal" + oId).val("0.00");			
			}
			else
			{
				
				$("#hidDescProducto" + oId).val(ui.item.value);
				$("#hidIdProducto" + oId).val(ui.item.id_producto);
				$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
				$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
				$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				
				Generar_Descripcion_Producto(oId);

				$("#txtCantidad" + oId).change(function(){
		
					if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == 'timp') & ($("#txtCantidad" + oId).val() > 1))
					{
						alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
						$("#txtCantidad" + oId).val('0');			
					}
					else if ($("#txtCantidad" + oId).val() == 0) 
					{
						alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
						$("#txtCantidad" + oId).val('0');			
					}					
					else
					{		
						$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
						$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
						//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
						Calcular_Total_Cotizacion ();
					}
				});	

				$.post("library/funciones.php?action=Verificar_Administrador",
				function(data){

					if (data == "true")
					{
						//if ($("#hidIdProducto"+oId).val() == "timp")
						//{
						
							$("#txtPrecio"+oId).attr("readonly",false);
							$("#txtPrecio"+oId).attr("title","Precio Sugerido");
							
							$("#txtPrecio" + oId).keydown(function(event){
							//alert(event.keyCode);
								if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
									return true;
								}
								else
								{
									return false;
								}
							});
							
							$("#txtPrecio" + oId).change(function(){

								$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
								$("#txtPrecio"+oId).attr("title","Precio Especial");
								$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

								$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
								$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
								$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
			
								Calcular_Total_Cotizacion ();
							});
						//}
					}
					else
					{
						//if ($("#hidIdProducto"+oId).val() == "timp")
						//{
							$("#txtPrecio"+oId).attr("readonly",true);
									
						//}
					}
				});				
				
				Calcular_Total_Cotizacion ();				
				//BuscarID_Producto(oId);
			}				
		}

	});	
}

function Generar_Descripcion_Producto(oId)
{
	var Cantidad = $("#hidCantidad" + oId).val();
	if ((Cantidad == undefined) | (Cantidad == ""))
	Cantidad = "0";	
	
	var TipoEmpaque = $("#hidTipoEmpaque" + oId).val();
	var DescTipoEmpaque = $("#txtTipoEmpaque" + oId).val();	
	var Precio = $("#hidPrecio" + oId).val();
	if ((Precio == undefined) | (Precio == ""))
	Precio = "0.00";
	
	var Total = $("#hidTotal" + oId).val();
	if ((Total == undefined) | (Total == ""))
	Total = "0.00";
	
	var IdProducto = $("#hidIdProducto" + oId).val();
	var DescProducto = $("#hidDescProducto" + oId).val();
	var Id = $("#hdnIdCampos_" + oId).val();	



	

	if ($("#hidIdProducto" + oId).val() == "timp")
	{
		//$("#rowDetalle_" + oId).remove();										
		var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
		var strHtml1 = '<td colspan="6"><table width="100%">';
			strHtml1 += '<tr>';
		var strHtml2 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
		var strHtml3 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="Unidad" style="width:80%;" class="validate[required]" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value="'+ TipoEmpaque +'"  /></td>';	
		//var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtProducto' + oId + '" name="txtProducto[]" value="" style="width:80%;" class="maskCelular validate[required]" /><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value=""  /></td>';
		var strHtml4 = '<td width="32%">';
			strHtml4 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto' + oId + '" style="width:85%;" class="validate[required]" value="'+DescProducto+'"/>';			
			//strHtml4 += '<select name="lstProducto[]" id="lstProducto' + oId + '" class="validate[required]" >';
			//strHtml4 += '<option value="">Seleccione el Producto</option>';
			//strHtml4 += '<option value="libf">Libreta Factura</option>';	
			//strHtml4 += '<option value="lib">Libreta</option>';			
			//strHtml4 += '</select>';
			strHtml4 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value="'+IdProducto+'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+DescProducto+'"  /></td>';
		var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="'+Precio+'" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value=""  /></td>';
		var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="'+Total+'" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value=""  /></td>';

		var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
			strHtml7 += '<input type="hidden" id="hdnDescripcionImprenta' + oId +'" name="hdnDescripcionImprenta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnResmaTamano' + oId +'" name="hdnResmaTamano[]" value="" />';				
			strHtml7 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoAncho' + oId +'" name="hdnOtroTamanoAncho[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoLargo' + oId +'" name="hdnOtroTamanoLargo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionInicio' + oId +'" name="hdnNumeracionInicio[]" value=""" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionFinal' + oId +'" name="hdnNumeracionFinal[]" value="" />';			
			
			var c = 0;
			
			while (c <= 3)
			{
				if (c == 0)
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="" />';					
				else
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="" />';
				
				c = c + 1;
			}
			
			strHtml7 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="" />';

			strHtml7 += '<input type="hidden" id="hdnArte' + oId + '" name="hdnArte[]" value=""  />';	
			strHtml7 += '<input type="hidden" id="hdnPlaca' + oId + '" name="hdnPlaca[]" value=""  />';	

			strHtml7 += '<input type="hidden" id="hdnDescripcionBanner' + oId +'" name="hdnDescripcionBanner[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialBanner' + oId +'" name="hdnMaterialBanner[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnAncho' + oId +'" name="hdnAncho[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnAnchoMedida' + oId +'" name="hdnAnchoMedida[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnLargo' + oId +'" name="hdnLargo[]"value="" />';				
			strHtml7 += '<input type="hidden" id="hdnLargoMedida' + oId +'" name="hdnLargoMedida[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnAreaTotal' + oId +'" name="hdnAreaTotal[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnFormaPago' + oId +'" name="hdnFormaPago[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnCalidadBanner' + oId +'" name="hdnCalidadBanner[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioInstalacion' + oId +'" name="hdnPrecioInstalacion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRecorte' + oId +'" name="hdnPrecioRecorte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioArte' + oId +'" name="hdnPrecioArte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRotulado' + oId +'" name="hdnPrecioRotulado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBasta' + oId +'" name="hdnPrecioBasta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioOjete' + oId +'" name="hdnPrecioOjete[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBulcaniza' + oId +'" name="hdnPrecioBulcaniza[]" value="" />';
		
			strHtml7 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]" value=""  />';				
			strHtml7 += '<input type="hidden" id="hdnNotaCotizacion' + oId + '" name="hdnNotaCotizacion[]" value=""  />';

			strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td></tr>';
		var strHtml8 = '<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles(' + oId +',\'timp\')" >Ver detalle</a></td>';				
		var strHtml9 = '</tr>';
			strHtml9 += '</table></td>';	
		var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;				
				
		//$("#tbDetalle").prepend(strHtmlTr);
		$("#rowDetalle_" + oId).html(strHtmlFinal);

	}
	else if ($("#hidIdProducto" + oId).val() == "tbnr")
	{
		//$("#rowDetalle_" + oId).remove();										
		var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
		var strHtml1 = '<td colspan="6"><table width="100%">';
			strHtml1 += '<tr>';
		var strHtml2 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
		var strHtml3 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="Unidad" style="width:80%;" class="validate[required]" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value="'+ TipoEmpaque +'"  /></td>';	
		//var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtProducto' + oId + '" name="txtProducto[]" value="" style="width:80%;" class="maskCelular validate[required]" /><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value=""  /></td>';
		var strHtml4 = '<td width="32%">';
			strHtml4 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto' + oId + '" style="width:85%;" class="validate[required]" value="'+DescProducto+'"/>';			
			//strHtml4 += '<select name="lstProducto[]" id="lstProducto' + oId + '" class="validate[required]" >';
			//strHtml4 += '<option value="">Seleccione el Producto</option>';
			//strHtml4 += '<option value="libf">Libreta Factura</option>';	
			//strHtml4 += '<option value="lib">Libreta</option>';			
			//strHtml4 += '</select>';
			strHtml4 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value="'+IdProducto+'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+DescProducto+'"  /></td>';
		var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="'+Precio+'" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value="'+Precio+'"  /></td>';
		var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="'+Total+'" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value="'+Total+'"  /></td>';

		var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
		
			strHtml7 += '<input type="hidden" id="hdnDescripcionImprenta' + oId +'" name="hdnDescripcionImprenta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnResmaTamano' + oId +'" name="hdnResmaTamano[]" value="" />';				
			strHtml7 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoAncho' + oId +'" name="hdnOtroTamanoAncho[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoLargo' + oId +'" name="hdnOtroTamanoLargo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionInicio' + oId +'" name="hdnNumeracionInicio[]" value=""" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionFinal' + oId +'" name="hdnNumeracionFinal[]" value="" />';			
			
			var c = 0;
			
			while (c <= 3)
			{
				if (c == 0)
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="" />';					
				else
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="" />';
				
				c = c + 1;
			}
			
			strHtml7 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="" />';

			strHtml7 += '<input type="hidden" id="hdnArte' + oId + '" name="hdnArte[]" value=""  />';	
			strHtml7 += '<input type="hidden" id="hdnPlaca' + oId + '" name="hdnPlaca[]" value=""  />';	

			strHtml7 += '<input type="hidden" id="hdnDescripcionBanner' + oId +'" name="hdnDescripcionBanner[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialBanner' + oId +'" name="hdnMaterialBanner[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnAncho' + oId +'" name="hdnAncho[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnAnchoMedida' + oId +'" name="hdnAnchoMedida[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnLargo' + oId +'" name="hdnLargo[]"value="" />';				
			strHtml7 += '<input type="hidden" id="hdnLargoMedida' + oId +'" name="hdnLargoMedida[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnAreaTotal' + oId +'" name="hdnAreaTotal[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnFormaPago' + oId +'" name="hdnFormaPago[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnCalidadBanner' + oId +'" name="hdnCalidadBanner[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioInstalacion' + oId +'" name="hdnPrecioInstalacion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRecorte' + oId +'" name="hdnPrecioRecorte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioArte' + oId +'" name="hdnPrecioArte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRotulado' + oId +'" name="hdnPrecioRotulado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBasta' + oId +'" name="hdnPrecioBasta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioOjete' + oId +'" name="hdnPrecioOjete[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBulcaniza' + oId +'" name="hdnPrecioBulcaniza[]" value="" />';
		
			strHtml7 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]" value=""  />';				
			strHtml7 += '<input type="hidden" id="hdnNotaCotizacion' + oId + '" name="hdnNotaCotizacion[]" value=""  />';
		
			strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td></tr>';
		var strHtml8 = '<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles(' + oId +',\'tbnr\')" >Ver detalle</a></td>';				
		var strHtml9 = '</tr>';
			strHtml9 += '</table></td>';	
		var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;				
				
		//$("#tbDetalle").prepend(strHtmlTr);
		$("#rowDetalle_" + oId).html(strHtmlFinal);
	}
	else if ($("#hidIdProducto" + oId).val() == "timpart")
	{
		//$("#rowDetalle_" + oId).remove();										
		var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
		var strHtml1 = '<td colspan="6"><table width="100%">';
			strHtml1 += '<tr>';			
		var strHtml2 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
		var strHtml3 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="Unidad" style="width:80%;" class="validate[required]" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value="'+ TipoEmpaque +'"  /></td>';	
		//var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtProducto' + oId + '" name="txtProducto[]" value="" style="width:80%;" class="maskCelular validate[required]" /><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value=""  /></td>';
		var strHtml4 = '<td width="32%">';
			strHtml4 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto' + oId + '" style="width:85%;" class="validate[required]" value="'+DescProducto+'"/>';			
			//strHtml4 += '<select name="lstProducto[]" id="lstProducto' + oId + '" class="validate[required]" >';
			//strHtml4 += '<option value="">Seleccione el Producto</option>';
			//strHtml4 += '<option value="libf">Libreta Factura</option>';	
			//strHtml4 += '<option value="lib">Libreta</option>';			
			//strHtml4 += '</select>';
			strHtml4 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value="'+IdProducto+'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+DescProducto+'"  /></td>';
		var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="'+Precio+'" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value="'+Precio+'"  /></td>';
		var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="'+Total+'" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value="'+Total+'"  /></td>';

		var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
			
			strHtml7 += '<input type="hidden" id="hdnDescripcionImprenta' + oId +'" name="hdnDescripcionImprenta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnResmaTamano' + oId +'" name="hdnResmaTamano[]" value="" />';				
			strHtml7 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoAncho' + oId +'" name="hdnOtroTamanoAncho[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoLargo' + oId +'" name="hdnOtroTamanoLargo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionInicio' + oId +'" name="hdnNumeracionInicio[]" value=""" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionFinal' + oId +'" name="hdnNumeracionFinal[]" value="" />';			
			
			var c = 0;
			
			while (c <= 3)
			{
				if (c == 0)
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="" />';					
				else
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="" />';
				
				c = c + 1;
			}
			
			strHtml7 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="" />';

			strHtml7 += '<input type="hidden" id="hdnArte' + oId + '" name="hdnArte[]" value=""  />';	
			strHtml7 += '<input type="hidden" id="hdnPlaca' + oId + '" name="hdnPlaca[]" value=""  />';	

			strHtml7 += '<input type="hidden" id="hdnDescripcionBanner' + oId +'" name="hdnDescripcionBanner[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialBanner' + oId +'" name="hdnMaterialBanner[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnAncho' + oId +'" name="hdnAncho[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnAnchoMedida' + oId +'" name="hdnAnchoMedida[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnLargo' + oId +'" name="hdnLargo[]"value="" />';				
			strHtml7 += '<input type="hidden" id="hdnLargoMedida' + oId +'" name="hdnLargoMedida[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnAreaTotal' + oId +'" name="hdnAreaTotal[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnFormaPago' + oId +'" name="hdnFormaPago[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnCalidadBanner' + oId +'" name="hdnCalidadBanner[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioInstalacion' + oId +'" name="hdnPrecioInstalacion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRecorte' + oId +'" name="hdnPrecioRecorte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioArte' + oId +'" name="hdnPrecioArte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRotulado' + oId +'" name="hdnPrecioRotulado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBasta' + oId +'" name="hdnPrecioBasta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioOjete' + oId +'" name="hdnPrecioOjete[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBulcaniza' + oId +'" name="hdnPrecioBulcaniza[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnNotaCotizacion' + oId + '" name="hdnNotaCotizacion[]" value=""  />';		
			strHtml7 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]" value=""  />';
		
			strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
		var strHtml8 = '<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles(' + oId +',\'timpart\')" >Ver detalle</a></td>';				
		var strHtml9 = '</tr>';
			strHtml9 += '</table></td>';	
		var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;				
				
		//$("#tbDetalle").prepend(strHtmlTr);
		$("#rowDetalle_" + oId).html(strHtmlFinal);
	
	}
	else
	{
	
		//$("#rowDetalle_" + oId).remove();										
		var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
		var strHtml1 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
		var strHtml2 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="Unidad" style="width:80%;" class="validate[required]" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value="'+ TipoEmpaque +'"  /></td>';	
		//var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtProducto' + oId + '" name="txtProducto[]" value="" style="width:80%;" class="maskCelular validate[required]" /><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value=""  /></td>';
		var strHtml3 = '<td width="32%">';
			strHtml3 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto' + oId + '" style="width:85%;" class="validate[required]" value="'+DescProducto+'"/>';			
			//strHtml4 += '<select name="lstProducto[]" id="lstProducto' + oId + '" class="validate[required]" >';
			//strHtml4 += '<option value="">Seleccione el Producto</option>';
			//strHtml4 += '<option value="libf">Libreta Factura</option>';	
			//strHtml4 += '<option value="lib">Libreta</option>';			
			//strHtml4 += '</select>';
			strHtml3 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value="'+IdProducto+'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+DescProducto+'"  /></td>';
		var strHtml4 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="'+Precio+'" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value="'+Precio+'"  /></td>';
		var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="'+Total+'" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value="'+Total+'"  /></td>';

		var strHtml6 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
			
			strHtml6 += '<input type="hidden" id="hdnDescripcionImprenta' + oId +'" name="hdnDescripcionImprenta[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnResmaTamano' + oId +'" name="hdnResmaTamano[]" value="" />';				
			strHtml6 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="" />';			
			strHtml6 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnOtroTamanoAncho' + oId +'" name="hdnOtroTamanoAncho[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnOtroTamanoLargo' + oId +'" name="hdnOtroTamanoLargo[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnNumeracionInicio' + oId +'" name="hdnNumeracionInicio[]" value=""" />';
			strHtml6 += '<input type="hidden" id="hdnNumeracionFinal' + oId +'" name="hdnNumeracionFinal[]" value="" />';			
			
			var c = 0;
			
			while (c <= 3)
			{
				if (c == 0)
				strHtml6 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="" />';					
				else
				strHtml6 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="" />';
				
				c = c + 1;
			}
			
			strHtml6 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="" />';			
			strHtml6 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="" />';			
			strHtml6 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="" />';

			strHtml6 += '<input type="hidden" id="hdnArte' + oId + '" name="hdnArte[]" value=""  />';	
			strHtml6 += '<input type="hidden" id="hdnPlaca' + oId + '" name="hdnPlaca[]" value=""  />';	

			strHtml6 += '<input type="hidden" id="hdnDescripcionBanner' + oId +'" name="hdnDescripcionBanner[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnMaterialBanner' + oId +'" name="hdnMaterialBanner[]" value="" />';			
			strHtml6 += '<input type="hidden" id="hdnAncho' + oId +'" name="hdnAncho[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnAnchoMedida' + oId +'" name="hdnAnchoMedida[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnLargo' + oId +'" name="hdnLargo[]"value="" />';				
			strHtml6 += '<input type="hidden" id="hdnLargoMedida' + oId +'" name="hdnLargoMedida[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnAreaTotal' + oId +'" name="hdnAreaTotal[]" value="" />';			
			strHtml6 += '<input type="hidden" id="hdnFormaPago' + oId +'" name="hdnFormaPago[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnCalidadBanner' + oId +'" name="hdnCalidadBanner[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnPrecioInstalacion' + oId +'" name="hdnPrecioInstalacion[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnPrecioRecorte' + oId +'" name="hdnPrecioRecorte[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnPrecioArte' + oId +'" name="hdnPrecioArte[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnPrecioRotulado' + oId +'" name="hdnPrecioRotulado[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnPrecioBasta' + oId +'" name="hdnPrecioBasta[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnPrecioOjete' + oId +'" name="hdnPrecioOjete[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnPrecioBulcaniza' + oId +'" name="hdnPrecioBulcaniza[]" value="" />';
			strHtml6 += '<input type="hidden" id="hdnNotaCotizacion' + oId + '" name="hdnNotaCotizacion[]" value=""  />';		
			strHtml6 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]" value=""  />';
		
			strHtml6 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
			strHtml6 += '</td>';	
		var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6;				
				
		//$("#tbDetalle").prepend(strHtmlTr);
		$("#rowDetalle_" + oId).html(strHtmlFinal);	
	}

		$("#txtProducto" + oId).autocomplete({
				source: "application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar",
				select:  function(event, ui) {
				//alert(ConvertirMoneda(ui.item.precio_venta));
				//alert($("#txtProducto" + oId).val());
				//alert(ui.item.precio_venta);
				//alert($("#txtCantidad" + oId).val());
				//alert(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));			
				
				$("#hidDescProducto" + oId).val(ui.item.value);
				$("#hidIdProducto" + oId).val(ui.item.id_producto);
				$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
				$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
				$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				
				//alert($("#txtPrecio" + oId).val());
				$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));		
			//BuscarID_Producto(oId);

				Generar_Descripcion_Producto(oId);
			
				$("#txtCantidad" + oId).change(function(){
		
					if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == 'timp') & ($("#txtCantidad" + oId).val() > 1) )
					{
						alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
						$("#txtCantidad" + oId).val('0');			
					}
					else if ($("#txtCantidad" + oId).val() == 0) 
					{
						alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
						$("#txtCantidad" + oId).val('0');			
					}					
					else
					{		
						$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
						$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
						//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
						Calcular_Total_Cotizacion ();
					}
				});	
				
				Calcular_Total_Cotizacion ();			
			},
			
			change: function (event, ui) {
			
				if (ui.item === null)
				{	
					$("#txtProducto" + oId).val("");
					$("#hidDescProducto" + oId).val("");
					$("#hidIdProducto" + oId).val("");
					$("#txtTipoEmpaque" + oId).val("");
					$("#hidTipoEmpaque" + oId).val("");
					$("#txtPrecio" + oId).val("0.00");
					
					//alert($("#txtPrecio" + oId).val());
					$("#hidPrecio" + oId).val("0.00");
					$("#txtTotal" + oId).val("0.00");
					$("#hidTotal" + oId).val("0.00");				
				}
				else
				{
					$("#hidDescProducto" + oId).val(ui.item.value);
					$("#hidIdProducto" + oId).val(ui.item.id_producto);
					$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
					$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
					$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					
					//alert($("#txtPrecio" + oId).val());
					$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
					$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));		
				//BuscarID_Producto(oId);

					Generar_Descripcion_Producto(oId);
				
					$("#txtCantidad" + oId).change(function(){
			
						if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == 'timp') & ($("#txtCantidad" + oId).val() > 1) )
						{
							alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
							$("#txtCantidad" + oId).val('0');			
						}
						else if ($("#txtCantidad" + oId).val() == 0) 
						{
							alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
							$("#txtCantidad" + oId).val('0');			
						}					
						else
						{		
							$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
							//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
							Calcular_Total_Cotizacion ();
						}
					});	
					
					Calcular_Total_Cotizacion ();
				}				
			}			
	
		});	
}


function Agregar_Articulo(){


	$.getScript("public/js/form_validation.js");
	
	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	
	Calcular_Total_Cotizacion ();
	
	$("#cant_campos").val(parseInt($("#cant_campos").val()) + 1);
	var oId = $("#cant_campos").val();

	var strHtml0= "<td  align=\"center\">" +  oId + '</td>';	        
	var strHtml1 = "<td>" + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="0" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="0"  /></td>';
	var strHtml2 = "<td>" + '<input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value=""  /></td>';	
	var strHtml3 = "<td>";
		strHtml3 += '<span class="req">*</span>';
		strHtml3 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto[]" style="width:85%;" class="validate[required]" />';	
		strHtml3 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value=""  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value=""  />';
		strHtml3 += '<input type="hidden" id="hidIdImprenta' + oId + '" name="hidIdImprenta[]" value=""  />';
		strHtml3 += '<input type="hidden" id="hidIdBanner' + oId + '" name="hidIdBanner[]" value=""  />';		
		strHtml3 += '<input type="hidden" id="hidIdImpresion' + oId + '" name="hidIdImpresion[]" value=""  /></td>';
	var strHtml4 = "<td>" + '<input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="0.00" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value=""  /></td>';
	var strHtml5 = "<td>" + '<input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="0.00" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value=""  /></td>';

	var strHtml6 = '<td><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
		
		strHtml6 += '<input type="hidden" id="hdnDescripcionImprenta' + oId +'" name="hdnDescripcionImprenta[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnResmaTamano' + oId +'" name="hdnResmaTamano[]" value="" />';				
		strHtml6 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="" />';			
		strHtml6 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnOtroTamanoAncho' + oId +'" name="hdnOtroTamanoAncho[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnOtroTamanoLargo' + oId +'" name="hdnOtroTamanoLargo[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnNumeracionInicio' + oId +'" name="hdnNumeracionInicio[]" value=""" />';
		strHtml6 += '<input type="hidden" id="hdnNumeracionFinal' + oId +'" name="hdnNumeracionFinal[]" value="" />';			
			
			var c = 0;
			
			while (c <= 3)
			{
				if (c == 0)
				strHtml6 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="" />';					
				else
				strHtml6 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="" />';
				
				c = c + 1;
			}
			
		strHtml6 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="" />';			
		strHtml6 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="" />';			
		strHtml6 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="" />';

		strHtml6 += '<input type="hidden" id="hdnArte' + oId + '" name="hdnArte[]" value=""  />';	
		strHtml6 += '<input type="hidden" id="hdnPlaca' + oId + '" name="hdnPlaca[]" value=""  />';	

		strHtml6 += '<input type="hidden" id="hdnDescripcionBanner' + oId +'" name="hdnDescripcionBanner[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnMaterialBanner' + oId +'" name="hdnMaterialBanner[]" value="" />';			
		strHtml6 += '<input type="hidden" id="hdnAncho' + oId +'" name="hdnAncho[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnAnchoMedida' + oId +'" name="hdnAnchoMedida[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnLargo' + oId +'" name="hdnLargo[]"value="" />';				
		strHtml6 += '<input type="hidden" id="hdnLargoMedida' + oId +'" name="hdnLargoMedida[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnAreaTotal' + oId +'" name="hdnAreaTotal[]" value="" />';			
		strHtml6 += '<input type="hidden" id="hdnFormaPago' + oId +'" name="hdnFormaPago[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnCalidadBanner' + oId +'" name="hdnCalidadBanner[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnPrecioInstalacion' + oId +'" name="hdnPrecioInstalacion[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnPrecioRecorte' + oId +'" name="hdnPrecioRecorte[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnPrecioArte' + oId +'" name="hdnPrecioArte[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnPrecioRotulado' + oId +'" name="hdnPrecioRotulado[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnPrecioBasta' + oId +'" name="hdnPrecioBasta[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnPrecioOjete' + oId +'" name="hdnPrecioOjete[]" value="" />';
		strHtml6 += '<input type="hidden" id="hdnPrecioBulcaniza' + oId +'" name="hdnPrecioBulcaniza[]" value="" />';
		
		strHtml6 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]" value=""  />';
		strHtml6 += '<input type="hidden" id="hdnNotaCotizacion' + oId + '" name="hdnNotaCotizacion[]" value=""  />';			
		strHtml6 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6;
	//alert(oId);

	
    $("#tbDetalle").append(strHtmlTr);
	
	$("#rowDetalle_" + oId).html(strHtmlFinal);

	var strHtmlSubTotal0= '<td  align="right" colspan="5">Sub-Total:</td>';	
	var strHtmlSubTotal1 = '<td align="center" >' + '<input type="text" id="txtSubTotal" name="txtSubTotal" value="0.00" style="width:80%;text-align:right;"  readonly="readonly"/><input type="hidden" id="hidSubTotal" name="hidSubTotal" value=""  /></td>';
	var strHtmlSubTotal2= '<td  align="center"></td>';	
	var strHtmlTotalITBM0= '<td  align="right" colspan="5">ITBMS:</td>';	
	var strHtmlTotalITBM1 = '<td align="center" >' + '<input type="text" id="txtTotalITBM" name="txtTotalITBM" value="0.00" style="width:80%;text-align:right;"  readonly="readonly"/><input type="hidden" id="hidTotalITBM" name="hidTotalITBM" value=""  /></td>';
	var strHtmlTotalITBM2= '<td  align="center"></td>';		
	var strHtmlTotal0= '<td  align="right" colspan="5">Total Final:</td>';	
	var strHtmlTotal1 = '<td align="center" >' + '<input type="text" id="txtTotalFinal" name="txtTotalFinal" value="0.00" style="width:80%;text-align:right;"  readonly="readonly"/><input type="hidden" id="hidTotalFinal" name="hidTotalFinal" value=""  /></td>';
	var strHtmlTotal2= '<td  align="center"></td>';
	var strHtmlTrSubTotal = '<tr id="rowSubTotal"  valign="center"  ></tr>';
	var strHtmlTrTotalITBM = '<tr id="rowTotalITBM"  valign="center"  ></tr>';
	var strHtmlTrTotal = '<tr id="rowTotal"  valign="center"  ></tr>';
	
	var strHtmlTrFinalSubTotal = strHtmlSubTotal0 + strHtmlSubTotal1 + strHtmlSubTotal2;	
	var strHtmlFinalTotalITBM = strHtmlTotalITBM0 + strHtmlTotalITBM1 + strHtmlTotalITBM2;	
	var strHtmlFinalTotal = strHtmlTotal0 + strHtmlTotal1 + strHtmlTotal2;

	$("#tbTotal").append(strHtmlTrSubTotal);
	$("#tbTotal").append(strHtmlTrTotalITBM);
    $("#tbTotal").append(strHtmlTrTotal);
	$("#rowSubTotal").html(strHtmlTrFinalSubTotal);
	$("#rowTotalITBM").html(strHtmlFinalTotalITBM);	
	$("#rowTotal").html(strHtmlFinalTotal);	

	
	$("#txtCantidad" + oId).keydown(function(event){
		//alert(event.keyCode);
           if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
			return true;
		}
		else
		{
			return false;
		}
    });
	
	Listar_Producto_Auto(oId);
	
	if ($("#txtTotalFinal").val() == undefined)
	$("#txtTotalFinal").val('0');
	
	$("#txtCantidad" + oId).change(function(){

		if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidDescProducto" + oId).val() == "Trabajo de Imprenta") & ($("#txtCantidad" + oId).val() > 1))
		{
			alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
			$("#txtCantidad" + oId).val('0');			
		}
		else if ($("#txtCantidad" + oId).val() == 0) 
		{
			alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
			$("#txtCantidad" + oId).val('0');			
		}		
		else
		{
	
			$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
			$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
			$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
			Calcular_Total_Cotizacion ();
			
		}		
		

	});	
	
	return false;	
}

function Eliminar_Articulo(oId){
	$("#rowDetalle_" + oId).remove();

	if($("[name='txtCantidad[]']").length == 0)
	{
		$("#cant_campos").val("0");
		$("#num_campos").val("0");
	}		
	
	Calcular_Total_Cotizacion ();
	
	return false;
}



function GenerarTipoPapel(oId,TipoPapel)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		$("#lstPapelTipo" + oId).load("application/controllers/CotizacionController.php?action=Listar_Tipo_Papel",
		function(data) {

			$("#lstPapelTipo" + oId).find('option').remove().end().append('<option value="">Seleccione el Tipo de Papel</option>');
			$("#lstPapelTipo" + oId).append(data);	
			
			$("#lstPapelTipo" + oId + " option[value=" + TipoPapel + "]").attr("selected",true);
		});
	}
	else
	{	
		$("#lstPapelTipo").load("application/controllers/CotizacionController.php?action=Listar_Tipo_Papel",
		function(data) {

		
			$("#lstPapelTipo").find('option').remove().end().append('<option value="">Seleccione el Tipo de Papel</option>');
			$("#lstPapelTipo").append(data);		

		});
	}
}

function GenerarMaterialTipoPapel(oId,TipoPapel,MaterialTipoPapel)
{
	
	//alert(oId);
	//alert(TipoPapel);
	var c = 1;
	var CantidadCopia = $("#hdnCantidadCopia" + oId).val();
	
	if (oId != undefined)
	{	
		//alert(TipoPapel);
		
		
		$.post("application/controllers/CotizacionController.php?action=Listar_Material_Tipo_Papel",
		{
		
			tipopapel:TipoPapel	
		
		},
		function(data) {

			
		
			if (TipoPapel==1)
			{
				$("#lstMaterialPapelTipo" + oId).find('option').remove().end().append('<option value="">Seleccione el Material Tipo de Papel</option>');
				$("#lstMaterialPapelTipo" + oId).append(data);	
			
				$("#lstMaterialPapelTipo" + oId + " option[value=" + MaterialTipoPapel + "]").attr("selected",true);			
				$("#lstMaterialPapelTipo" + oId).removeAttr('disabled');
				$("#lstMaterialPapelTipo" + oId).show();
				$("#lstResmaTamano" + oId).removeAttr('disabled');			
				$("#lstResmaTamano" + oId).show();
				
				$("#lstCantidadCopia" + oId).find('option').remove().end().append('<option value="">Seleccione la Cantidad de Copias</option>');
				$("#lstCantidadCopia" + oId).append('<option value="0">Solo Original</option>');

				while (c < 4)
				{
					$("#lstCantidadCopia" + oId).append('<option value="' + c + '">' + c + '</option>');
					c++;
				}

				$("#lstCantidadCopia" + oId + " option[value=" + CantidadCopia + "]").attr("selected",true);
			}

			else
			{
				$("#lstMaterialPapelTipo" + oId).attr('disabled',true);
				$("#lstMaterialPapelTipo" + oId).hide();
				$("#lstResmaTamano" + oId).attr('disabled',true);			
				$("#lstResmaTamano" + oId).hide();
				
				$("#lstCantidadCopia" + oId).find('option').remove().end().append('<option value="">Seleccione la Cantidad de Copias</option>');
				
				while (c < 4)
				{
					$("#lstCantidadCopia" + oId).append('<option value="' + c + '">' + c + '</option>');
					c++;
				}
				
				$("#lstCantidadCopia" + oId + " option[value=" + CantidadCopia + "]").attr("selected",true);				
				
			}

		});
	}
	else
	{	
		$.post("application/controllers/CotizacionController.php?action=Listar_Material_Tipo_Papel",
		{
		
			tipopapel:TipoPapel	
		
		},
		function(data) {

		
			$("#lstMaterialPapelTipo").find('option').remove().end().append('<option value="">Seleccione el Material Tipo de Papel</option>');
			$("#lstMaterialPapelTipo").append(data);		

		});
	}
}

function GenerarTamanoResmaPapel(oId,TipoPapel,ResmaTamanoPapel)
{
	
	//alert(oId);
	//alert(TipoPapel);
	if (oId != undefined)
	{	
		
		$.post("application/controllers/CotizacionController.php?action=Listar_Resma_Tamano_Papel",
		{
			tipopapel:TipoPapel
		},
		function(data) {
			
			if (TipoPapel==1)
			{			
						
				$("#lstResmaTamano" + oId).find('option').remove().end().append('<option value="">Seleccione el Tama&ntilde;o de Resma de  Papel</option>');
				$("#lstResmaTamano" + oId).append(data);

				//if (TipoPapel == 2)
				//$("#lstResmaTamano" + oId).append('<option value="o">Otro</option>');
			
				$("#lstResmaTamano" + oId + " option[value=" + ResmaTamanoPapel + "]").attr("selected",true);
				$("#lstResmaTamano" + oId).removeAttr('disabled');
				$("#lstResmaTamano" + oId).show();				
				
			}
			else
			{
				$("#lstResmaTamano" + oId).attr('disabled',true);
				$("#lstResmaTamano" + oId).hide();			
			
			
			
			}
		});
	}
	else
	{	
		$.post("application/controllers/CotizacionController.php?action=Listar_Resma_Tamano_Papel",
		{
			tipopapel:TipoPapel
		},
		function(data) {

			
		
			$("#lstResmaTamano").find('option').remove().end().append('<option value="">Seleccione el Tama&ntilde;o de Resma de Papel</option>');
			$("#lstResmaTamano").append(data);
			
			//if (TipoPapel == 2)		
			//$("#lstResmaTamano").append('<option value="o">Otro</option>');

		});
	}
}

function GenerarTamanoPapel(oId,TipoPapel,ResmaTamano,TamanoPapel)
{

	if (oId != undefined)
	{	
	
		$.post("application/controllers/CotizacionController.php?action=Listar_Tamano_Papel",
		{
			tipopapel:TipoPapel,
			resmatamano:ResmaTamano
		},
		function(data) {
					
			$("#lstTamano" + oId).find('option').remove().end().append('<option value="">Seleccione el Tama&ntilde;o de Papel</option>');
			$("#lstTamano" + oId).append(data);

			//if (TipoPapel == 2)
			$("#lstTamano" + oId).append('<option value="o">Otro</option>');
			
			$("#lstTamano" + oId + " option[value=" + TamanoPapel + "]").attr("selected",true);
		});
	}
	else
	{	

		$.post("application/controllers/CotizacionController.php?action=Listar_Tamano_Papel",
		{
			resmatamano:ResmaTamano
		},		
		function(data) {

			
		
			$("#lstTamano").find('option').remove().end().append('<option value="">Seleccione el Tama&ntilde;o de Papel</option>');
			$("#lstTamano").append(data);
			
			$("#lstTamano").append('<option value="o">Otro</option>');

		});
	}
}

function GenerarColorTinta(oId,ColorTinta)
{

	if (oId != undefined)
	{	
		
		$("#lstColorTinta" + oId).load("application/controllers/CotizacionController.php?action=Listar_Color_Tinta",
		function(data) {

			$("#lstColorTinta" + oId).find('option').remove().end().append('<option value="">Seleccione el Color de la Tinta</option>');
			$("#lstColorTinta" + oId).append(data);	
			
			$("#lstColorTinta" + oId + " option[value=" + ColorTinta + "]").attr("selected",true);
		});
	}
	else
	{	
		$("#lstColorTinta").load("application/controllers/CotizacionController.php?action=Listar_Color_Tinta",
		function(data) {

		
			$("#lstColorTinta").find('option').remove().end().append('<option value="">Seleccione el Color de la Tinta</option>');
			$("#lstColorTinta").append(data);		

		});
	}
}


function GenerarColorPapel(oId,copia,ColorPapel)
{

	if (oId != undefined)
	{	
		if ((copia == 0) | (copia == undefined))
		{
			
			$("#lstColorPapel" + oId).load("application/controllers/CotizacionController.php?action=Listar_Color_Papel",
			function(data) {

				$("#lstColorPapel" + oId).find('option').remove().end().append('<option value="">Seleccione el Color del Papel</option>');
				$("#lstColorPapel" + oId).append(data);	
				
				$("#lstColorPapel" + oId + " option[value=" + 1 + "]").attr("selected",true);
				$("#lstColorPapel" + oId).attr('disabled',true);
			});
		}
		else
		{
			
			$("#lstColorPapel" + copia + oId).load("application/controllers/CotizacionController.php?action=Listar_Color_Papel",
			function(data) {

				$("#lstColorPapel" + copia + oId).find('option').remove().end().append('<option value="">Seleccione el Color del Papel</option>');
				$("#lstColorPapel" + copia + oId).append(data);	
				
				$("#lstColorPapel" + copia + oId + " option[value=" + ColorPapel + "]").attr("selected",true);
			});		
		
		
		
		}

	}
	else
	{	
		$("#lstColorPapel").load("application/controllers/CotizacionController.php?action=Listar_Color_Papel",
		function(data) {

		
			$("#lstColorPapel").find('option').remove().end().append('<option value="">Seleccione el Color del Papel</option>');
			$("#lstColorPapel").append(data);		

		});
	}
}


function GenerarTipoForro(oId,TipoForro)
{

	if (oId != undefined)
	{	
		
		$("#lstTipoForro" + oId).load("application/controllers/CotizacionController.php?action=Listar_Tipo_Forro",
		function(data) {

			$("#lstTipoForro" + oId).find('option').remove().end().append('<option value="">Seleccione el Tipo de Forro</option>');
			$("#lstTipoForro" + oId).append(data);	
			
			$("#lstTipoForro" + oId + " option[value=" + TipoForro + "]").attr("selected",true);
		});
	}
	else
	{	
		$("#lstTipoForro").load("application/controllers/CotizacionController.php?action=Listar_Tipo_Forro",
		function(data) {

		
			$("#lstTipoForro").find('option').remove().end().append('<option value="">Seleccione el Tipo de Forro</option>');
			$("#lstTipoForro").append(data);		

		});
	}
}

function Verificar_Otro_Tamano(oId)
{
	var PapelTipo = $("#hdnPapelTipo" + oId).val();
	var ResmaTamano = $("#hdnResmaTamano" + oId).val();	
	var OtroTamanoAncho = $("#hdnOtroTamanoAncho" + oId).val();
	var OtroTamanoLargo = $("#hdnOtroTamanoLargo" + oId).val();	

	$.post("application/controllers/CotizacionController.php?action=Verificar_Otro_Tamano",
	{
		papeltipo:PapelTipo,	
		resmatamano:ResmaTamano,
		otrotamanoancho:OtroTamanoAncho,
		otrotamanolargo:OtroTamanoLargo	
	},
	function(data) {

		if (data != "")
		{
			
			$("#hdnOtroTamanoAncho" + oId).val('');
			$("#txtOtroTamanoAncho" + oId).val('');
			$("#hdnOtroTamanoLargo" + oId).val('');
			$("#txtOtroTamanoLargo" + oId).val('');	
		}
	
	});

}


function GenerarMaterial(oId,Material)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		$("#lstMaterialBanner" + oId).load("application/controllers/CotizacionController.php?action=Lista_Material_Banner",
		function(data) {

			$("#lstMaterialBanner" + oId).find('option').remove().end().append('<option value="">Seleccione el Material del Banner</option>');
			$("#lstMaterialBanner" + oId).append(data);	
			
			$("#lstMaterialBanner" + oId + " option[value=" + Material + "]").attr("selected",true);
		});
	}
	else
	{	
		$("#lstMaterialBanner").load("application/controllers/CotizacionController.php?action=Lista_Material_Banner",
		function(data) {

		
			$("#lstMaterialBanner").find('option').remove().end().append('<option value="">Seleccione el Material del Banner</option>');
			$("#lstMaterialBanner").append(data);		

		});
	}
}

function GenerarUnidadMedida(oId,Dimension,Unidad,Impresion)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		if(Dimension == "a")
		{
			$.post("application/controllers/CotizacionController.php?action=Lista_Unidad_Medida",
			{
				impresion:Impresion
			},
			function(data) {

				$("#lstAnchoMedida" + oId).find('option').remove().end().append('<option value="" title="Seleccione la Unidad de Medida">Seleccione</option>');
				$("#lstAnchoMedida" + oId).append(data);	
			
				$("#lstAnchoMedida" + oId + " option[value=" + Unidad + "]").attr("selected",true);
			});	
		}
		else if(Dimension == "l")
		{
			$.post("application/controllers/CotizacionController.php?action=Lista_Unidad_Medida",
			{
				impresion:Impresion
			},			
			function(data) {

				$("#lstLargoMedida" + oId).find('option').remove().end().append('<option value="" title="Seleccione la Unidad de Medida">Seleccione</option>');
				$("#lstLargoMedida" + oId).append(data);	
			
				$("#lstLargoMedida" + oId + " option[value=" + Unidad + "]").attr("selected",true);
			});			
		

		}
		

	}
	else
	{	
		if(Dimension == "a")
		{
			$("#lstAnchoMedida").load("application/controllers/CotizacionController.php?action=Lista_Unidad_Medida",
			function(data) {

				$("#lstAnchoMedida").find('option').remove().end().append('<option value="" title="Seleccione la Unidad de Medida">Seleccione</option>');
				$("#lstAnchoMedida").append(data);	

			});	
		}
		else if(Dimension == "l")
		{
			$("#lstLargoMedida").load("application/controllers/CotizacionController.php?action=Lista_Unidad_Medida",
			function(data) {

				$("#lstLargoMedida").find('option').remove().end().append('<option value="" title="Seleccione la Unidad de Medida">Seleccione</option>');
				$("#lstLargoMedida").append(data);	

			});			
		
		
		}
	}
}

function GenerarFormaPago(oId,FormaPago)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		$("#lstFormaPago" + oId).load("application/controllers/CotizacionController.php?action=Lista_Forma_Pago",
		function(data) {

			$("#lstFormaPago" + oId).find('option').remove().end().append('<option value="">Seleccione la Forma de Pago</option>');
			$("#lstFormaPago" + oId).append(data);	
			
			$("#lstFormaPago" + oId + " option[value=" + FormaPago + "]").attr("selected",true);
		});
	}
	else
	{	
		$("#lstFormaPago").load("application/controllers/CotizacionController.php?action=Lista_Forma_Pago",
		function(data) {

		
			$("#lstFormaPago").find('option').remove().end().append('<option value="">Seleccione la Forma de Pago</option>');
			$("#lstFormaPago").append(data);		

		});
	}
}

function GenerarCalidad(oId,Calidad)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		$("#lstCalidadBanner" + oId).load("application/controllers/CotizacionController.php?action=Lista_Calidad",
		function(data) {

			$("#lstCalidadBanner" + oId).find('option').remove().end().append('<option value="">Seleccione la Calidad del Banner</option>');
			$("#lstCalidadBanner" + oId).append(data);	
			
			$("#lstCalidadBanner" + oId + " option[value=" + Calidad + "]").attr("selected",true);
		});
	}
	else
	{	
		$("#lstCalidadBanner").load("application/controllers/CotizacionController.php?action=Lista_Calidad",
		function(data) {

		
			$("#lstCalidadBanner").find('option').remove().end().append('<option value="">Seleccione la Calidad del Banner</option>');
			$("#lstCalidadBanner").append(data);		

		});
	}
}

function GenerarMaterialImpresion(oId,TamanoPapel,Material)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		$.post("application/controllers/CotizacionController.php?action=Lista_Material_Impresion",
		{
			tamanopapel:TamanoPapel
		},		
		function(data) {

			$("#lstMaterialImpresion" + oId).find('option').remove().end().append('<option value="">Seleccione el Material del Impresi&oacute;n</option>');
			$("#lstMaterialImpresion" + oId).append(data);	
			
			$("#lstMaterialImpresion" + oId + " option[value=" + Material + "]").attr("selected",true);
		});
	}
	else
	{	
		$.post("application/controllers/CotizacionController.php?action=Lista_Material_Impresion",
		{
			tamanopapel:TamanoPapel
		},		
		function(data) {

		
			$("#lstMaterialImpresion").find('option').remove().end().append('<option value="">Seleccione el Material del Impresi&oacute;n</option>');
			$("#lstMaterialImpresion").append(data);		

		});
	}
}



function GenerarColorTintaImpresion(oId,ColorTinta)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		$("#lstColorTinta" + oId).load("application/controllers/CotizacionController.php?action=Listar_Color_Tinta_Impresion",
		function(data) {

			$("#lstColorTinta" + oId).find('option').remove().end().append('<option value="">Seleccione el Color de la Tinta</option>');
			$("#lstColorTinta" + oId).append(data);	
			
			$("#lstColorTinta" + oId + " option[value=" + ColorTinta + "]").attr("selected",true);
		});
	}
	else
	{	
		$("#lstColorTinta").load("application/controllers/CotizacionController.php?action=Listar_Color_Tinta_Impresion",
		function(data) {

		
			$("#lstColorTinta").find('option').remove().end().append('<option value="">Seleccione el Color de la Tinta</option>');
			$("#lstColorTinta").append(data);		

		});
	}
}

function GenerarCategoria(oId,TipoCategoria)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		$("#lstTipoCategoria" + oId).load("application/controllers/ProductoController.php?action=Listar_Tipo_Categoria",
		function(data) {

			$("#lstTipoCategoria" + oId).find('option').remove().end().append('<option value="">Seleccione el Tipo de Categor&iacute;a</option>');
			$("#lstTipoCategoria" + oId).append(data);	
			
			$("#lstTipoCategoria" + oId + " option[value=" + TipoCategoria + "]").attr("selected",true);
		});
	}
	else
	{	
		$("#lstTipoCategoria").load("application/controllers/ProductoController.php?action=Listar_Tipo_Categoria",
		function(data) {

		
			$("#lstTipoCategoria").find('option').remove().end().append('<option value="">Seleccione el Tipo de Categor&iacute;a</option>');
			$("#lstTipoCategoria").append(data);		

		});
	}
}

function GenerarCategoriaVolumen(oId,TipoCategoria)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		$("#lstTipoCategoria" + oId).load("application/controllers/CotizacionController.php?action=Tipo_Volumen_Imprenta",
		function(data) {

			$("#lstTipoCategoria" + oId).find('option').remove().end().append('<option value="">Seleccione el Tipo de Categor&iacute;a</option>');
			$("#lstTipoCategoria" + oId).append(data);	
			
			$("#lstTipoCategoria" + oId + " option[value=" + TipoCategoria + "]").attr("selected",true);
		});
	}
	else
	{	
		$("#lstTipoCategoria").load("application/controllers/CotizacionController.php?action=Tipo_Volumen_Imprenta",
		function(data) {

		
			$("#lstTipoCategoria").find('option').remove().end().append('<option value="">Seleccione el Tipo de Categor&iacute;a</option>');
			$("#lstTipoCategoria").append(data);		

		});
	}
}

function GenerarCategoriaVolumenImpresion(oId,TipoCategoria)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		$("#lstTipoCategoria" + oId).load("application/controllers/CotizacionController.php?action=Tipo_Volumen_Impresion",
		function(data) {

			$("#lstTipoCategoria" + oId).find('option').remove().end().append('<option value="">Seleccione el Tipo de Categor&iacute;a</option>');
			$("#lstTipoCategoria" + oId).append(data);	
			
			$("#lstTipoCategoria" + oId + " option[value=" + TipoCategoria + "]").attr("selected",true);
		});
	}
	else
	{	
		$("#lstTipoCategoria").load("application/controllers/CotizacionController.php?action=Tipo_Volumen_Impresion",
		function(data) {

		
			$("#lstTipoCategoria").find('option').remove().end().append('<option value="">Seleccione el Tipo de Categor&iacute;a</option>');
			$("#lstTipoCategoria").append(data);		

		});
	}
}


function Calcular_Precio_Imprenta(oId)
{
	
	var Cantidad = $("#hidCantidad" + oId).val();
	var PapelTipo = $("#hdnPapelTipo" + oId).val();
	var MaterialPapelTipo = $("#hdnMaterialPapelTipo" + oId).val();
	var ResmaTamano = $("#hdnResmaTamano" + oId).val();
	var Tamano = $("#hdnTamano" + oId).val();
	var OtroTamanoAncho = $("#hdnOtroTamanoAncho" + oId).val();
	var OtroTamanoLargo = $("#hdnOtroTamanoLargo" + oId).val();	
	var CantidadCopia = $("#hdnCantidadCopia" + oId).val();	
	var Tiempo = $("#hdnTiempo" + oId).val();
	var TipoTiempo = $("#hdnTipoTiempo" + oId).val();
	var TipoCategoria = $("#hdnTipoCategoria" + oId).val();
	var Placa = $("#hdnPlaca" + oId).val();	
	//alert(CantidadCopia);
	
	$.post("application/controllers/CotizacionController.php?action=Calcular_Precio_Imprenta",
	{
		cantidad:Cantidad,
		papeltipo:PapelTipo,	
		materialpapeltipo:MaterialPapelTipo,
		resmatamano:ResmaTamano,
		tamano:Tamano,
		otrotamanoancho:OtroTamanoAncho,
		otrotamanolargo:OtroTamanoLargo,		
		cantidadcopia:CantidadCopia,	
		tiempo:Tiempo,		
		tipotiempo:TipoTiempo,
		tipocategoria:TipoCategoria,		
		placa:Placa
		
	},
	function(data) {
					
			$("#hidPrecio" + oId).val(ConvertirMoneda(data));
			$("#txtPrecio" + oId).val(ConvertirMoneda(data));
			$("#hidTotal" + oId).val(ConvertirMoneda($("#hidPrecio" + oId).val()*Cantidad));
			$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*Cantidad));
			Calcular_Total_Cotizacion ();
			//alert(ConvertirMoneda(data));	
			//alert($("#hidPrecio" + oId).val());
			
	});
	

}

function Calcular_Precio_Banner(oId)
{
	
	var Cantidad = $("#hidCantidad" + oId).val();	
	var MaterialBanner = $("#hdnMaterialBanner" + oId).val();
	var Ancho = $("#hdnAncho" + oId).val();
	var AnchoMedida = $("#hdnAnchoMedida" + oId).val();
	var Largo = $("#hdnLargo" + oId).val();
	var LargoMedida = $("#hdnLargoMedida" + oId).val();
	var FormaPago = $("#hdnFormaPago" + oId).val();
	var CalidadBanner = $("#hdnCalidadBanner" + oId).val();
	var PrecioInstalacion = $("#hdnPrecioInstalacion" + oId).val();
	var PrecioRecorte = $("#hdnPrecioRecorte" + oId).val();
	var PrecioArte = $("#hdnPrecioArte" + oId).val();
	var PrecioRotulado = $("#hdnPrecioRotulado" + oId).val();		
	var PrecioBasta = $("#hdnPrecioBasta" + oId).val();
	var PrecioOjete = $("#hdnPrecioOjete" + oId).val();
	var PrecioBulcaniza = $("#hdnPrecioBulcaniza" + oId).val();		
	
	
	//alert(MaterialBanner);
	
	$.post("application/controllers/CotizacionController.php?action=Calcular_Precio_Banner",
	{
		cantidad:Cantidad,
		materialbanner:MaterialBanner,
		ancho:Ancho,	
		anchomedida:AnchoMedida,
		largo:Largo,
		largomedida:LargoMedida,
		formapago:FormaPago,
		calidadbanner:CalidadBanner,		
		precioinstalacion:PrecioInstalacion,	
		preciorecorte:PrecioRecorte,		
		precioarte:PrecioArte,
		preciorotulado:PrecioRotulado,
		preciobasta:PrecioBasta,		
		precioojete:PrecioOjete,
		preciobulcaniza:PrecioBulcaniza		
		
	},
	function(data) {
			
			$resultArr  = JSON.parse(data);
			
			
			$("#lblAreaTotal" + oId).html(ConvertirMoneda($resultArr[0]));
			$("#hdnAreaTotal" + oId).val(ConvertirMoneda($resultArr[0]));
			$("#hidPrecio" + oId).val(ConvertirMoneda($resultArr[1]));
			$("#txtPrecio" + oId).val(ConvertirMoneda($resultArr[1]));
			$("#hidTotal" + oId).val(ConvertirMoneda($("#hidPrecio" + oId).val()*Cantidad));
			$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*Cantidad));
			Calcular_Total_Cotizacion ();
			//alert(ConvertirMoneda(data));	
			//alert($("#hidPrecio" + oId).val());*/
			
	});
	

}


function Calcular_Precio_Impresion(oId)
{
	
	var Cantidad = $("#hidCantidad" + oId).val();	
	var MaterialImpresion = $("#hdnMaterialImpresion" + oId).val();
	var Ancho = $("#hdnAncho" + oId).val();
	var AnchoMedida = $("#hdnAnchoMedida" + oId).val();
	var Largo = $("#hdnLargo" + oId).val();
	var LargoMedida = $("#hdnLargoMedida" + oId).val();	
	var Tamano = $("#hdnTamano" + oId).val();
	var OtroTamanoAncho = $("#hdnOtroTamanoAncho" + oId).val();
	var OtroTamanoLargo = $("#hdnOtroTamanoLargo" + oId).val();
	var ColorTinta = $("#hdnColorTinta" + oId).val();
	var PrecioArte = $("#hdnPrecioArte" + oId).val();
	var Recorte = $("#hdnRecorte" + oId).val();
	var Plastificado = $("#hdnPlastificado" + oId).val();
	var Caminado = $("#hdnCaminado" + oId).val();
	var Realce = $("#hdnRealce" + oId).val();	
	var Doblado = $("#hdnDoblado" + oId).val();
	var Repujado = $("#hdnRepujado" + oId).val();
	var Engrapado = $("#hdnEngrapado" + oId).val();
	var UV = $("#hdnUV" + oId).val();
	var TipoCategoria = $("#hdnTipoCategoria" + oId).val();	
	var AjustarTamano = $("#hdnAjustarTamano" + oId).val();
		
	//alert(Recorte);
	//alert(Tamano);
	
	
	$.post("application/controllers/CotizacionController.php?action=Calcular_Precio_Impresion",
	{
		cantidad:Cantidad,
		materialimpresion:MaterialImpresion,
		ancho:Ancho,	
		anchomedida:AnchoMedida,
		largo:Largo,
		largomedida:LargoMedida,
		tamano:Tamano,
		colortinta:ColorTinta,
		otrotamanoancho:OtroTamanoAncho,	
		otrotamanolargo:OtroTamanoLargo,
		precioarte:PrecioArte,
		recorte:Recorte,
		plastificado:Plastificado,
		caminado:Caminado,
		realce:Realce,
		doblado:Doblado,
		repujado:Repujado,	
		engrapado:Engrapado,
		uv:UV,
		tipocategoria:TipoCategoria,
		ajustartamano:AjustarTamano
		
	},
	function(data) {
			
			$resultArr  = JSON.parse(data);
			//alert($resultArr[1]);
			
			$("#lblAreaTotal" + oId).html(ConvertirMoneda($resultArr[0]));
			$("#hdnAreaTotal" + oId).val(ConvertirMoneda($resultArr[0]));
			$("#lblCantPliego" + oId).html(ConvertirMoneda($resultArr[1]));
			$("#hdnCantPliego" + oId).val(ConvertirMoneda($resultArr[1]));
			$("#hidPrecio" + oId).val(ConvertirMoneda($resultArr[2]));
			$("#txtPrecio" + oId).val(ConvertirMoneda($resultArr[2]));
			$("#hidTotal" + oId).val(ConvertirMoneda($("#hidPrecio" + oId).val()*Cantidad));
			$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*Cantidad));
			Calcular_Total_Cotizacion ();
			//alert(ConvertirMoneda(data));	
			//alert($("#hidPrecio" + oId).val());*/
			
	});
	

}

function Calcular_Total_Cotizacion ()
{

	//var cant_fila =  $("[name='txtTotal[]']").length;

	var c = 1;
	var SubTotal = 0;
	var ITBMS = 0;
	var DescITBM = 0;
	var Total = 0;
	
	var arrTotal = new Array();
	arrTotal = $("[name='txtTotal[]']");
	arrExento = $("[name='hdnExentoITBM[]']");
	arrExentoVR = $("#chkExentoITBM:checked").val();
	
		
	for (var i = 0; i < arrTotal.length; ++i) {

		SubTotal = parseFloat(arrTotal[i].value) + parseFloat(SubTotal);
		

		if ((arrExento[i].value == 1) | (arrExentoVR == 1))
		{
			DescITBM = parseFloat(DescITBM) + parseFloat(arrTotal[i].value*0.07);
		}
	
		
	}
		
	//alert(SubTotal);
	//alert($('#hidTotal' + c).val());
	ITBMS = (SubTotal*0.07) - DescITBM;
	Total = (SubTotal*1.07) - DescITBM;
	$("#txtSubTotal").val(ConvertirMoneda(SubTotal));
	$("#hidSubTotal").val(ConvertirMoneda(SubTotal));	
	$("#txtTotalITBM").val(ConvertirMoneda(ITBMS));
	$("#hidTotalITBM").val(ConvertirMoneda(ITBMS));	
	$("#txtTotalFinal").val(ConvertirMoneda(Total));
	$("#hidTotalFinal").val(ConvertirMoneda(Total));	
	//alert(Total);

}


function Mostrar_Detalles(oId,Libreta)
{
	//alert(Libreta);
	//alert($("#txtTipoEmpaque" + oId).val());

	$.getScript("public/js/form_validation.js");	
	
	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);	
	
	var Cantidad = $("#hidCantidad" + oId).val();
	if ((Cantidad == undefined) | (Cantidad == ""))
	Cantidad = "0";
	
	var TipoEmpaque = $("#hidTipoEmpaque" + oId).val();
	var DescTipoEmpaque = $("#txtTipoEmpaque" + oId).val();		
	var Precio = $("#hidPrecio" + oId).val();
	var Total = $("#hidTotal" + oId).val();
	
	var Producto = $("#hidIdProducto" + oId).val();
	
	if (Producto == undefined)
	Producto = "";
	
	var IdImprenta = $("#hidIdImprenta" + oId).val();
	
	if (IdImprenta == undefined)
	IdImprenta = "";
	
	var IdBanner = $("#hidIdBanner" + oId).val();
	
	if (IdBanner == undefined)
	IdBanner = "";
	
	var IdImpresion = $("#hidIdImpresion" + oId).val();
	
	if (IdImpresion == undefined)
	IdImpresion = "";	
	
	var DescProducto = $("#hidDescProducto" + oId).val();

	var NotaCotizacion = $("#hdnNotaCotizacion" + oId).val();
	
	if (NotaCotizacion == undefined)
	NotaCotizacion = "";
	
	var ExentoITBM = $("#hdnExentoITBM" + oId).val();	

	
	if(Libreta == "timp")
	{					
		
		var Id = $("#hdnIdCampos_" + oId).val();
	
		var DescripcionImprenta = $("#hdnDescripcionImprenta" + oId).val();
		if (DescripcionImprenta == undefined)
		DescripcionImprenta = "";		
		

	
	
	
		var PapelTipo = $("#hdnPapelTipo" + oId).val();
		var MaterialPapelTipo = $("#hdnMaterialPapelTipo" + oId).val();
		var ResmaTamano = $("#hdnResmaTamano" + oId).val();

		
		var Tamano = $("#hdnTamano" + oId).val();

		var CantidadCopia = $("#hdnCantidadCopia" + oId).val();
		var ColorTinta = $("#hdnColorTinta" + oId).val();
	
		var OtroTamanoAncho = $("#hdnOtroTamanoAncho" + oId).val();
		var OtroTamanoLargo = $("#hdnOtroTamanoLargo" + oId).val();
	
		var NumeracionInicio = $("#hdnNumeracionInicio" + oId).val();
		if ((NumeracionInicio == undefined)  | (NumeracionInicio == ""))
		NumeracionInicio = "1";		
	
		var NumeracionFinal = $("#hdnNumeracionFinal" + oId).val();
		
		if ((NumeracionFinal == undefined)  | (NumeracionFinal == ""))
		NumeracionFinal = "";		
	
		var ColorPapel = new Array();
			ColorPapel[0] = $("#hdnColorPapel" + oId).val();
			ColorPapel[1] = $("#hdnColorPapel1" + oId).val();
			ColorPapel[2] = $("#hdnColorPapel2" + oId).val();
			ColorPapel[3] = $("#hdnColorPapel3" + oId).val();
		
		var TipoForro = $("#hdnTipoForro" + oId).val();	
		var Tiempo = $("#hdnTiempo" + oId).val();
		if ((Tiempo == undefined)  | (Tiempo == ""))
		Tiempo = "0";		
		
		var TipoTiempo = $("#hdnTipoTiempo" + oId).val();		
		var TipoCategoria = $("#hdnTipoCategoria" + oId).val();			
		
		var SinNumeracion = $("#hdnSinNumeracion" + oId).val();
		var Arte = $("#hdnArte" + oId).val();
		var Placa = $("#hdnPlaca" + oId).val();	
	
		//$("#rowDetalle_" + oId).remove();										
		var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
		var strHtml1 = '<td colspan="6"><table width="100%">';
			strHtml1 += '<tr>';
		var strHtml2 = '<td width="15%">' + '<input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
		var strHtml3 = '<td width="15%">' + '<input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="'+ DescTipoEmpaque +'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value="'+ DescTipoEmpaque +'"  /></td>';	
		var strHtml4 = '<td width="32%">';		
			strHtml4 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto[]" style="width:85%;" class="validate[required]" value="'+DescProducto+'"/>';			
			strHtml4 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value="'+Producto+'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+DescProducto+'"  />';
			strHtml4 += '<input type="hidden" id="hidIdImprenta' + oId + '" name="hidIdImprenta[]" value="'+IdImprenta+'"  />';
			strHtml4 += '<input type="hidden" id="hidIdBanner' + oId + '" name="hidIdBanner[]" value="'+IdBanner+'"  />';		
			strHtml4 += '<input type="hidden" id="hidIdImpresion' + oId + '" name="hidIdImpresion[]" value="'+IdImpresion+'"  /></td>';
		var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="' + Precio + '" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value="' + Precio + '"  /></td>';
		var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="' + Total + '" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value="' + Total + '"  /></td>';

		var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
			strHtml7 += '<input type="hidden" id="hdnDescripcionImprenta' + oId +'" name="hdnDescripcionImprenta[]" value="' + DescripcionImprenta + '" />';
			strHtml7 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="' + PapelTipo + '" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="' + MaterialPapelTipo + '" />';
			strHtml7 += '<input type="hidden" id="hdnResmaTamano' + oId +'" name="hdnResmaTamano[]" value="' + ResmaTamano + '" />';				
			strHtml7 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="' + Tamano + '" />';			
			strHtml7 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="' + CantidadCopia + '" />';
			strHtml7 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="' + ColorTinta + '" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoAncho' + oId +'" name="hdnOtroTamanoAncho[]" value="' + OtroTamanoAncho + '" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoLargo' + oId +'" name="hdnOtroTamanoLargo[]" value="' + OtroTamanoLargo + '" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionInicio' + oId +'" name="hdnNumeracionInicio[]" value="' + NumeracionInicio + '" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionFinal' + oId +'" name="hdnNumeracionFinal[]" value="' + NumeracionFinal + '" />';			
			
			var c = 0;
			
			while (c <= 3)
			{
				if (c == 0)
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="' + ColorPapel[c] + '" />';					
				else
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="' + ColorPapel[c] + '" />';
				
				c = c + 1;
			}
			
			strHtml7 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="' + TipoForro + '" />';			
			strHtml7 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="' + Tiempo + '" />';
			strHtml7 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="' + TipoTiempo + '" />';			
			strHtml7 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="' + TipoCategoria + '" />';
			
			strHtml7 += '<input type="hidden" id="hdnSinNumeracion' + oId + '" name="hdnSinNumeracion[]" value="' + SinNumeracion + '"  />';
			strHtml7 += '<input type="hidden" id="hdnArte' + oId + '" name="hdnArte[]" value="' + Arte + '"  />';	
			strHtml7 += '<input type="hidden" id="hdnPlaca' + oId + '" name="hdnPlaca[]" value="' + Placa + '"  />';

			strHtml7 += '<input type="hidden" id="hdnDescripcionBanner' + oId +'" name="hdnDescripcionBanner[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialBanner' + oId +'" name="hdnMaterialBanner[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnAncho' + oId +'" name="hdnAncho[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnAnchoMedida' + oId +'" name="hdnAnchoMedida[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnLargo' + oId +'" name="hdnLargo[]"value="" />';				
			strHtml7 += '<input type="hidden" id="hdnLargoMedida' + oId +'" name="hdnLargoMedida[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnAreaTotal' + oId +'" name="hdnAreaTotal[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnFormaPago' + oId +'" name="hdnFormaPago[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnCalidadBanner' + oId +'" name="hdnCalidadBanner[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioInstalacion' + oId +'" name="hdnPrecioInstalacion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRecorte' + oId +'" name="hdnPrecioRecorte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioArte' + oId +'" name="hdnPrecioArte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRotulado' + oId +'" name="hdnPrecioRotulado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBasta' + oId +'" name="hdnPrecioBasta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioOjete' + oId +'" name="hdnPrecioOjete[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBulcaniza' + oId +'" name="hdnPrecioBulcaniza[]" value="" />';						
			strHtml7 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]" value="' + ExentoITBM + '"  />';				
			strHtml7 += '<input type="hidden" id="hdnNotaCotizacion' + oId + '" name="hdnNotaCotizacion[]" value="' + NotaCotizacion + '"  />';	
			strHtml7 += '<input type="hidden" id="hdnDescripcionImpresion' + oId +'" name="hdnDescripcionImpresion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialImpresion' + oId +'" name="hdnMaterialImpresion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnRecorte' + oId +'" name="hdnRecorte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPlastificado' + oId +'" name="hdnPlastificado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnCaminado' + oId +'" name="hdnCaminado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnRealce' + oId +'" name="hdnRealce[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnDoblado' + oId +'" name="hdnDoblado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnRepujado' + oId +'" name="hdnRepujado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnEngrapado' + oId +'" name="hdnEngrapado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnUV' + oId +'" name="hdnUV[]" value="" />';	
			strHtml7 += '<input type="hidden" id="hdnCantPliego' + oId +'" name="hdnCantPliego[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnAjustarTamano' + oId +'" name="hdnAjustarTamano[]" value="" />';				
			strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
		var strHtml8 = '<tr><td colspan="6"><table width="100%">';		
			strHtml8 += '<tr><td colspan="2">Descripci&oacute;n:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtDescripcionImprenta' + oId + '" name="txtDescripcionImprenta[]" value=""  class="validate[required]"  style="width:50%;"/>';
			strHtml8 += '</td></tr>';
			
			strHtml8 += '<tr><td colspan="2">Tipo de Papel a Usar:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstPapelTipo[]" id="lstPapelTipo' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="">Seleccione el Tipo de Papel</option>';	
			strHtml8 += '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstMaterialPapelTipo[]" id="lstMaterialPapelTipo' + oId + '" class="validate[required]" style="display:none" disabled="disabled">';
			strHtml8 += '<option value="">Seleccione el Material Tipo de Papel</option>';		
			strHtml8 += '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstResmaTamano[]" id="lstResmaTamano' + oId + '" class="validate[required]" style="display:none" disabled="disabled">';
			strHtml8 += '<option value="">Seleccione el Tama&ntilde;o de Resma de Papel</option>';		
			strHtml8 += '</select></td></tr>';
			strHtml8 += '<tr><td>Tama&ntilde;o de Factura:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstTamano[]" id="lstTamano' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="">Seleccione el Tama&ntilde;o del Papel</option>';				
			strHtml8 += '</select></td>';
			strHtml8 += '<tr id="otrotamano' + oId + '"></tr>';
			strHtml8 += '<td>Color de la Tinta:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstColorTinta[]" id="lstColorTinta' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="">Seleccione el Color de Tinta</option>';		
			strHtml8 += '</select></td></tr>';			
			strHtml8 += '<tr><td colspan="2">Cantidad de Copias:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstCantidadCopia[]" id="lstCantidadCopia' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="">Seleccione la Cantidad de Copias</option>';					
			strHtml8 += '</select></td></tr>';
			strHtml8 += '<tr><td colspan="2">Numeraci&oacute;n de la Factura:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtNumeracionInicio' + oId + '" name="txtNumeracionInicio[]" value="'+ NumeracionInicio +'"  class="validate[required]"  style="width:5%; text-align:right;"/>&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtNumeracionFinal' + oId + '" name="txtNumeracionFinal[]" value="'+ NumeracionFinal +'"  class="validate[required]"  style="width:5%;; text-align:right;" readonly="readonly" />';			
			strHtml8 += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sin Numeraci&oacute;n:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="checkbox" id="chkSinNumeracion' + oId + '" name="chkSinNumeracion[]" value="1"  class=""  style="width:5%;"/>';
			strHtml8 += '</td></tr>';			
			strHtml8 += '<tr id="colorpapel' + oId + '"></tr>';	
			strHtml8 += '<tr><td>Forro:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstTipoForro[]" id="lstTipoForro' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="">Seleccione el Tipo de Forro</option>';		
			strHtml8 += '</select></td>';


			strHtml8 += '<td>Cantidad de:&nbsp;&nbsp;<input type="text" id="txtTiempo' + oId + '" name="txtTiempo[]" value=""  class=""  style="width:50%;"/>';
			strHtml8 += '&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="rdbHora' + oId + '" name="rdbTiempo' + oId + '" value="1" class="" data-prompt-position="topRight:102"/><label for="radioReq">&nbsp;&nbsp;Hora</label>';
			strHtml8 += '&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="rdbDia' + oId + '" name="rdbTiempo' + oId + '" value="2" class="" data-prompt-position="topRight:102"/><label for="radioReq">&nbsp;&nbsp;D&iacute;a</label>';
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td>Categor&iacute;a:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstTipoCategoria[]" id="lstTipoCategoria' + oId + '" class="">';
			strHtml8 += '<option value="0">Seleccione el Tipo de Categor&iacute;a</option>';		
			strHtml8 += '</select></td>';
			strHtml8 += '<td>Exento de ITBMS:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="checkbox" id="chkExentoITBM' + oId + '" name="chkExentoITBM[]" value="1"  class=""  style="width:5%;"/>';
			strHtml8 += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hacer Arte:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="checkbox" id="chkArte' + oId + '" name="chkArte[]" value="1"  class=""  style="width:5%;"/>';
			strHtml8 += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Placa:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="checkbox" id="chkPlaca' + oId + '" name="chkPlaca[]" value="1"  class=""  style="width:5%;"/>';			
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr valign="middle" ><td colspan="2">Nota:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<textarea rows="4" cols="" name="txtNotaCotizacion[]"  id="txtNotaCotizacion' + oId + '" class="autoGrow lim" placeholder="'+ ((NotaCotizacion=="")?'Escribir Observaciones':'') + '" style="width:50%">'+ ((NotaCotizacion=="")?'':NotaCotizacion) +'</textarea>';
			strHtml8 += '</td></tr>';				
			
			strHtml8 += '</table></td></tr><tr><td colspan="6"><a href="javascript:void(0)" onclick="Ocultar_Detalles(' + oId +',\''+Libreta+'\')" >Ocultar detalle</a></td></tr>';				
		var strHtml9 = '</tr>';
			strHtml9 += '</table></td>';	
		var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;		
	
		$("#rowDetalle_" + oId).html(strHtmlFinal);
		
		$.post("library/funciones.php?action=Verificar_Administrador",
		function(data){

			if (data == "true")
			{
				$("#txtPrecio"+oId).attr("readonly",false);
				$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
				$("#txtPrecio" + oId).keydown(function(event){
				//alert(event.keyCode);
					if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
						return false;
					}
				});
						
				$("#txtPrecio" + oId).change(function(){

					$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
					$("#txtPrecio"+oId).attr("title","Precio Especial");
					$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

					$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
					$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
					$("#hidTotal" + oId).val($("#txtTotal" + oId).val());

					Calcular_Total_Cotizacion ();
				});
			}
			else
			{
				$("#txtPrecio"+oId).attr("readonly",true);
			}
		});
		
		if (ExentoITBM == 1)
		$("#chkExentoITBM"+oId).attr("checked",true);
		else
		$("#chkExentoITBM"+oId).attr("checked",false);
		
		if (SinNumeracion == 1)
		{
			$("#chkSinNumeracion"+oId).attr("checked",true);
			$("#txtNumeracionInicio" + oId).val("");
			$("#txtNumeracionFinal" + oId).val("");	
			$("#hdnNumeracionInicio" + oId).val("");
			$("#hdnNumeracionFinal" + oId).val("");	
			$("#txtNumeracionInicio" + oId).attr("disabled",true);
			$("#txtNumeracionFinal" + oId).attr("disabled",true);				
		}
		else
		{
			$("#chkSinNumeracion"+oId).attr("checked",false);
			$("#txtNumeracionInicio" + oId).attr("disabled",false);
			$("#txtNumeracionFinal" + oId).attr("disabled",false);			
		}
		
		if (Arte == 1)
		$("#chkArte"+oId).attr("checked",true);
		else
		$("#chkArte"+oId).attr("checked",false);

		if (Placa == 1)
		$("#chkPlaca"+oId).attr("checked",true);
		else
		$("#chkPlaca"+oId).attr("checked",false);		
	
		GenerarTipoPapel(oId,PapelTipo);
				
		if (PapelTipo != undefined)
		{
			if (MaterialPapelTipo != undefined)
			GenerarMaterialTipoPapel(oId,PapelTipo,MaterialPapelTipo);
			else
			GenerarMaterialTipoPapel(oId,PapelTipo);
			
			if (ResmaTamano != undefined)
			{
				GenerarTamanoResmaPapel(oId,PapelTipo,ResmaTamano);
			

			
				if (Tamano != undefined)
				GenerarTamanoPapel(oId,PapelTipo,ResmaTamano,Tamano);
				else
				GenerarTamanoPapel(oId,PapelTipo,ResmaTamano);				
			}
			else
			GenerarTamanoResmaPapel(oId,PapelTipo);			
	
		}
		
		
			
		$("#lstPapelTipo" + oId).change(function(){		
			GenerarMaterialTipoPapel(oId,$("#lstPapelTipo" + oId).val());
			GenerarTamanoResmaPapel(oId,$("#lstPapelTipo" + oId).val());
			
			if ($("#lstPapelTipo" + oId).val()==2)
			GenerarTamanoPapel(oId,$("#lstPapelTipo" + oId).val(),$("#lstResmaTamano" + oId).val());			

			$("#otrotamano" + oId).empty();
			
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());			

			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			
			Calcular_Precio_Imprenta(oId);					
		});
	
		GenerarColorTinta(oId,ColorTinta);
		
		if ((CantidadCopia != undefined) & (CantidadCopia != ""))
		{			
			var c = 0;
			var strHtmlCopia = '<td colspan="2"><table><tr><td>';
			
			while (c <= CantidadCopia)
			{
				if ((c%2 == 0) && (c > 0))
				{
					strHtmlCopia += '<tr><td>';
				}
				
				if (c==0)
				{
					strHtmlCopia += 'Color de Papel Original:&nbsp;&nbsp;&nbsp;&nbsp;';
					strHtmlCopia += '<select name="lstColorPapel[]" id="lstColorPapel' + oId + '" class="validate[required]" >';
					strHtmlCopia += '<option value="">Seleccione el Color del Papel Original</option>';		
					strHtmlCopia += '</select>';					
				}
				else
				{	
					strHtmlCopia += 'Color de Papel Copia '+ c +':&nbsp;&nbsp;&nbsp;&nbsp;';
					strHtmlCopia += '<select name="lstColorPapel' + c + '[]" id="lstColorPapel' + c + oId + '" class="validate[required]" >';
					strHtmlCopia += '<option value="">Seleccione el Color del Papel'+ c +'</option>';		
					strHtmlCopia += '</select>';	
				}
				
				if ((c%2 > 0) & (c < (CantidadCopia - 2)))
				{
					strHtmlCopia += '</td></tr>';
				}
				else 
				{
					strHtmlCopia += '</td><td>';				
				}
			
				c = c + 1;
			}
			
			strHtmlCopia += '</td></tr></table></td>';
			
			$("#colorpapel" + oId).html(strHtmlCopia)

			c = 0;
			while (c <= CantidadCopia)
			{			
				
				GenerarColorPapel(oId,c,ColorPapel[c]);

				c = c + 1;
			}
			
			
		}
		
		GenerarTipoForro(oId,TipoForro);
		$("#txtDescripcionImprenta" + oId).val(DescripcionImprenta);
		$("#txtTiempo" + oId).val(Tiempo);
		GenerarCategoriaVolumen(oId,TipoCategoria);
		
		$("#txtProducto" + oId).autocomplete({
			source: "application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar",
			select:  function(event, ui) {
				
				$("#hidDescProducto" + oId).val(ui.item.value);
				$("#hidIdProducto" + oId).val(ui.item.id_producto);
				$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
				$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
				$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));

				Generar_Descripcion_Producto(oId);				
				
				$("#txtCantidad" + oId).change(function(){
		
					if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == 'timp') & ($("#txtCantidad" + oId).val() > 1))
					{
						alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
						$("#txtCantidad" + oId).val('0');			
					}
					else if($("#txtCantidad" + oId).val() == 0)
					{
						alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
						$("#txtCantidad" + oId).val('0');			
					}					
					else
					{		
						$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
						$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
						Calcular_Total_Cotizacion(); 
					}
				});	
				
				$.post("library/funciones.php?action=Verificar_Administrador",
	 			function(data){

					if (data == "true")
					{
						$("#txtPrecio"+oId).attr("readonly",false);
						$("#txtPrecio"+oId).attr("title","Precio Sugerido");

						$("#txtPrecio" + oId).keydown(function(event){

							if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
								return true;
							}
							else
							{
								return false;
							}
						});							
						
						$("#txtPrecio" + oId).change(function(){
							$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
							$("#txtPrecio"+oId).attr("title","Precio Especial");
							$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

							$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
							Calcular_Total_Cotizacion ();
						});
					}
					else
					{
						$("#txtPrecio"+oId).attr("readonly",true);
					}
				});						
				
				Calcular_Total_Cotizacion ();			
			},
			change: function (event, ui) {
			
				if (ui.item === null)
				{	
					$("#txtProducto"+oId).val("");
					$("#hidDescProducto" + oId).val("");
					$("#hidIdProducto" + oId).val("");
					$("#txtTipoEmpaque" + oId).val("");
					$("#hidTipoEmpaque" + oId).val("");
					$("#txtPrecio" + oId).val("0.00");
					$("#hidPrecio" + oId).val("0.00");
					$("#txtTotal" + oId).val("0.00");
					$("#hidTotal" + oId).val("0.00");			
				}
				else
				{
					
					$("#hidDescProducto" + oId).val(ui.item.value);
					$("#hidIdProducto" + oId).val(ui.item.id_producto);
					$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
					$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
					$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
					$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));

					Generar_Descripcion_Producto(oId);				
					
					$("#txtCantidad" + oId).change(function(){
			
						if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == 'timp') & ($("#txtCantidad" + oId).val() > 1))
						{
							alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
							$("#txtCantidad" + oId).val('0');			
						}
						else if($("#txtCantidad" + oId).val() == 0)
						{
							alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
							$("#txtCantidad" + oId).val('0');			
						}					
						else
						{		
							$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
							Calcular_Total_Cotizacion(); 
						}
					});	
					
					$.post("library/funciones.php?action=Verificar_Administrador",
					function(data){

						if (data == "true")
						{
							$("#txtPrecio"+oId).attr("readonly",false);
							$("#txtPrecio"+oId).attr("title","Precio Sugerido");

							$("#txtPrecio" + oId).keydown(function(event){
							//alert(event.keyCode);
								if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
									return true;
								}
								else
								{
									return false;
								}
							});							
							
							$("#txtPrecio" + oId).change(function(){
								$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
								$("#txtPrecio"+oId).attr("title","Precio Especial");
								$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

								$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
								$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
								$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
								Calcular_Total_Cotizacion ();
							});
						}
						else
						{
							$("#txtPrecio"+oId).attr("readonly",true);
						}
					});						
					
					Calcular_Total_Cotizacion ();			

				}				
			}
	
		});
				
		$("#txtCantidad" + oId).keydown(function(event){
			//alert(event.keyCode);
			if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});		
	
		$("#txtTiempo" + oId).keydown(function(event){
			//alert(event.keyCode);
			if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});
		
		if(Cantidad!=undefined)
		{
			$("#txtCantidad" + oId).val(Cantidad);
			$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());		
		}

		
		$("#txtCantidad" + oId).change(function(){
				
			if (($("#txtCantidad" + oId).val()%2 == 0) & ($("#txtCantidad" + oId).val() > 1) & $("#hidIdProducto" + oId).val() == "timp")
			{
				$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
				$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
				$("#hidTotal" + oId).val($("#txtTotal" + oId).val());

				if ($("#lstCantidadCopia" + oId).val() > 0)
				$("#txtNumeracionFinal" + oId).val(parseInt($("#txtNumeracionInicio" + oId).val())+(parseInt($("#txtCantidad" + oId).val())*50)-1);
				else
				$("#txtNumeracionFinal" + oId).val(parseInt($("#txtNumeracionInicio" + oId).val())+(parseInt($("#txtCantidad" + oId).val())*100)-1);				
				
				$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
				$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());
				
				Calcular_Precio_Imprenta(oId);			
			}
			else if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#txtCantidad" + oId).val() > 1) & $("#hidIdProducto" + oId).val() == "timp")
			{
				alert("La cantidad de Trabajo de Imprenta debe ser un número par.")			
				$("#txtCantidad" + oId).val('0');
			}
			else if ($("#txtCantidad" + oId).val() == 0)
			{
				alert("La cantidad de Trabajo de Imprenta no debe ser 0.")
				$("#txtCantidad" + oId).val('0');
			}
		});
		
		$("#lstMaterialPapelTipo" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());				

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			
		});	

		$("#lstResmaTamano" + oId).change(function(){

			GenerarTamanoPapel(oId,$("#lstPapelTipo" + oId).val(),$("#lstResmaTamano" + oId).val());		
		
			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());				
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			
		});
		
		$("#lstTamano" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());				
			
			if ($("#lstTamano" + oId).val() == "o")
			{
				var strHtmlOtroTamano = '<tr><td>';
				strHtmlOtroTamano += '&nbsp;&nbsp;Ancho:<input type="text" id="txtOtroTamanoAncho' + oId + '" name="txtOtroTamanoAncho[]" value=""  class="validate[required]"  style="width:25%;"/><input type="hidden" id="hdnOtroTamanoAncho' + oId + '" name="hdnOtroTamanoAncho[]" value=""  />';
				strHtmlOtroTamano += '&nbsp;&nbsp;&nbsp;&nbsp;Largo:<input type="text" id="txtOtroTamanoLargo' + oId + '" name="txtOtroTamanoLargo[]" value=""  class="validate[required]"  style="width:25%;"/><input type="hidden" id="hdnOtroTamanoLargo' + oId + '" name="hdnOtroTamanoLargo[]" value=""  />';
				strHtmlOtroTamano += '</td><td>&nbsp;</td></tr>';
				
				$("#otrotamano" + oId).html(strHtmlOtroTamano);
				
				$("#txtOtroTamanoAncho" + oId).keydown(function(event){
				//alert(event.keyCode);
					if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
						return false;
					}
				});	

				$("#txtOtroTamanoLargo" + oId).keydown(function(event){
				//alert(event.keyCode);
					if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
						return false;
					}
				});
				
				
			}
			else
			{
				$("#otrotamano" + oId).empty();
			}
			
			$("#txtOtroTamanoAncho" + oId).change(function(){
		
				$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
				$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());	
			
				$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
				$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());			
				$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
				$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
				$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
				$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
				$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
				$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
				$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
				$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
				$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
				$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
				$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
				$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
				$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
				$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
				$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
				$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());				
				$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

				$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
				$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
				$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());				
			
				Verificar_Otro_Tamano(oId);

				$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
				$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());			
			
				$("#txtPrecio"+oId).attr("title","Precio Sugerido");
				
				Calcular_Precio_Imprenta(oId);		
			});

			$("#txtOtroTamanoLargo" + oId).change(function(){
		
				$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
				$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());	
			
				$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
				$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());			
				$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
				$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
				$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
				$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
				$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
				$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
				$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
				$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
				$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
				$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
				$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
				$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
				$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
				$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
				$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
				$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());				
				$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

				$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());			
				$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
				$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());				
			
				Verificar_Otro_Tamano(oId);

				$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
				$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());				
			
				$("#txtPrecio"+oId).attr("title","Precio Sugerido");

		
				Calcular_Precio_Imprenta(oId);		
			});
			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			
			//Calcular_Total_Cotizacion ();	
		});


		$("#txtNumeracionInicio" + oId).keydown(function(event){
			//alert(event.keyCode);
			if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});	
		
		$("#txtNumeracionInicio" + oId).change(function(){

			if ($("#txtNumeracionInicio" + oId).val()%10 == 1)
			{
				$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
				$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());			
				$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
				$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
				$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
				$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
				$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
				$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
				$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
				$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
				$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
				$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
				$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
				$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
				$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
				$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
				$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
				$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());				
				$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

				$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
				$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());	


				$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());

				if($("#chkSinNumeracion" + oId + ":checked").val()==1)
				{				
					$("#txtNumeracionInicio" + oId).val("");
					$("#txtNumeracionFinal" + oId).val("");	
					$("#hdnNumeracionInicio" + oId).val("");
					$("#hdnNumeracionFinal" + oId).val("");	
				}
				else
				{
					if ($("#lstCantidadCopia" + oId).val() > 0)
					$("#txtNumeracionFinal" + oId).val(parseInt($("#txtNumeracionInicio" + oId).val())+(parseInt($("#txtCantidad" + oId).val())*50)-1);
					else
					$("#txtNumeracionFinal" + oId).val(parseInt($("#txtNumeracionInicio" + oId).val())+(parseInt($("#txtCantidad" + oId).val())*100)-1);	
				
					$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
					$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());
				}
			
				Calcular_Precio_Imprenta(oId);			
				//Calcular_Total_Cotizacion ();
			}
				else
			{
				alert("La Numeración de la Factura en el Trabajo de Imprenta debe ser un número terminado en 1.")
				$("#txtNumeracionInicio" + oId).val('1');
			}			
			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
	
		});	
		
		$("#chkSinNumeracion" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());				

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());

			if($("#chkSinNumeracion" + oId + ":checked").val()==1)
			{
				
				$("#txtNumeracionInicio" + oId).val("");
				$("#txtNumeracionFinal" + oId).val("");
				$("#txtNumeracionInicio" + oId).attr("disabled",true);
				$("#txtNumeracionFinal" + oId).attr("disabled",true);			
				$("#hdnNumeracionInicio" + oId).val("");
				$("#hdnNumeracionFinal" + oId).val("");			
			}
			else
			{
				$("#txtNumeracionInicio" + oId).attr("disabled",false);
				$("#txtNumeracionFinal" + oId).attr("disabled",false);
				$("#txtNumeracionInicio" + oId).val("1");
				if ($("#lstCantidadCopia" + oId).val() > 0)
				$("#txtNumeracionFinal" + oId).val(parseInt($("#txtNumeracionInicio" + oId).val())+(parseInt($("#txtCantidad" + oId).val())*50)-1);
				else
				$("#txtNumeracionFinal" + oId).val(parseInt($("#txtNumeracionInicio" + oId).val())+(parseInt($("#txtCantidad" + oId).val())*100)-1);					

				
				$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
				$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());
			}

			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			
			//Calcular_Total_Cotizacion ();	
		});		
		
		$("#lstCantidadCopia" + oId).change(function(){

			if ($("#lstCantidadCopia" + oId).val() > 0)
			$("#txtNumeracionFinal" + oId).val(parseInt($("#txtNumeracionInicio" + oId).val())+(parseInt($("#txtCantidad" + oId).val())*50)-1);
			else
			$("#txtNumeracionFinal" + oId).val(parseInt($("#txtNumeracionInicio" + oId).val())+(parseInt($("#txtCantidad" + oId).val())*100)-1);
			
			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			
			var c = 0;
			while (c <= $("#lstCantidadCopia" + oId).val())
			{			
				if (c==0)
				$("#hdnColorPapel" + oId).val(1);
				else
				$("#hdnColorPapel" + c + oId).val($("#lstColorPapel" + c + oId).val());
				
				c = c + 1;
			}
			
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());
			
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());				

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			
			if($("#chkSinNumeracion" + oId + ":checked").val()==1)
			{				
				$("#txtNumeracionInicio" + oId).val("");
				$("#txtNumeracionFinal" + oId).val("");	
				$("#hdnNumeracionInicio" + oId).val("");
				$("#hdnNumeracionFinal" + oId).val("");	
			}
			else
			{				
				$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
				$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());				
			}
			var c = 0;
			var strHtmlCopia = '<td colspan="2"><table><tr><td>';
			var copia = $("#lstCantidadCopia" + oId).val();
			
			while (c <= $("#lstCantidadCopia" + oId).val())
			{
				if ((c%2 == 0) && (c > 0))
				{
					strHtmlCopia += '<tr><td>';
				}
				
				if (c==0)
				{
					strHtmlCopia += 'Color de Papel Original:&nbsp;&nbsp;&nbsp;&nbsp;';
					strHtmlCopia += '<select name="lstColorPapel[]" id="lstColorPapel' + oId + '" class="validate[required]" >';
					strHtmlCopia += '<option value="">Seleccione el Color del Papel Original</option>';		
					strHtmlCopia += '</select>';					
				}
				else
				{	
					strHtmlCopia += 'Color de Papel Copia '+ c +':&nbsp;&nbsp;&nbsp;&nbsp;';
					strHtmlCopia += '<select name="lstColorPapel' + c + '[]" id="lstColorPapel' + c + oId + '" class="validate[required]" >';
					strHtmlCopia += '<option value="">Seleccione el Color del Papel'+ c +'</option>';		
					strHtmlCopia += '</select>';	
				}
				
				if ((c%2 > 0) & (c < ($("#lstCantidadCopia" + oId).val() - 2)))
				{
					strHtmlCopia += '</td></tr>';
				}
				else 
				{
					strHtmlCopia += '</td><td>';				
				}
			
				c = c + 1;
			}
			
			strHtmlCopia += '</td></tr></table></td>';
			
			$("#colorpapel" + oId).html(strHtmlCopia);

			c = 0;
			while (c <= $("#lstCantidadCopia" + oId).val())
			{			
				
				GenerarColorPapel(oId,c,ColorPapel[c]);

				c = c + 1;
			}
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			
			//Calcular_Total_Cotizacion ();	
		});	
		
		$("#lstColorTinta" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());			
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());	

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			
			//Calcular_Total_Cotizacion ();	
		});			
		
		$("#lstColorPapel" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());							
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());	

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			

		});	

		$("#lstColorPapel1" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());							
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());	

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			

		});
		
		$("#lstColorPapel2" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());							
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());	

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			

		});	


		$("#lstColorPapel3" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());							
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());	

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			
	
		});			
	
		$("#lstTipoForro" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());	

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			

		});	
	
		$("#txtTiempo" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());	

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			

		});
		
		$("input[name='rdbTiempo" + oId + "']").change(function(){

			//alert($("input[name='rdbTiempo" + oId + "']:checked").val())
			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());	

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			
		});	

		$("#chkExentoITBM" + oId).change(function(){

			//alert(oId);
		
			//alert($("input[name='chkExentoITBM" + oId + "']:checked").val());
			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());				

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			

		});

		$("#chkArte" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());				

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			

		});

		$("#chkPlaca" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());				

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			

		});		
		
		$("#lstTipoCategoria" + oId).change(function(){

			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());				
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());

			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());	

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			
		});

				
		$("#txtDescripcionImprenta" + oId).change(function(){
			
			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());
			
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());	
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			
	
		});	

		
		
		$("#txtNotaCotizacion" + oId).change(function(){
			
			$("#hdnDescripcionImprenta" + oId).val($("#txtDescripcionImprenta" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnPapelTipo" + oId).val($("#lstPapelTipo" + oId).val());
			$("#hdnMaterialPapelTipo" + oId).val($("#lstMaterialPapelTipo" + oId).val());
			$("#hdnResmaTamano" + oId).val($("#lstResmaTamano" + oId).val());			
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnCantidadCopia" + oId).val($("#lstCantidadCopia" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnColorPapel1" + oId).val($("#lstColorPapel1" + oId).val());	
			$("#hdnColorPapel2" + oId).val($("#lstColorPapel2" + oId).val());
			$("#hdnColorPapel3" + oId).val($("#lstColorPapel3" + oId).val());
			$("#hdnTipoForro" + oId).val($("#lstTipoForro" + oId).val());
			$("#hdnTiempo" + oId).val($("#txtTiempo" + oId).val());
			$("#hdnTipoTiempo" + oId).val($("input[name='rdbTiempo" + oId + "']:checked").val());
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnArte" + oId).val($("#chkArte" + oId + ":checked").val());
			$("#hdnPlaca" + oId).val($("#chkPlaca" + oId + ":checked").val());			
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());
			
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());

			$("#hdnSinNumeracion" + oId).val($("#chkSinNumeracion" + oId + ":checked").val());
			$("#hdnNumeracionInicio" + oId).val($("#txtNumeracionInicio" + oId).val());
			$("#hdnNumeracionFinal" + oId).val($("#txtNumeracionFinal" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Imprenta(oId);			

		});			
			
		$("#lstCantidadCopia" + oId + " option[value='" + CantidadCopia + "']").attr("selected",true);

		$('input:radio[name=rdbTiempo' + oId + ']:nth('+(TipoTiempo-1)+')').attr('checked',true);

	}
	else if(Libreta == "tbnr")
	{					
		var Id = $("#hdnIdCampos_" + oId).val();
	
		var DescripcionBanner = $("#hdnDescripcionBanner" + oId).val();
		if (DescripcionBanner == undefined)
		DescripcionBanner = "";			
		
		var MaterialBanner = $("#hdnMaterialBanner" + oId).val();
		
		var Ancho = $("#hdnAncho" + oId).val();
		if (Ancho == undefined)
		Ancho = "0.00";			
		
		var AnchoMedida = $("#hdnAnchoMedida" + oId).val();
		
		var Largo = $("#hdnLargo" + oId).val();
		if (Largo == undefined)
		Largo = "0.00";

		//alert($("#hdnAreaTotal" + oId).val()); 
		
		var AreaTotal = $("#hdnAreaTotal" + oId).val();
		if ((AreaTotal == undefined) | (AreaTotal == ""))
		AreaTotal = "0.00";
		
		
		var LargoMedida = $("#hdnLargoMedida" + oId).val();
		var FormaPago = $("#hdnFormaPago" + oId).val();
		var CalidadBanner = $("#hdnCalidadBanner" + oId).val();
		
		var PrecioInstalacion = $("#hdnPrecioInstalacion" + oId).val();
		if ((PrecioInstalacion == undefined) | (PrecioInstalacion == ""))
		PrecioInstalacion = "0.00";			
		
		var PrecioRecorte = $("#hdnPrecioRecorte" + oId).val();
		if ((PrecioRecorte == undefined) | (PrecioRecorte == ""))
		PrecioRecorte = "0.00";			
		
		var PrecioArte = $("#hdnPrecioArte" + oId).val();
		if ((PrecioArte == undefined) | (PrecioArte == ""))
		PrecioArte = "0.00";			
		
		var PrecioRotulado = $("#hdnPrecioRotulado" + oId).val();
		if ((PrecioRotulado == undefined) | (PrecioRotulado == ""))
		PrecioRotulado = "0.00";
		
		var PrecioBasta = $("#hdnPrecioBasta" + oId).val();
		if ((PrecioBasta == undefined) | (PrecioBasta == ""))
		PrecioBasta = "0.00";		
		
		var PrecioOjete = $("#hdnPrecioOjete" + oId).val();
		if ((PrecioOjete == undefined) | (PrecioOjete == ""))
		PrecioOjete = "0.00";		
		
		var PrecioBulcaniza = $("#hdnPrecioBulcaniza" + oId).val();
		if ((PrecioBulcaniza == undefined) | (PrecioBulcaniza == ""))
		PrecioBulcaniza = "0.00";
		
		
		//$("#rowDetalle_" + oId).remove();										
		var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
		var strHtml1 = '<td colspan="6"><table width="100%">';
			strHtml1 += '<tr>';
		var strHtml2 = '<td width="15%">' + '<input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
		var strHtml3 = '<td width="15%">' + '<input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="'+ DescTipoEmpaque +'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value="'+ TipoEmpaque +'"  /></td>';	
		var strHtml4 = '<td width="32%">';		
			strHtml4 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto[]" style="width:85%;" class="validate[required]" value="'+DescProducto+'"/>';			
			strHtml4 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value="'+Producto+'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+DescProducto+'"  />';
			strHtml4 += '<input type="hidden" id="hidIdImprenta' + oId + '" name="hidIdImprenta[]" value="'+IdImprenta+'"  />';
			strHtml4 += '<input type="hidden" id="hidIdBanner' + oId + '" name="hidIdBanner[]" value="'+IdBanner+'"  />';		
			strHtml4 += '<input type="hidden" id="hidIdImpresion' + oId + '" name="hidIdImpresion[]" value="'+IdImpresion+'"  /></td>';
		var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="' + Precio + '" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value="' + Precio + '"  /></td>';
		var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="' + Total + '" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value="' + Total + '"  /></td>';

		var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';	
			strHtml7 += '<input type="hidden" id="hdnDescripcionImprenta' + oId +'" name="hdnDescripcionImprenta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnResmaTamano' + oId +'" name="hdnResmaTamano[]" value="" />';				
			strHtml7 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoAncho' + oId +'" name="hdnOtroTamanoAncho[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoLargo' + oId +'" name="hdnOtroTamanoLargo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnSinNumeracion' + oId + '" name="hdnSinNumeracion[]" value=""  />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionInicio' + oId +'" name="hdnNumeracionInicio[]" value=""" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionFinal' + oId +'" name="hdnNumeracionFinal[]" value="" />';			
			
			var c = 0;
			
			while (c <= 3)
			{
				if (c == 0)
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="" />';					
				else
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="" />';
				
				c = c + 1;
			}
			
			strHtml7 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]" value=""  />';	
			strHtml7 += '<input type="hidden" id="hdnArte' + oId + '" name="hdnArte[]" value=""  />';	
			strHtml7 += '<input type="hidden" id="hdnPlaca' + oId + '" name="hdnPlaca[]" value=""  />';				


			strHtml7 += '<input type="hidden" id="hdnDescripcionBanner' + oId +'" name="hdnDescripcionBanner[]" value="' + DescripcionBanner + '" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialBanner' + oId +'" name="hdnMaterialBanner[]" value="' + MaterialBanner + '" />';			
			strHtml7 += '<input type="hidden" id="hdnAncho' + oId +'" name="hdnAncho[]" value="' + Ancho + '" />';
			strHtml7 += '<input type="hidden" id="hdnAnchoMedida' + oId +'" name="hdnAnchoMedida[]" value="' + AnchoMedida + '" />';
			strHtml7 += '<input type="hidden" id="hdnLargo' + oId +'" name="hdnLargo[]" value="' + Largo + '" />';				
			strHtml7 += '<input type="hidden" id="hdnLargoMedida' + oId +'" name="hdnLargoMedida[]" value="' + LargoMedida + '" />';
			strHtml7 += '<input type="hidden" id="hdnAreaTotal' + oId +'" name="hdnAreaTotal[]" value="' + AreaTotal + '" />';
			strHtml7 += '<input type="hidden" id="hdnFormaPago' + oId +'" name="hdnFormaPago[]" value="' + FormaPago + '" />';
			strHtml7 += '<input type="hidden" id="hdnCalidadBanner' + oId +'" name="hdnCalidadBanner[]" value="' + CalidadBanner + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioInstalacion' + oId +'" name="hdnPrecioInstalacion[]" value="' + PrecioInstalacion + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRecorte' + oId +'" name="hdnPrecioRecorte[]" value="' + PrecioRecorte + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioArte' + oId +'" name="hdnPrecioArte[]" value="' + PrecioArte + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRotulado' + oId +'" name="hdnPrecioRotulado[]" value="' + PrecioRotulado + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBasta' + oId +'" name="hdnPrecioBasta[]" value="' + PrecioBasta + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioOjete' + oId +'" name="hdnPrecioOjete[]" value="' + PrecioOjete + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBulcaniza' + oId +'" name="hdnPrecioBulcaniza[]" value="' + PrecioBulcaniza + '" />';
			strHtml7 += '<input type="hidden" id="hdnNotaCotizacion' + oId + '" name="hdnNotaCotizacion[]" value="' + NotaCotizacion + '"  />';	
			strHtml7 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]" value="' + ExentoITBM + '"  />';
			strHtml7 += '<input type="hidden" id="hdnDescripcionImpresion' + oId +'" name="hdnDescripcionImpresion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialImpresion' + oId +'" name="hdnMaterialImpresion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnRecorte' + oId +'" name="hdnRecorte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPlastificado' + oId +'" name="hdnPlastificado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnCaminado' + oId +'" name="hdnCaminado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnRealce' + oId +'" name="hdnRealce[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnDoblado' + oId +'" name="hdnDoblado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnRepujado' + oId +'" name="hdnRepujado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnEngrapado' + oId +'" name="hdnEngrapado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnUV' + oId +'" name="hdnUV[]" value="" />';	
			strHtml7 += '<input type="hidden" id="hdnCantPliego' + oId +'" name="hdnCantPliego[]" value="" />';	
			strHtml7 += '<input type="hidden" id="hdnAjustarTamano' + oId +'" name="hdnAjustarTamano[]" value="" />';				
			strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
		var strHtml8 = '<tr><td colspan="6"><table width="100%">';		
			strHtml8 += '<tr><td>Descripci&oacute;n de Banner:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtDescripcionBanner' + oId + '" name="txtDescripcionBanner[]" value=""  class="validate[required]"  style="width:50%;"/>';
			strHtml8 += '<td>Material del Banner:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstMaterialBanner[]" id="lstMaterialBanner' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="">Seleccione la Material del Banner</option>';	
			strHtml8 += '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td colspan="2">Dimensi&oacute;n del Banner:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += 'Ancho:&nbsp;&nbsp;&nbsp;<input type="text" id="txtAncho' + oId + '" name="txtAncho[]" value="'+ Ancho +'"  class="validate[required]"  style="width:5%; text-align:right;"/>&nbsp;&nbsp;';
			strHtml8 += '<select name="lstAnchoMedida[]" id="lstAnchoMedida' + oId + '" class="validate[required]" >&nbsp;&nbsp;';
			strHtml8 += '<option value="" title="Seleccione la Unidad de Medida">Seleccione</option>';	
			strHtml8 += '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';			
			strHtml8 += 'Alto:&nbsp;&nbsp;&nbsp;<input type="text" id="txtLargo' + oId + '" name="txtLargo[]" value="'+ Largo +'"  class="validate[required]"  style="width:5%; text-align:right;"  />&nbsp;&nbsp;';			
			strHtml8 += '<select name="lstLargoMedida[]" id="lstLargoMedida' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="" title="Seleccione la Unidad de Medida">Seleccione</option>';	
			strHtml8 += '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
			strHtml8 += '<span id="lblAreaTotal' + oId + '">' + AreaTotal + '</span>&nbsp;&nbsp;pies&sup2;<n>';			
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td>Forma de Pago del Banner:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstFormaPago[]" id="lstFormaPago' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="">Seleccione la Forma de Pago</option>';	
			strHtml8 += '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '</td>';
			strHtml8 += '<td>Calidad del Banner:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstCalidadBanner[]" id="lstCalidadBanner' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="">Seleccione la Calidad del Banner</option>';	
			strHtml8 += '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td>Instalaci&oacute;n:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtPrecioInstalacion' + oId + '" name="txtPrecioInstalacion[]" value="' + PrecioInstalacion + '"  class="validate[required]"  style="width:10%; text-align:right;" onchange="PrecioMoneda(\'txtPrecioInstalacion' + oId + '\');"/>';
			strHtml8 += '</td>';
			strHtml8 += '<td>Recorte:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtPrecioRecorte' + oId + '" name="txtPrecioRecorte[]" value="' + PrecioRecorte + '"  class="validate[required]"  style="width:10%; text-align:right;" onchange="PrecioMoneda(\'txtPrecioRecorte' + oId + '\');"/>';
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td>Arte:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtPrecioArte' + oId + '" name="txtPrecioArte[]" value="' + PrecioArte + '"  class="validate[required]"  style="width:10%; text-align:right;" onchange="PrecioMoneda(\'txtPrecioArte' + oId + '\');"/>';
			strHtml8 += '</td>';
			strHtml8 += '<td>Rotulado:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtPrecioRotulado' + oId + '" name="txtPrecioRotulado[]" value="' + PrecioRotulado + '"  class="validate[required]"  style="width:10%; text-align:right;" onchange="PrecioMoneda(\'txtPrecioRotulado' + oId + '\');"/>';
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td>Basta:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtPrecioBasta' + oId + '" name="txtPrecioBasta[]" value="' + PrecioBasta + '"  class="validate[required]"  style="width:10%; text-align:right;" onchange="PrecioMoneda(\'txtPrecioBasta' + oId + '\');"/>';
			strHtml8 += '</td>';
			strHtml8 += '<td>Ojete:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtPrecioOjete' + oId + '" name="txtPrecioOjete[]" value="' + PrecioOjete + '"  class="validate[required]"  style="width:10%; text-align:right;" onchange="PrecioMoneda(\'txtPrecioOjete' + oId + '\');"/>';
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td>Bulcaniza:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtPrecioBulcaniza' + oId + '" name="txtPrecioBulcaniza[]" value="' + PrecioBulcaniza + '"  class="validate[required]"  style="width:10%; text-align:right;" onchange="PrecioMoneda(\'txtPrecioBulcaniza' + oId + '\');"/>';
			strHtml8 += '</td>';
			strHtml8 += '<td>Exento de ITBMS:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="checkbox" id="chkExentoITBM' + oId + '" name="chkExentoITBM[]" value="1"  class=""  style="width:5%;"/>';
			strHtml8 += '</td></tr>';			
			strHtml8 += '<tr valign="middle" ><td colspan="2">Nota:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<textarea rows="4" cols="" name="txtNotaCotizacion[]"  id="txtNotaCotizacion' + oId + '" class="autoGrow lim" placeholder="'+ ((NotaCotizacion=="")?'Escribir Observaciones':'') + '" style="width:50%">'+ ((NotaCotizacion=="")?'':NotaCotizacion) +'</textarea>';
			strHtml8 += '</td></tr>';				
			
			strHtml8 += '</table></td></tr><tr><td colspan="6"><a href="javascript:void(0)" onclick="Ocultar_Detalles(' + oId +',\''+Libreta+'\')" >Ocultar detalle</a></td></tr>';				
		var strHtml9 = '</tr>';
			strHtml9 += '</table></td>';	
		var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;		
	
		$("#rowDetalle_" + oId).html(strHtmlFinal);

		$.post("library/funciones.php?action=Verificar_Administrador",
		function(data){

			if (data == "true")
			{

				$("#txtPrecio"+oId).attr("readonly",false);
				$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
				$("#txtPrecio" + oId).keydown(function(event){
				//alert(event.keyCode);
					if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
						return false;
					}
				});
						
				$("#txtPrecio" + oId).change(function(){

					$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
					$("#txtPrecio"+oId).attr("title","Precio Especial");
					$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

					$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
					$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
					$("#hidTotal" + oId).val($("#txtTotal" + oId).val());

					Calcular_Total_Cotizacion ();
				});
			}
			else
			{
				$("#txtPrecio"+oId).attr("readonly",true);
			}
		});		
		

		if (MaterialBanner != undefined)
		GenerarMaterial(oId,MaterialBanner);
		else
		GenerarMaterial(oId);		
		
		if (AnchoMedida != undefined)
		GenerarUnidadMedida(oId,"a",AnchoMedida);
		else
		GenerarUnidadMedida(oId,"a");
		
		if (LargoMedida != undefined)
		GenerarUnidadMedida(oId,"l",LargoMedida);
		else
		GenerarUnidadMedida(oId,"l");	
	
		if (FormaPago != undefined)
		GenerarFormaPago(oId,FormaPago);
		else
		GenerarFormaPago(oId);

		if (CalidadBanner != undefined)
		GenerarCalidad(oId,CalidadBanner);
		else
		GenerarCalidad(oId);

		$("#txtDescripcionBanner" + oId).val(DescripcionBanner);
		$("#txtAncho" + oId).val(Ancho);
		$("#txtLargo" + oId).val(Largo);
		$("#txtPrecioInstalacion" + oId).val(PrecioInstalacion);
		$("#txtPrecioRecorte" + oId).val(PrecioRecorte);		
		$("#txtPrecioArte" + oId).val(PrecioArte);
		$("#txtPrecioRotulado" + oId).val(PrecioRotulado);		
		$("#txtPrecioBasta" + oId).val(PrecioBasta);
		$("#txtPrecioOjete" + oId).val(PrecioOjete);
		$("#txtPrecioBulcaniza" + oId).val(PrecioBulcaniza);		

		if (ExentoITBM == 1)
		$("#chkExentoITBM"+oId).attr("checked",true);
		else
		$("#chkExentoITBM"+oId).attr("checked",false);
		
		$("#txtCantidad" + oId).keydown(function(event){
			//alert(event.keyCode);
			if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});

		if(Cantidad!=undefined)
		{
			$("#txtCantidad" + oId).val(Cantidad);
			$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());		
		}
		
		$("#txtCantidad" + oId).change(function(){

			
			if ($("#txtCantidad" + oId).val() > 0)
			{
				$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
				$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
				$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
				//alert("prueba");
			}
			else if($("#txtCantidad" + oId).val() == 0)
			{
				alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
				$("#txtCantidad" + oId).val('0');			
			}	
			
			Calcular_Precio_Banner(oId);
			Calcular_Total_Cotizacion ();				
		});	

		$("#txtProducto" + oId).autocomplete({
			source: "application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar",
			select:  function(event, ui) {
				
				$("#hidDescProducto" + oId).val(ui.item.value);
				$("#hidIdProducto" + oId).val(ui.item.id_producto);
				$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
				$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
				$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));

				Generar_Descripcion_Producto(oId);				
				
				$("#txtCantidad" + oId).change(function(){
		
					if($("#txtCantidad" + oId).val() == 0)
					{
						alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
						$("#txtCantidad" + oId).val('0');			
					}				
					else
					{		
						$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
						$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
						//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
						Calcular_Total_Cotizacion(); 
					}
				});	
				
				$.post("library/funciones.php?action=Verificar_Administrador",
	 			function(data){

					if (data == "true")
					{
						$("#txtPrecio"+oId).attr("readonly",false);
						$("#txtPrecio"+oId).attr("title","Precio Sugerido");

						$("#txtPrecio" + oId).keydown(function(event){
						//alert(event.keyCode);
							if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
								return true;
							}
							else
							{
								return false;
							}
						});							
						
						$("#txtPrecio" + oId).change(function(){
							$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
							$("#txtPrecio"+oId).attr("title","Precio Especial");
							$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

							$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
							Calcular_Total_Cotizacion ();
						});
					}
					else
					{
						$("#txtPrecio"+oId).attr("readonly",true);
					}
				});						
				
				Calcular_Total_Cotizacion ();			

			},
			change: function (event, ui) {
			
				if (ui.item === null)
				{	
					$("#txtProducto"+oId).val("");
					$("#hidDescProducto" + oId).val("");
					$("#hidIdProducto" + oId).val("");
					$("#txtTipoEmpaque" + oId).val("");
					$("#hidTipoEmpaque" + oId).val("");
					$("#txtPrecio" + oId).val("0.00");
					$("#hidPrecio" + oId).val("0.00");
					$("#txtTotal" + oId).val("0.00");
					$("#hidTotal" + oId).val("0.00");			
				}
				else
				{

					$("#hidDescProducto" + oId).val(ui.item.value);
					$("#hidIdProducto" + oId).val(ui.item.id_producto);
					$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
					$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
					$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
					$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));

					Generar_Descripcion_Producto(oId);				
					
					$("#txtCantidad" + oId).change(function(){
			
						if($("#txtCantidad" + oId).val() == 0)
						{
							alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
							$("#txtCantidad" + oId).val('0');			
						}					
						else
						{		
							$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
							//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
							Calcular_Total_Cotizacion(); 
						}
					});	
					
					$.post("library/funciones.php?action=Verificar_Administrador",
					function(data){

						if (data == "true")
						{
							$("#txtPrecio"+oId).attr("readonly",false);
							$("#txtPrecio"+oId).attr("title","Precio Sugerido");

							$("#txtPrecio" + oId).keydown(function(event){
							//alert(event.keyCode);
								if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
									return true;
								}
								else
								{
									return false;
								}
							});							
							
							$("#txtPrecio" + oId).change(function(){
								$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
								$("#txtPrecio"+oId).attr("title","Precio Especial");
								$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

								$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
								$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
								$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
								Calcular_Total_Cotizacion ();
							});

						}
						else
						{
							$("#txtPrecio"+oId).attr("readonly",true);
						}
					});						
					
					Calcular_Total_Cotizacion ();
				}				
			}
	
		});		
		
		$("#txtDescripcionBanner" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			
			Calcular_Precio_Banner(oId);			

		});
		
		$("#lstMaterialBanner" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			
			Calcular_Precio_Banner(oId);			

		});		
		
		$("#txtAncho" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});			
			
		$("#txtAncho" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());

			Calcular_Precio_Banner(oId);			
			//Calcular_Total_Cotizacion ();	
		});	

		$("#lstAnchoMedida" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());


			Calcular_Precio_Banner(oId);

		});			

		$("#txtLargo" + oId).keydown(function(event){

			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});			
			
		$("#txtLargo" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());


			Calcular_Precio_Banner(oId);			
		});	

		$("#lstLargoMedida" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());

			
			Calcular_Precio_Banner(oId);

		});

		$("#lstFormaPago" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());

			
			Calcular_Precio_Banner(oId);			
		});		
		
		$("#lstCalidadBanner" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());

			
			Calcular_Precio_Banner(oId);			
		});			
		
		$("#txtPrecioInstalacion" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});		
		
		$("#txtPrecioInstalacion" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());

			
			Calcular_Precio_Banner(oId);			
		});

		$("#txtPrecioRecorte" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});		
		
		$("#txtPrecioRecorte" + oId).change(function(){
			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
		
			Calcular_Precio_Banner(oId);			

		});

		$("#txtPrecioArte" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});		
		
		$("#txtPrecioArte" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
		
			Calcular_Precio_Banner(oId);			

		});

		$("#txtPrecioRotulado" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});		
		
		$("#txtPrecioRotulado" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			
			Calcular_Precio_Banner(oId);				
		});

		$("#txtPrecioBasta" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});		
		
		$("#txtPrecioBasta" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			
			Calcular_Precio_Banner(oId);			
		});

		$("#txtPrecioOjete" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});		
		
		$("#txtPrecioOjete" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());

			
			Calcular_Precio_Banner(oId);			
		});

		$("#txtPrecioBulcaniza" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});		
		
		$("#txtPrecioBulcaniza" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			
			Calcular_Precio_Banner(oId);			
		});

		$("#chkExentoITBM" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());

			Calcular_Precio_Banner(oId);			

		});
		
		$("#txtNotaCotizacion" + oId).change(function(){

			$("#hdnDescripcionBanner" + oId).val($("#txtDescripcionBanner" + oId).val());
			$("#hdnMaterialBanner" + oId).val($("#lstMaterialBanner" + oId).val());		
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());			
			$("#hdnFormaPago" + oId).val($("#lstFormaPago" + oId).val());
			$("#hdnCalidadBanner" + oId).val($("#lstCalidadBanner" + oId).val());
			$("#hdnPrecioInstalacion" + oId).val($("#txtPrecioInstalacion" + oId).val());
			$("#hdnPrecioRecorte" + oId).val($("#txtPrecioRecorte" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnPrecioRotulado" + oId).val($("#txtPrecioRotulado" + oId).val());
			$("#hdnPrecioBasta" + oId).val($("#txtPrecioBasta" + oId).val());
			$("#hdnPrecioOjete" + oId).val($("#txtPrecioOjete" + oId).val());
			$("#hdnPrecioBulcaniza" + oId).val($("#txtPrecioBulcaniza" + oId).val());
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());

			Calcular_Precio_Banner(oId);			

		});
	}
	else if(Libreta == "timpart")
	{

		var Id = $("#hdnIdCampos_" + oId).val();
	
		var DescripcionImpresion = $("#hdnDescripcionImpresion" + oId).val();
		if (DescripcionImpresion == undefined)
		DescripcionImpresion = "";			
		
		var MaterialImpresion = $("#hdnMaterialImpresion" + oId).val();
		
		var Tamano = $("#hdnTamano" + oId).val();
		
		var ColorTinta = $("#hdnColorTinta" + oId).val();		
		
		var Recorte = $("#hdnRecorte" + oId).val();	
		if ((Recorte == undefined) | (Recorte == ""))
		Recorte = "0.00";
		
		var Plastificado = $("#hdnPlastificado" + oId).val();
		if ((Plastificado == undefined) | (Plastificado == ""))
		Plastificado = "0.00";
		
		var Caminado = $("#hdnCaminado" + oId).val();
		if ((Caminado == undefined) | (Caminado == ""))
		Caminado = "0.00";
		
		var Realce = $("#hdnRealce" + oId).val();
		if ((Realce == undefined) | (Realce == ""))
		Realce = "0.00";
		
		var Doblado = $("#hdnDoblado" + oId).val();
		if ((Doblado == undefined) | (Doblado == ""))
		Doblado = "0.00";
		
		var Repujado = $("#hdnRepujado" + oId).val();
		if ((Repujado == undefined) | (Repujado == ""))
		Repujado = "0.00";
		
		var Engrapado = $("#hdnEngrapado" + oId).val();	
		if ((Engrapado == undefined) | (Engrapado == ""))
		Engrapado = "0.00";
		
		var UV = $("#hdnUV" + oId).val();
		if ((UV == undefined) | (UV == ""))
		UV = "0.00";
		
		var CantPliego = $("#hdnCantPliego" + oId).val();
		if ((CantPliego == undefined) | (CantPliego == ""))
		CantPliego = "0";		
		
		var TipoCategoria = $("#hdnTipoCategoria" + oId).val();
		
		var OtroTamanoAncho = $("#hdnOtroTamanoAncho" + oId).val();
		var OtroTamanoLargo = $("#hdnOtroTamanoLargo" + oId).val();	
		
		if (OtroTamanoAncho == undefined)
		OtroTamanoAncho = "0.00";			
		

		if (OtroTamanoLargo == undefined)
		OtroTamanoLargo = "0.00";

		var Ancho = $("#hdnAncho" + oId).val();
		if (Ancho == undefined)
		Ancho = "0.00";			
				
		var AnchoMedida = $("#hdnAnchoMedida" + oId).val();
		
		var Largo = $("#hdnLargo" + oId).val();
		if (Largo == undefined)
		Largo = "0.00";
		
		var AreaTotal = $("#hdnAreaTotal" + oId).val();
		if ((AreaTotal == undefined) | (AreaTotal == ""))
		AreaTotal = "0.00";
		
		
		var LargoMedida = $("#hdnLargoMedida" + oId).val();
		
		var PrecioArte = $("#hdnPrecioArte" + oId).val();
		if ((PrecioArte == undefined) | (PrecioArte == ""))
		PrecioArte = "0.00";

		var AjustarTamano = $("#hdnAjustarTamano" + oId).val();			
	
		//$("#rowDetalle_" + oId).remove();										
		var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
		var strHtml1 = '<td colspan="6"><table width="100%">';
			strHtml1 += '<tr>';
		var strHtml2 = '<td width="15%">' + '<input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
		var strHtml3 = '<td width="15%">' + '<input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="'+ DescTipoEmpaque +'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value="'+ TipoEmpaque +'"  /></td>';	
		var strHtml4 = '<td width="32%">';		
			strHtml4 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto[]" style="width:85%;" class="validate[required]" value="'+DescProducto+'"/>';			
			strHtml4 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value="'+Producto+'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+DescProducto+'"  />';
			strHtml4 += '<input type="hidden" id="hidIdImprenta' + oId + '" name="hidIdImprenta[]" value="'+IdImprenta+'"  />';
			strHtml4 += '<input type="hidden" id="hidIdBanner' + oId + '" name="hidIdBanner[]" value="'+IdBanner+'"  />';		
			strHtml4 += '<input type="hidden" id="hidIdImpresion' + oId + '" name="hidIdImpresion[]" value="'+IdImpresion+'"  /></td>';
		var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="' + Precio + '" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value="' + Precio + '"  /></td>';
		var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="' + Total + '" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value="' + Total + '"  /></td>';

		var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';	
			strHtml7 += '<input type="hidden" id="hdnDescripcionImprenta' + oId +'" name="hdnDescripcionImprenta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnResmaTamano' + oId +'" name="hdnResmaTamano[]" value="" />';				
			strHtml7 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="' + Tamano + '" />';			
			strHtml7 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="'+ ColorTinta +'" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoAncho' + oId +'" name="hdnOtroTamanoAncho[]" value="' + OtroTamanoAncho + '" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoLargo' + oId +'" name="hdnOtroTamanoLargo[]" value="' + OtroTamanoLargo + '" />';
			strHtml7 += '<input type="hidden" id="hdnSinNumeracion' + oId + '" name="hdnSinNumeracion[]" value=""  />';			
			strHtml7 += '<input type="hidden" id="hdnNumeracionInicio' + oId +'" name="hdnNumeracionInicio[]" value=""" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionFinal' + oId +'" name="hdnNumeracionFinal[]" value="" />';			
			
			var c = 0;
			
			while (c <= 3)
			{
				if (c == 0)
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="" />';					
				else
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="" />';
				
				c = c + 1;
			}
			
			strHtml7 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="'+ TipoCategoria +'" />';
			strHtml7 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]" value=""  />';	
			strHtml7 += '<input type="hidden" id="hdnArte' + oId + '" name="hdnArte[]" value=""  />';	
			strHtml7 += '<input type="hidden" id="hdnPlaca' + oId + '" name="hdnPlaca[]" value=""  />';				


			strHtml7 += '<input type="hidden" id="hdnDescripcionBanner' + oId +'" name="hdnDescripcionBanner[]" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialBanner' + oId +'" name="hdnMaterialBanner[]" />';			
			strHtml7 += '<input type="hidden" id="hdnAncho' + oId +'" name="hdnAncho[]" value="'+ Ancho +'" />';
			strHtml7 += '<input type="hidden" id="hdnAnchoMedida' + oId +'" name="hdnAnchoMedida[]" value="'+ AnchoMedida +'" />';
			strHtml7 += '<input type="hidden" id="hdnLargo' + oId +'" name="hdnLargo[]" value="'+ Largo +'" />';				
			strHtml7 += '<input type="hidden" id="hdnLargoMedida' + oId +'" name="hdnLargoMedida[]" value="'+ LargoMedida +'" />';
			strHtml7 += '<input type="hidden" id="hdnAreaTotal' + oId +'" name="hdnAreaTotal[]" value="'+ AreaTotal +'" />';
			strHtml7 += '<input type="hidden" id="hdnFormaPago' + oId +'" name="hdnFormaPago[]" />';
			strHtml7 += '<input type="hidden" id="hdnCalidadBanner' + oId +'" name="hdnCalidadBanner[]" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioInstalacion' + oId +'" name="hdnPrecioInstalacion[]" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRecorte' + oId +'" name="hdnPrecioRecorte[]" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioArte' + oId +'" name="hdnPrecioArte[]" value="' + PrecioArte + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRotulado' + oId +'" name="hdnPrecioRotulado[]" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBasta' + oId +'" name="hdnPrecioBasta[]" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioOjete' + oId +'" name="hdnPrecioOjete[]" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBulcaniza' + oId +'" name="hdnPrecioBulcaniza[]"  />';
			strHtml7 += '<input type="hidden" id="hdnNotaCotizacion' + oId + '" name="hdnNotaCotizacion[]" value="' + NotaCotizacion + '"  />';	
			strHtml7 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]"  />';
			strHtml7 += '<input type="hidden" id="hdnDescripcionImpresion' + oId +'" name="hdnDescripcionImpresion[]" value="' + DescripcionImpresion + '" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialImpresion' + oId +'" name="hdnMaterialImpresion[]" value="' + MaterialImpresion + '" />';
			strHtml7 += '<input type="hidden" id="hdnRecorte' + oId +'" name="hdnRecorte[]" value="' + Recorte + '" />';
			strHtml7 += '<input type="hidden" id="hdnPlastificado' + oId +'" name="hdnPlastificado[]" value="' + Plastificado + '" />';
			strHtml7 += '<input type="hidden" id="hdnCaminado' + oId +'" name="hdnCaminado[]" value="' + Caminado + '" />';
			strHtml7 += '<input type="hidden" id="hdnRealce' + oId +'" name="hdnRealce[]" value="' + Realce + '" />';
			strHtml7 += '<input type="hidden" id="hdnDoblado' + oId +'" name="hdnDoblado[]" value="' + Doblado + '" />';
			strHtml7 += '<input type="hidden" id="hdnRepujado' + oId +'" name="hdnRepujado[]" value="' + Repujado + '" />';
			strHtml7 += '<input type="hidden" id="hdnEngrapado' + oId +'" name="hdnEngrapado[]" value="' + Engrapado + '" />';
			strHtml7 += '<input type="hidden" id="hdnUV' + oId +'" name="hdnUV[]" value="' + UV + '" />';
			strHtml7 += '<input type="hidden" id="hdnCantPliego' + oId +'" name="hdnCantPliego[]" value="' + CantPliego + '" />';
			strHtml7 += '<input type="hidden" id="hdnAjustarTamano' + oId +'" name="hdnAjustarTamano[]" value="' + AjustarTamano + '" />';			
			strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
		var strHtml8 = '<tr><td colspan="6"><table width="100%">';		
			strHtml8 += '<tr><td>Descripci&oacute;n de Impresi&oacute;n:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtDescripcionImpresion' + oId + '" name="txtDescripcionImpresion[]" value=""  class="validate[required]"  style="width:50%;"/>';
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td colspan="2">Dimensi&oacute;n del Arte:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += 'Ancho:&nbsp;&nbsp;&nbsp;<input type="text" id="txtAncho' + oId + '" name="txtAncho[]" value="'+ Ancho +'"  class="validate[required]"  style="width:5%; text-align:right;"/>&nbsp;&nbsp;';
			strHtml8 += '<select name="lstAnchoMedida[]" id="lstAnchoMedida' + oId + '" class="validate[required]" >&nbsp;&nbsp;';
			strHtml8 += '<option value="" title="Seleccione la Unidad de Medida">Seleccione</option>';	
			strHtml8 += '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';			
			strHtml8 += 'Alto:&nbsp;&nbsp;&nbsp;<input type="text" id="txtLargo' + oId + '" name="txtLargo[]" value="'+ Largo +'"  class="validate[required]"  style="width:5%; text-align:right;"  />&nbsp;&nbsp;';			
			strHtml8 += '<select name="lstLargoMedida[]" id="lstLargoMedida' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="" title="Seleccione la Unidad de Medida">Seleccione</option>';	
			strHtml8 += '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<span id="lblAreaTotal' + oId + '">' + AreaTotal + '</span>&nbsp;&nbsp;pulgada&sup2;<n>';
			strHtml8 += '&nbsp;&nbsp;<input type="checkbox" id="chkAjustarTamano' + oId + '" name="chkAjustarTamano[]" value="1"  class=""  style="width:5%;"/>Ajustar';
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td>Dimensi&oacute;n del Papel:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstTamano[]" id="lstTamano' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="">Seleccione el Tama&ntilde;o del Papel</option>';				
			strHtml8 += '</select></td>';
			strHtml8 += '<td>Color de Tinta:&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstColorTinta[]" id="lstColorTinta' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="">Seleccione el Color de Tinta</option>';		
			strHtml8 += '</select></td></tr>';				
			strHtml8 += '<tr id="otrotamano' + oId + '"></tr>';
			strHtml8 += '<tr><td>Material de la Impresi&oacute;n:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstMaterialImpresion[]" id="lstMaterialImpresion' + oId + '" class="validate[required]" >';
			strHtml8 += '<option value="">Seleccione la Material del Impresi&oacute;n</option>';	
			strHtml8 += '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '</td>';			
			strHtml8 += '<td>Arte:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="text" id="txtPrecioArte' + oId + '" name="txtPrecioArte[]" value="' + PrecioArte + '"  class="validate[required]"  style="width:10%; text-align:right;" onchange="PrecioMoneda(\'txtPrecioArte' + oId + '\');"/>';
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td>Cantidad de Pliegos a Usar:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<span id="lblCantPliego' + oId + '">' + CantPliego + '</span>&nbsp;&nbsp;Pliegos<n>';				
			strHtml8 += '</td></tr>';				
			strHtml8 += '<tr><td>Acabado:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '</td></tr>';			
			strHtml8 += '<tr><td>Recorte:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txtRecorte' + oId + '" name="txtRecorte[]" value="' + Recorte + '"  class=""  style="width:10%; text-align:right;"/></td>';		
			strHtml8 += '<td>Plastificado:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txtPlastificado' + oId + '" name="txtPlastificado[]" value="' + Plastificado + '"  class=""  style="width:10%; text-align:right;"/>';			
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td>Caminado:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txtCaminado' + oId + '" name="txtCaminado[]" value="' + Caminado + '"  class=""  style="width:10%; text-align:right;"/></td>';
			strHtml8 += '<td>Realce:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txtRealce' + oId + '" name="txtRealce[]" value="' + Realce + '"  class=""  style="width:10%; text-align:right;"/>';			
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td>Doblado:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txtDoblado' + oId + '" name="txtDoblado[]" value="' + Doblado + '"  class=""  style="width:10%; text-align:right;"/></td>';
			strHtml8 += '<td>Repujado:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txtRepujado' + oId + '" name="txtRepujado[]" value="' + Repujado + '"  class=""  style="width:10%; text-align:right;"/>';			
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td>Engrapado:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txtEngrapado' + oId + '" name="txtEngrapado[]" value="' + Engrapado + '"  class=""  style="width:10%; text-align:right;"/></td>';
			strHtml8 += '<td>UV:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txtUV' + oId + '" name="txtUV[]" value="' + UV + '"  class=""  style="width:10%; text-align:right;"/>';			
			strHtml8 += '</td></tr>';
			strHtml8 += '<tr><td>Categor&iacute;a:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<select name="lstTipoCategoria[]" id="lstTipoCategoria' + oId + '" class="">';
			strHtml8 += '<option value="0">Seleccione el Tipo de Categor&iacute;a</option>';		
			strHtml8 += '</select></td>';			
			strHtml8 += '<td>Exento de ITBMS:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<input type="checkbox" id="chkExentoITBM' + oId + '" name="chkExentoITBM[]" value="1"  class=""  style="width:5%;"/>';
			strHtml8 += '</td></tr>';			
			strHtml8 += '<tr valign="middle" ><td colspan="2">Nota:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			strHtml8 += '<textarea rows="4" cols="" name="txtNotaCotizacion[]"  id="txtNotaCotizacion' + oId + '" class="autoGrow lim" placeholder="'+ ((NotaCotizacion=="")?'Escribir Observaciones':'') + '" style="width:50%">'+ ((NotaCotizacion=="")?'':NotaCotizacion) +'</textarea>';
			strHtml8 += '</td></tr>';				
				
			
			strHtml8 += '</table></td></tr><tr><td colspan="6"><a href="javascript:void(0)" onclick="Ocultar_Detalles(' + oId +',\''+Libreta+'\')" >Ocultar detalle</a></td></tr>';				
		var strHtml9 = '</tr>';
			strHtml9 += '</table></td>';	
		var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;		
	
		$("#rowDetalle_" + oId).html(strHtmlFinal);	

		$.post("library/funciones.php?action=Verificar_Administrador",
		function(data){

			if (data == "true")
			{
				$("#txtPrecio"+oId).attr("readonly",false);
				$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
				$("#txtPrecio" + oId).keydown(function(event){
				//alert(event.keyCode);
					if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
						return false;
					}
				});
						
				$("#txtPrecio" + oId).change(function(){

					$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
					$("#txtPrecio"+oId).attr("title","Precio Especial");
					$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

					$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
					$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
					$("#hidTotal" + oId).val($("#txtTotal" + oId).val());

					Calcular_Total_Cotizacion ();
				});
			}
			else
			{
				$("#txtPrecio"+oId).attr("readonly",true);
			}
		});
		
		if (AjustarTamano == 1)
		$("#chkAjustarTamano"+oId).attr("checked",true);
		else
		$("#chkAjustarTamano"+oId).attr("checked",false);		
		
		
		if (Tamano != undefined)
		{
			GenerarTamanoPliego(oId,Tamano);
		
			if (MaterialImpresion != undefined)
			{		
				GenerarMaterialImpresion(oId,Tamano,MaterialImpresion);			
			}
			else
			{
				GenerarMaterialImpresion(oId,Tamano);			
			}
		}
		else
		{
			GenerarTamanoPliego(oId);		
		}

		if (AnchoMedida != undefined)
		GenerarUnidadMedida(oId,"a",AnchoMedida,1);
		else
		GenerarUnidadMedida(oId,"a");
		
		if (LargoMedida != undefined)
		GenerarUnidadMedida(oId,"l",LargoMedida,1);
		else
		GenerarUnidadMedida(oId,"l");
				
		if (ColorTinta != undefined)
		{		
			GenerarColorTintaImpresion(oId,ColorTinta);
		}
		else
		{
			GenerarColorTintaImpresion(oId);		
		}		
		
		if (TipoCategoria != undefined)
		{		
			GenerarCategoriaVolumenImpresion(oId,TipoCategoria);
		}
		else
		{
			GenerarCategoriaVolumenImpresion(oId);		
		}		
		
		$("#txtDescripcionImpresion" + oId).val(DescripcionImpresion);
		$("#txtPrecioArte" + oId).val(PrecioArte);

		
		if (Recorte == 1)
		$("#txtRecorte"+oId).attr("checked",true);
		else
		$("#txtRecorte"+oId).attr("checked",false);	
		
		if (Plastificado == 1)
		$("#txtPlastificado"+oId).attr("checked",true);
		else
		$("#txtPlastificado"+oId).attr("checked",false);

		if (Caminado == 1)
		$("#txtCaminado"+oId).attr("checked",true);
		else
		$("#txtCaminado"+oId).attr("checked",false);	
		
		if (Realce == 1)
		$("#txtRealce"+oId).attr("checked",true);
		else
		$("#txtRealce"+oId).attr("checked",false);	

		if (Doblado == 1)
		$("#txtDoblado"+oId).attr("checked",true);
		else
		$("#txtDoblado"+oId).attr("checked",false);	
		
		if (Repujado == 1)
		$("#txtRepujado"+oId).attr("checked",true);
		else
		$("#txtRepujado"+oId).attr("checked",false);

		if (Engrapado == 1)
		$("#txtEngrapado"+oId).attr("checked",true);
		else
		$("#txtEngrapado"+oId).attr("checked",false);

		if (UV == 1)
		$("#txtUV"+oId).attr("checked",true);
		else
		$("#txtUV"+oId).attr("checked",false);		
		
		if (ExentoITBM == 1)
		$("#chkExentoITBM"+oId).attr("checked",true);
		else
		$("#chkExentoITBM"+oId).attr("checked",false);
		
		$("#txtCantidad" + oId).keydown(function(event){
			if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});

		if(Cantidad!=undefined)
		{
			$("#txtCantidad" + oId).val(Cantidad);
			$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());		
		}

		
		$("#txtCantidad" + oId).change(function(){

			
			if ($("#txtCantidad" + oId).val() > 0)
			{
				$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
				$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
				$("#hidTotal" + oId).val($("#txtTotal" + oId).val());			
			}
			else if($("#txtCantidad" + oId).val() == 0)
			{
				alert("La cantidad de Trabajo de Impresión de Arte debe ser mayor que 0.")
				$("#txtCantidad" + oId).val('0');			
			}	
		
			Calcular_Precio_Impresion(oId);
			Calcular_Total_Cotizacion ();				
		});		
		
		$("#txtProducto" + oId).autocomplete({
			source: "application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar",
			select:  function(event, ui) {
				
				$("#hidDescProducto" + oId).val(ui.item.value);
				$("#hidIdProducto" + oId).val(ui.item.id_producto);
				$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
				$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
				$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));

				Generar_Descripcion_Producto(oId);				
				
				$("#txtCantidad" + oId).change(function(){
		
					if($("#txtCantidad" + oId).val() == 0)
					{
						alert("La cantidad de Trabajo de Impresión de Arte debe ser mayor que 0.")
						$("#txtCantidad" + oId).val('0');			
					}				
					else
					{		
						$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
						$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
						Calcular_Total_Cotizacion(); 
					}
				});	
				
				$.post("library/funciones.php?action=Verificar_Administrador",
	 			function(data){

					if (data == "true")
					{
						$("#txtPrecio"+oId).attr("readonly",false);
						$("#txtPrecio"+oId).attr("title","Precio Sugerido");

						$("#txtPrecio" + oId).keydown(function(event){
						//alert(event.keyCode);
							if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
								return true;
							}
							else
							{
								return false;
							}
						});							
						
						$("#txtPrecio" + oId).change(function(){
							$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
							$("#txtPrecio"+oId).attr("title","Precio Especial");
							$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

							$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
							Calcular_Total_Cotizacion ();
						});
					}
					else
					{
						$("#txtPrecio"+oId).attr("readonly",true);
					}
				});						
				
				Calcular_Total_Cotizacion ();			
			},
			change: function (event, ui) {
			
				if (ui.item === null)
				{	
					$("#txtProducto"+oId).val("");
					$("#hidDescProducto" + oId).val("");
					$("#hidIdProducto" + oId).val("");
					$("#txtTipoEmpaque" + oId).val("");
					$("#hidTipoEmpaque" + oId).val("");
					$("#txtPrecio" + oId).val("0.00");
					$("#hidPrecio" + oId).val("0.00");
					$("#txtTotal" + oId).val("0.00");
					$("#hidTotal" + oId).val("0.00");
		
				}
				else
				{
					
					$("#hidDescProducto" + oId).val(ui.item.value);
					$("#hidIdProducto" + oId).val(ui.item.id_producto);
					$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
					$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
					$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
					$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));

					Generar_Descripcion_Producto(oId);				
					
					$("#txtCantidad" + oId).change(function(){
			
						if($("#txtCantidad" + oId).val() == 0)
						{
							alert("La cantidad de Trabajo de Impresión de Arte debe ser mayor que 0.")
							$("#txtCantidad" + oId).val('0');			
						}					
						else
						{		
							$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());

							Calcular_Total_Cotizacion(); 
						}
					});	
					
					$.post("library/funciones.php?action=Verificar_Administrador",
					function(data){

						if (data == "true")
						{
							$("#txtPrecio"+oId).attr("readonly",false);
							$("#txtPrecio"+oId).attr("title","Precio Sugerido");

							$("#txtPrecio" + oId).keydown(function(event){
							//alert(event.keyCode);
								if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
									return true;
								}
								else
								{
									return false;
								}
							});							
							
							$("#txtPrecio" + oId).change(function(){
								$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
								$("#txtPrecio"+oId).attr("title","Precio Especial");
								$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

								$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
								$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
								$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
								Calcular_Total_Cotizacion ();
							});
						}
						else
						{
							$("#txtPrecio"+oId).attr("readonly",true);
						}
					});						
					
					Calcular_Total_Cotizacion ();
				}				
			}
	
		});			
		
		$("#txtDescripcionImpresion" + oId).change(function(){

			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		});		
		$("#txtAncho" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});			
			
		$("#txtAncho" + oId).change(function(){

			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");

			Calcular_Precio_Impresion(oId);			
		});	

		$("#lstAnchoMedida" + oId).change(function(){

			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");

			Calcular_Precio_Impresion(oId);

		});			

		$("#txtLargo" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});			
			
		$("#txtLargo" + oId).change(function(){

	
			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");

			Calcular_Precio_Impresion(oId);			
		});	

		$("#lstLargoMedida" + oId).change(function(){

			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);

		});	

		$("#chkAjustarTamano" + oId).change(function(){

			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());			
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			

		});
		
		$("#lstMaterialImpresion" + oId).change(function(){

			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());			
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);
			
		});
		
		$("#lstColorTinta" + oId).change(function(){

			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());			
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);
			
		});		
		
		$("#lstTamano" + oId).change(function(){		
			
			GenerarMaterialImpresion(oId,$("#lstTamano" + oId).val(),$("#lstMaterialImpresion" + oId).val());			
			
			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			if ($("#lstTamano" + oId).val() == "o")
			{
				var strHtmlOtroTamano = '<tr><td>';
				strHtmlOtroTamano += '&nbsp;&nbsp;Ancho:<input type="text" id="txtOtroTamanoAncho' + oId + '" name="txtOtroTamanoAncho[]" value=""  class="validate[required]"  style="width:25%;"/><input type="hidden" id="hdnOtroTamanoAncho' + oId + '" name="hdnOtroTamanoAncho[]" value=""  />';
				strHtmlOtroTamano += '&nbsp;&nbsp;&nbsp;&nbsp;Largo:<input type="text" id="txtOtroTamanoLargo' + oId + '" name="txtOtroTamanoLargo[]" value=""  class="validate[required]"  style="width:25%;"/><input type="hidden" id="hdnOtroTamanoLargo' + oId + '" name="hdnOtroTamanoLargo[]" value=""  />';
				strHtmlOtroTamano += '</td><td>&nbsp;</td></tr>';
				
				$("#otrotamano" + oId).html(strHtmlOtroTamano);
				
				$("#txtOtroTamanoAncho" + oId).keydown(function(event){
					if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
					return false;
					}
				});	

				$("#txtOtroTamanoLargo" + oId).keydown(function(event){
					if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
						return false;
					}
				});
			}
			else
			{
				$("#otrotamano" + oId).empty();
			}				
			
			$("#txtOtroTamanoAncho" + oId).change(function(){
		
				$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
				$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
				$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
				$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
				$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
				$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
				$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
				$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
				$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
				$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
				$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
				$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
				$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
				$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
				$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
				$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
				$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
				$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
				$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
				$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			
				Verificar_Otro_Tamano(oId);

				$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
				$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());			
			
				$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
				$("#txtPrecio"+oId).attr("title","Precio Sugerido");
				
				Calcular_Precio_Impresion(oId);		
			});

			$("#txtOtroTamanoLargo" + oId).change(function(){
		
				$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
				$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
				$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
				$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
				$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
				$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
				$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
				$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
				$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
				$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
				$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
				$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
				$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
				$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
				$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
				$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
				$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
				$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
				$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
				$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			
				Verificar_Otro_Tamano(oId);

				$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
				$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());				
			
				$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
				$("#txtPrecio"+oId).attr("title","Precio Sugerido");

		
				Calcular_Precio_Impresion(oId);		
			});
			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		
		});	

		$("#txtPrecioArte" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});
		
		$("#txtPrecioArte" + oId).change(function(){		
			
			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		
		});			

		$("#txtRecorte" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});
		
		$("#txtRecorte" + oId).change(function(){		
			
			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		
		});
		
		$("#txtPlastificado" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});
		
		$("#txtPlastificado" + oId).change(function(){		
			
			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		
		});

		$("#txtCaminado" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});
		
		$("#txtCaminado" + oId).change(function(){		
			
			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		
		});

		$("#txtRealce" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});
		
		$("#txtRealce" + oId).change(function(){		
			
			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		
		});

		$("#txtDoblado" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});
		
		$("#txtDoblado" + oId).change(function(){		
			
			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		
		});

		$("#txtRepujado" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});
		
		$("#txtRepujado" + oId).change(function(){		
			
			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		
		});


		$("#txtEngrapado" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});
		
		$("#txtEngrapado" + oId).change(function(){		
			
			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		
		});		

		$("#txtUV" + oId).keydown(function(event){
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});
		
		$("#txtUV" + oId).change(function(){		
			
			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnColorPapel" + oId).val($("#lstColorPapel" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		
		});
		
		$("#chkExentoITBM" + oId).change(function(){

			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			

		});
		
		$("#lstTipoCategoria" + oId).change(function(){

			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		});		
		
		$("#txtNotaCotizacion" + oId).change(function(){

			$("#hdnDescripcionImpresion" + oId).val($("#txtDescripcionImpresion" + oId).val());			
			$("#hdnAncho" + oId).val($("#txtAncho" + oId).val());				
			$("#hdnAnchoMedida" + oId).val($("#lstAnchoMedida" + oId).val());
			$("#hdnLargo" + oId).val($("#txtLargo" + oId).val());
			$("#hdnLargoMedida" + oId).val($("#lstLargoMedida" + oId).val());	
			$("#hdnAjustarTamano" + oId).val($("#chkAjustarTamano" + oId + ":checked").val());				
			$("#hdnMaterialImpresion" + oId).val($("#lstMaterialImpresion" + oId).val());
			$("#hdnTamano" + oId).val($("#lstTamano" + oId).val());
			$("#hdnColorTinta" + oId).val($("#lstColorTinta" + oId).val());
			$("#hdnPrecioArte" + oId).val($("#txtPrecioArte" + oId).val());	
			$("#hdnNotaCotizacion" + oId).val($("#txtNotaCotizacion" + oId).val());	
			$("#hdnRecorte" + oId).val($("#txtRecorte" + oId).val());
			$("#hdnPlastificado" + oId).val($("#txtPlastificado" + oId).val());
			$("#hdnCaminado" + oId).val($("#txtCaminado" + oId).val());
			$("#hdnRealce" + oId).val($("#txtRealce" + oId).val());
			$("#hdnDoblado" + oId).val($("#txtDoblado" + oId).val());
			$("#hdnRepujado" + oId).val($("#txtRepujado" + oId).val());
			$("#hdnEngrapado" + oId).val($("#txtEngrapado" + oId).val());
			$("#hdnUV" + oId).val($("#txtUV" + oId).val());				
			$("#hdnExentoITBM" + oId).val($("#chkExentoITBM" + oId + ":checked").val());
			$("#hdnOtroTamanoAncho" + oId).val($("#txtOtroTamanoAncho" + oId).val());
			$("#hdnOtroTamanoLargo" + oId).val($("#txtOtroTamanoLargo" + oId).val());
			$("#hdnTipoCategoria" + oId).val($("#lstTipoCategoria" + oId).val());			
			$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
			Calcular_Precio_Impresion(oId);			
		});
	}
	
	
}


function Ocultar_Detalles(oId,Libreta)
{

	$.getScript("public/js/form_validation.js");		
	
	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);	
	
	var Cantidad = $("#hidCantidad" + oId).val();
	var TipoEmpaque = $("#hidTipoEmpaque" + oId).val();
	var DescTipoEmpaque = $("#txtTipoEmpaque" + oId).val();	
	
	var Precio = $("#hidPrecio" + oId).val();
	var Total = $("#hidTotal" + oId).val();
	var Producto = $("#hidIdProducto" + oId).val();
	
	if (Producto == undefined)
	Producto = "";
	
	var IdImprenta = $("#hidIdImprenta" + oId).val();
	
	if (IdImprenta == undefined)
	IdImprenta = "";
	
	var IdBanner = $("#hidIdBanner" + oId).val();

	if (IdBanner == undefined)
	IdBanner = "";
	
	var IdImpresion = $("#hidIdImpresion" + oId).val();
	
	if (IdImpresion == undefined)
	IdImpresion = "";	
	
	var DescProducto = $("#txtProducto" + oId).val();
	
	var NotaCotizacion = $("#txtNotaCotizacion" + oId).val();
	var ExentoITBM = $("#chkExentoITBM" + oId + ":checked").val();	

	if(Libreta == "timp")
	{					
		var Id = $("#hdnIdCampos_" + oId).val();		
		
		var DescripcionImprenta = $("#txtDescripcionImprenta" + oId).val();		
		var PapelTipo = $("#lstPapelTipo" + oId).val();
		var MaterialPapelTipo = $("#lstMaterialPapelTipo" + oId).val();
		var ResmaTamano = $("#lstResmaTamano" + oId).val();	
		var Tamano = $("#lstTamano" + oId).val();
		var CantidadCopia = $("#lstCantidadCopia" + oId).val();
		var ColorTinta = $("#lstColorTinta" + oId).val();

		var OtroTamanoAncho = $("#txtOtroTamanoAncho" + oId).val();
		var OtroTamanoLargo = $("#txtOtroTamanoLargo" + oId).val();

		var NumeracionInicio = $("#txtNumeracionInicio" + oId).val();
		var NumeracionFinal = $("#txtNumeracionFinal" + oId).val();	
	
		var ColorPapel = new Array();
			ColorPapel[0] = $("#lstColorPapel" + oId).val();
			ColorPapel[1] = $("#lstColorPapel1" + oId).val();
			ColorPapel[2] = $("#lstColorPapel2" + oId).val();
			ColorPapel[3] = $("#lstColorPapel3" + oId).val();
	
		var TipoForro = $("#lstTipoForro" + oId).val();	
		var Tiempo = $("#txtTiempo" + oId).val();
	
		var TipoTiempo = $("input[name='rdbTiempo" + oId + "']:checked").val();
	
		var TipoCategoria = $("#lstTipoCategoria" + oId).val();	

		var Arte = $("#chkArte" + oId + ":checked").val();
		var Placa = $("#chkPlaca" + oId + ":checked").val();			

		
		var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
		var strHtml1 = '<td colspan="6"><table width="100%">';
			strHtml1 += '<tr>';
		var strHtml2 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
		var strHtml3 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="'+ DescTipoEmpaque +'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value="'+ TipoEmpaque +'"  /></td>';	
		var strHtml4 = '<td width="32%">';
			strHtml4 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto[]" style="width:85%;" class="validate[required]" value="'+DescProducto+'"/>';	
			strHtml4 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value="'+Producto+'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+DescProducto+'"  />';
			strHtml4 += '<input type="hidden" id="hidIdImprenta' + oId + '" name="hidIdImprenta[]" value="'+IdImprenta+'"  />';
			strHtml4 += '<input type="hidden" id="hidIdBanner' + oId + '" name="hidIdBanner[]" value="'+IdBanner+'"  />';		
			strHtml4 += '<input type="hidden" id="hidIdImpresion' + oId + '" name="hidIdImpresion[]" value="'+IdImpresion+'"  /></td>';
		var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="' + Precio + '" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value="' + Precio + '"  /></td>';
		var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="' + Total + '" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value="' + Total + '"  /></td>';

		var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
			strHtml7 += '<input type="hidden" id="hdnDescripcionImprenta' + oId +'" name="hdnDescripcionImprenta[]" value="' + DescripcionImprenta + '" />';			
			strHtml7 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="' + PapelTipo + '" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="' + MaterialPapelTipo + '" />';
			strHtml7 += '<input type="hidden" id="hdnResmaTamano' + oId +'" name="hdnResmaTamano[]" value="' + ResmaTamano + '" />';			
			strHtml7 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="' + Tamano + '" />';			
			strHtml7 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="' + CantidadCopia + '" />';
			strHtml7 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="' + ColorTinta + '" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoAncho' + oId +'" name="hdnOtroTamanoAncho[]" value="' + OtroTamanoAncho + '" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoLargo' + oId +'" name="hdnOtroTamanoLargo[]" value="' + OtroTamanoLargo + '" />';
			strHtml7 += '<input type="hidden" id="hdnSinNumeracion' + oId + '" name="hdnSinNumeracion[]" value="' + SinNumeracion + '"  />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionInicio' + oId +'" name="hdnNumeracionInicio[]" value="' + NumeracionInicio + '" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionFinal' + oId +'" name="hdnNumeracionFinal[]" value="' + NumeracionFinal + '" />';			
			
			var c = 0;
			
			while (c <= 3)
			{
				if (c == 0)
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="' + ColorPapel[c] + '" />';					
				else
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="' + ColorPapel[c] + '" />';
				
				c = c + 1;
			}
			
			strHtml7 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="' + TipoForro + '" />';			
			strHtml7 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="' + Tiempo + '" />';
			strHtml7 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="' + TipoTiempo + '" />';			
			strHtml7 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="' + TipoCategoria + '" />';

			strHtml7 += '<input type="hidden" id="hdnArte' + oId + '" name="hdnArte[]" value="' + Arte + '"  />';	
			strHtml7 += '<input type="hidden" id="hdnPlaca' + oId + '" name="hdnPlaca[]" value="' + Placa + '"  />';

			strHtml7 += '<input type="hidden" id="hdnDescripcionBanner' + oId +'" name="hdnDescripcionBanner[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialBanner' + oId +'" name="hdnMaterialBanner[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnAncho' + oId +'" name="hdnAncho[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnAnchoMedida' + oId +'" name="hdnAnchoMedida[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnLargo' + oId +'" name="hdnLargo[]"value="" />';				
			strHtml7 += '<input type="hidden" id="hdnLargoMedida' + oId +'" name="hdnLargoMedida[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnAreaTotal' + oId +'" name="hdnAreaTotal[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnFormaPago' + oId +'" name="hdnFormaPago[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnCalidadBanner' + oId +'" name="hdnCalidadBanner[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioInstalacion' + oId +'" name="hdnPrecioInstalacion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRecorte' + oId +'" name="hdnPrecioRecorte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioArte' + oId +'" name="hdnPrecioArte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRotulado' + oId +'" name="hdnPrecioRotulado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBasta' + oId +'" name="hdnPrecioBasta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioOjete' + oId +'" name="hdnPrecioOjete[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBulcaniza' + oId +'" name="hdnPrecioBulcaniza[]" value="" />';
			
			strHtml7 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]" value="' + ExentoITBM + '"  />';			
			strHtml7 += '<input type="hidden" id="hdnNotaCotizacion' + oId + '" name="hdnNotaCotizacion[]" value="' + NotaCotizacion + '"  />';
			strHtml7 += '<input type="hidden" id="hdnDescripcionImpresion' + oId +'" name="hdnDescripcionImpresion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialImpresion' + oId +'" name="hdnMaterialImpresion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnRecorte' + oId +'" name="hdnRecorte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPlastificado' + oId +'" name="hdnPlastificado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnCaminado' + oId +'" name="hdnCaminado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnRealce' + oId +'" name="hdnRealce[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnDoblado' + oId +'" name="hdnDoblado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnRepujado' + oId +'" name="hdnRepujado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnEngrapado' + oId +'" name="hdnEngrapado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnUV' + oId +'" name="hdnUV[]" value="" />';	
			strHtml7 += '<input type="hidden" id="hdnCantPliego' + oId +'" name="hdnCantPliego[]" value="" />'; 
			strHtml7 += '<input type="hidden" id="hdnAjustarTamano' + oId +'" name="hdnAjustarTamano[]" value="" />';				
			strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
		var strHtml8 = '<tr><td colspan="6"><a href="javascript:void(0)" onclick="Mostrar_Detalles(' + oId +',\''+Libreta+'\')" >Ver detalle</a></td></tr>';				
		var strHtml9 = '</tr>';
		strHtml9 += '</table></td>';	
		var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;		
	
		$("#rowDetalle_" + oId).html(strHtmlFinal);

		$.post("library/funciones.php?action=Verificar_Administrador",
		function(data){

			if (data == "true")
			{
				$("#txtPrecio"+oId).attr("readonly",false);
				$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
				$("#txtPrecio" + oId).keydown(function(event){

					if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
						return false;
					}
				});
						
				$("#txtPrecio" + oId).change(function(){

					$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
					$("#txtPrecio"+oId).attr("title","Precio Especial");
					$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

					$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
					$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
					$("#hidTotal" + oId).val($("#txtTotal" + oId).val());

					Calcular_Total_Cotizacion ();
				});
			}
			else
			{
				$("#txtPrecio"+oId).attr("readonly",true);
			}
		});		
			

		$("#txtProducto" + oId).autocomplete({
			source: "application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar",
			select:  function(event, ui) {

				$("#hidDescProducto" + oId).val(ui.item.value);
				$("#hidIdProducto" + oId).val(ui.item.id_producto);
				$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
				$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
				$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));		

				Generar_Descripcion_Producto(oId);				
				
				$("#txtCantidad" + oId).change(function(){
		
					if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == 'timp') & ($("#txtCantidad" + oId).val() > 1))
					{
						alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
						$("#txtCantidad" + oId).val('0');			
					}
					else if ($("#txtCantidad" + oId).val() == 0)
					{
						alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
						$("#txtCantidad" + oId).val('0');			
					}					
					else
					{		
						$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
						$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
						Calcular_Total_Cotizacion 
					}
				});	

				$.post("library/funciones.php?action=Verificar_Administrador",
	 			function(data){

					if (data == "true")
					{
						$("#txtPrecio"+oId).attr("readonly",false);
						$("#txtPrecio"+oId).attr("title","Precio Sugerido");

						$("#txtPrecio" + oId).keydown(function(event){

							if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
								return true;
							}
							else
							{
								return false;
							}
						});
						
						$("#txtPrecio" + oId).change(function(){
							$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
							$("#txtPrecio"+oId).attr("title","Precio Especial");
							$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

							$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
							Calcular_Total_Cotizacion ();
						});
					}
					else
					{
						$("#txtPrecio"+oId).attr("readonly",true);
					}
				});				
				
				Calcular_Total_Cotizacion ();				
			},
			change: function (event, ui) {
			
				if (ui.item === null)
				{	
					$("#txtProducto"+oId).val("");
					$("#hidDescProducto" + oId).val("");
					$("#hidIdProducto" + oId).val("");
					$("#txtTipoEmpaque" + oId).val("");
					$("#hidTipoEmpaque" + oId).val("");
					$("#txtPrecio" + oId).val("0.00");
					$("#hidPrecio" + oId).val("0.00");
					$("#txtTotal" + oId).val("0.00");
					$("#hidTotal" + oId).val("0.00");					
				}
				else
				{
					$("#hidDescProducto" + oId).val(ui.item.value);
					$("#hidIdProducto" + oId).val(ui.item.id_producto);
					$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
					$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
					$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
					$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));		

					Generar_Descripcion_Producto(oId);				
					
					$("#txtCantidad" + oId).change(function(){
			
						if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == 'timp') & ($("#txtCantidad" + oId).val() > 1))
						{
							alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
							$("#txtCantidad" + oId).val('0');			
						}
						else if ($("#txtCantidad" + oId).val() == 0)
						{
							alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
							$("#txtCantidad" + oId).val('0');			
						}					
						else
						{		
							$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
							Calcular_Total_Cotizacion 
						}
					});	

					$.post("library/funciones.php?action=Verificar_Administrador",
					function(data){

						if (data == "true")
						{
							$("#txtPrecio"+oId).attr("readonly",false);
							$("#txtPrecio"+oId).attr("title","Precio Sugerido");

							$("#txtPrecio" + oId).keydown(function(event){

								if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
									return true;
								}
								else
								{
									return false;
								}
							});
							
							$("#txtPrecio" + oId).change(function(){
								$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
								$("#txtPrecio"+oId).attr("title","Precio Especial");
								$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

								$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
								$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
								$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
								Calcular_Total_Cotizacion ();
							});

						}
						else
						{
							$("#txtPrecio"+oId).attr("readonly",true);
						}
					});				
					
					Calcular_Total_Cotizacion ();				
				}				
			}
	
		});
			
				$.post("library/funciones.php?action=Verificar_Administrador",
	 			function(data){

					if (data == "true")
					{

						$("#txtPrecio"+oId).attr("readonly",false);
						$("#txtPrecio"+oId).attr("title","Precio Sugerido");

						$("#txtPrecio" + oId).keydown(function(event){
						//alert(event.keyCode);
							if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
								return true;
							}
							else
							{
								return false;
							}
						});
						
						$("#txtPrecio" + oId).change(function(){
							$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
							$("#txtPrecio"+oId).attr("title","Precio Especial");
							$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

							$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
							Calcular_Total_Cotizacion ();
						});

					}
					else
					{
						$("#txtPrecio"+oId).attr("readonly",true);
					}
				});	

			
		$("#txtCantidad" + oId).keydown(function(event){
			//alert(event.keyCode);
			if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});		
	
		if(Cantidad!=undefined)
		{
			$("#txtCantidad" + oId).val(Cantidad);
			$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());		
		}	
	
		$("#txtCantidad" + oId).change(function(){
		
			if (($("#txtCantidad" + oId).val()%2 == 0) & ($("#txtCantidad" + oId).val() > 1) & ($("#hidIdProducto" + oId).val() == 'timp'))
			{
				$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
				$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
				$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
			}
			else if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#txtCantidad" + oId).val() > 1)& ($("#hidIdProducto" + oId).val() == 'timp'))
			{
				alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
				$("#txtCantidad" + oId).val('0');
			}
			else if  ($("#txtCantidad" + oId).val() == 0)
			{
				alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
				$("#txtCantidad" + oId).val('0');
			}				
		});	
				
		Calcular_Precio_Imprenta(oId);		

	}
	else if(Libreta == "tbnr")
	{					
		var Id = $("#hdnIdCampos_" + oId).val();		

		var DescripcionBanner = $("#txtDescripcionBanner" + oId).val();
		var MaterialBanner = $("#lstMaterialBanner" + oId).val();		
		var Ancho = $("#txtAncho" + oId).val();
		var AnchoMedida = $("#lstAnchoMedida" + oId).val();	
		var Largo = $("#txtLargo" + oId).val();
		var LargoMedida = $("#lstLargoMedida" + oId).val();
		var AreaTotal = $("#hdnAreaTotal" + oId).val();			
		var FormaPago = $("#lstFormaPago" + oId).val();
		var CalidadBanner = $("#lstCalidadBanner" + oId).val();
		var PrecioInstalacion = $("#txtPrecioInstalacion" + oId).val();
		var PrecioRecorte = $("#txtPrecioRecorte" + oId).val();
		var PrecioArte = $("#txtPrecioArte" + oId).val();
		var PrecioRotulado = $("#txtPrecioRotulado" + oId).val();		
		var PrecioBasta = $("#txtPrecioBasta" + oId).val();
		var PrecioOjete = $("#txtPrecioOjete" + oId).val();
		var PrecioBulcaniza = $("#txtPrecioBulcaniza" + oId).val();	
									
		var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
		var strHtml1 = '<td colspan="6"><table width="100%">';
			strHtml1 += '<tr>';
		var strHtml2 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
		var strHtml3 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="'+ DescTipoEmpaque +'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value="'+ TipoEmpaque +'"  /></td>';	
		var strHtml4 = '<td width="32%">';
			strHtml4 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto[]" style="width:85%;" class="validate[required]" value="'+DescProducto+'"/>';			
			strHtml4 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value="'+Producto+'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+DescProducto+'"  />';
			strHtml4 += '<input type="hidden" id="hidIdImprenta' + oId + '" name="hidIdImprenta[]" value="'+IdImprenta+'"  />';
			strHtml4 += '<input type="hidden" id="hidIdBanner' + oId + '" name="hidIdBanner[]" value="'+IdBanner+'"  />';		
			strHtml4 += '<input type="hidden" id="hidIdImpresion' + oId + '" name="hidIdImpresion[]" value="'+IdImpresion+'"  /></td>';
		var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="' + Precio + '" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value="' + Precio + '"  /></td>';
		var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="' + Total + '" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value="' + Total + '"  /></td>';

		var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
			
			strHtml7 += '<input type="hidden" id="hdnDescripcionImprenta' + oId +'" name="hdnDescripcionImprenta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnResmaTamano' + oId +'" name="hdnResmaTamano[]" value="" />';				
			strHtml7 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoAncho' + oId +'" name="hdnOtroTamanoAncho[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoLargo' + oId +'" name="hdnOtroTamanoLargo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnSinNumeracion' + oId + '" name="hdnSinNumeracion[]" value=""  />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionInicio' + oId +'" name="hdnNumeracionInicio[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionFinal' + oId +'" name="hdnNumeracionFinal[]" value="" />';			
			
			var c = 0;
			
			while (c <= 3)
			{
				if (c == 0)
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="" />';					
				else
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="" />';
				
				c = c + 1;
			}
			
			strHtml7 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnArte' + oId + '" name="hdnArte[]" value=""  />';	
			strHtml7 += '<input type="hidden" id="hdnPlaca' + oId + '" name="hdnPlaca[]" value=""  />';		
			
			strHtml7 += '<input type="hidden" id="hdnDescripcionBanner' + oId +'" name="hdnDescripcionBanner[]" value="' + DescripcionBanner + '" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialBanner' + oId +'" name="hdnMaterialBanner[]" value="' + MaterialBanner + '" />';			
			strHtml7 += '<input type="hidden" id="hdnAncho' + oId +'" name="hdnAncho[]" value="' + Ancho + '" />';
			strHtml7 += '<input type="hidden" id="hdnAnchoMedida' + oId +'" name="hdnAnchoMedida[]" value="' + AnchoMedida + '" />';
			strHtml7 += '<input type="hidden" id="hdnLargo' + oId +'" name="hdnLargo[]" value="' + Largo + '" />';				
			strHtml7 += '<input type="hidden" id="hdnLargoMedida' + oId +'" name="hdnLargoMedida[]" value="' + LargoMedida + '" />';
			strHtml7 += '<input type="hidden" id="hdnAreaTotal' + oId +'" name="hdnAreaTotal[]" value="' + AreaTotal + '" />';			
			strHtml7 += '<input type="hidden" id="hdnFormaPago' + oId +'" name="hdnFormaPago[]" value="' + FormaPago + '" />';
			strHtml7 += '<input type="hidden" id="hdnCalidadBanner' + oId +'" name="hdnCalidadBanner[]" value="' + CalidadBanner + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioInstalacion' + oId +'" name="hdnPrecioInstalacion[]" value="' + PrecioInstalacion + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRecorte' + oId +'" name="hdnPrecioRecorte[]" value="' + PrecioRecorte + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioArte' + oId +'" name="hdnPrecioArte[]" value="' + PrecioArte + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRotulado' + oId +'" name="hdnPrecioRotulado[]" value="' + PrecioRotulado + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBasta' + oId +'" name="hdnPrecioBasta[]" value="' + PrecioBasta + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioOjete' + oId +'" name="hdnPrecioOjete[]" value="' + PrecioOjete + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBulcaniza' + oId +'" name="hdnPrecioBulcaniza[]" value="' + PrecioBulcaniza + '" />';
			strHtml7 += '<input type="hidden" id="hdnNotaCotizacion' + oId + '" name="hdnNotaCotizacion[]" value="' + NotaCotizacion + '"  />';		
			strHtml7 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]" value="' + ExentoITBM + '"  />';
			strHtml7 += '<input type="hidden" id="hdnDescripcionImpresion' + oId +'" name="hdnDescripcionImpresion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialImpresion' + oId +'" name="hdnMaterialImpresion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnRecorte' + oId +'" name="hdnRecorte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPlastificado' + oId +'" name="hdnPlastificado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnCaminado' + oId +'" name="hdnCaminado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnRealce' + oId +'" name="hdnRealce[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnDoblado' + oId +'" name="hdnDoblado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnRepujado' + oId +'" name="hdnRepujado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnEngrapado' + oId +'" name="hdnEngrapado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnUV' + oId +'" name="hdnUV[]" value="" />';	
			strHtml7 += '<input type="hidden" id="hdnCantPliego' + oId +'" name="hdnCantPliego[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnAjustarTamano' + oId +'" name="hdnAjustarTamano[]" value="" />';				
			strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
		var strHtml8 = '<tr><td colspan="6"><a href="javascript:void(0)" onclick="Mostrar_Detalles(' + oId +',\''+Libreta+'\')" >Ver detalle</a></td></tr>';				
		var strHtml9 = '</tr>';
		strHtml9 += '</table></td>';	
		var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;		

		$("#rowDetalle_" + oId).html(strHtmlFinal);

		$.post("library/funciones.php?action=Verificar_Administrador",
		function(data){

			if (data == "true")
			{
				$("#txtPrecio"+oId).attr("readonly",false);
				$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
				$("#txtPrecio" + oId).keydown(function(event){
				//alert(event.keyCode);
					if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
						return false;
					}
				});
						
				$("#txtPrecio" + oId).change(function(){

					$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
					$("#txtPrecio"+oId).attr("title","Precio Especial");
					$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

					$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
					$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
					$("#hidTotal" + oId).val($("#txtTotal" + oId).val());

					Calcular_Total_Cotizacion ();
				});
			}
			else
			{
				$("#txtPrecio"+oId).attr("readonly",true);
			}
		});
		
		
		$("#txtProducto" + oId).autocomplete({
			source: "application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar",
			select:  function(event, ui) {

				$("#hidDescProducto" + oId).val(ui.item.value);
				$("#hidIdProducto" + oId).val(ui.item.id_producto);
				$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
				$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
				$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));		

				Generar_Descripcion_Producto(oId);
			
				$("#txtCantidad" + oId).change(function(){
		
					if ($("#txtCantidad" + oId).val() > 0)
					{
						$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
						$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
						Calcular_Total_Cotizacion();			
					}
					else
					{		
						alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
						$("#txtCantidad" + oId).val('0');						
					}
				});	
				
				$.post("library/funciones.php?action=Verificar_Administrador",
				function(data){

					if (data == "true")
					{
						$("#txtPrecio"+oId).attr("readonly",false);
						$("#txtPrecio"+oId).attr("title","Precio Sugerido");
						
						$("#txtPrecio" + oId).keydown(function(event){

							if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
								return true;
							}
							else
							{
								return false;
							}
						});
						
						$("#txtPrecio" + oId).change(function(){

							$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
							$("#txtPrecio"+oId).attr("title","Precio Especial");
							$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

							$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
		
							Calcular_Total_Cotizacion ();
						});
					}
					else
					{
						$("#txtPrecio"+oId).attr("readonly",true);
					}
				});				
				
				Calcular_Total_Cotizacion ();			
			},
			change: function (event, ui) {
			
				if (ui.item === null)
				{	
					$("#txtProducto"+oId).val("");
					$("#hidDescProducto" + oId).val("");
					$("#hidIdProducto" + oId).val("");
					$("#txtTipoEmpaque" + oId).val("");
					$("#hidTipoEmpaque" + oId).val("");
					$("#txtPrecio" + oId).val("0.00");
					$("#hidPrecio" + oId).val("0.00");
					$("#txtTotal" + oId).val("0.00");
					$("#hidTotal" + oId).val("0.00");					
				}
				else
				{
					$("#hidDescProducto" + oId).val(ui.item.value);
					$("#hidIdProducto" + oId).val(ui.item.id_producto);
					$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
					$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
					$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
					$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));		

					Generar_Descripcion_Producto(oId);
				
					$("#txtCantidad" + oId).change(function(){
			
						if ($("#txtCantidad" + oId).val() > 0)
						{
							$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
							Calcular_Total_Cotizacion();			
						}
						else
						{		
							alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
							$("#txtCantidad" + oId).val('0');						
						}
					});	
					
				$.post("library/funciones.php?action=Verificar_Administrador",
				function(data){

					if (data == "true")
					{
						$("#txtPrecio"+oId).attr("readonly",false);
						$("#txtPrecio"+oId).attr("title","Precio Sugerido");
						
						$("#txtPrecio" + oId).keydown(function(event){

							if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
								return true;
							}
							else
							{
								return false;
							}
						});
						
						$("#txtPrecio" + oId).change(function(){

							$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
							$("#txtPrecio"+oId).attr("title","Precio Especial");
							$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

							$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
		
							Calcular_Total_Cotizacion ();
						});

					}
					else
					{
						$("#txtPrecio"+oId).attr("readonly",true);
					}
				});				
						
					Calcular_Total_Cotizacion ();	
				}				
			}
	
		});
			
		
		$("#txtCantidad" + oId).keydown(function(event){
			if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});		
	
		if(Cantidad!=undefined)
		{
			$("#txtCantidad" + oId).val(Cantidad);
			$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());		
		}	
	
		$("#txtCantidad" + oId).change(function(){
		
			if ($("#txtCantidad" + oId).val() == 0)
			{
				alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
				$("#txtCantidad" + oId).val('0');			
			}
			else
			{
				$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));			
				$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
				$("#hidTotal" + oId).val($("#txtTotal" + oId).val());			
			}

		});	
		
		Calcular_Precio_Banner(oId);		
		
	}
	else if(Libreta == "timpart")
	{

		var Id = $("#hdnIdCampos_" + oId).val();		

		var DescripcionImpresion = $("#txtDescripcionImpresion" + oId).val();
		var MaterialImpresion = $("#lstMaterialImpresion" + oId).val();		
		var PrecioArte = $("#txtPrecioArte" + oId).val();
		var Tamano = $("#lstTamano" + oId).val();
		var ColorTinta = $("#lstColorTinta" + oId).val();
		var Recorte = $("#txtRecorte" + oId).val();	
		var Plastificado = $("#txtPlastificado" + oId).val();	
		var Caminado = $("#txtCaminado" + oId).val();	
		var Realce = $("#txtRealce" + oId).val();	
		var Doblado = $("#txtDoblado" + oId).val();	
		var Repujado = $("#txtRepujado" + oId).val();	
		var Engrapado = $("#txtEngrapado" + oId).val();	
		var UV = $("#txtUV" + oId).val();
		var AjustarTamano = $("#hdnAjustarTamano" + oId).val();	
		var CantPliego = $("#hdnCantPliego" + oId).val();		
		var Ancho = $("#txtAncho" + oId).val();
		var AnchoMedida = $("#lstAnchoMedida" + oId).val();	
		var Largo = $("#txtLargo" + oId).val();
		var LargoMedida = $("#lstLargoMedida" + oId).val();		
		var OtroTamanoAncho = $("#txtOtroTamanoAncho" + oId).val();
		var OtroTamanoLargo = $("#txtOtroTamanoLargo" + oId).val();	
		var AreaTotal = $("#hdnAreaTotal" + oId).val();
		var TipoCategoria = $("#lstTipoCategoria" + oId).val();	
								
		var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
		var strHtml1 = '<td colspan="6"><table width="100%">';
			strHtml1 += '<tr>';
		var strHtml2 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
		var strHtml3 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="'+ DescTipoEmpaque +'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value="'+ TipoEmpaque +'"  /></td>';	
		var strHtml4 = '<td width="32%">';
			strHtml4 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto[]" style="width:85%;" class="validate[required]" value="'+DescProducto+'"/>';			
			strHtml4 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value="'+Producto+'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+DescProducto+'"  />';
			strHtml4 += '<input type="hidden" id="hidIdImprenta' + oId + '" name="hidIdImprenta[]" value="'+IdImprenta+'"  />';
			strHtml4 += '<input type="hidden" id="hidIdBanner' + oId + '" name="hidIdBanner[]" value="'+IdBanner+'"  />';		
			strHtml4 += '<input type="hidden" id="hidIdImpresion' + oId + '" name="hidIdImpresion[]" value="'+IdImpresion+'"  /></td>';
		var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="' + Precio + '" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value="' + Precio + '"  /></td>';
		var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="' + Total + '" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value="' + Total + '"  /></td>';

		var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
			
			strHtml7 += '<input type="hidden" id="hdnDescripcionImprenta' + oId +'" name="hdnDescripcionImprenta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnResmaTamano' + oId +'" name="hdnResmaTamano[]" value="" />';				
			strHtml7 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="' + Tamano + '" />';			
			strHtml7 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="'+ ColorTinta +'" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoAncho' + oId +'" name="hdnOtroTamanoAncho[]" value="' + OtroTamanoAncho + '" />';
			strHtml7 += '<input type="hidden" id="hdnOtroTamanoLargo' + oId +'" name="hdnOtroTamanoLargo[]" value="' + OtroTamanoLargo + '" />';
			strHtml7 += '<input type="hidden" id="hdnSinNumeracion' + oId + '" name="hdnSinNumeracion[]" value=""  />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionInicio' + oId +'" name="hdnNumeracionInicio[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnNumeracionFinal' + oId +'" name="hdnNumeracionFinal[]" value="" />';			
			
			var c = 0;
			
			while (c <= 3)
			{
				if (c == 0)
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="" />';					
				else
				strHtml7 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="" />';
				
				c = c + 1;
			}
			
			strHtml7 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="'+ TipoCategoria +'" />';
			strHtml7 += '<input type="hidden" id="hdnArte' + oId + '" name="hdnArte[]" value=""  />';	
			strHtml7 += '<input type="hidden" id="hdnPlaca' + oId + '" name="hdnPlaca[]" value=""  />';		
			
			strHtml7 += '<input type="hidden" id="hdnDescripcionBanner' + oId +'" name="hdnDescripcionBanner[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialBanner' + oId +'" name="hdnMaterialBanner[]" value="" />';			
			strHtml7 += '<input type="hidden" id="hdnAncho' + oId +'" name="hdnAncho[]" value="'+ Ancho +'" />';
			strHtml7 += '<input type="hidden" id="hdnAnchoMedida' + oId +'" name="hdnAnchoMedida[]" value="'+ AnchoMedida +'" />';
			strHtml7 += '<input type="hidden" id="hdnLargo' + oId +'" name="hdnLargo[]" value="'+ Largo +'" />';				
			strHtml7 += '<input type="hidden" id="hdnLargoMedida' + oId +'" name="hdnLargoMedida[]" value="'+ LargoMedida +'" />';
			strHtml7 += '<input type="hidden" id="hdnAreaTotal' + oId +'" name="hdnAreaTotal[]" value="'+ AreaTotal +'" />';			
			strHtml7 += '<input type="hidden" id="hdnFormaPago' + oId +'" name="hdnFormaPago[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnCalidadBanner' + oId +'" name="hdnCalidadBanner[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioInstalacion' + oId +'" name="hdnPrecioInstalacion[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRecorte' + oId +'" name="hdnPrecioRecorte[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioArte' + oId +'" name="hdnPrecioArte[]" value="' + PrecioArte + '" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioRotulado' + oId +'" name="hdnPrecioRotulado[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBasta' + oId +'" name="hdnPrecioBasta[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioOjete' + oId +'" name="hdnPrecioOjete[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnPrecioBulcaniza' + oId +'" name="hdnPrecioBulcaniza[]" value="" />';
			strHtml7 += '<input type="hidden" id="hdnNotaCotizacion' + oId + '" name="hdnNotaCotizacion[]" value="' + NotaCotizacion + '"  />';		
			strHtml7 += '<input type="hidden" id="hdnExentoITBM' + oId + '" name="hdnExentoITBM[]" value="' + ExentoITBM + '"  />';
			strHtml7 += '<input type="hidden" id="hdnDescripcionImpresion' + oId +'" name="hdnDescripcionImpresion[]" value="' + DescripcionImpresion + '" />';
			strHtml7 += '<input type="hidden" id="hdnMaterialImpresion' + oId +'" name="hdnMaterialImpresion[]" value="' + MaterialImpresion + '" />';
			strHtml7 += '<input type="hidden" id="hdnRecorte' + oId +'" name="hdnRecorte[]" value="' + Recorte + '" />';
			strHtml7 += '<input type="hidden" id="hdnPlastificado' + oId +'" name="hdnPlastificado[]" value="' + Plastificado + '" />';
			strHtml7 += '<input type="hidden" id="hdnCaminado' + oId +'" name="hdnCaminado[]" value="' + Caminado + '" />';
			strHtml7 += '<input type="hidden" id="hdnRealce' + oId +'" name="hdnRealce[]" value="' + Realce + '" />';
			strHtml7 += '<input type="hidden" id="hdnDoblado' + oId +'" name="hdnDoblado[]" value="' + Doblado + '" />';
			strHtml7 += '<input type="hidden" id="hdnRepujado' + oId +'" name="hdnRepujado[]" value="' + Repujado + '" />';
			strHtml7 += '<input type="hidden" id="hdnEngrapado' + oId +'" name="hdnEngrapado[]" value="' + Engrapado + '" />';
			strHtml7 += '<input type="hidden" id="hdnUV' + oId +'" name="hdnUV[]" value="' + UV + '" />';
			strHtml7 += '<input type="hidden" id="hdnCantPliego' + oId +'" name="hdnCantPliego[]" value="' + CantPliego + '" />';
			strHtml7 += '<input type="hidden" id="hdnAjustarTamano' + oId +'" name="hdnAjustarTamano[]" value="' + AjustarTamano + '" />';				
			strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
		var strHtml8 = '<tr><td colspan="6"><a href="javascript:void(0)" onclick="Mostrar_Detalles(' + oId +',\''+Libreta+'\')" >Ver detalle</a></td></tr>';				
		var strHtml9 = '</tr>';
		strHtml9 += '</table></td>';	
		var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;		
	
		$("#rowDetalle_" + oId).html(strHtmlFinal);
		
		$.post("library/funciones.php?action=Verificar_Administrador",
		function(data){

			if (data == "true")
			{
				$("#txtPrecio"+oId).attr("readonly",false);
				$("#txtPrecio"+oId).attr("title","Precio Sugerido");
			
				$("#txtPrecio" + oId).keydown(function(event){
					if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
						return false;
					}
				});
						
				$("#txtPrecio" + oId).change(function(){

					$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
					$("#txtPrecio"+oId).attr("title","Precio Especial");
					$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

					$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
					$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
					$("#hidTotal" + oId).val($("#txtTotal" + oId).val());

					Calcular_Total_Cotizacion ();
				});
			}
			else
			{
				$("#txtPrecio"+oId).attr("readonly",true);
			}
		});		

		$("#txtProducto" + oId).autocomplete({
			source: "application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar",
			select:  function(event, ui) {
				$("#hidDescProducto" + oId).val(ui.item.value);
				$("#hidIdProducto" + oId).val(ui.item.id_producto);
				$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
				$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
				$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));		

				Generar_Descripcion_Producto(oId);
			
				$("#txtCantidad" + oId).change(function(){
		
					if ($("#txtCantidad" + oId).val() > 0)
					{
						$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
						$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
						Calcular_Total_Cotizacion();			
					}
					else
					{		
						alert("La cantidad de Trabajo de Impresión de Arte debe ser mayor que 0.")
						$("#txtCantidad" + oId).val('0');						
					}
				});	

				$.post("library/funciones.php?action=Verificar_Administrador",
				function(data){

					if (data == "true")
					{
						$("#txtPrecio"+oId).attr("readonly",false);
						$("#txtPrecio"+oId).attr("title","Precio Sugerido");
						
						$("#txtPrecio" + oId).keydown(function(event){
						//alert(event.keyCode);
							if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
								return true;
							}
							else
							{
								return false;
							}
						});
						
						$("#txtPrecio" + oId).change(function(){

							$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
							$("#txtPrecio"+oId).attr("title","Precio Especial");
							$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

							$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
		
							Calcular_Total_Cotizacion ();
						});
					}
					else
					{
						$("#txtPrecio"+oId).attr("readonly",true);
					}
				})
				
				Calcular_Total_Cotizacion ();			
			},
			change: function (event, ui) {
			
				if (ui.item === null)
				{	
					$("#txtProducto"+oId).val("");
					$("#hidDescProducto" + oId).val("");
					$("#hidIdProducto" + oId).val("");
					$("#txtTipoEmpaque" + oId).val("");
					$("#hidTipoEmpaque" + oId).val("");
					$("#txtPrecio" + oId).val("0.00");
					$("#hidPrecio" + oId).val("0.00");
					$("#txtTotal" + oId).val("0.00");
					$("#hidTotal" + oId).val("0.00");					
				}
				else
				{
					$("#hidDescProducto" + oId).val(ui.item.value);
					$("#hidIdProducto" + oId).val(ui.item.id_producto);
					$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
					$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
					$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
					$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
					$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));		
				//BuscarID_Producto(oId);

					Generar_Descripcion_Producto(oId);
				
					$("#txtCantidad" + oId).change(function(){
			
						if ($("#txtCantidad" + oId).val() > 0)
						{
							$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
							Calcular_Total_Cotizacion();			
						}
						else
						{		
							alert("La cantidad de Trabajo de Impresión de Arte debe ser mayor que 0.")
							$("#txtCantidad" + oId).val('0');						
						}
					});	
					
					
				$.post("library/funciones.php?action=Verificar_Administrador",
				function(data){

					if (data == "true")
					{
						$("#txtPrecio"+oId).attr("readonly",false);
						$("#txtPrecio"+oId).attr("title","Precio Sugerido");
						
						$("#txtPrecio" + oId).keydown(function(event){
							if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
								return true;
							}
							else
							{
								return false;
							}
						});
						
						$("#txtPrecio" + oId).change(function(){

							$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
							$("#txtPrecio"+oId).attr("title","Precio Especial");
							$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

							$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
							$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
							$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
		
							Calcular_Total_Cotizacion ();
						});
					}
					else
					{
						$("#txtPrecio"+oId).attr("readonly",true);
					}
				})					
					Calcular_Total_Cotizacion ();
				}				
			}
	
		});
			
		
		$("#txtCantidad" + oId).keydown(function(event){

			if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});		
	
		if(Cantidad!=undefined)
		{
			$("#txtCantidad" + oId).val(Cantidad);
			$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());		
		}	
	
		$("#txtCantidad" + oId).change(function(){
		
			if ($("#txtCantidad" + oId).val() == 0)
			{
				alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
				$("#txtCantidad" + oId).val('0');			
			}
			else
			{
				$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
				$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
				$("#hidTotal" + oId).val($("#txtTotal" + oId).val());			
			}

			
		});	
		
		Calcular_Precio_Impresion(oId);	
	
	}

}





function Calcular_Precio_Material_Pulgada(oId,precio,idtamano)
{
	$.post("application/controllers/CotizacionController.php?action=Calcular_Precio_Material_Pulgada",
	{
		Precio:precio,
		Tamano:idtamano
	},
	function(data){
	
		$("#txtPrecioPulgada"+oId).val(data);

	});

}



function Calcular_Precio_Material_Pagina(oId,precio,idtamano)
{
	$.post("application/controllers/CotizacionController.php?action=Calcular_Precio_Material_Pagina",
	{
		Precio:precio,
		Tamano:idtamano
	},
	function(data){
	
		$("#txtPrecioPagina"+oId).val(data);

	});

}

function Agregar_Cotizacion()
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);	
	
	var c = 1;
	var msj = "";
	var mensaje = "";
	//alert($("[name='txtCantidad[]']").length);
	while (c <= $("[name='txtCantidad[]']").length)
	{
		if (($("#txtCantidad" + c).val()%2 != 0) & ($("#hidDescProducto" + c).val() == "Trabajo de Imprenta") & ($("#txtCantidad" + c).val()%2 > 1))
		{	
			msj = "- La cantidad de Trabajo de Imprenta de la fila " + c + " debe ser un número par.\n";
			mensaje = msj + mensaje;
			$("#txtCantidad" + c).val('0');
			$("#txtCantidad" + c).focus();
		}
		
		if (($("#txtCantidad" + c).val() == 0))
		{	
			msj = "- La cantidad de Producto o Trabajo de Imprenta o Banner de la fila " + c + " no debe ser 0.\n";
			mensaje = msj + mensaje;
			$("#txtCantidad" + c).focus();
		}		
		
		c = c + 1;
	}
	
	if (mensaje != "")
	{
		alert(mensaje)
					
	}
	else
	{
	var arrCantidad = new Array();
	arrCantidad = $("[name='hidCantidad[]']");
	var ArrCantidad = [];
	for (var i = 0; i < arrCantidad.length; ++i) {
		ArrCantidad[i] = arrCantidad[i].value;
	}

	//StrCantidad = ArrCantidad.toString();
	StrCantidad = JSON.stringify(ArrCantidad)
	
	
	var arrTipoEmpaque = new Array();
	arrTipoEmpaque = $("[name='hidTipoEmpaque[]']");
	var ArrTipoEmpaque = [];
	for (var i = 0; i < arrTipoEmpaque.length; ++i) {
		ArrTipoEmpaque[i] = arrTipoEmpaque[i].value;
	}

	//StrTipoEmpaque = ArrTipoEmpaque.toString();	
	StrTipoEmpaque = JSON.stringify(ArrTipoEmpaque);	
	
	var arrTipoEmpaqueDesc = new Array();
	arrTipoEmpaqueDesc = $("[name='txtTipoEmpaque[]']");
	var ArrTipoEmpaqueDesc = [];
	for (var i = 0; i < arrTipoEmpaqueDesc.length; ++i) {
		ArrTipoEmpaqueDesc[i] = arrTipoEmpaqueDesc[i].value;
	}	
	
	//StrTipoEmpaqueDesc = JSON.stringify(ArrTipoEmpaqueDesc);
	
	var arrProducto = new Array();
	arrProducto = $("[name='hidIdProducto[]']");
	var ArrProducto = [];
	for (var i = 0; i < arrProducto.length; ++i) {
		ArrProducto[i] = arrProducto[i].value;
	}

	//StrProducto = ArrProducto.toString();
	StrProducto = JSON.stringify(ArrProducto);	
	
	var arrProductoDesc = new Array();
	arrProductoDesc = $("[name='hidDescProducto[]']");
	var ArrProductoDesc = [];
	for (var i = 0; i < arrProductoDesc.length; ++i) {
		ArrProductoDesc[i] = arrProductoDesc[i].value;
	}	
	
	//StrProductoDesc = JSON.stringify(arrProductoDesc);
	
	var arrPrecio = new Array();
	arrPrecio = $("[name='hidPrecio[]']");
	var ArrPrecio = [];
	for (var i = 0; i < arrPrecio.length; ++i) {
		ArrPrecio[i] = arrPrecio[i].value;
	}

	//StrPrecio = ArrPrecio.toString();
	StrPrecio = JSON.stringify(ArrPrecio);
	
	var arrDescripcionImprenta = new Array();
	arrDescripcionImprenta = $("[name='hdnDescripcionImprenta[]']");
	var ArrDescripcionImprenta = [];
	for (var i = 0; i < arrDescripcionImprenta.length; ++i) {
		ArrDescripcionImprenta[i] = arrDescripcionImprenta[i].value;
	}

	//StrDescripcionImprenta = ArrDescripcionImprenta.toString();	
	StrDescripcionImprenta = JSON.stringify(ArrDescripcionImprenta);
	
	var arrPapelTipo = new Array();
	arrPapelTipo = $("[name='hdnPapelTipo[]']");
	var ArrPapelTipo = [];
	for (var i = 0; i < arrPapelTipo.length; ++i) {
		ArrPapelTipo[i] = arrPapelTipo[i].value;
	}

	//StrPapelTipo = ArrPapelTipo.toString();	
	StrPapelTipo = JSON.stringify(ArrPapelTipo);	
	
	
	var arrMaterialPapelTipo = new Array();
	arrMaterialPapelTipo = $("[name='hdnMaterialPapelTipo[]']");
	var ArrMaterialPapelTipo = [];
	for (var i = 0; i < arrMaterialPapelTipo.length; ++i) {
		ArrMaterialPapelTipo[i] = arrMaterialPapelTipo[i].value;
	}

	//StrMaterialPapelTipo = ArrMaterialPapelTipo.toString();
	StrMaterialPapelTipo = JSON.stringify(ArrMaterialPapelTipo);	
	
	var arrResmaTamano = new Array();
	arrResmaTamano = $("[name='hdnResmaTamano[]']");
	var ArrResmaTamano = [];
	for (var i = 0; i < arrResmaTamano.length; ++i) {
		ArrResmaTamano[i] = arrResmaTamano[i].value;
	}

	//StrResmaTamano = ArrResmaTamano.toString();	
	StrResmaTamano = JSON.stringify(ArrResmaTamano);
	
	var arrTamano = new Array();
	arrTamano = $("[name='hdnTamano[]']");
	var ArrTamano = [];
	for (var i = 0; i < arrTamano.length; ++i) {
		ArrTamano[i] = arrTamano[i].value;
	}

	//StrTamano = ArrTamano.toString();	
	StrTamano = JSON.stringify(ArrTamano);
	
	var arrOtroTamanoAncho = new Array();
	arrOtroTamanoAncho = $("[name='hdnOtroTamanoAncho[]']");
	var ArrOtroTamanoAncho = [];
	for (var i = 0; i < arrOtroTamanoAncho.length; ++i) {
		ArrOtroTamanoAncho[i] = arrOtroTamanoAncho[i].value;
	}

	//StrOtroTamanoAncho = ArrOtroTamanoAncho.toString();
	StrOtroTamanoAncho = JSON.stringify(ArrOtroTamanoAncho);	
	
	var arrOtroTamanoLargo = new Array();
	arrOtroTamanoLargo = $("[name='hdnOtroTamanoLargo[]']");
	var ArrOtroTamanoLargo = [];
	for (var i = 0; i < arrOtroTamanoLargo.length; ++i) {
		ArrOtroTamanoLargo[i] = arrOtroTamanoLargo[i].value;
	}

	//StrOtroTamanoLargo = ArrOtroTamanoLargo.toString();	
	StrOtroTamanoLargo = JSON.stringify(ArrOtroTamanoLargo);	
	
	var arrNumeracionInicio = new Array();
	arrNumeracionInicio = $("[name='hdnNumeracionInicio[]']");
	var ArrNumeracionInicio = [];
	for (var i = 0; i < arrNumeracionInicio.length; ++i) {
		ArrNumeracionInicio[i] = arrNumeracionInicio[i].value;
	}
	
	//StrNumeracionInicio = ArrNumeracionInicio.toString();
	StrNumeracionInicio = JSON.stringify(ArrNumeracionInicio);	
	
	var arrNumeracionFinal = new Array();
	arrNumeracionFinal = $("[name='hdnNumeracionFinal[]']");
	var ArrNumeracionFinal = [];
	for (var i = 0; i < arrNumeracionFinal.length; ++i) {
		ArrNumeracionFinal[i] = arrNumeracionFinal[i].value;
	}

	//StrNumeracionFinal = ArrNumeracionFinal.toString();
	StrNumeracionFinal = JSON.stringify(ArrNumeracionFinal);	
	
	var arrCantidadCopia = new Array();
	arrCantidadCopia = $("[name='hdnCantidadCopia[]']");
	var ArrCantidadCopia = [];
	for (var i = 0; i < arrCantidadCopia.length; ++i) {
		ArrCantidadCopia[i] = arrCantidadCopia[i].value;
	}	

	//StrCantidadCopia = ArrCantidadCopia.toString();		
	StrCantidadCopia = JSON.stringify(ArrCantidadCopia);
	
	var arrColorPapel = new Array();
	var arrColorPapel = new Array();
	arrColorPapel = $("[name='hdnColorPapel[]']");
	var ArrColorPapel = [];
	for (var i = 0; i < arrColorPapel.length; ++i) {
	ArrColorPapel[i] = arrColorPapel[i].value;
	}
	
	//StrColorPapel = ArrColorPapel.toString();	
	StrColorPapel = JSON.stringify(ArrColorPapel);	
	
	var arrColorPapel1 = new Array();
	var arrColorPapel1 = new Array();
	arrColorPapel1 = $("[name='hdnColorPapel1[]']");
	var ArrColorPapel1 = [];
	for (var i = 0; i < arrColorPapel1.length; ++i) {
	ArrColorPapel1[i] = arrColorPapel1[i].value;
	}
	
	//StrColorPapel1 = ArrColorPapel1.toString();	
	StrColorPapel1 = JSON.stringify(ArrColorPapel1);
	
	var arrColorPapel2 = new Array();
	var arrColorPapel2 = new Array();
	arrColorPapel2 = $("[name='hdnColorPapel2[]']");
	var ArrColorPapel2 = [];
	for (var i = 0; i < arrColorPapel2.length; ++i) {
	ArrColorPapel2[i] = arrColorPapel2[i].value;
	}
	
	//StrColorPapel2 = ArrColorPapel2.toString();	
	StrColorPapel2 = JSON.stringify(ArrColorPapel2);	
	
	var arrColorPapel3 = new Array();
	var arrColorPapel3 = new Array();
	arrColorPapel3 = $("[name='hdnColorPapel3[]']");
	var ArrColorPapel3 = [];
	for (var i = 0; i < arrColorPapel3.length; ++i) {
	ArrColorPapel3[i] = arrColorPapel3[i].value;
	}
	
	//StrColorPapel3 = ArrColorPapel3.toString();		
	StrColorPapel3 = JSON.stringify(ArrColorPapel3);		
	
	var arrColorTinta = new Array();
	arrColorTinta = $("[name='hdnColorTinta[]']");
	var ArrColorTinta = [];
	for (var i = 0; i < arrColorTinta.length; ++i) {
		ArrColorTinta[i] = arrColorTinta[i].value;
	}

	//StrColorTinta = ArrColorTinta.toString();		
	StrColorTinta = JSON.stringify(ArrColorTinta);
	
	var arrTipoForro = new Array();
	arrTipoForro = $("[name='hdnTipoForro[]']");
	var ArrTipoForro = [];
	for (var i = 0; i < arrTipoForro.length; ++i) {
		ArrTipoForro[i] = arrTipoForro[i].value;
	}

	//StrTipoForro = ArrTipoForro.toString();
	StrTipoForro = JSON.stringify(ArrTipoForro);
	

	var arrTiempo = new Array();
	arrTiempo = $("[name='hdnTiempo[]']");
	var ArrTiempo = [];
	for (var i = 0; i < arrTiempo.length; ++i) {
		ArrTiempo[i] = arrTiempo[i].value;
	}

	//StrTiempo = ArrTiempo.toString();
	StrTiempo = JSON.stringify(ArrTiempo);	
		
	var arrTipoTiempo = new Array();
	arrTipoTiempo = $("[name='hdnTipoTiempo[]']");
	var ArrTipoTiempo = [];
	for (var i = 0; i < arrTipoTiempo.length; ++i) {
		ArrTipoTiempo[i] = arrTipoTiempo[i].value;
	}

	//StrTipoTiempo = ArrTipoTiempo.toString();
	StrTipoTiempo = JSON.stringify(ArrTipoTiempo);	

	var arrTipoCategoria = new Array();
	arrTipoCategoria = $("[name='hdnTipoCategoria[]']");
	var ArrTipoCategoria = [];
	for (var i = 0; i < arrTipoCategoria.length; ++i) {
		ArrTipoCategoria[i] = arrTipoCategoria[i].value;
	}

	//StrTipoCategoria = ArrTipoCategoria.toString();	
	StrTipoCategoria = JSON.stringify(ArrTipoCategoria);		

	var arrExentoITBM = new Array();
	arrExentoITBM = $("[name='hdnExentoITBM[]']");
	var ArrExentoITBM = [];
	for (var i = 0; i < arrExentoITBM.length; ++i) {
		ArrExentoITBM[i] = arrExentoITBM[i].value;
	}
	
	//StrExentoITBM = ArrExentoITBM.toString();	
	StrExentoITBM = JSON.stringify(ArrExentoITBM);
	
	var arrArte = new Array();
	arrArte = $("[name='hdnArte[]']");
	var ArrArte = [];
	for (var i = 0; i < arrArte.length; ++i) {
		ArrArte[i] = arrArte[i].value;
	}
	
	//StrArte = ArrArte.toString();		
	StrArte = JSON.stringify(ArrArte);
	
	var arrPlaca = new Array();
	arrPlaca = $("[name='hdnPlaca[]']");
	var ArrPlaca = [];
	for (var i = 0; i < arrPlaca.length; ++i) {
		ArrPlaca[i] = arrPlaca[i].value;
	}
	
	//StrPlaca = ArrPlaca.toString();
	StrPlaca = JSON.stringify(ArrPlaca);
	
	var arrNotaCotizacion = new Array();
	arrNotaCotizacion = $("[name='hdnNotaCotizacion[]']");
	var ArrNotaCotizacion= [];
	for (var i = 0; i < arrNotaCotizacion.length; ++i) {
		ArrNotaCotizacion[i] = arrNotaCotizacion[i].value;
	}

	//StrNotaCotizacion = ArrNotaCotizacion.toString();
	StrNotaCotizacion = JSON.stringify(ArrNotaCotizacion);
	//alert(ArrNotaCotizacion[0]);
	//alert(StrNotaCotizacion);
	
	var arrDescripcionBanner = new Array();
	arrDescripcionBanner = $("[name='hdnDescripcionBanner[]']");
	var ArrDescripcionBanner = [];
	for (var i = 0; i < arrDescripcionBanner.length; ++i) {
		ArrDescripcionBanner[i] = arrDescripcionBanner[i].value;
	}

	//StrDescripcionBanner = ArrDescripcionBanner.toString();	
	StrDescripcionBanner = JSON.stringify(ArrDescripcionBanner);
	
	var arrMaterialBanner = new Array();
	arrMaterialBanner = $("[name='hdnMaterialBanner[]']");
	var ArrMaterialBanner = [];
	for (var i = 0; i < arrMaterialBanner.length; ++i) {
		ArrMaterialBanner[i] = arrMaterialBanner[i].value;
	}

	//StrMaterialBanner = ArrMaterialBanner.toString();		
	StrMaterialBanner = JSON.stringify(ArrMaterialBanner);
	
	var arrAncho = new Array();
	arrAncho = $("[name='hdnAncho[]']");
	var ArrAncho = [];
	for (var i = 0; i < arrAncho.length; ++i) {
		ArrAncho[i] = arrAncho[i].value;
	}

	//StrAncho = ArrAncho.toString();
	StrAncho = JSON.stringify(ArrAncho);	

	var arrAnchoMedida = new Array();
	arrAnchoMedida = $("[name='hdnAnchoMedida[]']");
	var ArrAnchoMedida = [];
	for (var i = 0; i < arrAnchoMedida.length; ++i) {
		ArrAnchoMedida[i] = arrAnchoMedida[i].value;
	}

	//StrAnchoMedida = ArrAnchoMedida.toString();
	StrAnchoMedida = JSON.stringify(ArrAnchoMedida);
	
	var arrLargo = new Array();
	arrLargo = $("[name='hdnLargo[]']");
	var ArrLargo = [];
	for (var i = 0; i < arrLargo.length; ++i) {
		ArrLargo[i] = arrLargo[i].value;
	}

	//StrLargo = ArrLargo.toString();	
	StrLargo = JSON.stringify(ArrLargo);
	//alert($("[name='hdnLargoMedida[]']").length);
	
	var arrLargoMedida = new Array();
	arrLargoMedida = $("[name='hdnLargoMedida[]']");
	var ArrLargoMedida = [];
	for (var i = 0; i < arrLargoMedida.length; ++i) {
		ArrLargoMedida[i] = arrLargoMedida[i].value;
	}

	//StrLargoMedida = ArrLargoMedida.toString();	
	StrLargoMedida = JSON.stringify(ArrLargoMedida);
	
	var arrAreaTotal = new Array();
	arrAreaTotal = $("[name='hdnAreaTotal[]']");
	var ArrAreaTotal = [];
	for (var i = 0; i < arrAreaTotal.length; ++i) {
		ArrAreaTotal[i] = arrAreaTotal[i].value;
	}

	//StrAreaTotal = ArrAreaTotal.toString();		
	StrAreaTotal = JSON.stringify(ArrAreaTotal);
	
	var arrFormaPago = new Array();
	arrFormaPago = $("[name='hdnFormaPago[]']");
	var ArrFormaPago = [];
	for (var i = 0; i < arrFormaPago.length; ++i) {
		ArrFormaPago[i] = arrFormaPago[i].value;
	}

	//StrFormaPago = ArrFormaPago.toString();		
	StrFormaPago = JSON.stringify(ArrFormaPago);
	
	var arrCalidadBanner = new Array();
	arrCalidadBanner = $("[name='hdnCalidadBanner[]']");
	var ArrCalidadBanner = [];
	for (var i = 0; i < arrCalidadBanner.length; ++i) {
		ArrCalidadBanner[i] = arrCalidadBanner[i].value;
	}

	//StrCalidadBanner = ArrCalidadBanner.tArrCalidadBanneroString();			
	StrCalidadBanner = JSON.stringify(ArrCalidadBanner);
	
	var arrPrecioInstalacion = new Array();
	arrPrecioInstalacion = $("[name='hdnPrecioInstalacion[]']");
	var ArrPrecioInstalacion = [];
	for (var i = 0; i < arrPrecioInstalacion.length; ++i) {
		ArrPrecioInstalacion[i] = arrPrecioInstalacion[i].value;
	}

	//StrPrecioInstalacion = ArrPrecioInstalacion.toString();
	StrPrecioInstalacion = JSON.stringify(ArrPrecioInstalacion);
	
	var arrPrecioRecorte = new Array();
	arrPrecioRecorte = $("[name='hdnPrecioRecorte[]']");
	var ArrPrecioRecorte = [];
	for (var i = 0; i < arrPrecioRecorte.length; ++i) {
		ArrPrecioRecorte[i] = arrPrecioRecorte[i].value;
	}

	//StrPrecioRecorte = ArrPrecioRecorte.toString();
	StrPrecioRecorte = JSON.stringify(ArrPrecioRecorte);	

	var arrPrecioArte = new Array();
	arrPrecioArte = $("[name='hdnPrecioArte[]']");
	var ArrPrecioArte = [];
	for (var i = 0; i < arrPrecioArte.length; ++i) {
		ArrPrecioArte[i] = arrPrecioArte[i].value;
	}

	//StrPrecioArte = ArrPrecioArte.toString();
	StrPrecioArte = JSON.stringify(ArrPrecioArte);	

	var arrPrecioRotulado = new Array();
	arrPrecioRotulado = $("[name='hdnPrecioRotulado[]']");
	var ArrPrecioRotulado = [];
	for (var i = 0; i < arrPrecioRotulado.length; ++i) {
		ArrPrecioRotulado[i] = arrPrecioRotulado[i].value;
	}

	//StrPrecioRotulado = ArrPrecioRotulado.toString();
	StrPrecioRotulado = JSON.stringify(ArrPrecioRotulado);
	
	var arrPrecioBasta = new Array();
	arrPrecioBasta = $("[name='hdnPrecioBasta[]']");
	var ArrPrecioBasta = [];
	for (var i = 0; i < arrPrecioBasta.length; ++i) {
		ArrPrecioBasta[i] = arrPrecioBasta[i].value;
	}

	//StrPrecioBasta = ArrPrecioBasta.toString();	
	StrPrecioBasta = JSON.stringify(ArrPrecioBasta);
	
	var arrPrecioOjete = new Array();
	arrPrecioOjete = $("[name='hdnPrecioOjete[]']");
	var ArrPrecioOjete = [];
	for (var i = 0; i < arrPrecioOjete.length; ++i) {
		ArrPrecioOjete[i] = arrPrecioOjete[i].value;
	}

	//StrPrecioOjete = ArrPrecioOjete.toString();	
	StrPrecioOjete = JSON.stringify(ArrPrecioOjete);
	
	var arrPrecioBulcaniza = new Array();
	arrPrecioBulcaniza = $("[name='hdnPrecioBulcaniza[]']");
	var ArrPrecioBulcaniza = [];
	for (var i = 0; i < arrPrecioBulcaniza.length; ++i) {
		ArrPrecioBulcaniza[i] = arrPrecioBulcaniza[i].value;
	}

	//StrPrecioBulcaniza = ArrPrecioBulcaniza.toString();
	StrPrecioBulcaniza = JSON.stringify(ArrPrecioBulcaniza);	

	var arrDescripcionImpresion = new Array();
	arrDescripcionImpresion = $("[name='hdnDescripcionImpresion[]']");
	var ArrDescripcionImpresion= [];
	for (var i = 0; i < arrDescripcionImpresion.length; ++i) {
		ArrDescripcionImpresion[i] = arrDescripcionImpresion[i].value;
	}
	
	StrDescripcionImpresion = JSON.stringify(ArrDescripcionImpresion);
	
	var arrMaterialImpresion = new Array();
	arrMaterialImpresion = $("[name='hdnMaterialImpresion[]']");
	var ArrMaterialImpresion= [];
	for (var i = 0; i < arrMaterialImpresion.length; ++i) {
		ArrMaterialImpresion[i] = arrMaterialImpresion[i].value;
	}

	StrMaterialImpresion = JSON.stringify(ArrMaterialImpresion);

	var arrRecorte = new Array();
	arrRecorte = $("[name='hdnRecorte[]']");
	var ArrRecorte= [];
	for (var i = 0; i < arrRecorte.length; ++i) {
		ArrRecorte[i] = arrRecorte[i].value;
	}

	StrRecorte = JSON.stringify(ArrRecorte);	
	
	var arrPlastificado = new Array();
	arrPlastificado = $("[name='hdnPlastificado[]']");
	var ArrPlastificado= [];
	for (var i = 0; i < arrPlastificado.length; ++i) {
		ArrPlastificado[i] = arrPlastificado[i].value;
	}

	StrPlastificado = JSON.stringify(ArrPlastificado);
	
	var arrCaminado = new Array();
	arrCaminado = $("[name='hdnCaminado[]']");
	var ArrCaminado= [];
	for (var i = 0; i < arrPlastificado.length; ++i) {
		ArrCaminado[i] = arrCaminado[i].value;
	}

	StrCaminado = JSON.stringify(ArrCaminado);
	
	var arrRealce = new Array();
	arrRealce = $("[name='hdnRealce[]']");
	var ArrRealce= [];
	for (var i = 0; i < arrRealce.length; ++i) {
		ArrRealce[i] = arrRealce[i].value;
	}

	StrRealce = JSON.stringify(ArrRealce);	
	
	var arrDoblado = new Array();
	arrDoblado = $("[name='hdnDoblado[]']");
	var ArrDoblado= [];
	for (var i = 0; i < arrDoblado.length; ++i) {
		ArrDoblado[i] = arrDoblado[i].value;
	}

	StrDoblado = JSON.stringify(ArrDoblado);		

	var arrRepujado = new Array();
	arrRepujado = $("[name='hdnRepujado[]']");
	var ArrRepujado= [];
	for (var i = 0; i < arrRepujado.length; ++i) {
		ArrRepujado[i] = arrRepujado[i].value;
	}

	StrRepujado = JSON.stringify(ArrRepujado);
	
	var arrEngrapado = new Array();
	arrEngrapado = $("[name='hdnEngrapado[]']");
	var ArrEngrapado= [];
	for (var i = 0; i < arrEngrapado.length; ++i) {
		ArrEngrapado[i] = arrEngrapado[i].value;
	}

	StrEngrapado = JSON.stringify(ArrEngrapado);

	var arrUV = new Array();
	arrUV = $("[name='hdnUV[]']");
	var ArrUV= [];
	for (var i = 0; i < arrUV.length; ++i) {
		ArrUV[i] = arrUV[i].value;
	}

	StrUV = JSON.stringify(ArrUV);

	var arrCantPliego = new Array();
	arrCantPliego = $("[name='hdnCantPliego[]']");
	var ArrCantPliego= [];
	for (var i = 0; i < arrCantPliego.length; ++i) {
		ArrCantPliego[i] = arrCantPliego[i].value;
	}

	StrCantPliego = JSON.stringify(ArrCantPliego);	
	
	var arrAjustarTamano = new Array();
	arrAjustarTamano = $("[name='hdnAjustarTamano[]']");
	var ArrAjustarTamano= [];
	for (var i = 0; i < arrAjustarTamano.length; ++i) {
		ArrAjustarTamano[i] = arrAjustarTamano[i].value;
	}

	StrAjustarTamano = JSON.stringify(ArrAjustarTamano);		
	
	//alert(StrColorPapel);		
	//alert(StrColorPapel1);
	//alert(StrColorPapel2);		
	//alert(StrColorPapel3);
	//alert(StrOtroTamanoAncho);	
	
	//alert('prueba');
	
	//alert(StrNotaCotizacion);
	
	$.post("application/controllers/CotizacionController.php?action=Agregar_Cotizacion",
	{
	
		NombreCliente:$("#txtNombreCliente").val(),
		DescripcionCotizacion:$("#txtDescripcionCotizacion").val(),		
		//NotaCotizacion:$("#txtNotaCotizacion").val(),
		Cantidad:StrCantidad,
		Producto:StrProducto,
		Precio:StrPrecio,
		DescripcionImprenta:StrDescripcionImprenta,		
		PapelTipo:StrPapelTipo,
		MaterialPapelTipo:StrMaterialPapelTipo,
		ResmaTamano:StrResmaTamano,		
		Tamano:StrTamano,
		OtroTamanoAncho:StrOtroTamanoAncho,		
		OtroTamanoLargo:StrOtroTamanoLargo,
		NumeracionInicio:StrNumeracionInicio,		
		NumeracionFinal:StrNumeracionFinal,		
		CantidadCopia:StrCantidadCopia,
		ColorTinta:StrColorTinta,
		ColorPapel:StrColorPapel,
		ColorPapel1:StrColorPapel1,
		ColorPapel2:StrColorPapel2,
		ColorPapel3:StrColorPapel3,		
		TipoForro:StrTipoForro,
		Tiempo:StrTiempo,
		TipoTiempo:StrTipoTiempo,
		TipoCategoria:StrTipoCategoria,
		ExentoITBM:StrExentoITBM,
		Arte:StrArte,
		Placa:StrPlaca,		
		NotaCotizacion:StrNotaCotizacion,
		DescripcionBanner:StrDescripcionBanner,		
		MaterialBanner:StrMaterialBanner,
		Ancho:StrAncho,		
		AnchoMedida:StrAnchoMedida,
		Largo:StrLargo,		
		LargoMedida:StrLargoMedida,
		AreaTotal:StrAreaTotal,		
		FormaPago:StrFormaPago,		
		CalidadBanner:StrCalidadBanner,
		PrecioInstalacion:StrPrecioInstalacion,		
		PrecioRecorte:StrPrecioRecorte,
		PrecioArte:StrPrecioArte,		
		PrecioRotulado:StrPrecioRotulado,		
		PrecioBasta:StrPrecioBasta,
		PrecioOjete:StrPrecioOjete,		
		PrecioBulcaniza:StrPrecioBulcaniza,
		DescripcionImpresion:StrDescripcionImpresion,	
		MaterialImpresion:StrMaterialImpresion,
		Recorte:StrRecorte,
		Plastificado:StrPlastificado,
		Caminado:StrCaminado,
		Realce:StrRealce,
		Doblado:StrDoblado,
		Repujado:StrRepujado,
		Engrapado:StrEngrapado,
		UV:StrUV,
		CantPliego:StrCantPliego,
		AjustarTamano:StrAjustarTamano,
		SubTotal:$("#txtSubTotal").val(),
		TotalITBM:$("#txtTotalITBM").val(),
		TotalFinal:$("#txtTotalFinal").val()
		
	}, function(data){

		//alert(data);
		//alert(arrCantidad.length);
		if ((data!="false") & (data!="false1"))
		{
			if (jQuery.browser.mobile == "true")
			{			
				var strHtml0 = '<div data-role="page" id="mainPage"><p>';
					strHtml0 += '<label>Nombre del Cliente:</label>';
					strHtml0 += '<div class="formRight">';
					strHtml0 += $("#txtNombreCliente").val();
					strHtml0 += '</div>';
					strHtml0 += '<div class="clear">';
					strHtml0 += '</div>';	
				var strHtml1 = '<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';
					strHtml1 += '<div data-role="page" id="mainPage"><p>';
					strHtml1 += '<label>Descripci&oacute;n de Cotizaci&oacute;n:</label>';
					strHtml1 += '<div class="formRight">';
					strHtml1 += $("#txtDescripcionCotizacion").val();
					strHtml1 += '</div>';
					strHtml1 += '<div class="clear">';
					strHtml1 += '</div>';	
					strHtml1 += '<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';				
			}
			else
			{
				var strHtml0 = '<label>Nombre del Cliente:</label>';
					strHtml0 += '<div class="formRight">';
					strHtml0 += $("#txtNombreCliente").val();
					strHtml0 += '</div>';
					strHtml0 += '<div class="clear">';
					strHtml0 += '</div>';
				var strHtml1 = '<label>Descripci&oacute;n de Cotizaci&oacute;n:</label>';
					strHtml1 += '<div class="formRight">';
					strHtml1 += $("#txtDescripcionCotizacion").val();
					strHtml1 += '</div>';
					strHtml1 += '<div class="clear">';
					strHtml1 += '</div>';				
			}	
		
			$("#NombreCliente").html(strHtml0);		
			
			$("#DescripcionCotizacion").html(strHtml1);		
			
			

			
			$.post("application/controllers/CotizacionController.php?action=Generar_Listar_Contactos",
			{	
				id:data
			}, function(data1){
			
				//alert(data1);
				if (data1 != "undefined")
				{
					$('#Contactos').show();
					$("#Contactos").html(data1);
				}
				else
				{
					$('#Contactos').hide();
				
				}
			});
			

			
			var strHtmlHead= '<tr><td width="2%"></td>';	
			strHtmlHead += '<td width="15%">Cantidad<input type="hidden" id="num_campos" name="num_campos" value="0"/></td>';
			strHtmlHead += '<td width="15%">Tipo de Empaque<input type="hidden" id="cant_campos" name="num_campos" value="0"/></td>';
			strHtmlHead += '<td width="38%">Producto</td>';	
			strHtmlHead += '<td width="15%">Precio</td>';		
			strHtmlHead += '<td width="15%">Total</td></tr>';
			
			var strHtmlTrHead = strHtmlHead;
			
			$("#tbHead").html(strHtmlTrHead);
		

			var oId,c;
			oId = 1;
			c = 0;
		
			//alert(ArrProductoDesc.length);
			//alert(arrCantidad.length);
			
			while (c < arrCantidad.length)
			{
			
				//alert(c);
				//alert(oId);
				//alert(ArrPrecio[c]);
				//alert(ArrCantidad[c]);
			
				//$("#rowDetalle_" + oId).remove();										
				var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
				var strHtml1 = '<td colspan="6"><table width="100%">';
					strHtml1 += '<tr>';
				var strHtml2 = '<td width="15%" align="center">' + ArrCantidad[c] + '</td>';
				var strHtml3 = '<td width="15%" align="center">'  + ArrTipoEmpaqueDesc[c] +  '</td>';	
				//var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtProducto' + oId + '" name="txtProducto[]" value="" style="width:80%;" class="maskCelular validate[required]" /><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value=""  /></td>';
				var strHtml4 = '<td width="32%">' + ArrProductoDesc[c] + '</td>';
				var strHtml5 = '<td width="15%" align="right">'  + ConvertirMoneda(ArrPrecio[c]) +  '</td>';
				var strHtml6 = '<td width="15%" align="right">' +  ConvertirMoneda(parseFloat(ArrCantidad[c]*ArrPrecio[c])) + '</td>';

				//var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					//strHtml7 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="' + PapelTipo + '" />';
					//strHtml7 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="' + MaterialPapelTipo + '" />';
					//strHtml7 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="' + Tamano + '" />';			
					//strHtml7 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="' + CantidadCopia + '" />';
					//strHtml7 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="' + ColorTinta + '" />';
					//var c = 0;
			
					//while (c <= 3)
					//{
						//if (c == 0)
						//strHtml7 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="' + ColorPapel[c] + '" />';					
						//else
						//strHtml7 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="' + ColorPapel[c] + '" />';
				
						//c = c + 1;
					//}
					//strHtml7 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="' + TipoForro + '" />';			
					//strHtml7 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="' + Tiempo + '" />';
					//strHtml7 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="' + TipoTiempo + '" />';
					//strHtml7 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="' + TipoCategoria + '" />';				
					//strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
				var strHtml8 = '<tr><td colspan "5"></td></tr>';				
				var strHtml9 = '</tr>';
				strHtml9 += '</table></td>';	
				var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
				var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml8 + strHtml9 //+ strHtml7 ;	

				//$("#tbDetalle").replaceWith(strHtmlTr);		
	
				$("#rowDetalle_" + oId).html(strHtmlFinal);				
				oId = oId + 1;
				c = c + 1;
			
			
			}
			
			var strHtmlSubTotal0= '<td  align="right" colspan="5">Sub-Total:</td>';	
			var strHtmlSubTotal1 = '<td align="right" >' + $("#txtSubTotal").val() + '</td>';
			var strHtmlSubTotal2= '<td  align="center"></td>';	
			var strHtmlTotalITBM0= '<td  align="right" colspan="5">ITBMS:</td>';	
			var strHtmlTotalITBM1 = '<td align="right" >' + $("#txtTotalITBM").val() + '</td>';
			var strHtmlTotalITBM2= '<td  align="center"></td>';		
			var strHtmlTotal0= '<td  align="right" colspan="5">Total Final:</td>';	
			var strHtmlTotal1 = '<td align="right" >' + $("#txtTotalFinal").val() + '</td>';
			var strHtmlTotal2= '<td  align="center"></td>';
			var strHtmlTrSubTotal = '<tr id="rowSubTotal"  valign="center"  ></tr>';
			var strHtmlTrTotalITBM = '<tr id="rowTotalITBM"  valign="center"  ></tr>';
			var strHtmlTrTotal = '<tr id="rowTotal"  valign="center"  ></tr>';
	
			var strHtmlTrFinalSubTotal = strHtmlSubTotal0 + strHtmlSubTotal1 + strHtmlSubTotal2;	
			var strHtmlFinalTotalITBM = strHtmlTotalITBM0 + strHtmlTotalITBM1 + strHtmlTotalITBM2;	
			var strHtmlFinalTotal = strHtmlTotal0 + strHtmlTotal1 + strHtmlTotal2;

			$("#tbTotal").append(strHtmlTrSubTotal);
			$("#tbTotal").append(strHtmlTrTotalITBM);
			$("#tbTotal").append(strHtmlTrTotal);
			$("#rowSubTotal").html(strHtmlTrFinalSubTotal);
			$("#rowTotalITBM").html(strHtmlFinalTotalITBM);	
			$("#rowTotal").html(strHtmlFinalTotal);						
		
			var strHtmlAgregarCotizacion= '<input type="button" value="Imprimir Cotizaci&oacute;n" class="redB" onclick="Imprimir_Cotizacion(\''+ data +'\');"/>&nbsp;&nbsp;<input type="button" value="Enviar Cotizaci&oacute;n" class="redB" onclick="Enviar_Cotizacion(\''+ data +'\');"/>';	
			$("#AgregarCotizacion").html(strHtmlAgregarCotizacion);	
			
			/*var strHtml0 = '<label>Nota:</label>';
				strHtml0 += '<div class="formRight">';
				strHtml0 += $("#txtNotaCotizacion").val();
				strHtml0 += '</div>';
				strHtml0 += '<div class="clear">';
				strHtml0 += '</div>';	
		
	
		$("#Nota").html(strHtml0);*/					
			
			alert("Se ha guardado exit\u00f3samente los Datos");
			//window.location.href='listar_cotizacion.html';
		}
		else if (data=="false1")
		alert("Error guardar los Datos, la Descripci\u00f3n de Cotizaci\u00f3n ya existe en el Sistema.");
		else if (data=="false")
		alert("Error guardar los Datos");

		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	})

	}

}

function Buscar_Cotizacion(cotizacion)
{
	//alert($("#hidIdCliente").val());
	//alert(cotizacion);
	
	
	$.post("application/controllers/CotizacionController.php?action=BuscarCotizacion",
	{
		idCotizacion:cotizacion
	},
	function(data) {
				
		$resultArr  = JSON.parse(data);
		
		$("#txtNumeroCotizacion").val($resultArr[0]);
		$("#txtDescripcionCotizacion").val($resultArr[1]);

	});
}

function Buscar_Cliente(cotizacion)
{
	//alert($("#hidIdCliente").val());

	$.post("application/controllers/CotizacionController.php?action=BuscarCliente",
	{
		idCotizacion:cotizacion
	},
	function(data) {
		//alert(data);
		$resultArr  = JSON.parse(data)		
		//alert($resultArr[0]);
		$("#txtNombreCliente").val($resultArr[0]);
		$("#hidIdCliente").val($resultArr[1]);		
	});
}

function Editar_Cotizacion (id_cotizacion)
{
	window.location.href='editar_cotizacion.html?id='+id_cotizacion;
}

function Cargar_Cotizacion(cotizacion)
{
	//alert($("#hidIdCliente").val());

	$.post("application/controllers/CotizacionController.php?action=Buscar_Cotizaciones",
	{
		idCotizacion:cotizacion
	},
	function(data) {
		
		//alert($("#cant_campos").val());
		//$resultArr  = JSON.parse(data);
		
		
		
		//$("#cant_campos").val(parseInt($("#cant_campos").val()) + 1);

		//Calcular_Total_Cotizacion ();

		//var oId = $("#cant_campos").val();
		
		$("#tbDetalle").html(data);	

		$("#cant_campos").val($("[name='txtCantidad[]']").length);
		$("#num_campos").val($("[name='txtCantidad[]']").length);		

		//alert($("#lstCotizacion").val());
		
		$.post("application/controllers/CotizacionController.php?action=Verificar_Administrador",
		function(data){

			if (data == "true")
			{	
				var hidProducto =  new Array();
				hidProducto = $("[name='hidIdProducto[]']");

				var HidProducto = [];
				for (var i = 0; i < hidProducto.length; ++i) {
					HidProducto[i] = hidProducto[i].value;
				}					
					
				if ((jQuery.inArray("timp",HidProducto)) | (jQuery.inArray("tbnr",HidProducto)) | (jQuery.inArray("timpart",HidProducto)))
				{

					for(i=0;i<HidProducto.length;i++)
					{
						if((HidProducto[i] == "timp")|(HidProducto[i] == "tbnr")|(HidProducto[i] == "timpart"))
						{
							$("#txtPrecio"+(i+1)).attr("readonly",false);
							$("#txtPrecio"+(i+1)).attr("title","Precio Sugerido");							
						}
					}

					$("[name='txtPrecio[]']").keydown(function(event){
					//alert(event.keyCode);
						if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
							return true;
						}
						else
						{
							return false;
						}
					});
						
					$("[name='txtPrecio[]']").change(function(){
						
						var oId = $(this).attr('id');
						oId = oId.substr(9);				
					
						$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
						$("#txtPrecio"+oId).attr("title","Precio Especial");
						$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

						$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
						$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
						$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
						Calcular_Total_Cotizacion ();
					});
				}

			}
			else
			{
				if ((jQuery.inArray("timp",HidProducto)) | (jQuery.inArray("tbnr",HidProducto)) | (jQuery.inArray("timpart",HidProducto)))
				{
					for(i=0;i<HidProducto.length;i++)
					{
						if((HidProducto[i] == "timp")|(HidProducto[i] == "tbnr")|(HidProducto[i] == "timpart"))
						{
							$("#txtPrecio"+(i+1)).attr("readonly",true);								
						}
					}
				}
			}
		});			
		
		$.post("application/controllers/CotizacionController.php?action=Buscar_Monto_Total_Cotizaciones_Anteriores",
		{
			idCotizacion:cotizacion
		},
		function(data) {
		
			$("#tbTotal").html(data);	
			//Calcular_Total_Cotizacion ();

			/*if (jQuery.browser.mobile == "true")
			{	
				$("#mainPage").on("pageshow", function(e) {	
					console.log("Ready to bring the awesome.");
					var sugList = $("#suggestions");
					var elementos 
	
					$("#searchField" + oId).on("input", function(e) {
						var text = $(this).val();
						if(text.length < 1) {
							sugList.html("");
							sugList.listview("refresh");
						} else {
							$.get("application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar", {search:text}, function(res,code) {
								var str = "";
								for(var i=0, len=res.length; i<len; i++) {
									str += "<li id='item"+i+"' onclick=\"$('#searchField" + oId + "').val('"+res[i]+"');\" >"+res[i]+"</li>";
								}
								sugList.html(str);
								sugList.listview("refresh");
								console.dir(res);
								console.log("cuantos elementos");
								console.log($("#suggestions li").size());
								console.log(res);
								//elementos = $("#suggestions li").size();
								//console.log($("#suggestions li").click());				
				
		
							},"json");
						}
					});	
	
				});	
			}
			else
			{*/
				
				//$("#txtProducto" + oId).autocomplete({
				$("[name='txtProducto[]']").autocomplete({
					source: "application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar",
					select:  function(event, ui) {
						//alert(ui.item.value);
						//alert($("#txtProducto" + oId).val());
						var oId = $(this).attr('id');
						oId = oId.substr(11);
						
						$("#hidDescProducto" + oId).val(ui.item.value);
						$("#hidIdProducto" + oId).val(ui.item.id_producto);
						$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
						$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
						$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
						$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
						$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				
						Generar_Descripcion_Producto(oId);

						$("[name='txtCantidad[]']").change(function(){
			
							var oId = $(this).attr('id');
							oId = oId.substr(11);
							
							//alert(oId);
							if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == "timp") & ($("#txtCantidad" + oId).val() > 1))
							{
								alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
								$("#txtCantidad" + oId).val('0');			
							}
							else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "timp"))
							{
								alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
								$("#txtCantidad" + oId).val('0');				
							}
							else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "tbnr"))
							{
								alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
								$("#txtCantidad" + oId).val('0');				
							}
							else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "timpart"))
							{
								alert("La cantidad de Trabajo de Impresión debe ser mayor que 0.")
								$("#txtCantidad" + oId).val('0');				
							}				
							else
							{		
								$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
								$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
								$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
								$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
								//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
								Calcular_Total_Cotizacion 
							}

						});	

						$.post("application/controllers/CotizacionController.php?action=Verificar_Administrador",
	 					function(data){

							if (data == "true")
							{
								//if ($("#hidIdProducto"+oId).val() == "timp")
								//{
									$("#txtPrecio"+oId).attr("readonly",false);
									$("#txtPrecio"+oId).attr("title","Precio Sugerido");

									$("#txtPrecio" + oId).keydown(function(event){
									//alert(event.keyCode);
										if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
											return true;
										}
										else
										{
											return false;
										}
									});
							
									$("#txtPrecio" + oId).change(function(){
										$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
										$("#txtPrecio"+oId).attr("title","Precio Especial");
										$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

										$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
										$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
										$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
										Calcular_Total_Cotizacion ();
									});
								//}
							}
							else
							{
								//if ($("#hidIdProducto"+oId).val() == "timp")
								//{
									$("#txtPrecio"+oId).attr("readonly",true);
								//}
							}
						});							
						
						Calcular_Total_Cotizacion ();				
						//BuscarID_Producto(oId);
					},
					change: function (event, ui) {
						
						var oId = $(this).attr('id');
						oId = oId.substr(11);
						
						if (ui.item === null)
						{	
							$("#txtProducto"+oId).val("");
							$("#hidDescProducto" + oId).val("");
							$("#hidIdProducto" + oId).val("");
							$("#txtTipoEmpaque" + oId).val("");
							$("#hidTipoEmpaque" + oId).val("");
							$("#txtPrecio" + oId).val("0.00");
							$("#hidPrecio" + oId).val("0.00");
							$("#txtTotal" + oId).val("0.00");
							$("#hidTotal" + oId).val("0.00");				
						}
						else
						{
							$("#hidDescProducto" + oId).val(ui.item.value);
							$("#hidIdProducto" + oId).val(ui.item.id_producto);
							$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
							$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
							$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
							$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
							$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
					
							Generar_Descripcion_Producto(oId);

							$("[name='txtCantidad[]']").change(function(){
			
								var oId = $(this).attr('id');
								oId = oId.substr(11);
								
								//alert(oId);
								if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == "timp") & ($("#txtCantidad" + oId).val() > 1))
								{
									alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
									$("#txtCantidad" + oId).val('0');			
								}
								else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "timp"))
								{
									alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
									$("#txtCantidad" + oId).val('0');				
								}
								else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "tbnr"))
								{
									alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
									$("#txtCantidad" + oId).val('0');				
								}
								else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "timpart"))
								{
									alert("La cantidad de Trabajo de Impresión debe ser mayor que 0.")
									$("#txtCantidad" + oId).val('0');				
								}				
								else
								{		
									$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
									$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
									$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
									$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
									//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
									Calcular_Total_Cotizacion 
								}

							});	

							$.post("application/controllers/CotizacionController.php?action=Verificar_Administrador",
							function(data){

								if (data == "true")
								{
									//if ($("#hidIdProducto"+oId).val() == "timp")
									//{
										$("#txtPrecio"+oId).attr("readonly",false);
										$("#txtPrecio"+oId).attr("title","Precio Sugerido");

										$("#txtPrecio" + oId).keydown(function(event){
										//alert(event.keyCode);
											if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
												return true;
											}
											else
											{
												return false;
											}
										});
								
										$("#txtPrecio" + oId).change(function(){
											$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
											$("#txtPrecio"+oId).attr("title","Precio Especial");
											$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

											$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
											$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
											$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
											Calcular_Total_Cotizacion ();
										});
									//}
								}
								else
								{
									//if ($("#hidIdProducto"+oId).val() == "timp")
									//{
										$("#txtPrecio"+oId).attr("readonly",true);
									//}
								}
							});							
							
							Calcular_Total_Cotizacion ();				
							//BuscarID_Producto(oId);
						}				
					}
					
	
				});	
	
	
	
			//}
					
			$("[name='txtCantidad[]']").keydown(function(event){
				//alert(event.keyCode);
				if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
					return true;
				}
				else
				{
					return false;
				}
			});		
	
			if ($("#txtTotalFinal").val() == undefined)
			$("#txtTotalFinal").val('0');
	
			$("[name='txtCantidad[]']").change(function(){

				//alert($("[name='txtCantidad[]']").val());
				var oId = $(this).attr('id');
				oId = oId.substr(11);
				
				//alert(oId);
				if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == "timp") & ($("#txtCantidad" + oId).val() > 1))
				{
					alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
					$("#txtCantidad" + oId).val('0');			
				}
				else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "timp"))
				{
					alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
					$("#txtCantidad" + oId).val('0');				
				}
				else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "tbnr"))
				{
					alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
					$("#txtCantidad" + oId).val('0');				
				}
				else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "timpart"))
				{
					alert("La cantidad de Trabajo de Impresión debe ser mayor que 0.")
					$("#txtCantidad" + oId).val('0');				
				}				
				else
				{

			
					$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
					$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
					$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
					//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val()) + parseFloat($("#txtTotalFinal").val())));
					Calcular_Total_Cotizacion ();
					//alert($("#txtTotal" + oId).val());			
				}					
				

			
	
		

			});				
			
		});
	});
}

function Abonar_Cotizacion(oId)
{
	//Cargar_Librerias();
	
	//$.getScript("js/custom-tables.js");
	$.getScript("js/custom-mask.js");	
	//$.getScript("js/funciones.js");	
	
	//alert("Abonar");
	
	var IdCotizacion = $("#hidIdCotizacion" + oId).val();
	var NombreCliente = $("#hidNombreCliente" + oId).val();
	var EstatusCotizacion = $("#hidEstatusCotizacion" + oId).val();	
	var MontoSubTotal = $("#hidMontoSubTotal" + oId).val();
	var MontoITBM = $("#hidMontoITBM" + oId).val();
	var MontoTotal = $("#hidMontoTotal" + oId).val();
	var MontoAbonado = $("#hidMontoAbonado" + oId).val();
	var MontoFaltante = ConvertirMoneda(MontoTotal - MontoAbonado);

	var Id = $("#hdnIdCampos_" + oId).val();
	

		
	//alert(RUC.length);
	var strHtml0 = "<td  align=\"center\">" +  oId + '</td>';		
		strHtml0 += "<td align=\"center\">" + IdCotizacion +'<input type="hidden" id="hidIdCotizacion' + oId + '" name="hidIdCotizacion[]" value="'+ IdCotizacion +'"  /></td>';
	var strHtml1 = "<td>" + NombreCliente +'<input type="hidden" id="hidNombreCliente' + oId + '" name="hidNombreCliente[]" value="'+ NombreCliente +'"  /></td>';		
	var strHtml2 = "<td>" + EstatusCotizacion +'<input type="hidden" id="hidEstatusCotizacion' + oId + '" name="hidEstatusCotizacion[]" value="'+ EstatusCotizacion +'"/></td>';	
	var strHtml3 = "<td>" + MontoSubTotal + '<input type="hidden" id="hidMontoSubTotal' + oId + '" name="hidMontoSubTotal[]" value="'+ MontoSubTotal +'"  /></td>';		
	var strHtml4 = "<td>" + MontoITBM + '<input type="hidden" id="hidMontoITBM' + oId + '" name="hidMontoITBM[]" value="'+ MontoITBM +'"  /></td>';	
	var strHtml5 = "<td>" + MontoTotal + '<input type="hidden" id="hidMontoTotal' + oId + '" name="hidMontoTotal[]" value="'+ MontoTotal +'"  /></td>';
	var strHtml6 = "<td>" + '<input type="text" id="txtMontoAbonado' + oId + '" name="txtMontoAbonado[]" value="'+ MontoFaltante +'"  style="width:50px; text-align:right;" class="validate[required]"  onchange="PrecioMoneda(\'txtMontoAbonado' + oId + '\');"/><span  class="req">*</span><input type="hidden" id="hidMontoAbonado' + oId + '" name="hidMontoAbonado[]" value="'+ MontoAbonado +'"  /></td>';	
	var strHtml7 = '<td><a href="javascript:void(0);" title="Abonar" class="smallButton" style="margin: 5px;" onclick="Ingresar_Abono(' + oId + ')"><img src="public/images/icons/light/check.png" alt="" class="icon" /><span></span></a>';
	strHtml7 += '<a href="javascript:void(0);" title="Cancelar" class="smallButton" style="margin: 5px;" onclick="Cancelar_Ingresar_Abono(' + oId + ')"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
	strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7;
	$("#tbDetalle").append(strHtmlTr);
	//si se agrega el HTML de una sola vez se debe comentar la linea siguiente.
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	
	//alert(oId);
	$("#txtMontoAbonado" + oId).keydown(function(event){
		//alert(event.keyCode);
		if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
			return true;
		}
		else
		{
			return false;
		}
		

	});		
	

}

function Ingresar_Abono(oId)
{
	var Id = $("#hdnIdCampos_" + oId).val();
	var MontoAbonado =  parseFloat($("#txtMontoAbonado" + oId).val());
	var MontoAbonado_Ant =  parseFloat($("#hidMontoAbonado" + oId).val());	
	var MontoTotal =  parseFloat($("#hidMontoTotal" + oId).val());
	
	//alert(Id);
	if ((MontoAbonado + MontoAbonado_Ant) > MontoTotal)
	alert("La Suma de Monto Abonado no debe ser mayor que el Monto Total.");
	else
	{
	
		$.post("application/controllers/CotizacionController.php?action=Ingresar_Abono",
		{
			Monto_Abonado:MontoAbonado,
			Id_Cotizacion:Id		
		
		}, function(data){

			
			if (data=="true")
			{
				alert("Se ha guardado exit\u00f3samente los Datos");
				window.location.href='listar_cotizacion.html';
			}
			else if (data=="false")
			alert("Error guardar los Datos");
		})
	}
}
function Cancelar_Ingresar_Abono(oId)
{
	//Cargar_Librerias();
	
	//$.getScript("js/custom-tables.js");
	$.getScript("js/custom-mask.js");	
	//$.getScript("js/funciones.js");	
	
	var IdCotizacion = $("#hidIdCotizacion" + oId).val();
	var NombreCliente = $("#hidNombreCliente" + oId).val();
	var EstatusCotizacion = $("#hidEstatusCotizacion" + oId).val();	
	var MontoSubTotal = $("#hidMontoSubTotal" + oId).val();
	var MontoITBM = $("#hidMontoITBM" + oId).val();
	var MontoTotal = $("#hidMontoTotal" + oId).val();
	var MontoAbonado = $("#hidMontoAbonado" + oId).val();	

	var Id = $("#hdnIdCampos_" + oId).val();
	

		
	//alert(RUC.length);
	var strHtml0 = "<td  align=\"center\">" +  oId + '</td>';		
		strHtml0 += "<td>" + IdCotizacion +'<input type="hidden" id="hidIdCotizacion' + oId + '" name="hidIdCotizacion[]" value="'+ IdCotizacion +'"  /></td>';
	var strHtml1 = "<td>" + NombreCliente +'<input type="hidden" id="hidNombreCliente' + oId + '" name="hidNombreCliente[]" value="'+ NombreCliente +'"  /></td>';		
	var strHtml2 = "<td>" + EstatusCotizacion +'<input type="hidden" id="hidEstatusCotizacion' + oId + '" name="hidEstatusCotizacion[]" value="'+ EstatusCotizacion +'"/></td>';	
	var strHtml3 = "<td>B/.&nbsp;" + MontoSubTotal + '<input type="hidden" id="hidMontoSubTotal' + oId + '" name="hidMontoSubTotal[]" value="'+ MontoSubTotal +'"  /></td>';		
	var strHtml4 = "<td>B/.&nbsp;" + MontoITBM + '<input type="hidden" id="hidMontoITBM' + oId + '" name="hidMontoITBM[]" value="'+ MontoITBM +'"  /></td>';	
	var strHtml5 = "<td>B/.&nbsp;" + MontoTotal + '<input type="hidden" id="hidMontoTotal' + oId + '" name="hidMontoTotal[]" value="'+ MontoTotal +'"  /></td>';
	var strHtml6 = "<td>B/.&nbsp;" + MontoAbonado +'<input type="hidden" id="hidMontoAbonado' + oId + '" name="hidMontoAbonado[]" value="'+ MontoAbonado +'"  /></td>';	
	var strHtml7 = '<td>';
	
	if ((MontoAbonado / MontoTotal) > 0.25)
	strHtml7 += '<a href="javascript:void(0);" title="Generar Orden de Trabajo" class="smallButton" style="margin: 5px;" onclick="Generar_Orden_de_Trabajo(' + Id + ');"><img src="public/images/icons/color/plus.png" alt="" class="icon" /><span></span></a>';
	else
	strHtml7 += '<a href="javascript:void(0);" title="Abonar Cotizaci&oacute;n" class="smallButton" style="margin: 5px;" onclick="Abonar_Cotizacion(' + oId + ')"><img src="public/images/icons/dark/cart.png" alt="" class="icon" /><span></span></a>';

	strHtml7 += '<a href="javascript:void(0);" title="Editar_Cotizacion" class="smallButton" style="margin: 5px;" onclick="Editar_Cotizacion(' + Id + ')"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
	strHtml7 += '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar esta Cotización?\')){Eliminar_Cotizacion(' + oId + ');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';	
	strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7;
	$("#tbDetalle").append(strHtmlTr);
	//si se agrega el HTML de una sola vez se debe comentar la linea siguiente.
	$("#rowDetalle_" + oId).html(strHtmlFinal);
}

function Modificar_Cotizacion()
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);
	
	var c = 1;
	var msj = "";
	var mensaje = "";
	//alert($("[name='txtCantidad[]']").length);
	while (c <= $("[name='txtCantidad[]']").length)
	{
		if (($("#txtCantidad" + c).val()%2 != 0) & ($("#hidDescProducto" + c).val() == "Trabajo de Imprenta") & ($("#txtCantidad" + c).val()%2 > 1))
		{	
			msj = "- La cantidad de Trabajo de Imprenta de la fila " + c + " debe ser un número par.\n";
			mensaje = msj + mensaje;
			$("#txtCantidad" + c).val('0');
			$("#txtCantidad" + c).focus();
		}
		
		if (($("#txtCantidad" + c).val() == 0))
		{	
			msj = "- La cantidad de Producto o Trabajo de Imprenta o Banner de la fila " + c + " no debe ser 0.\n";
			mensaje = msj + mensaje;
			$("#txtCantidad" + c).focus();
		}		
		
		c = c + 1;
	}
	
	if (mensaje != "")
	{
		alert(mensaje)
					
	}
	else
	{
	var arrCantidad = new Array();
	arrCantidad = $("[name='hidCantidad[]']");
	var ArrCantidad = [];
	for (var i = 0; i < arrCantidad.length; ++i) {
		ArrCantidad[i] = arrCantidad[i].value;
	}

	//StrCantidad = ArrCantidad.toString();
	StrCantidad = JSON.stringify(ArrCantidad);
	
	var arrTipoEmpaque = new Array();
	arrTipoEmpaque = $("[name='hidTipoEmpaque[]']");
	var ArrTipoEmpaque = [];
	for (var i = 0; i < arrTipoEmpaque.length; ++i) {
		ArrTipoEmpaque[i] = arrTipoEmpaque[i].value;
	}

	//StrTipoEmpaque = ArrTipoEmpaque.toString();	
	StrTipoEmpaque = JSON.stringify(ArrTipoEmpaque);
	
	var arrTipoEmpaqueDesc = new Array();
	arrTipoEmpaqueDesc = $("[name='txtTipoEmpaque[]']");
	var ArrTipoEmpaqueDesc = [];
	for (var i = 0; i < arrTipoEmpaqueDesc.length; ++i) {
		ArrTipoEmpaqueDesc[i] = arrTipoEmpaqueDesc[i].value;
	}	
	
	//StrTipoEmpaqueDesc = JSON.stringify(ArrTipoEmpaqueDesc);
	
	var arrProducto = new Array();
	arrProducto = $("[name='hidIdProducto[]']");
	var ArrProducto = [];
	for (var i = 0; i < arrProducto.length; ++i) {
		ArrProducto[i] = arrProducto[i].value;
	}

	//StrProducto = ArrProducto.toString();
	StrProducto = JSON.stringify(ArrProducto);	
	
	var arrIdImprenta = new Array();
	arrIdImprenta = $("[name='hidIdImprenta[]']");
	var ArrIdImprenta = [];
	for (var i = 0; i < arrIdImprenta.length; ++i) {
		ArrIdImprenta[i] = arrIdImprenta[i].value;
	}

	//StrProducto = ArrProducto.toString();
	StrIdImprenta = JSON.stringify(ArrIdImprenta);

	var arrIdBanner = new Array();
	arrIdBanner = $("[name='hidIdBanner[]']");
	var ArrIdBanner = [];
	for (var i = 0; i < arrIdBanner.length; ++i) {
		ArrIdBanner[i] = arrIdBanner[i].value;
	}

	//StrProducto = ArrProducto.toString();
	StrIdBanner = JSON.stringify(ArrIdBanner);
	
	var arrIdImpresion = new Array();
	arrIdImpresion = $("[name='hidIdImpresion[]']");
	var ArrIdImpresion = [];
	for (var i = 0; i < arrIdImpresion.length; ++i) {
		ArrIdImpresion[i] = arrIdImpresion[i].value;
	}

	//StrProducto = ArrProducto.toString();
	StrIdImpresion = JSON.stringify(ArrIdImpresion);	
	
	//alert(StrIdImprenta);	
	//alert(StrIdBanner);
	//alert(StrIdImpresion);
	
	var arrProductoDesc = new Array();
	arrProductoDesc = $("[name='hidDescProducto[]']");
	var ArrProductoDesc = [];
	for (var i = 0; i < arrProductoDesc.length; ++i) {
		ArrProductoDesc[i] = arrProductoDesc[i].value;
	}	
	
	//StrProductoDesc = JSON.stringify(ArrProductoDesc);	
	
	var arrPrecio = new Array();
	arrPrecio = $("[name='hidPrecio[]']");
	var ArrPrecio = [];
	for (var i = 0; i < arrPrecio.length; ++i) {
		ArrPrecio[i] = arrPrecio[i].value;
	}

	//StrPrecio = ArrPrecio.toString();	
	StrPrecio = JSON.stringify(ArrPrecio);
	
	var arrDescripcionImprenta = new Array();
	arrDescripcionImprenta = $("[name='hdnDescripcionImprenta[]']");
	var ArrDescripcionImprenta = [];
	for (var i = 0; i < arrDescripcionImprenta.length; ++i) {
		ArrDescripcionImprenta[i] = arrDescripcionImprenta[i].value;
	}

	//StrDescripcionImprenta = ArrDescripcionImprenta.toString();	
	StrDescripcionImprenta = JSON.stringify(ArrDescripcionImprenta);
	
	var arrPapelTipo = new Array();
	arrPapelTipo = $("[name='hdnPapelTipo[]']");
	var ArrPapelTipo = [];
	for (var i = 0; i < arrPapelTipo.length; ++i) {
		ArrPapelTipo[i] = arrPapelTipo[i].value;
	}

	//StrPapelTipo = ArrPapelTipo.toString();	
	StrPapelTipo = JSON.stringify(ArrPapelTipo);
	
	var arrMaterialPapelTipo = new Array();
	arrMaterialPapelTipo = $("[name='hdnMaterialPapelTipo[]']");
	var ArrMaterialPapelTipo = [];
	for (var i = 0; i < arrMaterialPapelTipo.length; ++i) {
		ArrMaterialPapelTipo[i] = arrMaterialPapelTipo[i].value;
	}

	//StrMaterialPapelTipo = ArrMaterialPapelTipo.toString();	
	StrMaterialPapelTipo = JSON.stringify(ArrMaterialPapelTipo);
	
	var arrResmaTamano = new Array();
	arrResmaTamano = $("[name='hdnResmaTamano[]']");
	var ArrResmaTamano = [];
	for (var i = 0; i < arrResmaTamano.length; ++i) {
		ArrResmaTamano[i] = arrResmaTamano[i].value;
	}

	//StrResmaTamano = ArrResmaTamano.toString();	
	StrResmaTamano = JSON.stringify(ArrResmaTamano);
	
	var arrTamano = new Array();
	arrTamano = $("[name='hdnTamano[]']");
	var ArrTamano = [];
	for (var i = 0; i < arrTamano.length; ++i) {
		ArrTamano[i] = arrTamano[i].value;
	}

	//StrTamano = ArrTamano.toString();	
	StrTamano = JSON.stringify(ArrTamano);
	
	var arrOtroTamanoAncho = new Array();
	arrOtroTamanoAncho = $("[name='hdnOtroTamanoAncho[]']");
	var ArrOtroTamanoAncho = [];
	for (var i = 0; i < arrOtroTamanoAncho.length; ++i) {
		ArrOtroTamanoAncho[i] = arrOtroTamanoAncho[i].value;
	}

	//StrOtroTamanoAncho = ArrOtroTamanoAncho.toString();		
	StrOtroTamanoAncho = JSON.stringify(ArrOtroTamanoAncho);
	
	var arrOtroTamanoLargo = new Array();
	arrOtroTamanoLargo = $("[name='hdnOtroTamanoLargo[]']");
	var ArrOtroTamanoLargo = [];
	for (var i = 0; i < arrOtroTamanoLargo.length; ++i) {
		ArrOtroTamanoLargo[i] = arrOtroTamanoLargo[i].value;
	}

	//StrOtroTamanoLargo = ArrOtroTamanoLargo.toString();	
	StrOtroTamanoLargo = JSON.stringify(ArrOtroTamanoLargo);
	
	var arrNumeracionInicio = new Array();
	arrNumeracionInicio = $("[name='hdnNumeracionInicio[]']");
	var ArrNumeracionInicio = [];
	for (var i = 0; i < arrNumeracionInicio.length; ++i) {
		ArrNumeracionInicio[i] = arrNumeracionInicio[i].value;
	}
	
	//StrNumeracionInicio = ArrNumeracionInicio.toString();	
	StrNumeracionInicio = JSON.stringify(ArrNumeracionInicio);

	
	var arrNumeracionFinal = new Array();
	arrNumeracionFinal = $("[name='hdnNumeracionFinal[]']");
	var ArrNumeracionFinal = [];
	for (var i = 0; i < arrNumeracionFinal.length; ++i) {
		ArrNumeracionFinal[i] = arrNumeracionFinal[i].value;
	}

	//StrNumeracionFinal = ArrNumeracionFinal.toString();	
	StrNumeracionFinal = JSON.stringify(ArrNumeracionFinal);
	
	var arrCantidadCopia = new Array();
	arrCantidadCopia = $("[name='hdnCantidadCopia[]']");
	var ArrCantidadCopia = [];
	for (var i = 0; i < arrCantidadCopia.length; ++i) {
		ArrCantidadCopia[i] = arrCantidadCopia[i].value;
	}	

	//StrCantidadCopia = ArrCantidadCopia.toString();		
	StrCantidadCopia = JSON.stringify(ArrCantidadCopia);
	
	var arrColorPapel = new Array();
	var arrColorPapel = new Array();
	arrColorPapel = $("[name='hdnColorPapel[]']");
	var ArrColorPapel = [];
	for (var i = 0; i < arrColorPapel.length; ++i) {
	ArrColorPapel[i] = arrColorPapel[i].value;
	}
	
	//StrColorPapel = ArrColorPapel.toString();	
	StrColorPapel = JSON.stringify(ArrColorPapel);
	
	var arrColorPapel1 = new Array();
	var arrColorPapel1 = new Array();
	arrColorPapel1 = $("[name='hdnColorPapel1[]']");
	var ArrColorPapel1 = [];
	for (var i = 0; i < arrColorPapel1.length; ++i) {
	ArrColorPapel1[i] = arrColorPapel1[i].value;
	}
	
	//StrColorPapel1 = ArrColorPapel1.toString();	
	StrColorPapel1 = JSON.stringify(ArrColorPapel1);
	
	var arrColorPapel2 = new Array();
	var arrColorPapel2 = new Array();
	arrColorPapel2 = $("[name='hdnColorPapel2[]']");
	var ArrColorPapel2 = [];
	for (var i = 0; i < arrColorPapel2.length; ++i) {
	ArrColorPapel2[i] = arrColorPapel2[i].value;
	}
	
	//StrColorPapel2 = ArrColorPapel2.toString();	
	StrColorPapel2 = JSON.stringify(ArrColorPapel2);
	
	var arrColorPapel3 = new Array();
	var arrColorPapel3 = new Array();
	arrColorPapel3 = $("[name='hdnColorPapel3[]']");
	var ArrColorPapel3 = [];
	for (var i = 0; i < arrColorPapel3.length; ++i) {
	ArrColorPapel3[i] = arrColorPapel3[i].value;
	}
	
	//StrColorPapel3 = ArrColorPapel3.toString();		
	StrColorPapel3 = JSON.stringify(ArrColorPapel3);	
	
	var arrColorTinta = new Array();
	arrColorTinta = $("[name='hdnColorTinta[]']");
	var ArrColorTinta = [];
	for (var i = 0; i < arrColorTinta.length; ++i) {
		ArrColorTinta[i] = arrColorTinta[i].value;
	}

	//StrColorTinta = ArrColorTinta.toString();		
	StrColorTinta = JSON.stringify(ArrColorTinta);
	
	var arrTipoForro = new Array();
	arrTipoForro = $("[name='hdnTipoForro[]']");
	var ArrTipoForro = [];
	for (var i = 0; i < arrTipoForro.length; ++i) {
		ArrTipoForro[i] = arrTipoForro[i].value;
	}

	//StrTipoForro = ArrTipoForro.toString();		
	StrTipoForro = JSON.stringify(ArrTipoForro);
	
	var arrTiempo = new Array();
	arrTiempo = $("[name='hdnTiempo[]']");
	var ArrTiempo = [];
	for (var i = 0; i < arrTiempo.length; ++i) {
		ArrTiempo[i] = arrTiempo[i].value;
	}

	//StrTiempo = ArrTiempo.toString();		
	StrTiempo = JSON.stringify(ArrTiempo);
	
	var arrTipoTiempo = new Array();
	arrTipoTiempo = $("[name='hdnTipoTiempo[]']");
	var ArrTipoTiempo = [];
	for (var i = 0; i < arrTipoTiempo.length; ++i) {
		ArrTipoTiempo[i] = arrTipoTiempo[i].value;
	}

	//StrTipoTiempo = ArrTipoTiempo.toString();
	StrTipoTiempo = JSON.stringify(ArrTipoTiempo);
	
	var arrTipoCategoria = new Array();
	arrTipoCategoria = $("[name='hdnTipoCategoria[]']");
	var ArrTipoCategoria = [];
	for (var i = 0; i < arrTipoCategoria.length; ++i) {
		ArrTipoCategoria[i] = arrTipoCategoria[i].value;
	}

	//StrTipoCategoria = ArrTipoCategoria.toString();	
	StrTipoCategoria = JSON.stringify(ArrTipoCategoria);
	
	var arrExentoITBM = new Array();
	arrExentoITBM = $("[name='hdnExentoITBM[]']");
	var ArrExentoITBM = [];
	for (var i = 0; i < arrExentoITBM.length; ++i) {
		ArrExentoITBM[i] = arrExentoITBM[i].value;
	}
	
	//StrExentoITBM = ArrExentoITBM.toString();	
	StrExentoITBM = JSON.stringify(ArrExentoITBM);
	
	var arrArte = new Array();
	arrArte = $("[name='hdnArte[]']");
	var ArrArte = [];
	for (var i = 0; i < arrArte.length; ++i) {
		ArrArte[i] = arrArte[i].value;
	}
	
	//StrArte = ArrArte.toString();		
	StrArte = JSON.stringify(ArrArte);
	
	var arrPlaca = new Array();
	arrPlaca = $("[name='hdnPlaca[]']");
	var ArrPlaca = [];
	for (var i = 0; i < arrPlaca.length; ++i) {
		ArrPlaca[i] = arrPlaca[i].value;
	}
	
	//StrPlaca = ArrPlaca.toString();
	StrPlaca = JSON.stringify(ArrPlaca);
	
	var arrNotaCotizacion = new Array();
	arrNotaCotizacion = $("[name='hdnNotaCotizacion[]']");
	var ArrNotaCotizacion= [];
	for (var i = 0; i < arrNotaCotizacion.length; ++i) {
		ArrNotaCotizacion[i] = arrNotaCotizacion[i].value;
	}

	//StrNotaCotizacion = ArrNotaCotizacion.toString();
	StrNotaCotizacion = JSON.stringify(ArrNotaCotizacion);
	//alert(StrNotaCotizacion);
	
	var arrDescripcionBanner = new Array();
	arrDescripcionBanner = $("[name='hdnDescripcionBanner[]']");
	var ArrDescripcionBanner = [];
	for (var i = 0; i < arrDescripcionBanner.length; ++i) {
		ArrDescripcionBanner[i] = arrDescripcionBanner[i].value;
	}

	//StrDescripcionBanner = ArrDescripcionBanner.toString();	
	StrDescripcionBanner = JSON.stringify(ArrDescripcionBanner);
	
	var arrMaterialBanner = new Array();
	arrMaterialBanner = $("[name='hdnMaterialBanner[]']");
	var ArrMaterialBanner = [];
	for (var i = 0; i < arrMaterialBanner.length; ++i) {
		ArrMaterialBanner[i] = arrMaterialBanner[i].value;
	}

	//StrMaterialBanner = ArrMaterialBanner.toString();		
	StrMaterialBanner = JSON.stringify(ArrMaterialBanner);
	
	var arrAncho = new Array();
	arrAncho = $("[name='hdnAncho[]']");
	var ArrAncho = [];
	for (var i = 0; i < arrAncho.length; ++i) {
		ArrAncho[i] = arrAncho[i].value;
	}

	//StrAncho = ArrAncho.toString();	
	StrAncho = JSON.stringify(ArrAncho);
	
	var arrAnchoMedida = new Array();
	arrAnchoMedida = $("[name='hdnAnchoMedida[]']");
	var ArrAnchoMedida = [];
	for (var i = 0; i < arrAnchoMedida.length; ++i) {
		ArrAnchoMedida[i] = arrAnchoMedida[i].value;
	}

	//StrAnchoMedida = ArrAnchoMedida.toString();
	StrAnchoMedida = JSON.stringify(ArrAnchoMedida);
	
	var arrLargo = new Array();
	arrLargo = $("[name='hdnLargo[]']");
	var ArrLargo = [];
	for (var i = 0; i < arrLargo.length; ++i) {
		ArrLargo[i] = arrLargo[i].value;
	}

	//StrLargo = ArrLargo.toString();	
	StrLargo = JSON.stringify(ArrLargo);
	//alert($("[name='hdnLargoMedida[]']").length);
	
	var arrLargoMedida = new Array();
	arrLargoMedida = $("[name='hdnLargoMedida[]']");
	var ArrLargoMedida = [];
	for (var i = 0; i < arrLargoMedida.length; ++i) {
		ArrLargoMedida[i] = arrLargoMedida[i].value;
	}

	//StrLargoMedida = ArrLargoMedida.toString();	
	StrLargoMedida = JSON.stringify(ArrLargoMedida);
	
	var arrAreaTotal = new Array();
	arrAreaTotal = $("[name='hdnAreaTotal[]']");
	var ArrAreaTotal = [];
	for (var i = 0; i < arrAreaTotal.length; ++i) {
		ArrAreaTotal[i] = arrAreaTotal[i].value;
	}

	//StrAreaTotal = ArrAreaTotal.toString();		
	StrAreaTotal = JSON.stringify(ArrAreaTotal);
	
	var arrFormaPago = new Array();
	arrFormaPago = $("[name='hdnFormaPago[]']");
	var ArrFormaPago = [];
	for (var i = 0; i < arrFormaPago.length; ++i) {
		ArrFormaPago[i] = arrFormaPago[i].value;
	}

	//StrFormaPago = ArrFormaPago.toString();		
	StrFormaPago = JSON.stringify(ArrFormaPago);
	
	var arrCalidadBanner = new Array();
	arrCalidadBanner = $("[name='hdnCalidadBanner[]']");
	var ArrCalidadBanner = [];
	for (var i = 0; i < arrCalidadBanner.length; ++i) {
		ArrCalidadBanner[i] = arrCalidadBanner[i].value;
	}

	//StrCalidadBanner = ArrCalidadBanner.toString();			
	StrCalidadBanner = JSON.stringify(ArrCalidadBanner);
	
	var arrPrecioInstalacion = new Array();
	arrPrecioInstalacion = $("[name='hdnPrecioInstalacion[]']");
	var ArrPrecioInstalacion = [];
	for (var i = 0; i < arrPrecioInstalacion.length; ++i) {
		ArrPrecioInstalacion[i] = arrPrecioInstalacion[i].value;
	}

	//StrPrecioInstalacion = ArrPrecioInstalacion.toString();
	StrPrecioInstalacion = JSON.stringify(ArrPrecioInstalacion);
	
	var arrPrecioRecorte = new Array();
	arrPrecioRecorte = $("[name='hdnPrecioRecorte[]']");
	var ArrPrecioRecorte = [];
	for (var i = 0; i < arrPrecioRecorte.length; ++i) {
		ArrPrecioRecorte[i] = arrPrecioRecorte[i].value;
	}

	//StrPrecioRecorte = ArrPrecioRecorte.toString();
	StrPrecioRecorte = JSON.stringify(ArrPrecioRecorte);
	
	var arrPrecioArte = new Array();
	arrPrecioArte = $("[name='hdnPrecioArte[]']");
	var ArrPrecioArte = [];
	for (var i = 0; i < arrPrecioArte.length; ++i) {
		ArrPrecioArte[i] = arrPrecioArte[i].value;
	}

	//StrPrecioArte = ArrPrecioArte.toString();
	StrPrecioArte = JSON.stringify(ArrPrecioArte);
	
	var arrPrecioRotulado = new Array();
	arrPrecioRotulado = $("[name='hdnPrecioRotulado[]']");
	var ArrPrecioRotulado = [];
	for (var i = 0; i < arrPrecioRotulado.length; ++i) {
		ArrPrecioRotulado[i] = arrPrecioRotulado[i].value;
	}

	//StrPrecioRotulado = ArrPrecioRotulado.toString();
	StrPrecioRotulado = JSON.stringify(ArrPrecioRotulado);
	
	var arrPrecioBasta = new Array();
	arrPrecioBasta = $("[name='hdnPrecioBasta[]']");
	var ArrPrecioBasta = [];
	for (var i = 0; i < arrPrecioBasta.length; ++i) {
		ArrPrecioBasta[i] = arrPrecioBasta[i].value;
	}

	//StrPrecioBasta = ArrPrecioBasta.toString();	
	StrPrecioBasta = JSON.stringify(ArrPrecioBasta);
	
	var arrPrecioOjete = new Array();
	arrPrecioOjete = $("[name='hdnPrecioOjete[]']");
	var ArrPrecioOjete = [];
	for (var i = 0; i < arrPrecioOjete.length; ++i) {
		ArrPrecioOjete[i] = arrPrecioOjete[i].value;
	}

	//StrPrecioOjete = ArrPrecioOjete.toString();	
	StrPrecioOjete = JSON.stringify(ArrPrecioOjete);
	
	var arrPrecioBulcaniza = new Array();
	arrPrecioBulcaniza = $("[name='hdnPrecioBulcaniza[]']");
	var ArrPrecioBulcaniza = [];
	for (var i = 0; i < arrPrecioBulcaniza.length; ++i) {
		ArrPrecioBulcaniza[i] = arrPrecioBulcaniza[i].value;
	}

	//StrPrecioBulcaniza = ArrPrecioBulcaniza.toString();		
	StrPrecioBulcaniza = JSON.stringify(ArrPrecioBulcaniza);
	
	var arrDescripcionImpresion = new Array();
	arrDescripcionImpresion = $("[name='hdnDescripcionImpresion[]']");
	var ArrDescripcionImpresion= [];
	for (var i = 0; i < arrDescripcionImpresion.length; ++i) {
		ArrDescripcionImpresion[i] = arrDescripcionImpresion[i].value;
	}

	StrDescripcionImpresion = JSON.stringify(ArrDescripcionImpresion);
	
	var arrMaterialImpresion = new Array();
	arrMaterialImpresion = $("[name='hdnMaterialImpresion[]']");
	var ArrMaterialImpresion= [];
	for (var i = 0; i < arrMaterialImpresion.length; ++i) {
		ArrMaterialImpresion[i] = arrMaterialImpresion[i].value;
	}

	StrMaterialImpresion = JSON.stringify(ArrMaterialImpresion);

	var arrRecorte = new Array();
	arrRecorte = $("[name='hdnRecorte[]']");
	var ArrRecorte= [];
	for (var i = 0; i < arrRecorte.length; ++i) {
		ArrRecorte[i] = arrRecorte[i].value;
	}

	StrRecorte = JSON.stringify(ArrRecorte);	
	
	var arrPlastificado = new Array();
	arrPlastificado = $("[name='hdnPlastificado[]']");
	var ArrPlastificado= [];
	for (var i = 0; i < arrPlastificado.length; ++i) {
		ArrPlastificado[i] = arrPlastificado[i].value;
	}

	StrPlastificado = JSON.stringify(ArrPlastificado);
	
	var arrCaminado = new Array();
	arrCaminado = $("[name='hdnCaminado[]']");
	var ArrCaminado= [];
	for (var i = 0; i < arrPlastificado.length; ++i) {
		ArrCaminado[i] = arrCaminado[i].value;
	}

	StrCaminado = JSON.stringify(ArrCaminado);
	
	var arrRealce = new Array();
	arrRealce = $("[name='hdnRealce[]']");
	var ArrRealce= [];
	for (var i = 0; i < arrRealce.length; ++i) {
		ArrRealce[i] = arrRealce[i].value;
	}

	StrRealce = JSON.stringify(ArrRealce);	
	
	var arrDoblado = new Array();
	arrDoblado = $("[name='hdnDoblado[]']");
	var ArrDoblado= [];
	for (var i = 0; i < arrDoblado.length; ++i) {
		ArrDoblado[i] = arrDoblado[i].value;
	}

	StrDoblado = JSON.stringify(ArrDoblado);		

	var arrRepujado = new Array();
	arrRepujado = $("[name='hdnRepujado[]']");
	var ArrRepujado= [];
	for (var i = 0; i < arrRepujado.length; ++i) {
		ArrRepujado[i] = arrRepujado[i].value;
	}

	StrRepujado = JSON.stringify(ArrRepujado);
	
	var arrEngrapado = new Array();
	arrEngrapado = $("[name='hdnEngrapado[]']");
	var ArrEngrapado= [];
	for (var i = 0; i < arrEngrapado.length; ++i) {
		ArrEngrapado[i] = arrEngrapado[i].value;
	}

	StrEngrapado = JSON.stringify(ArrEngrapado);

	var arrUV = new Array();
	arrUV = $("[name='hdnUV[]']");
	var ArrUV= [];
	for (var i = 0; i < arrUV.length; ++i) {
		ArrUV[i] = arrUV[i].value;
	}

	StrUV = JSON.stringify(ArrUV);	

	var arrCantPliego = new Array();
	arrCantPliego = $("[name='hdnCantPliego[]']");
	var ArrCantPliego= [];
	for (var i = 0; i < arrCantPliego.length; ++i) {
		ArrCantPliego[i] = arrCantPliego[i].value;
	}

	StrCantPliego = JSON.stringify(ArrCantPliego);
	
	var arrAjustarTamano = new Array();
	arrAjustarTamano = $("[name='hdnAjustarTamano[]']");
	var ArrAjustarTamano= [];
	for (var i = 0; i < arrAjustarTamano.length; ++i) {
		ArrAjustarTamano[i] = arrAjustarTamano[i].value;
	}

	StrAjustarTamano = JSON.stringify(ArrAjustarTamano);	
	
	//alert(StrColorPapel);		
	//alert(StrColorPapel1);
	//alert(StrColorPapel2);		
	//alert(StrColorPapel3);
	//alert(StrOtroTamanoAncho);	
	
	//alert('prueba');
	
	$.post("application/controllers/CotizacionController.php?action=Modificar_Cotizacion",
	{
	
		NumeroCotizacion:$("#txtNumeroCotizacion").val(),
		NombreCliente:$("#txtNombreCliente").val(),
		DescripcionCotizacion:$("#txtDescripcionCotizacion").val(),
		//NotaCotizacion:$("#txtNotaCotizacion").val(),
		Cantidad:StrCantidad,
		Producto:StrProducto,
		IdImprenta:StrIdImprenta,
		IdBanner:StrIdBanner,
		IdImpresion:StrIdImpresion,
		Precio:StrPrecio,
		DescripcionImprenta:StrDescripcionImprenta,		
		PapelTipo:StrPapelTipo,
		MaterialPapelTipo:StrMaterialPapelTipo,
		ResmaTamano:StrResmaTamano,		
		Tamano:StrTamano,
		OtroTamanoAncho:StrOtroTamanoAncho,		
		OtroTamanoLargo:StrOtroTamanoLargo,
		NumeracionInicio:StrNumeracionInicio,		
		NumeracionFinal:StrNumeracionFinal,		
		CantidadCopia:StrCantidadCopia,
		ColorTinta:StrColorTinta,
		ColorPapel:StrColorPapel,
		ColorPapel1:StrColorPapel1,
		ColorPapel2:StrColorPapel2,
		ColorPapel3:StrColorPapel3,		
		TipoForro:StrTipoForro,
		Tiempo:StrTiempo,
		TipoTiempo:StrTipoTiempo,
		TipoCategoria:StrTipoCategoria,
		ExentoITBM:StrExentoITBM,
		Arte:StrArte,
		Placa:StrPlaca,		
		NotaCotizacion:StrNotaCotizacion,
		DescripcionBanner:StrDescripcionBanner,		
		MaterialBanner:StrMaterialBanner,
		Ancho:StrAncho,		
		AnchoMedida:StrAnchoMedida,
		Largo:StrLargo,		
		LargoMedida:StrLargoMedida,
		AreaTotal:StrAreaTotal,		
		FormaPago:StrFormaPago,		
		CalidadBanner:StrCalidadBanner,
		PrecioInstalacion:StrPrecioInstalacion,		
		PrecioRecorte:StrPrecioRecorte,
		PrecioArte:StrPrecioArte,		
		PrecioRotulado:StrPrecioRotulado,		
		PrecioBasta:StrPrecioBasta,
		PrecioOjete:StrPrecioOjete,		
		PrecioBulcaniza:StrPrecioBulcaniza,
		DescripcionImpresion:StrDescripcionImpresion,	
		MaterialImpresion:StrMaterialImpresion,
		Recorte:StrRecorte,
		Plastificado:StrPlastificado,
		Caminado:StrCaminado,
		Realce:StrRealce,
		Doblado:StrDoblado,
		Repujado:StrRepujado,
		Engrapado:StrEngrapado,
		UV:StrUV,
		CantPliego:StrCantPliego,
		AjustarTamano:StrAjustarTamano,
		SubTotal:$("#txtSubTotal").val(),
		TotalITBM:$("#txtTotalITBM").val(),
		TotalFinal:$("#txtTotalFinal").val()
		
	}, function(data){

		//alert(data);
		//alert(arrCantidad.length);

		if (jQuery.browser.mobile == "true")
		{			
			var strHtml0 = '<div data-role="page" id="mainPage"><p>';
				strHtml0 += '<label>Nombre del Cliente:</label>';
				strHtml0 += '<div class="formRight">';
				strHtml0 += $("#txtNombreCliente").val();
				strHtml0 += '</div>';
				strHtml0 += '<div class="clear">';
				strHtml0 += '</div>';	
			var strHtml1 = '<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';
				strHtml1 += '<div data-role="page" id="mainPage"><p>';
				strHtml1 += '<label>Descripci&oacute;n de Cotizaci&oacute;n:</label>';
				strHtml1 += '<div class="formRight">';
				strHtml1 += $("#txtDescripcionCotizacion").val();
				strHtml1 += '</div>';
				strHtml1 += '<div class="clear">';
				strHtml1 += '</div>';	
				strHtml1 += '<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';				
		}
		else
		{
			var strHtml0 = '<label>Nombre del Cliente:</label>';
				strHtml0 += '<div class="formRight">';
				strHtml0 += $("#txtNombreCliente").val();
				strHtml0 += '</div>';
				strHtml0 += '<div class="clear">';
				strHtml0 += '</div>';
			var strHtml1 = '<label>Descripci&oacute;n de Cotizaci&oacute;n:</label>';
				strHtml1 += '<div class="formRight">';
				strHtml1 += $("#txtDescripcionCotizacion").val();
				strHtml1 += '</div>';
				strHtml1 += '<div class="clear">';
				strHtml1 += '</div>';				
		}	
	
		$("#NombreCliente").html(strHtml0);		
		
		$("#DescripcionCotizacion").html(strHtml1);	

		
		$.post("application/controllers/CotizacionController.php?action=Generar_Listar_Contactos",
		{	
			id:data
		}, function(data1){
		
			//alert(data1);
			if (data1 != "undefined")
			{
				$('#Contactos').show();
				$("#Contactos").html(data1);
			}
			else
			{
				$('#Contactos').hide();
			
			}
		});
		

		
		var strHtmlHead= '<tr><td width="2%"></td>';	
		strHtmlHead += '<td width="15%">Cantidad<input type="hidden" id="num_campos" name="num_campos" value="0"/></td>';
		strHtmlHead += '<td width="15%">Tipo de Empaque<input type="hidden" id="cant_campos" name="num_campos" value="0"/></td>';
		strHtmlHead += '<td width="38%">Producto</td>';	
		strHtmlHead += '<td width="15%">Precio</td>';		
		strHtmlHead += '<td width="15%">Total</td></tr>';
		
		var strHtmlTrHead = strHtmlHead;
		
		$("#tbHead").html(strHtmlTrHead);
		
		if (data!="false")
		{
			var oId,c;
			oId = 1;
			c = 0;
		
			//alert(ArrProductoDesc.length);
			//alert(arrCantidad.length);
			
			while (c < arrCantidad.length)
			{
			
				//alert(c);
				//alert(oId);
				//alert(ArrPrecio[c]);
				//alert(ArrCantidad[c]);
			
				//$("#rowDetalle_" + oId).remove();										
				var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
				var strHtml1 = '<td colspan="6"><table width="100%">';
					strHtml1 += '<tr>';
				var strHtml2 = '<td width="15%" align="center">' + ArrCantidad[c] + '</td>';
				var strHtml3 = '<td width="15%" align="center">'  + ArrTipoEmpaqueDesc[c] +  '</td>';	
				//var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtProducto' + oId + '" name="txtProducto[]" value="" style="width:80%;" class="maskCelular validate[required]" /><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value=""  /></td>';
				var strHtml4 = '<td width="32%">' + ArrProductoDesc[c] + '</td>';
				var strHtml5 = '<td width="15%" align="right">'  + ConvertirMoneda(ArrPrecio[c]) +  '</td>';
				var strHtml6 = '<td width="15%" align="right">' +  ConvertirMoneda(parseFloat(ArrCantidad[c]*ArrPrecio[c])) + '</td>';

				//var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					//strHtml7 += '<input type="hidden" id="hdnPapelTipo' + oId +'" name="hdnPapelTipo[]" value="' + PapelTipo + '" />';
					//strHtml7 += '<input type="hidden" id="hdnMaterialPapelTipo' + oId +'" name="hdnMaterialPapelTipo[]" value="' + MaterialPapelTipo + '" />';
					//strHtml7 += '<input type="hidden" id="hdnTamano' + oId +'" name="hdnTamano[]" value="' + Tamano + '" />';			
					//strHtml7 += '<input type="hidden" id="hdnCantidadCopia' + oId +'" name="hdnCantidadCopia[]" value="' + CantidadCopia + '" />';
					//strHtml7 += '<input type="hidden" id="hdnColorTinta' + oId +'" name="hdnColorTinta[]" value="' + ColorTinta + '" />';
					//var c = 0;
			
					//while (c <= 3)
					//{
						//if (c == 0)
						//strHtml7 += '<input type="hidden" id="hdnColorPapel' + oId + '" name="hdnColorPapel[]" value="' + ColorPapel[c] + '" />';					
						//else
						//strHtml7 += '<input type="hidden" id="hdnColorPapel' + c + oId +'" name="hdnColorPapel' + c + '[]" value="' + ColorPapel[c] + '" />';
				
						//c = c + 1;
					//}
					//strHtml7 += '<input type="hidden" id="hdnTipoForro' + oId +'" name="hdnTipoForro[]" value="' + TipoForro + '" />';			
					//strHtml7 += '<input type="hidden" id="hdnTiempo' + oId +'" name="hdnTiempo[]" value="' + Tiempo + '" />';
					//strHtml7 += '<input type="hidden" id="hdnTipoTiempo' + oId +'" name="hdnTipoTiempo[]" value="' + TipoTiempo + '" />';
					//strHtml7 += '<input type="hidden" id="hdnTipoCategoria' + oId +'" name="hdnTipoCategoria[]" value="' + TipoCategoria + '" />';				
					//strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
				var strHtml8 = '<tr><td colspan "5"></td></tr>';				
				var strHtml9 = '</tr>';
				strHtml9 += '</table></td>';	
				var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
				var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml8 + strHtml9 //+ strHtml7 ;	

				//$("#tbDetalle").replaceWith(strHtmlTr);		
	
				$("#rowDetalle_" + oId).html(strHtmlFinal);				
				oId = oId + 1;
				c = c + 1;
			
			
			}
			
			var strHtmlSubTotal0= '<td  align="right" colspan="5">Sub-Total:</td>';	
			var strHtmlSubTotal1 = '<td align="right" >' + $("#txtSubTotal").val() + '</td>';
			var strHtmlSubTotal2= '<td  align="center"></td>';	
			var strHtmlTotalITBM0= '<td  align="right" colspan="5">ITBMS:</td>';	
			var strHtmlTotalITBM1 = '<td align="right" >' + $("#txtTotalITBM").val() + '</td>';
			var strHtmlTotalITBM2= '<td  align="center"></td>';		
			var strHtmlTotal0= '<td  align="right" colspan="5">Total Final:</td>';	
			var strHtmlTotal1 = '<td align="right" >' + $("#txtTotalFinal").val() + '</td>';
			var strHtmlTotal2= '<td  align="center"></td>';
			var strHtmlTrSubTotal = '<tr id="rowSubTotal"  valign="center"  ></tr>';
			var strHtmlTrTotalITBM = '<tr id="rowTotalITBM"  valign="center"  ></tr>';
			var strHtmlTrTotal = '<tr id="rowTotal"  valign="center"  ></tr>';
	
			var strHtmlTrFinalSubTotal = strHtmlSubTotal0 + strHtmlSubTotal1 + strHtmlSubTotal2;	
			var strHtmlFinalTotalITBM = strHtmlTotalITBM0 + strHtmlTotalITBM1 + strHtmlTotalITBM2;	
			var strHtmlFinalTotal = strHtmlTotal0 + strHtmlTotal1 + strHtmlTotal2;

			$("#tbTotal").append(strHtmlTrSubTotal);
			$("#tbTotal").append(strHtmlTrTotalITBM);
			$("#tbTotal").append(strHtmlTrTotal);
			$("#rowSubTotal").html(strHtmlTrFinalSubTotal);
			$("#rowTotalITBM").html(strHtmlFinalTotalITBM);	
			$("#rowTotal").html(strHtmlFinalTotal);						
		
			var strHtmlAgregarCotizacion= '<input type="button" value="Imprimir Cotizaci&oacute;n" class="redB" onclick="Imprimir_Cotizacion(\''+ data +'\');"/>&nbsp;&nbsp;<input type="button" value="Enviar Cotizaci&oacute;n" class="redB" onclick="Enviar_Cotizacion(\''+ data +'\');"/>';	
			$("#ModificarCotizacion").html(strHtmlAgregarCotizacion);	
			
			/*var strHtml0 = '<label>Nota:</label>';
				strHtml0 += '<div class="formRight">';
				strHtml0 += $("#txtNotaCotizacion").val();
				strHtml0 += '</div>';
				strHtml0 += '<div class="clear">';
				strHtml0 += '</div>';	
		
	
		$("#Nota").html(strHtml0);*/					
			
			alert("Se ha guardado exit\u00f3samente los Datos");
			//window.location.href='listar_cotizacion.html';
		}
		else if (data=="false")
		alert("Error guardar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	})

	}
}

function Eliminar_Cotizacion(oId)
{
	var Id = $("#hdnIdCampos_" + oId).val();
	//alert(Id);
	$.post("application/controllers/CotizacionController.php?action=Eliminar_Cotizacion",
	{
		IdCotizacion:Id	
		
	}, function(data){

		
		if (data=="true")
		{
			$("#rowDetalle_" + oId).remove();			
			alert("Se ha eliminado exit\u00f3samente los Datos");
			window.location.href='listar_cotizacion.html';
		}
		else if (data=="false")
		alert("Error eliminar los Datos");
	})
	
	return false;
}

function Listar_Cotizaciones()
{


	
	$("#Listar_Cotizaciones").load("application/controllers/CotizacionController.php?action=Listar_Cotizaciones");

	
	
	Cargar_Librerias();
	
	$.getScript("js/custom-tables1.js");
	//$.getScript("js/funciones.js");		
	
}

function Ultimas_Cotizaciones()
{
	$("#Ultimas_Cotizaciones").load("application/controllers/CotizacionController.php?action=Ultimas_Cotizaciones",
	function(data){
	
		$("#Ultimas_Cotizaciones").html(data);		
		
	});
}

function Cantidad_Cotizaciones()
{
	$("#Cantidad_Cotizaciones").load("application/controllers/CotizacionController.php?action=Cantidad_Cotizaciones",
	function(data){
	
		$("#Cantidad_Cotizaciones").html(data);		
		
	});
}



function GenerarProducto(oId,ProductoSeleccionado)
{
	
	//alert(oId);
	//alert(ProductoSeleccionado);
	//alert($("#lstProducto" + oId).length);
		
	
	var Cantidad = $("#hidCantidad" + oId).val();
	var TipoEmpaque = $("#hidTipoEmpaque" + oId).val();
	var Precio = $("#hidPrecio" + oId).val();
	var Total = $("#hidTotal" + oId).val();
	var Producto = $("#hidProducto" + oId).val();	
	var DescProducto = $("#hidDescProducto" + oId).val();
	var Id = $("#hdnIdCampos_" + oId).val();		

	//alert(Cantidad);
	
	if ((Cantidad == "") || (Cantidad == undefined))
	Cantidad = 0;
		
	if (oId != undefined)
	{	
		
		//alert(oId);
		if (ProductoSeleccionado != undefined)
		{

		//alert(Cantidad);
			if(ProductoSeleccionado == "libf")
			{					
				
				//$("#rowDetalle_" + oId).remove();										
				var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
				var strHtml1 = '<td colspan="6"><table width="100%">';
					strHtml1 += '<tr>';
				var strHtml2 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
				var strHtml3 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="" style="width:80%;" class="validate[required]" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value=""  /></td>';	
				//var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtProducto' + oId + '" name="txtProducto[]" value="" style="width:80%;" class="maskCelular validate[required]" /><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value=""  /></td>';
				var strHtml4 = '<td width="32%">' + '<div class="floatL">';
					strHtml4 += '<select name="lstProducto[]" id="lstProducto' + oId + '" class="validate[required]" >';
					strHtml4 += '<option value="">Seleccione el Producto</option>';
					strHtml4 += '<option value="libf">Libreta Factura</option>';	
					strHtml4 += '<option value="lib">Libreta</option>';			
					strHtml4 += '</select>';
					strHtml4 += '</div><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value="' + ProductoSeleccionado + '"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value=""  /></td>';
				var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="0.00" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value=""  /></td>';
				var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="0.00" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value=""  /></td>';

				var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
				var strHtml8 = '<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles(' + oId +',\''+ProductoSeleccionado+'\')" >Ver detalle</a></td></tr>';				
				var strHtml9 = '</tr>';
					strHtml9 += '</table></td>';	
				var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
				var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;				
				
				//$("#tbDetalle").prepend(strHtmlTr);
				$("#rowDetalle_" + oId).html(strHtmlFinal);
					//$("#cant_campos_min" + oId).val(rowCount);
					
				GenerarProducto(oId);	

				$("#lstProducto" + oId).change(function(){
			
					if ($("#lstProducto" + oId).val() != "")	
					GenerarProducto(oId,$("#lstProducto" + oId).val());
					else
					GenerarProducto(oId);
		
				});


				
				$("#txtCantidad" + oId).keydown(function(event){
					//alert(event.keyCode);
					if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
						return false;
					}
				});		
	
				$("#txtCantidad" + oId).change(function(){
					$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
					$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
					$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
					//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val()) + parseFloat($("#txtTotalFinal").val())));
					Calcular_Total_Cotizacion ();					
				});	
				
				//alert(ProductoSeleccionado);				
				var Seleccionado = ProductoSeleccionado;
				//alert(Seleccionado);
				
				$("#lstProducto" + oId).load("application/controllers/CotizacionController.php?action=Listar_Producto_Select",
				function(data2) {

				$("#lstProducto" + oId).find('option').remove().end().append('<option value="">Seleccione el Producto</option>');
				$("#lstProducto" + oId).append('<option value="libf">Libreta Factura</option>');
				$("#lstProducto" + oId).append('<option value="lib">Libreta</option>');
				$("#lstProducto" + oId).append(data2);				
				
				$("#lstProducto" + oId + " option[value="+Seleccionado+"]").attr("selected",true);					
				});			
				
				//return false;	
			
			
			}
			else if(ProductoSeleccionado == "lib")
			{
			
						
				//$("#rowDetalle_" + oId).remove();										
				var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
				var strHtml1 = '<td colspan="6"><table width="100%">';
					strHtml1 += '<tr>';
				var strHtml2 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
				var strHtml3 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="" style="width:80%;" class="validate[required]" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value=""  /></td>';	
				//var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtProducto' + oId + '" name="txtProducto[]" value="" style="width:80%;" class="maskCelular validate[required]" /><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value=""  /></td>';
				var strHtml4 = '<td width="32%">' + '<div class="floatL">';
					strHtml4 += '<select name="lstProducto[]" id="lstProducto' + oId + '" class="validate[required]" >';
					strHtml4 += '<option value="">Seleccione el Producto</option>';
					strHtml4 += '<option value="libf">Libreta Factura</option>';	
					strHtml4 += '<option value="lib">Libreta</option>';			
					strHtml4 += '</select>';
					strHtml4 += '</div><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value="' + ProductoSeleccionado + '"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value=""  /></td>';
				var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="0.00" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value=""  /></td>';
				var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="0.00" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value=""  /></td>';

				var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
				var strHtml8 = '<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles(' + oId +',\''+ProductoSeleccionado+'\')" >Ver detalle</a></td></tr>';				
				var strHtml9 = '</tr>';
					strHtml9 += '</table></td>';	
				var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
				var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8+ strHtml9;				
				

				//$("#tbDetalle").replaceWith(strHtmlTr);		
	
				$("#rowDetalle_" + oId).html(strHtmlFinal);
					//$("#cant_campos_min" + oId).val(rowCount);
					
				GenerarProducto(oId);	

				$("#lstProducto" + oId).change(function(){
			
					if ($("#lstProducto" + oId).val() != "")	
					GenerarProducto(oId,$("#lstProducto" + oId).val());
					else
					GenerarProducto(oId);
		
				});

				$("#txtCantidad" + oId).keydown(function(event){
					//alert(event.keyCode);
					if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
						return false;
					}
				});		
	
				$("#txtCantidad" + oId).change(function(){
					$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
					$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
					$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
					//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
					Calcular_Total_Cotizacion ();
				});	
				
								
				//alert(ProductoSeleccionado);				
				var Seleccionado = ProductoSeleccionado;
				//alert(Seleccionado);
				
				$("#lstProducto" + oId).load("application/controllers/CotizacionController.php?action=Listar_Producto_Select",
				function(data2) {

				$("#lstProducto" + oId).find('option').remove().end().append('<option value="">Seleccione el Producto</option>');
				$("#lstProducto" + oId).append('<option value="libf">Libreta Factura</option>');
				$("#lstProducto" + oId).append('<option value="lib">Libreta</option>');
				$("#lstProducto" + oId).append(data2);				
				
				$("#lstProducto" + oId + " option[value="+Seleccionado+"]").attr("selected",true);					
				});
				//return false;			
			
			
			}
			else
			{				
				
				//$("#rowDetalle_" + oId).remove();
				
				var strHtml0= '<td  align="center"  width="2%">' +  oId + '</td>';	        
				var strHtml1 = '<td  width="15%">' + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
				var strHtml2 = '<td  width="15%">' + '<span class="req">*</span><input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="" style="width:80%;" class="validate[required]" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value=""  /></td>';	
				//var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtProducto' + oId + '" name="txtProducto[]" value="" style="width:80%;" class="maskCelular validate[required]" /><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value=""  /></td>';
				var strHtml3 = '<td width="29%">' + '<div class="floatL">';
					strHtml3 += '<select name="lstProducto[]" id="lstProducto' + oId + '" class="validate[required]" >';
					strHtml3 += '<option value="">Seleccione el Producto</option>';
					strHtml3 += '<option value="libf">Libreta Factura</option>';	
					strHtml3 += '<option value="lib">Libreta</option>';			
					strHtml3 += '</select>';
					strHtml3 += '</div><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value="' + ProductoSeleccionado + '"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value=""  /></td>';
				var strHtml4 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="0.00" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value=""  /></td>';
				var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="0.00" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value=""  /></td>';

				var strHtml6 = '<td width="9%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					strHtml6 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
				var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
				var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6;	

				//$("#tbDetalle").replaceWith(strHtmlTr);	
	
				$("#rowDetalle_" + oId).html(strHtmlFinal);	

				$("#lstProducto" + oId).change(function(){
			
					if ($("#lstProducto" + oId).val() != "")	
					GenerarProducto(oId,$("#lstProducto" + oId).val());
					else
					GenerarProducto(oId);
		
				});	
				
				$("#txtCantidad" + oId).keydown(function(event){
					//alert(event.keyCode);
					if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
						return true;
					}
					else
					{
						return false;
					}
				});	

				if ($("#txtTotalFinal").val() == undefined)
				$("#txtTotalFinal").val('0');
				
				$("#txtCantidad" + oId).change(function(){
					$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
					$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
					$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
					//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
					Calcular_Total_Cotizacion ();
					
				});					
				
				$("#lstProducto" + oId).load("application/controllers/CotizacionController.php?action=Producto_Seleccionado",
				{
					IdProducto:ProductoSeleccionado

				},			
				function(data) {			
					//alert(data1);
					$resultArr  = JSON.parse(data);
					//alert($resultArr);
					//alert($resultArr.length);
					var c = 0; 
					while (c < $resultArr.length)
					{				
						//alert($resultArr[c].descripcion_empaque);
						
						$("#txtTipoEmpaque" + oId).val($resultArr[c].descripcion_empaque);
						$("#hidTipoEmpaque" + oId).val($resultArr[c].id_tipo_empaque);
						$("#txtPrecio" + oId).val(ConvertirMoneda($resultArr[c].precio_venta));
						$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));	
						$("#hidProducto" + oId).val(ProductoSeleccionado);
						//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
								
						Calcular_Total_Cotizacion ();
						
						c = c + 1;
					}
					$("#lstProducto" + oId).load("application/controllers/CotizacionController.php?action=Listar_Producto_Select",			
					function(data1) {				
										
						$("#lstProducto" + oId).find('option').remove().end().append('<option value="">Seleccione el Producto</option>');
						$("#lstProducto" + oId).append('<option value="libf">Libreta Factura</option>');
						$("#lstProducto" + oId).append('<option value="lib">Libreta</option>');
						$("#lstProducto" + oId).append(data1);	
						
						$("#lstProducto" + oId + " option[value="+ProductoSeleccionado+"]").attr("selected",true);
					
					});	
				});		
			}	
		}
		else
		{
				$("#lstProducto" + oId).load("application/controllers/CotizacionController.php?action=Listar_Producto_Select",
				function(data) {

				$("#lstProducto" + oId).find('option').remove().end().append('<option value="">Seleccione el Producto</option>');
				$("#lstProducto" + oId).append('<option value="libf">Libreta Factura</option>');
				$("#lstProducto" + oId).append('<option value="lib">Libreta</option>');
				$("#lstProducto" + oId).append(data);	
				
				$("#lstProducto" + oId + " option[value=]").attr("selected",true);
				$("#txtTipoEmpaque" + oId).val('');
				$("#hidTipoEmpaque" + oId).val('');
				$("#txtPrecio" + oId).val('0.00');
				$("#hidPrecio" + oId).val('0.00');				
				$("#txtTotal" + oId).val('0.00');
				$("#hidTotal" + oId).val('0.00');

				if ((Cantidad=='0') || (Cantidad==undefined))
				{
					$("#txtCantidad" + oId).val('0');
					$("#hidCantidad" + oId).val('0');
				}
				
			});
		}
		

		

	}

}

function BuscarID_Producto(oId)
{
	//alert($("#hidDescProducto" + oId).val());

	var Cantidad = $("#hidCantidad" + oId).val();
	var TipoEmpaque = $("#hidTipoEmpaque" + oId).val();
	var Precio = $("#hidPrecio" + oId).val();
	var Total = $("#hidTotal" + oId).val();
	var Producto = $("#hidProducto" + oId).val();
	var DescProducto = $("#hidDescProducto" + oId).val();
	var Id = $("#hdnIdCampos_" + oId).val();	
	
	if ($("#hidDescProducto" + oId).val() == "Trabajo de Imprenta")
	{
		//$("#rowDetalle_" + oId).remove();										
		var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
		var strHtml1 = '<td colspan="6"><table width="100%">';
			strHtml1 += '<tr>';
		var strHtml2 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
		var strHtml3 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="Unidad" style="width:80%;" class="validate[required]" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value=""  /></td>';	
		//var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtProducto' + oId + '" name="txtProducto[]" value="" style="width:80%;" class="maskCelular validate[required]" /><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value=""  /></td>';
		var strHtml4 = '<td width="32%">';
			strHtml4 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto' + oId + '" style="width:85%;" class="validate[required]" value="'+DescProducto+'"/>';			
			//strHtml4 += '<select name="lstProducto[]" id="lstProducto' + oId + '" class="validate[required]" >';
			//strHtml4 += '<option value="">Seleccione el Producto</option>';
			//strHtml4 += '<option value="libf">Libreta Factura</option>';	
			//strHtml4 += '<option value="lib">Libreta</option>';			
			//strHtml4 += '</select>';
			strHtml4 += '<input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value="'+Producto+'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+DescProducto+'"  /></td>';
		var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="0.00" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value=""  /></td>';
		var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="0.00" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value=""  /></td>';

		var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
			strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
		var strHtml8 = '<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles(' + oId +',\'timp\')" >Ver detalle</a></td></tr>';				
		var strHtml9 = '</tr>';
			strHtml9 += '</table></td>';	
		var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;				
				
		//$("#tbDetalle").prepend(strHtmlTr);
		$("#rowDetalle_" + oId).html(strHtmlFinal);


		$("#hidProducto" + oId).val("timp");

		$("#txtProducto" + oId).autocomplete({
			source: "application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar",
			select:  function(event, ui) {
			//alert(ui.item.value);
			//alert($("#txtProducto" + oId).val());
			$("#hidDescProducto" + oId).val(ui.item.value);
			BuscarID_Producto(oId);
			},
			change: function (event, ui) {
			
				if (ui.item === null)
				{	
					$("#txtProducto"+oId).val("");
					$("#hidDescProducto"+oId).val("");					
				}
				else
				{
					//alert(ui.item.value);
					//alert($("#txtProducto" + oId).val());
					$("#hidDescProducto" + oId).val(ui.item.value);
					BuscarID_Producto(oId);
				}				
			}	
	
		});
		
		$("#txtCantidad" + oId).change(function(){
		
			if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidDescProducto" + oId).val() == "Trabajo de Imprenta")  & ($("#txtCantidad" + oId).val() > 1))
			{
				alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
				$("#txtCantidad" + oId).val('0');			
			}
			else if ($("#txtCantidad" + oId).val() == 0) 
			{
				alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
				$("#txtCantidad" + oId).val('0');			
			}			
			else
			{		
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
				$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
				//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
				Calcular_Total_Cotizacion (); 
			}
		});	
						
		
	}
	else if ($("#hidDescProducto" + oId).val() == "Trabajo de Banner")
	{
		//$("#rowDetalle_" + oId).remove();										
		var strHtml0 = '<td  align="center" width="2%">' +  oId + '</td>';
		var strHtml1 = '<td colspan="6"><table width="100%">';
			strHtml1 += '<tr>';
		var strHtml2 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="'+ Cantidad +'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="'+ Cantidad +'"  /></td>';
		var strHtml3 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTipoEmpaque' + oId + '" name="txtTipoEmpaque[]" value="Unidad" style="width:80%;" class="validate[required]" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque' + oId + '" name="hidTipoEmpaque[]" value=""  /></td>';	
		//var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtProducto' + oId + '" name="txtProducto[]" value="" style="width:80%;" class="maskCelular validate[required]" /><input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value=""  /></td>';
		var strHtml4 = '<td width="32%">';
			strHtml4 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto' + oId + '" style="width:85%;" class="validate[required]" value="'+DescProducto+'"/>';			
			//strHtml4 += '<select name="lstProducto[]" id="lstProducto' + oId + '" class="validate[required]" >';
			//strHtml4 += '<option value="">Seleccione el Producto</option>';
			//strHtml4 += '<option value="libf">Libreta Factura</option>';	
			//strHtml4 += '<option value="lib">Libreta</option>';			
			//strHtml4 += '</select>';
			strHtml4 += '<input type="hidden" id="hidProducto' + oId + '" name="hidProducto[]" value="'+Producto+'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+DescProducto+'"  /></td>';
		var strHtml5 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="0.00" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value=""  /></td>';
		var strHtml6 = '<td width="15%">' + '<span class="req">*</span><input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="0.00" style="width:80%;text-align:right;"  class="validate[required]"  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value=""  /></td>';

		var strHtml7 = '<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
			strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
		var strHtml8 = '<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles(' + oId +',\'tbnr\')" >Ver detalle</a></td></tr>';				
		var strHtml9 = '</tr>';
			strHtml9 += '</table></td>';	
		var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2  + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;				
				
		//$("#tbDetalle").prepend(strHtmlTr);
		$("#rowDetalle_" + oId).html(strHtmlFinal);


		$("#hidProducto" + oId).val("tbnr");

		$("#txtProducto" + oId).autocomplete({
			source: "application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar",
			select:  function(event, ui) {
			//alert(ui.item.value);
			//alert($("#txtProducto" + oId).val());
			$("#hidDescProducto" + oId).val(ui.item.value);
			BuscarID_Producto(oId);
			},
			change: function (event, ui) {
			
				if (ui.item === null)
				{	
					$("#txtProducto"+oId).val("");
					$("#hidDescProducto"+oId).val("");					
				}
				else
				{
					//alert(ui.item.value);
					//alert($("#txtProducto" + oId).val());
					$("#hidDescProducto" + oId).val(ui.item.value);
					BuscarID_Producto(oId);
				}				
			}
	
		});
		
		$("#txtCantidad" + oId).change(function(){
		
			if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidDescProducto" + oId).val() == "Trabajo de Imprenta")  & ($("#txtCantidad" + oId).val() > 1))
			{
				alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
				$("#txtCantidad" + oId).val('0');			
			}
			else if ($("#txtCantidad" + oId).val() == 0) 
			{
				alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
				$("#txtCantidad" + oId).val('0');			
			}
			else
			{		
				$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
				$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
				$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
				//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
				Calcular_Total_Cotizacion (); 
			}
		});	
						
		
	}
	else
	{
		$.post("application/controllers/CotizacionController.php?action=BuscarID_Producto",
		{
			NombreProducto:$("#hidDescProducto" + oId).val()
		},
		function(data) {
			
		
			$resultArr  = JSON.parse(data);
			//alert($resultArr);
			//alert($resultArr.length);
			var c = 0; 
			while (c < $resultArr.length)
			{				
				//alert($resultArr[c].descripcion_empaque);
				$("#hidProducto" + oId).val($resultArr[c].id_producto);	
				$("#txtTipoEmpaque" + oId).val($resultArr[c].descripcion_empaque);
				$("#hidTipoEmpaque" + oId).val($resultArr[c].id_tipo_empaque);
				$("#txtPrecio" + oId).val(ConvertirMoneda($resultArr[c].precio_venta));
				$("#hidPrecio" + oId).val(ConvertirMoneda($resultArr[c].precio_venta));
				$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda($("#hidPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
				//$("#hidProducto" + oId).val(ProductoSeleccionado);
				//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
									
				Calcular_Total_Cotizacion ();
						
				c = c + 1;
			}		
		
		});
	}

}


// ocurre cada vez que se marca un elemento de la lista
function productoFoco(event, ui)
{
    var producto = ui.item.value;
 
    // no quiero que jquery despliegue el texto del control porque
    // no puede manejar objetos, asi que escribimos los datos
    // nosotros y cancelamos el evento
    // (intenta comentando este codigo para ver a que me refiero)
    $("#txtProducto").val(producto.descripcion);
    event.preventDefault();
}

// ocurre cuando se selecciona un producto de la lista
function productoSeleccionado(event, ui)
{
    // recupera la informacion del producto seleccionado
    var producto = ui.item.value;
    var cantidad = $("#txtCantidad").val();
 
    // vamos a validar la cantidad con un procedimiento muy simple
    cantidad = parseInt(cantidad, 10); // convierte a entero
    if (isNaN(cantidad)) cantidad = 0;
 
    var precio = producto.precio;
    var importe = precio * cantidad;
 
    // actualizamos los datos en el formulario
    //$("#lblPrecio").text(precio);
    //$("#lblImporte").text(importe);
 
    // no quiero que jquery despliegue el texto del control porque
    // no puede manejar objetos, asi que escribimos los datos
    // nosotros y cancelamos el evento
    // (intenta comentando este codigo para ver a que me refiero)
    $("#txtProducto").val(producto.descripcion);
    event.preventDefault();
}


function Listar_Cotizaciones_Anteriores()
{

	//alert($("#hidIdCliente").val());

	$.post("application/controllers/CotizacionController.php?action=Listar_Cotizaciones_Anteriores",
	{
		IdCliente:$("#hidIdCliente").val(),
		IdTipoCliente:$("#hidIdTipoCliente").val()		
	},
	function(data) {
				
		
		$("#lstCotizacion").find('option').remove().end().append('<option value="">Seleccione la Cotizaci&oacute;n</option>');
		$("#lstCotizacion").append(data);	
			
		$("#lstCotizacion").change(function(){
		
			Buscar_Descripcion_Cotizacion();
			Buscar_Cotizaciones_Anteriores();
		});	
		//$("#lstCotizacion option[value=" + NoCotizacion + "]").attr("selected",true);
	});
}

function Buscar_Descripcion_Cotizacion()
{
	$.post("application/controllers/CotizacionController.php?action=Buscar_Descripcion_Cotizacion",
	{
		idCotizacion:$("#lstCotizacion").val()
	},
	function(data) {
		//alert(data);
		$("#txtDescripcionCotizacion").val(data);	

	});
}

function Buscar_Cotizaciones_Anteriores()
{
	$.post("application/controllers/CotizacionController.php?action=Buscar_Cotizaciones_Anteriores",
	{
		idCotizacion:$("#lstCotizacion").val()
	},
	function(data) {
		
		//alert($("#cant_campos").val());
		//alert(data);
		//$resultArr  = JSON.parse(data);
		//alert($resultArr[0]);
		//$("#txtDescripcionCotizacion").val($resultArr[0]);
		
		//$("#cant_campos").val(parseInt($("#cant_campos").val()) + 1);			
		
		//Calcular_Total_Cotizacion ();


		//var oId = $("#cant_campos").val();		
		
		$("#tbDetalle").html(data);	
		
		$("#cant_campos").val($("[name='txtCantidad[]']").length);
		$("#num_campos").val($("[name='txtCantidad[]']").length);			
		//
		//alert($("#lstCotizacion").val());
		
		$.post("application/controllers/CotizacionController.php?action=Verificar_Administrador",
		function(data){

			if (data == "true")
			{	
				var hidProducto =  new Array();
				hidProducto = $("[name='hidIdProducto[]']");

				var HidProducto = [];
				for (var i = 0; i < hidProducto.length; ++i) {
					HidProducto[i] = hidProducto[i].value;
				}					
					
				if ((jQuery.inArray("timp",HidProducto)) | (jQuery.inArray("tbnr",HidProducto)) | (jQuery.inArray("timpart",HidProducto)))
				{

					for(i=0;i<HidProducto.length;i++)
					{
						if((HidProducto[i] == "timp")|(HidProducto[i] == "tbnr")|(HidProducto[i] == "timpart"))
						{
							$("#txtPrecio"+(i+1)).attr("readonly",false);
							$("#txtPrecio"+(i+1)).attr("title","Precio Sugerido");							
						}
					}

					$("[name='txtPrecio[]']").keydown(function(event){
					//alert(event.keyCode);
						if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
							return true;
						}
						else
						{
							return false;
						}
					});
						
					$("[name='txtPrecio[]']").change(function(){
						
						var oId = $(this).attr('id');
						oId = oId.substr(9);				
					
						$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
						$("#txtPrecio"+oId).attr("title","Precio Especial");
						$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

						$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
						$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
						$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
						Calcular_Total_Cotizacion ();
					});
				}

			}
			else
			{
				if ((jQuery.inArray("timp",HidProducto)) | (jQuery.inArray("tbnr",HidProducto)) | (jQuery.inArray("timpart",HidProducto)))
				{
					for(i=0;i<HidProducto.length;i++)
					{
						if((HidProducto[i] == "timp")|(HidProducto[i] == "tbnr")|(HidProducto[i] == "timpart"))
						{
							$("#txtPrecio"+(i+1)).attr("readonly",true);								
						}
					}
				}
			}
		});			
		
		
		$.post("application/controllers/CotizacionController.php?action=Buscar_Monto_Total_Cotizaciones_Anteriores",
		{
			idCotizacion:$("#lstCotizacion").val()
		},
		function(data) {
		
			$("#tbTotal").html(data);	
			//Calcular_Total_Cotizacion ();

			/*if (jQuery.browser.mobile == "true")
			{	
				$("#mainPage").on("pageshow", function(e) {	
					console.log("Ready to bring the awesome.");
					var sugList = $("#suggestions");
					var elementos 
	
					$("#searchField" + oId).on("input", function(e) {
						var text = $(this).val();
						if(text.length < 1) {
							sugList.html("");
							sugList.listview("refresh");
						} else {
							$.get("application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar", {search:text}, function(res,code) {
								var str = "";
								for(var i=0, len=res.length; i<len; i++) {
									str += "<li id='item"+i+"' onclick=\"$('#searchField" + oId + "').val('"+res[i]+"');\" >"+res[i]+"</li>";
								}
								sugList.html(str);
								sugList.listview("refresh");
								console.dir(res);
								console.log("cuantos elementos");
								console.log($("#suggestions li").size());
								console.log(res);
								//elementos = $("#suggestions li").size();
								//console.log($("#suggestions li").click());				
				
		
							},"json");
						}
					});	
	
				});	
			}
			else
			{*/
	
				$("[name='txtProducto[]']").autocomplete({
					source: "application/controllers/CotizacionController.php?action=Listar_Producto_Autocompletar",
					select:  function(event, ui) {
						//alert(ui.item.value);
						//alert($("#txtProducto" + oId).val());
						var oId = $(this).attr('id');
						oId = oId.substr(11);						
						
						$("#hidDescProducto" + oId).val(ui.item.value);
						$("#hidIdProducto" + oId).val(ui.item.id_producto);
						$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
						$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
						$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
						$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
						$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
				
						Generar_Descripcion_Producto(oId);

						$("[name='txtCantidad[]']").change(function(){
		
							var oId = $(this).attr('id');
							oId = oId.substr(11);
							
							//alert(oId);
							if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == "timp") & ($("#txtCantidad" + oId).val() > 1))
							{
								alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
								$("#txtCantidad" + oId).val('0');			
							}
							else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "timp"))
							{
								alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
								$("#txtCantidad" + oId).val('0');				
							}
							else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "tbnr"))
							{
								alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
								$("#txtCantidad" + oId).val('0');				
							}
							else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "timpart"))
							{
								alert("La cantidad de Trabajo de Impresión debe ser mayor que 0.")
								$("#txtCantidad" + oId).val('0');				
							}				
							else
							{		
								$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
								$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
								$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
								$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
								//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
								Calcular_Total_Cotizacion()
							}

						});	

						$.post("application/controllers/CotizacionController.php?action=Verificar_Administrador",
	 					function(data){

							if (data == "true")
							{
								//if ($("#hidIdProducto"+oId).val() == "timp")
								//{
									$("#txtPrecio"+oId).attr("readonly",false);
									$("#txtPrecio"+oId).attr("title","Precio Sugerido");

									$("#txtPrecio" + oId).keydown(function(event){
									//alert(event.keyCode);
										if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
											return true;
										}
										else
										{
											return false;
										}
									});
							
									$("#txtPrecio" + oId).change(function(){
										$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
										$("#txtPrecio"+oId).attr("title","Precio Especial");
										$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

										$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
										$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
										$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
										Calcular_Total_Cotizacion ();
									});
								//}
							}
							else
							{
								//if ($("#hidIdProducto"+oId).val() == "timp")
								//{
									$("#txtPrecio"+oId).attr("readonly",true);
								//}
							}
						});									
						
						Calcular_Total_Cotizacion ();				
						//BuscarID_Producto(oId);
					},
					change: function (event, ui) {

						var oId = $(this).attr('id');
						oId = oId.substr(11);
					
						if (ui.item === null)
						{	
							$("#txtProducto"+oId).val("");
							$("#hidDescProducto" + oId).val("");
							$("#hidIdProducto" + oId).val("");
							$("#txtTipoEmpaque" + oId).val("");
							$("#hidTipoEmpaque" + oId).val("");
							$("#txtPrecio" + oId).val("0.00");
							$("#hidPrecio" + oId).val("0.00");
							$("#txtTotal" + oId).val("0.00");
							$("#hidTotal" + oId).val("0.00");				
						}
						else
						{
							//alert(ui.item.value);
							//alert($("#txtProducto" + oId).val());
							$("#hidDescProducto" + oId).val(ui.item.value);
							$("#hidIdProducto" + oId).val(ui.item.id_producto);
							$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
							$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
							$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
							$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
							$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
							$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
					
							Generar_Descripcion_Producto(oId);

							$("[name='txtCantidad[]']").change(function(){
			
								var oId = $(this).attr('id');
								oId = oId.substr(11);
								
								//alert(oId);
								if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == "timp") & ($("#txtCantidad" + oId).val() > 1))
								{
									alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
									$("#txtCantidad" + oId).val('0');			
								}
								else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "timp"))
								{
									alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
									$("#txtCantidad" + oId).val('0');				
								}
								else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "tbnr"))
								{
									alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
									$("#txtCantidad" + oId).val('0');				
								}
								else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "timpart"))
								{
									alert("La cantidad de Trabajo de Impresión debe ser mayor que 0.")
									$("#txtCantidad" + oId).val('0');				
								}				
								else
								{		
									$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
									$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
									$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
									$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
									//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val())));
									Calcular_Total_Cotizacion() 
								}

							});	

							$.post("application/controllers/CotizacionController.php?action=Verificar_Administrador",
							function(data){

								if (data == "true")
								{
									//if ($("#hidIdProducto"+oId).val() == "timp")
									//{
										$("#txtPrecio"+oId).attr("readonly",false);
										$("#txtPrecio"+oId).attr("title","Precio Sugerido");

										$("#txtPrecio" + oId).keydown(function(event){
										//alert(event.keyCode);
											if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
												return true;
											}
											else
											{
												return false;
											}
										});
								
										$("#txtPrecio" + oId).change(function(){
											$("#txtPrecio" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()));
											$("#txtPrecio"+oId).attr("title","Precio Especial");
											$("#hidPrecio" + oId).val($("#txtPrecio" + oId).val());

											$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
											$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
											$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
											Calcular_Total_Cotizacion ();
										});
									//}
								}
								else
								{
									//if ($("#hidIdProducto"+oId).val() == "timp")
									//{
										$("#txtPrecio"+oId).attr("readonly",true);
									//}
								}
							});									
							
							Calcular_Total_Cotizacion ();				
							//BuscarID_Producto(oId);
						}				
					}
	
				});	
	
	
	
			//}


			

			
			$("[name='txtCantidad[]']").keydown(function(event){
				//alert(event.keyCode);
				if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
					return true;
				}
				else
				{
					return false;
				}
			});		
	
			if ($("#txtTotalFinal").val() == undefined)
			$("#txtTotalFinal").val('0');
	
			$("[name='txtCantidad[]']").change(function(){

				var oId = $(this).attr('id');
				oId = oId.substr(11);
				
				//alert(oId);
				if (($("#txtCantidad" + oId).val()%2 != 0) & ($("#hidIdProducto" + oId).val() == "timp") & ($("#txtCantidad" + oId).val() > 1))
				{
					alert("La cantidad de Trabajo de Imprenta debe ser un número par.")
					$("#txtCantidad" + oId).val('0');			
				}
				else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "timp"))
				{
					alert("La cantidad de Trabajo de Imprenta debe ser mayor que 0.")
					$("#txtCantidad" + oId).val('0');				
				}
				else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "tbnr"))
				{
					alert("La cantidad de Trabajo de Banner debe ser mayor que 0.")
					$("#txtCantidad" + oId).val('0');				
				}
				else if (($("#txtCantidad" + oId).val() == 0) & ($("#hidIdProducto" + oId).val() == "timpart"))
				{
					alert("La cantidad de Trabajo de Impresión debe ser mayor que 0.")
					$("#txtCantidad" + oId).val('0');				
				}				
				else
				{

			
					$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
					$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
					$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
					//$("#txtTotalFinal").val(ConvertirMoneda(parseFloat($("#txtTotal" + oId).val()) + parseFloat($("#txtTotalFinal").val())));
					Calcular_Total_Cotizacion ();
					//alert($("#txtTotal" + oId).val());			
				}		
		

			});			
		
		
		
		});
		
		
	
	
		
	});
}

function Imprimir_Cotizacion(id_cotizacion)
{


	$.post("application/controllers/CotizacionController.php?action=Imprimir_Cotizacion",
	{	
		id:id_cotizacion
	
	}, function(data){
			
			
			window.open(data, 'win3', 'width=1024, height=768,  left=20, top=20, resizable=yes, scrollbars=yes,toolbar=no,location=no,directories=no, status=no,menubar=no');
			//window.location.href='listar_cotizacion.html';
	});
}


function Enviar_Cotizacion(id_cotizacion)
{
	/*var arrContacto = new Array();
	arrContacto = $("[name='contacto[]']");
	var ArrContacto = [];
	for (var i = 0; i < arrContacto.length; ++i) {
		ArrContacto[i] = arrContacto[i].value;
	}

	StrContacto = ArrContacto.toString();*/	
	
	var selectedItems = new Array();
		
	$("input[@name='contacto[]']:checked").each(function(){
			selectedItems.push($(this).val());
	});
		
	
	
	//alert(selectedItems);
	StrContacto = selectedItems.toString();
	//alert(StrContacto);
	
	$.post("application/controllers/CotizacionController.php?action=Enviar_Cotizacion",
	{	
		contactos:StrContacto,
		id:id_cotizacion	
	
	}, function(data){
			
			window.location.href='listar_cotizacion.html';
	});
}

function Listar_Descripcion_Cotizacion_Auto()
{

	//alert(filename);

	/*if (jQuery.browser.mobile == "true")
	{			
		var strHtml0 = '<div data-role="page" id="mainPage"><p>';
			strHtml0 += '<label>Descripci&oacute;n de Cotizaci&oacute;n:<span class="req">*</span></label>';
			strHtml0 += '<div class="formRight">';
			strHtml0 += '<input type="text" value="" class="validate[required]" name="txtDescripcionCotizacion" id="txtDescripcionCotizacion"  style="width:100%"/>';
			strHtml0 += '</div>';
			strHtml0 += '<div class="clear">';
			strHtml0 += '</div>';	
		strHtml0 += '<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';
	}
	else
	{*/
		var strHtml0 = '<label>Descripci&oacute;n de Cotizaci&oacute;n:<span class="req">*</span></label>';
			strHtml0 += '<div class="formRight">';
			strHtml0 += '<input type="text" value="" class="validate[required]" name="txtDescripcionCotizacion" id="txtDescripcionCotizacion"  style="width:100%"/>';
			strHtml0 += '</div>';
			strHtml0 += '<div class="clear">';
			strHtml0 += '</div>';	
	//}	
	
	$("#DescripcionCotizacion").html(strHtml0);
	
	
	/*if (jQuery.browser.mobile == "true")
	{	
$("#mainPage").on("pageshow", function(e) {	
	console.log("Ready to bring the awesome.");
	var sugList = $("#suggestions");
	var elementos 
	
	$("#txtDescripcionCotizacion").on("input", function(e) {
		var text = $(this).val();
		if(text.length < 1) {
			sugList.html("");
			sugList.listview("refresh");
		} else {
			$.get("library/funciones.php?action=Listar_Descripcion_Cotizacion_Autocompletar", {search:text}, function(res,code) {
				var str = "";
				for(var i=0, len=res.length; i<len; i++) {
					str += "<li id='item"+i+"' onclick=\"$('#txtNumeroCotizacion').val('"+res[i]+"');\" >"+res[i]+"</li>";
				}
				sugList.html(str);
				sugList.listview("refresh");
				console.dir(res);
				console.log("cuantos elementos");
				console.log($("#suggestions li").size());
				console.log(res);
				
				//elementos = $("#suggestions li").size();
				//console.log($("#suggestions li").click());		
		
			},"json");
		}
	});	
	
});	
	}
	else
	{*/
	
		$("#txtDescripcionCotizacion").autocomplete({
			source: "application/controllers/CotizacionController.php?action=Listar_Descripcion_Cotizacion_Autocompletar",
			select:  function(event, ui) {
			//alert(ui.item.value);
			//alert($("#txtNumeroCotizacion").val());
					
			}
	
		});	
	
	
	
	//}



}

function Listar_Cotizacion_Auto()
{

	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	

	//alert(filename);

	/*if (jQuery.browser.mobile == "true")
	{			
		var strHtml0 = '<div data-role="page" id="mainPage"><p>';
			strHtml0 += '<label>N&uacute;mero de Cotizaci&oacute;n:<span class="req">*</span></label>';
			strHtml0 += '<div class="formRight">';
			strHtml0 += '<input type="text" value="" class="validate[required]" name="txtNumeroCotizacion" id="txtNumeroCotizacion"  style="width:100%"/>';			
			strHtml0 += '</div>';
			strHtml0 += '<div class="clear">';
			strHtml0 += '</div>';	
		strHtml0 += '<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';
	}
	else
	{*/
		var strHtml0 = '<label>N&uacute;mero de Cotizaci&oacute;n:<span class="req">*</span></label>';
			strHtml0 += '<div class="formRight">';
			strHtml0 += '<input type="text" value="" class="validate[required]" name="txNumeroCotizacion" id="txtNumeroCotizacion"  style="width:100%"/>';			
			strHtml0 += '</div>';
			strHtml0 += '<div class="clear">';
			strHtml0 += '</div>';	
	//}	
	
	$("#NumeroCotizacion").html(strHtml0);
	
	$("#txtNumeroCotizacion").keydown(function(event){
		//alert(event.keyCode);
		if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
			return true;
		}
		else
		{
			return false;
		}
		
		Listar_Trabajo_Cotizacion(calcMD5($("#txtNumeroCotizacion").val()));

		if (filename == "editar_cotizacion.html")
		{
			Buscar_Cliente(calcMD5($("#txtNumeroCotizacion").val()));
			Cargar_Cotizacion(calcMD5($("#txtNumeroCotizacion").val()));
			$("#txtNumeroCotizacion").attr('readonly', true);
		}	
		
	});	
	
	$("#txtNumeroCotizacion").change(function(){
	
	
	
		Listar_Trabajo_Cotizacion(calcMD5($("#txtNumeroCotizacion").val()));

		if (filename == "editar_cotizacion.html")
		{
			Buscar_Cliente(calcMD5($("#txtNumeroCotizacion").val()));
			Cargar_Cotizacion(calcMD5($("#txtNumeroCotizacion").val()));
			$("#txtNumeroCotizacion").attr('readonly', true);
		}	
		
	})
	//alert(jQuery.browser.mobile);
	
	/*if (jQuery.browser.mobile == "true")
	{	
$("#mainPage").on("pageshow", function(e) {	
	console.log("Ready to bring the awesome.");
	var sugList = $("#suggestions");
	var elementos 
	
	$("#txtNumeroCotizacion").on("input", function(e) {
		var text = $(this).val();
		if(text.length < 1) {
			sugList.html("");
			sugList.listview("refresh");
		} else {
			$.get("library/funciones.php?action=Listar_Cotizacion_Autocompletar", {search:text}, function(res,code) {
				var str = "";
				for(var i=0, len=res.length; i<len; i++) {
					str += "<li id='item"+i+"' onclick=\"$('#txtNumeroCotizacion').val('"+res[i]+"');\" >"+res[i]+"</li>";
				}
				sugList.html(str);
				sugList.listview("refresh");
				console.dir(res);
				console.log("cuantos elementos");
				console.log($("#suggestions li").size());
				console.log(res);
				
				Listar_Trabajo_Cotizacion(calcMD5(res));
				//elementos = $("#suggestions li").size();
				//console.log($("#suggestions li").click());

				if (filename == "editar_cotizacion.html")
				{
					Buscar_Cliente(calcMD5(res));
					
					Cargar_Cotizacion(calcMD5(res));
					$("#txtNumeroCotizacion").attr('readonly', true);
				}	
				
				
		
			},"json");
		}
	});	
	
});	
	}
	else
	{*/
	
		$("#txtNumeroCotizacion").autocomplete({
			source: "application/controllers/CotizacionController.php?action=Listar_Cotizacion_Autocompletar",
			select:  function(event, ui) {
			//alert(ui.item.value);
			//alert($("#txtNumeroCotizacion").val());

				$("#txtDescripcionCotizacion").val(ui.item.descripcion_cotizacion);
				ui.item.value = ui.item.numero_cotizacion;
				Listar_Trabajo_Cotizacion(calcMD5(ui.item.numero_cotizacion));


				if (filename == "editar_cotizacion.html")
				{	//alert(ui.item.value);
					Buscar_Cliente(calcMD5(ui.item.numero_cotizacion));
					Cargar_Cotizacion(calcMD5(ui.item.numero_cotizacion));
					$("#txtNumeroCotizacion").attr('readonly', true);
					$("#txtDescripcionCotizacion").val(ui.item.descripcion_cotizacion);
				}					
			},
			change: function (event, ui) {
			
				if (ui.item === null)
				{	
					$("#txtNumeroCotizacion").val("");
					$("#txtDescripcionCotizacion").val("");				
				}
				else
				{
					$("#txtDescripcionCotizacion").val(ui.item.descripcion_cotizacion);
					ui.item.value = ui.item.numero_cotizacion;
					Listar_Trabajo_Cotizacion(calcMD5(ui.item.numero_cotizacion));


					if (filename == "editar_cotizacion.html")
					{	//alert(ui.item.value);
						Buscar_Cliente(calcMD5(ui.item.numero_cotizacion));
						Cargar_Cotizacion(calcMD5(ui.item.numero_cotizacion));
						$("#txtNumeroCotizacion").attr('readonly', true);
						$("#txtDescripcionCotizacion").val(ui.item.descripcion_cotizacion);
					}
				}				
			}
			

	
		});	
	
	//}



}

