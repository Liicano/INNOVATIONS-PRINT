function Mostrar_Numero_Orden()
{
	$.post("application/controllers/OrdenController.php?action=Mostrar_Numero_Orden",
	{
		TipoOrden:$("#lstTipoOrden").val()
	}
	, function(data){
	
		$("#txtNumeroOrden").val(data);
		
	});
}

function Mostrar_Fecha_Orden()
{
	$("#txtFechaOrden").load("application/controllers/OrdenController.php?action=Mostrar_Fecha_Orden"
	, function(data){

		$("#txtFechaOrden").val(data);
		
	});
}

function Mostrar_Usuario_Autoriza()
{
	$("#txtAutorizo").load("library/funciones.php?action=Usuario_Sesion"
	, function(data){

		$("#txtAutorizo").val(data);
		
	});
}

function Listar_Codigo_Barra_Auto(oId)
{
	var url;

	if ($("#hidProveedorProcedencia").val() != "")
	url = "application/controllers/ProductoController.php?action=Listar_Codigo_Barra_Autocompletar&idP="+$("#hidProveedorProcedencia").val()+"&tipo="+$("#lstTipoOrdenEntrada").val();
	else
	url = "application/controllers/ProductoController.php?action=Listar_Codigo_Barra_Autocompletar&tipo="+$("#lstTipoOrdenEntrada").val();

	if ((oId != undefined) & (oId != "any"))
	{	
		$("#txtCodigoBarra" + oId).autocomplete({
			source: url,
			select:  function(event, ui) {
			
				$("#txtNombreProducto" + oId).val(ui.item.txtNombreProducto);
				$("#hidProducto" + oId).val(ui.item.hidProducto);
				
			},
			change: function (event, ui) {

				$.post(url,
				{
					CodigoProducto:$("#txtCodigoBarra" + oId).val()
				},
				function(data){
				
					var item = JSON.parse(data);
					
					if (item === null)
					{
						$("#txtCodigoBarra" + oId).val("");
						$("#txtNombreProducto" + oId).val("");
						$("#hidProducto" + oId).val("");
					}
					else
					{
						$("#txtNombreProducto" + oId).val(item[0].txtNombreProducto);
						$("#hidProducto" + oId).val(item[0].hidProducto);
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
				$("#hidProducto" + oId).val(ui.item.hidProducto);
				
			},
			change: function (event, ui) {

				var oId = $(this).attr('id');
				oId = oId.substr(14);
				
				$.post(url,
				{
					CodigoProducto:$("#txtCodigoBarra" + oId).val()
				},
				function(data){
				
					var item = JSON.parse(data);
					
					if (item === null)
					{
						$("#txtCodigoBarra" + oId).val("");
						$("#txtNombreProducto" + oId).val("");
						$("#hidProducto" + oId).val("");
					}
					else
					{
						$("#txtNombreProducto" + oId).val(item[0].txtNombreProducto);
						$("#hidProducto" + oId).val(item[0].hidProducto);
					}					
				
				});					
			
			}
		});		
	}
}

function Listar_Nombre_Producto_Auto(oId)
{
	var url;
	
	if ($("#hidProveedorProcedencia").val() != "")
	url = "application/controllers/ProductoController.php?action=Listar_Nombre_Producto_Autocompletar&idP="+$("#hidProveedorProcedencia").val()+"&tipo="+$("#lstTipoOrdenEntrada").val()
	else
	url = "application/controllers/ProductoController.php?action=Listar_Nombre_Producto_Autocompletar&tipo="+$("#lstTipoOrdenEntrada").val()

	if ((oId != undefined) & (oId != "any"))
	{		
		$("#txtNombreProducto" + oId).autocomplete({
			source: url,
			select:  function(event, ui) {
				
				$("#txtCodigoBarra" + oId).val(ui.item.txtCodigoBarra);
				$("#hidProducto" + oId).val(ui.item.hidProducto);
				
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
						$("#hidProducto" + oId).val("");
					}
					else
					{
						$("#txtCodigoBarra" + oId).val(item[0].txtCodigoBarra);
						$("#hidProducto" + oId).val(item[0].hidProducto);
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
				$("#hidProducto" + oId).val(ui.item.hidProducto);				
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
						$("#hidProducto" + oId).val("");
					}
					else
					{
						$("#txtCodigoBarra" + oId).val(item[0].txtCodigoBarra);
						$("#hidProducto" + oId).val(item[0].hidProducto);
					}					
				
				});				
			}
		});	
	}
}

function Listar_Tipo_Orden (oId,Orden)
{
	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	var sec;
	if(getURLParameter('sec') === undefined)
	sec = "";
	else
	sec = getURLParameter('sec');
	
	if (oId != undefined)
	{	
		if (((filename == "admin.php") & (sec==btoa("agregar_orden"))) | ((filename == "admin.php") & (sec==btoa("editar_orden"))))
		{		
		
			if ((filename == "admin.php") & (sec==btoa("agregar_orden")))
			{
				$("#lstTipoOrdenEntrada" + oId + " option[value='']").attr("selected",true);
				$("#txtProveedor" + oId).val("");
				$("#txtBodegaProcedencia" + oId).val("");
				$("#txtBodegaReceptora" + oId).val("");				
				$("#txtTiendaProcedencia" + oId).val("");
				$("#txtTiendaReceptora" + oId).val("");
				$("#txtChoferAyudante" + oId).val("");	
				$("#hidProveedorProcedencia" + oId).val("");
			}
				
			$("#OrdenEntrada" + oId).hide();
			$("#TiendaProcedencia" + oId).hide();
			$("#TiendaReceptora" + oId).hide();
			$("#BodegaProcedencia" + oId).hide();
			$("#BodegaReceptora" + oId).hide();
			$("#ProveedorProcedencia" + oId).hide();			
		}		

		
		$("#lstTipoOrden" + oId).load("application/controllers/OrdenController.php?action=Listar_Tipo_Orden",
		function(data) {

			$("#lstTipoOrden" + oId).find('option').remove().end().append('<option value="" title="Seleccione Tipo de Orden" >Seleccione Tipo de Orden</option>');
			$("#lstTipoOrden" + oId).append(data);	
		
			$("#lstTipoOrden" + oId + " option[value='" + Orden + "']").attr("selected",true);
			$("#uniform-lstTipoOrden" + oId).children("span").html($("#lstTipoOrden" + oId + " option:selected").text());	
			
			if((filename == "admin.php") & (sec==btoa("editar_orden")))
			{	
				if($("#lstTipoOrden" + oId).prop("selectedIndex")==1)
				{	
					$("#OrdenEntrada" + oId).show();
					$("#BodegaProcedencia" + oId).hide();
					$("#BodegaReceptora" + oId).show();
					$("#TiendaProcedencia" + oId).hide();
					$("#TiendaReceptora" + oId).hide();
					Listar_Proveedor_Auto(oId);
					Listar_Bodega_Receptora_Auto(oId);			
				}
				else if($("#lstTipoOrden" + oId).prop("selectedIndex")==2)
				{	
					$("#OrdenEntrada" + oId).hide();
					$("#TiendaProcedencia" + oId).hide();
					$("#TiendaReceptora" + oId).show();
					$("#BodegaProcedencia" + oId).show();
					$("#BodegaReceptora" + oId).hide();
					$("#ProveedorProcedencia" + oId).hide();
					Listar_Bodega_Procedencia_Auto(oId);
					Listar_Tienda_Receptora_Auto(oId);
				}
				else if($("#lstTipoOrden" + oId).prop("selectedIndex")==3)
				{	
					$("#OrdenEntrada" + oId).hide();
					$("#BodegaProcedencia" + oId).hide();
					$("#BodegaReceptora" + oId).hide();
					$("#TiendaProcedencia" + oId).hide();
					$("#TiendaReceptora" + oId).hide();
					$("#ProveedorProcedencia" + oId).hide();
				}			
				else
				{			
					$("#OrdenEntrada" + oId).hide();
					$("#TiendaProcedencia" + oId).hide();
					$("#TiendaReceptora" + oId).hide();					
					$("#BodegaProcedencia" + oId).hide();
					$("#BodegaReceptora" + oId).hide();
					$("#ProveedorProcedencia" + oId).hide();
				}
			
			}
			$("#lstTipoOrden" + oId).change(function(){			
			
				$("#lstTipoOrdenEntrada" + oId + " option[value='0']").attr("selected",true);
				$("#txtProveedor" + oId).val("");
				$("#hidProveedor" + oId).val("");
				$("#txtBodegaProcedencia" + oId).val("");
				$("#txtBodegaReceptora" + oId).val("");				
				$("#txtTiendaProcedencia" + oId).val("");
				$("#txtTiendaReceptora" + oId).val("");
				$("#tbDetalle" + oId).empty();
				$("#cant_campos" + oId).val("0");
				$("#num_campos" + oId).val("0");				
			
				if($("#lstTipoOrden" + oId).prop("selectedIndex")==1)
				{	
					$("#OrdenEntrada" + oId).show();
					$("#TiendaProcedencia" + oId).hide();
					$("#TiendaReceptora" + oId).hide();
					$("#BodegaProcedencia" + oId).hide();
					$("#BodegaReceptora" + oId).show();					
					//if((filename == "admin.php") & (sec=="agregar_orden"))
					//Mostrar_Numero_Orden();
					Listar_Proveedor_Auto(oId);
					Listar_Bodega_Receptora_Auto(oId);						
				}
				else if($("#lstTipoOrden" + oId).prop("selectedIndex")==2)
				{
					$("#OrdenEntrada" + oId).hide();
					$("#TiendaProcedencia" + oId).hide();
					$("#BodegaProcedencia" + oId).show();
					$("#BodegaReceptora" + oId).hide();
					$("#ProveedorProcedencia" + oId).hide();
					$("#TiendaReceptora" + oId).show();
					//if((filename == "admin.php") & (sec=="agregar_orden"))
					//Mostrar_Numero_Orden();
					Listar_Bodega_Procedencia_Auto(oId);
					Listar_Tienda_Receptora_Auto(oId);
				}
				else if($("#lstTipoOrden" + oId).prop("selectedIndex")==3)
				{	
					$("#OrdenEntrada" + oId).hide();
					$("#BodegaProcedencia" + oId).hide();
					$("#BodegaReceptora" + oId).hide();
					$("#TiendaProcedencia" + oId).hide();
					$("#TiendaReceptora" + oId).hide();
					$("#ProveedorProcedencia" + oId).hide();
				}				
				else
				{			
					$("#OrdenEntrada" + oId).hide();
					$("#TiendaProcedencia" + oId).hide();
					$("#TiendaReceptora" + oId).hide();
					$("#BodegaProcedencia" + oId).hide();
					$("#BodegaReceptora" + oId).hide();
					$("#ProveedorProcedencia" + oId).hide();
					$("#TiendaSalida" + oId).hide();
					//if((filename == "admin.php") & (sec=="agregar_orden"))
					//Mostrar_Numero_Orden();	
				}			
			});	
		});
	}
	else
	{
		if (((filename == btoa("admin.php")) & (sec==btoa("agregar_orden"))) | ((filename == "admin.php") & (sec==btoa("editar_orden"))))
		{		
		
			if ((filename == "admin.php") & (sec==btoa("agregar_orden")))
			{
				$("#lstTipoOrdenEntrada option[value='0']").attr("selected",true);
				$("#txtProveedor").val("");
				$("#hidProveedor").val("");
				$("#txtBodegaProcedencia").val("");
				$("#txtBodegaReceptora").val("");				
				$("#txtTiendaProcedencia").val("");
				$("#txtTiendaReceptora").val("");
			}
				
			$("#OrdenEntrada").hide();
			$("#TiendaProcedencia").hide();
			$("#TiendaReceptora").hide();
			$("#BodegaProcedencia").hide();
			$("#BodegaReceptora").hide();
			$("#ProveedorProcedencia").hide();		
		}		
		
		$("#lstTipoOrden").load("application/controllers/OrdenController.php?action=Listar_Tipo_Orden",
		function(data) {

			$("#lstTipoOrden").find('option').remove().end().append('<option value="" title="Seleccione Tipo de Orden" >Seleccione Tipo de Orden</option>');
			$("#lstTipoOrden").append(data);	
		
			$("#lstTipoOrden option[value='" + Orden + "']").attr("selected",true);	
			$("#uniform-lstTipoOrden").children("span").html($("#lstTipoOrden option:selected").text());	

			if((filename == "admin.php") & (sec==btoa("editar_orden")))
			{
				if($("#lstTipoOrden").prop("selectedIndex")==1)
				{	
					$("#OrdenEntrada").show();
					$("#BodegaProcedencia").hide();
					$("#BodegaReceptora").show();
					$("#TiendaProcedencia").hide();					
					$("#TiendaReceptora").hide();
					Listar_Proveedor_Auto();
					Listar_Bodega_Receptora_Auto();	
				}
				else if($("#lstTipoOrden").prop("selectedIndex")==2)
				{		
					$("#OrdenEntrada").hide();
					$("#BodegaProcedencia").show();
					$("#BodegaReceptora").hide();					
					$("#TiendaProcedencia").hide();
					$("#TiendaReceptora").hide();
					$("#ProveedorProcedencia").hide();
					$("#TiendaReceptora").show();
					$("#ChoferAyudante").show();
					Listar_Bodega_Procedencia_Auto();
					Listar_Tienda_Receptora_Auto();
				}
				else if($("#lstTipoOrden").prop("selectedIndex")==3)
				{	
					$("#OrdenEntrada").hide();
					$("#BodegaProcedencia").hide();
					$("#BodegaReceptora").hide();
					$("#TiendaProcedencia").hide();
					$("#TiendaReceptora").hide();
					$("#ProveedorProcedencia").hide();
					$("#ChoferAyudante").hide();
				}				
				else
				{
						$("#OrdenEntrada").hide();
						$("#TiendaProcedencia").hide();
						$("#TiendaReceptora").hide();
						$("#BodegaProcedencia").hide();
						$("#BodegaReceptora").hide();
						$("#ProveedorProcedencia").hide();
						$("#ChoferAyudante").hide();
				}
			}
	
			$("#lstTipoOrden").change(function(){	

				$("#lstTipoOrdenEntrada option[value='']").attr("selected",true);
				$("#txtProveedorProcedencia").val("");
				$("#hidProveedorProcedencia").val("");
				$("#txtBodegaProcedencia").val("");
				$("#txtBodegaReceptora").val("");				
				$("#txtTiendaProcedencia").val("");
				$("#txtTiendaReceptora").val("");
				$("#tbDetalle").empty();
				$("#cant_campos").val("0");
				$("#num_campos").val("0");				
				
				if($("#lstTipoOrden").prop("selectedIndex")==1)
				{	
					$("#OrdenEntrada").show();
					$("#BodegaProcedencia").hide();
					$("#BodegaReceptora").show();
					$("#TiendaProcedencia").hide();
					$("#TiendaReceptora").hide();
					//if((filename == "admin.php") & (sec=="agregar_orden"))
					//Mostrar_Numero_Orden();	
					Listar_Proveedor_Auto();
					Listar_Bodega_Receptora_Auto();	
				}
				else if($("#lstTipoOrden").prop("selectedIndex")==2)
				{
					$("#OrdenEntrada").hide();
					$("#TiendaProcedencia").hide();
					$("#TiendaProcedencia").hide();
					$("#BodegaProcedencia").show();
					$("#BodegaReceptora").hide();
					$("#ProveedorProcedencia").hide();
					$("#TiendaReceptora").show();
					//if((filename == "admin.php") & (sec=="agregar_orden"))
					//Mostrar_Numero_Orden();
					Listar_Bodega_Procedencia_Auto();
					Listar_Tienda_Receptora_Auto();
				}	
				else if($("#lstTipoOrden").prop("selectedIndex")==3)
				{	
					$("#OrdenEntrada").hide();
					$("#BodegaProcedencia").hide();
					$("#BodegaReceptora").hide();
					$("#TiendaProcedencia").hide();
					$("#TiendaReceptora").hide();
					$("#ProveedorProcedencia").hide();
				}				
				else
				{
					if((filename == "admin.php") & (sec=="agregar_orden"))
					{			
						$("#OrdenEntrada").hide();
						$("#TiendaProcedencia").hide();
						$("#TiendaReceptora").hide();
						$("#BodegaProcedencia").hide();
						$("#BodegaReceptora").hide();
						$("#ProveedorProcedencia").hide();
						//Mostrar_Numero_Orden();	
					}
				}			
			});							
		
		});
	}
}

