function Calculadora (oId)
{
	
	$.post("application/controllers/VentaController.php?action=Calculadora",
	{	
		Cantidad:$("#txtCantidad"+oId).val()
	
	}, function(data){	
						
		//alert(data);
		$( "#dialog-message" ).html(data);
		
		$( "#dialog-message" ).dialog({
			autoOpen: false,
			modal: true,
			title: "Teclado Num&eacute;rico",
			width:400,
			height:400,
			//draggable: false,
			resizable: false,
			buttons: {
				Ok: function() {

					$("#txtCantidad"+oId).val($("#txtValorTeclado").val());				
				
					if ($("#txtCantidad" + oId).val() == 0) 
					{
						alert("La cantidad de Productos debe ser mayor que 0.")
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
						
						$( this ).dialog( "close" );
					}					
											

				}
			}
		});	
		
		$( "#dialog-message" ).dialog( "open" );		
		
		var valor;	
		valor = $("#txtValorTeclado").val();
		
		$("#btnCero").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(parseInt(valor));
		});

		$("#btnDosCero").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(parseInt(valor));
		});
		
		$("#btnPunto").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(parseFloat(valor));
			$("#btnPunto").attr("disabled",true);
		});	
		
		$("#btnUno").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(parseFloat(valor));
		});

		$("#btnDos").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(parseFloat(valor));
		});	

		$("#btnTres").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(parseFloat(valor));
		});	
		
		$("#btnCuatro").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(valor);
		});

		$("#btnCinco").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(parseFloat(valor));
		});	

		$("#btnSeis").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(parseFloat(valor));
		});	

		$("#btnSiete").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(parseFloat(valor));
		});

		$("#btnOcho").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(parseFloat(valor));
		});	

		$("#btnNueve").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(parseFloat(valor));
		});

		$("#btnBorrar").click(function(){
			valor =  valor + $(this).val();
			$("#txtValorTeclado").val(parseFloat(valor));
		});

		$("#btnLimpiar").click(function(){
			valor =  "0";
			$("#txtValorTeclado").val(parseFloat(valor));
			$("#btnPunto").attr("disabled",false);
		});

		$("#btnBackSpace").click(function(){
			valor = valor.slice(0,-1);
			
			if(valor.length == 0)
			valor =  "0";
			
			$("#txtValorTeclado").val(parseFloat(valor));
		});		
	});	
	
	return false;	
}

function Listar_Cliente_Auto()
{

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
		}
	});	
}

function Listar_Descripcion_Venta_Auto()
{

	$("#txtDescripcionVenta").autocomplete({
		source: "application/controllers/VentaController.php?action=Listar_Descripcion_Venta_Autocompletar",
		select:  function(event, ui) {
		//alert(ui.item.value);
		//alert($("#txtNumeroCotizacion").val());
				
		}

	});	
}

function GenerarTipoVenta(oId,TipoVenta)
{		

	if (oId != undefined)
	{
		$("#lstTipoVenta" + oId).load("application/controllers/VentaController.php?action=Listar_Tipo_Venta",
		function(data) {
		
			$("#lstTipoVenta" + oId).find('option').remove().end().append('<option value="">Seleccione el Tipo de Venta</option>');
			$("#lstTipoVenta" + oId).append(data);

			$("#lstTipoVenta" + oId + " option[value=" + TipoPaquete + "]").attr("selected",true);	
		});	
	}
	else
	{	
	
		$("#lstTipoVenta").load("application/controllers/VentaController.php?action=Listar_Tipo_Venta",
		function(data) {  
	
			$("#lstTipoVenta").find('option').remove().end().append('<option value="">Seleccione el Tipo de Venta</option>');
			$("#lstTipoVenta").append(data);		

		});
	}
}

