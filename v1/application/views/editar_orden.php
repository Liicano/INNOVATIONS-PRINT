	<!-- Main content wrapper -->
	<div class="wrapper">
		<!-- Note -->
		<div class="nNote nInformation hideit">
			<p>
				<strong>INFORMACI&Oacute;N: </strong>Llenar los campos correspondiente para Editar Orden
			</p>
		</div>
		<!-- Validation form -->
		<form id="frmActualizarOrden" class="form" method="post" action="javascript:Validar_Orden('<?php echo $_GET['id']; ?>','<?php echo $_GET['to']?>','<?php echo $_GET['toe']?>')">
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="public/images/icons/dark/alert.png" alt="" class="titleIcon"/>
						<h6>Llenar todos los campos para Agregar Orden</h6>
					</div>
					<div class="formRow">
						<span class="oneTwo">
							<label>N&uacute;mero de Orden:</label>
							<div class="formRight">
								<input type="text" value=""  name="txtNumeroOrden" id="txtNumeroOrden" style="width:80%" readonly="readonly"/>
							</div>
							<div class="clear">
							</div>
						</span>
						<span class="oneTwo">
							<label>Fecha:</label>
							<div class="formRight">
								<input type="text" value="" name="txtFechaOrden" id="txtFechaOrden" style="width:80%" readonly="readonly"/>
							</div>
							<div class="clear">
							</div>							
						</span>	
						<div class="clear">
						</div>						
					</div>
					<div class="formRow">
						<span class="oneTwo">
							<label>Tipo de Orden:</label>
							<div class="formRight">
								<div class="floatL">
									<select name="lstTipoOrden" id="lstTipoOrden"  class="validate[required]"  disabled="disabled" >
										<option value="0">Seleccione el Tipo de Orden</option>
									</select>
								</div>
							</div>
							<div class="clear">
							</div>
						</span>
						<span class="oneTwo" id="OrdenEntrada">
							<label>Tipo de Orden Entrada:</label>
							<div class="formRight">
								<div class="floatL">
									<select name="lstTipoOrdenEntrada" id="lstTipoOrdenEntrada"  class="validate[required]"  disabled="disabled">
										<option value="0">Seleccione el Tipo de Orden de Entrada</option>
									</select>
								</div>
							</div>
							<div class="clear">
							</div>						
						</span>	
						<div class="clear">
						</div>						
					</div>
					<div class="formRow" id="ProveedorProcedencia">
						<label>Proveedor:</label>
						<div class="formRight">
							<input type="text" value="" name="txtProveedorProcedencia" id="txtProveedorProcedencia" style="width:80%" class="validate[required]"/>
							<input type="hidden" name="hidProveedorProcedencia" id="hidProveedorProcedencia">
						</div>
						<div class="clear">
						</div>
					</div>					
					<div class="formRow" id="BodegaProcedencia">
						<label>Bodega de Procedencia:</label>
						<div class="formRight">
							<input type="text" value="" name="txtBodegaProcedencia" id="txtBodegaProcedencia" style="width:80%" class="validate[required]"/>
							<input type="hidden" name="hidBodegaProcedencia" id="hidBodegaProcedencia">
						</div>
						<div class="clear">
						</div>
					</div>					
					<div class="formRow" id="TiendaReceptora">
						<label>Tienda Receptor:</label>
						<div class="formRight">
							<input type="text" value="" name="txtTiendaReceptora" id="txtTiendaReceptora" style="width:80%" class="validate[required]"/>
							<input type="hidden" name="hidTiendaReceptora" id="hidTiendaReceptora">
						</div>
						<div class="clear">
						</div>									
					</div>	
					<div class="formRow" id="BodegaReceptora">
						<label>Bodega Receptor:</label>
						<div class="formRight">
							<input type="text" value="" name="txtBodegaReceptora" id="txtBodegaReceptora" style="width:80%" class="validate[required]"/>
							<input type="hidden" name="hidBodegaReceptora" id="hidBodegaReceptora">
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="TiendaProcedencia">					
						<label>Tienda de Procedencia:</label>
						<div class="formRight">
							<input type="text" value="" name="txtTiendaProcedencia" id="txtTiendaProcedencia" style="width:80%" class="validate[required]"/>
							<input type="hidden" name="hidTiendaProcedencia" id="hidTiendaProcedencia">
						</div>
						<div class="clear">
						</div>										
					</div>					
					<div class="formRow">
						<label>Autorizo:</label>
						<div class="formRight">
							<input type="text" value="" name="txtAutorizo" id="txtAutorizo" style="width:80%" readonly="readonly"/>
						</div>
						<div class="clear">
						</div>
					</div>					
					<div class="formRow">
						<label>Observaciones:</label>
						<div class="formRight">
							<textarea rows="4" cols="" class="validate[required]" name="txtObservaciones" id="txtObservaciones" class="autoGrow"></textarea>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<div class="widget" id="Lista_Articulos_Orden">
							<table cellpadding="0" cellspacing="0" border="0" class="sTable">
							<thead id="tbHead">
							<tr>
							<td width="2%"><a href="javascript:void(0);" title="" class="smallButton" style="margin: 5px;"><img src="public/images/icons/color/plus.png" alt="" onclick="Agregar_Articulo_Orden()"/></a></td>							
							<td width="20%">C&oacute;digo de Barra<input type="hidden" id="cant_campos" name="cant_campos" value="0"/></td>
							<td width="39%">Nombre de Producto</td>
							<td width="15%">Cantidad<input type="hidden" id="num_campos" name="num_campos" value="0"/></td>
							<td width="15%">Opciones</td>		
							</tr>
							</thead>
							<tbody id="tbDetalle">
							</tbody>
							</table>
						</div>	
					</div>
					<div class="formSubmit" id="EditarOrden">
						<input type="submit" value="Editar Orden" class="redB"/>&nbsp;&nbsp;
						<input type="button" value="Cancelar Editar Orden" class="redB" onclick="Cancelar_Agregar_Orden()"/>
					</div>
					<div class="clear">
					</div>
				</div>			
			</fieldset>
		</form>
	</div>