function Listar_Tipo_Orden_Entrada (oId,OrdenEntrada)
{
	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	var sec;
	if(getURLParameter('sec') === undefined)
	sec = "";
	else
	sec = getURLParameter('sec');	

	if (oId != undefined)
	{	
		if (((filename == "admin.php") & (sec==btoa("agregar_orden"))) | ((filename == "admin.php") & (sec==btoa("editar_orden"))))
		{		
		
			if ((filename == "admin.php") & (sec==btoa("agregar_orden")))
			{
				$("#txtTienda" + oId).val("");
				$("#txtProveedor" + oId).val("");
				$("#hidTienda" + oId).val("");
				$("#hidProveedor" + oId).val("");
			}
				
			$("#TiendaProcedencia" + oId).hide();
			$("#TiendaReceptora" + oId).hide();
			$("#BodegaProcedencia" + oId).hide();
			$("#BodegaReceptora" + oId).hide();
			$("#ProveedorProcedencia" + oId).hide();
		}		

		
		$("#lstTipoOrdenEntrada" + oId).load("application/controllers/OrdenController.php?action=Listar_Tipo_Orden_Entrada",
		function(data) {

			$("#lstTipoOrdenEntrada" + oId).find('option').remove().end().append('<option value="" title="Seleccione Tipo de Orden" >Seleccione Tipo de Orden de Entrada</option>');
			$("#lstTipoOrdenEntrada" + oId).append(data);	
		
			$("#lstTipoOrdenEntrada" + oId + " option[value='" + OrdenEntrada + "']").attr("selected",true);
			$("#uniform-lstTipoOrdenEntrada" + oId).children("span").html($("#lstTipoOrdenEntrada" + oId + " option:selected").text());				

			if((filename == "admin.php") & (sec==btoa("editar_orden")))
			{	
				if($("#lstTipoOrdenEntrada" + oId).prop("selectedIndex")==1)
				{
					$("#BodegaProcedencia" + oId).hide();			
					$("#TiendaProcedencia" + oId).hide();
					$("#ProveedorProcedencia" + oId).show();
					Listar_Proveedor_Auto(oId);					
				}
				else if($("#lstTipoOrdenEntrada" + oId).prop("selectedIndex")==2)
				{
					$("#BodegaProcedencia" + oId).hide();			
					$("#TiendaProcedencia" + oId).show();
					$("#ProveedorProcedencia" + oId).hide();
					Listar_Tienda_Procedencia_Auto(oId);
				}
				else if($("#lstTipoOrdenEntrada" + oId).prop("selectedIndex")==3)
				{
					$("#BodegaProcedencia" + oId).show();
					$("#TiendaProcedencia" + oId).hide();
					$("#ProveedorProcedencia" + oId).hide();					
					Listar_Bodega_Procedencia_Auto(oId);
				}				
				else
				{
					$("#TiendaProcedencia" + oId).hide();
					$("#TiendaReceptora" + oId).hide();
					$("#BodegaProcedencia" + oId).hide();
					$("#BodegaReceptora" + oId).hide();
					$("#ProveedorProcedencia" + oId).hide();
				}
			}
			
			$("#lstTipoOrdenEntrada" + oId).change(function(){

				$("#txtTienda" + oId).val("");
				$("#txtProveedor" + oId).val("");
				$("#hidTienda" + oId).val("");
				$("#hidProveedor" + oId).val("");
				
				if($("#lstTipoOrdenEntrada" + oId).prop("selectedIndex")==1)
				{
					$("#BodegaProcedencia" + oId).hide();
					$("#TiendaProcedencia" + oId).hide();
					$("#ProveedorProcedencia" + oId).show();
					Listar_Proveedor_Auto(oId);	
				}
				else if($("#lstTipoOrdenEntrada" + oId).prop("selectedIndex")==2)
				{
					$("#BodegaProcedencia" + oId).hide();
					$("#TiendaProcedencia" + oId).show();
					$("#ProveedorProcedencia" + oId).hide();
					Listar_Tienda_Procedencia_Auto(oId);
					
				}
				else if($("#lstTipoOrdenEntrada" + oId).prop("selectedIndex")==3)
				{
					$("#BodegaProcedencia" + oId).show();
					$("#TiendaProcedencia" + oId).hide();
					$("#ProveedorProcedencia" + oId).hide();					
					Listar_Bodega_Procedencia_Auto(oId);
				}				
				else
				{
					$("#TiendaProcedencia" + oId).hide();
					$("#TiendaReceptora").hide();
					$("#BodegaProcedencia" + oId).hide();
					$("#BodegaReceptora" + oId).hide();
					$("#ProveedorProcedencia" + oId).hide();
				}			
			
			});

		});
	}
	else
	{
		if (((filename == "admin.php") & (sec==btoa("agregar_orden"))) | ((filename == "admin.php") & (sec==btoa("editar_orden"))))
		{		
		
			if ((filename == "admin.php") & (sec==btoa("agregar_orden")))
			{
				$("#txtTienda").val("");
				$("#txtBodega").val("");
				$("#txtProveedor").val("");
				$("#hidTienda").val("");
				$("#hidProveedor").val("");
			}
				
			$("#TiendaProcedencia").hide();
			$("#TiendaReceptora").hide();
			$("#BodegaProcedencia").hide();
			$("#BodegaReceptora").hide();
			$("#ProveedorProcedencia").hide();	
		}		
		
		$("#lstTipoOrdenEntrada").load("application/controllers/OrdenController.php?action=Listar_Tipo_Orden_Entrada",
		function(data) {
			//alert(data);
			$("#lstTipoOrdenEntrada").find('option').remove().end().append('<option value="" title="Seleccione Tipo de Orden" >Seleccione Tipo de Orden de Entrada</option>');
			$("#lstTipoOrdenEntrada").append(data);	
		
			$("#lstTipoOrdenEntrada option[value='" + OrdenEntrada + "']").attr("selected",true);
			$("#uniform-lstTipoOrdenEntrada").children("span").html($("#lstTipoOrdenEntrada option:selected").text());	
			
			if((filename == "admin.php") & (sec==btoa("editar_orden")))
			{	
				if($("#lstTipoOrdenEntrada").prop("selectedIndex")==1)
				{
					$("#BodegaProcedencia").hide();	
					$("#TiendaProcedencia").hide();
					$("#ProveedorProcedencia").show();
					Listar_Proveedor_Auto();
				}
				else if($("#lstTipoOrdenEntrada").prop("selectedIndex")==2)
				{
					$("#BodegaProcedencia").hide();
					$("#TiendaProcedencia").show();
					$("#ProveedorProcedencia").hide();	
					Listar_Tienda_Procedencia_Auto();
				}
				else if($("#lstTipoOrdenEntrada").prop("selectedIndex")==3)
				{
					$("#BodegaProcedencia").show();
					$("#TiendaProcedencia").hide();
					$("#ProveedorProcedencia").hide();					
					Listar_Bodega_Procedencia_Auto();
				}				
				else
				{
					$("#TiendaProcedencia").hide();
					$("#TiendaReceptora").hide();
					$("#BodegaProcedencia").hide();
					$("#ProveedorProcedencia").hide();
				}
			}

			$("#lstTipoOrdenEntrada").change(function(){

				$("#txtTienda").val("");
				$("#txtProveedor").val("");
				$("#hidTienda").val("");
				$("#hidProveedor").val("");			
			
				if($("#lstTipoOrdenEntrada").prop("selectedIndex")==1)
				{
					$("#BodegaProcedencia").hide();				
					$("#TiendaProcedencia").hide();
					$("#ProveedorProcedencia").show();
					Listar_Proveedor_Auto();	
				}
				else if($("#lstTipoOrdenEntrada").prop("selectedIndex")==2)
				{
					$("#BodegaProcedencia").hide();					
					$("#TiendaProcedencia").show();
					$("#ProveedorProcedencia").hide();
					Listar_Tienda_Procedencia_Auto();	
				}
				else if($("#lstTipoOrdenEntrada").prop("selectedIndex")==3)
				{
					$("#BodegaProcedencia").show();
					$("#TiendaProcedencia").hide();
					$("#ProveedorProcedencia").hide();					
					Listar_Bodega_Procedencia_Auto();
				}				
				else
				{
					$("#TiendaProcedencia").hide();
					$("#TiendaReceptora").hide();
					$("#BodegaProcedencia").hide();
					$("#BodegaReceptora").hide();
					$("#ProveedorProcedencia").hide();
				}		
			
			
			});			
		});
	}

}

function Listar_Proveedor_Auto()
{
	
	$("#txtProveedorProcedencia").autocomplete({
		source: "application/controllers/ProveedorController.php?action=Listar_Proveedor_Autocompletar",
		select:  function(event, ui) {
			
			$("#tbDetalle").empty();
			$("#cant_campos").val("0");
			$("#num_campos").val("0");		
			$("#hidProveedorProcedencia").val(ui.item.hidProveedor);
			
		},
		change: function (event, ui) {
		
			$("#tbDetalle").empty();
			$("#cant_campos").val("0");
			$("#num_campos").val("0");	
			
			$.post("application/controllers/ProveedorController.php?action=Listar_Proveedor_Autocompletar",
			{
				Proveedor:$("#txtProveedorProcedencia").val()
			},
			function(data){
			
				var item = JSON.parse(data);
				//alert(data);
				if (item === null)
				{
					$("#txtProveedorProcedencia").val("");
					$("#hidProveedorProcedencia").val("");
				}
				else
				{
					$("#hidProveedorProcedencia").val(item[0].hidProveedor);
				}					
			
			});				
							
		}
	});
	
}

