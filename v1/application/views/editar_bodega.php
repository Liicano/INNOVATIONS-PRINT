	<!-- Main content wrapper -->
	<div class="wrapper">
		<!-- Note -->
		<div class="nNote nInformation hideit">
			<p>
				<strong>INFORMACI&Oacute;N: </strong>Llenar los campos correspondiente para Editar Bodega
			</p>
		</div>
		<!-- Validation form -->
		<form id="validate" class="form" method="post" action="javascript:Actualizar_Bodega('<?php echo $_GET['id'] ?>')">
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="public/images/icons/dark/alert.png" alt="" class="titleIcon"/>
						<h6>Llenar todos los campos para Editar Bodega</h6>
					</div>
					<div class="formRow">
						<span class="oneTwo">
							<label>Descricpci&oacute;n:</label>
							<div class="formRight">
								<input type="text" value="" class="validate[required]" name="txtDescripcion" id="txtDescripcion" style="width:80%"/>
							</div>
							<div class="clear">
							</div>
						</span>
						<span class="oneTwo">
							<label>Tel&eacute;fono:</label>
							<div class="formRight">
								<input type="text" value=""  class="validate[required]" name="txtTelefono" id="txtTelefono" style="width:80%"/>
							</div>
							<div class="clear">
							</div>							
						</span>	
						<div class="clear">
						</div>						
					</div>
					<div class="formRow">
							<label>Direcci&oacute;n:</label>
							<div class="formRight">
								<textarea rows="4" cols=""  class="validate[required]" name="txtDireccion" id="txtDireccion" class="autoGrow"></textarea>
							</div>
							<div class="clear">
							</div>					
					</div>
					<div class="formSubmit" id="ActualizarBodega">
						<input type="submit" value="Editar Bodega" class="redB"/>&nbsp;&nbsp;
						<input type="button" value="Cancelar Editar Bodega" class="redB" onclick="Cancelar_Actualizar_Bodega()"/>
					</div>
					<div class="clear">
					</div>
				</div>			
			</fieldset>
		</form>
	</div>