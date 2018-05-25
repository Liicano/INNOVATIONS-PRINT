	<!-- Main content wrapper -->
	<div class="wrapper">
		<!-- Note -->
		<div class="nNote nInformation hideit">
			<p>
				<strong>INFORMACI&Oacute;N: </strong>Llenar los campos correspondiente para Agregar Abono
			</p>
		</div>
		<!-- Validation form -->
		<form id="validate" class="form" method="post" action="javascript:Ingresar_Abono()">
			<fieldset>
				<div class="widget">
					<div class="title">
						<img src="public/images/icons/dark/alert.png" alt="" class="titleIcon"/>
						<h6>Llenar todos los campos para Agregar Abono</h6>
					</div>
					<div class="formRow">
						<label>N&uacute;mero de Cotizaci&oacute;n:</label>
						<div class="formRight">
							<input type="text" value="" class="validate[custom[number]]" name="txtNumeroCotizacion" id="txtNumeroCotizacion" readonly="readonly"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label>Saldo Anterior:</label>
						<div class="formRight">
							<input type="text" value="" class="validate[custom[number]]" name="txtSaldoAnterior" id="txtSaldoAnterior" readonly="readonly"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label>Monto a Abonar:<span class="req">*</span></label>
						<div class="formRight">
							<input type="text" value="" class="validate[required,custom[number]]" name="txtMontoAbonado" id="txtMontoAbonado" onchange="PrecioMoneda('txtMontoAbonado');"/>
							<input type="hidden" value="" name="hidMontoAbonadoAnt" id="hidMontoAbonadoAnt"/>
							<input type="hidden" value="" name="hidMontoTotal" id="hidMontoTotal"/>
							<input type="hidden" value="" name="hdnIdCotizacion" id="hdnIdCotizacion"/>
						</div>
						<div class="clear">
						</div>
					</div>						
					<div class="formRow">
						<label>Saldo Actual:</label>
						<div class="formRight">
							<input type="text" value="0.00" class="validate[custom[number]]" name="txtSaldoActual" id="txtSaldoActual" readonly="readonly"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow">
						<label>Tipo de Pago:<span class="req">*</span></label>
						<div class="formRight">
							<div class="floatL">
								<select name="lstTipoPago" id="lstTipoPago">
									<option value="0">Seleccione el Tipo de Pago</option>
								</select>
								
							</div>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow" id="NumFactFiscal">
						<label>N&uacute;mero de Factura Fiscal:</label>
						<div class="formRight">
							<input type="text" class="validate[custom[number]]" name="txtNumFactFiscal" id="txtNumFactFiscal"/>
						</div>
						<div class="clear">
						</div>
					</div>
					<div class="formRow"  id="FechaFactFiscal">
						<span class="oneTwo">
							<label>Fecha:</label>
							<div class="formRight">
								<input type="text" name="txtFechaFactFiscal" id="txtFechaFactFiscal" class="maskDate datepicker" />
							</div>
							<div class="clear">
							</div>
						</span>
						<span class="oneTwo">
							<label>Hora:</label>
							<div class="formRight">
								<input type="text" name="txtHoraFactFiscal" id="txtHoraFactFiscal" class="maskTime timepicker" size="10" /><span class="f11">Usar mousewheel y teclado</span>
							</div>
							<div class="clear">
							</div>						
						</span>	
						<div class="clear">
						</div>
					</div>
					<div class="formSubmit">
						<input type="submit" value="Ingresar Abono" class="redB"/>
						<input type="button" value="Cancelar Ingresar Abono" class="redB" onclick="Cancelar_Ingresar_Abono()"/>
					</div>
					<div class="clear">
					</div>
				</div>
			</fieldset>
		</form>
	</div>