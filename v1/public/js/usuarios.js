
function Listar_Usuario_Auto()
{

	var strHtml0 = '<label>Nombre del Usuario Asignado para Arte:<span class="req">*</span></label>';
		strHtml0 += '<div class="formRight">';
		strHtml0 += '<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado[]" id="txtUsuarioAsignado1"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado[]" id="hidUsuarioAsignado1"/>';
		strHtml0 += '</div>';
		strHtml0 += '<div class="clear">';
		strHtml0 += '</div>';
		strHtml0 += '<label>Nombre del Usuario Asignado para Impresi&oacute;n:<span class="req">*</span></label>';
		strHtml0 += '<div class="formRight">';
		strHtml0 += '<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado[]" id="txtUsuarioAsignado2"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado[]" id="hidUsuarioAsignado2"/>';
		strHtml0 += '</div>';
		strHtml0 += '<div class="clear">';
		strHtml0 += '</div>';
		strHtml0 += '<label>Nombre del Usuario Asignado para Acabado:<span class="req">*</span></label>';
		strHtml0 += '<div class="formRight">';
		strHtml0 += '<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado[]" id="txtUsuarioAsignado3"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado[]" id="hidUsuarioAsignado3"/>';
		strHtml0 += '</div>';
		strHtml0 += '<div class="clear">';
		strHtml0 += '</div>';	
		strHtml0 += '<label>Nombre del Usuario Asignado para Detalle:<span class="req">*</span></label>';
		strHtml0 += '<div class="formRight">';
		strHtml0 += '<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado[]" id="txtUsuarioAsignado4"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado[]" id="hidUsuarioAsignado4"/>';
		strHtml0 += '</div>';
		strHtml0 += '<div class="clear">';
		strHtml0 += '</div>';				

	
	$("#UsuarioAsignado").html(strHtml0);
	

	$("#txtUsuarioAsignado1").autocomplete({
		source: "php/funciones.php?action=Listar_Usuario_Autocompletar",
		select:  function(event, ui) {
		
		$("#hidUsuarioAsignado1").val(ui.item.id_usuario);
		//alert(ui.item.value);
		//alert(ui.item.value);
		//alert($("#hidUsuarioAsignado").val());

		},
		change: function (event, ui) {
		
			if (ui.item === null)
			{	
				$("#txtUsuarioAsignado1").val("");
				$("#hidUsuarioAsignado1").val("");				
			}
			else
			{
				
				$("#hidUsuarioAsignado1").val(ui.item.id_usuario);

			}				
		}	

	});

	$("#txtUsuarioAsignado2").autocomplete({
		source: "php/funciones.php?action=Listar_Usuario_Autocompletar",
		select:  function(event, ui) {
		
		$("#hidUsuarioAsignado2").val(ui.item.id_usuario);
		//alert(ui.item.value);
		//alert(ui.item.value);
		//alert($("#hidUsuarioAsignado").val());

		},
		change: function (event, ui) {
		
			if (ui.item === null)
			{	
				$("#txtUsuarioAsignado2").val("");
				$("#hidUsuarioAsignado2").val("");				
			}
			else
			{
				
				$("#hidUsuarioAsignado2").val(ui.item.id_usuario);

			}				
		}

	});	
		
	$("#txtUsuarioAsignado3").autocomplete({
		source: "php/funciones.php?action=Listar_Usuario_Autocompletar",
		select:  function(event, ui) {
		
		$("#hidUsuarioAsignado3").val(ui.item.id_usuario);
		//alert(ui.item.value);
		//alert(ui.item.value);
		//alert($("#hidUsuarioAsignado").val());

		},
		change: function (event, ui) {
		
			if (ui.item === null)
			{	
				$("#txtUsuarioAsignado3").val("");
				$("#hidUsuarioAsignado3").val("");				
			}
			else
			{
				
				$("#hidUsuarioAsignado3").val(ui.item.id_usuario);

			}				
		}

	});	
		
	$("#txtUsuarioAsignado4").autocomplete({
		source: "php/funciones.php?action=Listar_Usuario_Autocompletar",
		select:  function(event, ui) {
		
		$("#hidUsuarioAsignado4").val(ui.item.id_usuario);
		//alert(ui.item.value);
		//alert(ui.item.value);
		//alert($("#hidUsuarioAsignado").val());

		},
		change: function (event, ui) {
		
			if (ui.item === null)
			{	
				$("#txtUsuarioAsignado4").val("");
				$("#hidUsuarioAsignado4").val("");				
			}
			else
			{
				
				$("#hidUsuarioAsignado4").val(ui.item.id_usuario);

			}				
		}

	});		

}


