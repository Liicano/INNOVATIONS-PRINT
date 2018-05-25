function Agregar_Tienda()
{
	
	$.post("application/controllers/TiendaController.php?action=Agregar_Tienda",
	{
		Descripcion:$("#txtDescripcion").val(),
		Telefono:$("#txtTelefono").val(),
		Direccion:$("#txtDireccion").val()
	}, function(data){

		//alert(data);
		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_tiendas');
				}
			});
			
		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	});
}

function Cancelar_Tienda()
{

	Sexy.confirm('Deseas Regresar al Listado de Tienda?.<br />Pulsa &quot;Ok&quot; para continuar, o pulsa &quot;Cancelar&quot; para salir.', {onComplete: 
		function(returnvalue) { 
			if(returnvalue)
			{
				Sexy.info('Datos ingresados no se guardar&aacute;n', {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('listar_tiendas');
					}
				});			
			}

		}
	});
}

function Listar_Tiendas()
{
	$('#listado_tienda').dataTable( {
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"responsive":true,
		"info": true,
		"ajax": {
			"url": "application/controllers/TiendaController.php?action=Listar_Tiendas",			
			"type": "POST",
		},
		"pagingType":"full_numbers",
		"lengthMenu": [[5,10,15,25,50,75,100,150,-1],[5,10,15,25,50,75,100,150,"All"]],
		"pageLength": 10,
		//"paging": true,
		"dom": 'T<"clear">lfrtip',
		"createdRow":function( nRow, aData, iDataIndex ) {
				$(nRow).attr('id', "rowDetalle_"+iDataIndex);
			},
		"columnDefs": [
			  { "className": "text-center", "targets": [ 0,4 ] },
			  { "searchable": false, "targets": [ 0,4 ] },
			  { "orderable": false, "targets": [ 4 ] },
			],
		"columns": [
			{ "data": 0 },
			{ "data": 1 },
			{ "data": 2 },
			{ "data": 3 },
			{ "data": 4 },
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

function Editar_Tienda (oId)
{
	id_tienda = $("#hdnIdCampos_" + oId).val();
	
	window.location.href='admin.php?sec='+btoa('editar_tienda')+'&id='+id_tienda;
}

function Ver_Tienda(Id)
{
	$.post("application/controllers/TiendaController.php?action=Ver_Tienda",
	{
		IdTienda:Id
	}
	,function(data){
		//alert(data);
		var item = JSON.parse(data);
		
		$("#txtDescripcion").val(item[0].txtDescripcion);
		$("#txtTelefono").val(item[0].txtTelefono);
		$("#txtDireccion").val(item[0].txtDireccion);	
	});
}


function Actualizar_Tienda(Id)
{
	//alert(Id);
	
	$.post("application/controllers/TiendaController.php?action=Actualizar_Tienda",
	{
		Descripcion:$("#txtDescripcion").val(),
		Telefono:$("#txtTelefono").val(),
		Direccion:$("#txtDireccion").val(),
		IdTienda:Id
	}, function(data){

		
		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_tiendas');
				}
			});
			
		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);
	});	
	
}

function Eliminar_Tienda(oId)
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);
	$('.btn.btn-success').attr("disabled",true);	
	var Id = $("#hdnIdCampos_" + oId).val();
	
	$.post("application/controllers/TiendaController.php?action=Eliminar_Tienda",
	{
		IdTienda:Id	
		
	}, function(data){

		
		if (data=="true")
		{
			$("#rowDetalle_" + oId).remove();			
			Sexy.info("Se ha eliminado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec=listar_tiendas';
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