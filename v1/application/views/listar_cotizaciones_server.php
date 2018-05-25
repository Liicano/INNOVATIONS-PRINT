    <!-- Main content wrapper -->
  <div class="wrapper">
 
	<div class="widget">
		<div class="title"><img src="public/images/icons/dark/full2.png" alt="" class="titleIcon" /><h6><span id="Tipo1">Lista de Cotizaci&oacute;n</span></h6></div>                          
		
		<div id="Listar_Cotizaciones">
		<!-- cargar Listado de Cotizaciones -->
			<table cellpadding="0" cellspacing="0" border="0" class="display dTable" id="Cotizacion">
				<thead>
					<tr>
						<th style="width:2%"></th>
						<th style="width:9%">N&uacute;mero de Cotizaci&oacute;n</th>
						<th style="width:23%">Nombre del Cliente</th>
						<th style="width:20%">Estatus de Cotizaci&oacute;n
						<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
						<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
						<th style="width:9%">Monto Sub-Total</th>
						<th style="width:9%">MontoITBM</th>
						<th style="width:9%">Monto Total</th>
						<th style="width:9%">Monto Abonado</th>
						<th style="width:6%">Opciones</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div class="uDialog">
			<div id="dialog-message" title="Dialog title">
			</div>
		</div>		
	</div>			
 
         
    </div>