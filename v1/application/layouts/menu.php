<!-- Left side content -->
<div id="leftSide">
    <div class="logo"><a href="index.html"><img src="public/images/logo.png" alt="" /></a></div>
    
    <div class="sidebarSep mt0"></div>
    
    <!-- Search widget -->
    <form action="" class="sidebarSearch">
        <input type="text" name="search" placeholder="search..." id="ac" />
        <input type="submit" value="" />
    </form>
      
    <div class="sidebarSep"></div>
    
    <!-- Left navigation -->
    <ul id="menu" class="nav">
        <li class="dash"><a  id="dashboard" onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php';" title="Dashboard" class="active"><span>Dashboard</span></a></li>
						<?php 
						/*include('config/configuracion.php');
						try {
							$db = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NOMBRE, DB_USER, DB_CLAVE);
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}
						
						$id_usuario = base64_decode($_SESSION['id_usuario']);
						
						try
						{		
							$stmt = $db->prepare("SELECT id_tipo_usuario FROM usuarios
							WHERE id_usuario = ?");
							
							$p = 1;
							$stmt->bindParam($p,$id_usuario,PDO::PARAM_STR,255);
							
							$stmt->execute();
							$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas = $stmt->rowCount();
							$stmt->closeCursor();
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}*/

						?>        
        <li class="typo"><a id="clientes" href="javascript:void(0);" title="Clientes"  class="exp"><span>Clientes</span><strong>2</strong></a>
            <ul class="sub" id="ul_clientes">
                <li id="agregar_cliente"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_cliente")?>';" title="Agregar Cliente">Agregar Cliente</a></li>
                <li id="listar_clientes" class="last"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_clientes")?>';" title="Listar Clientes">Listar Clientes</a></li>
            </ul>
        </li>
        
        <li class="typo"><a id="inventario" href="javascript:void(0);" title="" class="exp"><span>Inventario</span><strong>8</strong></a>
			<ul class="sub" id="ul_inventario">
				<?php
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{  ?>				
				<li id="agregar_producto"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_producto")?>';" title="Agregar Producto">Agregar Producto</a></li>
				<?php } ?>
				<li id="listar_productos"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_productos")?>';" title="Listar Productos">Listar Productos</a></li>
				<li id="listar_precios_productos"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_precios_productos")?>';" title="Listar Productos">Listado de Precios de Productos</a></li>
				<li id="inventario_articulos"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("inventario_productos")?>';" title="Inventario de Productos">Inventario de Productos</a></li>
				<?php
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{  ?>				
				<li id="agregar_categoria_producto"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_categoria_producto")?>';" title="Agregar Categor&iacute;a de Producto">Agregar Categor&iacute;a de Producto</a></li>
				<?php } ?>
				<li id="listar_categorias_productos"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_categorias_productos")?>';" title="Listar Categor&iacute;as de Productos">Listar Categor&iacute;as de Productos</a></li>
				<?php
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{  ?>				
				<li id="agregar_ubicacion"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_ubicacion")?>';" title="Agregar Ubicaci&oacute;n">Agregar Ubicaci&oacute;n</a></li>
				<?php } ?>
				<li id="listar_ubicaciones"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_ubicaciones")?>';" title="Listar Ubicaciones">Listar Ubicaciones</a></li>				
			</ul>
		 </li>
		 <li class="typo"><a id="movimientos" href="javascript:void(0);" title="" class="exp"><span>Movimiento</span><strong>7</strong></a>
			<ul class="sub" id="ul_movimientos">
				<?php
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{  ?>				
				<li id="agregar_bodega"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_bodega")?>';" title="Agregar Bodega">Agregar Bodega</a></li>
				<?php } ?>
				<li id="listar_bodegas"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_bodegas")?>';" title="Listar Bodegas">Listar Bodegas</a></li>					   
				<?php
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{  ?>				
				<li id="agregar_tienda"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_tienda")?>';" title="Agregar Tienda">Agregar Tienda</a></li>
				<?php } ?>
				<li id="listar_tiendas"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_tiendas")?>';" title="Listar Tiendas">Listar Tiendas</a></li>					   
				<?php
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{  ?>				
				<li id="agregar_orden"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_orden")?>';" title="Agregar Orden">Agregar Orden</a></li>
				<?php } ?>
				<li id="listar_ordenes"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_ordenes")?>';" title="Listar &Oacute;rdenes">Listar &Oacute;rdenes</a></li>					   
				<li id="movimiento_productos" class="last"><a  onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("movimiento_productos")?>';" title="Movimiento de Productos">Mov. de Productos</a></li>				
			</ul>
		 </li>
		<?php
		if (base64_decode($_SESSION['id_tipo_usuario']) == 1)
		{  ?>		
        <li class="typo" id="materialimp"><a href="javascript:void(0);" title="" class="exp"><span>Material de Impresi&oacute;n</span><strong>2</strong></a>
            <ul class="sub" id="ul_materiales">
				<li id="agregar_material"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_material")?>';" title="Agregar Material">Agregar Material</a></li>
				<li id="listar_materiales" class="last"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_materiales")?>';" title="Listar Materiales">Listar Material</a></li>
             
            </ul>
        </li>
		<?php } ?>  		
        <li class="typo"><a id="cotizaciones" href="javascript:void(0);" title="" class="exp"><span>Cotizaciones</span><strong  id="cant_cotz_item" ><?php echo((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))?"3":"2" ?></strong></a>
            <ul class="sub" id="ul_cotizaciones">
				<li id="agregar_cotizacion"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_cotizacion")?>';" title="Agregar Cotizaci&oacute;n">Agregar Cotizaci&oacute;n</a></li>
				<?php
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{  ?>
				<li id="editar_cotizacion"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("editar_cotizacion")?>';" title="Editar Cotizaci&oacute;n">Editar Cotizaci&oacute;n</a></li>					
				<?php } ?>				
				<li id="listar_cotizacion"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_cotizaciones")?>';" title="Listar Cotizaciones">Listar Cotizaciones</a></li>               
            </ul>
        </li>
 
		<li class="typo"><a id="ventas_rapidas" href="javascript:void(0);" title=""  class="exp"><span>Venta R&aacute;pida</span><strong>3</strong></a>
			<ul class="sub" id="ul_ventas_rapidas">
				<li id="agregar_venta_rapida"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_venta_rapida")?>';" title="Agregar Venta R&aacute;pida">Agregar Venta R&aacute;pida</a></li>			
				<?php
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{  ?>
				<li id="listar_ventas_rapidas"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_ventas_rapidas")?>';" title="Listar Venta R&aacute;pida">Listar Venta R&aacute;pida</a></li>
				<?php } 
				if (base64_decode($_SESSION['id_tipo_usuario']) == 1)
				{  ?>
				<li id="reporte_venta_rapida" class="last"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("reporte_venta_rapida")?>';" title="Reporte de Venta R&aacute;pida">Reporte de Venta R&aacute;pida</a></li>							
				<?php } ?>			   
			</ul>
		</li>	
 
        <li id="orden" class="typo"><a id="ordenes_trabajo" href="javascript:void(0);" title="" class="exp"><span>Orden de trabajo</span><strong id="cant_orden_item"><?php echo((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))?"3":"2" ?></strong></a>
            <ul class="sub" id="ul_ordenes_trabajos">
				<?php
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{  ?>			
                <li id="agregar_orden_trabajo"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_orden_trabajo")?>';" title="Agregar Orden">Agregar Orden</a></li>
                <?php } ?>	
				<li id="listar_ordenes_trabajo"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_ordenes_trabajos")?>';" title="Listas Ordenes">Listas Ordenes</a></li>
				<li id="listar_archivos_dropbox"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_archivos_dropbox")?>';" title="Listar Archivo de DropBox">Listar Archivo de DropBox</a></li>                
            </ul>
        </li>
        <li class="typo"><a id="proveedores"  href="javascript:void(0);" title="" class="exp"><span>Proveedores</span><strong>2</strong></a>
         <ul class="sub" id="ul_proveedores">
				<li id="agregar_proveedor"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_proveedor")?>';" title="Agregar Proveedor">Agregar Proveedor</a></li>
				<li id="listar_proveedores" class="last"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_proveedores")?>';" title="Listar Proveedores">Listar Proveedores</a></li>
			</ul>
        </li>
    </ul>
