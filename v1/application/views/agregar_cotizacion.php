			<!-- Main content wrapper -->
		  <div class="wrapper">
				<form id="validate" class="form" method="post"  action="javascript:Agregar_Cotizacion()">
					<div class="widget">
							<div class="formRow" id="NombreCliente">
							</div>
							<!--<div class="formRow" id="Listar_Cotizacion">
							</div>!-->
							<div class="formRow" id="DescripcionCotizacion">
							</div>					
							<div class="formRow" id="Contactos">
							</div>					
					</div>
				
					<div class="widget">			
					<div class="title"><img src="public/images/icons/dark/frames.png" alt="" class="titleIcon" /><h6>Agregar Cotizaci&oacute;n</h6></div>                          
					<table cellpadding="0" cellspacing="0" border="0" class="sTable">
					<thead id="tbHead">
					<tr>
					<td width="2%"><a href="javascript:void(0);" title="" class="smallButton" style="margin: 5px;"><img src="public/images/icons/color/plus.png" alt="" onclick="Agregar_Articulo()"/></a></td>
					<td width="15%">Cantidad<input type="hidden" id="num_campos" name="num_campos" value="0"/></td>
					<td width="15%">Tipo de Empaque<input type="hidden" id="cant_campos" name="cant_campos" value="0"/></td>
					<td width="29%">Producto</td>
					<td width="15%">Precio</td>
					<td width="15%">Total</td>
					<td width="9%">&nbsp;</td>			
					</tr>
					</thead>
					<tbody id="tbDetalle">
					</tbody>
					<tfoot id="tbTotal" >
					</tfoot>
					</table>
							<div class="formSubmit" id="AgregarCotizacion">
								<input type="submit" value="Agregar Cotizaci&oacute;n" class="redB"/>&nbsp;&nbsp;
								<input type="button" value="Cancelar Agregar Cotizaci&oacute;n" class="redB" onclick="Cancelar_Agregar_Cotizacion()"/>
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
						
		 
				 
			</div>