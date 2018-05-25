    <!-- Main content wrapper -->
  <div class="wrapper">
        <form id="validate" class="form" method="post"  action="javascript:Agregar_Orden_Trabajo()">
			<div class="widget">
					<div class="formRow">
						<label>N&uacute;mero de Cotizaci&oacute;n:<span class="req">*</span></label>
						<div class="formRight">
							<input type="text" value="" class="validate[required]" name="txNumeroCotizacion" id="txtNumeroCotizacion"  style="width:100%"/>
							<input type="hidden" name="hiNumeroCotizacion" id="hiNumeroCotizacion"/>
						</div>
						<div class="clear"></div>
					</div>
					<!--<div class="formRow" id="UsuarioAsignado">
					</div>!-->
					<!--<div class="formRow" id="AgregarUsuario"><a href="javascript:void(0);" title="" class="smallButton" style="margin: 5px;"><img src="public/images/icons/color/plus.png" alt="" onclick="Agregar_Asignar_Usuario()"/>Agregar para Asignar Usuario</a>
					</div>!-->					
					<!--<div class="formRow" id="PorcentajeAvanzado">
						<label>Porcentaje Avanzado:<span class="req">*</span></label>
							<div class="formRight">
								<input type="text" value="" class="validate[required]" name="txPorcentajeAvanzado" id="txPorcentajeAvanzado"  style="width:10%"/>&nbsp;&nbsp;%
							</div>
							<div class="clear">
							</div>
					</div>!-->
					<div class="formRow" id="FechaEntrega">
						<label>Fecha de Entrega:</label>
						<div class="formRight">
							<input type="text" class="datepicker validate[required]" name="txtFechaEntrega" id="txtFechaEntrega" readonly="readonly" />
						</div>
                    <div class="clear"></div>
					</div>					
					<div class="formRow" id="Contactos">
					</div>					
			</div>
		
			<div class="widget">			
			<div class="title"><img src="public/images/icons/dark/frames.png" alt="" class="titleIcon" /><h6>Agregar Orden de Trabajo</h6></div>                          
            <table cellpadding="0" cellspacing="0" border="0" class="sTable" width="100%">
            <thead id="tbHead">
            <tr>
			<td width="5%">&nbsp;</td>
            <td width="15%">Cantidad<input type="hidden" id="num_campos" name="num_campos" value="0"/></td>
            <td width="20%">Tipo de Empaque<input type="hidden" id="cant_campos" name="num_campos" value="0"/></td>
            <td width="40%">Producto</td>
            <td width="15%">Seleccione</td>
			<td width="5%">&nbsp;</td>			
            </tr>
            </thead>
            <tbody id="tbTrabajo">
            </tbody>
			<tfoot id="tbTotal" >
			</tfoot>
            </table>
					<div class="formSubmit" id="AgregarOrdenTrabajo">
						<input type="submit" value="Agregar Orden de Trabajo" class="redB"/>
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