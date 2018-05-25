function Listar_Ubicacion(oId,Ubicacion)
{
	if (oId != undefined)
	{	
		
		$("#lstUbicacion" + oId).load("application/controllers/UbicacionController.php?action=Listar_Ubicacion",
		function(data) {

			$("#lstUbicacion" + oId).find('option').remove().end().append('<option value="" title="Seleccione la Ubicaci&oacute;n" >Seleccione</option>');
			$("#lstUbicacion" + oId).append(data);	
		
			$("#lstUbicacion" + oId + " option[value='" + Ubicacion + "']").attr("selected",true);
			$("#uniform-lstUbicacion").children("span").html($("#lstUbicacion option:selected").text());					
		});
	}
	else
	{
		$("#lstUbicacion").load("application/controllers/UbicacionController.php?action=Listar_Ubicacion",
		function(data) {

			$("#lstUbicacion").find('option').remove().end().append('<option value="">Seleccione la Ubicaci&oacute;n</option>');
			$("#lstUbicacion").append(data);	
		
			$("#lstUbicacion option[value='" + Ubicacion + "']").attr("selected",true);
			$("#uniform-lstUbicacion").children("span").html($("#lstUbicacion option:selected").text());					
		});
	}
}

function Verificar_Codigo_Producto()
{
	$.post("application/controllers/ProductoController.php?action=Verificar_Codigo_Producto",
	{
		hidCodigoProducto:$("#hidCodigoProducto").val(),
		CodigoProducto:$("#txtCodigoProducto").val()
	},
	function(data){	
	
		if (data=="false")
		{
			$("#txtCodigoProducto").val("");
			Sexy.error("El C&oacute;digo de Producto ya Existe en el Sistema Favor Verificar.");	
		}
		
	});
	
}

function Verificar_Codigo_Barra()
{
	$.post("application/controllers/ProductoController.php?action=Verificar_Codigo_Barra",
	{
		CodigoBarra:$("#txtCodigoBarra").val()
	},
	function(data){	
	
		if (data=="false")
		{
			$("#txtCodigoBarra").val("");
			Sexy.error("El C&oacute;digo de Barra ya Existe en el Sistema Favor Verificar.");	
		}	
	});
}

function Listar_Tipo_Descripcion_Producto_Auto()
{
	$("#txtTipo").autocomplete({
		source: "application/controllers/ProductoController.php?action=Listar_Tipo_Descripcion_Producto_Autocompletar",
		select:  function(event, ui) {

			$("#hidTipo").val(ui.item.hidTipo);
			$("#txtNombreProducto").val(ui.item.value + " "  + $("#txtMarca").val() + " " + $("#txtModelo").val() + " " + $("#txtColor").val() + " " + $("#txtTamano").val());				

			
		},
		change: function (event, ui) {

			$.post("application/controllers/ProductoController.php?action=Listar_Tipo_Descripcion_Producto_Autocompletar",
			{
				Tipo:$("#txtTipo").val()
			},
			function(data){

				var item = JSON.parse(data);
				
				if (item === null)
				{
					$("#hidTipo").val("");
					$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " "  + $("#txtTamano").val());				
					
				}
				else
				{
					$("#hidTipo").val(item[0].hidTipo);
					$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " " + $("#txtTamano").val());					
				}					
			
			});					
		}
	});
	
	return false
	
}

function Listar_Proveedor_Auto()
{
	$("#txtProveedor").autocomplete({
		source: "application/controllers/ProveedorController.php?action=Listar_Proveedor_Autocompletar",
		select:  function(event, ui) {

			$("#hidProveedor").val(ui.item.hidProveedor);
			$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " "  + $("#txtTamano").val());				
			//Calcular_Precio_Venta();
			
		},
		change: function (event, ui) {
			
			$.post("application/controllers/ProveedorController.php?action=Listar_Proveedor_Autocompletar",
			{
				Fabricante:$("#txtProveedor").val()
			},
			function(data){
			
				var item = JSON.parse(data);
				
				if (item === null)
				{
					$("#txtProveedor").val("");
					$("#hidProveedor").val("");
					$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " "  + $("#txtTamano").val());				
					
					
					Sexy.confirm('El Nombre de Proveedor no existe en el Sistema.<br />Pulsa &quot;Ok&quot; si Deseas agregar Proveedor, o pulsa &quot;Cancelar&quot; para salir y escoger otro Proveedor.', {onComplete: 
						function(returnvalue) { 
							if(returnvalue)
							{
								window.location.href='admin.php?sec='+btoa('agregar_proveedor');	
							}
						}
					});
				}
				else
				{
					$("#hidProveedor").val(item[0].hidProveedor);
					$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " "  + $("#txtTamano").val());					
					//Calcular_Precio_Venta();
				}					
			
			});					
		}
	});
	
	return false
	
}


function Listar_Marcas_Auto()
{
	$("#txtMarca").autocomplete({
		source: "application/controllers/ProductoController.php?action=Listar_Marcas_Autocompletar",
		select:  function(event, ui) {

			$("#hidMarca").val(ui.item.hidMarca);
			$("#txtNombreProducto").val($("#txtTipo").val() + " "  + ui.item.value + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " " + $("#txtTamano").val());				

			
		},
		change: function (event, ui) {

			$.post("application/controllers/ProductoController.php?action=Listar_Marcas_Autocompletar",
			{
				Marca:$("#txtMarca").val()
			},
			function(data){

				var item = JSON.parse(data);
				
				if (item === null)
				{
					$("#hidMarca").val("");
					$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " "  + $("#txtTamano").val());				
					
				}
				else
				{
					$("#hidMarca").val(item[0].hidMarca);
					$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " "  + $("#txtTamano").val());					
				}					
			
			});					
		}
	});
	
	return false
	
}

