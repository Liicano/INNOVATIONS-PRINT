	<!-- Main content wrapper -->  

	<div class="wrapper"> 				

		<form id="validate" class="form" method="post"  action="javascript:Actualizar_Material()">					
			<fieldset>
				<div class="widget">							

					<div class="formRow">				
						<label for="labelFor">Tipo de Material:</label>			
						<div class="formRight">									

							<div class="floatL">										
								<select name="lstMaterial" id="lstMaterial" class="validate[required]">											
								<option value="0">Seleccione el Tipo de Material</option>										
								</select>									
							</div>								
						</div>								

						<div class="clear">								
						</div>							
					</div>							

					<div class="formRow" id="TamanoAncho">								
						<label>Tama&ntildeo del Pliego - Ancho:<span class="req">*</span></label>								

						<div class="formRight">									
							<input type="text" value="0.00" class="validate[required]" name="txtTamanoAncho" id="txtTamanoAncho" onchange="PrecioMoneda('txtTamanoAncho');" />								
						</div>								

						<div class="clear">								
						</div>							
					</div>							

					<div class="formRow" id="TamanoLargo">								
						<label>Tama&ntildeo del Pliego - Largo:<span class="req">*</span></label>								

						<div class="formRight">									
							<input type="text" value="0.00" class="validate[required]" name="txtTamanoLargo" id="txtTamanoLargo" onchange="PrecioMoneda('txtTamanoLargo');" />								
						</div>								

						<div class="clear">								
						</div>							
					</div>												

					<div class="formRow" id="PrecioPliego">								
						<label>Precio por Pliego:<span class="req">*</span></label>								

						<div class="formRight">									
							<input type="text" value="0.00" class="validate[required]" name="txtPrecioPliego" id="txtPrecioPliego" onchange="PrecioMoneda('txtPrecioPliego');"/>								
						</div>								

						<div class="clear">								
						</div>							
					</div>							

					<div class="formRow" id="PrecioPulgada">								
						<label>Precio por Pulgada:<span class="req">*</span></label>								

						<div class="formRight">									
							<input type="text" value="0.00000000" class="validate[required]" name="txtPrecioPulgada" id="txtPrecioPulgada" onchange="DecimalesPulgada('txtPrecioPulgada');"/>								
						</div>								

						<div class="clear">								
						</div>							
					</div>							

					<!--<div class="formRow" id="divActualizar">								

						<div class="formSubmit">									
							<input type="button" value="Actualizar Material" class="redB" onclick="Actualizar_Material()"/>								
						</div>								

						<div class="clear">								
						</div>								
					</div>!-->							 					
				</div>					

			<div class="widget">							

				<div class="title"><img src="public/images/icons/dark/full2.png" alt="" class="titleIcon" /><h6><span id="Tipo1">Listar Materiales de Impresi&oacute;n</span></h6>
				</div>                          															

				<div id="Listar_Materiales">								
				<!-- cargar Listado de Ventas Rapidas -->								
				</div> 					
			</div>
			<div class="widget" id="divActualizar">
				<div class="formSubmit">
					<input type="submit" value="Actualizar Material" class="redB"/> <input type="button" value="Cancelar Actualizar Material" class="redB" onclick="Cancelar_Actualizar_Material()"/>
				</div>
				<div class="clear">
				</div>					
			</div>
			</fieldset>		
		</form>             
	</div>  