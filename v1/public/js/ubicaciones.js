function Listar_Tienda(oId,Tienda)
{
	if (oId != undefined)
	{	
		
		$("#lstTienda" + oId).load("application/controllers/TiendaController.php?action=Listar_Tienda",
		function(data) {

			$("#lstTienda" + oId).find('option').remove().end().append('<option value="" title="Seleccione la Tienda" >Seleccione</option>');
			$("#lstTienda" + oId).append(data);	
		
			$("#lstTienda" + oId + " option[value='" + Tienda + "']").attr("selected",true);
			$("#uniform-lstTienda").children("span").html($("#lstTienda option:selected").text());					
		});
	}
	else
	{
		$("#lstTienda").load("application/controllers/TiendaController.php?action=Listar_Tienda",
		function(data) {

			$("#lstTienda").find('option').remove().end().append('<option value="">Seleccione la Tienda</option>');
			$("#lstTienda").append(data);	
		
			$("#lstTienda option[value='" + Tienda + "']").attr("selected",true);
			$("#uniform-lstTienda").children("span").html($("#lstTienda option:selected").text());					
		});
	}
}

function Agregar_Ubicacion()
{
	
	$.post("application/controllers/UbicacionController.php?action=Agregar_Ubicacion",
	{
		Descripcion:$("#txtDescripcion").val(),
		Tienda:$("#lstTienda").val(),
	}, function(data){

		//alert(data);
		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_ubicaciones');
				}
			});
			
		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	});
}

function Cancelar_Ubicacion()
{

	Sexy.confirm('Deseas Regresar al Listado de Ubicacion?.<br />Pulsa &quot;Ok&quot; para continuar, o pulsa &quot;Cancelar&quot; para salir.', {onComplete: 
		function(returnvalue) { 
			if(returnvalue)
			{
				Sexy.info('Datos ingresados no se guardar&aacute;n', {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('listar_ubicaciones');
					}
				});			
			}

		}
	});
}

function Listar_Ubicaciones()
{
	$('#listado_ubicacion').dataTable( {
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"responsive":true,
		"info": true,
		"ajax": {
			"url": "application/controllers/UbicacionController.php?action=Listar_Ubicaciones",			
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
                title:'LISTA DE PRODUCTOS',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
            	extend: 'pdfHtml5',
                messageTop: 'LISTA DE PRODUCTOS',
                title:'LISTA DE PRODUCTOS EN INVENTARIO',
                 exportOptions: {
                    columns: ':visible'
                }
            },
             {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                },
                 title:'LISTA DE PRODUCTOS'
            },
            'colvis',  'pageLength'
        ],
		"createdRow":function( nRow, aData, iDataIndex ) {
				$(nRow).attr('id', "rowDetalle_"+iDataIndex);
			},
		"columnDefs": [
			  { "className": "text-center", "targets": [ 0,2 ] },
			  { "searchable": false, "targets": [ 0,2 ] },
			  { "orderable": false, "targets": [ 2 ] },
			],
		"columns": [
			{ "data": 0 },
			{ "data": 1 },
			{ "data": 2 },
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

function Editar_Ubicacion (oId)
{
	id_ubicacion = $("#hdnIdCampos_" + oId).val();
	
	window.location.href='admin.php?sec='+btoa('editar_ubicacion')+'&id='+id_ubicacion;
}

function Ver_Ubicacion(Id)
{
	$.post("application/controllers/UbicacionController.php?action=Ver_Ubicacion",
	{
		IdUbicacion:Id
	}
	,function(data){
		//alert(data);
		var item = JSON.parse(data);
		
		$("#txtDescripcion").val(item[0].txtDescripcion);
		Listar_Tienda(undefined,item[0].lstTienda);
	});
}


function Actualizar_Ubicacion(Id)
{
	//alert(Id);
	
	$.post("application/controllers/UbicacionController.php?action=Actualizar_Ubicacion",
	{
		Descripcion:$("#txtDescripcion").val(),
		Tienda:$("#lstTienda").val(),		
		IdUbicacion:Id
	}, function(data){

		
		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_ubicaciones');
				}
			});
			
		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);
	});	
	
}

function Eliminar_Ubicacion(oId)
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);
	$('.btn.btn-success').attr("disabled",true);	
	var Id = $("#hdnIdCampos_" + oId).val();
	
	$.post("application/controllers/UbicacionController.php?action=Eliminar_Ubicacion",
	{
		IdUbicacion:Id	
		
	}, function(data){

		
		if (data=="true")
		{
			$("#rowDetalle_" + oId).remove();			
			Sexy.info("Se ha eliminado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_ubicaciones');
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