function Listar_Bodega_Procedencia_Auto()
{
	
	$("#txtBodegaProcedencia").autocomplete({
		source: "application/controllers/BodegaController.php?action=Listar_Bodega_Autocompletar",
		select:  function(event, ui) {
			
			$("#tbDetalle").empty();
			$("#cant_campos").val("0");
			$("#num_campos").val("0");		
			$("#hidBodegaProcedencia").val(ui.item.hidBodega);
			
		},
		change: function (event, ui) {
		
			$("#tbDetalle").empty();
			$("#cant_campos").val("0");
			$("#num_campos").val("0");	
			
			$.post("application/controllers/BodegaController.php?action=Listar_Bodega_Autocompletar",
			{
				Bodega:$("#txtBodegaProcedencia").val()
			},
			function(data){
			
				var item = JSON.parse(data);
				
				if (item === null)
				{
					$("#txtBodegaProcedencia").val("");
					$("#hidBodegaProcedencia").val("");
				}
				else
				{
					$("#hidBodegaProcedencia").val(item[0].hidBodega);
				}					
			
			});					
		}
	});
	
}

function Listar_Bodega_Receptora_Auto()
{
	
	$("#txtBodegaReceptora").autocomplete({
		source: "application/controllers/BodegaController.php?action=Listar_Bodega_Autocompletar",
		select:  function(event, ui) {
			
			$("#tbDetalle").empty();
			$("#cant_campos").val("0");
			$("#num_campos").val("0");		
			$("#hidBodegaReceptora").val(ui.item.hidBodega);
			
		},
		change: function (event, ui) {
		
			$("#tbDetalle").empty();
			$("#cant_campos").val("0");
			$("#num_campos").val("0");	
			
			$.post("application/controllers/BodegaController.php?action=Listar_Bodega_Autocompletar",
			{
				Bodega:$("#txtBodegaReceptora").val()
			},
			function(data){
			
				var item = JSON.parse(data);
				
				if (item === null)
				{
					$("#txtBodegaReceptora").val("");
					$("#hidBodegaReceptora").val("");
				}
				else
				{
					$("#hidBodegaReceptora").val(item[0].hidBodega);
				}					
			
			});			
				
		}
	});
	
}

function Listar_Tienda_Procedencia_Auto()
{
	
	$("#txtTiendaProcedencia").autocomplete({
		source: "application/controllers/TiendaController.php?action=Listar_Tienda_Autocompletar",
		select:  function(event, ui) {
			
			$("#tbDetalle").empty();
			$("#cant_campos").val("0");
			$("#num_campos").val("0");		
			$("#hidTiendaProcedencia").val(ui.item.hidTienda);
			
		},
		change: function (event, ui) {
		
			$("#tbDetalle").empty();
			$("#cant_campos").val("0");
			$("#num_campos").val("0");	
			
			$.post("application/controllers/TiendaController.php?action=Listar_Tienda_Autocompletar",
			{
				Tienda:$("#txtTiendaProcedencia").val()
			},
			function(data){
			
				var item = JSON.parse(data);
				
				if (item === null)
				{
					$("#txtTiendaProcedencia").val("");
					$("#hidTiendaProcedencia").val("");
				}
				else
				{
					$("#hidTiendaProcedencia").val(item[0].hidTienda);
				}					
			
			});				
						
		}
	});
	
}

function Listar_Tienda_Receptora_Auto()
{
	
	$("#txtTiendaReceptora").autocomplete({
		source: "application/controllers/TiendaController.php?action=Listar_Tienda_Autocompletar",
		select:  function(event, ui) {
			
			$("#tbDetalle").empty();
			$("#cant_campos").val("0");
			$("#num_campos").val("0");		
			$("#hidTiendaReceptora").val(ui.item.hidTienda);
			
		},
		change: function (event, ui) {
		
			$("#tbDetalle").empty();
			$("#cant_campos").val("0");
			$("#num_campos").val("0");	
			
			$.post("application/controllers/TiendaController.php?action=Listar_Tienda_Autocompletar",
			{
				Tienda:$("#txtTiendaReceptora").val()
			},
			function(data){
			
				var item = JSON.parse(data);
				
				if (item === null)
				{
					$("#txtTiendaReceptora").val("");
					$("#hidTiendaReceptora").val("");
				}
				else
				{
					$("#hidTiendaReceptora").val(item[0].hidTienda);
				}					
			
			});				
		}
	});
	
}

function Agregar_Articulo_Orden()
{
	$.getScript("public/js/form_validation_table.js");		
	
	$("#cant_campos").val(parseInt($("#cant_campos").val()) + 1);
	var oId = $("#cant_campos").val();

	var strHtml0= '<td  align="center">' +  oId + '</td>';
	var strHtml1 = '<td><div class="formRight"><input class="validate[required]" type="text" name="txtCodigoBarra[]" id="txtCodigoBarra' + oId + '" style="width:80%" value="">';
		strHtml1 += '<input type="hidden" name="hidCodigoBarra[]" id="hidCodigoBarra' + oId + '" value=""  /></div></td>';	
	var strHtml2 = '<td><textarea class="validate[required]" rows="4" cols="" name="txtNombreProducto[]" id="txtNombreProducto' + oId + '" style="width:90%" value=""></textarea>';
		strHtml2 += '<input type="hidden" name="hidNombreProducto[]" id="hidNombreProducto' + oId + '" value="" />';
		strHtml2 += '<input type="hidden" name="hidProducto[]" id="hidProducto' + oId + '" value=""  /></td>';
	var strHtml3 = '<td><div class="formRight"><span class="req">*</span><input class="validate[required]" type="text" name="txtCantidad[]" id="txtCantidad' + oId + '" style="width:80%" value="">';
		strHtml3 += '<input type="hidden" name="hidCantidad[]" id="hidCantidad' + oId + '" value=""  /></div></td>';		
		
	var strHtml4 = '<td align="center"><button type="button" class="btn btn-danger btn-circle" onclick="if(confirm(\'Realmente quieres eliminar este Art&iacute;culo de la Orden?\')){Eliminar_Articulo_Orden(' + oId + ');}" title="Eliminar Art&iacute;lo"><i class="fa fa-times"></i></button></td>';	

	var strHtmlTr = '<tr id="rowDetalle_' + oId + '"  valign="center"  ></tr>';
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4;
	
    $("#tbDetalle").append(strHtmlTr);
	
	$("#rowDetalle_" + oId).html(strHtmlFinal);

	$("#txtCantidad" + oId).keydown(function(event){
		//alert(event.keyCode);
		if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
			return true;
		}
		else
		{
			return false;
		}
	});
	
	//mayuscula("[name='txtNombreContacto[]']");
	mayuscula("#txtCodigoBarra"+oId);
	mayuscula("#txtDescripcion"+oId);
	
	Listar_Codigo_Barra_Auto(oId);
	Listar_Nombre_Producto_Auto(oId);	
	
	return false;	
}

function Eliminar_Articulo_Orden (oId)
{
	$("#rowDetalle_" + oId).remove();

	if($("[name='txtCantidad[]']").length == 0)
	{
		$("#cant_campos").val("0");
		$("#num_campos").val("0");
	}		
		
	return false;

}


function Validar_Orden(Id,Tipo,TipoEntrada)
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);
	$('.btn.btn-success').attr("disabled",true);
	
	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);	
	var sec;
	if(getURLParameter('sec') === undefined)
	sec = "";
	else
	sec = getURLParameter('sec');	
	
	var arrCantidad = new Array();
	arrCantidad = $("[name='txtCantidad[]']");
	var ArrCantidad = [];
	for (var i = 0; i < arrCantidad.length; ++i) {
		ArrCantidad[i] = arrCantidad[i].value;
	}

	StrCantidad = JSON.stringify(ArrCantidad);
	
	var arrProducto = new Array();
	arrProducto = $("[name='hidProducto[]']");
	var ArrProducto = [];
	for (var i = 0; i < arrProducto.length; ++i) {
		ArrProducto[i] = arrProducto[i].value;
	}

	StrProducto = JSON.stringify(ArrProducto);
	
	$.post("application/controllers/OrdenController.php?action=Validar_Orden",
	{
		NumeroOrden:$("#txtNumeroOrden").val(),
		TipoOrden:$("#lstTipoOrden").val(),
		TipoOrdenEntrada:$("#lstTipoOrdenEntrada").val(),
		TipoOrdenInterno:$("#lstTipoOrdenInterno").val(),
		ProveedorProcedencia:$("#hidProveedorProcedencia").val(),
		BodegaProcedencia:$("#hidBodegaProcedencia").val(),
		BodegaReceptora:$("#hidBodegaReceptora").val(),		
		TiendaProcedencia:$("#hidTiendaProcedencia").val(),
		TiendaReceptora:$("#hidTiendaReceptora").val(),
		FechaOrden:$("#txtFechaOrden").val(),
		Observaciones:$("#txtObservaciones").val(),		
		Cantidad:StrCantidad,
		Producto:StrProducto		
	}, function(data){

		//alert(data);
		var item = JSON.parse(data);
		
		item .length
		var c;
		if (item.mensaje != "false")
		{
			Sexy.error(item.mensaje);
			if (item[0].TipoOrden == "true")
			$("#TipoOrden").addClass("has-error");
			else
			$("#TipoOrden").removeClass("has-error");
			if (item[0].TipoOrdenEntrada == "true")
			$("#TipoOrdenEntrada").addClass("has-error");
			else
			$("#TipoOrdenEntrada").removeClass("has-error");
			if (item[0].TipoOrdenInterno == "true")
			$("#TipoOrdenInterno").addClass("has-error");
			else
			$("#TipoOrdenInterno").removeClass("has-error");			
			if (item[0].BodegaProcedencia == "true")
			$("#BodegaProcedencia").addClass("has-error");
			else
			$("#BodegaProced").removeClass("has-error");			
			if (item[0].BodegaReceptora == "true")
			$("#BodegaReceptora").addClass("has-error");
			else
			$("#BodegaReceptora").removeClass("has-error");			
			if (item[0].TiendaProcedencia == "true")
			$("#TiendaProcedencia").addClass("has-error");
			else
			$("#TiendaProcede").removeClass("has-error");			
			if (item[0].TiendaReceptora == "true")
			$("#TiendaRecep").addClass("has-error");
			else
			$("#TiendaReceptora").removeClass("has-error");	
			if (item[0].Proveedor == "true")
			$("#ProveedorProcedencia").addClass("has-error");
			else
			$("#ProveedorProcedencia").removeClass("has-error");				
			
			c = 0;e = 1;	

			for (c in item) {

				if (item[c].Cantidad == "true")
				$("#Cantidad"+(e)).addClass("has-error");
				else
				$("#Cantidad"+(e)).removeClass("has-error");	
				if (item[c].Codigo == "true")
				$("#Codigo"+(e)).addClass("has-error");	
				else
				$("#Codigo"+(e)).removeClass("has-error");
				if (item[c].NombreProducto == "true")
				$("#NombreProducto"+(e)).addClass("has-error");	
				else
				$("#NombreProducto"+(e)).removeClass("has-error");				
				e++;
			}
			$('#loading').css("visibility","hidden");
			$('#main_content').css("opacity",1);				
			$('.btn.btn-success').attr("disabled",false);
		}
		else
		{
			$("#TipoOrden").removeClass("has-error");
			$("#TipoOrdenEntrada").removeClass("has-error");
			$("#TipoOrdenInterno").removeClass("has-error");			
			$("#BodegaProcedencia").removeClass("has-error");
			$("#BodegaReceptora").removeClass("has-error");			
			$("#TiendaProcedencia").removeClass("has-error");
			$("#TiendaReceptora").removeClass("has-error");
			$("#ProveedorProcedencia").removeClass("has-error");			
			$("#Autorizo").removeClass("has-error");	
			
			c = 0;e = 1;	
			for (c in item) {
				$("#Cantidad"+(e)).removeClass("has-error");
				$("#Codigo"+(e)).removeClass("has-error");	
				$("#NombreProducto"+(e)).removeClass("has-error");				
				e++;
			}	

			
			
			if ((filename == "admin.php") & (sec==btoa("agregar_orden")))
			{			
				$('#frmAgregarOrden').attr('method','POST');
				$('#frmAgregarOrden').attr('action','javascript:Agregar_Orden()');
				$('#frmAgregarOrden').submit();					
				
				
				//Agregar_Orden();
			}
			else if ((filename == "admin.php") & (sec==btoa("editar_orden")))
			{			
				$('#frmActualizarOrden').attr('method','POST');
				$('#frmActualizarOrden').attr('action','javascript:Actualizar_Orden("'+Id+'","'+Tipo+'","'+TipoEntrada+'")');
				$('#frmActualizarOrden').submit();					
				
				//Actualizar_Orden(Id,Tipo,TipoEntrada);
			}			
		}	
	
	});
}

