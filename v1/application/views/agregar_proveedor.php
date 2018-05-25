	<!-- Main content wrapper -->
	<div class="wrapper">
		<!-- Note -->
		<div class="nNote nInformation hideit">
			<p>
				<strong>INFORMACI&Oacute;N: </strong>Llenar los campos correspondiente para Agregar Proveedor
			</p>
		</div>
		<!-- Validation form -->
		<form id="validate" class="form" method="post" action="javascript:Agregar_Proveedor()">
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="public/images/icons/dark/alert.png" alt="" class="titleIcon"/>
						<h6>Llenar todos los campos para Agregar Proveedor</h6>
					</div>
					<div class="formRow">
						<label>Nombre de Proveedor:<span class="req">*</span></label>
						<div class="formRight">
							<input type="text" value="" class="validate[required]" name="txtNombreProveedor" id="txtNombreProveedor"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label>RUC:</label>
						<div class="formRight">
							<input type="text" value="" class="validate[custom[onlyNumberSp]]" name="txtRUC1" id="txtRUC1" maxlength="10" style="width:20%"/> &nbsp;-&nbsp;<input type="text" value="" class="validate[custom[onlyNumberSp]]" name="txtRUC2" id="txtRUC2" maxlength="4" style="width:20%"/> &nbsp;-&nbsp;<input type="text" value="" class="validate[custom[onlyNumberSp]]" name="txtRUC3" id="txtRUC3" maxlength="7" style="width:20%"/>&nbsp;&nbsp;DV&nbsp;<input type="text" value="" class="validate[custom[onlyNumberSp]]" name="txtDV" id="txtDV" maxlength="2" style="width:5%"/><span class="formNote">9999999999-9999-9999999 DV 99</span>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label>Correo Electr&oacute;nico:</label>
						<div class="formRight">
							<input type="text" value="" class="validate[custom[email]]" name="txtEmail" id="txtEmail"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label for="labelFor">Tel&eacute;fono:</label>
						<div class="formRight">
							<input type="text" class="maskTelefono" value="" name="txtTelefono" id="txtTelefono"/><span class="formNote">999-9999</span>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label for="labelFor">Celular:</label>
						<div class="formRight">
							<input type="text" class="maskCelular" value="" name="txtCelular" id="txtCelular"/><span class="formNote">9999-9999</span>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label for="labelFor">Fax:</label>
						<div class="formRight">
							<input type="text" class="maskTelefono" value="" name="txtFax" id="txtFax"/><span class="formNote">999-9999</span>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label>Direcci&oacute;n:</label>
						<div class="formRight">
							<input type="text" class="" name="txtDireccion" id="txtDireccion"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label>Nombre del Vendedor:</label>
						<div class="formRight">
							<input type="text" value="" class="validate[custom[onlyLetterSp]]" name="txtNombreVendedor" id="txtNombreVendedor"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label>Celular del Vendedor:</label>
						<div class="formRight">
							<input type="text" value="" class="maskCelular" name="txtCelularVendedor" id="txtCelularVendedor"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label>Correo Electr&oacute;nico del Vendedor:</label>
						<div class="formRight">
							<input type="text" value="" class="validate[custom[email]]" name="txtEmailVendedor" id="txtEmailVendedor"/>
						</div>
						<div class="clear">
						</div>
					</div>					
					<div class="formSubmit">
						<input type="submit" value="Agregar Proveedor" class="redB"/>
						<input type="button" value="Cancelar Agregar Proveedor" class="redB" onclick="Cancelar_Agregar_Proveedor()"/>
					</div>
					<div class="clear">
					</div>
				</div>
			</fieldset>
		</form>
	</div>