    <!-- Main content wrapper -->
  <div class="wrapper">
        <form id="validate" class="form" method="post"  enctype="multipart/form-data" action="javascript:Cargar_Diseno_Dropbox()">
			<fieldset>
			<div class="widget">
					<div class="formRow" id="NumeroCotizacion">
					</div>
					<div class="formRow" id="DescripcionCotizacion">
					</div>					
                    <div class="formRow">
                        <label>Seleccione el Archivo:</label>
                        <div class="formRight">
                        	<input type="file" id="file" name="file" multiple="multiple" onchange="Cargar_Diseno_Arte();" />
                        </div><div class="clear"></div>
                    </div>
					<div  id="archivo"></div>
					<div  id="Mensaje">
					</div>						
					<div class="formSubmit">
						<input type="submit" value="Cargar Dise&ntilde;o de Arte" class="redB"/>
					</div>
					<div class="clear">
					</div>					
					
				
			</div>
			</fieldset>
		</form>
				
 
         
    </div>