function Listar_Modelos_Auto()
{
	
	$("#txtModelo").autocomplete({
		source: "application/controllers/ProductoController.php?action=Listar_Modelos_Autocompletar",
		select:  function(event, ui) {
			
			$("#hidModelo").val(ui.item.hidModelo);
			$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + ui.item.value + " " + $("#txtColor").val() + " "  + $("#txtTamano").val());				
			
			
		},
		change: function (event, ui) {
				
			$.post("application/controllers/ProductoController.php?action=Listar_Modelos_Autocompletar",
			{
				Modelo:$("#txtModelo").val()
			},
			function(data){

				var item = JSON.parse(data);
				
				if (item === null)
				{
					$("#hidModelo").val("");
					$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " "  + $("#txtTamano").val());				

				}
				else
				{
					$("#hidModelo").val(item[0].hidModelo);
					$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " "  + $("#txtTamano").val());				

				}					
			
			});				
		}
	});
	
}

function Listar_Tamanos_Auto()
{
	
	$("#txtTamano").autocomplete({
		source: "application/controllers/ProductoController.php?action=Listar_Tamanos_Autocompletar",
		select:  function(event, ui) {
			
			$("#hidTamano").val(ui.item.hidTamano);
			$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " "  + ui.item.value);				

			
		},
		change: function (event, ui) {
		
			$.post("application/controllers/ProductoController.php?action=Listar_Tamanos_Autocompletar",
			{
				Tamano:$("#txtTamano").val()			
			},
			function(data){
			
				var item = JSON.parse(data);
				
				if (item === null)
				{
					$("#hidTamano").val("");
					$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " " + $("#txtTamano").val());				
					
				}
				else
				{
					$("#hidTamano").val(item[0].hidTamano);
					$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " " + $("#txtTamano").val());				
					
				}					
			
			});				
		}
	});
	
}

function Listar_Colores_Auto()
{
	
	$("#txtColor").autocomplete({
		source: "application/controllers/ProductoController.php?action=Listar_Colores_Autocompletar",
		select:  function(event, ui) {
			
			$("#hidColor").val(ui.item.hidColor);
			$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + ui.item.value + " "  + $("#txtTamano").val());				

			
		},
		change: function (event, ui) {
		
			$.post("application/controllers/ProductoController.php?action=Listar_Colores_Autocompletar",
			{
				Color:$("#txtColor").val()
			},
			function(data){
			
				var item = JSON.parse(data);
				
				if (item === null)
				{
					$("#hidColor").val("");
					$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " "  + $("#txtTamano").val());					
				}
				else
				{
					$("#hidColor").val(item[0].hidColor);
					$("#txtNombreProducto").val($("#txtTipo").val() + " "  + $("#txtMarca").val() + " "  + $("#txtModelo").val() + " " + $("#txtColor").val() + " "  + $("#txtTamano").val());				
					
				}					
			
			});	
			
		}
	});
	
}


