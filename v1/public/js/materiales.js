function GenerarTamanoPliego(oId,TamanoPapel)
{
	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	
	if (oId != undefined)
	{	

		$("#lstTamano" + oId).load("application/controllers/MaterialController.php?action=Listar_Tamano_Pliego",
		function(data) {
					
			$("#lstTamano" + oId).find('option').remove().end().append('<option value="">Seleccione el Tama&ntilde;o del Papel</option>');
			$("#lstTamano" + oId).append(data);
			
			$("#lstTamano" + oId + " option[value=" + TamanoPapel + "]").attr("selected",true);
			
			$("#uniform-lstTamano" + oId).children("span").html($("#lstTamano" + oId + " option:selected").text());					
		});
	}
	else
	{	
		$("#lstTamano").load("application/controllers/MaterialController.php?action=Listar_Tamano_Pliego",	
		function(data) {

			$("#lstTamano").find('option').remove().end().append('<option value="">Seleccione el Tama&ntilde;o del Papel</option>');
			$("#lstTamano").append(data);
			
			$("#lstTamano option[value=" + TamanoPapel + "]").attr("selected",true);
			
			$("#uniform-lstTamano").children("span").html($("#lstTamano option:selected").text());					

		});
	}
}

function GenerarListadoTamanoPag()
{

	$.post("application/controllers/MaterialController.php?action=Listar_Tamano_Pagina",
	function(data){
	//alert(data);
	$("#Listado_Tamano_Pagina").html(data);

		//Cargar_Librerias();
		
		//$.getScript("js/custom-tables1.js");
		//$.getScript("js/funciones.js");	
	
		$("[name='txtPrecioPulgada[]']").keydown(function(event){
			//alert(event.keyCode);
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});

		$("[name='txtPrecioPagina[]']").keydown(function(event){
			//alert(event.keyCode);
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});	
		
		$("[name='txtPrecioPulgada[]']").change(function(){

			var oId = $(this).attr('id');
			oId = oId.substr(16);	

			DecimalesPulgada('txtPrecioPulgada'+oId);

			Calcular_Precio_Material_Pagina(oId,$("#txtPrecioPulgada"+oId).val(),$("#hdnIdCampos_"+oId).val());
			
			
			
		});
		
		$("[name='txtPrecioPagina[]']").change(function(){

			var oId = $(this).attr('id');
			oId = oId.substr(15);	

			DecimalesPulgada('txtPrecioPagina'+oId);
			
			Calcular_Precio_Material_Pulgada(oId,$("#txtPrecioPagina"+oId).val(),$("#hdnIdCampos_"+oId).val());			
		});		
		

		$("[name='chkSeleccionar[]']").change(function(){
			var oId = $(this).attr('id');
			oId = oId.substr(14);			

			$("#hdnSeleccionar" + oId).val($("#chkSeleccionar" + oId + ":checked").val());
		});
	
	
	});

	
		
	
}

function Calcular_Precio_Pulgada()
{
	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	
	$.post("application/controllers/MaterialController.php?action=Calcular_Precio_Pulgada",
	{
		Precio:$("#txtPrecioPliego").val(),
		TamanoLargo:$("#txtTamanoLargo").val(),
		TamanoAncho:$("#txtTamanoAncho").val(),
	},
	function(data){

		$("#txtPrecioPulgada").val(data);
	
		$("[name='txtPrecioPulgada[]']").each(function(indice, elemento) {
			$(elemento).val(data)
		});
		
		$("[name='txtPrecioPagina[]']").each(function(indice, elemento) {
			
			Calcular_Precio_Material_Pagina((indice+1),$("#txtPrecioPulgada"+(indice+1)).val(),$("#hdnIdCampos_"+(indice+1)).val());
		});


	});

}