function Agregar_Orden()
{

	var arrCantidad = new Array();
	arrCantidad = $("[name='txtCantidad[]']");
	var ArrCantidad = [];
	for (var i = 0; i < arrCantidad.length; ++i) {
		ArrCantidad[i] = arrCantidad[i].value;
	}

	StrCantidad = JSON.stringify(ArrCantidad);
	
	var arrProducto = new Array();
	arrProducto = $("[name='hidProducto[]']");
	var ArrProducto = [];
	for (var i = 0; i < arrProducto.length; ++i) {
		ArrProducto[i] = arrProducto[i].value;
	}

	StrProducto = JSON.stringify(ArrProducto);

	$.post("application/controllers/OrdenController.php?action=Agregar_Orden",
	{
		NumeroOrden:$("#txtNumeroOrden").val(),
		TipoOrden:$("#lstTipoOrden").val(),
		TipoOrdenEntrada:$("#lstTipoOrdenEntrada").val(),
		Proveedor:$("#hidProveedorProcedencia").val(),
		BodegaProcedencia:$("#hidBodegaProcedencia").val(),
		BodegaReceptora:$("#hidBodegaReceptora").val(),			
		TiendaProcedencia:$("#hidTiendaProcedencia").val(),
		TiendaReceptora:$("#hidTiendaReceptora").val(),
		FechaOrden:$("#txtFechaOrden").val(),
		Observaciones:$("#txtObservaciones").val(),		
		Cantidad:StrCantidad,
		Producto:StrProducto	
	}, function(data){

		//alert(data);
		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_ordenes');
				}
			});
			
		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);
	});
}

function Cancelar_Agregar_Orden()
{

	Sexy.confirm('Deseas Regresar al Listado de &Oacute;denes?.<br />Pulsa &quot;Ok&quot; para continuar, o pulsa &quot;Cancelar&quot; para salir.', {onComplete: 
		function(returnvalue) { 
			if(returnvalue)
			{
				Sexy.info('Datos ingresados no se guardar&aacute;n', {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('listar_ordenes')
					}
				});			
			}

		}
	});
}

function Listar_Ordenes()
{
	$('#listado_orden').dataTable( {
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"responsive":true,
		"info": true,
		"ajax": {
			"url": "application/controllers/OrdenController.php?action=Listar_Ordenes",			
			"type": "POST",
		},
		"pagingType":"full_numbers",
		"lengthMenu": [[5,10,15,25,50,75,100,150,-1],[5,10,15,25,50,75,100,150,"All"]],
		"pageLength": 10,
		//"paging": true,
		"dom": 'Bfrtip',
        "buttons": [
            'excel', 'pdf'
        ],
		"createdRow":function( nRow, aData, iDataIndex ) {
				$(nRow).attr('id', "rowDetalle_"+iDataIndex);
			},
		"columnDefs": [
			  { "className": "text-center", "targets": [ 0,1,2,3,4,5,6 ] },
			  { "searchable": false, "targets": [ 0,6 ] },
			  { "orderable": false, "targets": [ 6 ] },
			],
		"columns": [
			{ "data": 0 },
			{ "data": 1 },
			{ "data": 2 },
			{ "data": 3 },
			{ "data": 4 },
			{ "data": 5 },
			{ "data": 6 },		
		],
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

function Editar_Orden (oId)
{
	id_orden = $("#hdnIdCampos_" + oId).val();
	id_tipo_orden = $("#hdnIdCamposTipo_" + oId).val();
	id_tipo_orden_entrada = $("#hdnIdCamposTipoEntrada_" + oId).val();
	
	window.location.href='admin.php?sec='+btoa('editar_orden')+'&id='+id_orden+'&to='+id_tipo_orden+'&toe='+id_tipo_orden_entrada;
}

function Ver_Orden(Id,Tipo,TipoEntrada)
{	
	$.post("application/controllers/OrdenController.php?action=Ver_Orden",
	{
		IdOrden:Id,
		TipoOrden:Tipo,
		TipoOrdenEntrada:TipoEntrada
	}
	,function(data){
		//alert(data);
		var item = JSON.parse(data);
		
		$("#txtNumeroOrden").val(item[0].txtNumeroOrden);
		Listar_Tipo_Orden(undefined,item[0].lstTipoOrden);
		if (item[0].lstTipoOrdenEntrada != "")
		Listar_Tipo_Orden_Entrada(undefined,item[0].lstTipoOrdenEntrada);
		$("#txtFechaOrden").val(item[0].txtFechaOrden);
		$("#txtAutorizo").val(item[0].txtAutorizo);
		$("#hidAutorizo").val(item[0].hidAutorizo);
		$("#txtProveedorProcedencia").val(item[0].txtProveedorProcedencia);
		$("#hidProveedorProcedencia").val(item[0].hidProveedorProcedencia);
		$("#txtBodegaReceptora").val(item[0].txtBodegaReceptora);
		$("#hidBodegaReceptora").val(item[0].hidBodegaReceptora);
		$("#txtBodegaProcedencia").val(item[0].txtBodegaProcedencia);
		$("#hidBodegaProcedencia").val(item[0].hidBodegaProcedencia);		
		$("#txtTiendaReceptora").val(item[0].txtTiendaReceptora);
		$("#hidTiendaReceptora").val(item[0].hidTiendaReceptora);
		$("#txtTiendaProcedencia").val(item[0].txtTiendaProcedencia);
		$("#hidTiendaProcedencia").val(item[0].hidTiendaProcedencia);		
		$("#txtObservaciones").val(item[0].txtObservaciones);
	
		Listar_Articulos_Orden(Id,Tipo);
	});
}

function Listar_Articulos_Orden(Id,Tipo)
{
	//alert("prueba");
	$.post("application/controllers/OrdenController.php?action=Listar_Articulos_Orden",
	{
		IdOrden:Id,
		TipoOrden:Tipo
	}	
	,function(data)
	{
		//alert(data);
		$("#Lista_Articulos_Orden").html(data);
		//$.getScript("public/js/form_validation.js");
		$("[name='txtCantidad[]']").keydown(function(event){
			//alert(event.keyCode);
			if( event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});
		
		mayuscula("[name='txtCodigo[]']");
		mayuscula("[name='txtNombreProducto[]']");		
		mayuscula("[name='txtColor[]']");		
		
		Listar_Codigo_Producto_Auto('any');		
		Listar_Nombre_Producto_Auto('any');		
		
	});
}


function Actualizar_Orden(Id,Tipo,TipoEntrada)
{

	//alert(Id);
	var arrCantidad = new Array();
	arrCantidad = $("[name='txtCantidad[]']");
	var ArrCantidad = [];
	for (var i = 0; i < arrCantidad.length; ++i) {
		ArrCantidad[i] = arrCantidad[i].value;
	}

	StrCantidad = JSON.stringify(ArrCantidad);
	
	var arrProducto = new Array();
	arrProducto = $("[name='hidProducto[]']");
	var ArrProducto = [];
	for (var i = 0; i < arrProducto.length; ++i) {
		ArrProducto[i] = arrProducto[i].value;
	}

	StrProducto = JSON.stringify(ArrProducto);
	
	var arrIdOrdenDetalle = new Array();
	arrIdOrdenDetalle = $("[name='hdnIdCampos[]']");
	var ArrIdOrdenDetalle = [];
	for (var i = 0; i < arrIdOrdenDetalle.length; ++i) {
		ArrIdOrdenDetalle[i] = arrIdOrdenDetalle[i].value;
	}

	StrIdOrdenDetalle = JSON.stringify(ArrIdOrdenDetalle);		
	//alert(StrProducto);
	/*alert(Id)
	alert(Tipo);
	alert(TipoEntrada);*/
	$.post("application/controllers/OrdenController.php?action=Actualizar_Orden",
	{
		Proveedor:$("#hidProveedorProcedencia").val(),
		BodegaProcedencia:$("#hidBodegaProcedencia").val(),
		BodegaReceptora:$("#hidBodegaReceptora").val(),		
		TiendaProcedencia:$("#hidTiendaProcedencia").val(),
		TiendaReceptora:$("#hidTiendaReceptora").val(),
		FechaOrden:$("#txtFechaOrden").val(),
		Observaciones:$("#txtObservaciones").val(),		
		Cantidad:StrCantidad,
		Producto:StrProducto,
		IdOrdenDetalle:StrIdOrdenDetalle,		
		IdOrden:Id,
		IdTipoOrden:Tipo,
		IdTipoOrdenEntrada:TipoEntrada,
		TipoOrden:$("#lstTipoOrden").val(),
		TipoOrdenEntrada:$("#lstTipoOrdenEntrada").val()
	}, function(data){

		//alert(data);
		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_ordenes');
				}
			});
			
		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	});	
	
}

function Eliminar_Orden(oId)
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);
	$('.btn.btn-success').attr("disabled",true);
	
	var Id = $("#hdnIdCampos_" + oId).val();
	var Tipo = $("#hdnIdCamposTipo_" + oId).val();
	
	$.post("application/controllers/OrdenController.php?action=Eliminar_Orden",
	{
		IdOrden:Id,
		TipoOrden:Tipo
		
	}, function(data){

		
		if (data=="true")
		{
			$("#rowDetalle_" + oId).remove();			
			Sexy.info("Se ha eliminado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_ordenes');
				}
			});
		}
		else if (data=="false")
		Sexy.error("Error eliminar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);
		$('.btn.btn-success').attr("disabled",false);
	});
	
	return false;
}

function Listar_Movimiento_Productos()
{
	$('#listado_movimiento_producto').dataTable( {
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"responsive":true,
		"info": true,
		"ajax": {
			"url": "application/controllers/OrdenController.php?action=Listar_Movimiento_Productos",			
			"type": "POST",
		},
		"pagingType":"full_numbers",
		"lengthMenu": [[5,10,15,25,50,75,100,150,-1],[5,10,15,25,50,75,100,150,"All"]],
		"pageLength": 10,
		//"paging": true,
		"dom": 'Bfrtip',
			"buttons": [
             {
                extend: 'excelHtml5',
                title:'MOVIMIENTOS DE PRODUCTOS',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
            	extend: 'pdfHtml5',
                messageTop: 'LISTA DE PRODUCTOS',
                title:'MOVIMIENTOS DE PRODUCTOS',
                 exportOptions: {
                    columns: ':visible'
                }
            },
             {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                },
                 title:'MOVIMIENTOS DE PRODUCTOS'
            },
            'colvis',  'pageLength'
        ],
		"createdRow":function( nRow, aData, iDataIndex ) {
				$(nRow).attr('id', "rowDetalle_"+iDataIndex);
			},
		"columnDefs": [
			  { "className": "text-center", "targets": [ 0,1,2,3,4,5,6,7,8,9 ] },
			  { "searchable": false, "targets": [ 0 ] },
			  {"targets": [ 6 ],
                "visible": false,
                "searchable": false
            },
            {"targets": [ 7 ],
                "visible": false,
                "searchable": false
            },
            {"targets": [ 8 ],
                "visible": false,
                "searchable": false
            },
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
			{ "data": 9 },			
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
		
			$("#txtPrecioVenta").val(data);
		
		})

	}	
}

function Listar_Cotizacion_Orden_Auto()
{
	
	$("#txtNumeroCotizacion").autocomplete({
		source: "application/controllers/OrdenController.php?action=Listar_Cotizacion_Orden_Autocompletar",
		select:  function(event, ui) {

			$("#txtDescripcionCotizacion").val(ui.item.value);
			$("#hiNumeroCotizacion").val(ui.item.numero_cotizacion);
			Listar_Trabajo_Cotizacion(calcMD5(ui.item.numero_cotizacion));
		},
		change: function (event, ui) {
					
			$.post("application/controllers/OrdenController.php?action=Listar_Cotizacion_Orden_Autocompletar",
			{
				NumeroCotizacion:$("#txtNumeroCotizacion").val()
			},
			function(data){

				var item = JSON.parse(data);
				
				if (item === null)
				{
					$("#txtNumeroCotizacion").val("");
					$("#hiNumeroCotizacion").val("");
					$("#txtDescripcionCotizacion").val("");					
				}
				else
				{
					$("#txtDescripcionCotizacion").val(item[0].value);
					$("#hiNumeroCotizacion").val(ui.item.numero_cotizacion);
					Listar_Trabajo_Cotizacion(calcMD5(item[0].numero_cotizacion));
				}					
			
			});					
		}
	});
	
	return false
}

function Buscar_Cotizacion_Orden(cotizacion)
{

	$.post("application/controllers/OrdenController.php?action=Buscar_Cotizacion_Orden",
	{
		idCotizacion:cotizacion
	},
	function(data) {
		//alert(data);
		$resultArr  = JSON.parse(data);
		
		$("#txtNumeroCotizacion").val($resultArr[0]);
		$("#txtDescripcionCotizacion").val($resultArr[1]);	
	});
}

