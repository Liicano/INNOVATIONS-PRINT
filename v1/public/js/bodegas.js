function Agregar_Bodega()
{
	
	$.post("application/controllers/BodegaController.php?action=Agregar_Bodega",
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
				window.location.href='admin.php?sec='+btoa('listar_bodegas');
				}
			});
			
		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	});
}

function Cancelar_Bodega()
{

	Sexy.confirm('Deseas Regresar al Listado de Bodega?.<br />Pulsa &quot;Ok&quot; para continuar, o pulsa &quot;Cancelar&quot; para salir.', {onComplete: 
		function(returnvalue) { 
			if(returnvalue)
			{
				Sexy.info('Datos ingresados no se guardar&aacute;n', {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec'+btoa('listar_bodegas');
					}
				});			
			}

		}
	});
}

function Listar_Bodegas()
{
	$('#listado_bodega').dataTable( {
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"responsive":true,
		"info": true,
		"ajax": {
			"url": "application/controllers/BodegaController.php?action=Listar_Bodegas",			
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

function Editar_Bodega (oId)
{
	id_bodega = $("#hdnIdCampos_" + oId).val();
	
	window.location.href='admin.php?sec='+btoa("editar_bodega")+'&id='+id_bodega;
}

function Ver_Bodega(Id)
{
	$.post("application/controllers/BodegaController.php?action=Ver_Bodega",
	{
		IdBodega:Id
	}
	,function(data){
		//alert(data);
		var item = JSON.parse(data);
		
		$("#txtDescripcion").val(item[0].txtDescripcion);
		$("#txtTelefono").val(item[0].txtTelefono);
		$("#txtDireccion").val(item[0].txtDireccion);	
	});
}


function Actualizar_Bodega(Id)
{
	//alert(Id);

	$.post("application/controllers/BodegaController.php?action=Actualizar_Bodega",
	{
		Descripcion:$("#txtDescripcion").val(),
		Telefono:$("#txtTelefono").val(),
		Direccion:$("#txtDireccion").val(),
		IdBodega:Id
	}, function(data){

		//alert(data);
		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_bodegas');
				}
			});
			
		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);
	});	
	
}

function Eliminar_Bodega(oId)
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);
	$('.btn.btn-success').attr("disabled",true);	
	var Id = $("#hdnIdCampos_" + oId).val();
	
	console.log("Id - ",Id);
	
	$.post("application/controllers/BodegaController.php?action=Eliminar_Bodega",
	{
		IdBodega:Id	
		
	}, function(data){

		
		if (data=="true")
		{
			$("#rowDetalle_" + oId).remove();			
			Sexy.info("Se ha eliminado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_bodegas');
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