function Listar_Tipo_Producto(TipoProducto,TipoCategoria,TipoPaquete)
{
	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	var sec;
	if(getURLParameter('sec') === undefined)
	sec = "";
	else
	sec = getURLParameter('sec');	

	if (((filename == "admin.php") & (sec==btoa("agregar_producto"))) | ((filename == "admin.php") & (sec==btoa("editar_producto"))))
	{		
	
		if ((filename == "admin.php") & (sec==btoa("agregar_producto")))
		{
			$("#txtCodigoProducto").val("");
			$("#hidCodigoProducto").val("");
			$("#txtCodigoBarra").val("");
			$("#txtCosto").val("0.00");
			$("#txtPrecioVenta").val("0.00");
			$("#txtTipo").val("");
			$("#txtNombreProducto").val("");
			$("#txtDescripcionProducto").val("");
			$("#txtProveedor").val("");
			$("#hidProveedor").val("");	
			$("#txtMarca").val("");
			$("#hidMarca").val("");
			$("#txtModelo").val("");
			$("#hidModelo").val("");
			$("#txtColor").val("");
			$("#hidColor").val("");
			$("#txtTamano").val("");
			$("#hidTamano").val("");
			$("#lstTipoPaquete").val("");
			$("#lstTipoCategoria").val("");
			$("#lstUbicacion").val("");
			//$("#txtCantExistInicial").val("");
			$("#txtCantMin").val("");
			$("#txtCantAlertMin").val("");
		}
			
		$("#txtNombreProducto").attr("readonly",true);
		$("#txtPrecioVenta").attr("readonly",true);
		$("#txtDescripcionProducto").attr("readonly",true);
		$("#DescripcionProducto").hide();
		$("#CodigoProducto").hide();
		$("#CodigoBarra").hide();
		$("#Costo").hide();
		$("#TipoCategoria").hide();
		$("#Ubicacion").hide();		
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
		GenerarCategoria(undefined,TipoCategoria);
	}	


	$("#lstTipoProducto").load("application/controllers/ProductoController.php?action=Listar_Tipo_Producto",
	function(data) {

		$("#lstTipoProducto").find('option').remove().end().append('<option value="">Seleccione el Tipo de Producto</option>');
		$("#lstTipoProducto").append(data);	
		
		$("#lstTipoProducto option[value='" + TipoProducto + "']").attr("selected",true);

		$("#uniform-lstTipoProducto").children("span").html($("#lstTipoProducto option:selected").text());
		
		if((filename == "admin.php") & (sec==btoa("editar_producto")))
		{	
			if($("#lstTipoProducto").prop("selectedIndex")==1)
			{
				$("#txtNombreProducto").attr("readonly",false);
				$("#txtPrecioVenta").attr("readonly",false);
				$("#DescripcionProducto").show();
				$("#txtDescripcionProducto").attr("readonly",false);				
				$("#CodigoProducto").hide();
				$("#CodigoBarra").show();
				$("#Costo").hide();
				$("#TipoCategoria").hide();
				$("#Ubicacion").hide();
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
				
				$("#PageTitle").html("Editar Producto - Servicio");
			}
			else if($("#lstTipoProducto").prop("selectedIndex")==2)
			{
				$("#CodigoProducto").show();
				$("#CodigoBarra").show();
				$("#Costo").show();
				$("#TipoCategoria").show();
				$("#Ubicacion").show();
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
				$("#txtNombreProducto").attr("readonly",true);
				$("#txtPrecioVenta").attr("readonly",false);
				$("#txtDescripcionProducto").attr("readonly",true);	
				$("#DescripcionProducto").hide();	
				Listar_Marcas_Auto();
				Listar_Modelos_Auto();
				Listar_Colores_Auto();
				Listar_Tamanos_Auto();
				GenerarTipoEmpaque(undefined,TipoPaquete);
				$("#PageTitle").html("Editar Producto - Producto");						
			}
			else
			{
				$("#txtNombreProducto").attr("readonly",true);
				$("#txtPrecioVenta").attr("readonly",true);
				$("#txtDescripcionProducto").attr("readonly",true);
				$("#DescripcionProducto").hide();
				$("#CodigoProducto").hide();
				$("#CodigoBarra").hide();
				$("#Costo").hide();
				$("#TipoCategoria").hide();
				$("#Ubicacion").hide();
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
				$("#PageTitle").html("Editar Producto");
			}
		}

		$("#lstTipoProducto").change(function(){

			$("#txtCodigoProducto").val("");
			$("#hidCodigoProducto").val("");
			$("#txtCodigoBarra").val("");
			$("#txtCosto").val("0.00");
			$("#txtPrecioVenta").val("0.00");
			$("#txtTipo").val("");
			$("#txtNombreProducto").val("");
			$("#txtDescripcionProducto").val("");
			$("#txtProveedor").val("");
			$("#hidProveedor").val("");			
			$("#txtMarca").val("");
			$("#hidMarca").val("");
			$("#txtModelo").val("");
			$("#hidModelo").val("");
			$("#txtColor").val("");
			$("#hidColor").val("");
			$("#txtTamano").val("");
			$("#hidTamano").val("");
			$("#lstTipoPaquete").val("");
			$("#lstTipoCategoria").val("");
			$("#lstUbicacion").val("");
			//$("#txtCantExistInicial").val("");
			$("#txtCantMin").val("");
			$("#txtCantAlertMin").val("");			
		
			if($("#lstTipoProducto").prop("selectedIndex")==1)
			{
				$("#txtNombreProducto").attr("readonly",false);
				$("#txtPrecioVenta").attr("readonly",false);
				$("#DescripcionProducto").show();
				$("#txtDescripcionProducto").attr("readonly",false);				
				$("#CodigoProducto").hide();
				$("#CodigoBarra").show();
				$("#Costo").hide();
				$("#TipoCategoria").hide();
				$("#Ubicacion").hide();
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
			else if($("#lstTipoProducto").prop("selectedIndex")==2)
			{
				$("#CodigoProducto").show();
				$("#CodigoBarra").show();
				$("#Costo").show();
				$("#TipoCategoria").show();
				$("#Ubicacion").show();
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
				$("#txtNombreProducto").attr("readonly",true);	
				$("#txtPrecioVenta").attr("readonly",false);
				$("#txtDescripcionProducto").attr("readonly",true);
				$("#DescripcionProducto").hide();
				Listar_Marcas_Auto();
				Listar_Modelos_Auto();
				Listar_Colores_Auto();
				Listar_Tamanos_Auto();
				GenerarTipoEmpaque(undefined,TipoPaquete);
				$("#PageTitle").html("Agregar Producto - Producto");			
			}
			else
			{
				$("#txtNombreProducto").attr("readonly",true);
				$("#txtPrecioVenta").attr("readonly",true);
				$("#txtDescripcionProducto").attr("readonly",true);
				$("#DescripcionProducto").hide();
				$("#CodigoProducto").hide();
				$("#CodigoBarra").hide();
				$("#Costo").hide();
				$("#TipoCategoria").hide();
				$("#Ubicacion").hide();
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
				$("#PageTitle").html("Agregar Producto");
			}		
		
		
		});		
		
	});
		
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
			
			$("#lstTipoCategoria" + oId + " option[value='" + TipoCategoria + "']").attr("selected",true);
			
			$("#uniform-lstTipoCategoria" + oId).children("span").html($("#lstTipoCategoria" + oId + " option:selected").text());					
		});
	}
	else
	{	
		$("#lstTipoCategoria").load("application/controllers/ProductoController.php?action=Listar_Tipo_Categoria",
		function(data) {

		
			$("#lstTipoCategoria").find('option').remove().end().append('<option value="">Seleccione el Tipo de Categor&iacute;a</option>');
			$("#lstTipoCategoria").append(data);		

			$("#lstTipoCategoria option[value='" + TipoCategoria + "']").attr("selected",true);
			
			$("#uniform-lstTipoCategoria").children("span").html($("#lstTipoCategoria option:selected").text());				
		});
	}
}

function GenerarCategoriaVolumen(oId,TipoCategoria)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		$("#lstTipoCategoria" + oId).load("application/controllers/ProductoController.php?action=Tipo_Volumen_Imprenta",
		function(data) {

			$("#lstTipoCategoria" + oId).find('option').remove().end().append('<option value="">Seleccione el Tipo de Categor&iacute;a</option>');
			$("#lstTipoCategoria" + oId).append(data);	
			
			$("#lstTipoCategoria" + oId + " option[value='" + TipoCategoria + "']").attr("selected",true);
			
			$("#uniform-lstTipoCategoria" + oId).children("span").html($("#lstTipoCategoria" + oId + " option:selected").text());				
		});
	}
	else
	{	
		$("#lstTipoCategoria").load("application/controllers/ProductoController.php?action=Tipo_Volumen_Imprenta",
		function(data) {

		
			$("#lstTipoCategoria").find('option').remove().end().append('<option value="">Seleccione el Tipo de Categor&iacute;a</option>');
			$("#lstTipoCategoria").append(data);

			$("#lstTipoCategoria option[value=" + TipoCategoria + "]").attr("selected",true);
			
			$("#uniform-lstTipoCategoria").children("span").html($("#lstTipoCategoria option:selected").text());				

		});
	}
}