function Calcular_Precio_Material()
{
	var url = location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	
	$.post("application/controllers/MaterialController.php?action=Calcular_Precio_Material",
	{
		Precio:$("#txtPrecioPulgada").val(),
		TamanoLargo:$("#txtTamanoLargo").val(),
		TamanoAncho:$("#txtTamanoAncho").val(),
	},
	function(data){
		//alert(data);

		$("#txtPrecioPliego").val(data);
		
		$("[name='txtPrecioPulgada[]']").each(function(indice, elemento) {
			$(elemento).val(data)
		});
		
		$("[name='txtPrecioPagina[]']").each(function(indice, elemento) {
			
			Calcular_Precio_Material_Pulgada((indice+1),$("#txtPrecioPliego"+(indice+1)).val(),$("#hdnIdCampos_"+(indice+1)).val());
		});


	});

}

function Calcular_Precio_Material_Pulgada(oId,precio,idtamano)
{
	$.post("application/controllers/MaterialController.php?action=Calcular_Precio_Material_Pulgada",
	{
		Precio:precio,
		Tamano:idtamano
	},
	function(data){
	
		$("#txtPrecioPulgada"+oId).val(data);
		DecimalesPulgada("txtPrecioPulgada"+oId);
	});

}

function Calcular_Precio_Material_Pagina(oId,precio,idtamano)
{	

	$.post("application/controllers/MaterialController.php?action=Calcular_Precio_Material_Pagina",
	{
		Precio:precio,
		Tamano:idtamano
	},
	function(data){
	
		$("#txtPrecioPagina"+oId).val(data);
		DecimalesPulgada("txtPrecioPagina"+oId);

	});

}


function GenerarMaterialEdicion(oId,Material)
{
	
	if (oId != undefined)
	{	
		
		$.post("application/controllers/MaterialController.php?action=Lista_Material_Edicion",	
		function(data) {

			$("#lstMaterialImpresion" + oId).find('option').remove().end().append('<option value="">Seleccione el Material</option>');
			$("#lstMaterialImpresion" + oId).append(data);	
			
			$("#lstMaterialImpresion" + oId + " option[value=" + Material + "]").attr("selected",true);
		});
	}
	else
	{	
		$.post("application/controllers/MaterialController.php?action=Lista_Material_Edicion",	
		function(data) {

		
			$("#lstMaterial").find('option').remove().end().append('<option value="">Seleccione el Material</option>');
			$("#lstMaterial").append(data);		

		});
	}
}