function Listar_Tipo_Usuario(oId, TipoUsuario)
{

		if (oId != undefined)
		{	
			
			$("#lstTipoUsuario" + oId).load("application/controllers/UsuarioController.php?action=Listar_Tipo_Usuario",
			function(data) {

				$("#lstTipoUsuario" + oId).find('option').remove().end().append('<option value="" title="Seleccione el Tipo de Usuario" >Seleccione</option>');
				$("#lstTipoUsuario" + oId).append(data);	
			
				$("#lstTipoUsuario" + oId + " option[value=" + TipoUsuario + "]").attr("selected",true);
				$("#uniform-lstTipoUsuario" + oId).children("span").html($("#lstTipoUsuario" + oId + " option:selected").text());
			});
		}
		else
		{
			$("#lstTipoUsuario").load("application/controllers/UsuarioController.php?action=Listar_Tipo_Usuario",
			function(data) {

				$("#lstTipoUsuario").find('option').remove().end().append('<option value="">Seleccione el Tipo de Usuario</option>');
				$("#lstTipoUsuario").append(data);	
			
				$("#lstTipoUsuario option[value=" + TipoUsuario + "]").attr("selected",true);
				$("#uniform-lstTipoUsuario").children("span").html($("#lstTipoUsuario option:selected").text());
			});
		}
}

function Listar_Estatus_Usuario(oId, EstatusUsuario)
{

		if (oId != undefined)
		{	
			
			$("#lstEstatusUsuario" + oId).load("application/controllers/UsuarioController.php?action=Listar_Estatus_Usuario",
			function(data) {

				$("#lstEstatusUsuario" + oId).find('option').remove().end().append('<option value="" title="Seleccione el Estatus del Usuario" >Seleccione</option>');
				$("#lstEstatusUsuario" + oId).append(data);	
			
				$("#lstEstatusUsuario" + oId + " option[value=" + EstatusUsuario + "]").attr("selected",true);
				$("#uniform-lstEstatusUsuario" + oId).children("span").html($("#lstEstatusUsuario" + oId + " option:selected").text());
			});
		}
		else
		{
			$("#lstEstatusUsuario").load("application/controllers/UsuarioController.php?action=Listar_Estatus_Usuario",
			function(data) {

				$("#lstEstatusUsuario").find('option').remove().end().append('<option value="">Seleccione el Estatus del Usuario</option>');
				$("#lstEstatusUsuario").append(data);	
			
				$("#lstEstatusUsuario option[value=" + EstatusUsuario + "]").attr("selected",true);
				$("#uniform-lstEstatusUsuario").children("span").html($("#lstEstatusUsuario option:selected").text());
			});
		}
		
}

function Agregar_Usuario()
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);
	
	//alert($("#txtNombreUsuario").val());
	$.post("application/controllers/UsuarioController.php?action=Agregar_Usuario",
	{
		NombreUsuario:$("#txtNombreUsuario").val(),
		ApellidoUsuario:$("#txtApellidoUsuario").val(),
		Usuario:$("#txtUsuario").val(),
		Clave:$("#txtClave").val(),
		DescripcionUsuario:$("#txtDescripcionUsuario").val(),
		TipoUsuario:$("#lstTipoUsuario").val(),			
		EstatusUsuario:$("#lstEstatusUsuario").val()	
	}, function(data){

		
		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos",{
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_usuarios');
				}
			});

		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	})
}

