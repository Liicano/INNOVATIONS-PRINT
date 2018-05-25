			<!-- Main content wrapper -->
		  <div class="wrapper">
				<form id="validate" class="form" method="post"  action="">
					<div class="widget">
							<div class="formRow">
									<label>Desde:</label>
									<div class="formRight">
										<input type="text" name="txtDesde" id="txtDesde" class="datepicker validate[required]" />&nbsp;<input type="text" name="txtHoraDesde" id="txtHoraDesde" class="timepicker validate[required]" size="10" /><span class="f11">Use rueda de mouse y teclado</span>
									</div>
								<div class="clear"></div>
							</div>					
							<div class="formRow">
									<label>Hasta:</label>
									<div class="formRight">
										<input type="text" name="txtHasta" id="txtHasta" class="datepicker validate[required]" />&nbsp;<input type="text" name="txtHoraHasta" id="txtHoraHasta" class="timepicker validate[required]" size="10" /><span class="f11">Use rueda de mouse y teclado</span>
									</div>
								<div class="clear"></div>
							</div>	
							<div class="formRow">
								<label>Tipo de Venta:</label>
								<div class="formRight">
									<input type="checkbox" name="chkContado" id="chkContado" /><label for="chkContado">Contado</label>
									<input type="checkbox" name="chkCredito" id="chkCredito" /><label for="chkCredito">Cr&eacute;dito</label>
								</div><div class="clear"></div>
							</div>
							<div class="formRow">
								<div class="formSubmit" id="GenerarReporte">
									<input type="button" value="Generar Reporte" class="redB" onclick="Reporte_Venta_Rapida()"/>&nbsp;&nbsp;<!--<input type="button" value="Tiene Cotizaci&oacute;n Realizado Anteriormente" class="redB" onclick="Buscar_Cotizacion()"/>!-->
								</div>
								<div class="clear">
								</div>
							</div>							
					</div>
				
					<div class="widget">			
					<div class="title"><img src="public/images/icons/dark/frames.png" alt="" class="titleIcon" /><h6>Reporte de Ventas</h6></div>                          
					<div id="Reporte_Venta_Rapida">
					<!-- cargar Listado de Cotizaciones -->
						<table cellpadding="0" cellspacing="0" border="0" class="display dTable" style="table-layout: fixed;word-wrap:break-word;" id="listado_reporte_venta_rapida">
							<thead>
								<tr>
									<th style="width:2%"></th>
									<th style="width:10%">Fecha</th>
									<th style="width:10%">Hora</th>
									<th style="width:10%">Generado Por
									<input type="hidden" id="num_campos" name="num_campos" value="<?php echo $nfilas ?>" />
									<input type="hidden" id="cant_campos" name="cant_campos" value="<?php echo $nfilas ?>" /></th>
									<th style="width:23%">Nombre del Cliente</th>
									<th style="width:15%">Tipo de Venta</th>
									<th style="width:10%">SubTotal</th>
									<th style="width:10%">ITBM</th>
									<th style="width:10%">Total</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
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