function Listar_Codigo_Barra_Venta_Auto(oId)
{
	var url;

	url = "application/controllers/ProductoController.php?action=Listar_Codigo_Barra_Venta_Autocompletar";

	if ((oId != undefined) & (oId != "any"))
	{	
		$("#txtCodigoBarra" + oId).autocomplete({
			source: url,
			select:  function(event, ui) {
			
				$("#txtNombreProducto" + oId).val(ui.item.txtNombreProducto);
				$("#hidIdProducto" + oId).val(ui.item.hidIdProducto);
				$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.txtPrecio));
				$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.hidPrecio));
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.txtPrecio*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.hidPrecio*$("#txtCantidad" + oId).val()));					
				
			},
			change: function (event, ui) {

				$.post(url,
				{
					CodigoBarra:$("#txtCodigoBarra" + oId).val()
				},
				function(data){

					var item = JSON.parse(data);
					
					if (item === null)
					{
						$("#txtCodigoBarra" + oId).val("");
						$("#txtNombreProducto" + oId).val("");
						$("#hidIdProducto" + oId).val("");
						$("#txtPrecio" + oId).val("");
						$("#hidPrecio" + oId).val("");
						$("#txtTotal" + oId).val("");
						$("#hidTotal" + oId).val("");						
					}
					else
					{
						$("#txtNombreProducto" + oId).val(item[0].txtNombreProducto);
						$("#hidIdProducto" + oId).val(item[0].hidIdProducto);
						$("#txtPrecio" + oId).val(ConvertirMoneda(item[0].txtPrecio));
						$("#hidPrecio" + oId).val(ConvertirMoneda(item[0].hidPrecio));
						$("#txtTotal" + oId).val(ConvertirMoneda(item[0].txtPrecio*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(item[0].hidPrecio*$("#txtCantidad" + oId).val()));							
					}					
				
				});	
				
			}
		});
	}
	else if ((oId != undefined) & (oId == "any"))
	{	
		$("[name='txtCodigoBarra[]']").autocomplete({
			source: url,
			select:  function(event, ui) {
			
				var oId = $(this).attr('id');
				oId = oId.substr(14);			
			
				$("#txtNombreProducto" + oId).val(ui.item.txtNombreProducto);
				$("#hidIdProducto" + oId).val(ui.item.hidIdProducto);
				$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.txtPrecio));
				$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.hidPrecio));
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.txtPrecio*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.hidPrecio*$("#txtCantidad" + oId).val()));					
				
			},
			change: function (event, ui) {

				var oId = $(this).attr('id');
				oId = oId.substr(14);
				
				$.post(url,
				{
					CodigoBarra:$("#txtCodigoBarra" + oId).val()
				},
				function(data){
				
					var item = JSON.parse(data);
					
					if (item === null)
					{
						$("#txtCodigoBarra" + oId).val("");
						$("#txtNombreProducto" + oId).val("");
						$("#hidIdProducto" + oId).val("");
						$("#txtPrecio" + oId).val("");
						$("#hidPrecio" + oId).val("");
						$("#txtTotal" + oId).val("");
						$("#hidTotal" + oId).val("");							
					}
					else
					{
						$("#txtNombreProducto" + oId).val(item[0].txtNombreProducto);
						$("#hidIdProducto" + oId).val(item[0].hidIdProducto);
						$("#txtPrecio" + oId).val(ConvertirMoneda(item[0].txtPrecio));
						$("#hidPrecio" + oId).val(ConvertirMoneda(item[0].hidPrecio));
						$("#txtTotal" + oId).val(ConvertirMoneda(item[0].txtPrecio*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(item[0].hidPrecio*$("#txtCantidad" + oId).val()));							
					}					
				
				});					
			
			}
		});		
	}
}