function Listar_Usuarios()
{
	/*$("#Lista_Usuarios").load("application/controllers/UsuarioController.php?action=Listar_Usuarios",function(){
	
		oTable = $('.dTable').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": true,
			"iDisplayLength": 10,
			"sDom": '<""l>t<"F"fp>'
		});
	
	});*/
	
	$('#listado_usuario').dataTable( {
		"processing": true,
		"serverSide": true,
		"ordering": true,
		"info": true,
		"ajax": {
			"url": "application/controllers/UsuarioController.php?action=Listar_Usuarios",
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
			  { "className": "hide_overflow", "targets": [ 5 ] },
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

function Editar_Usuario(oId)
{

	$.getScript("public/js/form_validation.js");
	
	var NombreUsuario = $("#hidNombreUsuario" + oId).val();
	var ApellidoUsuario = $("#hidApellidoUsuario" + oId).val();
	var DescripcionUsuario = $("#hidDescripcionUsuario" + oId).val();	
	var Usuario = $("#hidUsuario" + oId).val();
	var Clave = $("#txtClave" + oId).val();
	var TipoUsuario = $("#hidTipoUsuario" + oId).val();
	var DescTipoUsuario = $("#hidDescTipoUsuario" + oId).val();	
	var EstatusUsuario = $("#hidEstatusUsuario" + oId).val();
	var DescEstatusUsuario = $("#hidDescEstatusUsuario" + oId).val();	

	var Id = $("#hdnIdCampos_" + oId).val();
	

		
	//alert(RUC.length);
	var strHtml0 = "<td  align=\"center\">" +  oId + '</td>';		
		strHtml0 += "<td>" + '<input type="text" id="txtNombreUsuario' + oId + '" name="txtNombreUsuario[]" value="'+ NombreUsuario +'"  class="validate[required,custom[onlyLetterSp]]"  style="width:95%;"/><input type="hidden" id="hidNombreUsuario' + oId + '" name="hidNombreUsuario[]" value="'+ NombreUsuario +'"  /></td>';
	var strHtml1 = "<td>" + '<input type="text" id="txtApellidoUsuario' + oId + '" name="txtApellidoUsuario[]" value="'+ ApellidoUsuario +'"  class="validate[required,custom[onlyLetterSp]]"  style="width:95%;"/><input type="hidden" id="hidApellidoUsuario' + oId + '" name="hidApellidoUsuario[]" value="'+ ApellidoUsuario +'"  /></td>';		
	var strHtml2 = "<td>" + '<textarea rows="4" cols="" id="txtDescripcionUsuario' + oId + '" name="txtDescripcionUsuario[]" value="'+ DescripcionUsuario +'"  class="autoGrow validate[required]" style="width:95%;">'+ DescripcionUsuario +'</textarea><input type="hidden" id="hidDescripcionUsuario' + oId + '" name="hidDescripcionUsuario[]" value="'+ DescripcionUsuario +'"/></td>';	
	var strHtml3 = "<td>" + '<input type="text" id="txtUsuario' + oId + '" name="txtUsuario[]" value="'+ Usuario +'"  class="validate[required,custom[onlyLetterSp]]"  style="width:95%;"/><input type="hidden" id="hidUsuario' + oId + '" name="hidUsuario[]" value="'+ Usuario +'"  /></td>';		
	var strHtml4 = "<td>" + '<input type="password" id="txtClave' + oId + '" name="txtClave[]" value="'+ Clave +'"  class="validate[required]"  style="width:95%;"  onchange="this.value=calcMD5(this.value)" /><input type="hidden" id="hidClave' + oId + '" name="hidClave[]" value="'+ Clave +'"  /></td>';	
	var strHtml5 = "<td>" + '<div class="floatL">';
		strHtml5 += '<select name="lstTipoCategoria[]" id="lstTipoUsuario' + oId + '" class="validate[required]">';
		strHtml5 += '<option value="" title="Seleccione el Tipo de Usuario">Seleccione</option>';
		strHtml5 += '</select>';
		strHtml5 += '</div><input type="hidden" id="hidTipoUsuario' + oId + '" name="hidTipoUsuario[]" value="'+ TipoUsuario +'"  /><input type="hidden" id="hidDescTipoUsuario' + oId + '" name="hidDescTipoUsuario[]" value="'+ DescTipoUsuario +'"  /></td>';	
	var strHtml6 = "<td>" + '<div class="floatL">';
		strHtml6 += '<select name="lstEstatusUsuario[]" id="lstEstatusUsuario' + oId + '" class="validate[required]">';
		strHtml6 += '<option value="" title="Seleccione el Estatus del Usuario">Seleccione</option>';
		strHtml6 += '</select>';
		strHtml6 += '</div><input type="hidden" id="hidEstatusUsuario' + oId + '" name="hidEstatusUsuario[]" value="'+ EstatusUsuario +'"  /><input type="hidden" id="hidDescEstatusUsuario' + oId + '" name="hidDescEstatusUsuario[]" value="'+ DescEstatusUsuario +'"  /></td>';	
	var strHtml7 = '<td><a href="javascript:void(0);" title="Guardar" class="smallButton" style="margin: 5px;" onclick="Guardar_Usuario(' + oId + ')"><img src="public/images/icons/light/check.png" alt="" class="icon" /><span></span></a>';
	strHtml7 += '<a href="javascript:void(0);" title="Cancelar" class="smallButton" style="margin: 5px;" onclick="Cancelar_Guardar_Usuario(' + oId + ')"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
	strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7;
	$("#tbDetalle").append(strHtmlTr);
	//si se agrega el HTML de una sola vez se debe comentar la linea siguiente.
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	
	//alert(oId);
	Listar_Tipo_Usuario(oId, TipoUsuario);
	Listar_Estatus_Usuario(oId, EstatusUsuario);

	//$("#lstTipoCategoria" + oId + " option[value="+TipoCategoria+"]").attr("selected",true);
	return false;
	
}

function Guardar_Usuario(oId)
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);

	var Id = $("#hdnIdCampos_" + oId).val();

	$.post("application/controllers/UsuarioController.php?action=Actualizar_Usuario",
	{
		NombreUsuario:$("#txtNombreUsuario" + oId).val(),
		ApellidoUsuario:$("#txtApellidoUsuario" + oId).val(),
		Usuario:$("#txtUsuario" + oId).val(),
		Clave:$("#txtClave" + oId).val(),
		DescripcionUsuario:$("#txtDescripcionUsuario" + oId).val(),
		TipoUsuario:$("#lstTipoUsuario" + oId).val(),			
		EstatusUsuario:$("#lstEstatusUsuario" + oId).val(),	
		IdUsuario:Id		
		
	}, function(data){

		
		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos",{
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_usuarios');
				}
			});
		}
		else if (data=="false")
		Sexy.error("Error guardar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	})
}

function Cancelar_Guardar_Usuario(oId)
{
	var NombreUsuario = $("#hidNombreUsuario" + oId).val();
	var ApellidoUsuario = $("#hidApellidoUsuario" + oId).val();
	var DescripcionUsuario = $("#hidDescripcionUsuario" + oId).val();	
	var Usuario = $("#hidUsuario" + oId).val();
	var Clave = $("#txtClave" + oId).val();
	var TipoUsuario = $("#hidTipoUsuario" + oId).val();
	var DescTipoUsuario = $("#hidDescTipoUsuario" + oId).val();
	var EstatusUsuario = $("#hidEstatusUsuario" + oId).val();
	var DescEstatusUsuario = $("#hidDescEstatusUsuario" + oId).val();
	
	var Id = $("#hdnIdCampos_" + oId).val();		

	var strHtml0 = "<td  align=\"center\">" +  oId + '</td>';		
		strHtml0 += "<td>" + NombreUsuario + '<input type="hidden" id="hidNombreUsuario' + oId + '" name="hidNombreUsuario[]" value="'+ NombreUsuario +'"  /></td>';	
	var strHtml1 = "<td>" + ApellidoUsuario + '<input type="hidden" id="hidApellidoUsuario' + oId + '" name="hidApellidoUsuario[]" value="'+ ApellidoUsuario +'"/></td>';	
	var strHtml2 = "<td>" + DescripcionUsuario + '<input type="hidden" id="hidDescripcionUsuario' + oId + '" name="hidDescripcionUsuario[]" value="'+ DescripcionUsuario +'"/></td>';	
	var strHtml3 = "<td>" + Usuario + '<input type="hidden" id="hidUsuario' + oId + '" name="hidUsuario[]" value="'+ Usuario +'"  /></td>';	
	var strHtml4 = '<td><input type="password" id="txtClave' + oId + '" name="txtClave[]" value="'+ Clave +'" readonly="readonly" /></td>';	
	var strHtml5 = "<td>" + DescTipoUsuario + '<input type="hidden" id="hidTipoUsuario' + oId + '" name="hidTipoUsuario[]" value="'+ TipoUsuario +'"  /><input type="hidden" id="hidDescTipoUsuario' + oId + '" name="hidDescTipoUsuario[]" value="'+ DescTipoUsuario +'"  /></td>';	
	var strHtml6 = "<td>" + DescEstatusUsuario + '<input type="hidden" id="hidEstatusUsuario' + oId + '" name="hidEstatusUsuario[]" value="'+ EstatusUsuario +'"  /><input type="hidden" id="hidDescEstatusUsuario' + oId + '" name="hidDescEstatusUsuario[]" value="'+ DescEstatusUsuario +'"  /></td>';		
	var strHtml7 = '<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Usuario(' + oId + ')"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
	strHtml7 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7;
	$("#tbDetalle").append(strHtmlTr);
	//si se agrega el HTML de una sola vez se debe comentar la linea siguiente.
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	return false;
}



















