function GenerarProveedores(oId,Proveedor)
{
	
	//alert(oId);
	if (oId != undefined)
	{	
		
		$("#lstProveedor" + oId).load("application/controllers/ProveedorController.php?action=Listar_Proveedor",
		function(data) {

			$("#lstProveedor" + oId).find('option').remove().end().append('<option value="">Seleccione el Proveedor</option>');
			$("#lstProveedor" + oId).append(data);	
			
			$("#lstProveedor" + oId + " option[value='" + Proveedor + "']").attr("selected",true);
			
			$("#uniform-lstProveedor" + oId).children("span").html($("#lstProveedor" + oId + " option:selected").text());					
		});
	}
	else
	{	
		$("#lstProveedor").load("application/controllers/ProveedorController.php?action=Listar_Proveedor",
		function(data) {

			//alert(data);
			$("#lstProveedor").find('option').remove().end().append('<option value="">Seleccione el Proveedor</option>');
			$("#lstProveedor").append(data);		

			$("#lstProveedor option[value='" + Proveedor + "']").attr("selected",true);
			
			$("#uniform-lstProveedor").children("span").html($("#lstProveedor option:selected").text());				
		});
	}
}


function Agregar_Proveedor()
{
	$.post("application/controllers/ProveedorController.php?action=Agregar_Proveedor",
	{
		NombreProveedor:$("#txtNombreProveedor").val(),
		RUC1:$("#txtRUC1").val(),
		RUC2:$("#txtRUC2").val(),
		RUC3:$("#txtRUC3").val(),
		DV:$("#txtDV").val(),
		Email:$("#txtEmail").val(),		
		Telefono:$("#txtTelefono").val(),
		Celular:$("#txtCelular").val(),
		Fax:$("#txtFax").val(),		
		Direccion:$("#txtDireccion").val(),
		NombreVendedor:$("#txtNombreVendedor").val(),
		CelularVendedor:$("#txtCelularVendedor").val(),
		EmailVendedor:$("#txtEmailVendedor").val()		
		
	}, function(data){

		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_proveedores');
				}
			});

		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
	})
}

function Cancelar_Agregar_Proveedor()
{

	Sexy.confirm('Deseas Regresar al Listado de Proveedores?.<br />Pulsa &quot;Ok&quot; para continuar, o pulsa &quot;Cancelar&quot; para salir.', {onComplete: 
		function(returnvalue) { 
			if(returnvalue)
			{
				Sexy.info('Datos ingresados no se guardar&aacute;n', {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('listar_proveedores');
					}
				});			
			}

		}
	});
}

