			<!-- Main content wrapper -->
		  <div class="wrapper">
		 
			<div class="widget">
					<div class="title"><img src="public/images/icons/dark/full2.png" alt="" class="titleIcon" /><h6><span id="Tipo1">Lista de Usuarios</span></h6></div>                          
					
						<div id="Lista_Usuarios">
						<!-- cargar Listado de Productos -->
							<table cellpadding="0" cellspacing="0" border="0" class="display dTable" id="listado_usuario">
								<thead>
									<tr>
										<th style="width:2%"></th>
										<th style="width:15%">Nombre
										<input type="hidden" id="num_campos" name="num_campos" value="<?php echo $nfilas ?>" />
										<input type="hidden" id="cant_campos" name="cant_campos" value="<?php echo $nfilas ?>" /></th>
										<th style="width:15%">Apellido</th>
										<th style="width:16%">Descripci&oacute;n del Usuario</th>
										<th style="width:10%">Usuario</th>
										<th style="width:10%">Clave</th>
										<th style="width:10%">Tipo de Usuario</th>				
										<th style="width:10%">Estatus de Usuario</th>
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