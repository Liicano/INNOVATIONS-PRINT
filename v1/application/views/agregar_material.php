	<!-- Main content wrapper -->
	<div class="wrapper">
		<!-- Note -->
		<div class="nNote nInformation hideit">
			<p>
				<strong>INFORMACI&Oacute;N: </strong>Llenar los campos correspondiente para Agregar Material
			</p>
		</div>
		<!-- Validation form -->
		<form id="validate" class="form" method="post" action="javascript:Agregar_Material()">
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="public/images/icons/dark/alert.png" alt="" class="titleIcon"/>
						<h6>Llenar todos los campos para Agregar Material</h6>
					</div>
					<div class="formRow">
						<label>Nombre de Material:<span class="req">*</span></label>
						<div class="formRight">
							<input type="text" value="" class="validate[required]" name="txtNombreMaterial" id="txtNombreMaterial"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<input type="checkbox" name="chkCalcularPliego" id="chkCalcularPliego" /><label for="chkCalcularPliego">Calcular Precio de Pliego</label>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="TamanoAncho">
						<label>Tama&ntildeo del Pliego - Ancho:<span class="req">*</span></label>
						<div class="formRight">
							<input type="text" value="0.00" class="validate[required]" name="txtTamanoAncho" id="txtTamanoAncho" onchange="PrecioMoneda('txtTamanoAncho');" />
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="TamanoLargo">
						<label>Tama&ntildeo del Pliego - Largo:<span class="req">*</span></label>
						<div class="formRight">
							<input type="text" value="0.00" class="validate[required]" name="txtTamanoLargo" id="txtTamanoLargo" onchange="PrecioMoneda('txtTamanoLargo');" />
						</div>
						<div class="clear">
						</div>
					</div>					
					<div class="formRow" id="Precio">
						<label>Precio:<span class="req">*</span></label>
						<div class="formRight">
							<input type="text" value="0.00" class="validate[required]" name="txtPrecioPliego" id="txtPrecioPliego" onchange="PrecioMoneda('txtPrecioPliego');"/>
						</div>
						<div class="clear">
						</div>
					</div>					
				</div>
				<div class="widget">
					<div class="title"><img src="public/images/icons/dark/full2.png" alt="" class="titleIcon" /><h6><span id="Tipo1">Listado de Tama&ntilde;o de P&aacute;gina</span></h6></div>                          
            
					<div id="Listado_Tamano_Pagina">
					<!-- cargar Listado de Ventas Rapidas -->
					</div>
				</div>
				<div class="widget">
					<div class="formSubmit">
						<input type="submit" value="Agregar Material" class="redB"/>
						<input type="button" value="Cancelar Agregar Material" class="redB" onclick="Cancelar_Agregar_Material()"/>
					</div>
					<div class="clear">
					</div>					
				</div>	
			</fieldset>
		</form>
	</div>