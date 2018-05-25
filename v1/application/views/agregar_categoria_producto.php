	<!-- Main content wrapper -->
	<div class="wrapper">
		<!-- Note -->
		<div class="nNote nInformation hideit">
			<p>
				<strong>INFORMACI&Oacute;N: </strong>Llenar los campos correspondiente para Agregar Categor&iacute;a de Producto
			</p>
		</div>
		<!-- Validation form -->
		<form id="validate" class="form" method="post" action="javascript:Agregar_Categoria_Producto()">
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="public/images/icons/dark/alert.png" alt="" class="titleIcon"/>
						<h6>Llenar todos los campos para Agregar Categor&iacute;a de Producto</h6>
					</div>
					<div class="formRow">
						<label>Nombre de  Categor&iacute;a:</label>
						<div class="formRight">
							<input type="text" value="" class="validate[required]" name="txtNombreCategoriaProducto" id="txtNombreCategoriaProducto" style="width:80%"/>
						</div>
						<div class="clear">
						</div>
					</div>						
					<div class="formRow">						
						<label>Porcentaje(%):</label>
						<div class="formRight">
							<input type="text" value="0.00"  class="validate[required,custom[number]]" name="txtPorcentaje" id="txtPorcentaje" style="width:80%"/>
						</div>
						<div class="clear">
						</div>												
					</div>						
					<div class="formSubmit" id="AgregarCategoriaProducto">
						<input type="submit" value="Agregar Categor&iacute;a de Producto" class="redB"/>&nbsp;&nbsp;
						<input type="button" value="Cancelar Agregar Categor&iacute;a de Producto" class="redB" onclick="Cancelar_Agregar_Categoria_Producto()"/>
					</div>
					<div class="clear">
					</div>
				</div>			
			</fieldset>
		</form>
	</div>