function GenerarCategoriaVolumenImpresion(oId,TipoCategoria)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		$("#lstTipoCategoria" + oId).load("application/controllers/ProductoController.php?action=Tipo_Volumen_Impresion",
		function(data) {

			$("#lstTipoCategoria" + oId).find('option').remove().end().append('<option value="">Seleccione el Tipo de Categor&iacute;a</option>');
			$("#lstTipoCategoria" + oId).append(data);	
			
			$("#lstTipoCategoria" + oId + " option[value='" + TipoCategoria + "']").attr("selected",true);
			
			$("#uniform-lstTipoCategoria" + oId).children("span").html($("#lstTipoCategoria" + oId + " option:selected").text());				
		});
	}
	else
	{	
		$("#lstTipoCategoria").load("application/controllers/ProductoController.php?action=Tipo_Volumen_Impresion",
		function(data) {

		
			$("#lstTipoCategoria").find('option').remove().end().append('<option value="">Seleccione el Tipo de Categor&iacute;a</option>');
			$("#lstTipoCategoria").append(data);	
			
			$("#lstTipoCategoria option[value='" + TipoCategoria + "']").attr("selected",true);
			
			$("#uniform-lstTipoCategoria").children("span").html($("#lstTipoCategoria option:selected").text());	
		});
	}
}

function GenerarTipoEmpaque(oId,TipoPaquete)
{
	if (oId != undefined)
	{
		$("#lstTipoPaquete" + oId).load("application/controllers/ProductoController.php?action=Listar_Tipo_Empaque",
		function(data) {
		
			$("#lstTipoPaquete" + oId).find('option').remove().end().append('<option value="">Seleccione el Tipo de Paquete</option>');
			$("#lstTipoPaquete" + oId).append(data);

			$("#lstTipoPaquete" + oId + " option[value='" + TipoPaquete + "']").attr("selected",true);
			
			$("#uniform-lstTipoPaquete" + oId).children("span").html($("#lstTipoPaquete" + oId + " option:selected").text());				
		});	
	}
	else
	{	
	
		$("#lstTipoPaquete").load("application/controllers/ProductoController.php?action=Listar_Tipo_Empaque",
		function(data) {  
	
			$("#lstTipoPaquete").find('option').remove().end().append('<option value="">Seleccione el Tipo de Paquete</option>');
			$("#lstTipoPaquete").append(data);

			$("#lstTipoPaquete option[value='" + TipoPaquete + "']").attr("selected",true);
			
			$("#uniform-lstTipoPaquete").children("span").html($("#lstTipoPaquete option:selected").text());			

		});
	}
}


function Calcular_Precio(oId)
{
	if (oId != undefined)
	{	
		if ($("#txtCosto"+oId).val() == undefined)
		{		
			$.post("application/controllers/ProductoController.php?action=Calcular_Precio",
			{
				Costo:$("#hidCosto"+oId).val(),
				TipoCategoria:$("#hidTipoCategoria"+oId).val()
			}, function(data){
		
				$("#txtPrecioVenta"+oId).val(data);
				$("#hidPrecioVenta"+oId).val(data);
		
			})
		}
		else
		{

		
			$.post("application/controllers/ProductoController.php?action=Calcular_Precio",
			{
				Costo:$("#txtCosto"+oId).val(),
				TipoCategoria:$("#lstTipoCategoria"+oId).val()
			}, function(data){
		
				$("#txtPrecioVenta"+oId).val(data);
				$("#hidPrecioVenta"+oId).val(data);
		
			})
		}		
	}
	else
	{

		$.post("application/controllers/ProductoController.php?action=Calcular_Precio",
		{
			Costo:$("#txtCosto").val(),
			TipoCategoria:$("#lstTipoCategoria").val()
		}, function(data){
			//alert(data);
			$("#txtPrecioVenta").val(data);
		
		})

	}	
}

function Agregar_Producto()
{		
	$.post("application/controllers/ProductoController.php?action=Agregar_Producto",
	{
		IdTipoProducto:$("#lstTipoProducto").val(),
		NombreProducto:$("#txtNombreProducto").val(),
		CodigoBarra:$("#txtCodigoBarra").val(),
		CodigoProducto:$("#hidCodigoProducto").val(),
		IdTipo:$("#hidTipo").val(),
		Tipo:$("#txtTipo").val(),	
		IdProveedor:$("#hidProveedor").val(),
		Proveedor:$("#txtProveedor").val(),		
		IdMarca:$("#hidMarca").val(),
		Marca:$("#txtMarca").val(),
		IdModelo:$("#hidModelo").val(),
		Modelo:$("#txtModelo").val(),
		IdTamano:$("#hidTamano").val(),		
		Tamano:$("#txtTamano").val(),
		IdColor:$("#hidColor").val(),			
		Color:$("#txtColor").val(),
		Costo:$("#txtCosto").val(),
		TipoCategoria:$("#lstTipoCategoria").val(),
		Ubicacion:$("#lstUbicacion").val(),
		TipoPaquete:$("#lstTipoPaquete").val(),
		PrecioVenta:$("#txtPrecioVenta").val(),			
		//CantExistInicial:$("#txtCantExistInicial").val(),		
		CantMin:$("#txtCantMin").val(),		
		ObservacionProducto:$("#txtObservacionProducto").val()
	}, function(data){

		if (data)
		{
			console.log("Data ->>> ",data);
			Sexy.info("Se ha guardado exit&oacute;samente los Datos",{
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_productos');
				}
			});
		}
		else if (!data)
		Sexy.error("Error guardar los Datos");
	});
}