function Listar_Nombre_Producto_Venta_Auto(oId)
{
	var url;
	
	url = "application/controllers/ProductoController.php?action=Listar_Nombre_Producto_Venta_Autocompletar";

	if ((oId != undefined) & (oId != "any"))
	{		
		$("#txtNombreProducto" + oId).autocomplete({
			source: url,
			select:  function(event, ui) {
				
				$("#txtCodigoBarra" + oId).val(ui.item.txtCodigoBarra);
				$("#hidIdProducto" + oId).val(ui.item.hidIdProducto);
				$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.txtPrecio));
				$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.hidPrecio));
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.txtPrecio*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.hidPrecio*$("#txtCantidad" + oId).val()));					
				
			},
			change: function (event, ui) {
			
				$.post(url,
				{
					NombreProducto:$("#txtNombreProducto" + oId).val()
				},
				function(data){
				
					var item = JSON.parse(data);

					if (item === null)
					{
						$("#txtCodigoBarra" + oId).val("");
						$("#txtNombreProducto" + oId).val("");
						$("#hidIdProducto" + oId).val("");
						$("#txtPrecio" + oId).val("");
						$("#hidPrecio" + oId).val("");
						$("#txtTotal" + oId).val("");
						$("#hidTotal" + oId).val("");						
					}
					else
					{
						$("#txtCodigoBarra" + oId).val(item[0].txtCodigoBarra);
						$("#hidIdProducto" + oId).val(item[0].hidIdProducto);
						$("#txtPrecio" + oId).val(ConvertirMoneda(item[0].txtPrecio));
						$("#hidPrecio" + oId).val(ConvertirMoneda(item[0].hidPrecio));
						$("#txtTotal" + oId).val(ConvertirMoneda(item[0].txtPrecio*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(item[0].hidPrecio*$("#txtCantidad" + oId).val()));							
					}					
				
				});				
			}
		});
	}
	else if ((oId != undefined) & (oId == "any"))
	{
		$("[name='txtNombreProducto[]']").autocomplete({
			source: url,
			select:  function(event, ui) {
			
				var oId = $(this).attr('id');
				oId = oId.substr(14);			
				
				$("#txtCodigoBarra" + oId).val(ui.item.txtCodigoBarra);
				$("#hidIdProducto" + oId).val(ui.item.hidIdProducto);
				$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.txtPrecio));
				$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.hidPrecio));
				$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.txtPrecio*$("#txtCantidad" + oId).val()));
				$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.hidPrecio*$("#txtCantidad" + oId).val()));					
			},
			change: function (event, ui) {
				
				var oId = $(this).attr('id');
				oId = oId.substr(14);
							
				$.post(url,
				{
					NombreProducto:$("#txtNombreProducto" + oId).val()
				},
				function(data){
				
					var item = JSON.parse(data);
					
					if (item === null)
					{
						$("#txtCodigoBarra" + oId).val("");
						$("#txtNombreProducto" + oId).val("");
						$("#hidIdProducto" + oId).val("");
						$("#txtPrecio" + oId).val("");
						$("#hidPrecio" + oId).val("");
						$("#txtTotal" + oId).val("");
						$("#hidTotal" + oId).val("");							
					}
					else
					{
						$("#txtCodigoBarra" + oId).val(item[0].txtCodigoBarra);
						$("#hidIdProducto" + oId).val(item[0].hidIdProducto);
						$("#txtPrecio" + oId).val(ConvertirMoneda(item[0].txtPrecio));
						$("#hidPrecio" + oId).val(ConvertirMoneda(item[0].hidPrecio));
						$("#txtTotal" + oId).val(ConvertirMoneda(item[0].txtPrecio*$("#txtCantidad" + oId).val()));
						$("#hidTotal" + oId).val(ConvertirMoneda(item[0].hidPrecio*$("#txtCantidad" + oId).val()));							
					}					
				
				});				
			}
		});	
	}
}

