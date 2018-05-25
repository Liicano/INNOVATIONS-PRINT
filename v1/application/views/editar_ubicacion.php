	<!-- Main content wrapper -->
	<div class="wrapper">
		<!-- Note -->
		<div class="nNote nInformation hideit">
			<p>
				<strong>INFORMACI&Oacute;N: </strong>Llenar los campos correspondiente para Agregar Ubicaci&oacute;n
			</p>
		</div>
		<!-- Validation form -->
		<form id="validate" class="form" method="post" action="javascript:Actualizar_Ubicacion('<?php echo $_GET['id']?>')">
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="public/images/icons/dark/alert.png" alt="" class="titleIcon"/>
						<h6>Llenar todos los campos para Agregar Ubicaci&oacute;n</h6>
					</div>
					<div class="formRow">
						<label>Descricpci&oacute;n:</label>
						<div class="formRight">
							<input type="text" value="" class="validate[required]" name="txtDescripcion" id="txtDescripcion" style="width:80%"/>
						</div>
						<div class="clear">
						</div>			
					</div>
					<div class="formRow">
						<label for="labelFor">Tienda:</label>
						<div class="formRight">
							<div class="floatL">
								<select name="lstTienda" id="lstTienda" class="validate[required]">
									<option value="0">Seleccione la Tienda</option>
								</select>
							</div>
						</div>
						<div class="clear">
						</div>
					</div>						
					<div class="formSubmit" id="ActualizarUbicacion">
						<input type="submit" value="Agregar Ubicaci&oacute;n" class="redB"/>&nbsp;&nbsp;
						<input type="button" value="Cancelar Agregar Ubicaci&oacute;n" class="redB" onclick="Cancelar_Actualizar_Ubicacion()"/>
					</div>
					<div class="clear">
					</div>
				</div>			
			</fieldset>
		</form>
	</div>