function Cancelar_Agregar_Producto()
{

	Sexy.confirm('Deseas Regresar al Listado de Productos?.<br />Pulsa &quot;Ok&quot; para continuar, o pulsa &quot;Cancelar&quot; para salir.', {onComplete: 
		function(returnvalue) { 
			if(returnvalue)
			{
				Sexy.info('Datos ingresados no se guardar&aacute;n', {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('listar_productos');
					}
				});			
			}

		}
	});
}

function Listar_Productos()
{
	/*$("#Lista_Productos").load("application/controllers/ProductoController.php?action=Listar_Productos",function(){
	
		oTable = $('.dTable').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": true,
			"iDisplayLength": 10,
			"sDom": '<""l>t<"F"fp>'
		});
	
	});*/
	
		$('#listado_producto').dataTable( {
			"processing": true,
			"serverSide": true,
			"ordering": true,
			"info": true,
			"ajax": {
				"url": "application/controllers/ProductoController.php?action=Listar_Productos",		
				"type": "POST",
				"data": "tableData"
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
				  { "className": "text-center", "targets": [ 0,7 ] },
				  { "searchable": false, "targets": [ 0,7 ] },
				  { "orderable": false, "targets": [ 7 ] },
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
		} );	
	
}

function Ver_Producto(Id)
{
	
	$.post("application/controllers/ProductoController.php?action=Ver_Producto",
	{
		IdProducto:Id
	}
	,function(data){

		var item = JSON.parse(data);
		console.log("EDITAR PRODUCTO data -> ",item);


		Listar_Tipo_Producto(item[0].lstTipoProducto,item[0].lstCategoria,item[0].lstTipoPaquete);
		Listar_Ubicacion(undefined,item[0].lstUbicacion);
		GenerarCategoria(undefined,item[0].lstCategoria);
		GenerarTipoEmpaque(undefined,item[0].lstTipoPaquete);
		$("#txtCodigoProducto").val(item[0].txtCodigoProducto);
		$("#txtCodigoBarra").val(item[0].txtCodigoBarra);
		$("#txtTipo").val(item[0].txtTipo);
		$("#hidTipo").val(item[0].hidTipo);		
		$("#txtModelo").val(item[0].txtModelo);
		$("#hidModelo").val(item[0].hidModelo);
		$("#txtProveedor").val(item[0].txtProveedor);
		$("#hidProveedor").val(item[0].hidProveedor);		
		$("#txtMarca").val(item[0].txtMarca);
		$("#hidMatca").val(item[0].hidMatca);
		$("#txtNombreProducto").val(item[0].txtNombreProducto);
		$("#txtCosto").val(item[0].txtCosto);
		$("#txtPrecioVenta").val(item[0].txtPrecioVenta);
		$("#txtTamano").val(item[0].txtTamano);
		$("#hidTamano").val(item[0].hidTamano);
		$("#txtCantExistInicial").val(item[0].txtCantExistInicial);
		$("#txtCantMin").val(item[0].txtCantMin);
		$("#txtColor").val(item[0].txtColor);
		$("#hidColor").val(item[0].hidColor);
		$("#txtObservacionProducto").val(item[0].txtObservacionProducto);
	});
}

function Editar_Producto (oId)
{
	id_producto = $("#hdnIdCampos_" + oId).val();
	
	window.location.href='admin.php?sec='+btoa('editar_producto')+'&id='+id_producto;
}
/*
function Editar_Producto(oId)
{

	$.getScript("public/js/form_validation.js");	
	
	var NombreProducto = $("#hidNombreProducto" + oId).val();
	var DescripcionProducto = $("#hidDescripcionProducto" + oId).val();
	var Costo = $("#hidCosto" + oId).val();	
	var TipoCategoria = $("#hidTipoCategoria" + oId).val();
	var TipoPaquete = $("#hidTipoPaquete" + oId).val();
	var DescTipoCategoria = $("#hidDescTipoCategoria" + oId).val();
	var DescTipoPaquete = $("#hidDescTipoPaquete" + oId).val();
	var PrecioVenta = $("#hidPrecioVenta" + oId).val();	
	var CantExistInicial = $("#hidCantExistInicial" + oId).val();	
	var CantMin = $("#hidCantMin" + oId).val();		
	var CantAlertMin = $("#hidCantAlertMin" + oId).val();	
	var Id = $("#hdnIdCampos_" + oId).val();
	Calcular_Precio(oId);	

		
	//alert(RUC.length);
	var strHtml0 = "<td  align=\"center\">" +  oId + '</td>';		
		strHtml0 += "<td>" + '<input type="text" id="txtNombreProducto' + oId + '" name="txtNombreProducto[]" value="'+ NombreProducto +'"  class="validate[required,custom[onlyLetterSp]]"  style="width:95%;"/><input type="hidden" id="hidNombreProducto' + oId + '" name="hidNombreProducto[]" value="'+ NombreProducto +'"  /></td>';	
	var strHtml1 = "<td>" + '<textarea rows="4" cols="" id="txtDescripcionProducto' + oId + '" name="txtDescripcionProducto[]" value="'+ DescripcionProducto +'"  class="autoGrow validate[required]" style="width:95%;">'+ DescripcionProducto +'</textarea><input type="hidden" id="hidDescripcionProducto' + oId + '" name="hidDescripcionProducto[]" value="'+ DescripcionProducto +'"/></td>';	
	var strHtml2 = "<td>" + '<input type="text" id="txtCosto' + oId + '" name="txtCosto[]" value="'+ Costo +'"  class="validate[required,custom[number]]" style="width:95%;"/><input type="hidden" id="hidCosto' + oId + '" name="hidCosto[]" value="'+ Costo +'"/></td>';	
	var strHtml3 = "<td>" + '<div class="floatL">';
		strHtml3 += '<select name="lstTipoCategoria[]" id="lstTipoCategoria' + oId + '" class="validate[required]" >';
		strHtml3 += '<option value="">Seleccione el Tipo de Categor&iacute;a</option>';
		strHtml3 += '</select>';
		strHtml3 += '</div><input type="hidden" id="hidTipoCategoria' + oId + '" name="hidTipoCategoria[]" value="'+ TipoCategoria +'"  /><input type="hidden" id="hidDescTipoCategoria' + oId + '" name="hidDescTipoCategoria[]" value="'+ DescTipoCategoria +'"  /></td>';	
	var strHtml4 = "<td>" + '<input type="text" id="txtPrecioVenta' + oId + '" name="txtPrecioVenta[]" value="'+ PrecioVenta +'"  class="validate[required,custom[number]]" style="width:95%;" readonly="readonly" /><input type="hidden" id="hidPrecioVenta' + oId + '" name="hidPrecioVenta[]" value="'+ PrecioVenta +'"/></td>';	
	var strHtml5 = "<td>" + '<div class="floatL">';
		strHtml5 += '<select name="lstTipoPaquete[]" id="lstTipoPaquete' + oId + '" class="validate[required]" >';
		strHtml5 += '<option value="">Seleccione el Tipo de Paquete</option>';
		strHtml5 += '</select>';
		strHtml5 += '</div><input type="hidden" id="hidTipoPaquete' + oId + '" name="hidTipoPaquete[]" value="'+ TipoPaquete +'"  /><input type="hidden" id="hidDescTipoPaquete' + oId + '" name="hidDescTipoPaquete[]" value="'+ DescTipoPaquete +'"  /></td>';	
	var strHtml6 = "<td>" + CantExistInicial + '<input type="hidden" id="hidCantExistInicial' + oId + '" name="hidCantExistInicial[]" value="'+ CantExistInicial +'"  /></td>';		
	var strHtml7 = "<td>" + '<input type="text" id="txtCantMin' + oId + '" name="txtCantMin[]" value="'+ CantMin +'"  class="validate[required,custom[onlyNumberSp]]"  style="width:95%;"/><input type="hidden" id="hidCantMin' + oId + '" name="hidCantMin[]" value="'+ CantMin +'"  /></td>';	
	var strHtml8 = "<td>" + '<input type="text" id="txtCantAlertMin' + oId + '" name="txtCantAlertMin[]" value="'+ CantAlertMin +'"  class="validate[required,custom[onlyNumberSp]]"  style="width:95%;"/><input type="hidden" id="hidCantAlertMin' + oId + '" name="hidCantAlertMin[]" value="'+ CantAlertMin +'"  /></td>';	
	var strHtml9 = '<td><a href="javascript:void(0);" title="Guardar" class="smallButton" style="margin: 5px;" onclick="Guardar_Producto(' + oId + ')"><img src="public/images/icons/light/check.png" alt="" class="icon" /><span></span></a>';
	strHtml9 += '<a href="javascript:void(0);" title="Cancelar" class="smallButton" style="margin: 5px;" onclick="Cancelar_Guardar_Producto(' + oId + ')"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
	strHtml9 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;
	$("#tbDetalle").append(strHtmlTr);
	//si se agrega el HTML de una sola vez se debe comentar la linea siguiente.
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	
	GenerarCategoria(oId,TipoCategoria);
	GenerarTipoEmpaque(oId,TipoPaquete);
		
	$("#txtCosto" + oId).change(function(){
			
		PrecioMoneda('txtCosto' + oId);
		Calcular_Precio(oId);
		
	});		
		
	$("#lstTipoCategoria" + oId).change(function(){
			
		Calcular_Precio(oId);
		
	});	
	//alert(oId);
	

	//$("#lstTipoCategoria" + oId + " option[value="+TipoCategoria+"]").attr("selected",true);
	return false;
	
}
*/
function Actualizar_Producto(Id)
{	
		
	$.post("application/controllers/ProductoController.php?action=Actualizar_Producto",
	{
		IdTipoProducto:$("#lstTipoProducto").val(),
		NombreProducto:$("#txtNombreProducto").val(),
		CodigoBarra:$("#txtCodigoBarra").val(),
		CodigoProducto:$("#txtCodigoProducto").val(),
		IdTipo:$("#hidTipo").val(),
		Tipo:$("#txtTipo").val(),
		IdProveedor:$("#hidProveedor").val(),
		Proveedor:$("#txtProveedor").val(),			
		IdMarca:$("#hidMarca").val(),
		Marca:$("#txtMarca").val(),
		IdModelo:$("#hidModelo").val(),
		Modelo:$("#txtModelo").val(),
		IdTamano:$("#hidTamano").val(),		
		Tamano:$("#txtTamano").val(),
		IdColor:$("#hidColor").val(),			
		Color:$("#txtColor").val(),		
		Costo:$("#txtCosto").val(),
		TipoCategoria:$("#lstTipoCategoria").val(),
		Ubicacion:$("#lstUbicacion").val(),
		TipoPaquete:$("#lstTipoPaquete").val(),
		PrecioVenta:$("#txtPrecioVenta").val(),	
		CantMin:$("#txtCantMin").val(),		
		ObservacionProducto:$("#txtObservacionProducto").val(),	
		IdProducto:Id,
	}, function(data){

		if (data)
		{
			Sexy.info("Se han actualizado exit&oacute;samente los Datos",{
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_productos');
				}
			});
		}
		else if (!data)
		Sexy.error("Error guardar los Datos");
	});
		
}
/*
function Cancelar_Guardar_Producto(oId)
{
	var NombreProducto = $("#hidNombreProducto" + oId).val();
	var DescripcionProducto = $("#hidDescripcionProducto" + oId).val();
	var Costo = $("#hidCosto" + oId).val();	
	var TipoCategoria = $("#hidTipoCategoria" + oId).val();
	var TipoPaquete = $("#hidTipoPaquete" + oId).val();
	var DescTipoCategoria = $("#hidDescTipoCategoria" + oId).val();
	var DescTipoPaquete = $("#hidDescTipoPaquete" + oId).val();
	var PrecioVenta = $("#hidPrecioVenta" + oId).val();		
	var CantExistInicial = $("#hidCantExistInicial" + oId).val();		
	var CantMin = $("#hidCantMin" + oId).val();		
	var CantAlertMin = $("#hidCantAlertMin" + oId).val();	
	var Id = $("#hdnIdCampos_" + oId).val();		

	var strHtml0 = "<td  align=\"center\">" +  oId + '</td>';		
		strHtml0 += "<td>" + NombreProducto + '<input type="hidden" id="hidNombreProducto' + oId + '" name="hidNombreProducto[]" value="'+ NombreProducto +'"  /></td>';	
	var strHtml1 = "<td>" + DescripcionProducto + '<input type="hidden" id="hidDescripcionProducto' + oId + '" name="hidDescripcionProducto[]" value="'+ DescripcionProducto +'"/></td>';	
	var strHtml2 = "<td>B/.&nbsp;" + Costo + '<input type="hidden" id="hidCosto' + oId + '" name="hidCosto[]" value="'+ Costo +'"/></td>';	
	var strHtml3 = "<td>" + DescTipoCategoria + '<input type="hidden" id="hidTipoCategoria' + oId + '" name="hidTipoCategoria[]" value="'+ TipoCategoria +'"  /><input type="hidden" id="hidDescTipoCategoria' + oId + '" name="hidDescTipoCategoria[]" value="'+ DescTipoCategoria +'"  /></td>';	
	var strHtml4 = "<td>B/.&nbsp;" + PrecioVenta + '<input type="hidden" id="hidPrecioVenta' + oId + '" name="hidPrecioVenta[]" value="'+ PrecioVenta +'"/></td>';	
	var strHtml5 = "<td>" + DescTipoPaquete + '<input type="hidden" id="hidTipoPaquete' + oId + '" name="hidTipoPaquete[]" value="'+ TipoPaquete +'"  /><input type="hidden" id="hidDescTipoPaquete' + oId + '" name="hidDescTipoPaquete[]" value="'+ DescTipoPaquete +'"  /></td>';	
	var strHtml6 = "<td>" + CantExistInicial + '<input type="hidden" id="hidCantExistInicial' + oId + '" name="hidCantExistInicial[]" value="'+ CantExistInicial +'"  /></td>';		
	var strHtml7 = "<td>" + CantMin + '<input type="hidden" id="hidCantMin' + oId + '" name="hidCantMin[]" value="'+ CantMin +'"  /></td>';	
	var strHtml8 = "<td>" + CantAlertMin + '<input type="hidden" id="hidCantAlertMin' + oId + '" name="hidCantAlertMin[]" value="'+ CantAlertMin +'"  /></td>';	
	var strHtml9 = '<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Producto(' + oId + ')"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
	strHtml9 += '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Producto?\')){Eliminar_Producto(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
	strHtml9 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;
	$("#tbDetalle").append(strHtmlTr);
	//si se agrega el HTML de una sola vez se debe comentar la linea siguiente.
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	return false;
}*/

