	<!-- Main content wrapper -->
	<div class="wrapper">
		<!-- Note -->
		<div class="nNote nInformation hideit">
			<p>
				<strong>INFORMACI&Oacute;N: </strong>Llenar los campos correspondiente para Agregar Productos
			</p>
		</div>
		<!-- Validation form -->
		<form id="validate" class="form" method="post" action="javascript:Actualizar_Producto('<?php echo $_GET['id']?>')">
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="public/images/icons/dark/alert.png" alt="" class="titleIcon"/>
						<h6>Llenar todos los campos para Editar Producto</h6>
					</div>
					<div class="formRow">
						<label>Tipo de Producto:<span class="req">*</span></label>
						<div class="formRight">
							<div class="floatL" id="TipoCliente" >
								<select name="lstTipoProducto" id="lstTipoProducto" class="validate[required]">
									<option value="">Seleccione el Tipo de Producto</option>
								</select>
							</div>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="NombreProducto">
						<label>Nombre de Producto:<span class="req">*</span></label>
						<div class="formRight">
							<textarea rows="1" cols="" value="" class="validate[required]" name="txtNombreProducto" id="txtNombreProducto"/></textarea>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="CodigoProducto">
						<label>C&oacute;digo del Producto:</label>
						<div class="formRight">
							<input type="text" name="txtCodigoProducto" id="txtCodigoProducto" readonly="readonly"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="CodigoBarra">
						<label>C&oacute;digo de Barra:</label>
						<div class="formRight">
							<input type="text" name="txtCodigoBarra" class="validate[required]" id="txtCodigoBarra" />
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="DescripcionProducto">
						<label>Descripci&oacute;n del Producto:</label>
						<div class="formRight">
							<textarea rows="4" cols="" name="txtDescripcionProducto" id="txtDescripcionProducto" class="autoGrow"></textarea>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="Tipo">
						<label>Tipo:</label>
						<div class="formRight">
							<input type="text" value="" name="txtTipo" id="txtTipo"/>
							<input type="hidden" name="hidTipo" id="hidTipo"/>
						</div>
						<div class="clear">
						</div>
					</div>	
					<div class="formRow" id="Marca">
						<label>Marca:</label>
						<div class="formRight">
							<input type="text" value="" name="txtMarca" id="txtMarca"/>
							<input type="hidden" name="hidMarca" id="hidMarca"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="Modelo">
						<label>Modelo:</label>
						<div class="formRight">
							<input type="text" value="" name="txtModelo" id="txtModelo"/>
							<input type="hidden" name="hidModelo" id="hidModelo"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="Color">
						<label>Color:</label>
						<div class="formRight">
							<input type="text" value="" name="txtColor" id="txtColor"/>
							<input type="hidden" name="hidColor" id="hidColor"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="Tamano">
						<label>Tama&ntilde;o:</label>
						<div class="formRight">
							<input type="text" value="" name="txtTamano" id="txtTamano"/>
							<input type="hidden" name="hidTamano" id="hidTamano"/>
						</div>
						<div class="clear">
						</div>
					</div>					
					<div class="formRow" id="Costo">
						<label>Costo:</label>
						<div class="formRight">
							<input type="text" value="0.00" class="validate[custom[number]]" name="txtCosto" id="txtCosto" onchange="PrecioMoneda('txtCosto');"/>
						</div>
						<div class="clear">
						</div>
					</div>
				
					<div class="formRow" id="TipoCategoria">
						<label for="labelFor">Categor&iacute;a:</label>
						<div class="formRight">
							<div class="floatL">
								<select name="lstTipoCategoria" id="lstTipoCategoria" class="">
									<option value="0">Seleccione el Tipo de Categor&iacute;a</option>
								</select>
							</div>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="Ubicacion">
						<label for="labelFor">Ubicaci&oacute;n:</label>
						<div class="formRight">
							<div class="floatL">
								<select name="lstUbicacion" id="lstUbicacion" class="validate[required]">
									<option value="0">Seleccione la Ubicaci&oacute;n</option>
								</select>
							</div>
						</div>
						<div class="clear">
						</div>
					</div>						
					<div class="formRow" id="PrecioVenta">
						<label>Precio de Venta:</label>
						<div class="formRight">
							<input type="text" value="0.00" class="validate[custom[number]]" name="txtPrecioVenta" id="txtPrecioVenta" readonly="readonly" />
						</div>
						<div class="clear">
						</div>
					</div>						
					<div class="formRow" id="TipoPaquete">
						<label for="labelFor">Tipo de Paquete:</label>
						<div class="formRight">
							<div class="floatL">
								<select name="lstTipoPaquete" id="lstTipoPaquete" class="validate[required]">
									<option value="0">Seleccione el Tipo de Paquete</option>
								</select>
							</div>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="CantExistInicial">
						<label>Cantidad en Existencia Inicial:</label>
						<div class="formRight">
							<input type="text" value="" class="validate[custom[onlyNumberSp]]" name="txtCantExistInicial" id="txtCantExistInicial" readonly="readonly"/>
						</div>
						<div class="clear">
						</div>
					</div>					
					<div class="formRow" id="CantMin">
						<label>Cantidad M&iacute;nima:</label>
						<div class="formRight">
							<input type="text" value="" class="validate[custom[onlyNumberSp]]" name="txtCantMin" id="txtCantMin"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="ObservacionProducto">
						<label>Notas del Producto:</label>
						<div class="formRight">
							<textarea rows="4" cols="" name="txtObservacionProducto" id="txtObservacionProducto" class="autoGrow"></textarea>
						</div>
						<div class="clear">
						</div>
					</div>					
					<div class="formSubmit">
						<input type="submit" value="Editar Producto" class="redB"/>
						<input type="button" value="Cancelar Editar Producto" class="redB" onclick="Cancelar_Agregar_Producto()"/>
					</div>
					<div class="clear">
					</div>
				</div>
			</fieldset>
		</form>
	</div>