    <!-- Main content wrapper -->
  <div class="wrapper">
 
	<div class="widget">
			<div class="title"><img src="public/images/icons/dark/full2.png" alt="" class="titleIcon" /><h6><span id="Tipo1">Lista de Ordenes de Trabajos</span></h6></div>                          
            
				<div id="Lista_Ordenes_Trabajos">
				<!-- cargar Listado de Productos -->
					<table cellpadding="0" cellspacing="0" border="0" class="display dTable"  style="table-layout: fixed;word-wrap:break-word;" id="listado_orden_trabajo">
						<thead>
							<tr>
								<th style="width:2%"></th>
								<th style="width:8%">N&deg; de Orden de Trabajo
								<input type="hidden" id="num_campos" name="num_campos" value="<?php echo $nfilas ?>" />
								<input type="hidden" id="cant_campos" name="cant_campos" value="<?php echo $nfilas ?>" /></th>
								<th style="width:5%">N&deg; de Cotizaci&oacute;n:</th>
								<th style="width:22%">Descripci&oacute;n del Trabajo</th>
								<th style="width:8%">Usuario Arte</th>
								<th style="width:8%">Usuario Impresi&oacute;n</th>
								<th style="width:8%">Usuario Acabado</th>			
								<th style="width:10%">Estatus</th>
								<th style="width:10%">Porcentaje de Progreso</th>				
								<?php if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
								{ ?>
								<th style="width:13%">Opciones</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div> 
		</div>			
 
         
    </div>