function Listar_Trabajo_Cotizacion(Cotizacion)
{
	
	$.post("application/controllers/OrdenController.php?action=Listar_Trabajo_Cotizacion",
	{

		id:Cotizacion
	},
	function(data) {

		//alert(data);
		$("#tbTrabajo").html(data);
		$.getScript("public/js/form_validation.js");
		$("[name='seleccionado[]']").hide();
				
		$("input[name='rdbseleccion']").change(function(){
			
			if($(this).is(":checked"))
			{
				var fila = $(this).attr('id');
				fila = fila.substr(12);
				
				//alert(fila);
				
				//oId = $("input[name='rdbseleccion']:checked").val();
				//alert($("#seleccionado"+fila).html());
				
				
					
				var c = 1;
				while (c <= $("[name='seleccionado[]']").length)
				{				
					if(c != fila)
					{				
				
						//alert(c);
						$("#txtUsuarioAsignado1"+c).val("");
						$("#hidUsuarioAsignado1"+c).val("");				
						$("#txtUsuarioAsignado2"+c).val("");
						$("#hidUsuarioAsignado2"+c).val("");				
						$("#txtUsuarioAsignado3"+c).val("");
						$("#hidUsuarioAsignado3"+c).val("");				
						$("#txtUsuarioAsignado4"+c).val("");
						$("#hidUsuarioAsignado4"+c).val("");
						$("#seleccionado"+c).hide();
					}
					
					c++;
				}
				
				$("#seleccionado"+fila).show();
				//$.getScript("public/js/form_validation.js");
				//$.getScript("public/js/form_validation.js");
			}
			
			/*alert(oId);
			var c = 1;
			while (c <= $("[name='seleccionado[]']").length)
			{
				
				$("#txtUsuarioAsignado1"+c).val("");
				$("#hidUsuarioAsignado1"+c).val("");				
				$("#txtUsuarioAsignado2"+c).val("");
				$("#hidUsuarioAsignado2"+c).val("");				
				$("#txtUsuarioAsignado3"+c).val("");
				$("#hidUsuarioAsignado3"+c).val("");				
				$("#txtUsuarioAsignado4"+c).val("");
				$("#hidUsuarioAsignado4"+c).val("");
				$("#seleccionado"+c).hide();
				c++;
			}*/
		
			
				
			$("#txtUsuarioAsignado1"+fila).autocomplete({
				source: "application/controllers/UsuarioController.php?action=Listar_Usuario_Autocompletar",
				select:  function(event, ui) {
		
				$("#hidUsuarioAsignado1"+fila).val(ui.item.id_usuario);
				//alert(ui.item.value);
				//alert(ui.item.id_usuario);
				//alert($("#hidUsuarioAsignado1"+c).val());

				},
				change: function (event, ui) {
				
					if (ui.item === null)
					{	
						$("#txtUsuarioAsignado1"+fila).val("");
						$("#hidUsuarioAsignado1"+fila).val("");				
					}
					else
					{
						
						$("#hidUsuarioAsignado1"+fila).val(ui.item.id_usuario);

					}				
				}
		
			});

			$("#txtUsuarioAsignado2"+fila).autocomplete({
				source: "application/controllers/UsuarioController.php?action=Listar_Usuario_Autocompletar",
				select:  function(event, ui) {
				
				$("#hidUsuarioAsignado2"+fila).val(ui.item.id_usuario);
				//alert(ui.item.value);
				//alert(ui.item.value);
				//alert($("#hidUsuarioAsignado").val());

				},
				change: function (event, ui) {
				
					if (ui.item === null)
					{	
						$("#txtUsuarioAsignado2"+fila).val("");
						$("#hidUsuarioAsignado2"+fila).val("");				
					}
					else
					{
						
						$("#hidUsuarioAsignado2"+fila).val(ui.item.id_usuario);

					}				
				}

			});	
	
			$("#txtUsuarioAsignado3"+fila).autocomplete({
				source: "application/controllers/UsuarioController.php?action=Listar_Usuario_Autocompletar",
				select:  function(event, ui) {
		
				$("#hidUsuarioAsignado3"+fila).val(ui.item.id_usuario);
				//alert(ui.item.value);
				//alert(ui.item.value);
				//alert($("#hidUsuarioAsignado").val());

				},
				change: function (event, ui) {
				
					if (ui.item === null)
					{	
						$("#txtUsuarioAsignado3"+fila).val("");
						$("#hidUsuarioAsignado3"+fila).val("");				
					}
					else
					{
						
						$("#hidUsuarioAsignado3"+fila).val(ui.item.id_usuario);

					}				
				}

			});	
	
			$("#txtUsuarioAsignado4"+fila).autocomplete({
				source: "application/controllers/UsuarioController.php?action=Listar_Usuario_Autocompletar",
				select:  function(event, ui) {
		
				$("#hidUsuarioAsignado4"+oId).val(ui.item.id_usuario);
				//alert(ui.item.value);
				//alert(ui.item.value);
				//alert($("#hidUsuarioAsignado").val());

				},
				change: function (event, ui) {
				
					if (ui.item === null)
					{	
						$("#txtUsuarioAsignado4"+fila).val("");
						$("#hidUsuarioAsignado4"+fila).val("");				
					}
					else
					{
						
						$("#hidUsuarioAsignado4"+fila).val(ui.item.id_usuario);

					}				
				}

			});	
		});
	
	});	
}

function Agregar_Orden_Trabajo()
{
	oId = $("input[name='rdbseleccion']:checked").val();

	var arrUsuarioAsignado1 = new Array();
	arrUsuarioAsignado1 = $("[name='hidUsuarioAsignado1[]']");
	var ArrUsuarioAsignado1 = [];
	for (var i = 0; i < arrUsuarioAsignado1.length; ++i) {
		ArrUsuarioAsignado1[i] = arrUsuarioAsignado1[i].value;
	}

	StrUsuarioAsignado1 = ArrUsuarioAsignado1.toString();

	var arrUsuarioAsignado2 = new Array();
	arrUsuarioAsignado2 = $("[name='hidUsuarioAsignado2[]']");
	var ArrUsuarioAsignado2 = [];
	for (var i = 0; i < arrUsuarioAsignado2.length; ++i) {
		ArrUsuarioAsignado2[i] = arrUsuarioAsignado2[i].value;
	}

	StrUsuarioAsignado2 = ArrUsuarioAsignado2.toString();	

	var arrUsuarioAsignado3 = new Array();
	arrUsuarioAsignado3 = $("[name='hidUsuarioAsignado3[]']");
	var ArrUsuarioAsignado3 = [];
	for (var i = 0; i < arrUsuarioAsignado3.length; ++i) {
		ArrUsuarioAsignado3[i] = arrUsuarioAsignado3[i].value;
	}

	StrUsuarioAsignado3 = ArrUsuarioAsignado3.toString();

	var arrUsuarioAsignado4 = new Array();
	arrUsuarioAsignado4 = $("[name='hidUsuarioAsignado4[]']");
	var ArrUsuarioAsignado4 = [];
	for (var i = 0; i < arrUsuarioAsignado4.length; ++i) {
		ArrUsuarioAsignado4[i] = arrUsuarioAsignado4[i].value;
	}

	StrUsuarioAsignado4 = ArrUsuarioAsignado4.toString();	
	
	//alert(StrUsuarioAsignado1);
	//alert(StrUsuarioAsignado3);
	//alert(("#hidTipoTrabajo"+oId).val());
	//alert(("#hidIdTrabajo"+oId).val());
	//alert($("#txtFechaEntrega").val());
	$.post("application/controllers/OrdenController.php?action=Agregar_Orden_Trabajo",
	{
		NumeroCotizacion:$("#txtNumeroCotizacion").val(),
		FechaEntrega:$("#txtFechaEntrega").val(),
		UsuarioAsignado1:StrUsuarioAsignado1,
		UsuarioAsignado2:StrUsuarioAsignado2,
		UsuarioAsignado3:StrUsuarioAsignado3,
		UsuarioAsignado4:StrUsuarioAsignado4,		
		TipoTrabajo:$("#hidTipoTrabajo"+oId ).val(),
		IdTrabajo:$("#hidIdTrabajo"+oId).val()
		
	}, function(data){
		
		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos",{
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_ordenes_trabajos');
				}
			});
		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
	})






}

function Listar_Ordenes_Trabajos()
{
	/*$("#Lista_Ordenes_Trabajos").load("application/controllers/OrdenController.php?action=Listar_Ordenes_Trabajos",function(){
	
		oTable = $('.dTable').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": true,
			"iDisplayLength": 10,
			"sDom": '<""l>t<"F"fp>'
		});
	});*/
	
	$('#listado_orden_trabajo').dataTable( {
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"responsive":true,
		"info": true,
		"ajax": {
			"url": "application/controllers/OrdenController.php?action=Listar_Ordenes_Trabajos",		
			"type": "POST",
		},
		"pagingType":"full_numbers",
		"lengthMenu": [[5,10,15,25,50,75,100,150,-1],[5,10,15,25,50,75,100,150,"All"]],
		"pageLength": 10,
		//"paging": true,
		"dom": 'Bfrtip',
        "buttons": [
             {
                extend: 'excelHtml5',
                title:'LISTA DE ORDENES DE TRABAJO',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
            	extend: 'pdfHtml5',
                messageTop: 'LISTA DE ORDENES',
                title:'LISTA DE ORDENES DE TRABAJO',
                 exportOptions: {
                    columns: ':visible'
                }
            },
             {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                },
                 title:'LISTA DE ORDENES DE TRABAJO'
            },
            'colvis', 'pageLength'
        ],
         columnDefs: [ {
            targets: -1,
            visible: false
        } ],
		"createdRow":function( nRow, aData, iDataIndex ) {
				$(nRow).attr('id', "rowDetalle_"+iDataIndex);
				$(nRow).attr('class', "gradeA");
			},
		"columnDefs": [
			  { "className": "text-center", "targets": [ 0,9 ] },
			  { "searchable": false, "targets": [ 0,9 ] },
			  { "orderable": false, "targets": [ 9 ] },
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
			{ "data": 9 },
		],
		
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

function Subir_Arte(Id)
{
	window.location.href='admin.php?sec='+btoa('subir_arte')+'&id='+Id;
}

function Listar_Cotizacion_Auto()
{

	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	var sec;
	if(getURLParameter('sec') === undefined)
	sec = "";
	else
	sec = getURLParameter('sec'); 

	var strHtml0 = '<label>N&uacute;mero de Cotizaci&oacute;n:<span class="req">*</span></label>';
		strHtml0 += '<div class="formRight">';
		strHtml0 += '<input type="text" value="" class="validate[required]" name="txNumeroCotizacion" id="txtNumeroCotizacion"  style="width:100%"/>';			
		strHtml0 += '</div>';
		strHtml0 += '<div class="clear">';
		strHtml0 += '</div>';	
	
	$("#NumeroCotizacion").html(strHtml0);
	
	$("#txtNumeroCotizacion").keydown(function(event){

		if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
			return true;
		}
		else
		{
			return false;
		}
				
	});	
	
	$("#txtNumeroCotizacion").autocomplete({
		source: "application/controllers/CotizacionController.php?action=Listar_Cotizacion_Autocompletar",
		select:  function(event, ui) {

			$("#txtDescripcionCotizacion").val(ui.item.descripcion_cotizacion);
			ui.item.value = ui.item.numero_cotizacion;
			
			if ((filename == "admin.php") & (sec==btoa("editar_cotizacion")))
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

				if ((filename == "admin.php") & (sec==btoa("editar_cotizacion")))
				{	//alert(ui.item.value);
					Buscar_Cliente(calcMD5(ui.item.numero_cotizacion));
					Cargar_Cotizacion(calcMD5(ui.item.numero_cotizacion));
					$("#txtNumeroCotizacion").attr('readonly', true);
					$("#txtDescripcionCotizacion").val(ui.item.descripcion_cotizacion);
				}
			}				
		}
	});	

}

function Listar_Descripcion_Cotizacion_Auto()
{
		var strHtml0 = '<label>Descripci&oacute;n de Cotizaci&oacute;n:<span class="req">*</span></label>';
			strHtml0 += '<div class="formRight">';
			strHtml0 += '<input type="text" value="" class="validate[required]" name="txtDescripcionCotizacion" id="txtDescripcionCotizacion"  style="width:100%"/>';
			strHtml0 += '</div>';
			strHtml0 += '<div class="clear">';
			strHtml0 += '</div>';	
	
	$("#DescripcionCotizacion").html(strHtml0);
		
	$("#txtDescripcionCotizacion").autocomplete({
		source: "application/controllers/CotizacionController.php?action=Listar_Descripcion_Cotizacion_Autocompletar",
		select:  function(event, ui) {
		//alert(ui.item.value);
		//alert($("#txtNumeroCotizacion").val());
				
		}

	});
	
}

