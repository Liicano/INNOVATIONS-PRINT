
function Listar_Tipo_Cliente(TipoCliente)
{	
	
		$("#lstTipoCliente").load("application/controllers/ClienteController.php?action=Listar_Tipo_Cliente",
		function(data) {

			$("#lstTipoCliente").find('option').remove().end().append('<option value="">Seleccione el Tipo de Cliente</option>');
			$("#lstTipoCliente").append(data);	
			
			$("#lstTipoCliente option[value=" + TipoCliente + "]").attr("selected",true);
		});
		
}

function Agregar_Cliente()
{
	

	// SUBIR LOGOTIPO DATA NECESARIA
	var archivos = document.getElementById("file");
	var archivo = archivos.files; 
	var DatosForm = new FormData();
	for(i=0; i<archivo.length; i++){
		DatosForm.append('archivo'+i,archivo[i]);
	}
	//NOMBRE DE LA IMAGEN
	if (archivos.files.length > 0) {
		var Logotipo = archivos.files[0].name;
	}else{
		var Logotipo = 'NULL';	
	}

	var arrNombreContacto = new Array();
	arrNombreContacto = $("[name='hidNombreContacto[]']");
	var ArrNombreContacto = [];
	for (var i = 0; i < arrNombreContacto.length; ++i) {
		ArrNombreContacto[i] = arrNombreContacto[i].value;
	}

	StrNombreContacto = ArrNombreContacto.toString();
	
	var arrTelefonoContacto = new Array();
	arrTelefonoContacto = $("[name='hidTelefonoContacto[]']");
	var ArrTelefonoContacto = [];
	for (var i = 0; i < arrTelefonoContacto.length; ++i) {
		ArrTelefonoContacto[i] = arrTelefonoContacto[i].value;
	}

	StrTelefonoContacto = ArrTelefonoContacto.toString();

	var arrCelularContacto = new Array();
	arrCelularContacto = $("[name='hidCelularContacto[]']");
	var ArrCelularContacto = [];
	for (var i = 0; i < arrCelularContacto.length; ++i) {
		ArrCelularContacto[i] = arrCelularContacto[i].value;
	}

	StrCelularContacto = ArrCelularContacto.toString();
	
	var arrEmailContacto = new Array();
	arrEmailContacto = $("[name='hidEmailContacto[]']");
	var ArrEmailContacto = [];
	for (var i = 0; i < arrEmailContacto.length; ++i) {
		ArrEmailContacto[i] = arrEmailContacto[i].value;
	}

	StrEmailContacto = ArrEmailContacto.toString();
	
	$.post("application/controllers/ClienteController.php?action=Agregar_Cliente",

	{
		NombreCliente:$("#txtNombreCliente").val(),
		ApellidoCliente:$("#txtApellidoCliente").val(),
		NombreEmpresa:$("#txtNombreEmpresa").val(),
		RUC1:$("#txtRUC1").val(),
		RUC2:$("#txtRUC2").val(),
		RUC3:$("#txtRUC3").val(),
		DV:$("#txtDV").val(),		
		TipoCliente:$("#lstTipoCliente").val(),
		Email:$("#txtEmail").val(),		
		Telefono:$("#txtTelefono").val(),
		Celular:$("#txtCelular").val(),
		Direccion:$("#txtDireccion").val(),		
		NombreContacto:StrNombreContacto,
		TelefonoContacto:StrTelefonoContacto,
		CelularContacto:StrCelularContacto,
		EmailContacto:StrEmailContacto,	
		Credito:$("input:checked").val(),
		Logo: Logotipo
		
		
	}, function(data){

		$.ajax({
		url:'application/controllers/ClienteController.php?action=subir_logotipo', //Url a donde la enviaremos
		type:'POST', //Metodo que usaremos
		contentType:false, //Debe estar en false para que pase el objeto sin procesar
		data:DatosForm, //Le pasamos el objeto que creamos con los archivos
		processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
		cache:false //Para que el formulario no guarde cache
	}).done(function(msg){

	$( "#dialog-message" ).dialog( "open" );		
		if (data=="true" && msg=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('listar_clientes');
				}
			});
			
		}
		else if (data=="false" && msg=="false")
		Sexy.error("Error guardar los Datos");

	});
	})
}

function Cancelar_Agregar_Cliente()
{
	
	Sexy.confirm('Deseas Regresar al Listado de Clientes?.<br />Pulsa &quot;Ok&quot; para continuar, o pulsa &quot;Cancelar&quot; para salir.', {onComplete: 
		function(returnvalue) { 
			if(returnvalue)
			{
				Sexy.info('Datos ingresados no se guardar&aacute;n', {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('listar_clientes');
					}
				});			
			}

		}
	});
}