function Listar_Proveedores()
{
	/*$("#Lista_Proveedores").load("application/controllers/ProveedorController.php?action=Listar_Proveedores",function(){
	
		oTable = $('.dTable').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": true,
			"iDisplayLength": 10,
			"sDom": '<""l>t<"F"fp>'
		});
	
	});*/
	
	$('#listado_proveedor').dataTable( {
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"info": true,
		"ajax": {
			"url": "application/controllers/ProveedorController.php?action=Listar_Proveedores",	
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
			  { "className": "text-center", "targets": [ 0,12 ] },
			  { "className": "hide_overflow", "targets": [ 7,11 ] },
			  { "searchable": false, "targets": [ 0,12 ] },
			  { "orderable": false, "targets": [ 12 ] },
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
			{ "data": 10 },
			{ "data": 11 },
			{ "data": 12 },			

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

function Editar_Proveedor(oId)
{

	$.getScript("public/js/form_validation.js");	

	
	var NombreProveedor = $("#hidNombreProveedor" + oId).val();
	var strRUC = $("#hidRUC" + oId).val();
	var RUC=strRUC.split("-");
	var DV = $("#hidDV" + oId).val();	
	var Telefono = $("#hidTelefono" + oId).val();
	var Celular = $("#hidCelular" + oId).val();	
	var Fax = $("#hidFax" + oId).val();		
	var Email = $("#hidEmail" + oId).val();	
	var Direccion = $("#hidDireccion" + oId).val();
	var NombreVendedor = $("#hidNombreVendedor" + oId).val();		
	var CelularVendedor = $("#hidCelularVendedor" + oId).val();	
	var EmailVendedor = $("#hidEmailVendedor" + oId).val();	
	var Id = $("#hdnIdCampos_" + oId).val();	

		
	//alert(RUC.length);
	var strHtml0 = "<td  align=\"center\">" +  (parseInt(oId)+1) + '</td>';		
		strHtml0 += "<td>" + '<input type="text" id="txtNombreProveedor' + oId + '" name="txtNombreProveedor[]" value="'+ NombreProveedor +'"  class="validate[required,custom[onlyLetterSp]]"  style="width:95%;"/><input type="hidden" id="hidNombreProveedor' + oId + '" name="hidNombreProveedor[]" value="'+ NombreProveedor +'"  /></td>';	
	var strHtml1 = "<td>" + '<input type="text" id="txtRUC1' + oId + '" name="txtRUC1[]" value="'+ RUC[0] +'"  class="validate[required,custom[onlyNumberSp]]" style="width:28%;"/>';
		strHtml1 += '<input type="text" id="txtRUC2' + oId + '" name="txtRUC2[]" value="'+ RUC[1] +'"  class="validate[required,custom[onlyNumberSp]]" style="width:28%;"/>';
		strHtml1 += '<input type="text" id="txtRUC3' + oId + '" name="txtRUC3[]" value="'+ RUC[2] +'"  class="validate[required,custom[onlyNumberSp]]" style="width:28%;"/><input type="hidden" id="hidRUC' + oId + '" name="hidRUC[]" value="'+ strRUC +'"/></td>';	
	var strHtml2 = "<td>" + '<input type="text" id="txtDV' + oId + '" name="txtDV[]" value="'+ DV +'"  class="validate[required,custom[onlyNumberSp]]" style="width:95%;"/><input type="hidden" id="hidDV' + oId + '" name="hidDV[]" value="'+ DV +'"/></td>';	
	var strHtml3 = "<td>" + '<input type="text" id="txtTelefono' + oId + '" name="txtTelefono[]" value="'+ Telefono +'"  class="maskTelefono validate[required]"  style="width:95%;"/><input type="hidden" id="hidTelefono' + oId + '" name="hidTelefono[]" value="'+ Telefono +'"  /></td>';	
	var strHtml4 = "<td>" + '<input type="text" id="txtCelular' + oId + '" name="txtCelular[]" value="'+ Celular +'"  class="maskCelular validate[required]"  style="width:95%;"/><input type="hidden" id="hidCelular' + oId + '" name="hidCelular[]" value="'+ Celular +'"  /></td>';	
	var strHtml5 = "<td>" + '<input type="text" id="txtFax' + oId + '" name="txtFax[]" value="'+ Fax +'"  class="maskTelefono validate[required]"  style="width:95%;"/><input type="hidden" id="hidFax' + oId + '" name="hidFax[]" value="'+ Fax +'"  /></td>';	
	var strHtml6 = "<td>" + '<input type="text" id="txtEmail' + oId + '" name="txtEmail[]" value="'+ Email +'"  class="validate[required,custom[email]]"  style="width:95%;"/><input type="hidden" id="hidEmail' + oId + '" name="hidEmail[]" value="'+ Email +'"  /></td>';	
	var strHtml7 = "<td>" + '<input type="text" id="txtDireccion' + oId + '" name="txtDireccion[]" value="'+ Direccion +'"  class="validate[required]]"  style="width:95%;"/><input type="hidden" id="hidDireccion' + oId + '" name="hidDireccion[]" value="'+ Direccion +'"  /></td>';
	var strHtml8 = "<td>" + '<input type="text" id="txtNombreVendedor' + oId + '" name="hidNombreVendedor[]" value="'+ NombreVendedor +'"  class="validate[required,custom[onlyLetterSp]]"  style="width:95%;"/><input type="hidden" id="hidNombreVendedor' + oId + '" name="hidNombreVendedor[]" value="'+ NombreVendedor +'"  /></td>';	
	var strHtml9 = "<td>" + '<input type="text" id="txtCelularVendedor' + oId + '" name="hidCelularVendedor[]" value="'+ CelularVendedor +'"  class="maskCelular validate[required]"  style="width:95%;"/><input type="hidden" id="hidCelularVendedor' + oId + '" name="hidCelularVendedor[]" value="'+ CelularVendedor +'"  /></td>';	
	var strHtml10 = "<td>" + '<input type="text" id="txtEmailVendedor' + oId + '" name="hidEmailVendedor[]" value="'+ EmailVendedor +'"  class="validate[required,custom[email]]"  style="width:95%;"/><input type="hidden" id="hidEmailVendedor' + oId + '" name="hidEmailVendedor[]" value="'+ EmailVendedor +'"  /></td>';
	
	var strHtml11 = '<td><a href="javascript:void(0);" title="Guardar" class="smallButton" style="margin: 5px;" onclick="Guardar_Proveedor(' + oId + ')"><img src="public/images/icons/light/check.png" alt="" class="icon" /><span></span></a>';
	strHtml11 += '<a href="javascript:void(0);" title="Cancelar" class="smallButton" style="margin: 5px;" onclick="Cancelar_Guardar_Proveedor(' + oId + ')"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
	strHtml11 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9 + strHtml10 + strHtml11;
	$("#tbDetalle").append(strHtmlTr);
	//si se agrega el HTML de una sola vez se debe comentar la linea siguiente.
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	return false;
	
}

function Guardar_Proveedor(oId)
{
	var Id = $("#hdnIdCampos_" + oId).val();

	$.post("application/controllers/ProveedorController.php?action=Actualizar_Proveedor",
	{
		NombreProveedor:$("#txtNombreProveedor" + oId).val(),
		RUC1:$("#txtRUC1" + oId).val(),
		RUC2:$("#txtRUC2" + oId).val(),
		RUC3:$("#txtRUC3" + oId).val(),
		DV:$("#txtDV" + oId).val(),		
		Email:$("#txtEmail" + oId).val(),		
		Telefono:$("#txtTelefono" + oId).val(),
		Celular:$("#txtCelular" + oId).val(),
		Fax:$("#txtFax" + oId).val(),		
		Direccion:$("#txtDireccion" + oId).val(),
		NombreVendedor:$("#txtNombreVendedor" + oId).val(),
		CelularVendedor:$("#txtCelularVendedor" + oId).val(),
		EmailVendedor:$("#txtEmailVendedor" + oId).val(),
		IdProveedor:Id		
		
	}, function(data){

		
		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_proveedores');
				}
			});
		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
	})
}

function Cancelar_Guardar_Proveedor(oId)
{
	var NombreProveedor = $("#hidNombreProveedor" + oId).val();
	var RUC = $("#hidRUC" + oId).val();
	var DV = $("#hidDV" + oId).val();	
	var Telefono = $("#hidTelefono" + oId).val();
	var Celular = $("#hidCelular" + oId).val();	
	var Fax = $("#hidFax" + oId).val();		
	var Email = $("#hidEmail" + oId).val();	
	var Direccion = $("#hidDireccion" + oId).val();
	var NombreVendedor = $("#hidNombreVendedor" + oId).val();		
	var CelularVendedor = $("#hidCelularVendedor" + oId).val();	
	var EmailVendedor = $("#hidEmailVendedor" + oId).val();	
	var Id = $("#hdnIdCampos_" + oId).val();	

	var strHtml0 = "<td  align=\"center\">" +  oId + '</td>';		
		strHtml0 += "<td>" + NombreProveedor + '<input type="hidden" id="hidNombreProveedor' + oId + '" name="hidNombreProveedor[]" value="'+ NombreProveedor +'"  /></td>';	
	var strHtml1 = "<td>" + RUC + '<input type="hidden" id="hidRUC' + oId + '" name="hidRUC[]" value="'+ RUC +'"/></td>';
	var strHtml2 = "<td>" + DV + '<input type="hidden" id="hidDV' + oId + '" name="hidDV[]" value="'+ DV +'"/></td>';	
	var strHtml3 = "<td>" + Telefono + '<input type="hidden" id="hidTelefono' + oId + '" name="hidTelefono[]" value="'+ Telefono +'"  /></td>';	
	var strHtml4 = "<td>" + Celular + '<input type="hidden" id="hidCelular' + oId + '" name="hidCelular[]" value="'+ Celular +'"  /></td>';	
	var strHtml5 = "<td>" + Fax + '<input type="hidden" id="hidFax' + oId + '" name="hidFax[]" value="'+ Fax +'"  /></td>';	
	var strHtml6 = "<td>" + Email + '<input type="hidden" id="hidEmail' + oId + '" name="hidEmail[]" value="'+ Email +'"  /></td>';	
	var strHtml7 = "<td>" + Direccion + '<input type="hidden" id="hidDireccion' + oId + '" name="hidDireccion[]" value="'+ Direccion +'"  /></td>';
	var strHtml8 = "<td>" + NombreVendedor + '<input type="hidden" id="hidNombreVendedor' + oId + '" name="hidNombreVendedor[]" value="'+ NombreVendedor +'"  /></td>';	
	var strHtml9 = "<td>" + CelularVendedor + '<input type="hidden" id="hidCelularVendedor' + oId + '" name="hidCelularVendedor[]" value="'+ CelularVendedor +'"  /></td>';	
	var strHtml10 = "<td>" + EmailVendedor + '<input type="hidden" id="hidEmailVendedor' + oId + '" name="hidEmailVendedor[]" value="'+ EmailVendedor +'"  /></td>';
	
	var strHtml11 = '<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Proveedor(' + oId + ')"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
	strHtml11 += '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Proveedor?\')){Eliminar_Proveedor(' + oId + '})"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
	strHtml11 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9 + strHtml10 + strHtml11;
	$("#tbDetalle").append(strHtmlTr);
	//si se agrega el HTML de una sola vez se debe comentar la linea siguiente.
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	return false;
}

function Eliminar_Proveedor(oId)
{
	var Id = $("#hdnIdCampos_" + oId).val();
	
	$.post("application/controllers/ProveedorController.php?action=Eliminar_Proveedor",
	{
		IdProveedor:Id	
		
	}, function(data){

		
		if (data=="true")
		{
			$("#rowDetalle_" + oId).remove();			
			Sexy.info("Se ha eliminado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_proveedores');
				}
			});
		}
		else if (data=="false")
		Sexy.error("Error eliminar los Datos");
	})
	
	return false;
}
