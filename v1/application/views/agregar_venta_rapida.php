			<!-- Main content wrapper -->
		  <div class="wrapper">
				<form id="validate" class="form" method="post"  action="javascript:Agregar_Venta()">
					<div class="widget">
						<div class="formRow" id="NombreCliente">
							<label>Nombre del Cliente:<span class="req">*</span></label>
							<div class="formRight">
								<input type="text" value="" class="validate[required]" name="txtNombreCliente" id="txtNombreCliente"  style="width:100%"/>
								<input type="hidden" value="" name="hidIdCliente" id="hidIdCliente"/>
								<input type="hidden" value="" name="hidIdTipoCliente" id="hidIdTipoCliente"/>
							</div>
							<div class="clear"></div>								
						</div>
						<!--<div class="formRow" id="Listar_Cotizacion">
						</div>!-->
						<div class="formRow" id="DescripcionVenta">
							<label>Descripci&oacute;n de Ventas:<span class="req">*</span></label>
							<div class="formRight">
								<input type="text" value="" class="validate[required]" name="txtDescripcionVenta" id="txtDescripcionVenta"  style="width:100%"/>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label for="labelFor">Tipo de Venta:</label>
							<div class="formRight">
								<div class="floatL">
									<select name="lstTipoVenta" id="lstTipoVenta" class="validate[required]">
										<option value="0">Seleccione el Tipo de Venta</option>
									</select>
								</div>
							</div>
							<div class="clear">
							</div>
						</div>									
						<div class="formRow" id="Exento">
						<label for="labelFor">Exento de ITBM:</label>								
							<div class="formRight">
								<div class="floatL">
									<input type="checkbox" id="chkExentoITBM" name="chkExentoITBM" value="1"  class=""  style="width:5%;"/>
								</div>
							</div>								
							<div class="clear">
							</div>
						</div>							
					</div>
					<div class="widget">
						<div class="title"><img src="public/images/icons/dark/frames.png" alt="" class="titleIcon" /><h6>Agregar Ventas</h6></div>
						<div class="formRow" id="CodigoBarra">
							<label for="labelFor">C&oacute;digo de Barra:</label>								
							<div class="formRight">
								<input type="text" id="txtCodigoBarra" name="txtCodigoBarra" value=""  class="form-control"  style="width:90%;"/>
							</div>								
							<div class="clear">
							</div>
						</div>
						<div class="formRow" id="CodigoBarra">
							<label for="labelFor">Buscar Producto:</label>								
							<div class="formRight">
								<input type="text" id="txtProductoBuscar" name="txtProductoBuscar" value=""  class="form-control"  style="width:90%;"/>
								<input type="hidden" id="hidProductoBuscar" name="hidProductoBuscar" value=""/>
							</div>								
							<div class="clear">
							</div>
						</div>						
						
						<div class="formRow">
							<div class="threeone">
								<div class="widget">
									<table cellpadding="0" cellspacing="0" border="0" class="sTable">
										<thead id="tbHead">
										<tr>
										<td width="2%"><a href="javascript:void(0);" title="" class="smallButton" style="margin: 5px;"><img src="public/images/icons/color/plus.png" alt="" onclick="Agregar_Articulo()"/></a></td>
										<td width="15%">Codigo de Barra<input type="hidden" id="num_campos" name="num_campos" value="0"/></td>
										<td width="29%">Producto<input type="hidden" id="cant_campos" name="cant_campos" value="0"/></td>
										<td width="15%">Cantidad</td>
										<td width="15%">Precio</td>
										<td width="15%">Total</td>
										<td width="9%">&nbsp;</td>			
										</tr>
										</thead>
										<tbody id="tbDetalle">
											<tr id="rowDetalle_0">
												<td></td>
											</tr>
										</tbody>
										<tfoot id="tbTotal" >
										</tfoot>
									</table>
								</div>
								<div class="clear"></div>	
							</div>
							
							<div class="clear">
							</div>							
						</div>					
						<div class="formSubmit" id="AgregarVenta">
							<input type="submit" value="Pasar a la Caja" class="redB"/>&nbsp;&nbsp;
							<input type="button" value="Cancelar Agregar Venta Rapida" class="redB" onclick="Cancelar_Agregar_Venta_Rapida()"/>
							<!--<input type="button" value="Regresar al Dashboard" class="redB" onclick="location.href = 'admin.php';"/>!-->
							<!--<input type="button" value="Tiene Cotizaci&oacute;n Realizado Anteriormente" class="redB" onclick="Buscar_Cotizacion()"/>!-->
						</div>
						<div class="clear">
						</div>					
					<!--<div class="formRow" id="Nota" style="text-align:left">
						<!--<input type="text" value="" class="validate[required]" name="txtNotaCotizacion" id="txtNotaCotizacion"/>!-->
						<!--<label>Nota:</label>
						<div class="formRight"><textarea rows="4" cols="" name="txtNotaCotizacion"  id="txtNotaCotizacion" class="autoGrow lim" placeholder="Escribir Observaciones" style="width:50%"></textarea></div>
						<div class="clear"></div>
					</div>!-->
					</div>
				</form>
				<div class="uDialog">
					<div id="dialog-message" title="Dialog title">
					</div>
				</div>							
		 
				 
			</div>