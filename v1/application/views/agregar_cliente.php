	<!-- Main content wrapper -->
	<div class="wrapper">
		<!-- Note -->
		<div class="nNote nInformation hideit">
			<p>
				<strong>INFORMACI&Oacute;N: </strong>Llenar los campos correspondiente para Agregar Clientes
			</p>
		</div>
		<!-- Validation form -->
		<form id="validate" class="form" method="post" enctype="multipart/form-data" action="javascript:Agregar_Cliente()">
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="public/images/icons/dark/alert.png" alt="" class="titleIcon"/>
						<h6>Seleccione el Tipo de Cliente de la Lista de Selecci&oacute;n</h6>
					</div>
					<div class="formRow">
						<label>Tipo de Cliente:<span class="req">*</span></label>
						<div class="formRight">
							<div class="floatL" id="TipoCliente" >
								<select name="lstTipoCliente" id="lstTipoCliente" class="validatevalidate[required]">
									<option value="">Seleccione el Tipo de Cliente</option>
								</select>
							</div>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="NombreCliente">
						<label>Nombre:<span class="req">*</span></label>
						<div class="formRight">
							<input type="text" value="" class="validate[required]" name="txtNombreCliente" id="txtNombreCliente"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="ApellidoCliente">
						<label>Apellido:<span class="req">*</span></label>
						<div class="formRight">
							<input type="text"  class="validate[required]" name="txtApellidoCliente" id="txtApellidoCliente"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="NombreEmpresa">
						<label>Nombre de Empresa:<span class="req">*</span></label>
						<div class="formRight">
							<input type="text"  class="validate[required]" name="txtNombreEmpresa" id="txtNombreEmpresa"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="RUCEmpresa">
						<label>RUC:</label>
						<div class="formRight">
							<input type="text"  class="validate[custom[onlyNumberSp]]" name="txtRUC1" id="txtRUC1" maxlength="10" style="width:20%"/> &nbsp;-&nbsp;<input type="text"  class="validate[custom[onlyNumberSp]]" name="txtRUC2" id="txtRUC2" maxlength="4" style="width:20%"/> &nbsp;-&nbsp;<input type="text"  class="validate[custom[onlyNumberSp]]" name="txtRUC3" id="txtRUC3" maxlength="7" style="width:20%"/>&nbsp;&nbsp;DV&nbsp;<input type="text"  class="validate[custom[onlyNumberSp]]" name="txtDV" id="txtDV" maxlength="2" style="width:5%"/><span class="formNote">9999999999-9999-9999999 DV 99</span>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label>Correo Electr&oacute;nico:</label>
						<div class="formRight">
							<input type="text"  class="validate[custom[email]]" name="txtEmail" id="txtEmail"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label for="labelFor">Tel&eacute;fono:</label>
						<div class="formRight">
							<input type="text" class="maskTelefono"  name="txtTelefono" id="txtTelefono"/><span class="formNote">999-9999</span>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label for="labelFor">Celular:</label>
						<div class="formRight">
							<input type="text" class="maskCelular"  name="txtCelular" id="txtCelular"/><span class="formNote">9999-9999</span>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label>Direcci&oacute;n:</label>
						<div class="formRight">
							<input type="text" class=""  name="txtDireccion" id="txtDireccion"/>
						</div>
						<div class="clear">
						</div>
					</div>

					<div class="formRow" id="LogoEmpresa">
					<label>Cargar Logotipo: </label>
						<div class="formRight">
							<input type="file" class="" name="file" id="file" style="width: 30%" />
						</div>	
						<div class="clear">
						</div>
					</div>

					<div class="formRow" id="NombreContacto">
						<div class="widget">
							<div class="title">
								<img src="public/images/icons/dark/frames.png" alt="" class="titleIcon"/>
								<h6></h6>
							</div>
							<table cellpadding="0" cellspacing="0" width="100%" class="sTable" id="tblDetalle">
							<thead>
							<tr align="center">
								<td width="5%">
									<a href="javascript:void(0);" title="" class="smallButton" style="margin: 5px;"><img src="public/images/icons/color/plus.png" alt="" onclick="Agregar_Contacto()"/></a>
								</td>
								<td width="40%">
									Nombre de Contacto<input type="hidden" id="num_campos" name="num_campos" />
								</td>
								<td width="10%">
									Tel&eacute;fono del Contacto<input type="hidden" id="cant_campos" name="num_campos" value=""/>
								</td>
								<td width="10%">
									Celular del Contacto
								</td>
								<td width="10%">
									Correo Electr&oacute;nico del Contacto
								</td>
								<td width="10%">
									Opciones
								</td>
							</tr>
							</thead>
							<tbody id="tbDetalle">
							</tbody>
							</table>
						</div>
					</div>
					<div class="formRow">
						<label>Cr&eacute;dito:<span class="req">*</span></label>
						<div class="formRight">
							<div class="floatL" style="margin: 2px 0 0 0;">
								<input type="radio" id="rdbCredito1" name="rdbCredito" value="1" class="validate[required]" data-prompt-position="topRight:102"/><label for="radioReq">S&iacute;</label>
							</div>
							<div class="floatL" style="margin: 2px 0 0 0;">
								<input type="radio" id="rdbCredito2" name="rdbCredito" value="0" class="validate[required]" data-prompt-position="topRight:102"/><label for="radioReq">No</label>
							</div>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formSubmit">
						<input type="submit" value="Agregar Cliente" class="redB"/>
						<input type="button" value="Cancelar Agregar Cliente" class="redB" onclick="Cancelar_Agregar_Cliente()"/>
					</div>
					<div class="clear">
					</div>
				</div>
			</fieldset>
		</form>
	</div>