function Eliminar_Producto(oId)
{
	var Id = $("#hdnIdCampos_" + oId).val();
	
	$.post("application/controllers/ProductoController.php?action=Eliminar_Producto",
	{
		IdProducto:Id	
		
	}, function(data){

		
		if (data=="true")
		{
			$("#rowDetalle_" + oId).remove();

			if($("[name='hidNombreProducto[]']").length == 0)
			{
				$("#cant_campos").val("0");
				$("#num_campos").val("0");
			}
			
			Sexy.info("Se ha eliminado exit&oacute;samente los Datos",{
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_productos');
				}
			});
		}
		else if (data=="false")
		Sexy.error("Error eliminar los Datos");
	})
	
	return false;
}

function Listar_Inventario_Productos()
{
	$('#listado_inventario_producto').dataTable( {
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"responsive":true,
		"info": true,
		"ajax": {
			"url": "application/controllers/ProductoController.php?action=Listar_Inventario_Productos",			
			"data": function ( d ) {
				d.TipoCategoria = $("#lstTipoCategoria").val();
				d.Proveedor = $("#lstProveedor").val();
			},
			"type": "POST",
		},
		"pagingType":"full_numbers",
		"lengthMenu": [[5,10,15,25,50,75,100,150,-1],[5,10,15,25,50,75,100,150,"All"]],
		"pageLength": 10,
		"dom": 'T<"clear">lfrtip',
		"createdRow":function( nRow, aData, iDataIndex ) {
				$(nRow).attr('id', "rowDetalle_"+iDataIndex);
			},
		"columnDefs": [
			  { "className": "text-center", "targets": [ 0,5,6,7,8 ] },
			  { "searchable": false, "targets": [ 0 ] },
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
	} );

}

function Listar_Precios_Productos()
{
	$('#listado_precio_producto').dataTable( {
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"responsive":true,
		"info": true,
		"ajax": {
			"url": "application/controllers/ProductoController.php?action=Listar_Precios_Productos",			
			"data": function ( d ) {
				d.TipoCategoria = $("#lstTipoCategoria").val();
				d.Proveedor = $("#lstProveedor").val();
			},
			"type": "POST",
		},
		"pagingType":"full_numbers",
		"lengthMenu": [[5,10,15,25,50,75,100,150,-1],[5,10,15,25,50,75,100,150,"All"]],
		"pageLength": 10,
		"dom": 'T<"clear">lfrtip',
		"createdRow":function( nRow, aData, iDataIndex ) {
				$(nRow).attr('id', "rowDetalle_"+iDataIndex);
			},
		"columnDefs": [
			  { "className": "text-center", "targets": [ 0,1,2,5 ] },
			  { "searchable": false, "targets": [ 0 ] },
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
	} );
}

function Agregar_Categoria_Producto()
{
	
	$.post("application/controllers/ProductoController.php?action=Agregar_Categoria_Producto",
	{
		NombreCategoriaProducto:$("#txtNombreCategoriaProducto").val(),
		Porcentaje:$("#txtPorcentaje").val(),
	}, function(data){

		if (data)
		{
			Sexy.info("Se ha creado la categoria con exito",{
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_categorias_productos');
				}
			});
		}
		else if (!data)
		Sexy.error("Error guardar los Datos");
	});
	
}

function Cancelar_Agregar_Categoria_Producto()
{

	Sexy.confirm('Deseas Regresar al Listado de Categor&iacute;a Productos?.<br />Pulsa &quot;Ok&quot; para continuar, o pulsa &quot;Cancelar&quot; para salir.', {onComplete: 
		function(returnvalue) { 
			if(returnvalue)
			{
				Sexy.info('Datos ingresados no se guardar&aacute;n', {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('listar_categorias_productos');
					}
				});			
			}

		}
	});
}