function Listar_Materiales(id)
{
	id = (id == undefined) ? '' : id;
	
	$.post("application/controllers/MaterialController.php?action=Listar_Materiales",
	{
		IdMaterial:id
	},
	function(data){
		$("#Listar_Materiales").html(data);
		
		oTable = $('.dTable').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": true,
			"iDisplayLength": 10,
			"sDom": '<""l>t<"F"fp>'
		});		
		
		//$("[name='hdnSeleccionar[]").val($("[name='chkSeleccionar[]']").val());
		var c = 1;
		while (c < ($("[name='chkSeleccionar[]']").length + 1))
		{
			$("#hdnSeleccionar" + c).val($("#chkSeleccionar" + c + ":checked").val());		
		
			//alert($("#hdnSeleccionar" + c).val());
			c++;
		}
		
		if (id != undefined)
		{		
			$("[name='txtPrecioPulgada[]']").keydown(function(event){
				//alert(event.keyCode);
				if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
					return true;
				}
				else
				{
					return false;
				}
			});

			$("[name='txtPrecioPagina[]']").keydown(function(event){
				//alert(event.keyCode);
				if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
					return true;
				}
				else
				{
					return false;
				}
			});	
			
			$("[name='txtPrecioPulgada[]']").change(function(){

				var oId = $(this).attr('id');
				oId = oId.substr(16);	

				DecimalesPulgada('txtPrecioPulgada'+oId);

				Calcular_Precio_Material_Pagina(oId,$("#txtPrecioPulgada"+oId).val(),$("#hdnIdCampos_"+oId).val());
				
				
				
			});
			
			$("[name='txtPrecioPagina[]']").change(function(){

				var oId = $(this).attr('id');
				oId = oId.substr(15);	

				DecimalesPulgada('txtPrecioPagina'+oId);
				
				Calcular_Precio_Material_Pulgada(oId,$("#txtPrecioPagina"+oId).val(),$("#hdnIdCampos_"+oId).val());			
			});		
			

			$("[name='chkSeleccionar[]']").change(function(){
				var oId = $(this).attr('id');
				oId = oId.substr(14);			

				$("#hdnSeleccionar" + oId).val($("#chkSeleccionar" + oId + ":checked").val());
			});
		
		
		
		}
	});
}
 
 function Agregar_Material()
{

	var cant_seleccionada = 0;
	var arrSeleccionar = new Array();
	arrSeleccionar = $("[name='hdnSeleccionar[]']");
	var ArrSeleccionar = [];
	for (var i = 0; i < arrSeleccionar.length; ++i) {
		ArrSeleccionar[i] = arrSeleccionar[i].value;
		if (ArrSeleccionar[i] == 1)
		cant_seleccionada++;
	}
	
	if(cant_seleccionada > 0)
	{
		$('#loading').css("visibility","visible");
		$('#main_content').css("opacity",0.5);		
		
		StrSeleccionar = JSON.stringify(ArrSeleccionar);	
		
		var arrPrecioPulgada = new Array();
		arrPrecioPulgada = $("[name='txtPrecioPulgada[]']");
		var ArrPrecioPulgada = [];
		for (var i = 0; i < arrPrecioPulgada.length; ++i) {
			ArrPrecioPulgada[i] = arrPrecioPulgada[i].value;
		}

		StrPrecioPulgada = JSON.stringify(ArrPrecioPulgada);
		
		var arrPrecioPagina= new Array();
		arrPrecioPagina = $("[name='txtPrecioPagina[]']");
		var ArrPrecioPagina = [];
		for (var i = 0; i < arrPrecioPagina.length; ++i) {
			ArrPrecioPagina[i] = arrPrecioPagina[i].value;
		}

		StrPrecioPagina = JSON.stringify(ArrPrecioPagina);
		
		var arrIdTamano= new Array();
		arrIdTamano = $("[name='hidIdTamano[]']");
		var ArrIdTamano = [];
		for (var i = 0; i < arrIdTamano.length; ++i) {
			ArrIdTamano[i] = arrIdTamano[i].value;
		}

		StrIdTamano = JSON.stringify(ArrIdTamano);	
		
		$.post("application/controllers/MaterialController.php?action=Agregar_Material",
		{
			PrecioPulgada:StrPrecioPulgada,
			PrecioPagina:StrPrecioPagina,
			IdTamano:StrIdTamano,
			Seleccionar:StrSeleccionar,
			NombreMaterial:$("#txtNombreMaterial").val()
		},
		function(data){
		 
			if (data)
			{
				Sexy.info("Se ha guardado exit&oacute;samente el Material", {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('listar_materiales');
					}
				});			

				
			}
			else if (!data)
			Sexy.error("Error guardar el Material");
			
			$('#loading').css("visibility","hidden");
			$('#main_content').css("opacity",1);				

		});	
	}
	else
	{
		Sexy.error("Debes seleccionar al menos un de los Tama&ntilde;os en la Lista.");	
	}
	
}


function Cancelar_Agregar_Material()
{

	Sexy.confirm('Deseas Regresar al Listado de Materiales?.<br />Pulsa &quot;Ok&quot; para continuar, o pulsa &quot;Cancelar&quot; para salir.', {onComplete: 
		function(returnvalue) { 
			if(returnvalue)
			{
				Sexy.info('Datos ingresados no se guardar&aacute;n', {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('listar_materiales');
					}
				});			
			}

		}
	});
}

