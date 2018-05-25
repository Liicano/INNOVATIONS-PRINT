			<!-- Main content wrapper -->
			<div class="wrapper">
				<!-- Note -->
				<div class="nNote nInformation hideit">
					<p>
						<strong>INFORMACI&Oacute;N: </strong>Llenar los campos correspondiente para Agregar Usuario
					</p>
				</div>
				<!-- Validation form -->
				<form id="validate" class="form" method="post" action="javascript:Agregar_Usuario()">
					<fieldset>
						<div class="widget">
							<div class="title">
								<img src="images/icons/dark/alert.png" alt="" class="titleIcon"/>
								<h6>Llenar todos los campos para Agregar Usuario</h6>
							</div>
							<div class="formRow">
								<label>Nombre:<span class="req">*</span></label>
								<div class="formRight">
									<input type="text" value="" class="validate[required,custom[onlyLetterSp]]" name="txtNombreUsuario" id="txtNombreUsuario"/>
								</div>
								<div class="clear">
								</div>
							</div>
							<div class="formRow">
								<label>Apellido:<span class="req">*</span></label>
								<div class="formRight">
									<input type="text" value="" class="validate[required,custom[onlyLetterSp]]" name="txtApellidoUsuario" id="txtApellidoUsuario"/>
								</div>
								<div class="clear">
								</div>
							</div>
							<div class="formRow">
								<label>Nombre de Usuario:<span class="req">*</span></label>
								<div class="formRight">
									<input type="text" value="" class="validate[required]" name="txtUsuario" id="txtUsuario"/>
								</div>
								<div class="clear">
								</div>
							</div>
							<div class="formRow">
								<label>Clave de Usuario:<span class="req">*</span></label>
								<div class="formRight">
									<input type="password" value="" class="validate[required]" name="txtClave" id="txtClave" onchange="this.value=calcMD5(this.value)"/>
								</div>
								<div class="clear">
								</div>
							</div>					
							<div class="formRow">
								<label>Descripci&oacute;n del Usuario:</label>
								<div class="formRight">
									<textarea rows="4" cols="" name="txtDescripcionUsuario" id="txtDescripcionUsuario" class="autoGrow"></textarea>
								</div>
								<div class="clear">
								</div>
							</div>
							<div class="formRow">
								<label>Tipo de Usuario:<span class="req">*</span></label>
								<div class="formRight">
									<div class="floatL">
										<select name="lstTipoUsuario" id="lstTipoUsuario" class="validate[required]">
											<option value="">Seleccione el Tipo de Usuario</option>
										</select>
									</div>
								</div>
								<div class="clear">
								</div>
							</div>					
							<div class="formRow">
								<label>Estatus:<span class="req">*</span></label>
								<div class="formRight">
									<div class="floatL">
										<select name="lstEstatusUsuario" id="lstEstatusUsuario" class="validate[required]">
											<option value="">Seleccione el Estatus del Usuario</option>
										</select>
									</div>
								</div>
								<div class="clear">
								</div>
							</div>					
							<div class="formSubmit">
								<input type="submit" value="Agregar Usuario" class="redB"/>
							</div>
							<div class="clear">
							</div>
						</div>
					</fieldset>
				</form>
			</div>