function Cargar_Diseno_Arte()
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);
	
	var archivos = document.getElementById("file");
	var archivo = archivos.files; 

	var data = new FormData();

	for(i=0; i<archivo.length; i++){
		data.append('archivo'+i,archivo[i]);
	}

	

	id_cotizacion = calcMD5($("#txtNumeroCotizacion").val());
	
	$.ajax({
		url:'application/controllers/OrdenController.php?action=Cargar_Diseno_Arte&id='+id_cotizacion, //Url a donde la enviaremos
		type:'POST', //Metodo que usaremos
		contentType:false, //Debe estar en false para que pase el objeto sin procesar
		data:data, //Le pasamos el objeto que creamos con los archivos
		processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
		cache:false //Para que el formulario no guarde cache
	}).done(function(msg){
		
		//alert(msg);
		$resultArr  = JSON.parse(msg);
		
		var c = 1; var strHtml0 = "";
		while (c < $resultArr.length)
		{
			strHtml0 += '<input type="hidden" name="idad[]" id="idad'+c+'" value="'+ $resultArr[c] +'" />';
			c++;
		}
		
		$("#archivo").html(strHtml0);
		
		if ($resultArr[0]=="true")
		{
			Sexy.info("Se ha cargado exit&oacute;samente");
		}		
		else if ($resultArr[0]=="false")
		Sexy.error("Error cargar Archivo");			
		//$("#cargados").append(msg); //Mostrara los archivos cargados en el div con el id "Cargados"
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	});
}

function Cargar_Diseno_Dropbox()
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);
	
	var url = location.toString();
	var oauth_token = getURLParameter('oauth_token'); 
	var auth_callback = getURLParameter('auth_callback'); 
	//alert(auth_callback);

	var archivos = document.getElementById("file");
	var archivo = archivos.files; 

	var Arrfile = [];
	for(i=0; i<archivo.length; i++){
		Arrfile[i] = archivo[i].name;
	}
	
	Strfile = JSON.stringify(Arrfile);
	
	var arridad = new Array();
	arridad = $("[name='idad[]']");
	var Arridad = [];
	for (var i = 0; i < arridad.length; ++i) {
	Arridad[i] = arridad[i].value;
	}	
	//alert($("[name='idad[]']").length);
	Stridad = JSON.stringify(Arridad);	
	
	//alert(Stridad);
	
	if (archivo.length > 5)
	{
		Sexy.error("Error Guardar Registro de Carga de Archivo de Dropbox,\n solo puedes cargar hasta 5 archivos por Cotización.")
	
	}
	else
	{
		$.post("application/controllers/OrdenController.php?action=Cargar_Diseno_Dropbox",
		{
			NumeroCotizacion:calcMD5($("#txtNumeroCotizacion").val()),
			DescripcionCotizacion:$("#txtDescripcionCotizacion").val(),
			file:Strfile,
			idad:Stridad,
			Url:url,
			Oauth_token:oauth_token,
			Auth_callback:auth_callback
		},
		function(data) {
		
			//alert(data);
			if (data=="true")
			{
				Sexy.info("Se ha cargado Satisfact&oacute;riamnente a Dropbox",{
				onComplete:function (returnvalue) {

						window.location.href='admin.php?sec='+btoa('listar_archivos_dropbox');
					}
				});
			}
			else if (data=="false1")
			Sexy.error("Error Guardar Registro de Carga de Archivo de Dropbox");			
			else if (data=="false")
			Sexy.error("Error cargar Archivo a Dropbox");	
		});
	
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	
	}
	


}

function Listar_Archivos_DropBox()
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);	
	
	var url = location.toString();
	var oauth_token = getURLParameter('oauth_token'); 
	var auth_callback = getURLParameter('auth_callback');
	
	$.post("application/controllers/OrdenController.php?action=Listar_Archivos_DropBox",
	{
		Url:url,
		Oauth_token:oauth_token,
		Auth_callback:auth_callback
	},
	function(data) {

		//alert(data);
		
		$("#Lista_Archivos_DropBox").html(data);	
		
		oTable = $('.dTable').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": true,
			"iDisplayLength": 10,
			"sDom": '<""l>t<"F"fp>'
		});
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);	
	});	
}



function Descargar_Archivo(path, file)
{
	var url = location.toString();
	var oauth_token = getURLParameter('oauth_token'); 
	var auth_callback = getURLParameter('auth_callback');	
	
	$.post("application/controllers/OrdenController.php?action=Descargar_Archivo",
	{
		Path:path,
		File:file,
		Url:url,
		Oauth_token:oauth_token,
		Auth_callback:auth_callback
	},
	function(data) {

		Sexy.info(data);
		
		//$("#Lista_Archivo_DropBox").html(data);	
	
	});


}

function Imprimir_Orden_Trabajo(id_orden)
{

	$.post("application/controllers/OrdenController.php?action=Imprimir_Orden_Trabajo",
	{	
		id:id_orden
	
	}, function(data){
			
			
			window.open(data, 'win3', 'width=1024, height=768,  left=20, top=20, resizable=yes, scrollbars=yes,toolbar=no,location=no,directories=no, status=no,menubar=no');
			//window.location.href='listar_cotizacion.html';
	});
}


function Agregar_Asignar_Usuario(oId)
{
	$("#cant_campos").val(parseInt($("#cant_campos").val()) + 1);
	var oId = $("#cant_campos").val();

	var strHtml0 = '<label>Nombre del Usuario Asignado:<span class="req">*</span></label>';
		strHtml0 += '<div class="formRight">';
		strHtml0 += '<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado[]" id="txtUsuarioAsignado'+oId+'"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado" id="hidUsuarioAsignado'+oId+'"/>';
		strHtml0 += '</div>';
		strHtml0 += '<div class="clear">';
		strHtml0 += '</div>';	
	
	$("#UsuarioAsignado").append(strHtml0);


	$("#txtUsuarioAsignado"+oId).autocomplete({
		source: "application/controllers/UsuarioController.php?action=Listar_Usuario_Autocompletar",
		select:  function(event, ui) {
		
			$("#hidUsuarioAsignado"+oId).val(ui.item.id_usuario);

		},
		change: function (event, ui) {
		
			if (ui.item === null)
			{	
				$("#txtUsuarioAsignado"+oId).val("");
				$("#hidUsuarioAsignado"+oId).val("");				
			}
			else
			{
				
				$("#hidUsuarioAsignado"+oId).val(ui.item.id_usuario);
			}				
		}	

	});	
}

function GenerarEstatusOrdenTrabajo(Estatus,oId,TipoEstatus)
{

	$("#lstEstatusOrden"+ Estatus + oId).load("application/controllers/OrdenController.php?action=Listar_Estatus_Orden",
	function(data) {
		
		$("#lstEstatusOrden"+ Estatus + oId).find('option').remove().end().append('<option value="">Seleccione</option>');
		$("#lstEstatusOrden"+ Estatus + oId).append(data);

		$("#lstEstatusOrden"+ Estatus + oId + " option[value=" + TipoEstatus + "]").attr("selected",true);	
	});	

}