function Editar_Material(oId)
{

	//Cargar_Librerias();
	
	//$.getScript("js/custom-tables.js");
	$.getScript("js/custom-mask.js");	
	//$.getScript("js/funciones.js");	
	
	var DescripcionMaterial = $("#hidDescripcionMaterial" + oId).val();
	var DescripcionTamano = $("#hidDescripcionTamano" + oId).val();	
	var PrecioPulgada = $("#hidPrecioPulgada" + oId).val();
	var PrecioPagina = $("#hidPrecioPagina" + oId).val();

	var IdMaterial = $("#hdnIdCamposM_" + oId).val();
	var IdTamano = $("#hdnIdCamposT_" + oId).val();

		
	//alert(RUC.length);
	var strHtml0 = "<td  align=\"center\">" +  oId + '</td>';		
		strHtml0 += '<td>' + DescripcionMaterial +'<input type="hidden" id="hidDescripcionMaterial' + oId + '" name="hidDescripcionMaterial[]" value="'+ DescripcionMaterial +'"  /></td>';
	var strHtml1 = '<td>' +  DescripcionTamano + '<input type="hidden" id="hidDescripcionTamano' + oId + '" name="hidDescripcionTamano[]" value="'+ DescripcionTamano +'"  /></td>';		
	var strHtml2 = "<td>" + '<input type="text" id="txtPrecioPulgada' + oId + '" name="txtPrecioPulgada[]" value="'+ PrecioPulgada +'"  class="validate[required]"  style="width:95%;" onchange="DecimalesPulgada(\'txtPrecioPulgada' + oId + '\');"/><input type="hidden" id="hidPrecioPulgada' + oId + '" name="hidPrecioPulgada[]" value="'+ PrecioPulgada +'"/></td>';	
	var strHtml3 = "<td>" + '<input type="text" id="txtPrecioPagina' + oId + '" name="txtPrecioPagina[]" value="'+ PrecioPagina +'"  class="validate[required]"  style="width:95%;" onchange="DecimalesPulgada(\'txtPrecioPagina' + oId + '\');"/><input type="hidden" id="hidPrecioPagina' + oId + '" name="hidPrecioPagina[]" value="'+ PrecioPagina +'"  /></td>';		

	var strHtml4 = '<td><a href="javascript:void(0);" title="Guardar" class="smallButton" style="margin: 5px;" onclick="Guardar_Material(' + oId + ')"><img src="public/images/icons/light/check.png" alt="" class="icon" /><span></span></a>';
	strHtml4 += '<a href="javascript:void(0);" title="Cancelar" class="smallButton" style="margin: 5px;" onclick="Cancelar_Guardar_Material(' + oId + ')"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
	strHtml4 += '<input type="hidden" id="hdnIdCamposM_' + oId +'" name="hdnIdCamposM[]" value="' + IdMaterial + '" /><input type="hidden" id="hdnIdCamposT_' + oId +'" name="hdnIdCamposT[]" value="' + IdTamano + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4;
	$("#tbDetalle").append(strHtmlTr);
	//si se agrega el HTML de una sola vez se debe comentar la linea siguiente.
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	
	//alert(oId);
	//$("#lstTipoCategoria" + oId + " option[value="+TipoCategoria+"]").attr("selected",true);
	
		$("#txtPrecioPulgada"+oId).keydown(function(event){
			//alert(event.keyCode);
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});

		$("#txtPrecioPagina"+oId).keydown(function(event){
			//alert(event.keyCode);
			if(event.keyCode == 110 || event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || (event.keyCode >= 48 && event.keyCode <= 57 ) || (event.keyCode >= 95 && event.keyCode <= 105 )){
				return true;
			}
			else
			{
				return false;
			}
		});	
		
		$("#txtPrecioPulgada"+oId).change(function(){

			DecimalesPulgada('txtPrecioPulgada'+oId);

			Calcular_Precio_Material_Pagina(oId,$("#txtPrecioPulgada"+oId).val(),$("#hdnIdCamposT_"+oId).val());
			
			
			
		});
		
		$("#txtPrecioPagina"+oId).change(function(){

			DecimalesPulgada('txtPrecioPagina'+oId);
			
			Calcular_Precio_Material_Pulgada(oId,$("#txtPrecioPagina"+oId).val(),$("#hdnIdCamposT_"+oId).val());			
		});		
	
	
	return false;

}