function Listar_Categorias_Productos()
{
	
		$('#listado_categoria_producto').dataTable( {
			"processing": true,
			"serverSide": true,
			"ordering": true,
			"info": true,
			"ajax": {
				"url": "application/controllers/ProductoController.php?action=Listar_Categorias_Productos",		
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
				  { "className": "text-center", "targets": [ 0,3 ] },
				  { "searchable": false, "targets": [ 0,3 ] },
				  { "orderable": false, "targets": [ 3 ] },
				],
			"columns": [
				{ "data": 0 },
				{ "data": 1 },
				{ "data": 2 },
				{ "data": 3 },			
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
		} );	
	
}

function Ver_Categoria_Producto(Id)
{
	$.post("application/controllers/ProductoController.php?action=Ver_Categoria_Producto",
	{
		IdCatProducto:Id
	}
	,function(data){

		var item = JSON.parse(data);

		$("#txtNombreCategoriaProducto").val(item[0].txtNombreCategoriaProducto);
		$("#txtPorcentaje").val(item[0].txtPorcentaje);

	});
}

function Editar_Categoria_Producto (oId)
{
	id_categoria_producto = $("#hdnIdCampos_" + oId).val();
	
	window.location.href='admin.php?sec='+btoa('editar_categoria_producto')+'&id='+id_categoria_producto;
}

function Actualizar_Categoria_Producto(Id)
{
			
	$.post("application/controllers/ProductoController.php?action=Actualizar_Categoria_Producto",
	{
		NombreCategoriaProducto:$("#txtNombreCategoriaProducto").val(),
		Porcentaje:$("#txtPorcentaje").val(),	
		IdCatProducto:Id,
	}, function(data){

		if (data)
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos",{
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_categorias_productos');
				}
			});
		}
		else if (!data)
		Sexy.error("Error guardar los Datos");
	});
			
}

