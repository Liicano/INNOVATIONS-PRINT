    <!-- Main content wrapper -->
  <div class="wrapper">


        <form id="validate" class="form" method="post" action="">
        	<fieldset>
                <div class="widget"> 					
					<div class="formRow">
                        <label>Tipo de Cliente:</label>
                        <div class="formRight">
                            <div class="floatL">
                                <select name="lstTipoCliente" id="lstTipoCliente">
                                    <option value="">Seleccione el Tipo de Cliente</option>
                                    <option value="1">Persona</option>
                                    <option value="2">Empresa</option>

                                </select>
                            </div>                  
						</div><div class="clear"></div>
                    </div>
				</div>		
			
			</fieldset>
				
							
			<div class="widget" id="TablaCliente">
				<div class="title"><img src="public/images/icons/dark/full2.png" alt="" class="titleIcon" /><h6><span id="Tipo1">Lista de Clientes</span></h6></div>                          
            
					<div id="Lista_Cliente_Persona" class="dataTables_wrapper no-footer">
					<!-- cargar Listado de Clientes -->
					<table cellpadding="0" cellspacing="0" border="0" class="display dTable" id="listado_cliente_persona">
						<thead>
							<tr>
								<th>#</th>
								<th >Nombre
								<input type="hidden" id="num_campos" name="num_campos" value="0" />
								<input type="hidden" id="cant_campos" name="cant_campos" value="0" /></th>
								<th >Apellido</th>
								<th >Tel&eacute;fono</th>
								<th >Celular</th>
								<th >Correo Electr&oacute;nico</th>
								<th >Direcci&oacute;n</th>
								<th >Cr&eacute;dito</th>
								<th >Creado/Actualidado Por</th>				
								<th >Opciones</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>										
					</div>
					<div id="Lista_Cliente_Empresa" class="dataTables_wrapper no-footer">
					<!-- cargar Listado de Clientes -->					
					<table cellpadding="0" cellspacing="0" border="0" class="display dataTable dTable" id="listado_cliente_empresa">
						<thead>
							<tr>

								<th >#</th>
								<th >Nombre de la Empresa
								<input type="hidden" id="num_campos" name="num_campos" value="0" />
								<input type="hidden" id="cant_campos" name="cant_campos" value="0" /></th>
								<th >RUC</th>
								<th >DV</th>				
								<th >Tel&eacute;fono</th>
								<th >Celular</th>
								<th >Correo Electr&oacute;nico</th>
								<th >Direcci&oacute;n</th>
								<th >Cr&eacute;dito</th>
								<th >Creado/Actualidado Por</th>	
								<th >Logotipo</th>		
								<th >Opciones</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>					
					</div> 					
			</div> 

		</form>
		
<!-- The Modal -->
<div id="myModal" class="modal">

</div>	



    </div>






 