function Guardar_Material(oId)
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);

	var IdMat = $("#hdnIdCamposM_" + oId).val();
	var IdTam = $("#hdnIdCamposT_" + oId).val();

	$.post("application/controllers/MaterialController.php?action=Actualizar_Material",
	{
		PrecioPulgada:$("#txtPrecioPulgada" + oId).val(),
		PrecioPagina:$("#txtPrecioPagina" + oId).val(),
		IdMaterial:IdMat,
		IdTamano:IdTam		
		
	}, function(data){

		
		if (data)
		{
			Sexy.info("Se han guardado exit&oacute;samente los Datos", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_materiales');
				}
			});
		}
		else if (!data)
		Sexy.error("Error guardar los Datos");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	})
}

function Cancelar_Guardar_Material(oId)
{
	var DescripcionMaterial = $("#hidDescripcionMaterial" + oId).val();
	var DescripcionTamano = $("#hidDescripcionTamano" + oId).val();		
	var PrecioPulgada = $("#hidPrecioPulgada" + oId).val();	
	var PrecioPagina = $("#txtPrecioPagina" + oId).val();
		
	var IdMaterial = $("#hdnIdCamposM_" + oId).val();
	var IdTamano = $("#hdnIdCamposT_" + oId).val();

	var strHtml0 = "<td  align=\"center\">" +  oId + '</td>';		
		strHtml0 += "<td>" + DescripcionMaterial + '<input type="hidden" id="hidDescripcionMaterial' + oId + '" name="hidDescripcionMaterial[]" value="'+ DescripcionMaterial +'"  /></td>';	
	var strHtml1 = "<td>" + DescripcionTamano + '<input type="hidden" id="hidDescripcionTamano' + oId + '" name="hidDescripcionTamano[]" value="'+ DescripcionTamano +'"/></td>';	
	var strHtml2 = "<td>" + PrecioPulgada + '<input type="hidden" id="hidPrecioPulgada' + oId + '" name="hidPrecioPulgada[]" value="'+ PrecioPulgada +'"/></td>';	
	var strHtml3 = "<td>" + PrecioPagina + '<input type="hidden" id="hidPrecioPagina' + oId + '" name="hidPrecioPagina[]" value="'+ PrecioPagina +'"  /></td>';		
	var strHtml4 = '<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Material(' + oId + ')"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
	strHtml4 += '<input type="hidden" id="hdnIdCamposM_' + oId +'" name="hdnIdCamposM[]" value="' + IdMaterial + '" /><input type="hidden" id="hdnIdCamposT_' + oId +'" name="hdnIdCamposT[]" value="' + IdTamano + '" /></td>';

	var strHtmlTr = "<tr id='rowDetalle_" + oId + "'  valign=\"top\"></tr>";
	var strHtmlFinal = strHtml0 + strHtml1 + strHtml2 + strHtml3 + strHtml4;
	$("#tbDetalle").append(strHtmlTr);
	//si se agrega el HTML de una sola vez se debe comentar la linea siguiente.
	$("#rowDetalle_" + oId).html(strHtmlFinal);
	return false;
}

function Cancelar_Actualizar_Material()
{

	Sexy.confirm('Deseas Regresar al Listado de Materiales?.<br />Pulsa &quot;Ok&quot; para continuar, o pulsa &quot;Cancelar&quot; para salir.', {onComplete: 
		function(returnvalue) { 
			if(returnvalue)
			{
				Sexy.info('Datos actualizados no se guardar&aacute;n', {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('listar_materiales');
					}
				});			
			}

		}
	});
}