function Eliminar_Categoria_Producto(oId)
{
	var Id = $("#hdnIdCampos_" + oId).val();
	
	$.post("application/controllers/ProductoController.php?action=Eliminar_Categoria_Producto",
	{
		IdCatProducto:Id	
		
	}, function(data){

		
		if (data)
		{
			$("#rowDetalle_" + oId).remove();

			if($("[name='hidCategoriaProducto[]']").length == 0)
			{
				$("#cant_campos").val("0");
				$("#num_campos").val("0");
			}
			
			Sexy.info("Se ha eliminado exit&oacute;samente los Datos",{
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_categorias_productos');
				}
			});
		}
		else if (!data)
		Sexy.error("Error eliminar los Datos");
	})
	
	return false;
}

function Generar_Inventario_Productos_Total_Costo()
{
	$.post("application/controllers/ProductoController.php?action=Generar_Inventario_Productos_Total_Costo",
	{	
		TipoCategoria:$("#lstTipoCategoria").val(),
		Proveedor:$("#lstProveedor").val()
	}, function(data){

		window.open(data, 'win3', 'width=1024, height=768,  left=20, top=20, resizable=yes, scrollbars=yes,toolbar=no,location=no,directories=no, status=no,menubar=no');
		
	});
}

function Generar_Inventario_Productos_Bodega()
{
	$.post("application/controllers/ProductoController.php?action=Generar_Inventario_Productos_Bodega",
	{	
		TipoCategoria:$("#lstTipoCategoria").val(),
		Proveedor:$("#lstProveedor").val()
	}, function(data){

		window.open(data, 'win3', 'width=1024, height=768,  left=20, top=20, resizable=yes, scrollbars=yes,toolbar=no,location=no,directories=no, status=no,menubar=no');
		
	});
}

function Generar_Inventario_Productos_Tienda()
{
	$.post("application/controllers/ProductoController.php?action=Generar_Inventario_Productos_Tienda",
	{	
		TipoCategoria:$("#lstTipoCategoria").val(),
		Proveedor:$("#lstProveedor").val()
	}, function(data){

		window.open(data, 'win3', 'width=1024, height=768,  left=20, top=20, resizable=yes, scrollbars=yes,toolbar=no,location=no,directories=no, status=no,menubar=no');
		
	});
}