</div>

<!-- Right side -->
<div id="rightSide">

    <!-- Top fixed navigation -->
    <div class="topNav">
        <div class="wrapper">
            <div class="welcome"><a href="javascript:void(0);" title=""><img src="public/images/userPic.png" alt="" /></a><span id="usuario"></span></div>
            <div class="userNav">
                <ul>
					<li><a  onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_ordenes_trabajos")?>';" title="Tareas" ><img src="public/images/icons/topnav/tasks.png" alt=""/><span>Tareas</span></a></li>
                    <li class="dd"><a title=""><img src="public/images/icons/topnav/messages.png" alt="" /><span>Mensajes</span>
					<span class="numberTop" id="Tarea_Finalizada" style="display:none" onClick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_ordenes_trabajos")?>';"></span></a>
                        <!-- <ul class="userDropdown">
                            <li><a href="#" title="" class="sAdd">new message</a></li>
                            <li><a href="#" title="" class="sInbox">inbox</a></li>
                            <li><a href="#" title="" class="sOutbox">outbox</a></li>
                            <li><a href="#" title="" class="sTrash">trash</a></li>
                        </ul>-->
                    </li>
                    <li><a href="javascript:void(0);" title="" onclick="Cerrar_Sesion()"><img src="public/images/icons/topnav/logout.png" alt="" /><span>Logout</span></a></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <!-- Responsive header -->
    <div class="resp">
        <div class="respHead">
            <a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php';" title=""><img src="public/images/loginLogo.png" alt="" /></a>
        </div>
        
        <div class="cLine"></div>
        <div class="smalldd">
            <span class="goTo"><img src="public/images/icons/light/home.png" alt="" />Dashboard</span>
            <ul class="smallDropdown">
                <li><a id="res_dashboard" onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php';" title="" class="active" ><img src="public/images/icons/light/home.png" alt="" />Dashboard</a></li>
                <li><a id="res_clientes" href="javascript:void(0);" title="" class="exp"><img src="public/images/icons/light/create.png" alt="" />Clientes<strong>2</strong></a>
                    <ul id="resul_clientes" >
                        <li id="res_agregar_cliente" ><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_cliente")?>';" title="Agregar Cliente">Agregar Cliente</a></li>
                        <li id="res_listar_clientes" ><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_clientes")?>';" title="Listar Cliente">Listar Clientes</a></li>
                       </ul>
                </li>
                <li><a id="res_productos"  href="javascript:void(0);" title="" class="exp"><img src="public/images/icons/light/create.png" alt="" />Productos<strong>2</strong></a>
                    <ul id="resul_productos" >
                        <li id="res_agregar_producto" ><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_producto")?>';" title="Agregar Producto">Agregar Producto</a></li>
                        <li id="res_listar_productos" ><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_productos")?>';" title="Listar Producto">Listar Producto</a></li>
                    </ul>
                </li>
				<?php
				if (base64_decode($_SESSION['id_tipo_usuario']) == 1)
				{  ?>
                <li><a id="res_materialimp"  href="javascript:void(0);" title="" class="exp"><img src="public/images/icons/light/create.png" alt="" />Material de Impresi&oacute;n<strong>2</strong></a>
                    <ul id="resul_materiales" >
                        <li id="res_agregar_material" ><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_producto")?>';" title="Agregar Producto">Agregar Material</a></li>
                        <li id="res_listar_materiales" ><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_materiales")?>';" title="Listar Material">Listar Material</a></li>
                    </ul>
                </li>
				<?php } ?>					
				<li><a href="javascript:void(0);" title="" class="exp"><img src="public/images/icons/light/create.png" alt="" />Cotizaciones<strong  id="cant_cotz_item" ><?php echo((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))?"3":"2" ?></strong></a>
					<ul>
						<li><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_cotizacion")?>';" title="Agregar Cotizaci&oacute;n">Agregar Cotizaci&oacute;n</a></li>
						<?php
						if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
						{  ?>
						<li id="editar_cotizacion" ><a  onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("editar_cotizacion")?>';" title="Editar Cotizaci&oacute;n">Editar Cotizaci&oacute;n</a></li>					
						<?php } ?>	
						<li><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_cotizaciones")?>';" title="Listar Cotizaciones">Listar Cotizaci&oacute;n</a></li>
               
					</ul>
				</li>
				<li><a href="javascript:void(0);" title="" class="exp"><img src="public/images/venta_r2.png" alt="" />Venta R&aacute;pida<strong  id="cant_vent_item" ><?php echo((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))?"3":"2" ?></strong></a>
					<ul>
						<li><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_venta_rapida")?>';" title="Agregar Venta R&aacute;pida">Agregar Venta R&aacute;pida</a></li>
						<?php
						if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
						{  ?>	
						<li id="listar_venta_rapida1"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_ventas_rapidas")?>';" title="Listar Ventas R&aacute;pidas">Listar Ventas R&aacute;pidas</a></li>
						<?php } 
						if (base64_decode($_SESSION['id_tipo_usuario']) == 1)
						{  ?>
						<li id="reporte_venta_rapida1" ><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("reporte_venta_rapida")?>';" title="Reporte de Venta R&aacute;pida">Reporte de Venta R&aacute;pida</a></li>	
						<?php } ?>			   
					</ul>
				</li>				
                <li id="tareas"><a href="javascript:void(0);" title="" class="exp"><img src="public/images/icons/light/create.png" alt="" />Orden de Trabajo<strong id="cant_tarea_item" ><?php echo((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))?"3":"2" ?></strong></a>
                    <ul>
						<?php
						if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
						{  ?>				
                        <li  id="agregar_tarea"  style="display:none" ><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_orden_trabajo")?>';" title="Agregar Orden">Agregar Orden</a></li>
						<?php } ?>
						<li  id="tarea_lista" ><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_ordenes_trabajo")?>';" title="Listas &Oacute;rdenes">Listas &Oacute;rdenes</a></li>
						<li  id="tarea_lista1" ><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_archivos_dropbox")?>';" title="Listar Archivo de DropBox">Listar Archivo de DropBox</a></li>						
                    </ul>
                </li>
                <li><a href="javascript:void(0);" title="" class="exp"><img src="public/images/icons/light/create.png" alt="" />Proveedores<strong>2</strong></a>
                    <ul class="sub">
                        <li><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_proveedor")?>';" title="Agregar Proveedor">Agregar Proveedor</a></li>
                        <li><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_proveedores")?>';" title="Listar Proveedores">Listar Proveedores</a></li>
					</ul>
                </li>
               
            </ul>
        </div>
        <div class="cLine"></div>
    </div>
	
    <!-- Title area -->
    <div class="titleArea">
        <div class="wrapper">
            <div class="pageTitle" id="">
                <h5 id="PageTitle">Dashboard</h5>
            </div>
            <div class="middleNav">
                <ul>
                    <li class="mUser"><a title=""><span class="users"></span></a>
                        <ul class="mSub1">
							<?php
							if (base64_decode($_SESSION['id_tipo_usuario']) == 1)
							{  ?>
                            <li  id="agregar_usuario"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_usuario")?>';" title="Agregar Usuario">Agregar Usuario</a></li>
							<?php } 
							if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
							{  ?>							
							<li  id="lista_usuario"><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_usuarios")?>';" title="Lista de Usuarios">Lista de Usuarios</a></li>	
							<?php } ?>                            
							<li><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_ordenes_trabajos")?>';" title="Tareas" title="">Tareas</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line" id="LineStatsRow"></div>
    
    <!-- Page statistics and control buttons area -->
    <div class="statsRow">
        <div class="wrapper">
        	<div class="controlB">
            	<ul>
                	<li><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_cliente")?>';" title="Agregar Clientes"><img src="public/images/icons/control/32/hire-me.png" alt="" /><span>Agregar Clientes</span></a></li>
                    <li><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_cotizacion")?>';" title="Cotizaci&oacute;n"><img src="public/images/icons/control/32/plus.png" alt="" /><span>Cotizaci&oacute;n</span></a></li>
                    <!-- <li><a href="#" title=""><img src="images/icons/control/32/database.png" alt="" /><span>New DB entry</span></a></li>
                    <li><a href="#" title=""><img src="images/icons/control/32/statistics.png" alt="" /><span>Check statistics</span></a></li>-->
                    <li><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_orden_trabajo")?>';" title="Orden de Trabajo"><img src="public/images/icons/control/32/shipping.png" alt="" /><span>Orden de Trabajo</span></a></li>
					<?php if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
					{  ?>	
					<li id="detalle" ><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("listar_detalles_ventas")?>';" title="Detalle de Venta"><img src="public/images/icons/control/32/invoice.png" alt="" /><span>Detalle de Venta</span></a></li>
					<?php } ?> 
					<li><a onmouseover="this.style.cursor='pointer'" onmouseout="this.style.cursor='default'" onclick="location.href = 'admin.php?sec=<?php echo base64_encode("agregar_venta_rapida")?>';" title="Agregar Venta R&aacute;pida"><img src="public/images/venta_r2.png" alt="" /><span>Agregar Venta R&aacute;pida</span></a></li>	                
				</ul>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    
    <div class="line"></div>	
	