function Listar_Producto_Auto(oId)
{
	$("#txtProducto" + oId).autocomplete({
		source: "application/controllers/ProductoController.php?action=Listar_Producto_Autocompletar&v=1",
		select:  function(event, ui) {
		//alert(ui.item.value);
		//alert($("#txtProducto" + oId).val());
			//alert(ui.item.id_producto);
			$("#hidDescProducto" + oId).val(ui.item.value);
			$("#hidIdProducto" + oId).val(ui.item.id_producto);
			$("#txtTipoEmpaque" + oId).val(ui.item.descripcion_empaque);
			$("#hidTipoEmpaque" + oId).val(ui.item.id_tipo_empaque);
			$("#txtPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
			$("#hidPrecio" + oId).val(ConvertirMoneda(ui.item.precio_venta));
			$("#txtTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));
			$("#hidTotal" + oId).val(ConvertirMoneda(ui.item.precio_venta*$("#txtCantidad" + oId).val()));

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

function Agregar_Articulo(){

	if($("#cant_campos").val() == 0)
	$("#tbDetalle").empty();	
	
	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	
	Calcular_Total_Cotizacion ();
	
	$("#cant_campos").val(parseInt($("#cant_campos").val()) + 1);
	var oId = $("#cant_campos").val();

	var strHtml0= "<td  align=\"center\">" +  oId + '</td>';	        
	var strHtml1 = "<td>" + '<input type="text" id="txtCodigoBarra' + oId + '" name="txtCodigoBarra[]" value="" style="width:80%;" class="validate[required]"/><input type="hidden" id="hidCodigoBarra' + oId + '" name="hidCodigoBarra[]" value=""  /></td>';	
	var strHtml2 = "<td>";
		strHtml2 += '<span class="req">*</span>';
		strHtml2 += '<input type="text" id="txtNombreProducto' + oId + '" name="txtNombreProducto[]" style="width:85%;" class="validate[required]" />';	
		strHtml2 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value=""  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value=""  />';
		strHtml2 += '<input type="hidden" id="hidIdImprenta' + oId + '" name="hidIdImprenta[]" value=""  />';
		strHtml2 += '<input type="hidden" id="hidIdBanner' + oId + '" name="hidIdBanner[]" value=""  />';		
		strHtml2 += '<input type="hidden" id="hidIdImpresion' + oId + '" name="hidIdImpresion[]" value=""  /></td>';
	var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="0" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="0"  /></td>';	
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

		
	Listar_Nombre_Producto_Venta_Auto(oId);
	Listar_Codigo_Barra_Venta_Auto(oId);
	
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

		if ($("#txtCantidad" + oId).val() == 0) 
		{
			alert("La cantidad de Productos debe ser mayor que 0.")
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

	$("#txtCantidad" + oId).click(function(){
		
		Calculadora(oId);
		
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

function Calcular_Total_Cotizacion ()
{
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


function Agregar_Venta()
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);	
	
	var c = 1;
	var msj = "";
	var mensaje = "";
	//alert($("[name='txtCantidad[]']").length);
	while (c <= $("[name='txtCantidad[]']").length)
	{
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

	StrPrecio = JSON.stringify(ArrPrecio);
		
	$.post("application/controllers/VentaController.php?action=Agregar_Venta",
	{
	
		NombreCliente:$("#txtNombreCliente").val(),
		DescripcionVenta:$("#txtDescripcionVenta").val(),		
		TipoVenta:$("#lstTipoVenta").val(),
		Cantidad:StrCantidad,
		Producto:StrProducto,
		Precio:StrPrecio,
		SubTotal:$("#txtSubTotal").val(),
		TotalITBM:$("#txtTotalITBM").val(),
		TotalFinal:$("#txtTotalFinal").val()
		
	}, function(data){

		//alert(data);
		//alert(arrCantidad.length);
		if ((data!="false") & (data!="false1"))
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos",{
			onComplete:function (returnvalue) {

				window.location.href='admin.php?sec='+btoa('agregar_venta_rapida');
				
					/*$.post("library/funciones.php?action=Verificar_Administrador",
					function(data){

						if (data == "true")
						{
							
						}
						else
						{
							window.location.href='admin.php';
						}
				
					});	*/		
				}
			});
		}
		else if (data=="false1")
		Sexy.error("Error guardar los Datos, la Descripci&oacute;n de Venta ya existe en el Sistema.");
		else if (data=="false")
		Sexy.error("Error guardar los Datos");

		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	})

	}

}

function Cancelar_Agregar_Venta_Rapida()
{

	Sexy.confirm('Deseas Cancelar Ventas R&aacute;pidas?.<br />Pulsa &quot;Ok&quot; para continuar, o pulsa &quot;Cancelar&quot; para salir.', {onComplete: 
		function(returnvalue) { 
			if(returnvalue)
			{
				Sexy.info('Datos ingresados no se guardar&aacute;n', {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('agregar_venta_rapida');
					}
				});			
			}

		}
	});
}

function Listar_Ventas_Rapidas()
{
	
	$('#listado_venta_rapida').dataTable( {
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"responsive":true,
		"info": true,
		"ajax": {
			"url": "application/controllers/VentaController.php?action=Listar_Venta_Rapida",	
			"type": "POST",
		},
		"pagingType":"full_numbers",
		"lengthMenu": [[5,10,15,25,50,75,100,150,-1],[5,10,15,25,50,75,100,150,"All"]],
		"pageLength": 10,
		//"paging": true,
		"dom": 'T<"clear">lfrtip',
		"createdRow":function( nRow, aData, iDataIndex ) {
				$(nRow).attr('id', "rowDetalle_"+iDataIndex);
				$(nRow).attr('class', "gradeA");
			},
		"columnDefs": [
			  { "className": "text-center", "targets": [ 0,5 ] },
			  { "searchable": false, "targets": [ 0,2,5 ] },
			  { "orderable": false, "targets": [ 2,5 ] },
			],
		"columns": [
			{ "data": 0 },
			{ "data": 1 },
			{ "data": 2 },
			{ "data": 3 },
			{ "data": 4 },
			{ "data": 5 },		
		],
		"tableTools": {"sSwfPath": "tmp/copy_csv_xls_pdf.swf"},
		"destroy": true,
		"language": {
			"paginate": {
						  "first": "Primera P&aacute;gina",
						  "previous": "Anterior",
						  "next": "Siguiente",
						  "last": "&Uacute;ltima P&aacute;gina",			  
						},
			"emptyTable": "No hay datos disponibles en la tabla",
			"info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
			"infoEmpty": "No hay registros para mostrar",
			"infoFiltered": " - filtrados del total _MAX_ registros",
			"thousands": ",",
			"lengthMenu": "Mostrar _MENU_ registros",
			"loadingRecords": "Por favor, espere - cargando...",
			"processing": "Procesando...",
			"search": "B&uacute;squeda:",
			"zeroRecords": "No hay registros coincidentes encontrados",
			"sortAscending": " - haga clic / volver a ordenar ascendente",
			"sortDescending": " - haga clic / volver a ordenar descendente",
			
		 }			
	});		
	
}


function Ver_Venta_Rapida(id_venta)
{

	$.post("application/controllers/VentaController.php?action=Ver_Venta_Rapida",
	{	
		id:id_venta
	
	}, function(data){
			
			//alert(data);
			window.open(data, 'win3', 'width=1024, height=768,  left=20, top=20, resizable=yes, scrollbars=yes,toolbar=no,location=no,directories=no, status=no,menubar=no');
			//window.location.href='listar_cotizacion.html';
	});
}

function Cerrar_Venta(oId)
{
	var Id = $("#hdnIdCampos_" + oId).val();
	
	$.post("application/controllers/VentaController.php?action=Cerrar_Venta",
	{
		IdVenta:Id	
		
	}, function(data){

		//alert(data);
		if (data=="true")
		{
			$("#rowDetalle_" + oId).remove();			
			Sexy.info("Se ha cerrado la Venta exit&oacute;samente.",{
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_ventas_rapidas');
				}
			});
		}
		else if (data=="false")
		Sexy.error("Error cerrar la Venta.");
	})
	
	return false;

}

function Reporte_Venta_Rapida()
{
	$.post("library/funciones.php?action=Verificar_Administrador",
	function(data){

		if (data == "true")
		{
			/*$.post("application/controllers/VentaController.php?action=Reporte_Venta_Rapida",
			{	
				Desde:$("#txtDesde").val(),
				HoraDesde:$("#txtHoraDesde").val(),
				Hasta:$("#txtHasta").val(),
				HoraHasta:$("#txtHoraHasta").val(),
				Contado:$('#chkContado').is(':checked'),
				Credito:$('#chkCredito').is(':checked')
				
			}, function(data){
					
					
				$("#Reporte_Venta_Rapida").html(data);
				
				oTable = $('.dTable').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					"bLengthChange": true,
					"iDisplayLength": 10,
					"sDom": '<""l>t<"F"fp>',
				});		
			});*/
			
			
			$('#listado_reporte_venta_rapida').dataTable( {
				"processing": true,
				"serverSide": true,
				"ordering": true,
				"responsive":true,
				"info": true,
				"ajax": {
					"url": "application/controllers/VentaController.php?action=Reporte_Venta_Rapida",
					"data": function ( d ) {
						d.Desde = $("#txtDesde").val();
						d.HoraDesde = $("#txtHoraDesde").val();
						d.Hasta = $("#txtHasta").val();
						d.HoraHasta = $("#txtHoraHasta").val();
						d.Contado = $('#chkContado').is(':checked');
						d.Credito = $('#chkCredito').is(':checked');					
					},			
					"type": "POST",
				},
				"pagingType":"full_numbers",
				"lengthMenu": [[5,10,15,25,50,75,100,150,-1],[5,10,15,25,50,75,100,150,"All"]],
				"pageLength": 10,
				//"paging": true,
				"dom": 'T<"clear">lfrtip',
				"createdRow":function( nRow, aData, iDataIndex ) {
						$(nRow).attr('id', "rowDetalle_"+iDataIndex);
						$(nRow).attr('class', "gradeA");
					},
				"columnDefs": [
					  { "className": "text-center", "targets": [ 0,8 ] },
					  { "searchable": false, "targets": [ 0,8 ] },
					  { "orderable": false, "targets": [ 8 ] },
					],
				"columns": [
					{ "data": 0 },
					{ "data": 1 },
					{ "data": 2 },
					{ "data": 3 },
					{ "data": 4 },
					{ "data": 5 },
					{ "data": 6 },
					{ "data": 7 },
					{ "data": 8 },
		
				],
				"tableTools": {"sSwfPath": "tmp/copy_csv_xls_pdf.swf"},
				"destroy": true,
				"language": {
					"paginate": {
								  "first": "Primera P&aacute;gina",
								  "previous": "Anterior",
								  "next": "Siguiente",
								  "last": "&Uacute;ltima P&aacute;gina",			  
								},
					"emptyTable": "No hay datos disponibles en la tabla",
					"info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
					"infoEmpty": "No hay registros para mostrar",
					"infoFiltered": " - filtrados del total _MAX_ registros",
					"thousands": ",",
					"lengthMenu": "Mostrar _MENU_ registros",
					"loadingRecords": "Por favor, espere - cargando...",
					"processing": "Procesando...",
					"search": "B&uacute;squeda:",
					"zeroRecords": "No hay registros coincidentes encontrados",
					"sortAscending": " - haga clic / volver a ordenar ascendente",
					"sortDescending": " - haga clic / volver a ordenar descendente",
					
				 }			
			});			
			
			
		}
		else
		{
				
			Sexy.error("Usted no tiene permiso para Acceder Reporte de Ventas Rápida.",{
			onComplete:function (returnvalue) {

					window.location.href='admin.php';
				}
			});
		}
		
	});

}

function Listar_Detalles_Ventas()
{
	
	/*$("#Lista_Detalles_Ventas").load("application/controllers/VentaController.php?action=Listar_Detalles_Ventas",function(){
	
		oTable = $('.dTable').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": true,
			"iDisplayLength": 10,
			"sDom": '<""l>t<"F"fp>'
		});
	
	});*/
	
	$('#listado_detalle_venta').dataTable( {
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"responsive":true,
		"info": true,
		"ajax": {
			"url": "application/controllers/VentaController.php?action=Listar_Detalles_Ventas",		
			"type": "POST",
		},
		"pagingType":"full_numbers",
		"lengthMenu": [[5,10,15,25,50,75,100,150,-1],[5,10,15,25,50,75,100,150,"All"]],
		"pageLength": 10,
		//"paging": true,
		"dom": 'T<"clear">lfrtip',
		"createdRow":function( nRow, aData, iDataIndex ) {
				$(nRow).attr('id', "rowDetalle_"+iDataIndex);
				$(nRow).attr('class', "gradeA");
			},
		"columnDefs": [
			  { "className": "text-center", "targets": [ 0,8 ] },
			  { "searchable": false, "targets": [ 0,8 ] },
			  { "orderable": false, "targets": [ 8 ] },
			],
		"order": [[ 1, "desc" ]],
		"columns": [
			{ "data": 0 },
			{ "data": 1 },
			{ "data": 2 },
			{ "data": 3 },
			{ "data": 4 },
			{ "data": 5 },
			{ "data": 6 },
			{ "data": 7 },
			{ "data": 8 },
		],
		"tableTools": {"sSwfPath": "tmp/copy_csv_xls_pdf.swf"},
		"destroy": true,
		"language": {
			"paginate": {
						  "first": "Primera P&aacute;gina",
						  "previous": "Anterior",
						  "next": "Siguiente",
						  "last": "&Uacute;ltima P&aacute;gina",			  
						},
			"emptyTable": "No hay datos disponibles en la tabla",
			"info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
			"infoEmpty": "No hay registros para mostrar",
			"infoFiltered": " - filtrados del total _MAX_ registros",
			"thousands": ",",
			"lengthMenu": "Mostrar _MENU_ registros",
			"loadingRecords": "Por favor, espere - cargando...",
			"processing": "Procesando...",
			"search": "B&uacute;squeda:",
			"zeroRecords": "No hay registros coincidentes encontrados",
			"sortAscending": " - haga clic / volver a ordenar ascendente",
			"sortDescending": " - haga clic / volver a ordenar descendente",
			
		 }			
	});	
	
}

function Imprimir_Detalle_Venta(id_cotizacion)
{

//alert(id_cotizacion);
	$.post("application/controllers/CotizacionController.php?action=Imprimir_Detalle_Venta",
	{	
		id:id_cotizacion
	
	}, function(data){
			
			
			window.open(data, 'win3', 'width=1024, height=768,  left=20, top=20, resizable=yes, scrollbars=yes,toolbar=no,location=no,directories=no, status=no,menubar=no');
			//window.location.href='listar_cotizacion.html';
	});
}

function Listar_Producto_Buscar_Venta_Rapida_Auto()
{
	$("#txtProductoBuscar").autocomplete({
		source: "application/controllers/ProductoController.php?action=Listar_Producto_Venta_Rapida_Autocompletar",
		select:  function(event, ui) {

			$("#txtProductoBuscar").val(ui.item.value);
			$("#hidProductoBuscar").val(ui.item.hidProductoBuscar);
			Agregar_Articulo_Venta_x_Nombre_Producto(ui.item.hidProductoBuscar);			

		},
		change: function (event, ui) {

			if (ui.item === null)
			{	
				$("#txtProductoBuscar").val("");					
				$("#hidProductoBuscar").val("");		
			}
			else
			{
				
				$("#txtProductoBuscar").val(ui.item.value);
				$("#hidProductoBuscar").val(ui.item.hidProductoBuscar);
				Agregar_Articulo_Venta_x_Nombre_Producto(ui.item.hidProductoBuscar);
			}				
		}

	});		
}

function Listar_Producto_Venta_Rapida_Auto()
{
	$("#txtBuscarProducto").autocomplete({
		source: "application/controllers/ProductoController.php?action=Listar_Producto_Venta_Rapida_Autocompletar",
		select:  function(event, ui) {

			$("#txtBuscarProducto").val(ui.item.value);
			$("#hidBuscarProducto").val(ui.item.hidBuscarProducto);
			Listar_Productos_por_Busqueda(ui.item.hidBuscarProducto);			

		},
		change: function (event, ui) {

			if (ui.item === null)
			{	
				$("#txtBuscarProducto").val("");					
				$("#hidBuscarProducto").val("");		
			}
			else
			{
				
				$("#txtBuscarProducto").val(ui.item.value);
				$("#hidBuscarProducto").val(ui.item.hidBuscarProducto);
				Listar_Productos_por_Busqueda(ui.item.hidBuscarProducto);
			}				
		}

	});		

}

function Listar_Productos_por_Busqueda(Prod)
{
	//alert(Cat);

	$.post("application/controllers/ProductoController.php?action=Listar_Productos_por_Busqueda",
	{
		BuscarProducto:Prod		
	}
	, function(data){		
	
		//alert(data);
		$("#carousel_prod_list_cat").html(data);
		
		Listar_Producto_Venta_Rapida_Auto();
	
		var options3 = {
	
			$BulletNavigatorOptions: {                                	//[Optional] Options to specify and enable navigator or not
				$Class: $JssorBulletNavigator$,                       	//[Required] Class to create navigator instance
				$ChanceToShow: 2,                               		//[Required] 0 Never, 1 Mouse Over, 2 Always
				$AutoCenter: 1,                                  		//[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
				$SpacingX: 25	                                 		//[Optional] Horizontal space between each item in pixel, default value is 0			
			},
			
			$ArrowNavigatorOptions: {
				$Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
				$ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
				$AutoCenter: 2,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
				$Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
			},
				
		};

        var jssor_sliderb3 = new $JssorSlider$("ListadoProductoCategoria", options3);
	
	});	
}

function Agregar_Articulo_Venta_x_Codigo_Barra()
{
	$.post("application/controllers/VentaController.php?action=Agregar_Articulo_Venta_x_Codigo_Barra",
	{
		CodigoBarra:$("#txtCodigoBarra").val()
		
	},function(data){	
	
		//alert(data);
		if (data != "")
		Agregar_Articulo_Venta(data);
		
	});	
}

function Agregar_Articulo_Venta_x_Nombre_Producto()
{
	$.post("application/controllers/VentaController.php?action=Agregar_Articulo_Venta_x_Nombre_Producto",
	{
		ProductoBuscar:$("#hidProductoBuscar").val()
		
	},function(data){	
	
		//alert(data);
		if (data != "")
		Agregar_Articulo_Venta(data);
		
	});	
}

function Agregar_Articulo_Venta(Prod)
{
	if($("#cant_campos").val() == 0)
	$("#tbDetalle").empty();
	
	var Repetido = false;
	$("input[name='hidIdProducto[]']").each(function () {

		var oId = $(this).attr('id');
		oId = oId.substr(13);		
		
		if($(this).val() == Prod)
		{
			Repetido = true;
			$("#txtCantidad" + oId).val(parseInt($("#txtCantidad" + oId).val()) + 1);
			$("#txtTotal" + oId).val(ConvertirMoneda($("#txtPrecio" + oId).val()*$("#txtCantidad" + oId).val()));
			$("#hidCantidad" + oId).val($("#txtCantidad" + oId).val());
			$("#hidTotal" + oId).val($("#txtTotal" + oId).val());
			Calcular_Total_Cotizacion ();
		}
		
	});	
	
	if (Repetido === false)
	{
		$.post("application/controllers/VentaController.php?action=Agregar_Articulo_Venta",
		{
			
			IdProducto:Prod
			
		},function(data){

		
			//alert(data);
			var item = JSON.parse(data);
			
			Calcular_Total_Cotizacion ();
			
			$("#cant_campos").val(parseInt($("#cant_campos").val()) + 1);
			var oId = $("#cant_campos").val();

			var strHtml0= "<td  align=\"center\">" +  oId + '</td>';	        
			var strHtml1 = "<td>" + '<input type="text" id="txtCodigoBarra' + oId + '" name="txtCodigoBarra[]" value="'+ item[0].txtCodigoBarra +'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidCodigoBarra' + oId + '" name="hidCodigoBarra[]" value="'+ item[0].hidCodigoBarra +'"  /></td>';	
			var strHtml2 = "<td>";
				strHtml2 += '<span class="req">*</span>';
				strHtml2 += '<input type="text" id="txtProducto' + oId + '" name="txtProducto[]" style="width:85%;" class="validate[required]" value="'+ item[0].txtProducto +'" />';	
				strHtml2 += '<input type="hidden" id="hidIdProducto' + oId + '" name="hidIdProducto[]" value="'+ item[0].hidIdProducto +'"  /><input type="hidden" id="hidDescProducto' + oId + '" name="hidDescProducto[]" value="'+ item[0].hidDescProducto +'"  />';
				strHtml2 += '<input type="hidden" id="hidIdImprenta' + oId + '" name="hidIdImprenta[]" value=""  />';
				strHtml2 += '<input type="hidden" id="hidIdBanner' + oId + '" name="hidIdBanner[]" value=""  />';		
				strHtml2 += '<input type="hidden" id="hidIdImpresion' + oId + '" name="hidIdImpresion[]" value=""  /></td>';
			var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtCantidad' + oId + '" name="txtCantidad[]" value="1" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad' + oId + '" name="hidCantidad[]" value="1"  /></td>';			
			var strHtml4 = "<td>" + '<input type="text" id="txtPrecio' + oId + '" name="txtPrecio[]" value="'+ item[0].txtPrecio +'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio' + oId + '" name="hidPrecio[]" value="'+ item[0].txtPrecio +'"  /></td>';
			var strHtml5 = "<td>" + '<input type="text" id="txtTotal' + oId + '" name="txtTotal[]" value="'+ item[0].txtTotal +'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal' + oId + '" name="hidTotal[]" value="'+ item[0].txtTotal +'"  /></td>';

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

			var strHtmlSubTotal0= '<th  align="right" colspan="5">Sub-Total:</th>';	
			var strHtmlSubTotal1 = '<th align="center" >' + '<input type="text" id="txtSubTotal" name="txtSubTotal" value="0.00" style="width:80%;text-align:right;"  readonly="readonly"/><input type="hidden" id="hidSubTotal" name="hidSubTotal" value=""  /></th>';
			var strHtmlSubTotal2= '<th  align="center"></th>';	
			var strHtmlTotalITBM0= '<th  align="right" colspan="5">ITBMS:</th>';	
			var strHtmlTotalITBM1 = '<th align="center" >' + '<input type="text" id="txtTotalITBM" name="txtTotalITBM" value="0.00" style="width:80%;text-align:right;"  readonly="readonly"/><input type="hidden" id="hidTotalITBM" name="hidTotalITBM" value=""  /></th>';
			var strHtmlTotalITBM2= '<th  align="center"></th>';		
			var strHtmlTotal0= '<th  align="right" colspan="5">Total Final:</th>';	
			var strHtmlTotal1 = '<th align="center" >' + '<input type="text" id="txtTotalFinal" name="txtTotalFinal" value="0.00" style="width:80%;text-align:right;"  readonly="readonly"/><input type="hidden" id="hidTotalFinal" name="hidTotalFinal" value=""  /></th>';
			var strHtmlTotal2= '<th  align="center"></th>';
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
			Calcular_Total_Cotizacion ();
			Listar_Producto_Auto(oId);
			
			//alert($("input[name='txtProducto[]']").inArray("Tinta")
			
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

				if ($("#txtCantidad" + oId).val() == 0) 
				{
					alert("La cantidad de Productos debe ser mayor que 0.")
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
			
			$("#txtCantidad" + oId).click(function(){
				
				Calculadora(oId);
				
			});
			
			return false;		
		});
	}
}