function Editar_Orden_Trabajo(oId)
{


	$.getScript("public/js/form_validation_table.js");
	
	var NoOrdenTrabajo = $("#hidNoOrdenTrabajo" + oId).val();
	var NoCotizacion = $("#hidNoCotizacion" + oId).val();
	var DescripcionTrabajo = $("#hidDescripcionTrabajo" + oId).val();	
	var Usuario1 = $("#hidUsuario1" + oId).val();
	var Usuario2 = $("#hidUsuario2" + oId).val();
	var Usuario3 = $("#hidUsuario3" + oId).val();
	//var Usuario4 = $("#hidUsuario4" + oId).val();	
	var IdUsuario1 = $("#hidIdUsuario1" + oId).val();
	var IdUsuario2 = $("#hidIdUsuario2" + oId).val();
	var IdUsuario3 = $("#hidIdUsuario3" + oId).val();
	//var IdUsuario4 = $("#hidIdUsuario4" + oId).val();	
	var Estatus = $("#hidEstatus" + oId).val();
	var Porcentaje = $("#hidPorcentaje" + oId).val();
	var IdEstatusOrden1 = $("#hidIdEstatusOrden1" + oId).val();
	var IdEstatusOrden2 = $("#hidIdEstatusOrden2" + oId).val();
	var IdEstatusOrden3 = $("#hidIdEstatusOrden3" + oId).val();
	//var IdEstatusOrden4 = $("#hidIdEstatusOrden4" + oId).val();	
	var EstatusOrden1 = $("#hidEstatusOrden1" + oId).val();
	var EstatusOrden2 = $("#hidEstatusOrden2" + oId).val();
	var EstatusOrden3 = $("#hidEstatusOrden3" + oId).val();	
	//var EstatusOrden4 = $("#hidEstatusOrden4" + oId).val();		

	var Id = $("#hdnIdCampos_" + oId).val();
	Calcular_Precio(oId);	

	

	//alert(RUC.length);
	var strHtml0 = '<td align="center">' +  oId + '</td>';		
		strHtml0 += '<td align="center">' + NoOrdenTrabajo + '<input type="hidden" id="hidNoOrdenTrabajo' + oId + '" name="hidNoOrdenTrabajo[]" value="'+ NoOrdenTrabajo +'"  /></td>';
	var strHtml1 = '<td align="center">' + NoCotizacion + '<input type="hidden" id="hidNoCotizacion' + oId + '" name="hidNoCotizacion[]" value="'+ NoCotizacion +'"  /></td>';		
	var strHtml2 = '<td>' + DescripcionTrabajo + '<input type="hidden" id="hidDescripcionTrabajo' + oId + '" name="hidDescripcionTrabajo[]" value="'+ DescripcionTrabajo +'"/></td>';	
	
	//alert(IdUsuario1);
	
	if (IdUsuario1 == "")
	{
		var strHtml3 = '<td>No Asignado<input type="hidden" id="hidUsuario1' + oId + '" name="hidUsuario1[]" value=""  /><input type="hidden" id="hidIdUsuario1' + oId + '" name="hidIdUsuario1[]" value=""  />';
			strHtml3 += '<input type="hidden" id="hidEstatusOrden1' + oId + '" name="hidEstatusOrden1[]" value=""  /><input type="hidden" id="hidIdEstatusOrden1' + oId + '" name="hidIdEstatusOrden1[]" value=""  /></td>';
	}
	else
	{
		if (IdEstatusOrden1 == 4)
		{
			var	strHtml3 = '<td>' + Usuario1 + '/' + EstatusOrden1 + '<input type="hidden" id="hidUsuario1' + oId + '" name="hidUsuario1[]" value="'+ Usuario1 +'"  /><input type="hidden" id="hidIdUsuario1' + oId + '" name="hidIdUsuario1[]" value="'+ IdUsuario1 +'"  /></td>';
				strHtml3 += '<input type="hidden" id="hidEstatusOrden1' + oId + '" name="hidEstatusOrden1[]" value="'+ EstatusOrden1 +'"  /><input type="hidden" id="hidIdEstatusOrden1' + oId + '" name="hidIdEstatusOrden1[]" value="'+ IdEstatusOrden1 +'"  /></td>';
		}
		else if (IdEstatusOrden1 == 2)
		{
			var strHtml3 = '<td><label>Asignar:<span class="req">*</span></label>';
				strHtml3 += '<div class="formRight">';
				strHtml3 += '<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado1[]" id="txtUsuarioAsignado1' + oId + '"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado2[]" id="hidUsuarioAsignado2' + oId + '"/>';
				strHtml3 += '</div><div class="clear"></div>';
				strHtml3 += '<input type="hidden" id="hidUsuario1' + oId + '" name="hidUsuario1[]" value=""  /><input type="hidden" id="hidIdUsuario1' + oId + '" name="hidIdUsuario1[]" value=""  />';
				strHtml3 += '<input type="hidden" id="hidEstatusOrden1' + oId + '" name="hidEstatusOrden1[]" value=""  /><input type="hidden" id="hidIdEstatusOrden1' + oId + '" name="hidIdEstatusOrden1[]" value=""  /></td>';
		}
		else
		{
			var strHtml3 = '<td>Estatus de ' + Usuario1;
				strHtml3 += '<select name="lstEstatusOrden1[]" id="lstEstatusOrden1' + oId + '" class="validate[required]" >';
				strHtml3 += '<option value="">Seleccione</option>';	
				strHtml3 += '</select><input type="hidden" id="hidUsuario1' + oId + '" name="hidUsuario1[]" value="'+ Usuario1 +'"  />';
				strHtml3 += '<input type="hidden" id="hidIdUsuario1' + oId + '" name="hidIdUsuario1[]" value="'+ IdUsuario1 +'"  />';
				strHtml3 += '<input type="hidden" id="hidIdEstatusOrden1' + oId + '" name="hidIdEstatusOrden1[]" value="'+ IdEstatusOrden1 +'"  />';		
				strHtml3 += '<input type="hidden" id="hidEstatusOrden1' + oId + '" name="hidEstatusOrden1[]" value="'+ EstatusOrden1 +'"  /></td>';		
		}	
	}
	

	if (IdUsuario2 == "")
	{
		if ((IdEstatusOrden2 == "") & (IdEstatusOrden1 == 4) & (IdUsuario1 != "")) 
		{
			strHtml3 += '<td><label>Asignar:<span class="req">*</span></label>';
			strHtml3 += '<div class="formRight">';
			strHtml3 += '<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado2[]" id="txtUsuarioAsignado2' + oId + '"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado2[]" id="hidUsuarioAsignado2' + oId + '"/>';
			strHtml3 += '</div><div class="clear"></div>';
			strHtml3 += '<input type="hidden" id="hidUsuario2' + oId + '" name="hidUsuario2[]" value=""  /><input type="hidden" id="hidIdUsuario2' + oId + '" name="hidIdUsuario2[]" value=""  />';
			strHtml3 += '<input type="hidden" id="hidEstatusOrden2' + oId + '" name="hidEstatusOrden2[]" value=""  /><input type="hidden" id="hidIdEstatusOrden2' + oId + '" name="hidIdEstatusOrden2[]" value=""  /></td>';
		}		
		else
		{
			strHtml3 += '<td>No Asignado<input type="hidden" id="hidUsuario2' + oId + '" name="hidUsuario2[]" value=""  /><input type="hidden" id="hidIdUsuario2' + oId + '" name="hidIdUsuario2[]" value=""  />';
			strHtml3 += '<input type="hidden" id="hidEstatusOrden2' + oId + '" name="hidEstatusOrden2[]" value=""  /><input type="hidden" id="hidIdEstatusOrden2' + oId + '" name="hidIdEstatusOrden2[]" value=""  /></td>';
		}
			
	}
	else
	{	
		if (IdEstatusOrden2 == 4) 
		{
			strHtml3 += '<td>' + Usuario2 + '/' + EstatusOrden2 + '<input type="hidden" id="hidUsuario2' + oId + '" name="hidUsuario2[]" value="'+ Usuario2 +'"  /><input type="hidden" id="hidIdUsuario2' + oId + '" name="hidIdUsuario2[]" value="'+ IdUsuario2 +'"  /></td>';
			strHtml3 += '<input type="hidden" id="hidEstatusOrden2' + oId + '" name="hidEstatusOrden2[]" value="'+ EstatusOrden2 +'"  /><input type="hidden" id="hidIdEstatusOrden2' + oId + '" name="hidIdEstatusOrden2[]" value="'+ IdEstatusOrden2 +'"  /></td>';
		}
		else if (IdEstatusOrden2 == 2) 
		{
			strHtml3 += '<td><label>Asignar:<span class="req">*</span></label>';
			strHtml3 += '<div class="formRight">';
			strHtml3 += '<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado2[]" id="txtUsuarioAsignado2' + oId + '"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado2[]" id="hidUsuarioAsignado2' + oId + '"/>';
			strHtml3 += '</div><div class="clear"></div>';
			strHtml3 += '<input type="hidden" id="hidUsuario2' + oId + '" name="hidUsuario2[]" value=""  /><input type="hidden" id="hidIdUsuario2' + oId + '" name="hidIdUsuario2[]" value=""  />';
			strHtml3 += '<input type="hidden" id="hidEstatusOrden2' + oId + '" name="hidEstatusOrden2[]" value=""  /><input type="hidden" id="hidIdEstatusOrden2' + oId + '" name="hidIdEstatusOrden2[]" value=""  /></td>';
		}		
		else
		{	
			strHtml3 += '<td>Estatus de ' + Usuario2;	
			strHtml3 += '<select name="lstEstatusOrden2[]" id="lstEstatusOrden2' + oId + '" class="validate[required]" >';
			strHtml3 += '<option value="">Seleccione</option>';	
			strHtml3 += '</select><input type="hidden" id="hidUsuario2' + oId + '" name="hidUsuario2[]" value="'+ Usuario2 +'"  />';
			strHtml3 += '<input type="hidden" id="hidIdUsuario2' + oId + '" name="hidIdUsuario2[]" value="'+ IdUsuario2 +'"  />';
			strHtml3 += '<input type="hidden" id="hidIdEstatusOrden2' + oId + '" name="hidIdEstatusOrden2[]" value="'+ IdEstatusOrden2 +'"  />';			
			strHtml3 += '<input type="hidden" id="hidEstatusOrden2' + oId + '" name="hidEstatusOrden2[]" value="'+ EstatusOrden2 +'"  /></td>';
		}
	}
	
	
	if (IdUsuario3 == "")
	{
		if ((IdEstatusOrden3 == "") & (IdEstatusOrden2 == 4) & (IdUsuario2 != "")) 
		{
			strHtml3 += '<td><label>Asignar:<span class="req">*</span></label>';
			strHtml3 += '<div class="formRight">';
			strHtml3 += '<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado3[]" id="txtUsuarioAsignado3' + oId + '"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado3[]" id="hidUsuarioAsignado3' + oId + '"/>';
			strHtml3 += '</div><div class="clear"></div>';
			strHtml3 += '<input type="hidden" id="hidUsuario3' + oId + '" name="hidUsuario3[]" value=""  /><input type="hidden" id="hidIdUsuario3' + oId + '" name="hidIdUsuario3[]" value=""  />';
			strHtml3 += '<input type="hidden" id="hidEstatusOrden3' + oId + '" name="hidEstatusOrden3[]" value=""  /><input type="hidden" id="hidIdEstatusOrden3' + oId + '" name="hidIdEstatusOrden3[]" value=""  /></td>';
		}			
		else
		{			
			strHtml3 += '<td>No Asignado<input type="hidden" id="hidUsuario3' + oId + '" name="hidUsuario3[]" value=""  /><input type="hidden" id="hidIdUsuario3' + oId + '" name="hidIdUsuario3[]" value=""  />';
			strHtml3 += '<input type="hidden" id="hidEstatusOrden3' + oId + '" name="hidEstatusOrden3[]" value=""  /><input type="hidden" id="hidIdEstatusOrden3' + oId + '" name="hidIdEstatusOrden3[]" value=""  /></td>';
		}
	}
	else
	{		
		if (IdEstatusOrden3 == 4) 
		{
			strHtml3 += '<td>' + Usuario3 + '/' + EstatusOrden3 + '<input type="hidden" id="hidUsuario3' + oId + '" name="hidUsuario3[]" value="'+ Usuario3 +'"  /><input type="hidden" id="hidIdUsuario3' + oId + '" name="hidIdUsuario3[]" value="'+ IdUsuario3 +'"  /></td>';
			strHtml3 += '<input type="hidden" id="hidEstatusOrden3' + oId + '" name="hidEstatusOrden3[]" value="'+ EstatusOrden3 +'"  /><input type="hidden" id="hidIdEstatusOrden3' + oId + '" name="hidIdEstatusOrden3[]" value="'+ IdEstatusOrden3 +'"  /></td>';		
		}
		else if (IdEstatusOrden3 == 2) 
		{
			strHtml3 += '<td><label>Asignar:<span class="req">*</span></label>';
			strHtml3 += '<div class="formRight">';
			strHtml3 += '<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado3[]" id="txtUsuarioAsignado3' + oId + '"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado3[]" id="hidUsuarioAsignado3' + oId + '"/>';
			strHtml3 += '</div><div class="clear"></div>';
			strHtml3 += '<input type="hidden" id="hidUsuario3' + oId + '" name="hidUsuario3[]" value=""  /><input type="hidden" id="hidIdUsuario3' + oId + '" name="hidIdUsuario3[]" value=""  />';
			strHtml3 += '<input type="hidden" id="hidEstatusOrden3' + oId + '" name="hidEstatusOrden3[]" value=""  /><input type="hidden" id="hidIdEstatusOrden3' + oId + '" name="hidIdEstatusOrden3[]" value=""  /></td>';
		}		
		else
		{		
			strHtml3 += '<td>Estatus de ' + Usuario3;	
			strHtml3 += '<select name="lstEstatusOrden3[]" id="lstEstatusOrden3' + oId + '" class="validate[required]" >';
			strHtml3 += '<option value="">Seleccione</option>';	
			strHtml3 += '</select><input type="hidden" id="hidUsuario3' + oId + '" name="hidUsuario3[]" value="'+ Usuario3 +'"  />';
			strHtml3 += '<input type="hidden" id="hidIdUsuario3' + oId + '" name="hidIdUsuario3[]" value="'+ IdUsuario3 +'"  />';
			strHtml3 += '<input type="hidden" id="hidIdEstatusOrden3' + oId + '" name="hidIdEstatusOrden3[]" value="'+ IdEstatusOrden3 +'"  />';			
			strHtml3 += '<input type="hidden" id="hidEstatusOrden3' + oId + '" name="hidEstatusOrden3[]" value="'+ EstatusOrden3 +'"  /></td>';
		}
	}
/*
	if (IdEstatusOrden4 == 4)
	{
		strHtml3 += '<td>' + Usuario4 + '/' + EstatusOrden4 + '<input type="hidden" id="hidUsuario4' + oId + '" name="hidUsuario4[]" value="'+ Usuario4 +'"  /><input type="hidden" id="hidIdUsuario4' + oId + '" name="hidIdUsuario4[]" value="'+ IdUsuario4 +'"  /></td>';
		strHtml3 += '<input type="hidden" id="hidEstatusOrden4' + oId + '" name="hidEstatusOrden4[]" value="'+ EstatusOrden4 +'"  /><input type="hidden" id="hidIdEstatusOrden4' + oId + '" name="hidIdEstatusOrden4[]" value="'+ IdEstatusOrden4 +'"  /></td>';
	}
	else
	{	
		strHtml3 += '<td>Estatus de ' + Usuario4;	
		strHtml3 += '<select name="lstEstatusOrden4[]" id="lstEstatusOrden4' + oId + '" class="validate[required]" >';
		strHtml3 += '<option value="">Seleccione</option>';	
		strHtml3 += '</select><input type="hidden" id="hidUsuario4' + oId + '" name="hidUsuario4[]" value="'+ Usuario4 +'"  />';
		strHtml3 += '<input type="hidden" id="hidIdUsuario4' + oId + '" name="hidIdUsuario4[]" value="'+ IdUsuario4 +'"  />';
		strHtml3 += '<input type="hidden" id="hidIdEstatusOrden4' + oId + '" name="hidIdEstatusOrden4[]" value="'+ IdEstatusOrden4 +'"  />';			
		strHtml3 += '<input type="hidden" id="hidEstatusOrden4' + oId + '" name="hidEstatusOrden4[]" value="'+ EstatusOrden4 +'"  /></td>';	
	}*/
	var strHtml4 = '<td>' + Estatus + '<input type="hidden" id="hidEstatus' + oId + '" name="hidEstatus[]" value="'+ Estatus +'"  /></td>';
	//var strHtml5 = '<td align="right">' + '<input type="text" id="txtPorcentaje' + oId + '" name="txtPorcentaje[]" value="'+ Porcentaje +'"  style="width:50px; text-align:right;"  class="validate[required]" /><span  class="req">*</span><input type="hidden" id="hidPorcentaje' + oId + '" name="hidPorcentaje[]" value="'+ Porcentaje +'"  /></td>';	
	
	var strHtml5 = '<td>' + '<div class="contentProgress"><div class="barB tipS" id="bar' + oId + '" title="'+ Porcentaje +'%" style="width: '+ Porcentaje +'%" ></div></div>';
		strHtml5 += '<ul class="ruler">';
		strHtml5 += '<li>0</li>';
		strHtml5 += '<li class="textC">50%</li>';
		strHtml5 += '<li class="textR">100%</li>';
		strHtml5 += '</ul><input type="hidden" id="hidPorcentaje' + oId + '" name="hidPorcentaje[]" value="'+ Porcentaje +'"  /></td>';		
	var strHtml6 = '<td><a href="javascript:void(0);" title="Guardar" class="smallButton" style="margin: 5px;" onclick="Guardar_Orden_Trabajo(' + oId + ')"><img src="public/images/icons/light/check.png" alt="" class="icon" /><span></span></a>';
	strHtml6 += '<a href="javascript:void(0);" title="Cancelar" class="smallButton" style="margin: 5px;" onclick="Cancelar_Guardar_Orden_Trabajo(' + oId + ')"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
	strHtml6 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6;
	$("#tbDetalle").append(strHtmlTr);
	//si se agrega el HTML de una sola vez se debe comentar la linea siguiente.
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	
	//$("#lstEstatusOrden1"+oId+",#lstEstatusOrden2"+oId+",#lstEstatusOrden3"+oId+",#lstEstatusOrden4"+oId).uniform();
	
	//alert(oId);
	/*$("#txtPorcentaje" + oId).keydown(function(event){
		//alert(event.keyCode);
		if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
			return true;
		}
		else
		{
			return false;
		}
		

	});	*/	
	
			//alert(oId);
			

			if (IdEstatusOrden1 == 2)
			{
				$("#txtUsuarioAsignado1"+oId).autocomplete({
					source: "application/controllers/UsuarioController.php?action=Listar_Usuario_Autocompletar",
					select:  function(event, ui) {
				
					$("#hidIdUsuario1"+oId).val(ui.item.id_usuario);
					//alert(ui.item.id_usuario);
					//alert(ui.item.value);
					//alert($("#hidUsuarioAsignado").val());

					},
					change: function (event, ui) {
					
						if (ui.item === null)
						{	
							$("#txtUsuarioAsignado1"+oId).val("");
							$("#hidIdUsuario1"+oId).val("");				
						}
						else
						{
							
							$("#hidIdUsuario1"+oId).val(ui.item.id_usuario);

						}				
					}

				});	


			}
			if (((IdEstatusOrden2 == "") & (IdEstatusOrden1 == 4) & (IdUsuario1 != "")) | (IdEstatusOrden2 == 2))
			{
				$("#txtUsuarioAsignado2"+oId).autocomplete({
					source: "application/controllers/UsuarioController.php?action=Listar_Usuario_Autocompletar",
					select:  function(event, ui) {
				
					$("#hidIdUsuario2"+oId).val(ui.item.id_usuario);
					//alert(ui.item.id_usuario);
					//alert(ui.item.value);
					//alert($("#hidUsuarioAsignado").val());

					},
					change: function (event, ui) {
					
						if (ui.item === null)
						{	
							$("#txtUsuarioAsignado2"+oId).val("");
							$("#hidIdUsuario2"+oId).val("");				
						}
						else
						{
							
							$("#hidIdUsuario2"+oId).val(ui.item.id_usuario);

						}				
					}

				});	
			}
	
			//alert(IdEstatusOrden3);
			//alert(IdEstatusOrden2);
			//alert(IdUsuario2);
			
			if (((IdEstatusOrden3 == "") & (IdEstatusOrden2 == 4) & (IdUsuario2 != "") ) | (IdEstatusOrden3 == 2))
			{				
				$("#txtUsuarioAsignado3"+oId).autocomplete({
					source: "application/controllers/UsuarioController.php?action=Listar_Usuario_Autocompletar",
					select:  function(event, ui) {
		
					$("#hidIdUsuario3"+oId).val(ui.item.id_usuario);
					//alert(ui.item.id_usuario);
					//alert(ui.item.value);
					//alert($("#hidUsuarioAsignado").val());

					},
					change: function (event, ui) {
					
						if (ui.item === null)
						{	
							$("#txtUsuarioAsignado3"+oId).val("");
							$("#hidIdUsuario3"+oId).val("");				
						}
						else
						{
							
							$("#hidIdUsuario3"+oId).val(ui.item.id_usuario);

						}				
					}

				});	
			}
	


	if (IdEstatusOrden1 != undefined)
	GenerarEstatusOrdenTrabajo(1,oId,IdEstatusOrden1);
	else
	GenerarEstatusOrdenTrabajo(1,oId);
	
	if (IdEstatusOrden2 != undefined)
	GenerarEstatusOrdenTrabajo(2,oId,IdEstatusOrden2);
	else
	GenerarEstatusOrdenTrabajo(2,oId);

	if (IdEstatusOrden3 != undefined)
	GenerarEstatusOrdenTrabajo(3,oId,IdEstatusOrden3);
	else
	GenerarEstatusOrdenTrabajo(3,oId);

	/*if (IdEstatusOrden4 != undefined)
	GenerarEstatusOrdenTrabajo(4,oId,IdEstatusOrden4);
	else
	GenerarEstatusOrdenTrabajo(4,oId);*/	
	//$("#lstTipoCategoria" + oId + " option[value="+TipoCategoria+"]").attr("selected",true);
	
	return false;
	

	
}