function Listar_Clientes()
{
	/*$.post("application/controllers/ClienteController.php?action=Listar_Cliente",
	{
		TipoCliente:$("#lstTipoCliente").val()
	}, function(data){
	
	
		$("#Lista_Cliente").html(data);
		
		oTable = $('.dTable').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": true,
			"iDisplayLength": 10,
			"sDom": '<""l>t<"F"fp>'
		});		
	});*/
	
	if($("#lstTipoCliente").prop("selectedIndex")==1)
	{
		$('#listado_cliente_persona').dataTable( {
			"processing": true,
			"serverSide": true,
			"ordering": true,
			"info": true,
			"ajax": {
				"url": "application/controllers/ClienteController.php?action=Listar_Cliente",
				"data": function ( d ) {
					d.TipoCliente = $("#lstTipoCliente").val();				
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
				  { "className": "text-center", "targets": [ 0,9 ] },
				  { "searchable": false, "targets": [ 0,8,9 ] },
				  { "orderable": false, "targets": [ 8,9 ] },
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
	else if($("#lstTipoCliente").prop("selectedIndex")==2)
	{
		$('#listado_cliente_empresa').dataTable( {
			"processing": true,
			"serverSide": true,
			"ordering": true,
			"info": true,
			"ajax": {
				"url": "application/controllers/ClienteController.php?action=Listar_Cliente",
				"data": function ( d ) {
					d.TipoCliente = $("#lstTipoCliente").val();				
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
				  { "className": "text-center", "targets": [ 0,10 ] },
				  { "searchable": false, "targets": [ 0,9,10 ] },
				  { "orderable": false, "targets": [ 9,10 ] },
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
				{ "data": 11 }

				
				
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
	else
	{
		$('#listado_cliente_persona').addClass("hidden");
		$('#listado_cliente_empresa').addClass("hidden");
	}
		
	
	
}

function Ultimos_Clientes()
{
	$("#Ultimos_Clientes").load("application/controllers/ClienteController.php?action=Ultimos_Clientes",
	function(data){
	
	
		$("#Ultimos_Clientes").html(data);
		
	/*//Cargar_Librerias();
	
	$.getScript("js/custom-tables.js");
	//$.getScript("js/funciones.js");*/			
		
	});
}

function verLogo(id){
var modal = document.getElementById('myModal');
$(document).on('click', '#verLogo'+id+'', function(event) {
	event.preventDefault();
$.post("application/controllers/ClienteController.php?action=Ver_Logotipo",
	{
		id_cliente:id
	
	},function(data){
		$('#myModal').html('');
		var data = $.parseJSON(data);
		var Nombre_Empresa = data[0].nombre_empresa;
		var Logo_Empresa = data[0].logo_empresa;
		Logo_Empresa = (Logo_Empresa == 'NULL') ? 'logo.png' : Logo_Empresa;
		$('#myModal').prepend('<div class="modal-content"><span class="close">&times;</span><h3 class="text-center">'+Nombre_Empresa+'</h3><br><hr class="divider"><br><div align="center"><img class="Logotipo" style="width:40%;" src="././public/images/logotipos/'+Logo_Empresa+'"></div></div>')
		 modal.style.display = "block";

	});

});
$(document).on('click', '.close', function(event) {
	event.preventDefault();
	$('#myModal').html('');
	modal.style.display = "none";
});
$(document).on('click', 'body', function(event) {
	event.preventDefault();
	if (event.target == modal) {
		$('#myModal').html('');
        modal.style.display = "none";
    }

});
}



function Editar_Cliente(oId)			
{
	


	$.getScript("public/js/form_validation_table.js");
	
	if ($("#lstTipoCliente").val() == 1)
	{
		var NombreCliente = $("#hidNombreCliente" + oId).val();
		var ApellidoCliente = $("#hidApellidoCliente" + oId).val();	
	}
	else if ($("#lstTipoCliente").val() == 2)
	{
		var NombreEmpresa = $("#hidNombreEmpresa" + oId).val();
		var strRUC = $("#hidRUC" + oId).val();
		var RUC=strRUC.split("-");
		var DV = $("#hidDV" + oId).val();
	    var Logotipo = $("#LogoValue"+oId).attr('value');	
		console.log(Logotipo);	

	}
	

	var Telefono = $("#hidTelefono" + oId).val();
	var Celular = $("#hidCelular" + oId).val();	
	var Email = $("#hidEmail" + oId).val();	
	var Direccion = $("#hidDireccion" + oId).val();
	var Credito = $("#hidCredito" + oId).val();
	var CreadoPor = $("#hidCreadoPor" + oId).val();
	
	if (CreadoPor == undefined)
	CreadoPor = "";
	
	var ActualizadoPor = $("#hidActualizadoPor" + oId).val();

	if (ActualizadoPor == undefined)
	ActualizadoPor = "";
	
	var Id = $("#hdnIdCampos_" + oId).val();	



	
		
	if ($("#lstTipoCliente").val() == 1)
	{		
		var strHtml0= "<td  align=\"center\">" +  (parseInt(oId+1)) + '</td>';
			strHtml0 += "<td>" + '<input type="text" id="txtNombreCliente' + oId + '" name="txtNombreCliente[]" value="'+ NombreCliente +'"  class="validate[required,custom[onlyLetterSp]]"  style="width:95%;"/><input type="hidden" id="hidNombreCliente' + oId + '" name="hidNombreCliente[]" value="'+ NombreCliente +'"  /></td>';	
		var strHtml1 = "<td>" + '<input type="text" id="txtApellidoCliente' + oId + '" name="txtApellidoCliente[]" value="'+ ApellidoCliente +'"  class="validate[required,custom[onlyLetterSp]]" style="width:95%;"/><input type="hidden" id="hidApellidoCliente' + oId + '" name="hidApellidoCliente[]" value="'+ ApellidoCliente +'"/></td>';
	}
	else if ($("#lstTipoCliente").val() == 2)
	{		
		var strHtml0  = "<td  align=\"center\">" +  (parseInt(oId+1)) + '</td>';
			strHtmlNombre = "<td>" + '<input type="text" id="txtNombreEmpresa' + oId + '" name="txtNombreEmpresa[]" value="'+ NombreEmpresa +'"  class="validate[required,custom[onlyLetterSp]]"  style="width:95%;"/><input type="hidden" id="hidNombreEmpresa' + oId + '" name="hidNombreEmpresa[]" value="'+ NombreEmpresa +'"  /></td>';	
		var strHtml1 = "<td>" + '<input type="text" id="txtRUC1' + oId + '" name="txtRUC1[]" value="'+ RUC[0] +'"  class="validate[required,custom[onlyNumberSp]]" style="width:20%;"/>';
			strHtml1 += '<input type="text" id="txtRUC2' + oId + '" name="txtRUC2[]" value="'+ RUC[1] +'"  class="validate[required,custom[onlyNumberSp]]" style="width:20%;"/>';
			strHtml1 += '<input type="text" id="txtRUC3' + oId + '" name="txtRUC3[]" value="'+ RUC[2] +'"  class="validate[required,custom[onlyNumberSp]]" style="width:20%;"/><input type="hidden" id="hidRUC' + oId + '" name="hidRUC[]" value="'+ strRUC +'"/></td>';	
		var strHtml2 = "<td>" + '<input type="text" id="txtDV' + oId + '" name="txtDV[]" value="'+ DV +'"  class="validate[required,custom[onlyNumberSp]]" style="width:60%;"/><input type="hidden" id="hidDV' + oId + '" name="hidDV[]" value="'+ DV +'"/></td>';	

	}
	
	var strHtml3 = "<td>" + '<input type="text" id="txtTelefono' + oId + '" name="txtTelefono[]" value="'+ Telefono +'"  class="maskTelefono validate[required]"  style="width:85%;"/><input type="hidden" id="hidTelefono' + oId + '" name="hidTelefono[]" value="'+ Telefono +'"  /></td>';	
	var strHtml4 = "<td>" + '<input type="text" id="txtCelular' + oId + '" name="txtCelular[]" value="'+ Celular +'"  class="maskCelular validate[required]"  style="width:85%;"/><input type="hidden" id="hidCelular' + oId + '" name="hidCelular[]" value="'+ Celular +'"  /></td>';	
	var strHtml5 = "<td>" + '<input type="text" id="txtEmail' + oId + '" name="txtEmail[]" value="'+ Email +'"  class="validate[required,custom[email]]"  style="width:95%;"/><input type="hidden" id="hidEmail' + oId + '" name="hidEmail[]" value="'+ Email +'"  /></td>';	
	var strHtml6 = "<td>" + '<input type="text" id="txtDireccion' + oId + '" name="txtDireccion[]" value="'+ Direccion +'"  class="validate[required]]"  style="width:95%;"/><input type="hidden" id="hidDireccion' + oId + '" name="hidDireccion[]" value="'+ Direccion +'"  /></td>';
	var strHtml7 = "<td>" + '<div class="floatL" style="margin: 2px 0 0 0;"><input type="radio" id="rdbCredito1" name="rdbCredito" value="1" class="validate[required]" data-prompt-position="topRight:102" ';
	if (escape(Credito)=="S%ED")
	strHtml7 += 'checked="checked"';
	else
	strHtml7 += '';	
	strHtml7 += ' /><label for="radioReq">S&iacute;</label></div>';
	
	strHtml7 += '<div class="floatL" style="margin: 2px 0 0 0;"><input type="radio" id="rdbCredito2" name="rdbCredito" value="0" class="validate[required]" data-prompt-position="topRight:102" ';
	if (Credito=="No")
	strHtml7 += 'checked="checked"';
	else
	strHtml7 += '';	
	strHtml7 += ' /><label for="radioReq">No</label></div>';
	strHtml7 += '<input type="hidden" id="hidCredito' + oId + '" name="hidCredito[]" value="'+ Credito +'"  /></td>';
	
	if (ActualizadoPor != "")
	var strHtml8 = "<td>" + CreadoPor + '/' + ActualizadoPor + '<input type="hidden" id="hidCreadoPor' + oId + '" name="hidCreadoPor[]" value="'+ CreadoPor +'"  /><input type="hidden" id="hidActualizadoPor' + oId + '" name="hidActualizadoPor[]" value="'+ ActualizadoPor +'"  /></td>';
	else
	var strHtml8 = "<td>" + CreadoPor + '<input type="hidden" id="hidCreadoPor' + oId + '" name="hidCreadoPor[]" value="'+ CreadoPor +'"  /><input type="hidden" id="hidActualizadoPor' + oId + '" name="hidActualizadoPor[]" value="'+ ActualizadoPor +'"  /></td>';
	
	var strHtmlLogo ='<td ><input type="file" class="" style="width: 100%;" name="Logoedit" id="Logoedit'+oId+'" /><input type="hidden" id="tdLogo'+ oId +'" value="'+Logotipo+'"></td>'; 

	var strHtml9 = '<td><a href="javascript:void(0);" title="Guardar" class="smallButton" style="margin: 5px;" onclick="Guardar_Cliente(' + oId + ')"><img src="public/images/icons/light/check.png" alt="" class="icon" /><span></span></a>';
	strHtml9 += '<a href="javascript:void(0);" title="Cancelar" class="smallButton" style="margin: 5px;" onclick="Cancelar_Guardar_Cliente(' + oId + ')"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
	strHtml9 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";

	if ($("#lstTipoCliente").val() == 1)
	{		
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;
	}
	else if ($("#lstTipoCliente").val() == 2)
	{
		var strHtmlFinal =  strHtml0 + strHtmlNombre + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7+ strHtml8 + strHtmlLogo + strHtml9;	
	}
	
	$("#tbDetalle").append(strHtmlTr);

	$("#rowDetalle_" + oId).html(strHtmlFinal);
	return false;
	




}

function Guardar_Cliente(oId)
{

	var Logotipo_Editado = document.getElementById("Logoedit"+oId);	

if (Logotipo_Editado != null) {
	var Logotipo = Logotipo_Editado.files; 
	var FormEdit = new FormData();
	for(i=0; i<Logotipo.length; i++){
		FormEdit.append('archivo'+i,Logotipo[i]);
	}

	var Logo_Nombre = document.getElementById('tdLogo'+oId).value; 
	 // Nombre de la imagen
	if (Logotipo.length != 0) {var Logo_Editado = Logotipo[0].name;}else{var Logo_Editado = Logo_Nombre;}
}

	
	var Id = $("#hdnIdCampos_" + oId).val();
	
	$.post("application/controllers/ClienteController.php?action=Actualizar_Cliente",
	{
		NombreCliente:$("#txtNombreCliente" + oId).val(),
		ApellidoCliente:$("#txtApellidoCliente" + oId).val(),
		NombreEmpresa:$("#txtNombreEmpresa" + oId).val(),
		RUC1:$("#txtRUC1" + oId).val(),
		RUC2:$("#txtRUC2" + oId).val(),
		RUC3:$("#txtRUC3" + oId).val(),
		DV:$("#txtDV" + oId).val(),
		TipoCliente:$("#lstTipoCliente").val(),
		Email:$("#txtEmail" + oId).val(),		
		Telefono:$("#txtTelefono" + oId).val(),
		Celular:$("#txtCelular" + oId).val(),
		Direccion:$("#txtDireccion" + oId).val(),		
		NombreContacto:$("#txtNombreContacto").val(),
		CelularContacto:$("#txtCelularContacto").val(),
		EmailContacto:$("#txtEmailContacto").val(),		
		Credito:$("input:checked").val(),
		IdCliente:Id,
		Logo_Editado:Logo_Editado		
		
	}, function(data){

		
		$.ajax({
		url:'application/controllers/ClienteController.php?action=subir_logotipo', //Url a donde la enviaremos
		type:'POST', //Metodo que usaremos
		contentType:false, //Debe estar en false para que pase el objeto sin procesar
		data:FormEdit, //Le pasamos el objeto que creamos con los archivos
		processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
		cache:false //Para que el formulario no guarde cache
	}).done(function(msg){




		if (data=="true" && msg == "true")
		{
			Sexy.info("Se han actualizado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_clientes');
				}
			});
		}
		else if (data=="false" && msg == "true")
		Sexy.error("Error guardar los Datos");
		});
	})
}


function Cancelar_Guardar_Cliente(oId)
{
	if ($("#lstTipoCliente").val() == 1)
	{
		var NombreCliente = $("#hidNombreCliente" + oId).val();
		var ApellidoCliente = $("#hidApellidoCliente" + oId).val();	
	}
	else if ($("#lstTipoCliente").val() == 2)
	{
		var NombreEmpresa = $("#hidNombreEmpresa" + oId).val();
		var RUC = $("#hidRUC" + oId).val();
		var DV = $("#hidDV" + oId).val();			
	}
	

	var Telefono = $("#hidTelefono" + oId).val();
	var Celular = $("#hidCelular" + oId).val();	
	var Email = $("#hidEmail" + oId).val();	
	var Direccion = $("#hidDireccion" + oId).val();
	var Credito = $("#hidCredito" + oId).val();
	var CreadoPor = $("#hidCreadoPor" + oId).val();
	
	if (CreadoPor == undefined)
	CreadoPor = "";
	
	var ActualizadoPor = $("#hidActualizadoPor" + oId).val();

	if (ActualizadoPor == undefined)
	ActualizadoPor = "";
	
	var Id = $("#hdnIdCampos_" + oId).val();	

	var strHtml0= "<td  align=\"center\">" +  oId + '</td>';	
	if ($("#lstTipoCliente").val() == 1)
	{	
			strHtml0 += "<td>" + NombreCliente + '<input type="hidden" id="hidNombreCliente' + oId + '" name="hidNombreCliente[]" value="'+ NombreCliente +'"  /></td>';	
		var strHtml1 = "<td>" + ApellidoCliente +'<input type="hidden" id="hidApellidoCliente' + oId + '" name="hidApellidoCliente[]" value="'+ ApellidoCliente +'"/></td>';
	}
	else if ($("#lstTipoCliente").val() == 2)
	{
			strHtml0 += "<td>" + NombreEmpresa + '<input type="hidden" id="hidNombreEmpresa' + oId + '" name="hidNombreEmpresa[]" value="'+ NombreEmpresa +'"  /></td>';	
		var strHtml1 = "<td>" + RUC + '<input type="hidden" id="hidRUC' + oId + '" name="hidRUC[]" value="'+ RUC +'"/></td>';
		var strHtml2 = "<td>" + DV + '<input type="hidden" id="hidDV' + oId + '" name="hidDV[]" value="'+ DV +'"/></td>';
	}
	var strHtml3 = "<td>" + Telefono + '<input type="hidden" id="hidTelefono' + oId + '" name="hidTelefono[]" value="'+ Telefono +'"  /></td>';	
	var strHtml4 = "<td>" + Celular + '<input type="hidden" id="hidCelular' + oId + '" name="hidCelular[]" value="'+ Celular +'"  /></td>';	
	var strHtml5 = "<td>" + Email + '<input type="hidden" id="hidEmail' + oId + '" name="hidEmail[]" value="'+ Email +'"  /></td>';	
	var strHtml6 = "<td>" + Direccion + '<input type="hidden" id="hidDireccion' + oId + '" name="hidDireccion[]" value="'+ Direccion +'"  /></td>';
	var strHtml7 = "<td>" + Credito + '<input type="hidden" id="hidCredito' + oId + '" name="hidCredito[]" value="'+ Credito +'"  /></td>';	
	
	if (ActualizadoPor != "")
	var strHtml8 = "<td>" + CreadoPor + '/' + ActualizadoPor + '<input type="hidden" id="hidCreadoPor' + oId + '" name="hidCreadoPor[]" value="'+ CreadoPor +'"  /><input type="hidden" id="hidActualizadoPor' + oId + '" name="hidActualizadoPor[]" value="'+ ActualizadoPor +'"  /></td>';
	else
	var strHtml8 = "<td>" + CreadoPor + '<input type="hidden" id="hidCreadoPor' + oId + '" name="hidCreadoPor[]" value="'+ CreadoPor +'"  /><input type="hidden" id="hidActualizadoPor' + oId + '" name="hidActualizadoPor[]" value="'+ ActualizadoPor +'"  /></td>';
	
	var strHtml9 = '<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Cliente(' + oId + ')"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
	if ($("#lstTipoCliente").val() == 2)
	{	
		strHtml9 += '<a href="javascript:void(0);" title="Editar Contactos" class="smallButton" style="margin: 5px;" onclick="Editar_Contacto_Cliente(' + oId + ')"><img src="public/images/icons/light/user.png" alt="" class="icon" /><span></span></a>';		
	}
	strHtml9 += '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Cliente?\')){Eliminar_Cliente(' + oId + '})"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
	strHtml9 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	
	if ($("#lstTipoCliente").val() == 1)
	{		
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7 + strHtml8 + strHtml9;
	}
	else if ($("#lstTipoCliente").val() == 2)
	{
		var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7+ strHtml8;	
	}
	
	$("#tbDetalle").append(strHtmlTr);

	$("#rowDetalle_" + oId).html(strHtmlFinal);
	window.location.reload();
	return false;
}

function Eliminar_Cliente(oId)
{
	var Id = $("#hdnIdCampos_" + oId).val();
	
	$.post("application/controllers/ClienteController.php?action=Eliminar_Cliente",
	{
		TipoCliente:$("#lstTipoCliente").val(),
		IdCliente:Id	
		
	}, function(data){

		
		if (data=="true")
		{
			$("#rowDetalle_" + oId).remove();

			if($("[name='txtTelefono[]']").length == 0)
			{
				$("#cant_campos").val("0");
				$("#num_campos").val("0");
			}			
			Sexy.info("Se ha eliminado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_clientes');
				}
			});
		}
		else if (data=="false")
		Sexy.error("Error eliminar los Datos");
	})
	
	return false; 
}


function Agregar_Contacto(){

	$.getScript("public/js/form_validation_table.js");	
	
	$("#cant_campos").val(parseInt($("#cant_campos").val()) + 1);
	var oId = $("#cant_campos").val();

	var strHtml0= "<td  align=\"center\">" +  oId + '</td>';	        
	var strHtml1 = "<td>" + '<span class="req">*</span><input type="text" id="txtNombreContacto' + oId + '" name="txtNombreContacto[]" value="" style="width:95%;" class="validate[required]"/><input type="hidden" id="hidNombreContacto' + oId + '" name="hidNombreContacto[]" value=""  /></td>';
	var strHtml2 = "<td>" + '<span class="req">*</span><input type="text" id="txtTelefonoContacto' + oId + '" name="txtTelefonoContacto[]" value="" style="width:70%;" class="maskTelefono validate[required]"/><input type="hidden" id="hidTelefonoContacto' + oId + '" name="hidTelefonoContacto[]" value=""  /></td>';	
	var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtCelularContacto' + oId + '" name="txtCelularContacto[]" value="" style="width:70%;" class="maskCelular validate[required]" /><input type="hidden" id="hidCelularContacto' + oId + '" name="hidCelularContacto[]" value=""  /></td>';
	var strHtml4 = "<td>" + '<span class="req">*</span><input type="text" id="txtEmailContacto' + oId + '" name="txtEmailContacto[]" value="" style="width:70%;"  class="validate[required,custom[email]]"/><input type="hidden" id="hidEmailContacto' + oId + '" name="hidEmailContacto[]" value=""  /></td>';

	var strHtml5 = '<td><a href="javascript:void(0);" title="Guardar" class="smallButton" style="margin: 5px;" onclick="Confirmar_Contacto(' + oId + ')"><img src="public/images/icons/light/check.png" alt="" class="icon" /><span></span></a>&nbsp;';
		strHtml5 += '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Contacto?\')){Eliminar_Contacto(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
		strHtml5 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5;
	
    $("#tbDetalle").append(strHtmlTr);
	
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	return false;	
}

function Agregar_Contacto_Cliente(oId){
	
	$.getScript("public/js/form_validation_table.js");	
	
	$("#cant_campos_min" + oId).val(parseInt($("#cant_campos_min" + oId).val()) + 1);
	var oIdMin = $("#cant_campos_min" + oId).val();

	
	var Id = $("#hdnIdCamposMin_" + oIdMin).val();
	
	var strHtml0= "<td  align=\"center\">" +  oIdMin + '</td>';	        
	var strHtml1 = "<td>" + '<span class="req">*</span><input type="text" id="txtNombreContacto' + oId + oIdMin + '" name="txtNombreContacto' + oId + '[]" value="" style="width:95%;" class="validate[required]"/><input type="hidden" id="hidNombreContacto' + oId + oIdMin + '" name="hidNombreContacto' + oId + '[]" value=""  /></td>';
	var strHtml2 = "<td>" + '<span class="req">*</span><input type="text" id="txtTelefonoContacto' + oId + oIdMin + '" name="txtTelefonoContacto' + oId + '[]" value="" style="width:70%;" class="maskTelefono validate[required]"/><input type="hidden" id="hidTelefonoContacto' + oId + oIdMin + '" name="hidTelefonoContacto' + oId + '[]" value=""  /></td>';	
	var strHtml3 = "<td>" + '<span class="req">*</span><input type="text" id="txtCelularContacto' + oId + oIdMin + '" name="txtCelularContacto' + oId + '[]" value="" style="width:70%;" class="maskCelular validate[required]" /><input type="hidden" id="hidCelularContacto' + oId + oIdMin + '" name="hidCelularContacto' + oId + '[]" value=""  /></td>';
	var strHtml4 = "<td>" + '<span class="req">*</span><input type="text" id="txtEmailContacto' + oId + oIdMin + '" name="txtEmailContacto' + oId + '[]" value="" style="width:70%;"  class="validate[required,custom[email]]"/><input type="hidden" id="hidEmailContacto' + oId + oIdMin + '" name="hidEmailContacto' + oId + '[]" value=""  /></td>';

	var strHtml5 = '<td><a href="javascript:void(0);" title="Guardar" class="smallButton" style="margin: 5px;" onclick="Confirmar_Contacto_Cliente(' + oId + ',' + oIdMin + ')"><img src="public/images/icons/light/check.png" alt="" class="icon" /><span></span></a>&nbsp;';
		strHtml5 += '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Contacto?\')){Eliminar_Contacto_Cliente(' + oIdMin + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
		strHtml5 += '<input type="hidden" id="hdnIdCamposMin_' + oIdMin +'" name="hdnIdCamposMin[]" value="' + Id + '" /></td>';
	var strHtmlTr = "<tr id='rowDetalleMin_" + oId + oIdMin + "'  valign=\"center\"  ></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5;
	
    $("#tbDetalleMin" + oId).append(strHtmlTr);
	
	$("#rowDetalleMin_" +  + oId + oIdMin).html(strHtmlFinal);
	return false;	
}

function Confirmar_Contacto(oId)
{
	
	var NombreContacto = $("#txtNombreContacto" + oId).val();
	var TelefonoContacto = $("#txtTelefonoContacto" + oId).val();
	var CelularContacto = $("#txtCelularContacto" + oId).val();	
	var EmailContacto = $("#txtEmailContacto" + oId).val();
	var Id = $("#hdnIdCampos_" + oId).val();

	var strHtml0= "<td  align=\"center\">" +  oId + '</td>';	        
	var strHtml1 = "<td>" + NombreContacto + '<input type="hidden" id="hidNombreContacto' + oId + '" name="hidNombreContacto[]" value="' + NombreContacto + '"  /></td>';
	var strHtml2 = "<td>" + TelefonoContacto + '<input type="hidden" id="hidTelefonoContacto' + oId + '" name="hidTelefonoContacto[]" value="' + TelefonoContacto + '"  /></td>';	
	var strHtml3 = "<td>" + CelularContacto + '<input type="hidden" id="hidCelularContacto' + oId + '" name="hidCelularContacto[]" value="' + CelularContacto + '"  /></td>';
	var strHtml4 = "<td>" + EmailContacto + '<input type="hidden" id="hidEmailContacto' + oId + '" name="hidEmailContacto[]" value="' + EmailContacto + '"  /></td>';

	var strHtml5 = '<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Contacto(' + oId + ')"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>&nbsp;';
		strHtml5 += '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Contacto?\')){Eliminar_Contacto(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
		strHtml5 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5;
	
    $("#tbDetalle").append(strHtmlTr);
	
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	return false;	
}


function Confirmar_Contacto_Cliente(oId, oIdMin)
{
	
	var NombreContacto = $("#txtNombreContacto" + oId + oIdMin).val();
	var TelefonoContacto = $("#txtTelefonoContacto" + oId + oIdMin).val();
	var CelularContacto = $("#txtCelularContacto" + oId + oIdMin).val();	
	var EmailContacto = $("#txtEmailContacto" + oId + oIdMin).val();
	var Id = $("#hdnIdCamposMin_" + oIdMin).val();

	var strHtml0= "<td  align=\"center\">" +  oIdMin + '</td>';	        
	var strHtml1 = "<td>" + NombreContacto + '<input type="hidden" id="hidNombreContacto' + oId + oIdMin + '" name="hidNombreContacto' + oId + '[]" value="' + NombreContacto + '"  /></td>';
	var strHtml2 = "<td>" + TelefonoContacto + '<input type="hidden" id="hidTelefonoContacto' + oId + oIdMin + '" name="hidTelefonoContacto' + oId + '[]" value="' + TelefonoContacto + '"  /></td>';	
	var strHtml3 = "<td>" + CelularContacto + '<input type="hidden" id="hidCelularContacto' + oId + oIdMin + '" name="hidCelularContacto' + oId + '[]" value="' + CelularContacto + '"  /></td>';
	var strHtml4 = "<td>" + EmailContacto + '<input type="hidden" id="hidEmailContacto' + oId + oIdMin + '" name="hidEmailContacto' + oId + '[]" value="' + EmailContacto + '"  /></td>';

	var strHtml5 = '<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Contacto_Cliente(' + oId + ',' + oIdMin + ')"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>&nbsp;';
		strHtml5 += '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Contacto?\')){Eliminar_Contacto_Cliente(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
		strHtml5 += '<input type="hidden" id="hdnIdCamposMin_' + oIdMin +'" name="hdnIdCamposMin[]" value="' + Id + '" /></td>';
	var strHtmlTr = "<tr id='rowDetalleMin_" + oId + oIdMin + "'  valign=\"center\"  ></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5;
	
    $("#tbDetalleMin").append(strHtmlTr);
	
	$("#rowDetalleMin_" + oId + oIdMin).html(strHtmlFinal);
	
	$.getScript("js/custom-mask.js");
	return false;	
}

function Editar_Contacto(oId)
{
	
	var NombreContacto = $("#hidNombreContacto" + oId).val();
	var TelefonoContacto = $("#hidTelefonoContacto" + oId).val();
	var CelularContacto = $("#hidCelularContacto" + oId).val();	
	var EmailContacto = $("#hidEmailContacto" + oId).val();
	var Id = $("#hdnIdCampos_" + oId).val();

	var strHtml0= "<td  align=\"center\">" +  oId + '</td>';	        
	var strHtml1 = '<td><span class="req">*</span><input type="text" id="txtNombreContacto' + oId + '" name="txtNombreContacto[]" value="' + NombreContacto + '" style="width:95%;" class="validate[required]"/><input type="hidden" id="hidNombreContacto' + oId + '" name="hidNombreContacto[]" value="' + NombreContacto + '"  /></td>';
	var strHtml2 = '<td><span class="req">*</span><input type="text" id="txtTelefonoContacto' + oId + '" name="txtTelefonoContacto[]" value="' + TelefonoContacto + '" style="width:70%;" class="maskTelefono validate[required]"/><input type="hidden" id="hidTelefonoContacto' + oId + '" name="hidTelefonoContacto[]" value="' + TelefonoContacto + '"  /></td>';	
	var strHtml3 = '<td><span class="req">*</span><input type="text" id="txtCelularContacto' + oId + '" name="txtCelularContacto[]" value="' + CelularContacto + '" style="width:70%;" class="maskCelular validate[required]" /><input type="hidden" id="hidCelularContacto' + oId + '" name="hidCelularContacto[]" value="' + CelularContacto + '"  /></td>';
	var strHtml4 = '<td><span class="req">*</span><input type="text" id="txtEmailContacto' + oId + '" name="txtEmailContacto[]" value="' + EmailContacto + '" style="width:70%;"  class="validate[required,custom[email]]"/><input type="hidden" id="hidEmailContacto' + oId + '" name="hidEmailContacto[]" value="' + EmailContacto + '"  /></td>';

	var strHtml5 = '<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Confirmar_Contacto(' + oId + ')"><img src="public/images/icons/light/check.png" alt="" class="icon" /><span></span></a>&nbsp;';
		strHtml5 += '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Contacto?\')){Eliminar_Contacto(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
		strHtml5 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" /></td>';
	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5;
	
    $("#tbDetalle").append(strHtmlTr);
	
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	
	$.getScript("public/js/form_validation.js");	
	return false;	
}

function Editar_Contacto_Cliente(oId, oIdMin)
{

	var NombreContacto = $("#hidNombreContacto" + oId + oIdMin).val();
	var TelefonoContacto = $("#hidTelefonoContacto" + oId + oIdMin).val();
	var CelularContacto = $("#hidCelularContacto" + oId + oIdMin).val();	
	var EmailContacto = $("#hidEmailContacto" + oId + oIdMin).val();
	var Id = $("#hdnIdCamposMin_" + oIdMin).val();

	var strHtml0= "<td  align=\"center\">" +  oIdMin + '</td>';	        
	var strHtml1 = '<td><span class="req">*</span><input type="text" id="txtNombreContacto' + oId + oIdMin + '" name="txtNombreContacto' + oId + '[]" value="' + NombreContacto + '" style="width:95%;" class="validate[required]"/><input type="hidden" id="hidNombreContacto' + oId + oIdMin + '" name="hidNombreContacto' + oId + '[]" value="' + NombreContacto + '"  /></td>';
	var strHtml2 = '<td><span class="req">*</span><input type="text" id="txtTelefonoContacto' + oId + oIdMin + '" name="txtTelefonoContacto' + oId + '[]" value="' + TelefonoContacto + '" style="width:70%;" class="maskTelefono validate[required]"/><input type="hidden" id="hidTelefonoContacto' + oId + oIdMin + '" name="hidTelefonoContacto' + oId + '[]" value="' + TelefonoContacto + '"  /></td>';	
	var strHtml3 = '<td><span class="req">*</span><input type="text" id="txtCelularContacto' + oId + oIdMin + '" name="txtCelularContacto' + oId + '[]" value="' + CelularContacto + '" style="width:70%;" class="maskCelular validate[required]" /><input type="hidden" id="hidCelularContacto' + oId + oIdMin + '" name="hidCelularContacto' + oId + '[]" value="' + CelularContacto + '"  /></td>';
	var strHtml4 = '<td><span class="req">*</span><input type="text" id="txtEmailContacto' + oId + oIdMin + '" name="txtEmailContacto' + oId + '[]" value="' + EmailContacto + '" style="width:70%;"  class="validate[required,custom[email]]"/><input type="hidden" id="hidEmailContacto' + oId + oIdMin + '" name="hidEmailContacto' + oId + '[]" value="' + EmailContacto + '"  /></td>';

	var strHtml5 = '<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Confirmar_Contacto_Cliente(' + oId + ',' + oIdMin + ')"><img src="public/images/icons/light/check.png" alt="" class="icon" /><span></span></a>&nbsp;';
		strHtml5 += '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Contacto?\')){Eliminar_Contacto_Cliente(' + oId + ')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
		strHtml5 += '<input type="hidden" id="hdnIdCamposMin_' + oIdMin +'" name="hdnIdCamposMin[]" value="' + Id + '" /></td>';
	var strHtmlTr = "<tr id='rowDetalleMin_" + oId + oIdMin + "'  valign=\"center\"  ></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5;
	
    $("#tbDetalle").append(strHtmlTr);
	
	$("#rowDetalleMin_" + oId + oIdMin).html(strHtmlFinal);
	
	$.getScript("public/js/form_validation.js");	

	return false;	
}

function Editar_Contacto_Listado(oId)
{

	var NombreEmpresa = $("#hidNombreEmpresa" + oId).val();
	var RUC = $("#hidRUC" + oId).val();
	var DV = $("#hidDV" + oId).val();
	var Telefono = $("#hidTelefono" + oId).val();
	var Celular = $("#hidCelular" + oId).val();	
	var Email = $("#hidEmail" + oId).val();	
	var Direccion = $("#hidDireccion" + oId).val();
	var Credito = $("#hidCredito" + oId).val();	
	var CreadoPor = $("#hidCreadoPor" + oId).val();
	
	if (CreadoPor == undefined)
	CreadoPor = "";
	
	var ActualizadoPor = $("#hidActualizadoPor" + oId).val();

	if (ActualizadoPor == undefined)
	ActualizadoPor = "";
	
	var Id = $("#hdnIdCampos_" + oId).val();

	var strHtml0 = "<td  align=\"center\">" + oId + "</td>";
		strHtml0 += "<td  align=\"center\" colspan=\"10\">";	
		//strHtml0 +=  '<div class="title"><img src="public/images/icons/dark/frames.png" alt="" class="titleIcon" /><h6></h6></div>';
		strHtml0 +=  '<table  cellpadding="0" cellspacing="0" width="100%" class="sTable" id="tblDetalleMin' + oId + '" name="tblDetalleMin[]">';
		strHtml0 +=  '<thead>';
		strHtml0 +=  '<tr align="center">';
		strHtml0 +=  '<td width="15%"><a href="javascript:void(0);" title="Agregar Contactos" id="AgregarContactos' + oId + '" class="smallButton" style="margin: 5px;"><img src="public/images/icons/color/plus.png" alt="" /></a>';
		strHtml0 +=  '<a href="javascript:void(0);" title="Guardar Cambios" class="smallButton" style="margin: 5px;"><img src="public/images/icons/color/tick.png" alt="" onclick="Guardar_Contacto_Cliente(' + oId + ')" /></a>';		
		strHtml0 +=  '<a href="javascript:void(0);" title="Cancelar Editar Contactos" class="smallButton" style="margin: 5px;" onclick="Cancelar_Editar_Contacto_Cliente(' + oId + ');"><img src="public/images/icons/dark/close.png" alt="" class="icon" /><span></span></a></td>';
		strHtml0 +=  '<td width="32%">Nombre de Contacto<input type="hidden" id="num_campos_min' + oId + '" name="num_campos_min' + oId + '" value="0" /></td>';
		strHtml0 +=  '<td width="10%">Tel&eacute;fono del Contacto<input type="hidden" id="cant_campos_min' + oId + '" name="cant_campos_min' + oId + '" value="0" /></td>';
		strHtml0 +=  '<td width="10%">Celular del Contacto</td>';					
		strHtml0 +=  '<td width="15%">Correo Electr&oacute;nico del Contacto</td>';
		strHtml0 +=  '<td width="18%">Opciones</td>';							
		strHtml0 +=  '</tr>';
		strHtml0 +=  '</thead>';
		strHtml0 +=  '<tbody id="tbDetalleMin' + oId + '"></tbody>';
		strHtml0 +=  '</table>';
		strHtml0 +=  '<input type="hidden" id="hidNombreEmpresa' + oId + '" name="hidNombreEmpresa[]" value="'+ NombreEmpresa +'"  />';	
		strHtml0 +=  '<input type="hidden" id="hidRUC' + oId + '" name="hidRUC[]" value="'+ RUC +'"/>';	
		strHtml0 +=  '<input type="hidden" id="hidDV' + oId + '" name="hidDV[]" value="'+ DV +'"/>';	
		strHtml0 +=  '<input type="hidden" id="hidTelefono' + oId + '" name="hidTelefono[]" value="'+ Telefono +'"  />';	
		strHtml0 +=  '<input type="hidden" id="hidCelular' + oId + '" name="hidCelular[]" value="'+ Celular +'"  />';	
		strHtml0 +=  '<input type="hidden" id="hidEmail' + oId + '" name="hidEmail[]" value="'+ Email +'"  />';	
		strHtml0 +=  '<input type="hidden" id="hidDireccion' + oId + '" name="hidDireccion[]" value="'+ Direccion +'"  />';	
		strHtml0 +=  '<input type="hidden" id="hidCredito' + oId + '" name="hidCredito[]" value="'+ Credito +'"  />';
		strHtml0 +=  '<input type="hidden" id="hidCreadoPor' + oId + '" name="hidCreadoPor[]" value="'+ CreadoPor +'"  />';	
		strHtml0 +=  '<input type="hidden" id="hidActualizadoPor' + oId + '" name="hidActualizadoPor[]" value="'+ ActualizadoPor +'"  />';		
		strHtml0 +=  '<input type="hidden" id="hdnIdCampos_' + oId + '" name="hdnIdCampos[]" value="'+ Id +'"  />';		
		strHtml0 +=  '</td>';	

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"center\"  ></tr>";
	var strHtmlFinal = strHtml0;// + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5;
	
	var rowCount = "";
	var rowCount1 = "";
	$.post("application/controllers/ClienteController.php?action=Listar_Contactos",
	{
		IdFila:oId,
		IdCliente:Id		
		
	}, function(data){

			
		$("#tbDetalleMin" + oId).append(data);
		
		$('#tblDetalleMin' + oId).each(function(index) {
			rowCount = $("tbody tr", this).length;

			rowCount1 = $(this).find('tbody > tr').length; 
		});	
		
		$("#cant_campos_min" + oId).val(rowCount);
		$("#num_campos_min" + oId).val(rowCount);
		
		$("#AgregarContactos" + oId).click(function()
		{
			Agregar_Contacto_Cliente(oId,$("#cant_campos_min" + oId).val());
		});

	})
	

    $("#tbDetalle").append(strHtmlTr);
	
	$("#rowDetalle_" + oId).html(strHtmlFinal);

	return false;	

}

function Guardar_Contacto_Cliente(oId, oIdMin)
{
	
	var arrNombreContacto = new Array();
	arrNombreContacto = $("[name='hidNombreContacto" + oId + "[]']");
	var ArrNombreContacto = [];
	for (var i = 0; i < arrNombreContacto.length; ++i) {
		ArrNombreContacto[i] = arrNombreContacto[i].value;
	}

	StrNombreContacto = ArrNombreContacto.toString();
	
	var arrTelefonoContacto = new Array();
	arrTelefonoContacto = $("[name='hidTelefonoContacto" + oId + "[]']");
	var ArrTelefonoContacto = [];
	for (var i = 0; i < arrTelefonoContacto.length; ++i) {
		ArrTelefonoContacto[i] = arrTelefonoContacto[i].value;
	}

	StrTelefonoContacto = ArrTelefonoContacto.toString();

	var arrCelularContacto = new Array();
	arrCelularContacto = $("[name='hidCelularContacto" + oId + "[]']");
	var ArrCelularContacto = [];
	for (var i = 0; i < arrCelularContacto.length; ++i) {
		ArrCelularContacto[i] = arrCelularContacto[i].value;
	}

	StrCelularContacto = ArrCelularContacto.toString();
	
	var arrEmailContacto = new Array();
	arrEmailContacto = $("[name='hidEmailContacto" + oId + "[]']");
	var ArrEmailContacto = [];
	for (var i = 0; i < arrEmailContacto.length; ++i) {
		ArrEmailContacto[i] = arrEmailContacto[i].value;
	}

	StrEmailContacto = ArrEmailContacto.toString();	

	

	
	var NombreEmpresa = $("#hidNombreEmpresa" + oId).val();
	var RUC = $("#hidRUC" + oId).val();
	var DV = $("#hidDV" + oId).val();
	var Telefono = $("#hidTelefono" + oId).val();
	var Celular = $("#hidCelular" + oId).val();	
	var Email = $("#hidEmail" + oId).val();	
	var Direccion = $("#hidDireccion" + oId).val();
	var Credito = $("#hidCredito" + oId).val();
	var CreadoPor = $("#hidCreadoPor" + oId).val();
	
	if (CreadoPor == undefined)
	CreadoPor = "";
	
	var ActualizadoPor = $("#hidActualizadoPor" + oId).val();

	if (ActualizadoPor == undefined)
	ActualizadoPor = "";
	
	var Id = $("#hdnIdCampos_" + oId).val();

	$("#hdnIdCamposMin" + oIdMin).val(Id);
	
	$.post("application/controllers/ClienteController.php?action=Editar_Contactos",
	{
		NombreContacto:StrNombreContacto,
		TelefonoContacto:StrTelefonoContacto,
		CelularContacto:StrCelularContacto,
		EmailContacto:StrEmailContacto,	
		IdCliente:Id
		
	}, function(data){

		if (data=="true")
		{
			Sexy.info("Se ha guardado exit&oacute;samente los Contactos",{
			onComplete:function (returnvalue) {

					window.location.href='admin.php?sec='+btoa('listar_clientes');
				}
			});

		}
		else if (data=="false")
		Sexy.error("Error guardar los Contactos");
	})		

	var strHtml0 = "<td>" + oId + '</td>';		
		strHtml0 += "<td>" + NombreEmpresa + '<input type="hidden" id="hidNombreEmpresa' + oId + '" name="hidNombreEmpresa[]" value="'+ NombreEmpresa +'"  /></td>';	
	var strHtml1 = "<td>" + RUC + '<input type="hidden" id="hidRUC' + oId + '" name="hidRUC[]" value="'+ RUC +'"/></td>';
	var strHtml2 = "<td>" + DV + '<input type="hidden" id="hidDV' + oId + '" name="hidDV[]" value="'+ DV +'"/></td>';

	var strHtml3 = "<td>" + Telefono + '<input type="hidden" id="hidTelefono' + oId + '" name="hidTelefono[]" value="'+ Telefono +'"  /></td>';	
	var strHtml4 = "<td>" + Celular + '<input type="hidden" id="hidCelular' + oId + '" name="hidCelular[]" value="'+ Celular +'"  /></td>';	
	var strHtml5 = "<td>" + Email + '<input type="hidden" id="hidEmail' + oId + '" name="hidEmail[]" value="'+ Email +'"  /></td>';	
	var strHtml6 = "<td>" + Direccion + '<input type="hidden" id="hidDireccion' + oId + '" name="hidDireccion[]" value="'+ Direccion +'"  /></td>';
	var strHtml7 = "<td>" + Credito + '<input type="hidden" id="hidCredito' + oId + '" name="hidCredito[]" value="'+ Credito +'"  /></td>';	
	
	if (ActualizadoPor != "")
	var strHtml8 = "<td>" + CreadoPor + '/' + ActualizadoPor + '<input type="hidden" id="hidCreadoPor' + oId + '" name="hidCreadoPor[]" value="'+ CreadoPor +'"  /><input type="hidden" id="hidActualizadoPor' + oId + '" name="hidActualizadoPor[]" value="'+ ActualizadoPor +'"  /></td>';
	else
	var strHtml8 = "<td>" + CreadoPor + '<input type="hidden" id="hidCreadoPor' + oId + '" name="hidCreadoPor[]" value="'+ CreadoPor +'"  /><input type="hidden" id="hidActualizadoPor' + oId + '" name="hidActualizadoPor[]" value="'+ ActualizadoPor +'"  /></td>';

	var strHtml9 = '<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Cliente(' + oId + ')"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
	strHtml9 += '<a href="javascript:void(0);" title="Editar Contactos" class="smallButton" style="margin: 5px;" onclick="Editar_Contacto_Listado(' + oId + ')"><img src="public/images/icons/light/user.png" alt="" class="icon" /><span></span></a>';	
	strHtml9 += '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Contacto?\')){Eliminar_Cliente(' + oId + '})"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
	strHtml9 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	

	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7+ strHtml8+ strHtml9;
	$("#tbDetalle").append(strHtmlTr);

	$("#rowDetalle_" + oId).html(strHtmlFinal);
	return false;	
}

function Cancelar_Editar_Contacto_Cliente(oId)
{
	var NombreEmpresa = $("#hidNombreEmpresa" + oId).val();
	var RUC = $("#hidRUC" + oId).val();
	var DV = $("#hidDV" + oId).val();
	var Telefono = $("#hidTelefono" + oId).val();
	var Celular = $("#hidCelular" + oId).val();	
	var Email = $("#hidEmail" + oId).val();	
	var Direccion = $("#hidDireccion" + oId).val();
	var Credito = $("#hidCredito" + oId).val();
	var CreadoPor = $("#hidCreadoPor" + oId).val();
	
	
	if (CreadoPor == undefined)
	CreadoPor = "";
	
	var ActualizadoPor = $("#hidActualizadoPor" + oId).val();

	if (ActualizadoPor == undefined)
	ActualizadoPor = "";
	
	var oIdMin = $("#cant_campos_min" + oId).val();	
	
	var Id = $("#hdnIdCampos_" + oId).val();

	$("#hdnIdCamposMin" + oIdMin).val(Id);

	var strHtml0 = "<td>" + oId + '</td>';		
		strHtml0 += "<td>" + NombreEmpresa + '<input type="hidden" id="hidNombreEmpresa' + oId + '" name="hidNombreEmpresa[]" value="'+ NombreEmpresa +'"  /></td>';	
	var strHtml1 = "<td>" + RUC + '<input type="hidden" id="hidRUC' + oId + '" name="hidRUC[]" value="'+ RUC +'"/></td>';
	var strHtml2 = "<td>" + DV + '<input type="hidden" id="hidDV' + oId + '" name="hidDV[]" value="'+ DV +'"/></td>';

	var strHtml3 = "<td>" + Telefono + '<input type="hidden" id="hidTelefono' + oId + '" name="hidTelefono[]" value="'+ Telefono +'"  /></td>';	
	var strHtml4 = "<td>" + Celular + '<input type="hidden" id="hidCelular' + oId + '" name="hidCelular[]" value="'+ Celular +'"  /></td>';	
	var strHtml5 = "<td>" + Email + '<input type="hidden" id="hidEmail' + oId + '" name="hidEmail[]" value="'+ Email +'"  /></td>';	
	var strHtml6 = "<td>" + Direccion + '<input type="hidden" id="hidDireccion' + oId + '" name="hidDireccion[]" value="'+ Direccion +'"  /></td>';
	var strHtml7 = "<td>" + Credito + '<input type="hidden" id="hidCredito' + oId + '" name="hidCredito[]" value="'+ Credito +'"  /></td>';	

	if (ActualizadoPor != "")
	var strHtml8 = "<td>" + CreadoPor + '/' + ActualizadoPor + '<input type="hidden" id="hidCreadoPor' + oId + '" name="hidCreadoPor[]" value="'+ CreadoPor +'"  /><input type="hidden" id="hidActualizadoPor' + oId + '" name="hidActualizadoPor[]" value="'+ ActualizadoPor +'"  /></td>';
	else
	var strHtml8 = "<td>" + CreadoPor + '<input type="hidden" id="hidCreadoPor' + oId + '" name="hidCreadoPor[]" value="'+ CreadoPor +'"  /><input type="hidden" id="hidActualizadoPor' + oId + '" name="hidActualizadoPor[]" value="'+ ActualizadoPor +'"  /></td>';

	var strHtml9 = '<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Cliente(' + oId + ')"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
	strHtml9 += '<a href="javascript:void(0);" title="Editar Contactos" class="smallButton" style="margin: 5px;" onclick="Editar_Contacto_Listado(' + oId + ')"><img src="public/images/icons/light/user.png" alt="" class="icon" /><span></span></a>';	
	strHtml9 += '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Contacto?\')){Eliminar_Cliente(' + oId + '})"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
	strHtml9 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + Id + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	

	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4 + strHtml5 + strHtml6 + strHtml7+ strHtml8+ strHtml9;	

	$("#tbDetalle").append(strHtmlTr);

	$("#rowDetalle_" + oId).html(strHtmlFinal);
	window.location.reload();
	return false;	
}

function Eliminar_Contacto(oId){
	$("#rowDetalle_" + oId).remove();

	if($("[name='txtNombreContacto[]']").length == 0)
	{
		$("#cant_campos").val("0");
		$("#num_campos").val("0");
	}		
	return false;
}

function Eliminar_Contacto_Cliente(oId,cId){
	$("#rowDetalleMin_" + oId+cId).remove();

	if($("[name='txtNombreContacto" + oId + "[]']").length == 0)
	{
		$("#cant_campos_min" + oId).val("0");
		$("#num_campos_min" + oId).val("0");
	}
	
	return false;
}

function Cancelar_Guardar_Contacto(){
	$("#tbDetalle").html("");	
	return false;
}