function Actualizar_Material()
{
	var cant_seleccionada = 0;
	var arrSeleccionar = new Array();
	arrSeleccionar = $("[name='hdnSeleccionar[]']");
	var ArrSeleccionar = [];
	for (var i = 0; i < arrSeleccionar.length; ++i) {
		ArrSeleccionar[i] = arrSeleccionar[i].value;
		if (ArrSeleccionar[i] == 1)
		cant_seleccionada++;
	}
	

	if(cant_seleccionada > 0)
	{
		$('#loading').css("visibility","visible");
		$('#main_content').css("opacity",0.5);		
		
		//StrExentoITBM = ArrExentoITBM.toString();	
		StrSeleccionar = JSON.stringify(ArrSeleccionar);	
		//alert(StrSeleccionar);
		//alert(StrPrecioPagina);	
		
		var arrPrecioPulgada = new Array();
		arrPrecioPulgada = $("[name='txtPrecioPulgada[]']");
		var ArrPrecioPulgada = [];
		for (var i = 0; i < arrPrecioPulgada.length; ++i) {
			ArrPrecioPulgada[i] = arrPrecioPulgada[i].value;
		}

		StrPrecioPulgada = JSON.stringify(ArrPrecioPulgada);
		
		var arrPrecioPagina= new Array();
		arrPrecioPagina = $("[name='txtPrecioPagina[]']");
		var ArrPrecioPagina = [];
		for (var i = 0; i < arrPrecioPagina.length; ++i) {
			ArrPrecioPagina[i] = arrPrecioPagina[i].value;
		}

		StrPrecioPagina = JSON.stringify(ArrPrecioPagina);
		
		var arrIdTamano= new Array();
		arrIdTamano = $("[name='hidIdTamano[]']");
		var ArrIdTamano = [];
		for (var i = 0; i < arrIdTamano.length; ++i) {
			ArrIdTamano[i] = arrIdTamano[i].value;
		}

		StrIdTamano = JSON.stringify(ArrIdTamano);	
		console.log("StrIdTamano ->>> ",StrIdTamano);

		$.post("application/controllers/MaterialController.php?action=Actualizar_Material",
		{	
			PrecioPulgada:StrPrecioPulgada,
			PrecioPagina:StrPrecioPagina,
			IdTamano:StrIdTamano,
			Seleccionar:StrSeleccionar,
			IdMaterial:$("#lstMaterial").val()	
			
		}, function(data){

			//alert(data);
			if (data)
			{
				Sexy.info("Se han guardado exit&oacute;samente los Datos", {
				onComplete:function (returnvalue) {
					window.location.href='admin.php?sec='+btoa('listar_materiales');
					}
				});			
			}
			else if (!data)
			Sexy.error("Error guardar los Datos");
			
			$('#loading').css("visibility","hidden");
			$('#main_content').css("opacity",1);		
		});	
	}
	else
	{
		Sexy.error("Debes seleccionar al menos un de los Tama&ntilde;os en la Lista.");	
	}
	

}

function Eliminar_Material(oId)
{
	$('#loading').css("visibility","visible");
	$('#main_content').css("opacity",0.5);

	var IdMat = $("#hdnIdCamposM_" + oId).val();

	$.post("application/controllers/MaterialController.php?action=Eliminar_Material",
	{
		IdMaterial:IdMat	
	}, function(data){

		
		if (data=="true")
		{
			Sexy.info("Se ha eliminado exit&oacute;samente el Material", {
			onComplete:function (returnvalue) {
				window.location.href='admin.php?sec='+btoa('listar_materiales');
				}
			});			
		}
		else if (data=="false")
		Sexy.error("Error eliminar el Material");
		
		$('#loading').css("visibility","hidden");
		$('#main_content').css("opacity",1);		
	})
}