function Guardar_Orden_Trabajo(oId)
{
	var Id = $("#hdnIdCampos_" + oId).val();
	
	//alert(oId);
	//alert($("#hidIdUsuario2" + oId).val());
	//alert($("#hidIdEstatusOrden2" + oId).val());
	
	var idusuario1 = $("#hidIdUsuario1" + oId).val();
	var idusuario2 = $("#hidIdUsuario2" + oId).val();
	var idusuario3 = $("#hidIdUsuario3" + oId).val();
	//var idusuario4 = $("#hidIdUsuario4" + oId).val();	
	
	var estatusorden1,estatusorden2,estatusorden3;
	
	if ($("#hidIdEstatusOrden1" + oId).val() == 4)
	estatusorden1 =  parseFloat($("#hidIdEstatusOrden1" + oId).val());
	else
	estatusorden1 =  parseFloat($("#lstEstatusOrden1" + oId).val());
	
	if ($("#hidIdEstatusOrden2" + oId).val() == 4)
	estatusorden2 =  parseFloat($("#hidIdEstatusOrden2" + oId).val());
	else
	estatusorden2 =  parseFloat($("#lstEstatusOrden2" + oId).val());
	
	if ($("#hidIdEstatusOrden3" + oId).val() == 4)
	estatusorden3 =  parseFloat($("#hidIdEstatusOrden3" + oId).val());
	else	
	estatusorden3 =  parseFloat($("#lstEstatusOrden3" + oId).val());
	
	//var estatusorden4 =  parseFloat($("#lstEstatusOrden4" + oId).val());	
	
	//var porcentaje =  parseFloat($("#txtPorcentaje" + oId).val());
	//var porcentaje_ant =  parseFloat($("#hidPorcentaje" + oId).val()); 
	
	/*if (($("#txtPorcentaje" + oId).val() > 100) || ($("#txtPorcentaje" + oId).val() < 0))
	alert("El Porcentaje de Avance no debe ser mayor que 100 ni menor que 0.");
	else if (porcentaje_ant > porcentaje)
	alert("El Porcentaje de Avance no debe ser menor de la que fue ingresado.");
	else
	{*/
	
		$.post("application/controllers/OrdenController.php?action=Actualizar_Orden_Trabajo",
		{
			//Porcentaje:porcentaje,
			IdUsuario1:idusuario1,
			IdUsuario2:idusuario2,
			IdUsuario3:idusuario3,
			//IdUsuario4:idusuario4,			
			EstatusOrden1:estatusorden1,
			EstatusOrden2:estatusorden2,
			EstatusOrden3:estatusorden3,
			//EstatusOrden4:estatusorden4,			
			Id_Orden_Trabajo:Id		
		
		}, function(data){

			
			if (data=="true")
			{
				Sexy.info("Se ha guardado exit&oacute;samente los Datos",{
				onComplete:function (returnvalue) {

						window.location.href='admin.php?sec='+btoa('listar_ordenes_trabajos');
					}
				});
			}
			else if (data=="false")
			Sexy.error("Error guardar los Datos");
		})
	//}
}

function Cancelar_Guardar_Orden_Trabajo(oId)
{
	var NoOrdenTrabajo = $("#hidNoOrdenTrabajo" + oId).val();
	var NoCotizacion = $("#hidNoCotizacion" + oId).val();
	var DescripcionTrabajo = $("#hidDescripcionTrabajo" + oId).val();	
	var Usuario1 = $("#hidUsuario1" + oId).val();
	var Usuario2 = $("#hidUsuario2" + oId).val();
	var Usuario3 = $("#hidUsuario3" + oId).val();
	//var Usuario4 = $("#hidUsuario4" + oId).val();	
	var IdUsuario1 = $("#hidIdUsuario1" + oId).val();
	var IdUsuario2 = $("#hidIdUsuario2" + oId).val();
	var IdUsuario3 = $("#hidIdUsuario3" + oId).val();
	//var IdUsuario4 = $("#hidIdUsuario4" + oId).val();	
	var IdEstatusOrden1 = $("#hidIdEstatusOrden1" + oId).val();
	var IdEstatusOrden2 = $("#hidIdEstatusOrden2" + oId).val();
	var IdEstatusOrden3 = $("#hidIdEstatusOrden3" + oId).val();	
	//var IdEstatusOrden4 = $("#hidIdEstatusOrden4" + oId).val();		
	var EstatusOrden1 = $("#hidEstatusOrden1" + oId).val();
	var EstatusOrden2 = $("#hidEstatusOrden2" + oId).val();
	var EstatusOrden3 = $("#hidEstatusOrden3" + oId).val();
	//var EstatusOrden4 = $("#hidEstatusOrden4" + oId).val();	
	var Estatus = $("#hidEstatus" + oId).val();
	var Porcentaje = $("#hidPorcentaje" + oId).val();
	
	var Id = $("#hdnIdCampos_" + oId).val();		

	var strHtml0 = '<td align="center">' +  oId + '</td>';		
		strHtml0 += '<td align="center">' + NoOrdenTrabajo + '<input type="hidden" id="hidNoOrdenTrabajo' + oId + '" name="hidNoOrdenTrabajo[]" value="'+ NoOrdenTrabajo +'"  /></td>';
	var strHtml1 = '<td align="center">' + NoCotizacion + '<input type="hidden" id="hidNoCotizacion' + oId + '" name="hidNoCotizacion[]" value="'+ NoCotizacion +'"  /></td>';		
	var strHtml2 = '<td>' + DescripcionTrabajo + '<input type="hidden" id="hidDescripcionTrabajo' + oId + '" name="hidDescripcionTrabajo[]" value="'+ DescripcionTrabajo +'"/></td>';	
	var strHtml3 = '<td>' + Usuario1 + '/' + EstatusOrden1 + '<input type="hidden" id="hidUsuario1' + oId + '" name="hidUsuario1[]" value="'+ Usuario1 +'"  /><input type="hidden" id="hidIdUsuario1' + oId + '" name="hidIdUsuario1[]" value="'+ IdUsuario1 +'"  />';
		strHtml3 += '<input type="hidden" id="hidEstatusOrden1' + oId + '" name="hidEstatusOrden1[]" value="'+ EstatusOrden1 +'"  /><input type="hidden" id="hidIdEstatusOrden1' + oId + '" name="hidIdEstatusOrden1[]" value="'+ IdEstatusOrden1 +'"  /></td>';
		strHtml3 += '<td>' + Usuario2 + '/' + EstatusOrden2 + '<input type="hidden" id="hidUsuario2' + oId + '" name="hidUsuario2[]" value="'+ Usuario2 +'"  /><input type="hidden" id="hidIdUsuario2' + oId + '" name="hidIdUsuario2[]" value="'+ IdUsuario2 +'"  /></td>';
		strHtml3 += '<input type="hidden" id="hidEstatusOrden2' + oId + '" name="hidEstatusOrden2[]" value="'+ EstatusOrden2 +'"  /><input type="hidden" id="hidIdEstatusOrden2' + oId + '" name="hidIdEstatusOrden2[]" value="'+ IdEstatusOrden2 +'"  /></td>';	
		strHtml3 += '<td>' + Usuario3 + '/' + EstatusOrden3 + '<input type="hidden" id="hidUsuario3' + oId + '" name="hidUsuario3[]" value="'+ Usuario3 +'"  /><input type="hidden" id="hidIdUsuario3' + oId + '" name="hidIdUsuario3[]" value="'+ IdUsuario3 +'"  /></td>';
		strHtml3 += '<input type="hidden" id="hidEstatusOrden3' + oId + '" name="hidEstatusOrden3[]" value="'+ EstatusOrden3 +'"  /><input type="hidden" id="hidIdEstatusOrden3' + oId + '" name="hidIdEstatusOrden3[]" value="'+ IdEstatusOrden3 +'"  /></td>';		
		//strHtml3 += '<td>' + Usuario4 + '/' + EstatusOrden4 + '<input type="hidden" id="hidUsuario4' + oId + '" name="hidUsuario4[]" value="'+ Usuario4 +'"  /><input type="hidden" id="hidIdUsuario4' + oId + '" name="hidIdUsuario4[]" value="'+ IdUsuario4 +'"  /></td>';
		//strHtml3 += '<input type="hidden" id="hidEstatusOrden4' + oId + '" name="hidEstatusOrden4[]" value="'+ EstatusOrden4 +'"  /><input type="hidden" id="hidIdEstatusOrden4' + oId + '" name="hidIdEstatusOrden4[]" value="'+ IdEstatusOrden4 +'"  /></td>';
	var strHtml4 = '<td>' + Estatus + '<input type="hidden" id="hidEstatus' + oId + '" name="hidEstatus[]" value="'+ Estatus +'"  /></td>';
	var strHtml5 = '<td>' + '<div class="contentProgress"><div class="barB tipS" id="bar' + oId + '" title="'+ Porcentaje +'%" style="width: '+ Porcentaje +'%" ></div></div>';
		strHtml5 += '<ul class="ruler">';
		strHtml5 += '<li>0</li>';
		strHtml5 += '<li class="textC">50%</li>';
		strHtml5 += '<li class="textR">100%</li>';
		strHtml5 += '</ul><input type="hidden" id="hidPorcentaje' + oId + '" name="hidPorcentaje[]" value="'+ Porcentaje +'"  /></td>';	
	var strHtml6 = '<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Orden_Trabajo(' + oId + ')"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
		strHtml6 += '<a href="javascript:void(0);" title="Imprimir" class="smallButton" style="margin: 5px;" onclick="Imprimir_Orden_Trabajo(\'' +  calcMD5(NoOrdenTrabajo) + '\');"><img src="public/images/icons/color/blue-document-pdf-text.png" alt="" class="icon" /><span></span></a>';
		strHtml6 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6;
	$("#tbDetalle").append(strHtmlTr);
	//si se agrega el HTML de una sola vez se debe comentar la linea siguiente.
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	
	//Cargar_Librerias();
	
	//$.getScript("js/custom-tables.js");
	
	return false;
	
	
}



