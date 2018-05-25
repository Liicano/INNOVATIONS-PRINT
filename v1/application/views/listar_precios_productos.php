    <!-- Main content wrapper -->
  <div class="wrapper">
 				
		<div class="widget">
			<form id="validate" class="form" method="post"  action="">
				<div class="formRow">
					<div class="oneTwo">
						<label for="labelFor">Tipo de Categor&iacute;a:</label>
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
					<div class="oneTwo">
						<label for="labelFor">Proveedor:</label>
						<div class="formRight">
							<div class="floatL">
								<select name="lstProveedor" id="lstProveedor" class="">
									<option value="0">Seleccione el Proveedor</option>
								</select>
							</div>
						</div>
						<div class="clear">
						</div>				
					</div>
					<div class="clear">
					</div>
				</div>		
			</form>						
		</div>
		<div class="widget">
			<div class="title"><img src="public/images/icons/dark/full2.png" alt="" class="titleIcon" /><h6><span id="Tipo1">Listado de Precios de Productos</span></h6></div>                          
            
				<div id="Lista_Precios_Productos">
				<!-- cargar Listado de Productos -->
					<table cellpadding="0" cellspacing="0" border="0" class="display dTable"  id="listado_precio_producto">
						<thead>
							<tr>
								<th style="width:2%"></th>
								<th>Categor&iacute;ca de Producto</th>
								<th>Nombre de Proveedor</th>
								<input type="hidden" id="num_campos" name="num_campos" value="0" />
								<input type="hidden" id="cant_campos" name="cant_campos" value="0" /></th>
								<th>Nombre de Producto</th>
								<th>C&oacute;digo de Producto</th>
								<th>Precio de Venta</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>							
				</div> 
		</div>			
 
         
    </div>