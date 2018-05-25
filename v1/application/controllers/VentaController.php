<?php
	include('../../config/configuracion.php');
	include('../../library/Database.php');	
	//echo date_default_timezone_get();
	date_default_timezone_set ('America/Panama');
	//echo date('d-m-Y H:i');
	if (!isset($_SERVER['HTTP_REFERER']))
	header('Location: ../index.php');

	try {
		$db = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NOMBRE, DB_USER, DB_CLAVE);
		//echo 'Connected to database<br />';
	}
		catch(PDOException $e) {
		echo $e->getMessage();
	}

	if($_GET['action'] == 'Calculadora')
	{
		$Cantidad	= strip_tags(utf8_decode($_POST['Cantidad']));
		
		$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable" id="Cotizacion">
					<thead>
						<tr>
							<th colspan="3" ><input name="txtValorTeclado" id="txtValorTeclado" type="text" style="text-align:right" value="'.$Cantidad.'" readonly="readonly"/></th>
						</tr>
					</thead>
					</tbody>
						<tr>
							<td align="center"><input name="btnSiete" id="btnSiete" type="button" class="blueB" value="7"/></td>
							<td align="center"><input name="btnOcho" id="btnOcho" type="button" class="blueB" value="8"/></td>
							<td align="center"><input name="btnNueve" id="btnNueve" type="button" class="blueB" value="9"/></td>
						</tr>
						<tr>
							<td align="center"><input name="btnCuatro" id="btnCuatro" type="button" class="blueB" value="4"/></td>
							<td align="center"><input name="btnCinco" id="btnCinco" type="button" class="blueB" value="5"/></td>
							<td align="center"><input name="btnSeis" id="btnSeis" type="button" class="blueB" value="6"/></td>
						</tr>
						<tr>
							<td align="center"><input name="btnUno" id="btnUno" type="button" class="blueB" value="1"/></td>
							<td align="center"><input name="btnDos" id="btnDos" type="button" class="blueB" value="2"/></td>
							<td align="center"><input name="btnTres" id="btnTres" type="button" class="blueB" value="3"/></td>
						</tr>
						<tr>
							<td align="center"><input name="btnCero" id="btnCero" type="button" class="blueB" value="0"/></td>
							<td align="center"><input name="btnDosCero" id="btnDosCero" type="button" class="blueB" value="00"/></td>
							<td align="center"><input name="btnPunto" id="btnPunto" type="button" class="blueB" value="."/></td>
						</tr>
						<tr>
							<td align="center" colspan="2"><input name="btnLimpiar" id="btnLimpiar" type="button" class="blueB" value="C"/></td>
							<td align="center"><input name="btnBackSpace" id="btnBackSpace" type="button" class="blueB" value="CE"/></td>
						</tr>						
					</tbody>
			</table>';

		$html .= '';

		echo $html;				
	}
	
	if($_GET['action'] == 'Listar_Descripcion_Venta_Autocompletar')
	{

		$html = "";
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		if(isset($_GET["search"]))		
		$criterio = strtolower($_GET["search"]);
		
		if (!$criterio) return;
		
		try
		{		

			$stmt = $db->prepare("SELECT DISTINCT descripcion_venta FROM ventas WHERE  descripcion_venta LIKE '".$criterio."%'");
		
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}

		$c = 0;
			
		if ($nfilas > 0)
		{
			foreach ($rows as $row)
			{
				$Descripcion_Venta[$c] = utf8_encode($row['descripcion_venta']);
				$c++;
			}
		}
		
		$html = json_encode($Descripcion_Venta);
		
		echo $html;		
	
	}	

	if($_GET['action'] == 'Listar_Tipo_Venta')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM tipo_venta ORDER BY `descripcion_tipo_venta` ASC");
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}	

		if ($nfilas > 0)
		{
				
			$c = 1;
			foreach ($rows as $row)
			{
				$html .= "<option value='".base64_encode($row['id_tipo_venta'])."'>".utf8_encode($row['descripcion_tipo_venta'])."</option>";
			}
		}
		
		echo $html;
	}	

	if($_GET['action'] == 'Agregar_Articulo_Venta_x_Codigo_Barra')	
	{

		$html = "";
		
		try
		{		
			$CodigoBarra = strip_tags(utf8_decode($_POST['CodigoBarra']));		
		
			$stmt = $db->prepare("SELECT p.id_producto,nombre_producto,p.id_tipo_empaque,descripcion_empaque,precio_venta
			FROM producto p INNER JOIN tipo_empaque te ON (te.id_tipo_empaque = p.id_tipo_empaque)
			WHERE codigo_barra = ?");
			
			$p = 1;		
			$stmt->bindParam($p,$CodigoBarra,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}	
	
		if ($nfilas > 0)
		{
			$html = utf8_encode(base64_encode($rows[0]['id_producto']));
		}

		echo $html;
	}	
	
	
	if($_GET['action'] == 'Agregar_Articulo_Venta_x_Nombre_Producto')	
	{

		$html = "";
		
		try
		{		
			$ProductoBuscar = strip_tags(utf8_decode(base64_decode($_POST['ProductoBuscar'])));			
		
			$stmt = $db->prepare("SELECT p.id_producto,nombre_producto,p.id_tipo_empaque,descripcion_empaque,precio_venta
			FROM producto p INNER JOIN tipo_empaque te ON (te.id_tipo_empaque = p.id_tipo_empaque)
			WHERE MD5(id_producto) = ?");
			
			$p = 1;		
			$stmt->bindParam($p,$ProductoBuscar,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}	
	
		if ($nfilas > 0)
		{
			$html = utf8_encode(base64_encode($rows[0]['id_producto']));
		}

		echo $html;
	}	
	
	if($_GET['action'] == 'Agregar_Articulo_Venta')	
	{
		
		$html = "";
		
		try
		{		
			$IdProducto = strip_tags(utf8_decode(base64_decode($_POST['IdProducto'])));		
		
			$stmt = $db->prepare("SELECT p.id_producto,nombre_producto,p.id_tipo_empaque,descripcion_empaque,precio_venta,codigo_barra
			FROM producto p INNER JOIN tipo_empaque te ON (te.id_tipo_empaque = p.id_tipo_empaque)
			WHERE id_producto = ?");
			
			$p = 1;		
			$stmt->bindParam($p,$IdProducto,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}	
	
		if ($nfilas > 0)
		{
				
			$c = 0;
			$Producto = array();	
			foreach ($rows as $row)
			{
				$Producto[$c]['hidIdProducto'] = utf8_encode(base64_encode($row['id_producto']));
				$Producto[$c]['hidDescProducto'] = utf8_encode($row['nombre_producto']);
				$Producto[$c]['txtProducto'] = utf8_encode($row['nombre_producto']);
				$Producto[$c]['hidCodigoBarra'] = utf8_encode($row['codigo_barra']);
				$Producto[$c]['txtCodigoBarra'] = utf8_encode($row['codigo_barra']);
				$Producto[$c]['txtPrecio'] = utf8_encode($row['precio_venta']);
				$Producto[$c]['hidPrecio'] = utf8_encode($row['hidPrecio']);
				$Producto[$c]['txtTotal'] = utf8_encode($row['precio_venta']);
				$Producto[$c]['hidTotal'] = utf8_encode($row['hidPrecio']);				
				$c++;
			}
			
			$html = json_encode($Producto);		
		}

		echo $html;
	}	
	
	if($_GET['action'] == 'Agregar_Venta')	
	{	

		session_start();
		$db->beginTransaction();
		

		try
		{
			$NombreCliente	= strip_tags(utf8_decode($_POST['NombreCliente']));
			$DescripcionVenta	= strip_tags(utf8_decode($_POST['DescripcionVenta']));	
			$TipoVenta	= strip_tags(utf8_decode(base64_decode($_POST['TipoVenta'])));			
			$SubTotal	= strip_tags(utf8_decode($_POST['SubTotal']));
			$TotalITBM = strip_tags(utf8_decode($_POST['TotalITBM']));
			$TotalFinal = strip_tags(utf8_decode($_POST['TotalFinal']));
					
			//$Cantidad = explode(',',strip_tags(utf8_decode($_POST['Cantidad'])));
			$Cantidad = json_decode($_POST['Cantidad']);
			
			//$Producto = explode(',',strip_tags(utf8_decode($_POST['Producto'])));
			$Producto = json_decode($_POST['Producto']);
			
			//$Precio = explode(',',strip_tags(utf8_decode($_POST['Precio'])));
			$Precio = json_decode($_POST['Precio']);
		
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Tienda = base64_decode($_SESSION['id_tienda']);
			$Bodega = base64_decode($_SESSION['id_bodega']);			
			
			$stmt = $db->prepare("SELECT MAX(id_cotizaciones) AS Numero_Factura FROM cotizaciones");
			
			$stmt->execute();
			$rowsIdPC = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilasIdPC = $stmt->rowCount();
			$stmt->closeCursor();

			$stmt = $db->prepare("SELECT MAX(id_venta) AS Numero_Factura FROM ventas");
			
			$stmt->execute();
			$rowsIdPV = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilasIdPV = $stmt->rowCount();
			//$stmt->closeCursor();

			if ($rowsIdPC[0]['Numero_Factura'] > $rowsIdPV[0]['Numero_Factura'])
			{
				$Numero_Factura = $rowsIdPC[0]['Numero_Factura']+1;
			}
			else if ($rowsIdPC[0]['Numero_Factura'] < $rowsIdPV[0]['Numero_Factura'])
			{
				$Numero_Factura = "";
			}
			else if ($rowsIdPC[0]['Numero_Factura'] == $rowsIdPV[0]['Numero_Factura'])
			{
				$Numero_Factura = "";		
			}
			


			$stmt = $db->prepare("SELECT id_cliente,direccion,email 
			FROM cliente_persona WHERE CONCAT(nombre,' ',apellido) LIKE ?");

			$c = 1;
			$stmt->bindParam($c,$NombreCliente,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rowsC = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilasC = $stmt->rowCount();
			$stmt->closeCursor();
			
			$stmt = $db->prepare("SELECT id_cliente,ruc_parte_1,ruc_parte_2,ruc_parte_3,dv,direccion,email
			FROM cliente_empresa WHERE nombre_empresa LIKE ?");

			$c = 1;
			$stmt->bindParam($c,$NombreCliente,PDO::PARAM_STR,255);			
			
			$stmt->execute();
			$rowsE = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilasE = $stmt->rowCount();
			$stmt->closeCursor();			
			
			if($nfilasC > 0)
			{
				$Id_Tipo_Cliente = 1;
				$Id_Cliente = $rowsC[0]['id_cliente'];
				$Direccion = $rowsC[0]['direccion'];
				$Email = $rowsC[0]['email'];
			
			}
			else
			if($nfilasE > 0)
			{
				$Id_Tipo_Cliente = 2;			
				$Id_Cliente = $rowsE[0]['id_cliente'];
				$Direccion = $rowsE[0]['direccion'];
				$RUC = $rowsE[0]['ruc_parte_1']."-".$rowsE[0]['ruc_parte_2']."-".$rowsE[0]['ruc_parte_3'];
				$Email = $rowsE[0]['email'];
			}
			else
			{
				$Id_Tipo_Cliente = 1;
				$Evento = "Cliente Persona Agregado";
				$Tipo = "1";
				
				$stmt = $db->prepare("INSERT INTO cliente_persona (nombre,cliente_venta_rapida,fecha_creado) VALUES (?,1,NOW())");

				$c = 1;
				$stmt->bindParam($c,$NombreCliente,PDO::PARAM_STR,255);

				$Insertado5 = $stmt->execute();
			
				$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Cliente");
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$Id_Cliente = $results[0]["Id_Cliente"];

				$stmt = $db->prepare("INSERT INTO user_log (id_usuario,anio,fecha_log,evento,tipo) VALUES (?,YEAR(NOW()), NOW(),?,?)");
				$c = 1;
				$stmt->bindParam($c,$Id_Usuario,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$Evento,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Tipo,PDO::PARAM_INT);
	
				$Insertado6 = $stmt->execute();
				
				$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Log");
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$Id_Log = $results[0]["Id_Log"];
				
				$stmt = $db->prepare("INSERT INTO historial_cliente_persona (id_cliente_persona,id_log) VALUES (?,?)");
				$c = 1;
				$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
				$Insertado7 = $stmt->execute();					
			}
			

			$Evento = "Venta Agregada";
			$Tipo = "18";
			if($Numero_Factura!="")
			{
				$stmt = $db->prepare("INSERT INTO ventas (id_venta,descripcion_venta,id_tipo_venta,estatus_leido, monto_subtotal,monto_itbm,monto_total,id_cliente, id_tipo_cliente,fecha_creado) VALUES (?,?,?,0,?,?,?,?,?,'".date('Y-m-d H:i:s')."')");
			}
			else
			{
				$stmt = $db->prepare("INSERT INTO ventas (descripcion_venta,id_tipo_venta,estatus_leido, monto_subtotal,monto_itbm,monto_total,id_cliente, id_tipo_cliente,fecha_creado) VALUES (?,?,0,?,?,?,?,?,'".date('Y-m-d H:i:s')."')");
			}
			
			$c = 1;
			if($Numero_Factura!="")
			{
				$stmt->bindParam($c,$Numero_Factura,PDO::PARAM_STR,255);			
				$c++;
			}
			$stmt->bindParam($c,$DescripcionVenta,PDO::PARAM_STR,255);			
			$c++;			
			$stmt->bindParam($c,$TipoVenta,PDO::PARAM_STR,255);			
			$c++;			
			$stmt->bindParam($c,$SubTotal,PDO::PARAM_STR,255);			
			$c++;
			$stmt->bindParam($c,$TotalITBM,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$TotalFinal,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Id_Tipo_Cliente,PDO::PARAM_STR,255);
			//$c++;
			//$stmt->bindParam($c,$NotaCotizacion,PDO::PARAM_STR,255);			
					
			$Insertado = $stmt->execute();

			if($Numero_Factura!="")
			{
				$Id_Venta=$Numero_Factura;
			}
			else
			{
				$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Venta");
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$Id_Venta = $results[0]["Id_Venta"];
			}
			
			//echo count($Cantidad);
			//print_r ($DescripcionImprenta);
			//echo count($DescripcionImprenta);
			
			$i = 0; $CantItem = 0; $Trabajo = 0;
			while ($i < count($Cantidad))
			{

				$Producto[$i] = strip_tags(utf8_decode(base64_decode($Producto[$i])));			
							
				//echo $Costo;
				try
				{
					
					$stmt = $db->prepare("SELECT * FROM producto p 
					LEFT JOIN categoria c ON (p.id_categoria = c.id_categoria) 
					INNER JOIN tipo_empaque te ON (p.id_tipo_empaque = te.id_tipo_empaque)
					WHERE id_producto = ?");

					$c = 1;
					$stmt->bindParam($c,$Producto[$i],PDO::PARAM_STR,255);		
			
					$stmt->execute();
					$rowsP = $stmt->fetchAll(PDO::FETCH_ASSOC);
					//$nfilasP = $stmt->rowCount();
					$stmt->closeCursor();
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}				
			
				$Tipo_Empaque[$i]=$rowsP[0]['descripcion_empaque'];
				$Nombre_Producto[$i]=$rowsP[0]['descripcion_producto'];	
				
				$Cant = strip_tags(utf8_decode($Cantidad[$i]));
			
				$Id_Producto = $Producto[$i];				
		
				$stmt = $db->prepare("INSERT INTO venta_detalle (id_venta,cantidad,id_producto,precio_venta,fecha_agregado) VALUES (?,?,?,?,NOW())");
				$c = 1;
				$stmt->bindParam($c,$Id_Venta,PDO::PARAM_INT);	
				$c++;				
				$stmt->bindParam($c,$Cant,PDO::PARAM_INT);
				$c++;				
				$stmt->bindParam($c,$Id_Producto,PDO::PARAM_INT);
				$c++;				
				$stmt->bindParam($c,$Precio[$i],PDO::PARAM_INT);				

			
				

			//echo "INSERT INTO cotizacion_producto (id_cotizacion,cantidad,id_producto,id_libreta,id_factura) VALUES ($Id_Cotizacion,$Cant,$Id_Producto,$Id_Libreta,$Id_Factura)";
			
				
				$Insertado2 = $stmt->execute();
				//print_r($stmt->errorInfo());
				//echo $Insertado2;
				$CantItem = $Insertado2 + $CantItem;
				
				$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Venta_Detalle");
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$Id_Venta_Detalle = $results[0]["Id_Venta_Detalle"];				

				try
				{
					
					$stmt = $db->prepare("SELECT c.descripcion_categoria,pr.nombre_proveedor,m.id_producto,codigo_producto,IF(id_tipo_producto=1,descripcion_producto,nombre_producto) AS descripcion_producto,id_bodega,id_tienda,
					(IFNULL(SUM(balance_bodega),0)) AS total_bodega,(IFNULL(SUM(balance_tienda),0)) AS total_tienda,(IFNULL(SUM(balance_bodega),0) + (IFNULL(SUM(balance_tienda),0))) AS total_inventario
					FROM movimientos m
					INNER JOIN producto p ON (m.id_producto = p.id_producto)
					INNER JOIN proveedores pr ON (pr.id_proveedor = p.id_proveedor)
					INNER JOIN categoria c ON (c.id_categoria = p.id_categoria)
					WHERE m.estatus_movimiento = 1 AND m.id_producto = ? GROUP BY m.id_producto");

					$c = 1;
					$stmt->bindParam($c,$Producto[$i],PDO::PARAM_STR,255);		
			
					$stmt->execute();
					$rowsM = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$nfilasM = $stmt->rowCount();
					$stmt->closeCursor();
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}				

				
				if (($rowsM[0]['total_tienda']) > 0)
				{
					$stmt = $db->prepare("INSERT INTO movimientos (id_venta,id_venta_detalle,id_producto,id_tienda,balance_tienda,fecha_agregado)
					VALUES (?,?,?,?,?,'".date('Y-m-d H:i:s')."')");					
				
					$TiendaProcedencia = $Cantidad[$i]*-1;
					
					$p = 1;
					$stmt->bindParam($p,$Id_Venta,PDO::PARAM_INT);
					$p++;
					$stmt->bindParam($p,$Id_Venta_Detalle,PDO::PARAM_STR,255);					
					$p++;
					$stmt->bindParam($p,$Id_Producto,PDO::PARAM_STR,255);
					$p++;
					$stmt->bindParam($p,$Tienda,PDO::PARAM_STR,255);						
					$p++;
					$stmt->bindParam($p,$TiendaProcedencia,PDO::PARAM_STR,255);
				}
				else
				{
					$stmt = $db->prepare("INSERT INTO movimientos (id_venta,id_venta_detalle,id_producto,id_bodega,balance_bodega,fecha_agregado)
					VALUES (?,?,?,?,?,'".date('Y-m-d H:i:s')."')");					
				
					$BodegaProcedencia = $Cantidad[$i]*-1;
					
					$p = 1;
					$stmt->bindParam($p,$Id_Venta,PDO::PARAM_INT);
					$p++;
					$stmt->bindParam($p,$Id_Venta_Detalle,PDO::PARAM_STR,255);					
					$p++;
					$stmt->bindParam($p,$Id_Producto,PDO::PARAM_STR,255);
					$p++;
					$stmt->bindParam($p,$Bodega,PDO::PARAM_STR,255);						
					$p++;
					$stmt->bindParam($p,$BodegaProcedencia,PDO::PARAM_STR,255);
				}
				
				$Insertado4 = $stmt->execute();	
				$CantMov = $Insertado5  + $CantMov ;				
				
				
				$i = $i + 1;
			}				
				
			
			$stmt = $db->prepare("INSERT INTO user_log (id_usuario,anio,fecha_log,evento,tipo) VALUES (?,YEAR(NOW()), NOW(),?,?)");
			$c = 1;
			$stmt->bindParam($c,$Id_Usuario,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Evento,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Tipo,PDO::PARAM_INT);
	
			$Insertado3 = $stmt->execute();
				
			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Log");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Log = $results[0]["Id_Log"];
				
			$stmt = $db->prepare("INSERT INTO historial_venta (id_venta,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$Id_Venta,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado4 = $stmt->execute();			
				
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();		
		}	
	
		//echo "$Insertado-$Insertado3-$Insertado4-$CantItem-$Cantidad-";
	
		if (($Insertado === true)  and ($Insertado3 === true) and ($Insertado4 === true) and ($CantItem > 0) and (count($Cantidad) == $CantItem))
		{
			echo md5($Id_Venta);
			$db->commit();
		}
		else
		{
			echo "false";
			$db->rollBack();
		}
	
	}
	
	if($_GET['action'] == 'Listar_Venta_Rapida')
	{
		$html = "";
		session_start();
		$objDatabase = new Database();
		$bindings = array();
		$ResultSet = array();
		$Length = ($_POST['length']);
		$Start = ($_POST['start']);
		$Draw = ($_POST['draw']);

		$limit = $objDatabase->limit($_POST);		
		
		$columns = array(
			array( 'db' => 'id_venta', 'dt' => 0 ),
			array( 'db' => 'usuario',  'dt' => 1 ),
			array( 'db' => 'nombre_cliente',   'dt' => 2 ),
			array( 'db' => 'descripcion_tipo_venta',   'dt' => 3 ),
			array( 'db' => 'monto_total',   'dt' => 4 ),
			array( 'db' => 'opciones',   'dt' => 5 ),			
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS id_cliente,id_tipo_cliente,ve.id_venta,tv.id_tipo_venta, descripcion_tipo_venta,monto_subtotal,monto_itbm,monto_total,usuario
			FROM ventas ve INNER JOIN tipo_venta tv ON (tv.id_tipo_venta = ve.id_tipo_venta)
			INNER JOIN historial_venta hv ON (hv.id_venta = ve.id_venta)
			INNER JOIN user_log ul ON (ul.id_log = hv.id_log)
			INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
			".$where.(($where == "")?"WHERE":" AND")." ve.estatus_leido = 0 AND ul.tipo = 18 ".$order." ".$limit);
			
			if ( is_array( $bindings ) ) {
				for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
					$binding = $bindings[$i];
									
					$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
				}
			}			
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			

			
			$stmt = $db->prepare("SELECT FOUND_ROWS()");
			
			$stmt->execute();
			$resFilterLength = $stmt->fetchColumn (0);

			$stmt = $db->prepare("SELECT COUNT(id_venta)
			FROM ventas ve INNER JOIN tipo_venta tv ON (tv.id_tipo_venta = ve.id_tipo_venta)
			INNER JOIN historial_venta hv ON (hv.id_venta = ve.id_venta)
			INNER JOIN user_log ul ON (ul.id_log = hv.id_log)
			INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
			WHERE ve.estatus_leido = 0 AND ul.tipo = 18");			
				
			$stmt->execute();			
			$recordsTotal = $stmt->fetchColumn (0);			
			
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
			
		/*$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable" id="Cotizacion"><thead><tr>';			

		$html .= '<th style="width:2%"></th>
				<th style="width:26%">Generado Por
				<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
				<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
				<th style="width:26%">Nombre del Cliente</th>
				<th style="width:25%">Tipo de Venta</th>
				<th style="width:10%">Monto Total</th>
				<th style="width:11%">Opciones</th>';	

		$html .= '</tr>
            </thead>
            <tbody>';
			  			  
			  

		if ($nfilas > 0)
		{
				
			$c = 1;
			foreach ($rows as $row)
			{				
				
				try
				{		
					
					$Id_Cliente = $row['id_cliente'];
					
					if($row['id_tipo_cliente']==1)
					$stmt = $db->prepare("SELECT CONCAT(nombre,' ',apellido) AS Nombre_Cliente,credito 
					FROM cliente_persona WHERE id_cliente = ?");
					else if($row['id_tipo_cliente']==2)
					$stmt = $db->prepare("SELECT nombre_empresa AS Nombre_Cliente,credito
					FROM cliente_empresa  WHERE id_cliente = ?");
					
					$p = 1;
					$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_INT);
			
					$stmt->execute();
					$rowsCliente = $stmt->fetchAll(PDO::FETCH_ASSOC);
					//$nfilas = $stmt->rowCount();
					$stmt->closeCursor();
					
					$NombreCliente = $rowsCliente[0]['Nombre_Cliente'];
					$Credito = $rowsCliente[0]['credito'];
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}
								
				$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
						<td  align="center">'.$c.'</td>
						<td align="center" >'.utf8_encode($row['usuario']).'<input type="hidden" id="hidUsuario'.$c.'" name="hidUsuario[]" value="'.utf8_encode($row['usuario']).'" /></td>
						<td>'.utf8_encode($NombreCliente).'<input type="hidden" id="hidNombreCliente'.$c.'" name="hidNombreCliente[]" value="'.utf8_encode($NombreCliente).'" /></td>
						<td>'.utf8_encode($row['descripcion_tipo_venta']).'<input type="hidden" id="hidIdTipoVenta'.$c.'" name="hidIdTipoVenta[]" value="'.utf8_encode($row['id_tipo_venta']).'" /></td>
						<td align="center" >'.utf8_encode(number_format($row['monto_total'],2,'.','')).'<input type="hidden" id="hidMontoTotal'.$c.'" name="hidMontoTotal[]" value="'.utf8_encode(number_format($row['monto_total'],2,'.','')).'" /></td>';
						
						
					if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
					{
						$html .='</td><td>';
				
						$html .='<a href="javascript:void(0);" title="Ver Factura Venta" class="smallButton" style="margin: 5px;" onclick="Ver_Venta_Rapida(\''.utf8_encode(md5($row['id_venta'])).'\');"><img src="public/images/icons/color/blue-document-pdf-text.png" alt="" class="icon" /><span></span></a>';

						
						$html .='<a href="javascript:void(0);" title="Cerrar" class="smallButton" style="margin: 5px;" onclick="Cerrar_Venta('.$c.')"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					}
					else
					{
						$html .='</td><td>';
					}
					$html .='<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_venta'])).'" /></td>					
					</tr>';
					
				$c = $c + 1;
			}

		}
		  
		$html .= '
              </tbody></table>';	
		echo $html;*/
		
		$Data = array();		
		if ($nfilas > 0)
		{

			$f = 0;
			foreach ($rows as $row)
			{
				try
				{		
					
					$Id_Cliente = $row['id_cliente'];
					
					if($row['id_tipo_cliente']==1)
					$stmt = $db->prepare("SELECT CONCAT(nombre,' ',apellido) AS Nombre_Cliente,credito 
					FROM cliente_persona WHERE id_cliente = ?");
					else if($row['id_tipo_cliente']==2)
					$stmt = $db->prepare("SELECT nombre_empresa AS Nombre_Cliente,credito
					FROM cliente_empresa  WHERE id_cliente = ?");
					
					$p = 1;
					$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_INT);
			
					$stmt->execute();
					$rowsCliente = $stmt->fetchAll(PDO::FETCH_ASSOC);
					//$nfilas = $stmt->rowCount();
					$stmt->closeCursor();
					
					$NombreCliente = $rowsCliente[0]['Nombre_Cliente'];
					$Credito = $rowsCliente[0]['credito'];
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}				
				
				$c=0;
				
				$Data[$f][$c] = $f+1;
				$c++;
				$Data[$f][$c] = utf8_encode($row['usuario']).'<input type="hidden" id="hidUsuario'.$f.'" name="hidUsuario[]" value="'.utf8_encode($row['usuario']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($NombreCliente).'<input type="hidden" id="hidNombreCliente'.$f.'" name="hidNombreCliente[]" value="'.utf8_encode($NombreCliente).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['descripcion_tipo_venta']).'<input type="hidden" id="hidIdTipoVenta'.$f.'" name="hidIdTipoVenta[]" value="'.utf8_encode($row['id_tipo_venta']).'" />';
				$c++;
				$Data[$f][$c] = 'B/.&nbsp;'.utf8_encode(number_format($row['monto_total'],2,'.','')).'<input type="hidden" id="hidMontoTotal'.$f.'" name="hidMontoTotal[]" value="'.utf8_encode(number_format($row['monto_total'],2,'.','')).'" />';
				$c++;
				
				$Data[$f][$c] = "";
				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
				{
					$Data[$f][$c] .= '<a href="javascript:void(0);" title="Ver Factura Venta" class="smallButton" style="margin: 5px;" onclick="Ver_Venta_Rapida(\''.utf8_encode(md5($row['id_venta'])).'\');"><img src="public/images/icons/color/blue-document-pdf-text.png" alt="" class="icon" /><span></span></a>';
					$Data[$f][$c] .= '<a href="javascript:void(0);" title="Cerrar" class="smallButton" style="margin: 5px;" onclick="Cerrar_Venta('.$f.')"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
				}
			
				$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_venta'])).'" />';

			
				$f = $f + 1;
			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;		
		echo json_encode($ResultSet);	
		
	}	

	if($_GET['action'] == 'Ver_Venta_Rapida')
	{

	
		include('../../library/Generar_Venta_Rapida.php');

		$objGenerarVentaRapida =  new Generar_Venta_Rapida();

		$Id_Venta	= strip_tags(utf8_decode($_POST['id']));	
		//echo mysql_error($conexion);

		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,ve.id_venta,tv.id_tipo_venta, descripcion_tipo_venta,monto_subtotal,monto_itbm,monto_total,usuario,fecha_creado
			FROM ventas ve INNER JOIN tipo_venta tv ON (tv.id_tipo_venta = ve.id_tipo_venta)
			INNER JOIN historial_venta hv ON (hv.id_venta = ve.id_venta)
			INNER JOIN user_log ul ON (ul.id_log = hv.id_log)
			INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
			WHERE MD5(ve.id_venta) = ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Venta,PDO::PARAM_STR,255);
			
			$stmt->execute();
			
			//print_r($stmt->errorInfo());			
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		
		
		if ($rows[0]['id_tipo_cliente'] == 1)
		{
			try
			{		
				$Id_Cliente = $rows[0]['id_cliente'];
				
				$stmt = $db->prepare("SELECT id_cliente,CONCAT(nombre,' ',apellido) AS Nombre_Cliente,direccion,email 
				FROM cliente_persona WHERE id_cliente = ?");			
		
				$p = 1;
				$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_STR,255);
			
				$stmt->execute();
				$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas1 = $stmt->rowCount();
				$stmt->closeCursor();
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}		
		
		
		
		
		
		}
		else if ($rows[0]['id_tipo_cliente'] == 2)
		{
		
			try
			{		
				$Id_Cliente = $rows[0]['id_cliente'];
				
				$stmt = $db->prepare("SELECT id_cliente,nombre_empresa AS Nombre_Cliente,ruc_parte_1,ruc_parte_2,ruc_parte_3,dv,direccion,email
				FROM cliente_empresa WHERE id_cliente = ?");				

				$p = 1;
				$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_STR,255);
			
				$stmt->execute();
				$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas1 = $stmt->rowCount();
				$stmt->closeCursor();
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}		
		
		}

		
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM venta_detalle WHERE MD5(id_venta) = ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Venta,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas2 = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}		
		
		if ($nfilas2 > 0)
		{
			$c = 0;
			foreach ($rows2 as $row)
			{			
				$Cantidad[$c] = $row['cantidad'];
				
				try
				{	
					$Id_Producto = $row['id_producto'];	
					$stmt = $db->prepare("SELECT * FROM producto p 
					INNER JOIN categoria c ON (p.id_categoria = c.id_categoria) 
					INNER JOIN tipo_empaque te ON (p.id_tipo_empaque = te.id_tipo_empaque)
					WHERE id_producto = ?");

					$p = 1;
					$stmt->bindParam($p,$Id_Producto,PDO::PARAM_INT);
		
					$stmt->execute();
					$rows3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$nfilas3 = $stmt->rowCount();
					$stmt->closeCursor();
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}				
				
				if($row['precio_venta'] != "")
				{
					$Precio[$c] = $row['precio_venta'];
				}
				else
				{


					$Precio[$c] = $rows3[0]['precio_venta'];					
				}
				
				$Nombre_Producto[$c] = utf8_encode($rows3[0]['nombre_producto']);

				$Tipo_Empaque[$c] = utf8_encode($rows3[0]['descripcion_empaque']);
				$PapelTipo[$c] = "";
				$Tamano[$c] = "";
				$CantidadCopia[$c] = "";
				$ColorTinta[$c] = "";
				$TipoForro[$c] = "";
				$ColorPapel[$c] = "";
				$ColorPapel1[$c] = "";
				$ColorPapel2[$c] = "";
				$ColorPapel3[$c] = "";					
				$TipoTiempo[$c] = "";
				$TipoCategoria[$c] = "";

				
				
				$c = $c + 1;
			}
		
		}
		
				$mensaje[0] = $rows[0]['id_venta'];
				$mensaje[1] = $rows1[0]['Nombre_Cliente'];
				$mensaje[2] = $rows1[0]['direccion'];
				$mensaje[3] = $rows1[0]['ruc_parte_1']."-".$rows1[0]['ruc_parte_2']."-".$rows1[0]['ruc_parte_3'];
				$mensaje[4] = $rows[0]['monto_subtotal'];			
				$mensaje[5] = $rows[0]['monto_itbm'];			
				$mensaje[6] = $rows[0]['monto_total'];
				

				$mensaje[7] = $Cantidad;
				$mensaje[8] = $Nombre_Producto;
				$mensaje[9] = $Tipo_Empaque;				
				$mensaje[10] = $Precio;
				$mensaje[11] = $rows1[0]['dv'];	
				/*$mensaje[11] = $PapelTipo;			
				$mensaje[12] = $Tamano;
				$mensaje[13] = $CantidadCopia;				
				$mensaje[14] = $ColorTinta;
				$mensaje[15] = $ColorPapel;
				$mensaje[16] = $ColorPapel1;			
				$mensaje[17] = $ColorPapel2;
				$mensaje[18] = $ColorPapel3;				
				$mensaje[19] = $TipoForro;
				$mensaje[20] = $Tiempo;
				$mensaje[21] = $TipoTiempo;
				$mensaje[22] = $TipoCategoria;*/				

				$hoy=date('Y-m-d',strtotime($rows[0]['fecha_creado']));
				$desde=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy)),date("Y", strtotime($hoy))));
				$hasta=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy))+30,date("Y", strtotime($hoy))));					
				
				$objGenerarVentaRapida->Generar_Venta($desde, $hasta, $mensaje);
				
				echo 'tmp/Factura_Innovations_Print_'.$mensaje[0].'_'.$desde.'.pdf';

	}

	if($_GET['action'] == 'Cerrar_Venta')	
	{

		session_start();
		$db->beginTransaction();
		try
		{
			$Id_Venta = strip_tags(utf8_decode($_POST['IdVenta']));				
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Venta Cerrada";
			$Tipo = "19";			

			$stmt = $db->prepare("SELECT * FROM ventas WHERE MD5(id_venta) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Venta,PDO::PARAM_STR,255);
			$stmt->execute();
			//print_r($stmt->errorInfo());			
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_venta = $results[0]["id_venta"];	
			$stmt->closeCursor();	
			
			$stmt = $db->prepare("UPDATE ventas SET estatus_leido = 1 WHERE MD5(id_venta) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Venta,PDO::PARAM_STR,255);
			$Actualizado = $stmt->execute();				
		
			$stmt = $db->prepare("INSERT INTO user_log (id_usuario,anio,fecha_log,evento,tipo) VALUES (?,YEAR(NOW()), NOW(),?,?)");
			$c = 1;
			$stmt->bindParam($c,$Id_Usuario,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Evento,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Tipo,PDO::PARAM_INT);
	
			$Insertado1 = $stmt->execute();
			
			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Log");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Log = $results[0]["Id_Log"];
				
			$stmt = $db->prepare("INSERT INTO historial_venta (id_venta,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_venta,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();				
				
			$stmt->closeCursor();
				
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
	
		if (($Actualizado === true) and ($Insertado1 === true) and ($Insertado2 === true))
		{
			echo "true";
			$db->commit();
		}
		else
		{
			echo "false";
			$db->rollBack();
		}
		
	}

	if($_GET['action'] == 'Reporte_Venta_Rapida')
	{
		$html = "";
		session_start();
		$objDatabase = new Database();
		$bindings = array();
		$ResultSet = array();
		$Length = ($_POST['length']);
		$Start = ($_POST['start']);
		$Draw = ($_POST['draw']);

		$limit = $objDatabase->limit($_POST);		
		
		$columns = array(
			array( 'db' => 'id_venta', 'dt' => 0 ),
			array( 'db' => 'fecha',  'dt' => 1 ),
			array( 'db' => 'hora',   'dt' => 2 ),
			array( 'db' => 'usuario',   'dt' => 3 ),
			array( 'db' => 'nombre_cliente',   'dt' => 4 ),
			array( 'db' => 'descripcion_tipo_venta',   'dt' => 5 ),
			array( 'db' => 'monto_subtotal',   'dt' => 6 ),
			array( 'db' => 'monto_itbm',   'dt' => 7 ),	
			array( 'db' => 'monto_total',   'dt' => 8 ),			
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			$Desde	= strip_tags(utf8_decode($_POST['Desde']));	
			$Hasta	= strip_tags(utf8_decode($_POST['Hasta']));
			
			$HoraDesde	= strip_tags(utf8_decode($_POST['HoraDesde']));	
			$HoraHasta	= strip_tags(utf8_decode($_POST['HoraHasta']));			
			
			$desde = explode("-",$Desde);
			$hasta = explode("-",$Hasta);
			
			$fecha_desde = (($Desde!="")?$desde[2]."-".$desde[1]."-".$desde[0]:"")." ".$HoraDesde;
			$fecha_hasta = (($Hasta!="")?$hasta[2]."-".$hasta[1]."-".$hasta[0]:"")." ".$HoraHasta;		
			
			
			$Contado	= strip_tags(utf8_decode($_POST['Contado']));	
			$Credito	= strip_tags(utf8_decode($_POST['Credito']));
		
			
			if (($Desde == "") and ($Hasta == "") and ($Contado == "false") and ($Credito == "false"))
			{
				$Sql1 = "SELECT id_cliente,id_tipo_cliente,ve.id_venta,tv.id_tipo_venta, descripcion_tipo_venta,monto_subtotal,monto_itbm,monto_total,usuario,DATE(fecha_creado) AS fecha,TIME(fecha_creado) AS hora
				FROM ventas ve INNER JOIN tipo_venta tv ON (tv.id_tipo_venta = ve.id_tipo_venta)
				INNER JOIN historial_venta hv ON (hv.id_venta = ve.id_venta)
				INNER JOIN user_log ul ON (ul.id_log = hv.id_log)
				INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
				WHERE ul.tipo = 18";
				
				$Sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT(id_venta),id_cliente,id_tipo_cliente,id_tipo_venta,descripcion_tipo_venta,monto_subtotal,monto_itbm,monto_total,usuario,fecha,hora 
				FROM (".$Sql1.") AS T ".$where." ".$order." ".$limit;				

				$stmt = $db->prepare($Sql);	

				if ( is_array( $bindings ) ) {
					for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
						$binding = $bindings[$i];
										
						$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
					}
				}				
			}
			else
			{
				$Sql1 = "SELECT id_cliente,id_tipo_cliente,ve.id_venta,tv.id_tipo_venta, descripcion_tipo_venta,monto_subtotal,monto_itbm,monto_total,usuario,DATE(fecha_creado) AS fecha,TIME(fecha_creado) AS hora
				FROM ventas ve INNER JOIN tipo_venta tv ON (tv.id_tipo_venta = ve.id_tipo_venta)
				INNER JOIN historial_venta hv ON (hv.id_venta = ve.id_venta)
				INNER JOIN user_log ul ON (ul.id_log = hv.id_log)
				INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)";			
				
				$where1 = "";
				
				if(($Desde != "") and ($Hasta == ""))
				$where1 .= " WHERE fecha_creado >= ?";
				
				if(($Desde == "") and ($Hasta != ""))
				$where1 .= " WHERE fecha_creado <= ?";				
				
				if(($Desde != "") and ($Hasta != ""))
				$where1 .= " WHERE  fecha_creado BETWEEN ? AND ?";				
				
				if (($Contado=="true") and ($Credito=="false"))
				{
					if ($where1 == "")
					$where1 .= " WHERE  ve.id_tipo_venta = 1";
					else
					$where1 .= " AND ve.id_tipo_venta = 1";
				}
				
				if (($Credito=="true") and ($Contado=="false"))
				{
					if ($where1 == "")
					$where1 .= " WHERE ve.id_tipo_venta = 2";
					else
					$where1 .= " AND ve.id_tipo_venta = 2";
				}		

				$Sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT(id_venta),id_cliente,id_tipo_cliente,id_tipo_venta,descripcion_tipo_venta,monto_subtotal,monto_itbm,monto_total,usuario,fecha,hora
				FROM (".$Sql1.$where1." AND ul.tipo = 18 ) AS T ".$where." ".$order." ".$limit;				

				$stmt = $db->prepare($Sql);
				

				if ( is_array( $bindings ) ) {
					for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
						$binding = $bindings[$i];
										
						$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
					}
				}				

				if(($Desde != "") and ($Hasta != ""))
				{
					$p = 1;
					$stmt->bindParam($p,$fecha_desde,PDO::PARAM_STR,255);
					$p++;
					$stmt->bindParam($p,$fecha_hasta,PDO::PARAM_STR,255);
				}
				else if(($Desde != "") and ($Hasta == ""))
				{
					$p = 1;
					$stmt->bindParam($p,$fecha_desde,PDO::PARAM_STR,255);				
				}
				else if(($Desde == "") and ($Hasta != ""))
				{				
					$p = 1;
					$stmt->bindParam($p,$fecha_hasta,PDO::PARAM_STR,255);			
;				}
			
			}
		
			//print_r($stmt);
			//echo $Contado;
			//print_r($stmt->errorInfo());	
				
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			
			$stmt = $db->prepare("SELECT FOUND_ROWS()");
			
			$stmt->execute();
			$resFilterLength = $stmt->fetchColumn (0);
			
			if (($Desde == "") and ($Hasta == "") and ($Contado == "false") and ($Credito == "false"))
			{
				$stmt = $db->prepare("SELECT count(ve.id_venta)
				FROM ventas ve INNER JOIN tipo_venta tv ON (tv.id_tipo_venta = ve.id_tipo_venta)
				INNER JOIN historial_venta hv ON (hv.id_venta = ve.id_venta)
				INNER JOIN user_log ul ON (ul.id_log = hv.id_log)
				INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
				WHERE ul.tipo = 18");			
					
				$stmt->execute();			
				$recordsTotal = $stmt->fetchColumn (0);				
			}
			else
			{
				$stmt = $db->prepare("SELECT count(ve.id_venta)
				FROM ventas ve INNER JOIN tipo_venta tv ON (tv.id_tipo_venta = ve.id_tipo_venta)
				INNER JOIN historial_venta hv ON (hv.id_venta = ve.id_venta)
				INNER JOIN user_log ul ON (ul.id_log = hv.id_log)
				INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)".$where1." AND ul.tipo = 18");			
				
				if(($Desde != "") and ($Hasta != ""))
				{
					$p = 1;
					$stmt->bindParam($p,$fecha_desde,PDO::PARAM_STR,255);
					$p++;
					$stmt->bindParam($p,$fecha_hasta,PDO::PARAM_STR,255);
				}
				else if(($Desde != "") and ($Hasta == ""))
				{
					$p = 1;
					$stmt->bindParam($p,$fecha_desde,PDO::PARAM_STR,255);				
				}
				else if(($Desde == "") and ($Hasta != ""))
				{				
					$p = 1;
					$stmt->bindParam($p,$fecha_hasta,PDO::PARAM_STR,255);			
;				}
				
				$stmt->execute();			
				$recordsTotal = $stmt->fetchColumn (0);				
				
			}
			
			
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		/*	
		$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable"  style="table-layout: fixed;word-wrap:break-word;"id="Venta"><thead><tr>';			

		$html .= '<th style="width:2%"></th>
				<th style="width:10%">Fecha</th>
				<th style="width:10%">Hora</th>
				<th style="width:10%">Generado Por
				<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
				<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
				<th style="width:23%">Nombre del Cliente</th>
				<th style="width:15%">Tipo de Venta</th>
				<th style="width:10%">SubTotal</th>
				<th style="width:10%">ITBM</th>
				<th style="width:10%">Total</th>';	

		$html .= '</tr>
            </thead>
            <tbody>';
			  			  
			  

		if ($nfilas > 0)
		{
				
			$c = 1;
			foreach ($rows as $row)
			{				
				
				try
				{		
					
					$Id_Cliente = $row['id_cliente'];
					
					if($row['id_tipo_cliente']==1)
					$stmt = $db->prepare("SELECT CONCAT(nombre,' ',apellido) AS Nombre_Cliente,credito 
					FROM cliente_persona WHERE id_cliente = ?");
					else if($row['id_tipo_cliente']==2)
					$stmt = $db->prepare("SELECT nombre_empresa AS Nombre_Cliente,credito
					FROM cliente_empresa  WHERE id_cliente = ?");
					
					$p = 1;
					$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_INT);
			
					$stmt->execute();
					$rowsCliente = $stmt->fetchAll(PDO::FETCH_ASSOC);
					//$nfilas = $stmt->rowCount();
					$stmt->closeCursor();
					
					$NombreCliente = $rowsCliente[0]['Nombre_Cliente'];
					$Credito = $rowsCliente[0]['credito'];
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}
								
				$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
						<td  align="center">'.$c.'</td>
						<td align="center" >'.utf8_encode($row['fecha']).'<input type="hidden" id="hidUsuario'.$c.'" name="hidFecha[]" value="'.utf8_encode($row['fecha']).'" /></td>
						<td align="center" >'.utf8_encode($row['hora']).'<input type="hidden" id="hidUsuario'.$c.'" name="hidHora[]" value="'.utf8_encode($row['hora']).'" /></td>						
						<td align="center" >'.utf8_encode($row['usuario']).'<input type="hidden" id="hidUsuario'.$c.'" name="hidUsuario[]" value="'.utf8_encode($row['usuario']).'" /></td>
						<td align="center" >'.utf8_encode($NombreCliente).'<input type="hidden" id="hidNombreCliente'.$c.'" name="hidNombreCliente[]" value="'.utf8_encode($NombreCliente).'" /></td>
						<td align="center" >'.utf8_encode($row['descripcion_tipo_venta']).'<input type="hidden" id="hidIdTipoVenta'.$c.'" name="hidIdTipoVenta[]" value="'.utf8_encode($row['id_tipo_venta']).'" /></td>		
						<td align="center" >B/.&nbsp;'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'<input type="hidden" id="hidMontoSubTotal'.$c.'" name="hidMontoSubTotal[]" value="'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'" /></td>						
						<td align="center" >B/.&nbsp;'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'<input type="hidden" id="hidMontoITBM'.$c.'" name="hidMontoITBM[]" value="'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'" /></td>
						<td align="center" >B/.&nbsp;'.utf8_encode(number_format($row['monto_total'],2,'.','')).'<input type="hidden" id="hidMontoTotal'.$c.'" name="hidMontoTotal[]" value="'.utf8_encode(number_format($row['monto_total'],2,'.','')).'" />';							

					$html .='<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_venta'])).'" /></td>					
					</tr>';
					
				$c = $c + 1;
			}

		}
		  
		$html .= '
              </tbody></table>';	
		echo $html;*/
		
		$Data = array();		
		if ($nfilas > 0)
		{
				
			$f = 0;
			foreach ($rows as $row)
			{				
				
				try
				{		
					
					$Id_Cliente = $row['id_cliente'];
					
					if($row['id_tipo_cliente']==1)
					$stmt = $db->prepare("SELECT CONCAT(nombre,' ',apellido) AS Nombre_Cliente,credito 
					FROM cliente_persona WHERE id_cliente = ?");
					else if($row['id_tipo_cliente']==2)
					$stmt = $db->prepare("SELECT nombre_empresa AS Nombre_Cliente,credito
					FROM cliente_empresa  WHERE id_cliente = ?");
					
					$p = 1;
					$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_INT);
			
					$stmt->execute();
					$rowsCliente = $stmt->fetchAll(PDO::FETCH_ASSOC);
					//$nfilas = $stmt->rowCount();
					$stmt->closeCursor();
					
					$NombreCliente = $rowsCliente[0]['Nombre_Cliente'];
					$Credito = $rowsCliente[0]['credito'];
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}
				
				$c=0;
				
				$Data[$f][$c] = $f+1;
				$c++;
				$Data[$f][$c] = utf8_encode($row['fecha']).'<input type="hidden" id="hidUsuario'.$f.'" name="hidFecha[]" value="'.utf8_encode($row['fecha']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['hora']).'<input type="hidden" id="hidUsuario'.$f.'" name="hidHora[]" value="'.utf8_encode($row['hora']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['usuario']).'<input type="hidden" id="hidUsuario'.$f.'" name="hidUsuario[]" value="'.utf8_encode($row['usuario']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($NombreCliente).'<input type="hidden" id="hidNombreCliente'.$f.'" name="hidNombreCliente[]" value="'.utf8_encode($NombreCliente).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['descripcion_tipo_venta']).'<input type="hidden" id="hidIdTipoVenta'.$f.'" name="hidIdTipoVenta[]" value="'.utf8_encode($row['id_tipo_venta']).'" />';
				$c++;
				$Data[$f][$c] = 'B/.&nbsp;'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'<input type="hidden" id="hidMontoSubTotal'.$f.'" name="hidMontoSubTotal[]" value="'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'" />';
				$c++;
				$Data[$f][$c] = 'B/.&nbsp;'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'<input type="hidden" id="hidMontoITBM'.$f.'" name="hidMontoITBM[]" value="'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'" />';
				$c++;
				$Data[$f][$c] = 'B/.&nbsp;'.utf8_encode(number_format($row['monto_total'],2,'.','')).'<input type="hidden" id="hidMontoTotal'.$f.'" name="hidMontoTotal[]" value="'.utf8_encode(number_format($row['monto_total'],2,'.','')).'" />';
				$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_venta'])).'" />';
				$c++;
								
				$f = $f + 1;
			}

		}
		
		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;		
		echo json_encode($ResultSet);		
		
	}
	
	if($_GET['action'] == 'Listar_Detalles_Ventas')
	{
		
		$html = "";
		session_start();

		$objDatabase = new Database();
		$bindings = array();
		$ResultSet = array();
		$Length = ($_POST['length']);
		$Start = ($_POST['start']);
		$Draw = ($_POST['draw']);

		$limit = $objDatabase->limit($_POST);		
		
		$columns = array(
			array( 'db' => 'id_cotizaciones', 'dt' => 0 ),
			array( 'db' => 'id_cotizaciones',  'dt' => 1 ),
			array( 'db' => 'nombre_cliente',   'dt' => 2 ),
			array( 'db' => 'descripcion_estatus',   'dt' => 3 ),
			array( 'db' => 'monto_subtotal',   'dt' => 4 ),
			array( 'db' => 'monto_itbm',   'dt' => 5 ),
			array( 'db' => 'monto_total',   'dt' => 6 ),
			array( 'db' => 'monto_abonado',   'dt' => 7 ),
			array( 'db' => 'opciones',   'dt' => 8 ),
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			$Sql1 = "SELECT id_cliente,id_tipo_cliente,id_cotizaciones,co.id_estatus, descripcion_estatus,monto_subtotal,monto_itbm,monto_total,
			IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones)) AS monto_abonado, 
			IF(id_tipo_cliente = 1,(SELECT CONCAT(nombre,' ',apellido) FROM cliente_persona WHERE id_cliente = co.id_cliente),(SELECT nombre_empresa FROM cliente_empresa WHERE id_cliente = co.id_cliente)) AS nombre_cliente
			FROM cotizaciones co INNER JOIN tipo_estatus_cotizacion te ON (te.id_estatus = co.id_estatus)
			WHERE co.id_estatus = 4
			ORDER BY id_cotizaciones DESC";
			
			$Sql = "SELECT SQL_CALC_FOUND_ROWS id_cotizaciones,nombre_cliente,descripcion_estatus,monto_subtotal,monto_itbm,monto_total,monto_abonado,id_estatus 
			FROM (".$Sql1.") AS T ".$where." ".$order." ".$limit;			
			
			$stmt = $db->prepare($Sql);
			
			
			if ( is_array( $bindings ) ) {
				for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
					$binding = $bindings[$i];
					$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
				}
			}			
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			
			$stmt = $db->prepare("SELECT FOUND_ROWS()");
			
			$stmt->execute();
			$resFilterLength = $stmt->fetchColumn (0);

			$stmt = $db->prepare("SELECT count(id_cotizaciones)
			FROM cotizaciones co INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus)
			WHERE co.id_estatus = 4");			
			
			$stmt->execute();			
			$recordsTotal = $stmt->fetchColumn (0);		
			
			$stmt->execute();
			
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
			
			
			
			
		/*$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable" id="Cotizacion" style="table-layout: fixed;word-wrap:break-word;"><thead><tr>';			

		$html .= '<th style="width:2%"></th>
				<th style="width:9%">N&uacute;mero de Cotizaci&oacute;n</th>
				<th style="width:23%">Nombre del Cliente</th>
				<th style="width:20%">Estatus de Cotizaci&oacute;n
				<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
				<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
				<th style="width:9%">Monto Sub-Total</th>
				<th style="width:9%">MontoITBM</th>
				<th style="width:9%">Monto Total</th>
				<th style="width:9%">Monto Abonado</th>
				<th style="width:10%">Opciones</th>';	

		$html .= '</tr>
            </thead>
            <tbody>';
			  			  
			  

		if ($nfilas > 0)
		{
				
			$c = 1;
			foreach ($rows as $row)
			{				
				
				try
				{		
					
					$Id_Cliente = $row['id_cliente'];
					
					if($row['id_tipo_cliente']==1)
					$stmt = $db->prepare("SELECT CONCAT(nombre,' ',apellido) AS Nombre_Cliente 
					FROM cliente_persona WHERE id_cliente = ?");
					else if($row['id_tipo_cliente']==2)
					$stmt = $db->prepare("SELECT nombre_empresa AS Nombre_Cliente
					FROM cliente_empresa  WHERE id_cliente = ?");
					
					$p = 1;
					$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_INT);
			
					$stmt->execute();
					$rowsCliente = $stmt->fetchAll(PDO::FETCH_ASSOC);
					//$nfilas = $stmt->rowCount();
					$stmt->closeCursor();
					
					$NombreCliente = $rowsCliente[0]['Nombre_Cliente'];
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}

				try
				{		
					
					$Id_Cliente = $row['id_cliente'];
					$Id_Cotizaciones = $row['id_cotizaciones'];
					
					$stmt = $db->prepare("SELECT  SUM(IF(id_imprenta,1,0) + IF(id_banner,1,0)) AS Trabajo
					FROM cotizaciones co
					INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus)
					INNER JOIN cotizacion_producto cp ON(cp.id_cotizacion = co.id_cotizaciones)
					WHERE id_cliente = ? AND id_cotizaciones = ? GROUP BY id_cotizaciones
					ORDER BY id_cotizaciones DESC");

					
					$p = 1;
					$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_INT);
					$p++;
					$stmt->bindParam($p,$Id_Cotizaciones,PDO::PARAM_INT);
					
					$stmt->execute();
					$rowsTrabajo = $stmt->fetchAll(PDO::FETCH_ASSOC);
					//$nfilas = $stmt->rowCount();
					$stmt->closeCursor();
					
					$TrabajoImprenta = $rowsTrabajo[0]['Trabajo'];
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}				
				
				
				$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
						<td  align="center">'.$c.'</td>
						<td align="center" >'.utf8_encode($row['id_cotizaciones']).'<input type="hidden" id="hidIdCotizacion'.$c.'" name="hidIdCotizacion[]" value="'.utf8_encode($row['id_cotizaciones']).'" /></td>
						<td>'.utf8_encode($NombreCliente).'<input type="hidden" id="hidNombreCliente'.$c.'" name="hidNombreCliente[]" value="'.utf8_encode($NombreCliente).'" /></td>
						<td>'.utf8_encode($row['descripcion_estatus']).'<input type="hidden" id="hidEstatusCotizacion'.$c.'" name="hidEstatusCotizacion[]" value="'.utf8_encode($row['descripcion_estatus']).'" /></td>
						<td>B/.&nbsp;'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'<input type="hidden" id="hidMontoSubTotal'.$c.'" name="hidMontoSubTotal[]" value="'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'" /></td>						
						<td>B/.&nbsp;'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'<input type="hidden" id="hidMontoITBM'.$c.'" name="hidMontoITBM[]" value="'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'" /></td>
						<td>B/.&nbsp;'.utf8_encode(number_format($row['monto_total'],2,'.','')).'<input type="hidden" id="hidMontoTotal'.$c.'" name="hidMontoTotal[]" value="'.utf8_encode(number_format($row['monto_total'],2,'.','')).'" />
						<td>B/.&nbsp;'.utf8_encode(number_format($row['monto_abonado'],2,'.','')).'<input type="hidden" id="hidMontoAbonado'.$c.'" name="hidMontoAbonado[]" value="'.utf8_encode(number_format($row['monto_abonado'],2,'.','')).'" />';						
						
					if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
					{
						$html .='</td><td>';
						$html .='<a href="javascript:void(0);" title="Imprimir" class="smallButton" style="margin: 5px;" onclick="Imprimir_Detalle_Venta(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/color/blue-document-pdf-text.png" alt="" class="icon" /><span></span></a>';
						
					}
					else
					{
						$html .='</td><td>';
					}
					$html .='<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_cotizaciones'])).'" /></td>					
					</tr>';
					
				$c = $c + 1;
			}

		}
		  
		$html .= '
              </tbody></table>';	
		echo $html;*/

		$Data = array();
		if ($nfilas > 0)
		{
				
			$f = 0;
			foreach ($rows as $row)
			{
				$c=0;
				$Data[$f][$c] = $f+1;
				$c++;
				$Data[$f][$c] = utf8_encode($row['id_cotizaciones']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['nombre_cliente']);
				$c++;
				$Data[$f][$c] = utf8_encode('<i class="fa fa-circle" style="color:'.((($row['id_estatus'])=="4")?'green;':((($row['id_estatus'])=="3")?'blue;':((($row['id_estatus'])=="2")?'yellow;':((($row['id_estatus'])=="1")?'red;':'')))).'"></i> '.$row['descripcion_estatus']);
				$c++;
				$Data[$f][$c] = utf8_encode(number_format($row['monto_subtotal'],2,'.',''));
				$c++;
				$Data[$f][$c] = utf8_encode(number_format($row['monto_itbm'],2,'.',''));
				$c++;
				$Data[$f][$c] = utf8_encode(number_format($row['monto_total'],2,'.',''));
				$c++;
				$Data[$f][$c] = utf8_encode(number_format($row['monto_abonado'],2,'.',''));
				
				$c++;
				$Data[$f][$c] = "";
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{				
					//$Data[$f][$c] .= '<button type="button" class="btn btn-success btn-circle" onclick="Editar_Articulo('.$f.')" title="Editar Art&iacute;culo"><i class="fa fa-link"></i></button>&nbsp;';
					//$Data[$f][$c] .= '<button type="button" class="btn btn-primary btn-circle" onclick="Imprimir_Etiqueta('.$f.')" title="Imprimir Etiqueta"><i class="fa fa-list"></i></button>&nbsp;';
					//$Data[$f][$c] .= '<button type="button" class="btn btn-danger btn-circle" onclick="if(confirm(\'Realmente quieres eliminar este Art&iacute;culo?\')){Eliminar_Articulo('.$f.',0);}" title="Eliminar Articulo"><i class="fa fa-times"></i></button>&nbsp;';
					$Data[$f][$c] .= '<a href="javascript:void(0);" title="Imprimir" class="smallButton" style="margin: 5px;" onclick="Imprimir_Detalle_Venta(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/color/blue-document-pdf-text.png" alt="" class="icon" /><span></span></a>';					
					
				}
				$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_cotizaciones'])).'" />';
			
				$f = $f + 1;
			}

		}
		
		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;		
		echo json_encode($ResultSet);			
		
	}	

?>