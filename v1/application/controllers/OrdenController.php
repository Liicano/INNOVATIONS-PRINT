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

	if($_GET['action'] == 'Mostrar_Numero_Orden')
	{
		$html = "";
		$TipoOrden = strip_tags(utf8_decode(base64_decode($_POST['TipoOrden'])));		
		try
		{		

			$stmt = $db->prepare("SELECT IFNULL(MAX(id_orden)+1,1) AS numero_orden FROM ordenes WHERE id_tipo_orden = ?");

			$p = 1;
			$stmt->bindParam($p,$TipoOrden,PDO::PARAM_STR,255);
			
			$stmt->execute();
			//print_r($stmt->errorInfo());
			$html = $stmt->fetchColumn(0);
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}

		echo $html;
	}
	
	if($_GET['action'] == 'Mostrar_Fecha_Orden')
	{
		$html = date('d-m-Y');
		
		echo $html;
	}	
	
	if($_GET['action'] == 'Listar_Tipo_Orden')
	{
		try
		{
			$stmt = $db->prepare("SELECT id_tipo_orden,descripcion_tipo_orden FROM tipo_orden");
			
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
				$html .= "<option value='".base64_encode($row['id_tipo_orden'])."'>".utf8_encode($row['descripcion_tipo_orden'])."</option>";
			}
		}
		
		echo $html;
	}	
	
	if($_GET['action'] == 'Listar_Tipo_Orden_Entrada')
	{
		try
		{
			$stmt = $db->prepare("SELECT count(id_bodega) AS Bodega FROM bodegas");
			
			$stmt->execute();
			$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas1 = $stmt->rowCount();			
			
			if($rows1[0]['Bodega'] > 1)
			$stmt = $db->prepare("SELECT id_tipo_orden_entrada,descripcion_tipo_orden_entrada FROM tipo_orden_entrada");
			else
			$stmt = $db->prepare("SELECT id_tipo_orden_entrada,descripcion_tipo_orden_entrada FROM tipo_orden_entrada WHERE id_tipo_orden_entrada != 3");
			
			$stmt->execute();
			//echo "prueba";
			//print_r($stmt->errorInfo());
			
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
				$html .= "<option value='".base64_encode($row['id_tipo_orden_entrada'])."'>".utf8_encode($row['descripcion_tipo_orden_entrada'])."</option>";
			}
		}
		
		echo $html;
	}	
	
	if($_GET['action'] == 'Validar_Orden')
	{
		$TipoOrden = strip_tags(utf8_decode(base64_decode($_POST['TipoOrden'])));
		$TipoOrdenEntrada = strip_tags(utf8_decode(base64_decode($_POST['TipoOrdenEntrada'])));
		$TipoOrdenInterno = strip_tags(utf8_decode(base64_decode($_POST['TipoOrdenInterno'])));
		$BodegaProcedencia = strip_tags(utf8_decode(base64_decode($_POST['BodegaProcedencia'])));
		$BodegaReceptora = strip_tags(utf8_decode(base64_decode($_POST['BodegaReceptora'])));			
		$TiendaProcedencia = strip_tags(utf8_decode(base64_decode($_POST['TiendaProcedencia'])));
		$TiendaReceptora = strip_tags(utf8_decode(base64_decode($_POST['TiendaReceptora'])));		
		$ProveedorProcedencia = strip_tags(utf8_decode($_POST['ProveedorProcedencia']));		
		//$FechaOrden	= strip_tags(utf8_decode($_POST['FechaOrden']));
		//$Autorizo	= strip_tags(utf8_decode($_POST['Autorizo']));		
		$Observaciones	= strip_tags(utf8_decode($_POST['Observaciones']));
		
		$Cantidad = json_decode($_POST['Cantidad']);
		$Producto = json_decode($_POST['Producto']);
	
		$a = 0;
		while ($a < count($Cantidad))
		{
			$Cantidad[$a] = strip_tags(utf8_decode($Cantidad[$a]));
			$Producto[$a] = strip_tags(utf8_decode(base64_decode($Producto[$a])));
			
			$a++;
		}

		$msg =  false; $mensaje = "false"; 
		$Error[0]['TipoOrden'] = "false";
		$Error[0]['TipoOrdenEntrada'] = "false";
		$Error[0]['BodegaProcedencia'] = "false";
		$Error[0]['BodegaReceptora'] = "false";		
		$Error[0]['TiendaProcedencia'] = "false";
		$Error[0]['TiendaReceptora'] = "false";		
		$Error[0]['ProveedorProcedencia'] = "false";		
		$Error[0]['Autorizo'] = "false";
		$Error[0]['Observaciones'] = "false";	
		
		
		$m = 0; $c = 0;
		if ($TipoOrden == "")
		{
			$msg[$m] = "- Debes seleccionar el Tipo de Orden<br />";	
			$Error[0]['TipoOrden'] = "true";			
			$m = $m + 1;			
		}

		if (($TipoOrden == "1") and ($TipoOrdenEntrada==""))
		{
			$msg[$m] = "- Debes seleccionar el Tipo de Orden de Entrada<br />";	
			$Error[0]['TipoOrdenEntrada'] = "true";			
			$m = $m + 1;			
		}		
		
		if (($TiendaProcedencia == "") and ((($TipoOrden=="1") and ($TipoOrdenEntrada=="2")) or (($TipoOrden=="3") and ($TipoOrdenInterno=="4"))))
		{
			$msg[$m] = "- Debes escribir la Tienda de Procedencia<br />";
			$Error[0]['TiendaProcedencia'] = "true";
			$m = $m + 1;			
		}		
		
		if (($BodegaProcedencia == "") and (($TipoOrden=="2") or (($TipoOrden=="1") and ($TipoOrdenEntrada=="3")) or (($TipoOrden=="3") and ($TipoOrdenInterno=="3"))))
		{
			$msg[$m] = "- Debes escribir la Bodega de Procedencia<br />";
			$Error[0]['BodegaProcedencia'] = "true";
			$m = $m + 1;			
		}

		if (($BodegaReceptora == "") and (($TipoOrden=="1") or (($TipoOrden=="3") and ($TipoOrdenInterno=="1"))))
		{
			$msg[$m] = "- Debes escribir la Bodega Receptora<br />";
			$Error[0]['BodegaReceptora'] = "true";
			$m = $m + 1;			
		}

		if (($BodegaReceptora == $BodegaProcedencia) and ($TipoOrden=="1"))
		{
			$msg[$m] = "- La Bodega Receptora y de Procedencia no debe ser Iguales<br />";
			$Error[0]['BodegaProcedencia'] = "true";
			$Error[0]['BodegaReceptora'] = "true";
			$m = $m + 1;			
		}		
		
		
		
		if (($TiendaReceptora == "") and (($TipoOrden=="2") or (($TipoOrden=="3") and ($TipoOrdenInterno=="2"))))
		{
			$msg[$m] = "- Debes escribir la Tienda Receptora<br />";
			$Error[0]['TiendaReceptora'] = "true";
			$m = $m + 1;			
		}
		
		if (($ProveedorProcedencia == "") and ($TipoOrden=="1") and ($TipoOrdenEntrada=="1"))
		{
			$msg[$m] = "- Debes escribir Proveedor  de Procedencia<br />";	
			$Error[0]['ProveedorProcedencia'] = "true";
			$m = $m + 1;			
		}		
				
		if (count($Cantidad) == 0)
		{
			$msg[$m] = "- Debes agregar al menos un Producto de la Orden<br />";
			
			$m = $m + 1;			
		}
		else
		{
			$a = 0;
			while($a < count($Cantidad))
			{
				if($Cantidad[$a] == "")
				{
					$msg[$m] = "- Debes escribir la Cantidad de Art&iacute;culo de la Fila ".($a+1)."<br />";
					$Error[$a]['Cantidad'] = "true";
					$m = $m + 1;				
				}
				else
				{
					if (($BodegaProcedencia != "") and (($TipoOrden=="2") or (($TipoOrden=="1") and ($TipoOrdenEntrada == 3))))
					{
						try
						{
							$stmt = $db->prepare("SELECT m.id_producto,codigo_producto,descripcion_producto,id_bodega,id_tienda,
							(IFNULL(SUM(balance_bodega),0)) AS total_bodega,(IFNULL(SUM(IF(balance_tienda>=0,balance_tienda,0)),0) + IFNULL(SUM(IF(abonado_por_entregar>=0,abonado_por_entregar,0)),0)) AS total_tienda,
							(IFNULL(SUM(balance_bodega),0) + IFNULL(SUM(IF(balance_tienda>=0,balance_tienda,0)),0) + IFNULL(SUM(IF(abonado_por_entregar>=0,abonado_por_entregar,0)),0)) AS total_inventario
							FROM movimientos m
							INNER JOIN producto a ON (m.id_producto = a.id_producto)
							WHERE id_bodega = ? AND m.id_producto = ? AND m.estatus_movimiento = 1
							GROUP BY id_producto");
							
							$p = 1;
							$stmt->bindParam($p,$BodegaProcedencia,PDO::PARAM_STR,255);	
							$p++;
							$stmt->bindParam($p,$Producto[$a],PDO::PARAM_STR,255);								

							$stmt->execute();
							$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas = $stmt->rowCount();
							$stmt->closeCursor();
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}		
						
						if ($rows[0]['total_bodega'] < $Cantidad[$a])
						{
							$msg[$m] = "- La Cantidad de Art&iacute;culo supera a la Cantidad de Art&iacute;culo en Bodega de la Fila ".($a+1)."<br />";	
							$Error[0]['Cantidad'] = "true";
							$m = $m + 1;
						}
					}
					
					if((($TiendaProcedencia != "") and ($TipoOrden=="1") and ($TipoOrdenEntrada=="2")))
					{
						try
						{
							$stmt = $db->prepare("SELECT m.id_producto,codigo_producto,descripcion_producto,id_bodega,id_tienda,
							(IFNULL(SUM(balance_bodega),0)) AS total_bodega,(IFNULL(SUM(IF(balance_tienda>=0,balance_tienda,0)),0) + IFNULL(SUM(IF(abonado_por_entregar>=0,abonado_por_entregar,0)),0)) AS total_tienda,
							(IFNULL(SUM(balance_bodega),0) + IFNULL(SUM(IF(balance_tienda>=0,balance_tienda,0)),0) + IFNULL(SUM(IF(abonado_por_entregar>=0,abonado_por_entregar,0)),0)) AS total_inventario
							FROM movimientos m
							INNER JOIN producto a ON (m.id_producto = a.id_producto)
							WHERE id_tienda = ? AND m.id_producto = ? AND m.estatus_movimiento = 1
							GROUP BY id_producto");
							
							$p = 1;
							$stmt->bindParam($p,$TiendaProcedencia,PDO::PARAM_STR,255);			
							$p++;
							$stmt->bindParam($p,$Producto[$a],PDO::PARAM_STR,255);
							
							$stmt->execute();
							$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas = $stmt->rowCount();
							$stmt->closeCursor();
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}		
					
						if ($rows[0]['total_tienda'] < $Cantidad[$a])
						{
							$msg[$m] = "- La Cantidad de Producto supera a la Cantidad de Producto en la Tienda de la Fila ".($a+1)."<br />";	
							$Error[0]['Cantidad'] = "true";
							$m = $m + 1;
						}
					}

				}
				
				if($Producto[$a] == "")
				{
					$msg[$m] = "- Debes escribir el C&oacute;digo o Nombre del Producto de la Fila ".($a+1)."<br />";
					$Error[$a]['Codigo'] = "true";
					$Error[$a]['Nombre_Producto'] = "true";
					$m = $m + 1;				
				}			
				
				$a++;
			}
		
		}
		
		
		if ($msg != false)
		{
			$mensaje = "Error Guardar Datos, favor verificar.<br /><br />";
			
			while($c < count($msg))
			{
				$mensaje .= $msg[$c];	
				$c++;
			}
			
			$Error['mensaje'] = $mensaje;
			
		}
		else
		$Error['mensaje'] = $mensaje;
		
		echo json_encode($Error);
		
	}
	
	if($_GET['action'] == 'Agregar_Orden')
	{
		session_start();
		$db->beginTransaction();
		
		$TipoOrden = strip_tags(utf8_decode(base64_decode($_POST['TipoOrden'])));		
		try
		{		

			$stmt = $db->prepare("SELECT IFNULL(MAX(id_orden)+1,1) AS numero_orden FROM ordenes WHERE id_tipo_orden = ?");

			$p = 1;
			$stmt->bindParam($p,$TipoOrden,PDO::PARAM_STR,255);
			
			$stmt->execute();
			//print_r($stmt->errorInfo());
			$NumeroOrden = $stmt->fetchColumn(0);
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}		
		
		
		//$NumeroOrden = strip_tags(utf8_decode($_POST['NumeroOrden']));
		

		$TipoOrdenEntrada = strip_tags(utf8_decode(base64_decode($_POST['TipoOrdenEntrada'])));
		$BodegaProcedencia = strip_tags(utf8_decode(base64_decode($_POST['BodegaProcedencia'])));
		$BodegaReceptora = strip_tags(utf8_decode(base64_decode($_POST['BodegaReceptora'])));			
		$TiendaProcedencia = strip_tags(utf8_decode(base64_decode($_POST['TiendaProcedencia'])));
		$TiendaReceptora = strip_tags(utf8_decode(base64_decode($_POST['TiendaReceptora'])));
		$Proveedor = strip_tags(utf8_decode(base64_decode($_POST['Proveedor'])));
		//echo $TipoOrden."-".$TipoOrdenInterno;
		//$FechaOrden	= strip_tags(utf8_decode($_POST['FechaOrden']));
		//$Autorizo	= strip_tags(utf8_decode($_POST['Autorizo']));		
		$Observaciones	= strip_tags(utf8_decode($_POST['Observaciones']));
		$ChoferAyudante	= strip_tags(utf8_decode(base64_decode($_POST['ChoferAyudante'])));		
		$EncargadoTienda	= strip_tags(utf8_decode(base64_decode($_POST['EncargadoTienda'])));		
		
		$Cantidad = json_decode($_POST['Cantidad']);
		$Producto = json_decode($_POST['Producto']);
	
		$a = 0;
		while ($a < count($Cantidad))
		{
			$Cantidad[$a] = strip_tags(utf8_decode($Cantidad[$a]));
			$Producto[$a] = strip_tags(utf8_decode(base64_decode($Producto[$a])));
			
			$a++;
		}
		
		try
		{
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Orden Agregado";
			$Tipo = "4";
	
			if ($TipoOrden == 1)
			$stmt = $db->prepare("INSERT INTO ordenes (id_orden,id_tipo_orden,id_usuario_autoriza,id_tipo_orden_entrada,id_bodega_recibido,id_bodega_enviado,id_proveedor,id_tienda_enviado,fecha,observaciones,fecha_agregado)
			VALUES (?,?,?,?,?,?,?,?,'".date('Y-m-d H:i:s')."',?,'".date('Y-m-d H:i:s')."')");				
			else
			$stmt = $db->prepare("INSERT INTO ordenes (id_orden,id_tipo_orden,id_usuario_autoriza,id_bodega_enviado,id_tienda_recibido,fecha,observaciones,fecha_agregado)
			VALUES (?,?,?,?,?,'".date('Y-m-d H:i:s')."',?,'".date('Y-m-d H:i:s')."')");	
			$p = 1;
			$stmt->bindParam($p,$NumeroOrden,PDO::PARAM_INT);
			$p++;			
			$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
			$p++;			
			$stmt->bindParam($p,$Id_Usuario,PDO::PARAM_STR,255);
			$p++;
			if ($TipoOrden == 1)
			{		
				$stmt->bindParam($p,$TipoOrdenEntrada,PDO::PARAM_INT);
				$p++;				
				$stmt->bindParam($p,$BodegaReceptora,PDO::PARAM_STR,255);				
				$p++;				
				$stmt->bindParam($p,$BodegaProcedencia,PDO::PARAM_STR,255);			
				$p++;				
				$stmt->bindParam($p,$Proveedor,PDO::PARAM_STR,255);
				$p++;
				$stmt->bindParam($p,$TiendaProcedencia,PDO::PARAM_STR,255);
				$p++;
			}		
			else
			{					
				$stmt->bindParam($p,$BodegaProcedencia,PDO::PARAM_STR,255);				
				$p++;				
				$stmt->bindParam($p,$TiendaReceptora,PDO::PARAM_STR,255);
				$p++;
			}
			$stmt->bindParam($p,$Observaciones,PDO::PARAM_STR,255);			
			
			$Insertado = $stmt->execute();
			//print_r($stmt->errorInfo());
			$Id_Orden = $NumeroOrden;	

			
			
			
			$stmt = $db->prepare("INSERT INTO user_log (id_usuario,anio,fecha_log,evento,tipo) VALUES (?,YEAR('".date('Y-m-d H:i:s')."'), '".date('Y-m-d H:i:s')."',?,?)");
			$p = 1;
			$stmt->bindParam($p,$Id_Usuario,PDO::PARAM_INT);
			$p++;
			$stmt->bindParam($p,$Evento,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Tipo,PDO::PARAM_INT);

			$Insertado1 = $stmt->execute();
			
			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Log");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Log = $results[0]["Id_Log"];
			
			$stmt = $db->prepare("INSERT INTO historial_ordenes (id_orden,id_tipo_orden,id_log) VALUES (?,?,?)");
			$p = 1;
			$stmt->bindParam($p,$Id_Orden,PDO::PARAM_INT);
			$p++;
			$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
			$p++;			
			$stmt->bindParam($p,$Id_Log,PDO::PARAM_INT);
			
			$Insertado2 = $stmt->execute();
			//print_r($stmt->errorInfo());
			if ($Insertado)
			{	
				$f = 0; $CantOrden = 0; $CantMov = 0;
				while ($f < count($Cantidad))
				{					
					try
					{
						$stmt = $db->prepare("SELECT cantidad_existencia FROM producto WHERE id_producto = ?");
						
						$p = 1;
						$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);						
						$stmt->execute();
						$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas = $stmt->rowCount();	
						//print_r($stmt->errorInfo());
						if ($TipoOrden == 1)
						{
							$CantExistenciaActual = $Cantidad[$f] + $rows[0]['cantidad_existencia'];

						
							$stmt = $db->prepare("UPDATE producto SET cantidad_existencia = ? WHERE id_producto = ?");	
							$p = 1;
							$stmt->bindParam($p,$CantExistenciaActual,PDO::PARAM_INT);	
							$p++;
							$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);

							$Actualizado = $stmt->execute();	
						}						
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}			
			
			
					$stmt = $db->prepare("INSERT INTO orden_detalle (id_orden,id_tipo_orden,id_tipo_orden_entrada,cantidad,id_producto,fecha_agregado)
					VALUES (?,?,?,?,?,'".date('Y-m-d H:i:s')."')");
					$p = 1;
					$stmt->bindParam($p,$NumeroOrden,PDO::PARAM_INT);
					$p++;			
					$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
					$p++;
					$stmt->bindParam($p,$TipoOrdenEntrada,PDO::PARAM_INT);
					$p++;					
					$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);
					$p++;
					$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
					$p++;

					$Insertado3 = $stmt->execute();				
					//print_r($stmt->errorInfo());
					$CantOrden = $Insertado3  + $CantOrden ;					
					
					$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Orden_Detalle");
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$Id_Orden_Detalle = $results[0]["Id_Orden_Detalle"];
					
					if ($TipoOrden == 1)
					{
						if ($TipoOrdenEntrada == 1)
						{
							$stmt = $db->prepare("INSERT INTO movimientos (id_orden,tipo_orden,tipo_orden_entrada,id_orden_detalle,id_producto,id_bodega,balance_bodega,fecha_agregado)
							VALUES (?,?,?,?,?,?,?,'".date('Y-m-d H:i:s')."')");					
							
							$p = 1;
							$stmt->bindParam($p,$NumeroOrden,PDO::PARAM_INT);
							$p++;			
							$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
							$p++;			
							$stmt->bindParam($p,$TipoOrdenEntrada,PDO::PARAM_INT);
							$p++;					
							$stmt->bindParam($p,$Id_Orden_Detalle,PDO::PARAM_INT);									
							$p++;
							$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
							$p++;
							$stmt->bindParam($p,$BodegaReceptora,PDO::PARAM_STR,255);								
							$p++;
							$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);
						
					
						}
						else if ($TipoOrdenEntrada == 2)
						{
						
							$stmt = $db->prepare("INSERT INTO movimientos (id_orden,tipo_orden,tipo_orden_entrada,id_orden_detalle,id_producto,id_bodega,balance_bodega,id_tienda,balance_tienda,fecha_agregado)
							VALUES (?,?,?,?,?,?,?,?,?,'".date('Y-m-d H:i:s')."')");					
							
							$CantTiendaProcedencia = $Cantidad[$f]*-1;
							
							$p = 1;
							$stmt->bindParam($p,$NumeroOrden,PDO::PARAM_INT);
							$p++;			
							$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
							$p++;			
							$stmt->bindParam($p,$TipoOrdenEntrada,PDO::PARAM_INT);
							$p++;					
							$stmt->bindParam($p,$Id_Orden_Detalle,PDO::PARAM_INT);								
							$p++;
							$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
							$p++;
							$stmt->bindParam($p,$BodegaReceptora,PDO::PARAM_STR,255);	
							$p++;
							$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);							
							$p++;
							$stmt->bindParam($p,$TiendaProcedencia,PDO::PARAM_STR,255);						
							$p++;
							$stmt->bindParam($p,$CantTiendaProcedencia,PDO::PARAM_STR,255);	
							
						
						}
						else
						{
						
							$stmt = $db->prepare("INSERT INTO movimientos (id_orden,tipo_orden,tipo_orden_entrada,id_orden_detalle,id_producto,id_bodega,balance_bodega,fecha_agregado)
							VALUES (?,?,?,?,?,?,?,'".date('Y-m-d H:i:s')."')");					
														
							$p = 1;
							$stmt->bindParam($p,$NumeroOrden,PDO::PARAM_INT);
							$p++;			
							$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
							$p++;			
							$stmt->bindParam($p,$TipoOrdenEntrada,PDO::PARAM_INT);
							$p++;					
							$stmt->bindParam($p,$Id_Orden_Detalle,PDO::PARAM_INT);								
							$p++;
							$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
							$p++;
							$stmt->bindParam($p,$BodegaReceptora,PDO::PARAM_STR,255);	
							$p++;
							$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);

							
							$Insertado4 = $stmt->execute();	
							//print_r($stmt->errorInfo());
							$stmt = $db->prepare("INSERT INTO movimientos (id_orden,tipo_orden,tipo_orden_entrada,id_orden_detalle,id_producto,id_bodega,balance_bodega,fecha_agregado)
							VALUES (?,?,?,?,?,?,?,'".date('Y-m-d H:i:s')."')");					
							
							$CantBodegaProcedencia = $Cantidad[$f]*-1;
							
							$p = 1;
							$stmt->bindParam($p,$NumeroOrden,PDO::PARAM_INT);
							$p++;			
							$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
							$p++;			
							$stmt->bindParam($p,$TipoOrdenEntrada,PDO::PARAM_INT);
							$p++;					
							$stmt->bindParam($p,$Id_Orden_Detalle,PDO::PARAM_INT);							
							$p++;
							$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
							$p++;
							$stmt->bindParam($p,$BodegaProcedencia,PDO::PARAM_STR,255);	
							$p++;
							$stmt->bindParam($p,$CantBodegaProcedencia,PDO::PARAM_STR,255);

													
						}
					}
					else
					{
						$stmt = $db->prepare("INSERT INTO movimientos (id_orden,tipo_orden,id_orden_detalle,id_producto,id_bodega,balance_bodega,id_tienda,balance_tienda,fecha_agregado)
						VALUES (?,?,?,?,?,?,?,?,'".date('Y-m-d H:i:s')."')");					
						
						$CantBodegaProcedencia = $Cantidad[$f]*-1;
						
						$p = 1;
						$stmt->bindParam($p,$NumeroOrden,PDO::PARAM_INT);
						$p++;			
						$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
						$p++;					
						$stmt->bindParam($p,$Id_Orden_Detalle,PDO::PARAM_INT);
						$p++;							
						$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
						$p++;
						$stmt->bindParam($p,$BodegaProcedencia,PDO::PARAM_STR,255);	
						$p++;
						$stmt->bindParam($p,$CantBodegaProcedencia,PDO::PARAM_STR,255);
						$p++;
						$stmt->bindParam($p,$TiendaReceptora,PDO::PARAM_STR,255);						
						$p++;
						$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);	
					
					}
					
					$Insertado4 = $stmt->execute();	
					//print_r($stmt->errorInfo());
					$CantMov = $Insertado4  + $CantMov ;
					
					$f = $f + 1;
				}				
			
			}
			
			$stmt->closeCursor();				
		
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}			

		if (($Insertado === true)  and ($Insertado1 === true) and ($Insertado2 === true)
		and ($CantOrden > 0) and (count($Cantidad) == $CantOrden) and ($CantMov > 0) and (count($Cantidad) == $CantMov))
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

	if($_GET['action'] == 'Listar_Ordenes')
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
			array( 'db' => 'id_orden', 'dt' => 0 ),
			array( 'db' => 'id_orden',  'dt' => 1 ),
			array( 'db' => 'fecha_agregado',   'dt' => 2 ),
			array( 'db' => 'descripcion_tipo_orden',   'dt' => 3 ),
			array( 'db' => 'lugar_entrada_salida',   'dt' => 4 ),
			array( 'db' => 'usuario_autoriza',   'dt' => 5 ),
			array( 'db' => 'opciones',   'dt' => 6 ),
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			$Sql1 = "SELECT id_orden,o.id_tipo_orden,o.id_tipo_orden_entrada,
			IF(o.id_tipo_orden = 1,CONCAT(descripcion_tipo_orden,'-',descripcion_tipo_orden_entrada),descripcion_tipo_orden) AS descripcion_tipo_orden,
			IF(o.id_tipo_orden = 1,(SELECT descripcion_bodega FROM bodegas WHERE id_bodega = o.id_bodega_recibido),
			(SELECT descripcion_tienda FROM tiendas WHERE id_tienda = o.id_tienda_recibido)) AS lugar_entrada_salida,
			(SELECT CONCAT(nombre,' ',apellido) FROM usuarios WHERE id_usuario = id_usuario_autoriza) AS usuario_autoriza,o.fecha_agregado
			FROM ordenes o
			INNER JOIN tipo_orden t ON (t.id_tipo_orden = o.id_tipo_orden)
			LEFT JOIN proveedores p ON (p.id_proveedor = o.id_proveedor)
			LEFT JOIN tipo_orden_entrada toe ON (toe.id_tipo_orden_entrada = o.id_tipo_orden_entrada)			
			WHERE estatus_orden = 1";			
			
			$Sql = "SELECT SQL_CALC_FOUND_ROWS (id_orden),id_tipo_orden,id_tipo_orden_entrada,descripcion_tipo_orden,lugar_entrada_salida,usuario_autoriza,fecha_agregado  
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

			$stmt = $db->prepare("SELECT COUNT(id_orden)
			FROM ordenes o
			INNER JOIN tipo_orden t ON (t.id_tipo_orden = o.id_tipo_orden)
			LEFT JOIN proveedores p ON (p.id_proveedor = o.id_proveedor)
			LEFT JOIN tipo_orden_entrada toe ON (toe.id_tipo_orden_entrada = o.id_tipo_orden_entrada)			
			WHERE estatus_orden = 1");			
				
			$stmt->execute();			
			$recordsTotal = $stmt->fetchColumn (0);				
			
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		$Data = array();				
		if ($nfilas > 0)
		{
				
			$f = 0;
			foreach ($rows as $row)
			{
				$c=0;
				$Fecha_Orden = date("d-m-Y h:i:s",strtotime($row['fecha_agregado']));
				
				$Data[$f][$c] = $f+1;
				$c++;
				$Data[$f][$c] = utf8_encode($row['id_orden']);
				$c++;
				$Data[$f][$c] = utf8_encode($Fecha_Orden);
				$c++;
				$Data[$f][$c] = utf8_encode($row['descripcion_tipo_orden']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['lugar_entrada_salida']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['usuario_autoriza']);			
				$c++;
				
				$Data[$f][$c] = "";				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{
					$Data[$f][$c] .= '<button type="button" class="btn btn-success btn-circle" onclick="Editar_Orden('.$f.')" title="Editar Orden"><i class="fa fa-link"></i></button>&nbsp;';
					$Data[$f][$c] .= '<button type="button" class="btn btn-danger btn-circle" onclick="if(confirm(\'Realmente quieres eliminar esta Orden?\')){Eliminar_Orden('.$f.');}" title="Eliminar Orden"><i class="fa fa-times"></i></button>&nbsp;';
				}
					

				
				$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_orden'])).'" />
							<input type="hidden" id="hdnIdCamposTipo_'.$f.'" name="hdnIdCamposTipo_[]" value="'.utf8_encode(md5($row['id_tipo_orden'])).'" />
							<input type="hidden" id="hdnIdCamposTipoEntrada_'.$f.'" name="hdnIdCamposTipoEntrada_[]" value="'.utf8_encode(md5($row['id_tipo_orden_entrada'])).'" />';
				
				$f = $f + 1;
			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;
		echo json_encode($ResultSet);		
		
		
	}

	if($_GET['action'] == 'Ver_Orden')
	{
		try
		{
			$id_Orden = strip_tags(utf8_decode($_POST['IdOrden']));
			$id_Tipo_Orden = strip_tags(utf8_decode($_POST['TipoOrden']));
			
			$id_Tipo_Orden_Entrada = strip_tags(utf8_decode($_POST['TipoOrdenEntrada']));
			
			$Sql = "SELECT id_orden,o.id_tipo_orden,o.id_tipo_orden_entrada,fecha,observaciones,
			id_usuario_autoriza,(SELECT CONCAT(nombre,' ',apellido) FROM usuarios WHERE id_usuario = id_usuario_autoriza) AS usuario_autoriza,
			o.id_proveedor, nombre_proveedor,
			o.id_bodega_recibido,(SELECT descripcion_bodega FROM bodegas WHERE id_bodega = id_bodega_recibido) AS descripcion_bodega_recibido,
			o.id_bodega_enviado,(SELECT descripcion_bodega FROM bodegas WHERE id_bodega = id_bodega_enviado) AS descripcion_bodega_enviado,
			o.id_tienda_recibido,(SELECT descripcion_tienda FROM tiendas WHERE id_tienda = id_tienda_recibido) AS descripcion_tienda_recibido,
			o.id_tienda_enviado,(SELECT descripcion_tienda FROM tiendas WHERE id_tienda = id_tienda_enviado) AS descripcion_tienda_enviado
			FROM ordenes o
			INNER JOIN tipo_orden t ON (t.id_tipo_orden = o.id_tipo_orden)
			LEFT JOIN proveedores p ON (p.id_proveedor = o.id_proveedor) WHERE MD5(id_orden) = ? AND MD5(o.id_tipo_orden) = ?";
			
			if ($id_Tipo_Orden_Entrada != md5(""))
			{
				$Sql .= " AND MD5(o.id_tipo_orden_entrada) = ?";
			}
			
			$stmt = $db->prepare($Sql);
			
			$p = 1;
			$stmt->bindParam($p,$id_Orden,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$id_Tipo_Orden,PDO::PARAM_STR,255);
			
			if ($id_Tipo_Orden_Entrada != md5(""))
			{			
				$p++;
				$stmt->bindParam($p,$id_Tipo_Orden_Entrada,PDO::PARAM_STR,255);			
			}
			
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
			$Orden = array();
			foreach ($rows as $row)
			{
				$Fecha = explode("-",$row['fecha']);
				$Orden[$c]['txtNumeroOrden'] = utf8_encode($row['id_orden']);
				$Orden[$c]['lstTipoOrden'] = utf8_encode(base64_encode($row['id_tipo_orden']));
				$Orden[$c]['lstTipoOrdenEntrada'] = utf8_encode(base64_encode($row['id_tipo_orden_entrada']));				
				$Orden[$c]['txtFechaOrden'] = utf8_encode($Fecha[2]."-".$Fecha[1]."-".$Fecha[0]);
				$Orden[$c]['hidAutorizo'] = utf8_encode(base64_encode($row['id_usuario_autoriza']));
				$Orden[$c]['txtAutorizo'] = utf8_encode($row['usuario_autoriza']);				
				$Orden[$c]['hidProveedorProcedencia'] = utf8_encode(base64_encode($row['id_proveedor']));
				$Orden[$c]['txtProveedorProcedencia'] = utf8_encode($row['nombre_proveedor']);
				$Orden[$c]['txtBodegaReceptora'] = utf8_encode($row['descripcion_bodega_recibido']);
				$Orden[$c]['txtBodegaProcedencia'] = utf8_encode($row['descripcion_bodega_enviado']);				
				$Orden[$c]['txtTiendaReceptora'] = utf8_encode($row['descripcion_tienda_recibido']);
				$Orden[$c]['txtTiendaProcedencia'] = utf8_encode($row['descripcion_tienda_enviado']);
				$Orden[$c]['hidBodegaReceptora'] = utf8_encode(base64_encode($row['id_bodega_recibido']));
				$Orden[$c]['hidBodegaProcedencia'] = utf8_encode(base64_encode($row['id_bodega_enviado']));				
				$Orden[$c]['hidTiendaReceptora'] = utf8_encode(base64_encode($row['id_tienda_recibido']));
				$Orden[$c]['hidTiendaProcedencia'] = utf8_encode(base64_encode($row['id_tienda_enviado']));				
				$Orden[$c]['txtObservaciones'] = utf8_encode($row['observaciones']);
				$Orden[$c]['hidChoferAyudante'] = utf8_encode(base64_encode($row['id_chofer_ayudante']));
				$Orden[$c]['txtChoferAyudante'] = utf8_encode($row['chofer_ayudante']);				
				$Orden[$c]['hidEncargadoTienda'] = utf8_encode(base64_encode($row['id_encargado_ubicacion']));
				$Orden[$c]['txtEncargadoTienda'] = utf8_encode($row['encargado_ubicacion']);
				
				
				$c++;
			}
		}		

		if ($nfilas > 0)
		{
			$response = json_encode($Orden);
		}		
	
		echo $response;
	
	}	

	if($_GET['action'] == 'Listar_Articulos_Orden')
	{
		$html = "";
		session_start();
		
		try
		{		
			$Id_Orden = strip_tags(utf8_decode($_POST['IdOrden']));
			$Id_Tipo_Orden = strip_tags(utf8_decode($_POST['TipoOrden']));
			$stmt = $db->prepare("SELECT id_orden_detalle,od.id_producto,cantidad,codigo_producto,nombre_producto,descripcion_color FROM orden_detalle od
			INNER JOIN producto a ON (a.id_producto = od.id_producto)
			INNER JOIN colores c ON (c.id_color = a.id_color)
			WHERE estatus_orden_detalle = 1 AND MD5(id_orden) = ? AND MD5(id_tipo_orden) = ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);			
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		$html .= '<table cellpadding="0" cellspacing="0" border="0" class="sTable">
					<thead id="tbHead">
						<tr>
							<td style="width:2%">
								<a href="javascript:void(0);" title="" class="smallButton" style="margin: 5px;"><img src="public/images/icons/color/plus.png" alt="" onclick="Agregar_Articulo_Orden()"/></a>
								<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
								<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" />
							</td>
							<td style="width:15%">Cantidad</td>
							<td style="width:15%">C&oacute;digo</td>
							<td style="width:29%">Nombre de Producto</td>
							<td style="width:15%">Color</td>
							<td style="width:15%">Opciones</td>																
						</tr>
					</thead>
					<tbody id="tbDetalle">';
			  			  
			  
		if ($nfilas > 0)
		{
				
			$c = 1;
			foreach ($rows as $row)
			{

				$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
						<td>'.$c.'</td>
						<td><div class="formRight"><span class="req">*</span><input class="validate[required]" type="text" name="txtCantidad[]" id="txtCantidad'.$c.'" style="width:80%" value="'.utf8_encode($row['cantidad']).'"/>
						<input type="hidden" name="hidCantidad[]" id="hidCantidad'.$c.'" value="'.utf8_encode($row['cantidad']).'"  /></div></td>
						<td><div class="formRight"><input class="validate[required]" type="text" name="txtCodigo[]" id="txtCodigo'.$c.'" style="width:80%" value="'.utf8_encode($row['codigo_producto']).'"/>
						<input type="hidden" name="hidCodigo[]" id="hidCodigo'.$c.'" value="'.utf8_encode($row['codigo_producto']).'"  /></div></td>
						<td><textarea class="validate[required]" rows="4" cols="" name="txtNombreProducton[]" id="txtNombreProducton'.$c.'" style="width:90%" value="'.utf8_encode($row['nombre_producto']).'">'.utf8_encode($row['nombre_producto']).'</textarea>
						<input type="hidden" name="hidNombreProducto[]" id="hidNombreProducto'.$c.'" value="'.utf8_encode($row['nombre_producto']).'"  />
						<input type="hidden" name="hidProducto[]" id="hidProducto'.$c.'" value="'.utf8_encode(base64_encode($row['id_producto'])).'"  /></td>
						<td><div class="formRight"><input class="validate[required]" type="text" name="txtColor[]" id="txtColor'.$c.'" style="width:80%"value="'.utf8_encode($row['descripcion_color']).'"/><p class="help-block"></p>
						<input type="hidden" name="hidColor[]" id="hidColor'.$c.'" value="'.utf8_encode($row['descripcion_color']).'"  /></div></td>				
						<td align="center">';
						
					if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
					{
						$html .= '<button type="button" class="btn btn-danger btn-circle" onclick="if(confirm(\'Realmente quieres eliminar este Art&iacute;lo - Orden?\')){Eliminar_Articulo_Orden('.$c.');}" title="Eliminar &Aacute;rticulo"><i class="fa fa-times"></i></button>&nbsp;';	
					}
					
					$html .='<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_orden_detalle'])).'" /></td>					
					</tr>';
					
				$c = $c + 1;
			}

		}
	  
		$html .= '</tbody></table>';

		echo $html;
		
	}

	if($_GET['action'] == 'Actualizar_Orden')
	{
		session_start();
		$db->beginTransaction();

		$TipoOrden = strip_tags(utf8_decode(base64_decode($_POST['TipoOrden'])));
		$TipoOrdenEntrada = strip_tags(utf8_decode(base64_decode($_POST['TipoOrdenEntrada'])));	
		
		$BodegaProcedencia = strip_tags(utf8_decode(base64_decode($_POST['BodegaProcedencia'])));
		$BodegaReceptora = strip_tags(utf8_decode(base64_decode($_POST['BodegaReceptora'])));			
		$TiendaProcedencia = strip_tags(utf8_decode(base64_decode($_POST['TiendaProcedencia'])));
		$TiendaReceptora = strip_tags(utf8_decode(base64_decode($_POST['TiendaReceptora'])));
		
		$Proveedor = strip_tags(utf8_decode(base64_decode($_POST['Proveedor'])));		

		//$FechaOrden	= strip_tags(utf8_decode($_POST['FechaOrden']));
		//$Autorizo	= strip_tags(utf8_decode($_POST['Autorizo']));		
		$Observaciones	= strip_tags(utf8_decode($_POST['Observaciones']));
	
		$Cantidad = json_decode($_POST['Cantidad']);
		$Producto = json_decode($_POST['Producto']);
		$IdOrdenDetalle = json_decode($_POST['IdOrdenDetalle']);
	
		$a = 0;
		while ($a < count($Cantidad))
		{
			$Cantidad[$a] = strip_tags(utf8_decode($Cantidad[$a]));
			$Producto[$a] = strip_tags(utf8_decode(base64_decode($Producto[$a])));
			$IdOrdenDetalle[$a] = strip_tags(utf8_decode($IdOrdenDetalle[$a]));
			
			$a++;
		}
		
		$Id_Orden = strip_tags(utf8_decode($_POST['IdOrden']));
		$Id_Tipo_Orden = strip_tags(utf8_decode($_POST['IdTipoOrden']));
		$Id_Tipo_Orden_Entrada = strip_tags(utf8_decode($_POST['IdTipoOrdenEntrada']));
		
		$Id_Usuario = base64_decode($_SESSION['id_usuario']);
		$Evento = "Orden Actualizado";
		$Tipo = "5";

		try
		{	
			if ($Id_Tipo_Orden == md5(1))
			$stmt = $db->prepare("UPDATE ordenes SET id_proveedor=?,id_bodega_enviado=?,id_tienda_enviado=?,observaciones=?,fecha_actualizado='".date('Y-m-d H:i:s')."'
			WHERE MD5(id_orden) = ? AND MD5(id_tipo_orden) = ?");	
			else
			$stmt = $db->prepare("UPDATE ordenes SET id_tienda_recibido=?,observaciones=?,fecha_actualizado='".date('Y-m-d H:i:s')."'
			WHERE MD5(id_orden) = ? AND MD5(id_tipo_orden) = ?");
			
			$p = 1;
			if ($Id_Tipo_Orden == md5(1))
			{
				$stmt->bindParam($p,$Proveedor,PDO::PARAM_STR,255);
				$p++;				
				$stmt->bindParam($p,$BodegaProcedencia,PDO::PARAM_STR,255);				
				$p++;				
				$stmt->bindParam($p,$TiendaProcedencia,PDO::PARAM_STR,255);
				$p++;
				
			}	
			else
			{
				$stmt->bindParam($p,$TiendaReceptora,PDO::PARAM_STR,255);
				$p++;			
			}
			$stmt->bindParam($p,$Observaciones,PDO::PARAM_STR,255);	
			$p++;			
			$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);			
			$p++;			
			$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);
			
			$Actualizado = $stmt->execute();
			//print_r($stmt->errorInfo());	
			$stmt = $db->prepare("SELECT id_orden,id_tipo_orden,id_tipo_orden_entrada FROM ordenes WHERE MD5(id_orden) = ? AND MD5(id_tipo_orden) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
			$p++;			
			$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_orden = $results[0]["id_orden"];
			$id_tipo_orden = $results[0]["id_tipo_orden"];
			$id_tipo_orden_entrada = $results[0]["id_tipo_orden_entrada"];			
			$stmt->closeCursor();				

			$stmt = $db->prepare("INSERT INTO user_log (id_usuario,anio,fecha_log,evento,tipo) VALUES (?,YEAR('".date('Y-m-d H:i:s')."'), '".date('Y-m-d H:i:s')."',?,?)");
			$p = 1;
			$stmt->bindParam($p,$Id_Usuario,PDO::PARAM_INT);
			$p++;
			$stmt->bindParam($p,$Evento,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Tipo,PDO::PARAM_INT);
	
			$Insertado1 = $stmt->execute();
			//print_r($stmt->errorInfo());	
			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Log");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Log = $results[0]["Id_Log"];
				
			$stmt = $db->prepare("INSERT INTO historial_ordenes (id_orden,id_tipo_orden,id_log) VALUES (?,?,?)");
			$p = 1;
			$stmt->bindParam($p,$id_orden,PDO::PARAM_INT);
			$p++;
			$stmt->bindParam($p,$id_tipo_orden,PDO::PARAM_INT);
			$p++;			
			$stmt->bindParam($p,$Id_Log,PDO::PARAM_INT);
			
			$Insertado2 = $stmt->execute();			
			//print_r($stmt->errorInfo());
			if ($Actualizado)
			{	
				
				$stmt = $db->prepare("UPDATE orden_detalle SET estatus_orden_detalle=0,fecha_actualizado='".date('Y-m-d H:i:s')."' WHERE MD5(id_orden) = ? AND MD5(id_tipo_orden) = ?");
				$p = 1;
				$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
				$p++;
				$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);				

				$Eliminado = $stmt->execute();
				//print_r($stmt->errorInfo());
				
				$f = 0; $CantContacto = 0;
				while ($f < count($Cantidad))
				{	

					if ($IdOrdenDetalle[$f] != "")
					{
						try
						{
							$stmt = $db->prepare("SELECT cantidad,id_producto FROM orden_detalle WHERE MD5(id_orden) = ? AND MD5(id_tipo_orden) = ? AND MD5(id_orden_detalle)=?");
							
							$p = 1;
							$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
							$p++;
							$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);				
							$p++;					
							$stmt->bindParam($p,$IdOrdenDetalle[$f],PDO::PARAM_INT);					
							$stmt->execute();
							//print_r($stmt->errorInfo());
							
							$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas = $stmt->rowCount();

							$stmt = $db->prepare("SELECT cantidad_existencia FROM producto WHERE id_producto = ?");
							
							$p = 1;
							$stmt->bindParam($p,$rows[0]['id_producto'],PDO::PARAM_STR,255);						
							$stmt->execute();
							//print_r($stmt->errorInfo());
							$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas1 = $stmt->rowCount();	
							
							if ($TipoOrden == 1)
							{							
								$CantExistenciaActual = $rows1[0]['cantidad_existencia'] - $rows[0]['cantidad'];
								
								$stmt = $db->prepare("UPDATE producto SET cantidad_existencia = ? WHERE id_producto = ?");	
								$p = 1;
								$stmt->bindParam($p,$CantExistenciaActual,PDO::PARAM_INT);	
								$p++;
								$stmt->bindParam($p,$rows[0]['id_producto'],PDO::PARAM_STR,255);								
								
								
								$Actualizado2 = $stmt->execute();
								//print_r($stmt->errorInfo());
								$stmt = $db->prepare("SELECT cantidad_existencia FROM producto WHERE id_producto = ?");
								
								$p = 1;
								$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);						
								$stmt->execute();
								$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
								$nfilas2 = $stmt->rowCount();	
							

								$CantExistenciaActual = $Cantidad[$f] + $rows2[0]['cantidad_existencia'];

							
								$stmt = $db->prepare("UPDATE producto SET cantidad_existencia = ? WHERE id_producto = ?");	
								$p = 1;
								$stmt->bindParam($p,$CantExistenciaActual,PDO::PARAM_INT);	
								$p++;
								$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);	
								
								$Actualizado3 = $stmt->execute();
								//print_r($stmt->errorInfo());
							}							

						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}						
						
						
						$stmt = $db->prepare("UPDATE orden_detalle SET cantidad=?,id_producto=?,estatus_orden_detalle=1,fecha_actualizado='".date('Y-m-d H:i:s')."'
						WHERE MD5(id_orden) = ? AND MD5(id_tipo_orden) = ? AND MD5(id_orden_detalle)=?");
						$p = 1;
						$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);
						$p++;
						$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
						$p++;
						$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
						$p++;
						$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);				
						$p++;					
						$stmt->bindParam($p,$IdOrdenDetalle[$f],PDO::PARAM_INT);					
					
						$Actualizado1 = $stmt->execute();				
						//print_r($stmt->errorInfo());
						$CantContacto = $Actualizado1  + $CantContacto;					

						if ($Id_Tipo_Orden == md5(1))
						{
							if ($Id_Tipo_Orden_Entrada == md5(1))
							{
								$stmt = $db->prepare("UPDATE movimientos SET id_producto=?,id_bodega=?,balance_bodega=?,fecha_actualizado='".date('Y-m-d H:i:s')."'
								WHERE MD5(id_orden) = ? AND MD5(tipo_orden) = ?  AND MD5(tipo_orden_entrada) = ? AND MD5(id_orden_detalle)=?");
															
								$p = 1;

								$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
								$p++;
								$stmt->bindParam($p,$BodegaReceptora,PDO::PARAM_STR,255);								
								$p++;
								$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);
								$p++;								
								$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
								$p++;			
								$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);
								$p++;			
								$stmt->bindParam($p,$Id_Tipo_Orden_Entrada,PDO::PARAM_STR,255);
								$p++;					
								$stmt->bindParam($p,$IdOrdenDetalle[$f],PDO::PARAM_STR,255);	
								
							}
							else if ($Id_Tipo_Orden_Entrada == md5(2))
							{
							
								$stmt = $db->prepare("UPDATE movimientos SET id_producto=?,id_bodega=?,balance_bodega=?,id_tienda=?,balance_tienda=?,fecha_actualizado='".date('Y-m-d H:i:s')."'
								WHERE MD5(id_orden) = ? AND MD5(tipo_orden) = ?  AND MD5(tipo_orden_entrada) = ? AND MD5(id_orden_detalle)=?");								
													
								$CantTiendaProcedencia = $Cantidad[$f]*-1;
								
								$p = 1;

								$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
								$p++;
								$stmt->bindParam($p,$BodegaReceptora,PDO::PARAM_STR,255);	
								$p++;
								$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);							
								$p++;
								$stmt->bindParam($p,$TiendaProcedencia,PDO::PARAM_STR,255);						
								$p++;
								$stmt->bindParam($p,$CantTiendaProcedencia,PDO::PARAM_STR,255);	
								$p++;								
								$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
								$p++;			
								$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);
								$p++;			
								$stmt->bindParam($p,$Id_Tipo_Orden_Entrada,PDO::PARAM_STR,255);
								$p++;					
								$stmt->bindParam($p,$IdOrdenDetalle[$f],PDO::PARAM_STR,255);
							
							
							}
							else
							{
							
								$stmt = $db->prepare("UPDATE movimientos SET id_producto,id_bodega,balance_bodega,fecha_actualizado='".date('Y-m-d H:i:s')."'
								WHERE MD5(id_orden) = ? AND MD5(tipo_orden) = ?  AND MD5(tipo_orden_entrada) = ? AND MD5(id_orden_detalle)=?");										
																		
								$p = 1;

								$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
								$p++;
								$stmt->bindParam($p,$BodegaReceptora,PDO::PARAM_STR,255);	
								$p++;
								$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);
								$p++;								
								$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
								$p++;			
								$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);
								$p++;			
								$stmt->bindParam($p,$Id_Tipo_Orden_Entrada,PDO::PARAM_STR,255);
								$p++;					
								$stmt->bindParam($p,$IdOrdenDetalle[$f],PDO::PARAM_STR,255);
								
								$Actualizado4 = $stmt->execute();	
								//print_r($stmt->errorInfo());
								$stmt = $db->prepare("UPDATE movimientos SET id_producto,id_bodega,balance_bodega,fecha_actualizado='".date('Y-m-d H:i:s')."'
								WHERE MD5(id_orden) = ? AND MD5(tipo_orden) = ?  AND MD5(tipo_orden_entrada) = ? AND MD5(id_orden_detalle)=?");						
								
								$CantBodegaProcedencia = $Cantidad[$f]*-1;
								
								$p = 1;

								$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
								$p++;
								$stmt->bindParam($p,$BodegaProcedencia,PDO::PARAM_STR,255);	
								$p++;
								$stmt->bindParam($p,$CantBodegaProcedencia,PDO::PARAM_STR,255);
								$p++;								
								$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
								$p++;			
								$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);
								$p++;			
								$stmt->bindParam($p,$Id_Tipo_Orden_Entrada,PDO::PARAM_STR,255);
								$p++;					
								$stmt->bindParam($p,$IdOrdenDetalle[$f],PDO::PARAM_STR,255);
														
							}
						}
						else
						{
							$stmt = $db->prepare("UPDATE movimientos SET id_producto=?,id_bodega=?,balance_bodega=?,id_tienda=?,balance_tienda=?,fecha_actualizado='".date('Y-m-d H:i:s')."'
							WHERE MD5(id_orden) = ? AND MD5(tipo_orden) = ?  AND MD5(id_orden_detalle)=?");				
							
							$CantBodegaProcedencia = $Cantidad[$f]*-1;
							
							$p = 1;
							$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
							$p++;
							$stmt->bindParam($p,$BodegaProcedencia,PDO::PARAM_STR,255);	
							$p++;
							$stmt->bindParam($p,$CantBodegaProcedencia,PDO::PARAM_STR,255);
							$p++;
							$stmt->bindParam($p,$TiendaReceptora,PDO::PARAM_STR,255);						
							$p++;
							$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);	
							$p++;								
							$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
							$p++;			
							$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);
							$p++;					
							$stmt->bindParam($p,$IdOrdenDetalle[$f],PDO::PARAM_STR,255);							
						}
						
						$Actualizado4 = $stmt->execute();	
						//print_r($stmt->errorInfo());
						$CantMov = $Actualizado4  + $CantMov ;

					
					}
					else
					{

						try
						{
							$stmt = $db->prepare("SELECT cantidad_existencia FROM producto WHERE id_producto = ?");
							
							$p = 1;
							$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);						
							$stmt->execute();
							$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas = $stmt->rowCount();	
							
							if ($TipoOrden == 1)
							{
								$CantExistenciaActual = $Cantidad[$f] + $rows[0]['cantidad_existencia'];

							
								$stmt = $db->prepare("UPDATE producto SET cantidad_existencia = ? WHERE id_producto = ?");	
								$p = 1;
								$stmt->bindParam($p,$CantExistenciaActual,PDO::PARAM_INT);	
								$p++;
								$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
								
								$Actualizado3 = $stmt->execute();									
							}							
							
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}					
					
						$stmt = $db->prepare("INSERT INTO orden_detalle (id_orden,id_tipo_orden,id_tipo_orden_entrada,cantidad,id_producto,fecha_agregado)
						VALUES (?,?,?,?,?,'".date('Y-m-d H:i:s')."')");
						$p = 1;
						$stmt->bindParam($p,$id_orden,PDO::PARAM_INT);
						$p++;			
						$stmt->bindParam($p,$id_tipo_orden,PDO::PARAM_INT);
						$p++;
						$stmt->bindParam($p,$id_tipo_orden_entrada,PDO::PARAM_INT);
						$p++;						
						$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);
						$p++;
						$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);

						$Insertado3 = $stmt->execute();					
						//print_r($stmt->errorInfo());	
						$CantContacto = $Insertado3  + $CantContacto;
						
						$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Orden_Detalle");
						$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$Id_Orden_Detalle = $results[0]["Id_Orden_Detalle"];

						if ($TipoOrden == 1)
						{
							if ($TipoOrdenEntrada == 1)
							{
								$stmt = $db->prepare("INSERT INTO movimientos (id_orden,tipo_orden,tipo_orden_entrada,id_orden_detalle,id_producto,id_bodega,balance_bodega,fecha_agregado)
								VALUES (?,?,?,?,?,?,?,'".date('Y-m-d H:i:s')."')");					
								
								$p = 1;
								$stmt->bindParam($p,$id_orden,PDO::PARAM_INT);
								$p++;			
								$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
								$p++;			
								$stmt->bindParam($p,$TipoOrdenEntrada,PDO::PARAM_INT);
								$p++;					
								$stmt->bindParam($p,$Id_Orden_Detalle,PDO::PARAM_INT);									
								$p++;
								$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
								$p++;
								$stmt->bindParam($p,$BodegaReceptora,PDO::PARAM_STR,255);								
								$p++;
								$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);
							
						
							}
							else if ($TipoOrdenEntrada == 2)
							{
							
								$stmt = $db->prepare("INSERT INTO movimientos (id_orden,tipo_orden,tipo_orden_entrada,id_orden_detalle,id_producto,id_bodega,balance_bodega,id_tienda,balance_tienda,fecha_agregado)
								VALUES (?,?,?,?,?,?,?,?,?,'".date('Y-m-d H:i:s')."')");					
								
								$CantTiendaProcedencia = $Cantidad[$f]*-1;
								
								$p = 1;
								$stmt->bindParam($p,$id_orden,PDO::PARAM_INT);
								$p++;			
								$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
								$p++;			
								$stmt->bindParam($p,$TipoOrdenEntrada,PDO::PARAM_INT);
								$p++;					
								$stmt->bindParam($p,$Id_Orden_Detalle,PDO::PARAM_INT);								
								$p++;
								$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
								$p++;
								$stmt->bindParam($p,$BodegaReceptora,PDO::PARAM_STR,255);	
								$p++;
								$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);							
								$p++;
								$stmt->bindParam($p,$TiendaProcedencia,PDO::PARAM_STR,255);						
								$p++;
								$stmt->bindParam($p,$CantTiendaProcedencia,PDO::PARAM_STR,255);	
								
							
							}
							else
							{
							
								$stmt = $db->prepare("INSERT INTO movimientos (id_orden,tipo_orden,tipo_orden_entrada,id_orden_detalle,id_producto,id_bodega,balance_bodega,fecha_agregado)
								VALUES (?,?,?,?,?,?,?,'".date('Y-m-d H:i:s')."')");					
															
								$p = 1;
								$stmt->bindParam($p,$id_orden,PDO::PARAM_INT);
								$p++;			
								$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
								$p++;			
								$stmt->bindParam($p,$TipoOrdenEntrada,PDO::PARAM_INT);
								$p++;					
								$stmt->bindParam($p,$Id_Orden_Detalle,PDO::PARAM_INT);								
								$p++;
								$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
								$p++;
								$stmt->bindParam($p,$BodegaReceptora,PDO::PARAM_STR,255);	
								$p++;
								$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);

								
								$Insertado4 = $stmt->execute();	
								//print_r($stmt->errorInfo());
								$stmt = $db->prepare("INSERT INTO movimientos (id_orden,tipo_orden,tipo_orden_entrada,id_orden_detalle,id_producto,id_bodega,balance_bodega,fecha_agregado)
								VALUES (?,?,?,?,?,?,?,'".date('Y-m-d H:i:s')."')");					
								
								$CantBodegaProcedencia = $Cantidad[$f]*-1;
								
								$p = 1;
								$stmt->bindParam($p,$id_orden,PDO::PARAM_INT);
								$p++;			
								$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
								$p++;			
								$stmt->bindParam($p,$TipoOrdenEntrada,PDO::PARAM_INT);
								$p++;					
								$stmt->bindParam($p,$Id_Orden_Detalle,PDO::PARAM_INT);							
								$p++;
								$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
								$p++;
								$stmt->bindParam($p,$BodegaProcedencia,PDO::PARAM_STR,255);	
								$p++;
								$stmt->bindParam($p,$CantBodegaProcedencia,PDO::PARAM_STR,255);

														
							}
						}
						else
						{
							$stmt = $db->prepare("INSERT INTO movimientos (id_orden,tipo_orden,id_orden_detalle,id_producto,id_bodega,balance_bodega,id_tienda,balance_tienda,fecha_agregado)
							VALUES (?,?,?,?,?,?,?,?,'".date('Y-m-d H:i:s')."')");					
							
							$CantBodegaProcedencia = $Cantidad[$f]*-1;
							
							$p = 1;
							$stmt->bindParam($p,$NumeroOrden,PDO::PARAM_INT);
							$p++;			
							$stmt->bindParam($p,$TipoOrden,PDO::PARAM_INT);
							$p++;					
							$stmt->bindParam($p,$Id_Orden_Detalle,PDO::PARAM_INT);
							$p++;							
							$stmt->bindParam($p,$Producto[$f],PDO::PARAM_STR,255);
							$p++;
							$stmt->bindParam($p,$BodegaProcedencia,PDO::PARAM_STR,255);	
							$p++;
							$stmt->bindParam($p,$CantBodegaProcedencia,PDO::PARAM_STR,255);
							$p++;
							$stmt->bindParam($p,$TiendaReceptora,PDO::PARAM_STR,255);						
							$p++;
							$stmt->bindParam($p,$Cantidad[$f],PDO::PARAM_STR,255);	
						
						}
						
						$Insertado4 = $stmt->execute();	
						//print_r($stmt->errorInfo());
						$CantMov = $Insertado4  + $CantMov ;
						
					}
					

					
					$f = $f + 1;

				}				
			
			}
			
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();		
		}
		

		//echo "$Actualizado-$Insertado1-$Insertado2";
		if (($Actualizado === true)  and ($Insertado1 === true) and ($Insertado2 === true)
		and ($CantContacto > 0) and (count($Cantidad) == $CantContacto) and ($CantMov > 0) and (count($Cantidad) == $CantMov))
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

	if($_GET['action'] == 'Eliminar_Orden')	
	{
		session_start();
		$db->beginTransaction();
		
		try
		{		
			$Id_Orden = strip_tags(utf8_decode($_POST['IdOrden']));
			$Id_Tipo_Orden = strip_tags(utf8_decode($_POST['TipoOrden']));			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Orden Eliminado";
			$Tipo = "6";			

			$stmt = $db->prepare("SELECT id_orden,id_tipo_orden FROM ordenes  WHERE MD5(id_orden) = ? AND MD5(id_tipo_orden) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);	
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_orden = $results[0]["id_orden"];
			$id_tipo_orden = $results[0]["id_tipo_orden"];
			$stmt->closeCursor();
				
			$stmt = $db->prepare("SELECT cantidad,id_producto FROM orden_detalle WHERE estatus_orden_detalle=1 AND MD5(id_orden) = ? AND MD5(id_tipo_orden) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$stmt = $db->prepare("SELECT cantidad_existencia FROM producto WHERE id_producto = ?");
							
			$p = 1;
			$stmt->bindParam($p,$results1[0]['id_producto'],PDO::PARAM_STR,255);						
			$stmt->execute();
			$results2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if ($results[0]["id_tipo_orden"] == 1)
			$CantExistenciaActual = $results2[0]['cantidad_existencia'] - $results1[0]['cantidad'];
			
			$stmt = $db->prepare("UPDATE producto SET cantidad_existencia = ? WHERE id_producto = ?");	
			$p = 1;
			$stmt->bindParam($p,$CantExistenciaActual,PDO::PARAM_INT);	
			$p++;
			$stmt->bindParam($p,$results1[0]['id_producto'],PDO::PARAM_STR,255);		

			$Actualizado = $stmt->execute();					
				
			$stmt = $db->prepare("UPDATE ordenes SET estatus_orden=0 WHERE MD5(id_orden) = ? AND MD5(id_tipo_orden) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);	

			$Eliminado = $stmt->execute();

			$stmt = $db->prepare("UPDATE orden_detalle SET estatus_orden_detalle=0,fecha_actualizado='".date('Y-m-d H:i:s')."' WHERE MD5(id_orden) = ? AND MD5(id_tipo_orden) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);	

			$Eliminado1 = $stmt->execute();	

			$stmt = $db->prepare("UPDATE movimientos SET estatus_movimiento=0,fecha_actualizado='".date('Y-m-d H:i:s')."' WHERE MD5(id_orden) = ? AND MD5(tipo_orden) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Id_Tipo_Orden,PDO::PARAM_STR,255);	

			$Eliminado2 = $stmt->execute();				
				
			$stmt = $db->prepare("INSERT INTO user_log (id_usuario,anio,fecha_log,evento,tipo) VALUES (?,YEAR('".date('Y-m-d H:i:s')."'), '".date('Y-m-d H:i:s')."',?,?)");
			$p = 1;
			$stmt->bindParam($p,$Id_Usuario,PDO::PARAM_INT);
			$p++;
			$stmt->bindParam($p,$Evento,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Tipo,PDO::PARAM_INT);
	
			$Insertado1 = $stmt->execute();
				
			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Log");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Log = $results[0]["Id_Log"];
				
			$stmt = $db->prepare("INSERT INTO historial_ordenes (id_orden,id_tipo_orden,id_log) VALUES (?,?,?)");
			$p = 1;
			$stmt->bindParam($p,$id_orden,PDO::PARAM_INT);
			$p++;
			$stmt->bindParam($p,$id_tipo_orden,PDO::PARAM_INT);
			$p++;			
			$stmt->bindParam($p,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();				
				
			$stmt->closeCursor();	

		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
	
		//echo "$Eliminado-$Insertado1-$Insertado2";
	
		if (($Eliminado === true) and ($Eliminado1 === true) and ($Insertado1 === true) and ($Insertado2 === true))
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

	if($_GET['action'] == 'Listar_Movimiento_Productos')	
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
			array( 'db' => 'id_movimiento', 'dt' => 0 ),
			array( 'db' => 'fecha_agregado',  'dt' => 1 ),
			array( 'db' => 'id_orden',   'dt' => 2 ),
			array( 'db' => 'descripcion_tipo_orden',   'dt' => 3 ),
			//array( 'db' => 'codigo_producto',   'dt' => 4 ),
			array( 'db' => 'nombre_producto',   'dt' => 4 ),
			array( 'db' => 'total_bodega',   'dt' => 5 ),			
			array( 'db' => 'total_bodega',   'dt' => 6 ),
			array( 'db' => 'total_tienda',   'dt' => 7 ),	
			array( 'db' => 'total_inventario',   'dt' => 8 ),
			array( 'db' => 'nombre_proveedor',   'dt' => 9 ),			
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			
			$Sql1 = "(SELECT id_movimiento,m.id_orden,m.fecha_agregado,m.tipo_orden,descripcion_tipo_orden,tipo_orden_entrada,'' AS id_venta,m.id_producto,codigo_producto,nombre_producto,m.id_bodega,m.id_tienda,
			descripcion_bodega,descripcion_tienda,nombre_proveedor,'' AS  nombre_cliente,
			(IFNULL(balance_bodega,0)) AS total_bodega,(IFNULL(balance_tienda,0)) AS total_tienda,(IFNULL(balance_bodega,0) + IFNULL(balance_tienda,0)) AS total_inventario
			FROM movimientos m
			INNER JOIN producto a ON (m.id_producto = a.id_producto)
			INNER JOIN bodegas b ON (b.id_bodega = m.id_bodega)
			INNER JOIN tiendas t ON (t.id_tienda = t.id_tienda)
			INNER JOIN ordenes o ON (o.id_orden = m.id_orden)
			INNER JOIN tipo_orden ot ON (ot.id_tipo_orden = m.tipo_orden)
			AND (ot.id_tipo_orden = o.id_tipo_orden)
			INNER JOIN proveedores p ON (p.id_proveedor = o.id_proveedor)
			WHERE m.estatus_movimiento = 1 AND m.tipo_orden = 1 AND m.tipo_orden_entrada = 1
			)
			UNION
			(SELECT id_movimiento,m.id_orden,m.fecha_agregado,m.tipo_orden,descripcion_tipo_orden,tipo_orden_entrada,'' AS id_venta,m.id_producto,codigo_producto,nombre_producto,m.id_bodega,m.id_tienda,
			descripcion_bodega,descripcion_tienda,'' AS nombre_proveedor,'' AS  nombre_cliente,
			(IFNULL(balance_bodega,0)) AS total_bodega,(IFNULL(balance_tienda,0)) AS total_tienda,(IFNULL(balance_bodega,0) + IFNULL(balance_tienda,0)) AS total_inventario
			FROM movimientos m
			INNER JOIN producto a ON (m.id_producto = a.id_producto)
			INNER JOIN bodegas b ON (b.id_bodega = m.id_bodega)
			INNER JOIN tiendas t ON (t.id_tienda = m.id_tienda)
			INNER JOIN ordenes o ON (o.id_orden = m.id_orden)
			INNER JOIN tipo_orden ot ON (ot.id_tipo_orden = m.tipo_orden)
			AND (ot.id_tipo_orden = o.id_tipo_orden)
			WHERE m.estatus_movimiento = 1 AND m.tipo_orden = 1 AND m.tipo_orden_entrada = 2
			)
			UNION
			(SELECT id_movimiento,m.id_orden,m.fecha_agregado,m.tipo_orden,descripcion_tipo_orden,tipo_orden_entrada,'' AS id_venta,m.id_producto,codigo_producto,nombre_producto,m.id_bodega,m.id_tienda,
			descripcion_bodega,descripcion_tienda,'' AS nombre_proveedor,'' AS  nombre_cliente,
			(IFNULL(balance_bodega,0)) AS total_bodega,(IFNULL(balance_tienda,0)) AS total_tienda,(IFNULL(balance_bodega,0) + IFNULL(balance_tienda,0)) AS total_inventario
			FROM movimientos m
			INNER JOIN producto a ON (m.id_producto = a.id_producto)
			INNER JOIN bodegas b ON (b.id_bodega = m.id_bodega)
			INNER JOIN tiendas t ON (t.id_tienda = t.id_tienda)
			INNER JOIN ordenes o ON (o.id_orden = m.id_orden)
			INNER JOIN tipo_orden ot ON (ot.id_tipo_orden = m.tipo_orden)
			AND (ot.id_tipo_orden = o.id_tipo_orden)
			WHERE m.estatus_movimiento = 1 AND m.tipo_orden = 1 AND m.tipo_orden_entrada = 3
			)
			UNION			
			(SELECT id_movimiento,m.id_orden,m.fecha_agregado,m.tipo_orden,descripcion_tipo_orden,'' AS tipo_orden_entrada,'' AS id_venta,m.id_producto,codigo_producto,nombre_producto,m.id_bodega,m.id_tienda,
			descripcion_bodega,descripcion_tienda,'' AS nombre_proveedor,'' AS  nombre_cliente,
			(IFNULL(balance_bodega,0)) AS total_bodega,(IFNULL(balance_tienda,0)) AS total_tienda,(IFNULL(balance_bodega,0) + IFNULL(balance_tienda,0)) AS total_inventario
			FROM movimientos m
			INNER JOIN producto a ON (m.id_producto = a.id_producto)
			INNER JOIN bodegas b ON (b.id_bodega = m.id_bodega)
			INNER JOIN tiendas t ON (t.id_tienda = t.id_tienda)
			INNER JOIN ordenes o ON (o.id_orden = m.id_orden)
			INNER JOIN tipo_orden ot ON (ot.id_tipo_orden = m.tipo_orden)
			AND (ot.id_tipo_orden = o.id_tipo_orden)
			WHERE m.estatus_movimiento = 1 AND m.tipo_orden = 2
			)
			UNION		
			(SELECT id_movimiento,'' AS id_orden,m.fecha_agregado,'' AS tipo_orden,'' AS descripcion_tipo_orden,'' AS tipo_orden_entrada,m.id_venta,m.id_producto,codigo_producto,nombre_producto,'' AS id_bodega,m.id_tienda,
			'' AS descripcion_bodega,descripcion_tienda,'' AS nombre_proveedor,
			IF(id_tipo_cliente=1,(SELECT CONCAT(nombre,' ',apellido) FROM cliente_persona WHERE id_cliente = v.id_cliente),(SELECT nombre_empresa FROM cliente_empresa WHERE id_cliente = v.id_cliente)) AS nombre_cliente,
			(IFNULL(balance_bodega,0)) AS total_bodega,(IFNULL(balance_tienda,0)) AS total_tienda,(IFNULL(balance_bodega,0) + IFNULL(balance_tienda,0)) AS total_inventario
			FROM movimientos m
			INNER JOIN producto a ON (m.id_producto = a.id_producto)
			INNER JOIN tiendas t ON (t.id_tienda = t.id_tienda)
			INNER JOIN ventas v ON (v.id_venta = m.id_venta)
			WHERE m.estatus_movimiento = 1
			)
			";

			/*$stmt = $db->prepare("SELECT fd.id_factura_detalle,fd.id_factura,a.id_producto,a.codigo_producto,a.descripcion_producto,fd.cantidad FROM
			factura_detalle fd INNER JOIN producto a ON (fd.id_producto = a.id_producto)
			WHERE estatus_factura_detalle = 1 AND producto_retirado = 0 ORDER BY id_factura");*/
						
			$Sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT(id_movimiento),id_orden,fecha_agregado,tipo_orden,descripcion_tipo_orden,tipo_orden_entrada,id_venta,id_producto,
			codigo_producto,nombre_producto,id_bodega,id_tienda,descripcion_bodega,descripcion_tienda,nombre_proveedor,nombre_cliente,total_bodega,total_tienda,total_inventario 
			FROM (".$Sql1.") AS T ".$where." ".$order." ".$limit;			
			
			$stmt = $db->prepare($Sql);			

			if ( is_array( $bindings ) ) {
				for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
					$binding = $bindings[$i];
					
					if ($i == 1)
					{
						$Fecha = explode("-",$binding['val']);
						$binding['val'] = utf8_encode($Fecha[2]."-".$Fecha[1]."-".$Fecha[0]);						
					}
					
					$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
				}
			}
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			
			$stmt = $db->prepare("SELECT FOUND_ROWS()");
			
			$stmt->execute();
			$resFilterLength = $stmt->fetchColumn (0);

			$stmt = $db->prepare("SELECT SUM(Total) AS Total_Registro
			FROM(		
			(SELECT COUNT(DISTINCT id_movimiento) AS Total
			FROM movimientos m
			INNER JOIN producto a ON (m.id_producto = a.id_producto)
			INNER JOIN bodegas b ON (b.id_bodega = m.id_bodega)
			INNER JOIN tiendas t ON (t.id_tienda = t.id_tienda)
			INNER JOIN ordenes o ON (o.id_orden = m.id_orden)
			INNER JOIN tipo_orden ot ON (ot.id_tipo_orden = m.tipo_orden)
			AND (ot.id_tipo_orden = o.id_tipo_orden)
			INNER JOIN proveedores p ON (p.id_proveedor = o.id_proveedor)
			WHERE m.estatus_movimiento = 1 AND m.tipo_orden = 1 AND m.tipo_orden_entrada = 1
			)
			UNION ALL
			(SELECT COUNT(DISTINCT id_movimiento) AS Total
			FROM movimientos m
			INNER JOIN producto a ON (m.id_producto = a.id_producto)
			INNER JOIN bodegas b ON (b.id_bodega = m.id_bodega)
			INNER JOIN tiendas t ON (t.id_tienda = m.id_tienda)
			INNER JOIN ordenes o ON (o.id_orden = m.id_orden)
			INNER JOIN tipo_orden ot ON (ot.id_tipo_orden = m.tipo_orden)
			AND (ot.id_tipo_orden = o.id_tipo_orden)
			WHERE m.estatus_movimiento = 1 AND m.tipo_orden = 1 AND m.tipo_orden_entrada = 2
			)
			UNION ALL
			(SELECT COUNT(DISTINCT id_movimiento) AS Total
			FROM movimientos m
			INNER JOIN producto a ON (m.id_producto = a.id_producto)
			INNER JOIN bodegas b ON (b.id_bodega = m.id_bodega)
			INNER JOIN tiendas t ON (t.id_tienda = t.id_tienda)
			INNER JOIN ordenes o ON (o.id_orden = m.id_orden)
			INNER JOIN tipo_orden ot ON (ot.id_tipo_orden = m.tipo_orden)
			AND (ot.id_tipo_orden = o.id_tipo_orden)
			WHERE m.estatus_movimiento = 1 AND m.tipo_orden = 1 AND m.tipo_orden_entrada = 3
			)
			UNION ALL			
			(SELECT COUNT(DISTINCT id_movimiento) AS Total
			FROM movimientos m
			INNER JOIN producto a ON (m.id_producto = a.id_producto)
			INNER JOIN bodegas b ON (b.id_bodega = m.id_bodega)
			INNER JOIN tiendas t ON (t.id_tienda = t.id_tienda)
			INNER JOIN ordenes o ON (o.id_orden = m.id_orden)
			INNER JOIN tipo_orden ot ON (ot.id_tipo_orden = m.tipo_orden)
			AND (ot.id_tipo_orden = o.id_tipo_orden)
			WHERE m.estatus_movimiento = 1 AND m.tipo_orden = 2
			)
			UNION ALL		
			(SELECT COUNT(DISTINCT id_movimiento) AS Total
			FROM movimientos m
			INNER JOIN producto a ON (m.id_producto = a.id_producto)
			INNER JOIN tiendas t ON (t.id_tienda = t.id_tienda)
			INNER JOIN ventas v ON (v.id_venta = m.id_venta)
			WHERE m.estatus_movimiento = 1
			)
			) AS T");			
				
			$stmt->execute();			
			$recordsTotal = $stmt->fetchColumn (0);	
			
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		$Data = array();				
		if ($nfilas > 0)
		{
			$f = 0; $CantidadBodega = false; $CantidadTienda = false; $CantidadInventario = false;				
			foreach ($rows as $row)
			{
				$c = 0;
				$Id_Producto = $row['id_producto'];
				$Fecha_Orden = date("d-m-Y h:i:s",strtotime($row['fecha_agregado']));
				
				$Data[$f][$c] = $f+1;
				$c++;
				$Data[$f][$c] = utf8_encode($Fecha_Orden);
				$c++;

				if ($row['id_orden'] != "")
				{
					$Data[$f][$c] = utf8_encode($row['id_orden']);	
					$c++;
				}
				if ($row['id_venta'] != "")
				{					
					$Data[$f][$c] = utf8_encode($row['id_venta']);
					$c++;
					$Data[$f][$c] = utf8_encode("Venta");
					$c++;
				}
				if ($row['id_orden'] != "")
				{
					if ($row['tipo_orden'] == 1)
					$Data[$f][$c] = utf8_encode("Orden ".$row['descripcion_tipo_orden']);
					else if ($row['tipo_orden'] == 2)
					$Data[$f][$c] = utf8_encode("Orden ".$row['descripcion_tipo_orden']);
					$c++;				
				}

				//$Data[$f][$c] = utf8_encode($row['codigo_producto']);
				//$c++;
				$Data[$f][$c] = utf8_encode($row['nombre_producto']);
				$c++;
				
				if ($row['id_orden'] != "")
				{
					$Data[$f][$c] = utf8_encode(abs($row['total_bodega']));
					$c++;
				}
				else
				{
					$Data[$f][$c] = utf8_encode(abs($row['total_tienda'])+abs($row['total_bodega']));
					$c++;
				}
// PREGUNTAR A AGUSTIN POR ESTOS CALCULOS
	 $CantidadBodega["'".$Id_Producto."'"]     = $row['total_bodega'];
 	 $CantidadTienda["'".$Id_Producto."'"]     = $row['total_tienda'];
	 $CantidadInventario["'".$Id_Producto."'"] = $row['total_inventario'];

	 $CantidadBodega["'".$Id_Producto."'"]     += $CantidadBodega["'".$Id_Producto."'"];
	 $CantidadTienda["'".$Id_Producto."'"]     += $CantidadTienda["'".$Id_Producto."'"];
	 $CantidadInventario["'".$Id_Producto."'"] += $CantidadInventario["'".$Id_Producto."'"];

//=============================================	
	 
				$Data[$f][$c] = utf8_encode($CantidadBodega["'".$Id_Producto."'"]);
				$c++;
				$Data[$f][$c] = utf8_encode($CantidadTienda["'".$Id_Producto."'"]);
				$c++;
				$Data[$f][$c] = utf8_encode($CantidadInventario["'".$Id_Producto."'"]);
				$c++;
				
				if ($row['id_orden'] != "")
				{
					if ($row['tipo_orden'] == 1)
					{
						if ($row['id_proveedor'] != "")
						$Data[$f][$c] = utf8_encode($row['nombre_proveedor']);
						else if (($row['id_bodega'] != "") and ($row['id_proveedor'] == ""))
						$Data[$f][$c] = utf8_encode($row['descripcion_bodega']);							
						else if ($row['id_tienda'] != "")
						$Data[$f][$c] = utf8_encode($row['descripcion_tienda']);
						$c++;					
					}
					else if ($row['tipo_orden'] == 2)
					{
						$Data[$f][$c] = utf8_encode($row['descripcion_tienda']);
						$c++;						
					}					
				}

				if ($row['id_venta'] != "")
				{
					$Data[$f][$c] = utf8_encode($row['nombre_cliente']);
					$c++;
				}
				
				$f = $f + 1;
			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;
		echo json_encode($ResultSet);				
		
	
	}	


	
	
/********************************************Orden de Trabajo*************************************************************************************************************************************/	
	if($_GET['action'] == 'Cantidad_Ordenes')
	{
		try
		{		
			$stmt = $db->prepare("(SELECT id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_imprenta IS NOT NULL,descripcion_imprenta,'Trabajo de Imprenta') AS Descripcion_Trabajo,  descripcion_estatus, porcentaje_realizado, ot.fecha_creado
			FROM orden_trabajo ot
			INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
			INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
			INNER JOIN imprenta i ON (ot.id_imprenta = i.id_imprenta)
			AND (cp.id_imprenta = i.id_imprenta)
			INNER JOIN tipo_estatus te ON(te.id_estatus = ot.id_estado))
			UNION
			(SELECT id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_banner IS NOT NULL,descripcion_banner,'Trabajo de Banner') AS Descripcion_Trabajo, descripcion_estatus, porcentaje_realizado, ot.fecha_creado
			FROM orden_trabajo ot
			INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
			INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
			INNER JOIN banner b ON (ot.id_banner = b.id_banner)
			AND (cp.id_banner = b.id_banner)
			INNER JOIN tipo_estatus te ON(te.id_estatus = ot.id_estado))
			UNION
			(SELECT id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_impresion IS NOT NULL,descripcion_impresion,'Trabajo de IMPRESION') AS Descripcion_Trabajo, descripcion_estatus, porcentaje_realizado, ot.fecha_creado
			FROM orden_trabajo ot
			INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
			INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
			INNER JOIN impresion im ON (ot.id_impresion = im.id_impresion)
			AND (cp.id_impresion = im.id_impresion)
			INNER JOIN tipo_estatus te ON(te.id_estatus = ot.id_estado)) ORDER BY fecha_creado DESC LIMIT 0,10");
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}

		echo "+".$nfilas;
	}
	
	if($_GET['action'] == 'Ultimas_Ordenes')
	{
		$html = "";		
		
		try
		{		
			$stmt = $db->prepare("(SELECT id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_imprenta IS NOT NULL,descripcion_imprenta,'Trabajo de Imprenta') AS Descripcion_Trabajo,  descripcion_estatus, porcentaje_realizado, ot.fecha_creado
			FROM orden_trabajo ot
			INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
			INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
			INNER JOIN imprenta i ON (ot.id_imprenta = i.id_imprenta)
			AND (cp.id_imprenta = i.id_imprenta)
			INNER JOIN tipo_estatus te ON(te.id_estatus = ot.id_estado))
			UNION
			(SELECT id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_banner IS NOT NULL,descripcion_banner,'Trabajo de Banner') AS Descripcion_Trabajo, descripcion_estatus, porcentaje_realizado, ot.fecha_creado
			FROM orden_trabajo ot
			INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
			INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
			INNER JOIN banner b ON (ot.id_banner = b.id_banner)
			AND (cp.id_banner = b.id_banner)
			INNER JOIN tipo_estatus te ON(te.id_estatus = ot.id_estado))
			UNION
			(SELECT id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_impresion IS NOT NULL,descripcion_impresion,'Trabajo de IMPRESION') AS Descripcion_Trabajo, descripcion_estatus, porcentaje_realizado, ot.fecha_creado
			FROM orden_trabajo ot
			INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
			INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
			INNER JOIN impresion im ON (ot.id_impresion = im.id_impresion)
			AND (cp.id_impresion = im.id_impresion)
			INNER JOIN tipo_estatus te ON(te.id_estatus = ot.id_estado)) ORDER BY fecha_creado DESC LIMIT 0,10");
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		if($nfilas > 0)
		{
			foreach ($rows as $row)
			{
				
				$Id_Cotizacion = $row['id_cotizacion'];
	

				try
				{		
					$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,descripcion_cotizacion 
					FROM cotizaciones co INNER JOIN tipo_estatus_cotizacion te ON (te.id_estatus = co.id_estatus) WHERE id_cotizaciones = ?");

					$p = 1;
					$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
					$stmt->execute();
					$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$nfilas1 = $stmt->rowCount();
					$stmt->closeCursor();
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}
		
		
		
				if ($rows1[0]['id_tipo_cliente'] == 1)
				{
					try
					{		
						$Id_Cliente = $rows1[0]['id_cliente'];
				
						$stmt = $db->prepare("SELECT CONCAT(nombre,' ',apellido) AS Nombre_Cliente FROM cliente_persona WHERE id_cliente = ?");			
		
						$p = 1;
						$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_STR,255);
			
						$stmt->execute();
						$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas2 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}		
		
		
		
		
		
				}
				else if ($rows1[0]['id_tipo_cliente'] == 2)
				{
		
					try
					{		
						$Id_Cliente = $rows1[0]['id_cliente'];
				
						$stmt = $db->prepare("SELECT nombre_empresa AS Nombre_Cliente FROM cliente_empresa WHERE id_cliente = ?");				

						$p = 1;
						$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_STR,255);
			
						$stmt->execute();
						$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas2 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}		
		
				}				
				
				
				
				$html .= '<tr>
								<td ><a href="listar_orden_trabajo.html" title="">'.utf8_encode($row['id_orden_trabajo']).'</a></td>
                                <td><a href="listar_orden_trabajo.html" title="">'.utf8_encode($row['id_cotizacion']).'</a></td>
								<td><a href="listar_orden_trabajo.html" title="">'.utf8_encode($rows2[0]['Nombre_Cliente']).'</a></td>
								<td><a href="listar_orden_trabajo.html" title="">'.utf8_encode($rows1[0]['descripcion_cotizacion']).'</a></td>
								<td class="taskPr"><a href="listar_orden_trabajo.html" title="">'.utf8_encode($row['Descripcion_Trabajo']).'</a></td>
                                <td><span class="green f11">'.utf8_encode($row['descripcion_estatus']).'</span></td>
                                <td class="actBtns"><a href="listar_orden_trabajo.html" title="Update" class="tipS"><img src="public/images/icons/edit.png" alt="" /></a><a href="listar_orden_trabajo.html" title="Remove" class="tipS"><img src="public/images/icons/remove.png" alt="" /></a></td>
                            </tr>';			
			
			
			
			
			}
		}
		
		echo $html;
	}
	
	if($_GET['action'] == 'Cantidad_Asignaciones')	
	{	
		session_start();
		$html = "";
		$id_usuario = base64_decode($_SESSION['id_usuario']);
		try
		{		
			$stmt = $db->prepare("(SELECT ot.id_orden_trabajo, ot.id_cotizacion,  cantidad,  IF(descripcion_imprenta IS NOT NULL,descripcion_imprenta,'Trabajo de Imprenta') AS Descripcion_Trabajo, IF(estatus_arte = 1,'ASIGNACION DE ARTE',IF(estatus_impresion = 1,'ASIGNACION DE IMPRESION',IF(estatus_acabado = 1,'ASIGNACION DE ACABADO', 'Sin ASIGNACION') ) ) AS tipo_asignacion,  ot.fecha_creado
			FROM orden_trabajo ot
			INNER JOIN orden_trabajo_asignar ota ON (ot.id_orden_trabajo = ota.id_orden_trabajo)
			INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
			INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
			INNER JOIN imprenta i ON (ot.id_imprenta = i.id_imprenta)
			AND (cp.id_imprenta = i.id_imprenta)
			WHERE ota.id_usuario = ? AND (estatus_arte = 1 OR estatus_impresion = 1 OR estatus_acabado = 1))
			UNION
			(SELECT ot.id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_banner IS NOT NULL,descripcion_banner,'Trabajo de Banner') AS Descripcion_Trabajo, IF(estatus_arte = 1,'ASIGNACION DE ARTE',IF(estatus_impresion = 1,'ASIGNACION DE IMPRESION',IF(estatus_acabado = 1,'ASIGNACION DE ACABADO', 'Sin ASIGNACION') ) ) AS tipo_asignacion, ot.fecha_creado
			FROM orden_trabajo ot
			INNER JOIN orden_trabajo_asignar ota ON (ot.id_orden_trabajo = ota.id_orden_trabajo)
			INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
			INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
			INNER JOIN banner b ON (ot.id_banner = b.id_banner)
			AND (cp.id_banner = b.id_banner)
			WHERE ota.id_usuario = ? AND (estatus_arte = 1 OR estatus_impresion = 1 OR estatus_acabado = 1))
			UNION
			(SELECT ot.id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_impresion IS NOT NULL,descripcion_impresion,'Trabajo de IMPRESION') AS Descripcion_Trabajo, IF(estatus_arte = 1,'ASIGNACION DE ARTE',IF(estatus_impresion = 1,'ASIGNACION DE IMPRESION',IF(estatus_acabado = 1,'ASIGNACION DE ACABADO', 'Sin ASIGNACION') ) ) AS tipo_asignacion, ot.fecha_creado
			FROM orden_trabajo ot
			INNER JOIN orden_trabajo_asignar ota ON (ot.id_orden_trabajo = ota.id_orden_trabajo)
			INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
			INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
			INNER JOIN impresion im ON (ot.id_impresion = im.id_impresion)
			AND (cp.id_impresion = im.id_impresion)
			WHERE ota.id_usuario = ? AND (estatus_arte = 1 OR estatus_impresion = 1 OR estatus_acabado = 1)) ORDER BY fecha_creado DESC");

			$c = 1;
			$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);			
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		echo "+".$nfilas;
	
	}	
	if($_GET['action'] == 'Lista_Asignaciones')	
	{	
		session_start();
		$html = "";
		$id_usuario = base64_decode($_SESSION['id_usuario']);
		try
		{		
			$stmt = $db->prepare("(SELECT ot.id_orden_trabajo, ot.id_cotizacion,  cantidad,  IF(descripcion_imprenta IS NOT NULL,descripcion_imprenta,'Trabajo de Imprenta') AS Descripcion_Trabajo, IF(estatus_arte = 1,'ASIGNACION DE ARTE',IF(estatus_impresion = 1,'ASIGNACION DE IMPRESION',IF(estatus_acabado = 1,'ASIGNACION DE ACABADO', 'Sin ASIGNACION') ) ) AS tipo_asignacion,  ot.fecha_creado
			FROM orden_trabajo ot
			INNER JOIN orden_trabajo_asignar ota ON (ot.id_orden_trabajo = ota.id_orden_trabajo)
			INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
			INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
			INNER JOIN imprenta i ON (ot.id_imprenta = i.id_imprenta)
			AND (cp.id_imprenta = i.id_imprenta)
			WHERE ota.id_usuario = ? AND (estatus_arte = 1 OR estatus_impresion = 1 OR estatus_acabado = 1))
			UNION
			(SELECT ot.id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_banner IS NOT NULL,descripcion_banner,'Trabajo de Banner') AS Descripcion_Trabajo, IF(estatus_arte = 1,'ASIGNACION DE ARTE',IF(estatus_impresion = 1,'ASIGNACION DE IMPRESION',IF(estatus_acabado = 1,'ASIGNACION DE ACABADO', 'Sin ASIGNACION') ) ) AS tipo_asignacion, ot.fecha_creado
			FROM orden_trabajo ot
			INNER JOIN orden_trabajo_asignar ota ON (ot.id_orden_trabajo = ota.id_orden_trabajo)
			INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
			INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
			INNER JOIN banner b ON (ot.id_banner = b.id_banner)
			AND (cp.id_banner = b.id_banner)
			WHERE ota.id_usuario = ? AND (estatus_arte = 1 OR estatus_impresion = 1 OR estatus_acabado = 1))
			UNION
			(SELECT ot.id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_impresion IS NOT NULL,descripcion_impresion,'Trabajo de IMPRESION') AS Descripcion_Trabajo, IF(estatus_arte = 1,'ASIGNACION DE ARTE',IF(estatus_impresion = 1,'ASIGNACION DE IMPRESION',IF(estatus_acabado = 1,'ASIGNACION DE ACABADO', 'Sin ASIGNACION') ) ) AS tipo_asignacion, ot.fecha_creado
			FROM orden_trabajo ot
			INNER JOIN orden_trabajo_asignar ota ON (ot.id_orden_trabajo = ota.id_orden_trabajo)
			INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
			INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
			INNER JOIN impresion im ON (ot.id_impresion = im.id_impresion)
			AND (cp.id_impresion = im.id_impresion)
			WHERE ota.id_usuario = ? AND (estatus_arte = 1 OR estatus_impresion = 1 OR estatus_acabado = 1)) ORDER BY fecha_creado DESC");

			$c = 1;
			$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);	
			$c++;
			$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		if($nfilas > 0)
		{
			foreach ($rows as $row)
			{

				$html .= '<tr>
								<td ><a href="#" title="">'.utf8_encode($row['id_orden_trabajo']).'</a></td>
                                <td><a href="#" title="">'.utf8_encode($row['id_cotizacion']).'</a></td>
								<td class="taskPr"><a href="#" title="">'.utf8_encode($row['Descripcion_Trabajo']).'</a></td>
                                <td><span class="green f11">'.utf8_encode($row['tipo_asignacion']).'</span></td>
                                <td class="actBtns"><a href="listar_orden_trabajo.html" title="Update" class="tipS"><img src="public/images/icons/edit.png" alt="" /></a><a href="listar_orden_trabajo.html" title="Remove" class="tipS"><img src="public/images/icons/remove.png" alt="" /></a></td>
                            </tr>';			
			
			
			
			
			}
		}
		else
		{
				$html .= '<tr>
								<td colspan="5">No tienes Tareas asignadas</td>
                            </tr>';		
		
		
		}
		
		echo $html;
	
	}
	
	if($_GET['action'] == 'Tarea_Finalizada')	
	{	
		session_start();
		$html = "";	
		try
		{		
				
			$stmt = $db->prepare("SELECT COUNT(*) FROM orden_trabajo_asignar WHERE estatus_arte = 3 OR estatus_impresion =  3 OR estatus_acabado = 3 GROUP BY id_asignacion");	
			
			$Ejecutado = $stmt->execute();
			
			$nfilas = $stmt->fetchColumn();
			
			$stmt->closeCursor();			
			
			
			if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))		
			{
				if ($nfilas > 1)
				$html = $nfilas.' Tareas finalizadas';
				else if ($nfilas == 1)
				$html = $nfilas.' Tarea Finalizada';				
				else
				$html = '';
			}
			else
			$html = '';	
			

		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}	
	
		echo $html;
	
	}	

	
	if($_GET['action'] == 'Listar_Cotizacion_Orden_Autocompletar')
	{

		$html = "";
		session_start();
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		if(isset($_GET["search"]))		
		$criterio = strtolower($_GET["search"]);
		
		if (!$criterio) return;

		try
		{		
		
			$Sql1 = "SELECT id_cliente,id_tipo_cliente,id_cotizaciones,descripcion_cotizacion,co.id_estatus, descripcion_estatus,monto_subtotal,monto_itbm,monto_total,
			IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones)) AS monto_abonado 
			FROM cotizaciones co INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus)
			WHERE id_cotizaciones LIKE '".$criterio."%'";

			if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
			{			
				$Sql = "SELECT id_cliente,id_tipo_cliente,id_cotizaciones,descripcion_cotizacion,id_estatus,descripcion_estatus,monto_subtotal,monto_itbm,monto_total,
				monto_abonado FROM (".$Sql1.") AS T WHERE ROUND(monto_abonado, 2) >= 0";
			}
			else
			{
				$Sql = "SELECT id_cliente,id_tipo_cliente,id_cotizaciones,descripcion_cotizacion,id_estatus,descripcion_estatus,monto_subtotal,monto_itbm,monto_total,
				monto_abonado FROM (".$Sql1.") AS T WHERE ROUND(monto_abonado, 2) > 0";								
			}
		
			$stmt = $db->prepare($Sql);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		

		/*
		try
		{		

			$stmt = $db->prepare("SELECT id_cotizaciones, descripcion_cotizacion FROM cotizaciones c
			INNER JOIN abono a ON (a.id_cotizacion = c.id_cotizaciones) WHERE  id_cotizaciones LIKE '".$criterio."%'
			AND ((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion LIKE id_cotizaciones)/monto_total) >= 0.25  GROUP BY id_cotizaciones");

			//WHERE descripcion_producto like '".mysql_real_escape_string(strip_tags(utf8_decode($criterio)))."%'");		
			//$c = 1;
			//$stmt->bindParam($c,$criterio,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}*/

		$c = 0;
			
		if ($nfilas > 0)
		{
			foreach ($rows as $row)
			{
				try
				{		
					
					$Id_Cliente = $row['id_cliente'];
					
					if($row['id_tipo_cliente']==1)
					$stmt = $db->prepare("SELECT credito 
					FROM cliente_persona WHERE id_cliente = ?");
					else if($row['id_tipo_cliente']==2)
					$stmt = $db->prepare("SELECT credito
					FROM cliente_empresa  WHERE id_cliente = ?");
					
					$p = 1;
					$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_INT);
			
					$stmt->execute();
					$rowsCliente = $stmt->fetchAll(PDO::FETCH_ASSOC);
					//$nfilas = $stmt->rowCount();
					$stmt->closeCursor();
					
					$Credito = $rowsCliente[0]['credito'];
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}	
				
				try
				{		
					
					$Id_Cliente = $row['id_cliente'];
					$Id_Cotizaciones = $row['id_cotizaciones'];
					
					$stmt = $db->prepare("SELECT  SUM(IF(id_imprenta,1,0) + IF(id_banner,1,0) + IF(id_impresion,1,0)) AS Trabajo
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
				
				try
				{		
					
					$Id_Cotizaciones = $row['id_cotizaciones'];
					
					$stmt = $db->prepare("SELECT COUNT(*) As Existe FROM orden_trabajo WHERE id_cotizacion = ?");

					
					$p = 1;
					$stmt->bindParam($p,$Id_Cotizaciones,PDO::PARAM_INT);
					
					$stmt->execute();
					$rowsExisteTrabajo = $stmt->fetchAll(PDO::FETCH_ASSOC);
					//$nfilas = $stmt->rowCount();
					$stmt->closeCursor();
					
					$ExisteTrabajoImprenta = $rowsExisteTrabajo[0]['Existe'];
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}				
				
				if ((($TrabajoImprenta > 0) and ($ExisteTrabajoImprenta == 0)) or ($TrabajoImprenta > $ExisteTrabajoImprenta))
				{				

					if ($row['monto_abonado'] > 0) {
					if (((($row['monto_abonado']/$row['monto_total']) > 0.50) or ($Credito == 1))  and ((base64_decode($_SESSION['id_tipo_usuario']) != 1) or (base64_decode($_SESSION['id_tipo_usuario']) != 2))
					or ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2)))
					{
						$Numero_Cotizacion[$c]['numero_cotizacion'] = utf8_encode($row['id_cotizaciones']);
						$Numero_Cotizacion[$c]['value'] = utf8_encode($row['id_cotizaciones']." (".$row['descripcion_cotizacion'].")");
						$c++;
					}
					}
				}
				
			}
		}
		
		$html = json_encode($Numero_Cotizacion);
		
		echo $html;		
	
	}
	
	
	if($_GET['action'] == 'Listar_Trabajo_Cotizacion')	
	{

		$html = "";
		
		try
		{		
			$Id_Cotizacion	= strip_tags(utf8_decode(strtolower($_POST['id'])));
			
			$stmt = $db->prepare("SELECT id_cotizacion, i.id_imprenta AS Id_Trabajo, '1' AS tipo_trabajo, cantidad, IF(descripcion_imprenta IS NOT NULL,descripcion_imprenta,'Trabajo de Imprenta') AS Descripcion_Trabajo, arte AS Trabajo_Arte FROM cotizacion_producto cp
			INNER JOIN imprenta i ON (cp.id_imprenta = i.id_imprenta)
			WHERE id_producto IS NULL OR id_producto = 0 AND MD5(id_cotizacion) = ?
			UNION
			SELECT id_cotizacion, b.id_banner AS Id_Trabajo, '2' AS tipo_trabajo, cantidad, IF(descripcion_banner IS NOT NULL,descripcion_banner,'Trabajo de Banner') AS Descripcion_Trabajo, precio_arte AS Trabajo_Arte FROM cotizacion_producto cp
			INNER JOIN banner b ON (cp.id_banner = b.id_banner)
			WHERE id_producto IS NULL OR id_producto = 0 AND MD5(id_cotizacion) = ?
			UNION
			SELECT id_cotizacion, im.id_impresion AS Id_Trabajo, '3' AS tipo_trabajo, cantidad, IF(descripcion_impresion IS NOT NULL,descripcion_impresion,'Trabajo de IMPRESION') AS Descripcion_Trabajo, precio_arte AS Trabajo_Arte FROM cotizacion_producto cp
			INNER JOIN impresion im ON (cp.id_impresion = im.id_impresion)
			WHERE id_producto IS NULL OR id_producto = 0 AND MD5(id_cotizacion) = ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_INT);
			$p++;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_INT);	
			$p++;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_INT);
			
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
				
				try
				{		
					//SELECT COUNT(*) FROM orden_trabajo WHERE id_cotizacion = 144 AND id_imprenta = 30 AND id_banner = 30
					if ($row['tipo_trabajo'] == 1)
					$stmt = $db->prepare("SELECT COUNT(*) As Existe FROM orden_trabajo WHERE MD5(id_cotizacion) = ? AND id_imprenta = ?");
					else if ($row['tipo_trabajo'] == 2)
					$stmt = $db->prepare("SELECT COUNT(*) As Existe FROM orden_trabajo WHERE MD5(id_cotizacion) = ? AND id_banner = ?");
					else if ($row['tipo_trabajo'] == 3)
					$stmt = $db->prepare("SELECT COUNT(*) As Existe FROM orden_trabajo WHERE MD5(id_cotizacion) = ? AND id_impresion = ?");					

					$p = 1;
					$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_INT);
					$p++;
					$stmt->bindParam($p,$row['Id_Trabajo'],PDO::PARAM_INT);	
			
					$stmt->execute();
					$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$nfilas1 = $stmt->rowCount();
					$stmt->closeCursor();
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}				
				//echo $rows1[0]['Existe'];
				if ($rows1[0]['Existe'] == 0)
				{
					$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
							<tr>
							<td>'.$c.'</td>
							<td>'.utf8_encode($row['cantidad']).'<input type="hidden" id="hidCantidad'.$c.'" name="hidCantidad[]" value="'.utf8_encode($row['cantidad']).'" /></td>						
							<td>Unidad</td>
							<td>'.utf8_encode($row['Descripcion_Trabajo']).'<input type="hidden" id="hidDescripcionTrabajo'.$c.'" name="hidDescripcionTrabajo[]" value="'.utf8_encode($row['Descripcion_Trabajo']).'" />
							<input type="hidden" id="hidTipoTrabajo'.$c.'" name="hidTipoTrabajo[]" value="'.utf8_encode($row['tipo_trabajo']).'" />
							<input type="hidden" id="hidIdTrabajo'.$c.'" name="hidIdTrabajo[]" value="'.utf8_encode($row['Id_Trabajo']).'" /></td>
							<td><input type="radio" id="rdbseleccion'.$c.'" name="rdbseleccion" value="'.$c.'" class="validate[required]" data-prompt-position="topRight:102" value="" />&nbsp;</td>
							<td>&nbsp;</td>
							</tr>
							<tr id="seleccionado'.$c.'" style="display:none" name="seleccionado[]">
							<td colspan="5">
							<div class="formRow">';
					if (($row['Trabajo_Arte'] > 0) and ($row['Trabajo_Arte'] != ""))
					{
						$html .='<label>Nombre del Usuario Asignado para Arte:<span class="req">*</span></label>
								<div class="formRight">
								<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado1[]" id="txtUsuarioAsignado1'.$c.'"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado1[]" id="hidUsuarioAsignado1'.$c.'"/>
								</div><div class="clear"></div>';
					}else
					{
						$html .='<label>Nombre del Usuario Asignado para Impresi&oacute;n:<span class="req">*</span></label>
								<div class="formRight">
								<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado2[]" id="txtUsuarioAsignado2'.$c.'"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado2[]" id="hidUsuarioAsignado2'.$c.'"/>
								</div><div class="clear"></div>';
					}
					/*$html .='<label>Nombre del Usuario Asignado para Acabado:<span class="req">*</span></label>
							<div class="formRight">
							<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado3[]" id="txtUsuarioAsignado3'.$c.'"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado3[]" id="hidUsuarioAsignado3'.$c.'"/>
							</div><div class="clear"></div>
							<label>Nombre del Usuario Asignado para Detalle:<span class="req">*</span></label>
							<div class="formRight">
							<input type="text" value="" class="validate[required]" name="txtUsuarioAsignado4[]" id="txtUsuarioAsignado4'.$c.'"  style="width:100%"/><input type="hidden" value="" class="validate[required]" name="hidUsuarioAsignado4[]" id="hidUsuarioAsignado4'.$c.'"/>
							</div><div class="clear"></div>						
							</div>
							</td>
							</tr>
						</tr>';*/
				}
					
				$c++;
			}
		}
		
		echo $html;
	}	
	
	if($_GET['action'] == 'Agregar_Orden_Trabajo')	
	{	
	
		session_start();
		$db->beginTransaction();
		try
		{
			

			$NumeroCotizacion	= strip_tags(utf8_decode($_POST['NumeroCotizacion']));
			$FechaEntrega	= utf8_decode($_POST['FechaEntrega']);
			
			$fecha = explode ("-" ,$FechaEntrega);
			$Fecha_Entrega = $fecha[2]."-".$fecha[1]."-".$fecha[0];			

			/*$UsuarioAsignado1 = strip_tags(utf8_decode($_POST['UsuarioAsignado1']));
			$UsuarioAsignado2 = strip_tags(utf8_decode($_POST['UsuarioAsignado2']));
			$UsuarioAsignado3 = strip_tags(utf8_decode($_POST['UsuarioAsignado3']));
			$UsuarioAsignado4 = strip_tags(utf8_decode($_POST['UsuarioAsignado4']));*/

			$Usuario_Asignado1 = explode(',',$_POST['UsuarioAsignado1']);	
			$Usuario_Asignado2 = explode(',',$_POST['UsuarioAsignado2']);
			$Usuario_Asignado3 = explode(',',$_POST['UsuarioAsignado3']);
			//$Usuario_Asignado4 = explode(',',$_POST['UsuarioAsignado4']);
			
			$e = 0;
			while ($e < count($Usuario_Asignado2))
			{
				if ($Usuario_Asignado1[$e] != "")
				$UsuarioAsignado1 = strip_tags(utf8_decode($Usuario_Asignado1[$e]));
			
				if ($Usuario_Asignado2[$e] != "")
				$UsuarioAsignado2 = strip_tags(utf8_decode($Usuario_Asignado2[$e]));
				
				if ($Usuario_Asignado3[$e] != "")
				$UsuarioAsignado3 = strip_tags(utf8_decode($Usuario_Asignado3[$e]));

				//if ($Usuario_Asignado4[$e] != "")
				//$UsuarioAsignado4 = strip_tags(utf8_decode($Usuario_Asignado4[$e]));				
			
				$e = $e + 1;
			}
					
			$TipoTrabajo = strip_tags(utf8_decode($_POST['TipoTrabajo']));
			$IdTrabajo = strip_tags(utf8_decode($_POST['IdTrabajo']));

			// ORDEN DE TRABAJO NUEVA O ALTERADA DE UNA VIEJA
			if ($TipoTrabajo == 1)
			{
				$Id_Imprenta = $IdTrabajo;
				$Id_Banner = 0;
				$Id_Impresion = 0;
			}
			else if ($TipoTrabajo == 2)
			{
				$Id_Imprenta = 0;
				$Id_Banner = $IdTrabajo;
				$Id_Impresion = 0;
			}
			// ORDEN DE TRABAJO VIEJA OSIN ALTERAR DE UNA VIEJA
			else if ($TipoTrabajo == 3)
			{
				$Id_Imprenta = 0;
				$Id_Banner = 0;
				$Id_Impresion = $IdTrabajo;
			}		
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Orden de Trabajo Agregado";
			$Tipo = "15";

			$stmt = $db->prepare("INSERT INTO orden_trabajo (id_cotizacion,id_imprenta,id_banner,id_impresion,id_usuario,id_estado,porcentaje_realizado,fecha_entrega,fecha_creado)
			VALUES (?,?,?,?,?,1,0,?,NOW())");
			$c = 1;
			$stmt->bindParam($c,$NumeroCotizacion,PDO::PARAM_INT);			
			$c++;
			$stmt->bindParam($c,$Id_Imprenta,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Banner,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Impresion,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$UsuarioAsignado1,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Fecha_Entrega,PDO::PARAM_STR,255);
			
			$Insertado = $stmt->execute();
			

			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Orden_Trabajo");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Orden_Trabajo = $results[0]["Id_Orden_Trabajo"];	

			$ua = 0;
			
			while ($ua < 3)
			{
				if (($ua == 0) and ($UsuarioAsignado1 != ""))
				{
					$UsuarioAsignado = $UsuarioAsignado1;
					$stmt = $db->prepare("INSERT INTO orden_trabajo_asignar (id_orden_trabajo,id_usuario,arte,estatus_arte,impresion,estatus_impresion,acabado,estatus_acabado,detalle,estatus_detalle,fecha_asignado) VALUES (?,?,1,1,0,0,0,0,0,0,NOW())");									

					$c = 1;
					$stmt->bindParam($c,$Id_Orden_Trabajo,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$UsuarioAsignado,PDO::PARAM_INT);				
				
					$Insertado3 = $stmt->execute();	
				}
				if (($ua == 1) and ($UsuarioAsignado2 != ""))
				{
					$UsuarioAsignado = $UsuarioAsignado2;
					$stmt = $db->prepare("INSERT INTO orden_trabajo_asignar (id_orden_trabajo,id_usuario,arte,estatus_arte,impresion,estatus_impresion,acabado,estatus_acabado,detalle,estatus_detalle,fecha_asignado) VALUES (?,?,0,0,1,1,0,0,0,0,NOW())");						
				
					$c = 1;
					$stmt->bindParam($c,$Id_Orden_Trabajo,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$UsuarioAsignado,PDO::PARAM_INT);				
				
					$Insertado3 = $stmt->execute();					
				}
				
				if (($ua == 2) and ($UsuarioAsignado3 != ""))
				{
					$UsuarioAsignado = $UsuarioAsignado3;
					$stmt = $db->prepare("INSERT INTO orden_trabajo_asignar (id_orden_trabajo,id_usuario,arte,estatus_arte,impresion,estatus_impresion,acabado,estatus_acabado,detalle,estatus_detalle,fecha_asignado) VALUES (?,?,0,0,0,0,1,1,0,0,NOW())");	
				
					$c = 1;
					$stmt->bindParam($c,$Id_Orden_Trabajo,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$UsuarioAsignado,PDO::PARAM_INT);				
				
					$Insertado3 = $stmt->execute();					
				}
				/*
				if ($ua == 3)
				{
					$UsuarioAsignado = $UsuarioAsignado4;
					$stmt = $db->prepare("INSERT INTO orden_trabajo_asignar (id_orden_trabajo,id_usuario,arte,estatus_arte,impresion,estatus_impresion,acabado,estatus_acabado,detalle,estatus_detalle,fecha_asignado) VALUES (?,?,0,0,0,0,0,0,1,1,NOW())");	
				}*/				


			
				$ua++;
			}
						
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
				
			$stmt = $db->prepare("INSERT INTO historial_orden_trabajo (id_orden_trabajo,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$Id_Orden_Trabajo,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();			
				
			$stmt = $db->prepare("UPDATE cotizaciones SET id_estatus = 2 WHERE id_cotizaciones = ?");
			$c = 1;
			$stmt->bindParam($c,$NumeroCotizacion,PDO::PARAM_INT);
			
			$Actualizado = $stmt->execute();					
				
			$stmt->closeCursor();

		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		

		if (($Insertado === true) and ($Insertado1 === true) and ($Insertado2 === true) and ($Actualizado === true))
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
	

	if($_GET['action'] == 'Listar_Ordenes_Trabajos')
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
			array( 'db' => 'id_orden_trabajo', 'dt' => 0 ),
			array( 'db' => 'id_orden_trabajo',  'dt' => 1 ),
			array( 'db' => 'id_cotizacion',   'dt' => 2 ),
			array( 'db' => 'cantidad',   'dt' => 3 ),
			array( 'db' => 'Descripcion_Trabajo',   'dt' => 4 ),
			array( 'db' => 'descripcion_estatus',   'dt' => 5 ),
			array( 'db' => 'descripcion_estatus',   'dt' => 6 ),
			array( 'db' => 'descripcion_estatus',   'dt' => 7 ),
			array( 'db' => 'porcentaje_realizado',   'dt' => 8 ),
			array( 'db' => 'fecha_creado',   'dt' => 9 ),		
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
			{
				$Sql1 = "(SELECT id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_imprenta IS NOT NULL,descripcion_imprenta,'Trabajo de Imprenta') AS Descripcion_Trabajo,  descripcion_estatus, porcentaje_realizado, ot.fecha_creado,
				IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = ot.id_cotizacion) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = ot.id_cotizacion)) AS monto_abonado
				FROM orden_trabajo ot
				INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
				INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
				INNER JOIN imprenta i ON (ot.id_imprenta = i.id_imprenta)
				AND (cp.id_imprenta = i.id_imprenta)
				INNER JOIN tipo_estatus te ON(te.id_estatus = ot.id_estado))
				UNION
				(SELECT id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_banner IS NOT NULL,descripcion_banner,'Trabajo de Banner') AS Descripcion_Trabajo, descripcion_estatus, porcentaje_realizado, ot.fecha_creado,
				IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = ot.id_cotizacion) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = ot.id_cotizacion)) AS monto_abonado
				FROM orden_trabajo ot
				INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
				INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
				INNER JOIN banner b ON (ot.id_banner = b.id_banner)
				AND (cp.id_banner = b.id_banner)
				INNER JOIN tipo_estatus te ON(te.id_estatus = ot.id_estado))							
				UNION
				(SELECT id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_impresion IS NOT NULL,descripcion_impresion,'Trabajo de IMPRESION') AS Descripcion_Trabajo, descripcion_estatus, porcentaje_realizado, ot.fecha_creado,
				IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = ot.id_cotizacion) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = ot.id_cotizacion)) AS monto_abonado
				FROM orden_trabajo ot
				INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
				INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
				INNER JOIN impresion im ON (ot.id_impresion = im.id_impresion)
				AND (cp.id_impresion = im.id_impresion)
				INNER JOIN tipo_estatus te ON(te.id_estatus = ot.id_estado))";
				
				$Sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT(id_orden_trabajo),id_cotizacion,cantidad,Descripcion_Trabajo,descripcion_estatus,porcentaje_realizado,fecha_creado,monto_abonado
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
				$id_usuario = base64_decode($_SESSION['id_usuario']);
		
				$stmt = $db->prepare("(SELECT ot.id_orden_trabajo, ot.id_cotizacion,  cantidad,  IF(descripcion_imprenta IS NOT NULL,descripcion_imprenta,'Trabajo de Imprenta') AS Descripcion_Trabajo, IF(estatus_arte = 1,'ASIGNACION DE ARTE',IF(estatus_impresion = 1,'ASIGNACION DE IMPRESION',IF(estatus_acabado = 1,'ASIGNACION DE ACABADO', 'Sin ASIGNACION') ) ) AS tipo_asignacion, porcentaje_realizado,  ot.fecha_creado,
				IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = ot.id_cotizacion) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = ot.id_cotizacion)) AS monto_abonado
				FROM orden_trabajo ot
				INNER JOIN orden_trabajo_asignar ota ON (ot.id_orden_trabajo = ota.id_orden_trabajo)
				INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
				INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
				INNER JOIN imprenta i ON (ot.id_imprenta = i.id_imprenta)
				AND (cp.id_imprenta = i.id_imprenta)
				WHERE ota.id_usuario = ? AND (estatus_arte = 1 OR estatus_impresion = 1 OR estatus_acabado = 1))
				UNION
				(SELECT ot.id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_banner IS NOT NULL,descripcion_banner,'Trabajo de Banner') AS Descripcion_Trabajo, IF(estatus_arte = 1,'ASIGNACION DE ARTE',IF(estatus_impresion = 1,'ASIGNACION DE IMPRESION',IF(estatus_acabado = 1,'ASIGNACION DE ACABADO', 'Sin ASIGNACION') ) ) AS tipo_asignacion, porcentaje_realizado, ot.fecha_creado,
				IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = ot.id_cotizacion) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = ot.id_cotizacion)) AS monto_abonado
				FROM orden_trabajo ot
				INNER JOIN orden_trabajo_asignar ota ON (ot.id_orden_trabajo = ota.id_orden_trabajo)
				INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
				INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
				INNER JOIN banner b ON (ot.id_banner = b.id_banner)
				AND (cp.id_banner = b.id_banner)
				WHERE ota.id_usuario = ? AND (estatus_arte = 1 OR estatus_impresion = 1 OR estatus_acabado = 1))
				UNION
				(SELECT ot.id_orden_trabajo, ot.id_cotizacion, cantidad, IF(descripcion_impresion IS NOT NULL,descripcion_impresion,'Trabajo de IMPRESION') AS Descripcion_Trabajo, IF(estatus_arte = 1,'ASIGNACION DE ARTE',IF(estatus_impresion = 1,'ASIGNACION DE IMPRESION',IF(estatus_acabado = 1,'ASIGNACION DE ACABADO', 'Sin ASIGNACION') ) ) AS tipo_asignacion, porcentaje_realizado, ot.fecha_creado,
				IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = ot.id_cotizacion) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = ot.id_cotizacion)) AS monto_abonado
				FROM orden_trabajo ot
				INNER JOIN orden_trabajo_asignar ota ON (ot.id_orden_trabajo = ota.id_orden_trabajo)
				INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
				INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
				INNER JOIN impresion im ON (ot.id_impresion = im.id_impresion)
				AND (cp.id_impresion = im.id_impresion)
				WHERE ota.id_usuario = ? AND (estatus_arte = 1 OR estatus_impresion = 1 OR estatus_acabado = 1))");
				
				$Sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT(id_orden_trabajo),id_cotizacion,cantidad,Descripcion_Trabajo,descripcion_estatus,porcentaje_realizado,fecha_creado,monto_abonado 
				FROM (".$Sql1.") AS T ".$where." ".$order." ".$limit;	

				$stmt = $db->prepare($Sql);	

				if ( is_array( $bindings ) ) {
					for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
						$binding = $bindings[$i];
										
						$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
					}
				}				
				
				$c = 1;
				$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);			
				$c++;
				$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);			
			}
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			
			$stmt = $db->prepare("SELECT FOUND_ROWS()");
			
			$stmt->execute();
			$resFilterLength = $stmt->fetchColumn (0);			
			if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
			{			
				$stmt = $db->prepare("SELECT SUM(Total) AS Total_Registro
				FROM(		
				(SELECT COUNT(DISTINCT id_orden_trabajo) AS Total
					FROM orden_trabajo ot
					INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
					INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
					INNER JOIN imprenta i ON (ot.id_imprenta = i.id_imprenta)
					AND (cp.id_imprenta = i.id_imprenta)
					INNER JOIN tipo_estatus te ON(te.id_estatus = ot.id_estado))
				UNION
				(SELECT COUNT(DISTINCT id_orden_trabajo) AS Total
					FROM orden_trabajo ot
					INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
					INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
					INNER JOIN banner b ON (ot.id_banner = b.id_banner)
					AND (cp.id_banner = b.id_banner)
					INNER JOIN tipo_estatus te ON(te.id_estatus = ot.id_estado))
				UNION
				(SELECT COUNT(DISTINCT id_orden_trabajo) AS Total
					FROM orden_trabajo ot
					INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
					INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
					INNER JOIN impresion im ON (ot.id_impresion = im.id_impresion)
					AND (cp.id_impresion = im.id_impresion)
					INNER JOIN tipo_estatus te ON(te.id_estatus = ot.id_estado))				
				) AS T");
			}
			else
			{
				$stmt = $db->prepare("SELECT SUM(Total) AS Total_Registro
				FROM(		
				(SELECT COUNT(DISTINCT id_orden_trabajo) AS Total
					FROM orden_trabajo ot
				INNER JOIN orden_trabajo_asignar ota ON (ot.id_orden_trabajo = ota.id_orden_trabajo)
				INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
				INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
				INNER JOIN imprenta i ON (ot.id_imprenta = i.id_imprenta)
				AND (cp.id_imprenta = i.id_imprenta)
				WHERE ota.id_usuario = ? AND (estatus_arte = 1 OR estatus_impresion = 1 OR estatus_acabado = 1))
				UNION
				(SELECT COUNT(DISTINCT id_orden_trabajo) AS Total
					FROM orden_trabajo ot
					INNER JOIN orden_trabajo_asignar ota ON (ot.id_orden_trabajo = ota.id_orden_trabajo)
					INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
					INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
					INNER JOIN banner b ON (ot.id_banner = b.id_banner)
					AND (cp.id_banner = b.id_banner)
					WHERE ota.id_usuario = ? AND (estatus_arte = 1 OR estatus_impresion = 1 OR estatus_acabado = 1))
				UNION
				(SELECT COUNT(DISTINCT id_orden_trabajo) AS Total
					FROM orden_trabajo ot
					INNER JOIN orden_trabajo_asignar ota ON (ot.id_orden_trabajo = ota.id_orden_trabajo)
					INNER JOIN cotizaciones c ON (ot.id_cotizacion = c.id_cotizaciones)
					INNER JOIN cotizacion_producto cp ON (cp.id_cotizacion = c.id_cotizaciones)
					INNER JOIN impresion im ON (ot.id_impresion = im.id_impresion)
					AND (cp.id_impresion = im.id_impresion)
					WHERE ota.id_usuario = ? AND (estatus_arte = 1 OR estatus_impresion = 1 OR estatus_acabado = 1))				
				) AS T");
				
				
				$c = 1;
				$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);			
				$c++;
				$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);				
			}
			
				
			$stmt->execute();			
			$recordsTotal = $stmt->fetchColumn (0);	
			
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
			
		/*$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable"  style="table-layout: fixed;word-wrap:break-word;"><thead><tr>';
		//$html .= '<table cellpadding="0" cellspacing="0" border="0" class="sTable"><thead><tr>';		

		$html .= '<th style="width:2%"></th>
				<th style="width:8%">N&deg; de Orden de Trabajo
				<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
				<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
				<th style="width:5%">N&deg; de Cotizaci&oacute;n:</th>
				<th style="width:22%">Descripci&oacute;n del Trabajo</th>
				<th style="width:8%">Usuario Arte</th>
				<th style="width:8%">Usuario Impresi&oacute;n</th>
				<th style="width:8%">Usuario Acabado</th>			
				<th style="width:10%">Estatus</th>
				<th style="width:10%">Porcentaje de Progreso</th>';
				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))					
		$html .= '<th style="width:13%">Opciones</th>';	

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
					$stmt = $db->prepare("SELECT * FROM orden_trabajo_asignar ota
					INNER JOIN usuarios u ON (u.id_usuario = ota.id_usuario)
					INNER JOIN tipo_estatus_asignado tea ON (ota.estatus_arte = tea.id_estatus)
					OR (ota.estatus_impresion = tea.id_estatus) OR (ota.estatus_acabado = tea.id_estatus)
					OR (ota.estatus_detalle = tea.id_estatus)
					WHERE id_orden_trabajo = ?");
				
					$p = 1;
					$stmt->bindParam($p,$row['id_orden_trabajo'],PDO::PARAM_INT);				
					$stmt->execute();
					$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$nfilas = $stmt->rowCount();
					$stmt->closeCursor();
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}				
				
				$id_usuario_arte = "";
				$usuario_arte = "";				
				$id_usuario_impresion = "";				
				$usuario_impresion = "";
				$id_usuario_acabado = "";				
				$usuario_acabado = "";
				$id_estatus_arte = "";
				$id_estatus_impresion = "";				
				$id_estatus_acabado = "";
				$estatus_arte = "";
				$estatus_impresion = "";				
				$estatus_acabado = "";				
				$id_estatus_detalle = "";				
				$estatus_detalle = "";
				
				foreach ($rows1 as $row1)
				{				
					if ($row1['arte'] == 1)
					{
						$id_usuario_arte = $row1['id_usuario'];
						$usuario_arte = $row1['usuario'];
						$id_estatus_arte = $row1['estatus_arte'];
						$estatus_arte = $row1['descripcion_estatus'];
					}
					
					if ($row1['impresion'] == 1)
					{
						$id_usuario_impresion = $row1['id_usuario'];
						$usuario_impresion = $row1['usuario'];
						$id_estatus_impresion = $row1['estatus_impresion'];
						$estatus_impresion = $row1['descripcion_estatus'];
					}
					
					if ($row1['acabado'] == 1)
					{
						$id_usuario_acabado = $row1['id_usuario'];
						$usuario_acabado = $row1['usuario'];
						$id_estatus_acabado = $row1['estatus_acabado'];
						$estatus_acabado = $row1['descripcion_estatus'];						
					}
					
					//if ($row1['detalle'] == 1)
					//{
					//	$id_usuario_detalle = $row1['id_usuario'];
					//	$usuario_detalle = $row1['usuario'];
					//	$id_estatus_detalle = $row1['estatus_detalle'];
					//	$estatus_detalle = $row1['descripcion_estatus'];						
					//}					
					
				}
				
				$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
						<td>'.$c.'</td>
						<td align="center">'.utf8_encode($row['id_orden_trabajo']).'<input type="hidden" id="hidNoOrdenTrabajo'.$c.'" name="hidNoOrdenTrabajo[]" value="'.utf8_encode($row['id_orden_trabajo']).'" /></td>
						<td align="center">'.utf8_encode($row['id_cotizacion']).'<input type="hidden" id="hidNoCotizacion'.$c.'" name="hidNoCotizacion[]" value="'.utf8_encode($row['id_cotizacion']).'" /></td>						
						<td>'.utf8_encode($row['Descripcion_Trabajo']).'<input type="hidden" id="hidDescripcionTrabajo'.$c.'" name="hidDescripcionTrabajo[]" value="'.utf8_encode($row['Descripcion_Trabajo']).'" /></td>';
				if($usuario_arte != "")
				$html .='<td>'.utf8_encode($usuario_arte." / ".$estatus_arte).'<input type="hidden" id="hidUsuario1'.$c.'" name="hidUsuario1[]" value="'.utf8_encode($usuario_arte).'" /><input type="hidden" id="hidIdUsuario1'.$c.'" name="hidIdUsuario1[]" value="'.md5($id_usuario_arte).'" />
						<input type="hidden" id="hidIdEstatusOrden1'.$c.'" name="hidIdEstatusOrden1[]" value="'.$id_estatus_arte.'" /><input type="hidden" id="hidEstatusOrden1'.$c.'" name="hidEstatusOrden1[]" value="'.$estatus_arte.'" /></td>';					
				else
				$html .='<td>No Asignado<input type="hidden" id="hidUsuario1'.$c.'" name="hidUsuario1[]" value="" /><input type="hidden" id="hidIdUsuario1'.$c.'" name="hidIdUsuario1[]" value="" />
						<input type="hidden" id="hidIdEstatusOrden1'.$c.'" name="hidIdEstatusOrden1[]" value="" /><input type="hidden" id="hidEstatusOrden1'.$c.'" name="hidEstatusOrden1[]" value="" /></td>';						
				if($usuario_impresion != "")				
				$html .='<td>'.utf8_encode($usuario_impresion." / ".$estatus_impresion).'<input type="hidden" id="hidUsuario2'.$c.'" name="hidUsuario2[]" value="'.utf8_encode($usuario_impresion).'" /><input type="hidden" id="hidIdUsuario2'.$c.'" name="hidIdUsuario2[]" value="'.md5($id_usuario_impresion).'" />
						<input type="hidden" id="hidIdEstatusOrden2'.$c.'" name="hidIdEstatusOrden2[]" value="'.$id_estatus_impresion.'" /><input type="hidden" id="hidEstatusOrden2'.$c.'" name="hidEstatusOrden2[]" value="'.$estatus_impresion.'" /></td>';					
				else
				$html .='<td>No Asignado<input type="hidden" id="hidUsuario2'.$c.'" name="hidUsuario2[]" value="" /><input type="hidden" id="hidIdUsuario2'.$c.'" name="hidIdUsuario2[]" value="" />
						<input type="hidden" id="hidIdEstatusOrden2'.$c.'" name="hidIdEstatusOrden2[]" value="" /><input type="hidden" id="hidEstatusOrden2'.$c.'" name="hidEstatusOrden2[]" value="" /></td>';					
				if($usuario_acabado != "")	
				$html .='<td>'.utf8_encode($usuario_acabado." / ".$estatus_acabado).'<input type="hidden" id="hidUsuario3'.$c.'" name="hidUsuario3[]" value="'.utf8_encode($usuario_acabado).'" /><input type="hidden" id="hidIdUsuario3'.$c.'" name="hidIdUsuario3[]" value="'.md5($id_usuario_acabado).'" />
						<input type="hidden" id="hidIdEstatusOrden3'.$c.'" name="hidIdEstatusOrden3[]" value="'.$id_estatus_acabado.'" /><input type="hidden" id="hidEstatusOrden3'.$c.'" name="hidEstatusOrden3[]" value="'.$estatus_acabado.'" /></td>';						
				else
				$html .='<td>No Asignado<input type="hidden" id="hidUsuario3'.$c.'" name="hidUsuario3[]" value="" /><input type="hidden" id="hidIdUsuario3'.$c.'" name="hidIdUsuario3[]" value="" />
						<input type="hidden" id="hidIdEstatusOrden3'.$c.'" name="hidIdEstatusOrden3[]" value="" /><input type="hidden" id="hidEstatusOrden3'.$c.'" name="hidEstatusOrden3[]" value="" /></td>';						
				
				//<td>'.utf8_encode($usuario_detalle." / ".$estatus_detalle).'<input type="hidden" id="hidUsuario4'.$c.'" name="hidUsuario4[]" value="'.utf8_encode($usuario_detalle).'" /><input type="hidden" id="hidIdUsuario4'.$c.'" name="hidIdUsuario4[]" value="'.md5($id_usuario_detalle).'" />
				//		<input type="hidden" id="hidIdEstatusOrden4'.$c.'" name="hidIdEstatusOrden4[]" value="'.$id_estatus_detalle.'" /><input type="hidden" id="hidEstatusOrden4'.$c.'" name="hidEstatusOrden4[]" value="'.$estatus_detalle.'" /></td>						
				$html .='<td>'.utf8_encode($row['descripcion_estatus']).'<input type="hidden" id="hidEstatus'.$c.'" name="hidEstatus[]" value="'.utf8_encode($row['descripcion_estatus']).'" /></td>';
				
				$html .='<td><div class="contentProgress"><div class="barB tipS" id="bar'.$c.'" title="'.utf8_encode($row['porcentaje_realizado']).'%" style="width: '.utf8_encode($row['porcentaje_realizado']).'%" ></div></div>
							<ul class="ruler">
								<li>0</li>
								<li class="textC">50%</li>
								<li class="textR">100%</li>
							</ul>
						<input type="hidden" id="hidPorcentaje'.$c.'" name="hidPorcentaje[]" value="'.utf8_encode($row['porcentaje_realizado']).'" />';
				
				//$html .='<td>'.utf8_encode($row['porcentaje_realizado']).'<input type="hidden" id="hidPorcentaje'.$c.'" name="hidPorcentaje[]" value="'.utf8_encode($row['porcentaje_realizado']).'" /></td>';
				
				$html .='</td><td>';				
				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{
				}
				$html .='<a href="javascript:void(0);" title="Subir Arte" class="smallButton" style="margin: 5px;" onclick="Subir_Arte(\''.utf8_encode(md5($row['id_cotizacion'])).'\');"><img src="public/images/icons/light/transfer.png" alt="" class="icon" /><span></span></a>';
				
				if ($row['porcentaje_realizado'] < 100)
				$html .='<a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Orden_Trabajo('.$c.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';

				$html .='<a href="javascript:void(0);" title="Imprimir" class="smallButton" style="margin: 5px;" onclick="Imprimir_Orden_Trabajo(\''.utf8_encode(md5($row['id_orden_trabajo'])).'\');"><img src="public/images/icons/color/blue-document-pdf-text.png" alt="" class="icon" /><span></span></a>';

				$html .='<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_orden_trabajo'])).'" /></td>
				</tr>';					
				

				//else if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) and ($row['porcentaje_realizado'] == 100))
				//$html .='<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Imprimir_Orden_Trabajo('.$c.');"><img src="public/images/icons/color/blue-document-pdf-text.pngg" alt="" class="icon" /><span></span></a>
				//		<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_orden_trabajo'])).'" /></td>					
				//	</tr>';
					
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
				
				try
				{		
					$stmt = $db->prepare("SELECT * FROM orden_trabajo_asignar ota
					INNER JOIN usuarios u ON (u.id_usuario = ota.id_usuario)
					INNER JOIN tipo_estatus_asignado tea ON (ota.estatus_arte = tea.id_estatus)
					OR (ota.estatus_impresion = tea.id_estatus) OR (ota.estatus_acabado = tea.id_estatus)
					OR (ota.estatus_detalle = tea.id_estatus)
					WHERE id_orden_trabajo = ?");
				
					$p = 1;
					$stmt->bindParam($p,$row['id_orden_trabajo'],PDO::PARAM_INT);				
					$stmt->execute();
					$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$nfilas = $stmt->rowCount();
					$stmt->closeCursor();
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}				
				
				$id_usuario_arte = "";
				$usuario_arte = "";				
				$id_usuario_impresion = "";				
				$usuario_impresion = "";
				$id_usuario_acabado = "";				
				$usuario_acabado = "";
				$id_estatus_arte = "";
				$id_estatus_impresion = "";				
				$id_estatus_acabado = "";
				$estatus_arte = "";
				$estatus_impresion = "";				
				$estatus_acabado = "";				
				$id_estatus_detalle = "";				
				$estatus_detalle = "";
				
				foreach ($rows1 as $row1)
				{				
					if ($row1['arte'] == 1)
					{
						$id_usuario_arte = $row1['id_usuario'];
						$usuario_arte = $row1['usuario'];
						$id_estatus_arte = $row1['estatus_arte'];
						$estatus_arte = $row1['descripcion_estatus'];
					}
					
					if ($row1['impresion'] == 1)
					{
						$id_usuario_impresion = $row1['id_usuario'];
						$usuario_impresion = $row1['usuario'];
						$id_estatus_impresion = $row1['estatus_impresion'];
						$estatus_impresion = $row1['descripcion_estatus'];
					}
					
					if ($row1['acabado'] == 1)
					{
						$id_usuario_acabado = $row1['id_usuario'];
						$usuario_acabado = $row1['usuario'];
						$id_estatus_acabado = $row1['estatus_acabado'];
						$estatus_acabado = $row1['descripcion_estatus'];						
					}
					
					/*if ($row1['detalle'] == 1)
					{
						$id_usuario_detalle = $row1['id_usuario'];
						$usuario_detalle = $row1['usuario'];
						$id_estatus_detalle = $row1['estatus_detalle'];
						$estatus_detalle = $row1['descripcion_estatus'];						
					}*/					
					
				}				
				
				$Data[$f][$c] = $f+1;
				$c++;
				$Data[$f][$c] = utf8_encode($row['id_orden_trabajo']).'<input type="hidden" id="hidNoOrdenTrabajo'.$f.'" name="hidNoOrdenTrabajo[]" value="'.utf8_encode($row['id_orden_trabajo']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['id_cotizacion']).'<input type="hidden" id="hidNoCotizacion'.$f.'" name="hidNoCotizacion[]" value="'.utf8_encode($row['id_cotizacion']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['Descripcion_Trabajo']).'<input type="hidden" id="hidDescripcionTrabajo'.$f.'" name="hidDescripcionTrabajo[]" value="'.utf8_encode($row['Descripcion_Trabajo']).'" />';
				$c++;
				if($usuario_arte != "")				
				$Data[$f][$c] = utf8_encode($usuario_arte." / ".$estatus_arte).'<input type="hidden" id="hidUsuario1'.$f.'" name="hidUsuario1[]" value="'.utf8_encode($usuario_arte).'" /><input type="hidden" id="hidIdUsuario1'.$f.'" name="hidIdUsuario1[]" value="'.md5($id_usuario_arte).'" />
						<input type="hidden" id="hidIdEstatusOrden1'.$f.'" name="hidIdEstatusOrden1[]" value="'.$id_estatus_arte.'" /><input type="hidden" id="hidEstatusOrden1'.$f.'" name="hidEstatusOrden1[]" value="'.$estatus_arte.'" />';
				else
				$Data[$f][$c] = 'No Asignado<input type="hidden" id="hidUsuario1'.$f.'" name="hidUsuario1[]" value="" /><input type="hidden" id="hidIdUsuario1'.$f.'" name="hidIdUsuario1[]" value="" />
						<input type="hidden" id="hidIdEstatusOrden1'.$f.'" name="hidIdEstatusOrden1[]" value="" /><input type="hidden" id="hidEstatusOrden1'.$f.'" name="hidEstatusOrden1[]" value="" />';					
				$c++;
				
				if($usuario_impresion != "")
				$Data[$f][$c] = utf8_encode($usuario_impresion." / ".$estatus_impresion).'<input type="hidden" id="hidUsuario2'.$f.'" name="hidUsuario2[]" value="'.utf8_encode($usuario_impresion).'" /><input type="hidden" id="hidIdUsuario2'.$f.'" name="hidIdUsuario2[]" value="'.md5($id_usuario_impresion).'" />
						<input type="hidden" id="hidIdEstatusOrden2'.$f.'" name="hidIdEstatusOrden2[]" value="'.$id_estatus_impresion.'" /><input type="hidden" id="hidEstatusOrden2'.$f.'" name="hidEstatusOrden2[]" value="'.$estatus_impresion.'" />';				
				else					
				$Data[$f][$c] = '<td>No Asignado<input type="hidden" id="hidUsuario2'.$f.'" name="hidUsuario2[]" value="" /><input type="hidden" id="hidIdUsuario2'.$f.'" name="hidIdUsuario2[]" value="" />
						<input type="hidden" id="hidIdEstatusOrden2'.$f.'" name="hidIdEstatusOrden2[]" value="" /><input type="hidden" id="hidEstatusOrden2'.$f.'" name="hidEstatusOrden2[]" value="" />';
				$c++;
				
				if($usuario_acabado != "")				
				$Data[$f][$c] = utf8_encode($usuario_acabado." / ".$estatus_acabado).'<input type="hidden" id="hidUsuario3'.$f.'" name="hidUsuario3[]" value="'.utf8_encode($usuario_acabado).'" /><input type="hidden" id="hidIdUsuario3'.$f.'" name="hidIdUsuario3[]" value="'.md5($id_usuario_acabado).'" />
						<input type="hidden" id="hidIdEstatusOrden3'.$f.'" name="hidIdEstatusOrden3[]" value="'.$id_estatus_acabado.'" /><input type="hidden" id="hidEstatusOrden3'.$f.'" name="hidEstatusOrden3[]" value="'.$estatus_acabado.'" />';
				else
				$Data[$f][$c] = '<td>No Asignado<input type="hidden" id="hidUsuario3'.$f.'" name="hidUsuario3[]" value="" /><input type="hidden" id="hidIdUsuario3'.$f.'" name="hidIdUsuario3[]" value="" />
						<input type="hidden" id="hidIdEstatusOrden3'.$f.'" name="hidIdEstatusOrden3[]" value="" /><input type="hidden" id="hidEstatusOrden3'.$f.'" name="hidEstatusOrden3[]" value="" /></td>';					
				$c++;
				
				$Data[$f][$c] = utf8_encode($row['descripcion_estatus']).'<input type="hidden" id="hidEstatus'.$f.'" name="hidEstatus[]" value="'.utf8_encode($row['descripcion_estatus']).'" />';
				$c++;
				$Data[$f][$c] = '<div class="contentProgress"><div class="barB tipS" id="bar'.$f.'" title="'.utf8_encode($row['porcentaje_realizado']).'%" style="width: '.utf8_encode($row['porcentaje_realizado']).'%" ></div></div>
							<ul class="ruler">
								<li>0</li>
								<li class="textC">50%</li>
								<li class="textR">100%</li>
							</ul>
						<input type="hidden" id="hidPorcentaje'.$f.'" name="hidPorcentaje[]" value="'.utf8_encode($row['porcentaje_realizado']).'" />';
				$c++;
				
				$Data[$f][$c] = "";
				$Data[$f][$c] .= '<a href="javascript:void(0);" title="Subir Arte" class="smallButton" style="margin: 5px;" onclick="Subir_Arte(\''.utf8_encode(md5($row['id_cotizacion'])).'\');"><img src="public/images/icons/light/transfer.png" alt="" class="icon" /><span></span></a>';				
				if ($row['porcentaje_realizado'] < 100)
				$Data[$f][$c] .= '<a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Orden_Trabajo('.$f.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';				
				$Data[$f][$c] .= '<a href="javascript:void(0);" title="Imprimir" class="smallButton" style="margin: 5px;" onclick="Imprimir_Orden_Trabajo(\''.utf8_encode(md5($row['id_orden_trabajo'])).'\');"><img src="public/images/icons/color/blue-document-pdf-text.png" alt="" class="icon" /><span></span></a>';				
				$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_orden_trabajo'])).'" />';				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
				{			
					if(number_format($row['monto_abonado'],2,'.','') > 0)
					$Data[$f][$c] .='<a href="javascript:void(0);" title="Imprimir &Uacute;timo Recibo de Abono" class="smallButton" style="margin: 5px;" onclick="Imprimir_Ultimo_Recibo_Abono('.$f.')"><i class="fa fa-file-text-o"></i><span></span></a>';					
					$Data[$f][$c] .='<input type="hidden" id="hdnIdCamposO_'.$f.'" name="hdnIdCamposO[]" value="'.utf8_encode(md5($row['id_cotizacion'])).'" />';				
				}
				$f = $f + 1;
			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;		
		echo json_encode($ResultSet);		
		
	}

	if($_GET['action'] == 'Buscar_Cotizacion_Orden')
	{
		session_start();
		$idCotizacion	= strip_tags(utf8_decode($_POST['idCotizacion']));
		$DetalleCotizacion = array();
		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,descripcion_cotizacion,co.id_estatus, descripcion_estatus,monto_subtotal,monto_itbm,monto_total,
			IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones)) AS monto_abonado 
			FROM cotizaciones co INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus)
			WHERE MD5(id_cotizaciones) = ?");

			$c = 1;
			$stmt->bindParam($c,$idCotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
			//print_r($stmt->errorInfo());
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		try
		{		
					
			$Id_Cliente = $rows[0]['id_cliente'];
					
			if($rows[0]['id_tipo_cliente']==1)
			$stmt = $db->prepare("SELECT credito 
			FROM cliente_persona WHERE id_cliente = ?");
			else if($rows[0]['id_tipo_cliente']==2)
			$stmt = $db->prepare("SELECT credito
			FROM cliente_empresa  WHERE id_cliente = ?");
					
			$p = 1;
			$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_INT);
			
			$stmt->execute();
			$rowsCliente = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
					
			$Credito = $rowsCliente[0]['credito'];
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
		{
			$DetalleCotizacion[0] = $rows[0]['id_cotizaciones'];
			$DetalleCotizacion[1] = $rows[0]['descripcion_cotizacion'];				
		}
		else
		{
			if ((($rows[0]['monto_abonado']/$rows[0]['monto_total']) > 0.25) or ($Credito == 1))
			{
				$DetalleCotizacion[0] = $rows[0]['id_cotizaciones'];
				$DetalleCotizacion[1] = $rows[0]['descripcion_cotizacion'];	
			}
		}
		/*
		try
		{		
			$stmt = $db->prepare("SELECT id_cotizaciones, descripcion_cotizacion FROM cotizaciones c
			INNER JOIN abono a ON (a.id_cotizacion = c.id_cotizaciones)
			WHERE MD5(id_cotizaciones) = ? AND ((SELECT SUM(monto_abonado) FROM abono  WHERE MD5(id_cotizacion) = ?)/monto_total) >= 0.25  GROUP BY id_cotizaciones");
			
			//$stmt = $db->prepare("SELECT id_cotizaciones, descripcion_cotizacion FROM cotizaciones c
			//INNER JOIN abono a ON (a.id_cotizacion = c.id_cotizaciones) WHERE MD5(id_cotizaciones) = ?  AND (monto_abonado/monto_total) >= 0.25");			
			
			$c = 1;
			$stmt->bindParam($c,$idCotizacion,PDO::PARAM_STR,255);	
			$c++;
			$stmt->bindParam($c,$idCotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
	
		$DetalleCotizacion[0] = $rows[0]['id_cotizaciones'];
		$DetalleCotizacion[1] = $rows[0]['descripcion_cotizacion'];*/
		//echo "prueba";
		echo json_encode($DetalleCotizacion);
		
	}

	if($_GET['action'] == 'Listar_Estatus_Orden')	
	{
		session_start();
		$html = "";
				//if (base64_decode($_SESSION['id_tipo_usuario']) == 1)
				//{		
		try
		{		
			if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))		
			$stmt = $db->prepare("SELECT * FROM tipo_estatus_asignado");
			else
			$stmt = $db->prepare("SELECT * FROM tipo_estatus_asignado WHERE id_estatus IN (3)");
			
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
				$html .= "<option value='".$row['id_estatus']."'>".$row['descripcion_estatus']."</option>";
			}
		}
		
		echo $html;	
	
	
	}
	
	if($_GET['action'] == 'Actualizar_Orden_Trabajo')	
	{	
		session_start();	
		$db->beginTransaction();
		try
		{
				
			//$Porcentaje	= strip_tags(utf8_decode($_POST['Porcentaje']));
			
			$IdUsuario1	= strip_tags(utf8_decode($_POST['IdUsuario1']));
			$IdUsuario2	= strip_tags(utf8_decode($_POST['IdUsuario2']));
			$IdUsuario3	= strip_tags(utf8_decode($_POST['IdUsuario3']));
			//$IdUsuario4	= strip_tags(utf8_decode($_POST['IdUsuario4']));			
			
			$EstatusOrden1	= strip_tags(utf8_decode($_POST['EstatusOrden1']));
			$EstatusOrden2	= strip_tags(utf8_decode($_POST['EstatusOrden2']));
			$EstatusOrden3	= strip_tags(utf8_decode($_POST['EstatusOrden3']));
			//$EstatusOrden4	= strip_tags(utf8_decode($_POST['EstatusOrden4']));			

			
			$Id_Orden_Trabajo = strip_tags(utf8_decode($_POST['Id_Orden_Trabajo']));
			
			try
			{		
				$stmt = $db->prepare("Select id_orden_trabajo FROM orden_trabajo WHERE MD5(id_orden_trabajo) = ?");
				
				$c = 1;
				$stmt->bindParam($c,$Id_Orden_Trabajo,PDO::PARAM_INT);
	
				$stmt->execute();
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas = $stmt->rowCount();
				$stmt->closeCursor();
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}			
			
			$Id_OrdenTrabajo = $rows[0]['id_orden_trabajo'];
			
			$ua = 0;
			
			while ($ua < 3)
			{
				if (($ua == 0) and ($IdUsuario1 != "") and ($IdUsuario1 != 0))
				{
					//echo "prueba";
					try
					{		
						$stmt = $db->prepare("Select count(*) As Existe FROM orden_trabajo_asignar WHERE MD5(id_orden_trabajo) = ? AND MD5(id_usuario) = ? and arte = 1");
				
						$c = 1;
						$stmt->bindParam($c,$Id_Orden_Trabajo,PDO::PARAM_INT);
						$c++;
						$stmt->bindParam($c,$UsuarioAsignado,PDO::PARAM_INT);				
								
						$stmt->execute();
						$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					
					
					if ($rows[0]['Existe'] == 0)
					{					
						$UsuarioAsignado = $IdUsuario1;
						$stmt = $db->prepare("INSERT INTO orden_trabajo_asignar (id_orden_trabajo,id_usuario,arte,estatus_arte,impresion,estatus_impresion,acabado,estatus_acabado,detalle,estatus_detalle,fecha_asignado) VALUES (?,?,1,1,0,0,0,0,0,0,NOW())");									

						$c = 1;
						$stmt->bindParam($c,$Id_OrdenTrabajo,PDO::PARAM_INT);
						$c++;
						$stmt->bindParam($c,$UsuarioAsignado,PDO::PARAM_INT);				
				
						$Insertado3 = $stmt->execute();
					}
				}
				if (($ua == 1) and ($IdUsuario2 != "") and ($IdUsuario2 != 0))
				{
					//echo "prueba1";
					try
					{		
						$stmt = $db->prepare("Select count(*) As Existe FROM orden_trabajo_asignar WHERE MD5(id_orden_trabajo) = ? AND MD5(id_usuario) = ? and impresion = 1");
				
						$c = 1;
						$stmt->bindParam($c,$Id_Orden_Trabajo,PDO::PARAM_INT);
						$c++;
						$stmt->bindParam($c,$UsuarioAsignado,PDO::PARAM_INT);				
								
						$stmt->execute();
						$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					
					
					if ($rows[0]['Existe'] == 0)
					{
						$UsuarioAsignado = $IdUsuario2;
						$stmt = $db->prepare("INSERT INTO orden_trabajo_asignar (id_orden_trabajo,id_usuario,arte,estatus_arte,impresion,estatus_impresion,acabado,estatus_acabado,detalle,estatus_detalle,fecha_asignado) VALUES (?,?,0,0,1,1,0,0,0,0,NOW())");						
				
						$c = 1;
						$stmt->bindParam($c,$Id_OrdenTrabajo,PDO::PARAM_INT);
						$c++;
						$stmt->bindParam($c,$UsuarioAsignado,PDO::PARAM_INT);				
				
						$Insertado3 = $stmt->execute();
					}
				}
				
				if (($ua == 2) and ($IdUsuario3 != "") and ($IdUsuario3 != 0))
				{
					//echo "prueba2";
					try
					{		
						$stmt = $db->prepare("Select count(*) As Existe FROM orden_trabajo_asignar WHERE MD5(id_orden_trabajo) = ? AND MD5(id_usuario) = ? and acabado = 1");
				
						$c = 1;
						$stmt->bindParam($c,$Id_Orden_Trabajo,PDO::PARAM_INT);
						$c++;
						$stmt->bindParam($c,$UsuarioAsignado,PDO::PARAM_INT);				
								
						$stmt->execute();
						$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					
					
					if ($rows[0]['Existe'] == 0)
					{					
						$UsuarioAsignado = $IdUsuario3;
						$stmt = $db->prepare("INSERT INTO orden_trabajo_asignar (id_orden_trabajo,id_usuario,arte,estatus_arte,impresion,estatus_impresion,acabado,estatus_acabado,detalle,estatus_detalle,fecha_asignado) VALUES (?,?,0,0,0,0,1,1,0,0,NOW())");	
				
						$c = 1;
						$stmt->bindParam($c,$Id_OrdenTrabajo,PDO::PARAM_INT);
						$c++;
						$stmt->bindParam($c,$UsuarioAsignado,PDO::PARAM_INT);				
				
						$Insertado3 = $stmt->execute();
					}
				}
				/*
				if ($ua == 3)
				{
					$UsuarioAsignado = $UsuarioAsignado4;
					$stmt = $db->prepare("INSERT INTO orden_trabajo_asignar (id_orden_trabajo,id_usuario,arte,estatus_arte,impresion,estatus_impresion,acabado,estatus_acabado,detalle,estatus_detalle,fecha_asignado) VALUES (?,?,0,0,0,0,0,0,1,1,NOW())");	
				}*/				


			
				$ua++;
			}			
			
			$c = 0;
			$Estapa_Terminada = 0;
			while ($c < 4)
			{
				if ($c == 0)
				{
					$IdUsuario = $IdUsuario1;
					$EstatusOrden = $EstatusOrden1;
					
					$stmt = $db->prepare("UPDATE orden_trabajo_asignar SET estatus_arte = ?
					WHERE MD5(id_orden_trabajo) = ? AND MD5(id_usuario) = ? AND arte = 1");						
					
					/*$stmt = $db->prepare("SELECT * FROM orden_trabajo_asignar ota
					INNER JOIN usuarios u ON (u.id_usuario = ota.id_usuario)
					WHERE id_orden_trabajo = ? AND ota.id_usuario = ? AND estatus_arte = ? AND arte = 1");*/	

					if ($EstatusOrden == 4)					
					$Estapa_Terminada = $Estapa_Terminada + 1;
				}
				
				if ($c == 1)
				{
					$IdUsuario = $IdUsuario2;
					$EstatusOrden = $EstatusOrden2;
					
					$stmt = $db->prepare("UPDATE orden_trabajo_asignar SET estatus_impresion = ?
					WHERE MD5(id_orden_trabajo) = ? AND MD5(id_usuario) = ? AND impresion = 1");						
			
					/*$stmt = $db->prepare("SELECT * FROM orden_trabajo_asignar ota
					INNER JOIN usuarios u ON (u.id_usuario = ota.id_usuario)
					WHERE id_orden_trabajo = ? AND ota.id_usuario = ? AND estatus_impresion = ? AND impresion = 1");*/						

					if ($EstatusOrden == 4)					
					$Estapa_Terminada = $Estapa_Terminada + 1;
					
				}

				if ($c == 2)
				{
					$IdUsuario = $IdUsuario3;
					$EstatusOrden = $EstatusOrden3;
					
					$stmt = $db->prepare("UPDATE orden_trabajo_asignar SET estatus_acabado = ?
					WHERE MD5(id_orden_trabajo) = ? AND MD5(id_usuario) = ? AND acabado = 1");					
					
					/*$stmt = $db->prepare("SELECT * FROM orden_trabajo_asignar ota
					INNER JOIN usuarios u ON (u.id_usuario = ota.id_usuario)
					WHERE id_orden_trabajo = ? AND ota.id_usuario = ? AND estatus_acabado = ? AND acabado = 1");*/						

					if ($EstatusOrden == 4)					
					$Estapa_Terminada = $Estapa_Terminada + 1;
					
				}

				/*if ($c == 3)
				{
					$IdUsuario = $IdUsuario4;
					$EstatusOrden = $EstatusOrden4;
					
					$stmt = $db->prepare("UPDATE orden_trabajo_asignar SET estatus_detalle = ?
					WHERE MD5(id_orden_trabajo) = ? AND MD5(id_usuario) = ? AND detalle = 1");					
					
					//$stmt = $db->prepare("SELECT * FROM orden_trabajo_asignar ota
					//INNER JOIN usuarios u ON (u.id_usuario = ota.id_usuario)
					//WHERE id_orden_trabajo = ? AND ota.id_usuario = ? AND estatus_acabado = ? AND acabado = 1");					

					if ($EstatusOrden == 4)					
					$Estapa_Terminada = $Estapa_Terminada + 1;
					
				}*/				
				

				
				$p = 1;
				$stmt->bindParam($p,$EstatusOrden,PDO::PARAM_INT);	
				$p++;
				$stmt->bindParam($p,$Id_Orden_Trabajo,PDO::PARAM_STR,255);
				$p++;
				$stmt->bindParam($p,$IdUsuario,PDO::PARAM_STR,255);			


			
				$stmt->execute();
				//$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				//$nfilas = $stmt->rowCount();
				$stmt->closeCursor();
			
				$c++;
			}
			
			if ($IdUsuario1 == "")
			$Porcentaje = number_format($Estapa_Terminada*100/2,2,'.','');
			else
			$Porcentaje = number_format($Estapa_Terminada*100/3,2,'.','');
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Orden de Trabajo Actualizado";
			$Tipo = "16";
			//echo $Id_Orden_Trabajo;

			if ($Porcentaje == 100)
			$stmt = $db->prepare("UPDATE orden_trabajo SET porcentaje_realizado=?,id_estado=3,ultima_actualizacion=NOW() 
			WHERE MD5(id_orden_trabajo)=?");
			else
			$stmt = $db->prepare("UPDATE orden_trabajo SET porcentaje_realizado=?,id_estado=2,ultima_actualizacion=NOW() 
			WHERE MD5(id_orden_trabajo)=?");

			$c = 1;
			$stmt->bindParam($c,$Porcentaje,PDO::PARAM_STR,255);			
			$c++;
			$stmt->bindParam($c,$Id_Orden_Trabajo,PDO::PARAM_STR,255);
					
			$Actualizado = $stmt->execute();
			//print_r($stmt->errorInfo());
			
			$stmt = $db->prepare("SELECT id_orden_trabajo, id_cotizacion FROM orden_trabajo WHERE md5(id_orden_trabajo) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Orden_Trabajo,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_orden_trabajo = $results[0]["id_orden_trabajo"];	
			$id_cotizacion = $results[0]["id_cotizacion"];
			
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
				
			$stmt = $db->prepare("INSERT INTO historial_orden_trabajo (id_orden_trabajo,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_orden_trabajo,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();			
				
			try
			{		
				$stmt = $db->prepare("SELECT (SUM(porcentaje_realizado)/COUNT(*)) AS Trabajo_Cotizacion_Realizado FROM cotizacion_producto cp
				LEFT JOIN orden_trabajo ot ON(ot.id_imprenta = cp.id_imprenta)
				AND (ot.id_banner = cp.id_banner) AND (ot.id_impresion = cp.id_impresion)
				WHERE cp.id_cotizacion = ? AND id_producto = 0");
				
				$c = 1;
				$stmt->bindParam($c,$id_cotizacion,PDO::PARAM_INT);				
								
				$stmt->execute();
				$Porcentaje_Realizado = $stmt->fetchColumn();
				//$nfilas2 = $stmt->rowCount();
				
				$stmt = $db->prepare("SELECT monto_total, IF(id_tipo_cliente = 1, (SELECT credito FROM cliente_persona WHERE id_cliente = c.id_cliente),
				(SELECT credito FROM cliente_empresa WHERE id_cliente = c.id_cliente)) AS credito  FROM cotizaciones c
				WHERE id_cotizaciones = ?");

				$p = 1;
				$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_STR,255);
				
				$stmt->execute();
				//print_r($stmt->errorInfo());
				$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$Monto_Total = number_format($rows1[0]['monto_total'],2,'.','');
				$Credito = $rows1[0]['credito'];
				
				$stmt = $db->prepare("SELECT IFNULL(SUM(monto_abonado),0) As total_abonado FROM abono a
				WHERE id_cotizacion = ?");

				$p = 1;
				$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_STR,255);
				
				$stmt->execute();
				//print_r($stmt->errorInfo());
				$Total_Abonado = number_format($stmt->fetchColumn(),2,'.','');				
				
				$stmt->closeCursor();
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}			
			
			
			
			
			if ((($Porcentaje_Realizado == 100) and ($Monto_Total <= $Total_Abonado)) or (($Porcentaje_Realizado == 100) and ($Credito == 1)))
			{
				$stmt = $db->prepare("UPDATE cotizaciones SET id_estatus = 4 WHERE id_cotizaciones = ?");
				$c = 1;
				$stmt->bindParam($c,$id_cotizacion,PDO::PARAM_INT);
			
				$Actualizado1 = $stmt->execute();		
			}
			else if ((($Porcentaje_Realizado == 100) and ($Monto_Total > $Total_Abonado)))
			{
				$stmt = $db->prepare("UPDATE cotizaciones SET id_estatus = 3 WHERE id_cotizaciones = ?");
				$c = 1;
				$stmt->bindParam($c,$id_cotizacion,PDO::PARAM_INT);
			
				$Actualizado1 = $stmt->execute();				
			}
			
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();		
		}
		

		//echo "$Actualizado-$Insertado1-$Insertado2";		
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
	if($_GET['action'] == 'Cargar_Diseno_Arte')	
	{
		$ruta="../../tmp/";
		
		$NumeroCotizacion	= strip_tags(utf8_decode($_GET['id']));
		$Id_Archivo_Dropbox[0] = "";
		//print_r($_FILES);
		//echo $NumeroCotizacion;
		$f=0;$i=0;
		foreach ($_FILES as $key) {
			if($key['error'] == UPLOAD_ERR_OK )
			{//Verificamos si se subio correctamente
				$nombre = $key['name'];//Obtenemos el nombre del archivo
				$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
				//$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
				$tamano= $key['size']; //Obtenemos el tamaño en KB
				move_uploaded_file($temporal, $ruta . $nombre); //Movemos el archivo temporal a la ruta especificada
				//El echo es para que lo reciba jquery y lo ponga en el div "cargados"
			
				try
				{		

					$stmt = $db->prepare("SELECT id_cotizaciones FROM cotizaciones WHERE MD5(id_cotizaciones) = ?");
			
					$p = 1;		
					$stmt->bindParam($p,$NumeroCotizacion,PDO::PARAM_STR,255);	

					$stmt->execute();
					//print_r($stmt->errorInfo());
					$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$nfilas = $stmt->rowCount();
					$stmt->closeCursor();			
						
					$stmt = $db->prepare("SELECT id_archivo_dropbox FROM archivo_dropbox WHERE MD5(id_cotizacion) = ? and nombre_archivo = ?");
					
					$p = 1;
					$stmt->bindParam($p,$NumeroCotizacion,PDO::PARAM_STR,255);
					$p++;
					$stmt->bindParam($p,$nombre,PDO::PARAM_STR,255);					
					
					$Insertado = $stmt = $db->prepare("INSERT INTO archivo_dropbox(id_cotizacion,nombre_archivo,tamano_archivo_byte,ruta_archivo_interno,fecha_agregado) VALUE (?,?,?,?, NOW())");
				
					$c = 1;
					$stmt->bindParam($c,$rows[0]['id_cotizaciones'],PDO::PARAM_INT);				
					$c++;
					$stmt->bindParam($c,$nombre,PDO::PARAM_STR,255);	
					$c++;
					$stmt->bindParam($c,$tamano,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$ruta,PDO::PARAM_INT);
					
					$stmt->execute();

					//$nfilas2 = $stmt->rowCount();
					$stmt->closeCursor();
					
					$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Archivo_Dropbox");
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$Id_Archivo_Dropbox[$f+1] = md5($results[0]["Id_Archivo_Dropbox"]);
					
					$stmt->closeCursor();					
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}			
			
				$i = $Insertado + $i;
				
			}
			/*else
			{
				
				//echo $key['error']; //Si no se cargo mostramos el error
			}*/
			$f++;
		}
		
		if ($f == $i)
		{
			$Id_Archivo_Dropbox[0] = "true";
			echo json_encode($Id_Archivo_Dropbox);
		}
		else
		{
			$Id_Archivo_Dropbox[0] = "false";
			echo json_encode($Id_Archivo_Dropbox);
		}
	}
	
	if($_GET['action'] == 'Cargar_Diseno_Dropbox')	
	{	
		require_once("../../library/DropboxClient.php");
		require_once("../../library/Cargar_Archivo_a_Dropbox.php");

		session_start();	
		$db->beginTransaction();
		
		$Id_Usuario = base64_decode($_SESSION['id_usuario']);
		$Evento = "Diseño de Arte Cargado a Dropbox";
		$Tipo = "17";
			
		$meta =  null;
		$ruta="../../tmp/";
		//$url	= strip_tags(utf8_decode($_POST['url']));
		$dropbox = new DropboxClient(array(
			'app_key' 			=> APP_KEY, 
			'app_secret' 		=> APP_SECRET,
			'app_full_access' 	=> false,
		),'en');		
		
		$NumeroCotizacion	= strip_tags(utf8_decode($_POST['NumeroCotizacion']));
		$DescripcionCotizacion	= strip_tags(utf8_decode($_POST['DescripcionCotizacion']));
		$Oauth_token	= strip_tags(utf8_decode($_POST['Oauth_token']));
		$Oauth_token = ($Oauth_token=="null")?null:$Oauth_token;
		$Auth_callback	= strip_tags(utf8_decode($_POST['Auth_callback']));
		$Auth_callback = ($Auth_callback=="null")?null:$Auth_callback;
		$file = json_decode($_POST['file']);
		$idad = json_decode($_POST['idad']);
		$Url	= $_POST['Url'];

		//echo $Url;
		
		handle_dropbox_auth($dropbox,$Url,$Oauth_token,$Auth_callback);

		//$upload_name	= strip_tags(utf8_decode($_POST['file']));
		//$upload_name = $_FILES["file"]["name"];
		/*$folder = $dropbox->CreateFolder("Cotizacion_".$NumeroCotizacion);*/
		
		//echo $ruta.$file;

		
		//$meta = $dropbox->UploadFile($_FILES["file"]["tmp_name"], "Cotizacion_".$NumeroCotizacion."/".$upload_name);	
		//fclose();
		
		if($dropbox->IsAuthorized())
		{
			try
			{		

				$stmt = $db->prepare("SELECT id_cotizaciones FROM cotizaciones WHERE MD5(id_cotizaciones) = ?");
			
				$p = 1;		
				$stmt->bindParam($p,$NumeroCotizacion,PDO::PARAM_STR,255);	

				$stmt->execute();
				//print_r($stmt->errorInfo());
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas = $stmt->rowCount();
				
				$id_cotizaciones = $rows[0]['id_cotizaciones'];
				
				$stmt->closeCursor();
				
				$stmt = $db->prepare("SELECT id_archivo_dropbox FROM archivo_dropbox WHERE MD5(id_cotizacion) = ? AND id_estado = 1");
					
				$p = 1;
				$stmt->bindParam($p,$NumeroCotizacion,PDO::PARAM_STR,255);

				$stmt->execute();
				//print_r($stmt->errorInfo());
				$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas1 = $stmt->rowCount();				
			
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}			
			//$dropbox->Delete("/");
			if($nfilas1 > 0) 
			$Borrado = $dropbox->Delete("Cotizacion_".$id_cotizaciones);
			else
			$folder = $dropbox->CreateFolder("Cotizacion_".$id_cotizaciones);
			
			if($Borrado)
			$folder = $dropbox->CreateFolder("Cotizacion_".$id_cotizaciones);
			
			$f=0; $i=0;$i1=0;$i2=0;$m=0;
			while($f < count($file))
			{
				
				$archivo = strip_tags(utf8_decode($file[$f]));
				$id_archivo_dropbox = strip_tags(utf8_decode($idad[$f]));
				//echo $file[$f];
				//echo $archivo;
		
				$meta = $dropbox->UploadFile($ruta.$archivo, "Cotizacion_".$id_cotizaciones."/".$archivo);
		
				if (($meta !== false) or ($meta != null))
				{
				
					try
					{		
						$stmt = $db->prepare("SELECT id_archivo_dropbox FROM archivo_dropbox WHERE MD5(id_cotizacion) = ? AND nombre_archivo = ? AND MD5(id_archivo_dropbox) = ?");
					
						$p = 1;
						$stmt->bindParam($p,$NumeroCotizacion,PDO::PARAM_STR,255);
						$p++;
						$stmt->bindParam($p,$archivo,PDO::PARAM_STR,255);
						$p++;
						$stmt->bindParam($p,$id_archivo_dropbox,PDO::PARAM_STR,255);						
						
						$stmt->execute();
						$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$Id_Archivo_Dropbox = $results[0]["id_archivo_dropbox"];					
						
						$stmt->closeCursor();
						
						//echo $id_cotizaciones;
						//echo "UPDATE archivo_dropbox SET ruta_archivo_dropbox = 'Cotizacion_".$id_cotizaciones."/', id_estado = 1 WHERE MD5(id_cotizacion) = '".$NumeroCotizacion."' AND nombre_archivo = '".$archivo."' AND MD5(id_archivo_dropbox) = '".$id_archivo_dropbox."'";
						$stmt = $db->prepare("UPDATE archivo_dropbox SET ruta_archivo_dropbox = 'Cotizacion_".$id_cotizaciones."/', id_estado = 1 WHERE MD5(id_cotizacion) = ? AND nombre_archivo = ? AND MD5(id_archivo_dropbox) = ?");
				
						$p = 1;
						$stmt->bindParam($p,$NumeroCotizacion,PDO::PARAM_STR,255);				
						$p++;
						$stmt->bindParam($p,$archivo,PDO::PARAM_STR,255);					
						$p++;
						$stmt->bindParam($p,$id_archivo_dropbox,PDO::PARAM_STR,255);
						
						$Insertado = $stmt->execute();

						$i = $Insertado + $i;
						//print_r($stmt->errorInfo());
						//$nfilas2 = $stmt->rowCount();
						$stmt->closeCursor();
					
						/*$stmt = $db->prepare("SELECT id_archivo_dropbox FROM archivo_dropbox WHERE MD5(id_cotizacion) = ?");
					
						$p = 1;
						$stmt->bindParam($p,$NumeroCotizacion,PDO::PARAM_STR,255);
						$stmt->execute();
						$results1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$Id_Archivo_Dropbox = $results1[0]["id_archivo_dropbox"];

						$stmt->closeCursor();*/

						$stmt = $db->prepare("INSERT INTO user_log (id_usuario,anio,fecha_log,evento,tipo) VALUES (?,YEAR(NOW()), NOW(),?,?)");
						$c = 1;
						$stmt->bindParam($c,$Id_Usuario,PDO::PARAM_INT);
						$c++;
						$stmt->bindParam($c,$Evento,PDO::PARAM_STR,255);
						$c++;
						$stmt->bindParam($c,$Tipo,PDO::PARAM_INT);
	
						$Insertado1 = $stmt->execute();
						
						$i1 = $Insertado1 + $i1;
				
						$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Log");
						$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$Id_Log = $results[0]["Id_Log"];
				
						$stmt = $db->prepare("INSERT INTO historial_archivo_dropbox (id_dropbox,id_log) VALUES (?,?)");
						$c = 1;
						$stmt->bindParam($c,$Id_Archivo_Dropbox,PDO::PARAM_INT);
						$c++;
						$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
						$Insertado2 = $stmt->execute();

						$i2 = $Insertado2 + $i2;	
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}				
				
					$m++;
				}
		
				$f++;
			}
			
			//echo "$i-$i1-$i2-$m-$f";		
			if (($i == $f) and ($i1 == $f) and ($i2 == $f) and ($m == $f))
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
	//print_r($meta);
	//echo "\r\n done!";
	//echo "</pre>";
	}
	
	if($_GET['action'] == 'Listar_Archivos_DropBox')	
	{	
		require_once("../../library/DropboxClient.php");
		require_once("../../library/Cargar_Archivo_a_Dropbox.php");
		
		$dropbox = new DropboxClient(array(
			'app_key' 			=> APP_KEY, 
			'app_secret' 		=> APP_SECRET,
			'app_full_access' 	=> false,
		),'en');		
		
		//echo "prueba";
		$Oauth_token	= strip_tags(utf8_decode($_POST['Oauth_token']));
		$Oauth_token = ($Oauth_token=="null")?null:$Oauth_token;
		$Auth_callback	= strip_tags(utf8_decode($_POST['Auth_callback']));
		$Auth_callback = ($Auth_callback=="null")?null:$Auth_callback;
		$Url	= $_POST['Url'];

		//echo $Url;
		
		handle_dropbox_auth($dropbox,$Url,$Oauth_token,$Auth_callback);	

		//$FileTree = $dropbox->getFileTree("",false,0,0);
		$FileTree = $dropbox->getFileTree("",false,10,0);
		
		//print_r($FileTree);
		
		$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable"><thead><tr>';			

		$html .= '<th style="width:2%"></th>
				<th style="width:10%">Nombre de la Carpeta Dropbox 
				<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
				<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
				<th style="width:20%">Nombre del Archivo</th>
				<th style="width:20%">Tamano del Archivo</th>
				<th style="width:20%">Fecha Modificado</th>';	

		$html .= '</tr>
            </thead>
            <tbody>';
		$r=0;
		
		foreach ($FileTree as $Item)
		{
			$row = (array) $Item;
			

			
			$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
						<td>'.$c.'</td>';
			
			if ($row['is_dir'] == 1)
			{
				$html .='<td>'.substr($row['path'],1).'</td>
				<td></td>';
			}
			else
			{
				$file = substr($row['path'],strrpos($row['path'],"/")+1);
				$path = substr($row['path'],0,strrpos($row['path'],"/"));
			
				$html .='<td></td>
				<td>'.$file.'</td>';
			}

				
				$html .= '<td>'.$row['size'].'</td>
				<td>'.$row['modified'].'</td>';
						/*<td>';
					
					if ($row['is_dir'] != 1)
					{						
						$html .='<a href="javascript:void(0);" title="Descagar" class="smallButton" style="margin: 5px;" onclick="Descargar_Archivo(\''.$path.'\',\''.$file.'\');"><img src="public/images/icons/light/download.png" alt="" class="icon" /><span></span></a>';
					}
					//if (base64_decode($_SESSION['id_tipo_usuario']) == 1)							
					//$html .='<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Archivo Dropbox?\')){Eliminar_Proveedor('.$c.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					
					$html .='<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="" /></td>*/					
				$html .= '</tr>';			
			
			
			
			//$row = get_object_vars ( object  stdClass  );
			//print_r($row);
			
			//echo $row['path'];
			//print_r($Item);
			//echo $Item[$r]['path'];
			//echo $row['size'];
			//echo $r;
		
			$r++;
		}
		
		$html .= '
              </tbody></table>';			
		//echo count ($FileTree[0]);
		//print_r($FileTree);
		
		echo $html;
	}
	
	if($_GET['action'] == 'Descargar_Archivo')	
	{
		require_once("../../library/DropboxClient.php");
		require_once("../../library/Cargar_Archivo_a_Dropbox.php");
		
		$dropbox = new DropboxClient(array(
			'app_key' 			=> APP_KEY, 
			'app_secret' 		=> APP_SECRET,
			'app_full_access' 	=> false,
		),'en');		
		
		//echo "prueba";
		$Oauth_token	= strip_tags(utf8_decode($_POST['Oauth_token']));
		$Oauth_token = ($Oauth_token=="null")?null:$Oauth_token;
		$Auth_callback	= strip_tags(utf8_decode($_POST['Auth_callback']));
		$Auth_callback = ($Auth_callback=="null")?null:$Auth_callback;
		$Url	= $_POST['Url'];
		$Path	= $_POST['Path'];
		$File	= $_POST['File'];
		
		//echo $Url;
		
		handle_dropbox_auth($dropbox,$Url,$Oauth_token,$Auth_callback);	

		echo $dropbox->DownloadFile($File, $Path);
		//echo $dropbox->DownloadFile($File, "/var/www/imprenta_final/tmp/");
		//echo $dropbox->DownloadFile("../tmp/".$File);
	}

	if($_GET['action'] == 'Imprimir_Orden_Trabajo')
	{

		include('../../library/Generar_Orden_Trabajo.php');

		$objGenerarOrdenTrabajo =  new Generar_Orden_Trabajo();

		$Id_Orden	= strip_tags(utf8_decode($_POST['id']));	
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM orden_trabajo WHERE MD5(id_orden_trabajo) =  ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Orden,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		$Id_Cotizacion = $rows[0]['id_cotizacion'];
		$Numero_Orden = $rows[0]['id_orden_trabajo'];
		$FechaCreado = $rows[0]['fecha_creado'];
		$fecha_entrega = $rows[0]['fecha_entrega'];
		$id_imprentaMsj = $rows[0]['id_imprenta'];
		
		$fecha = explode ("-" ,$fecha_entrega);
		$Fecha_Entrega = $fecha[2]."-".$fecha[1]."-".$fecha[0];
		
		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones, cotizacion_base, descripcion_estatus,monto_subtotal,monto_itbm,monto_total
			FROM cotizaciones co INNER JOIN tipo_estatus_cotizacion te ON (te.id_estatus = co.id_estatus) WHERE id_cotizaciones = ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows6 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas6 = $stmt->rowCount();
			$stmt->closeCursor();
			
			$monto_total = $rows6[0]['monto_total'];
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		try
		{		
			$stmt = $db->prepare("SELECT IFNULL(SUM(monto_abonado),0) AS Monto_Abonado
			FROM abono WHERE id_cotizacion = ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows8 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas8 = $stmt->rowCount();
			$stmt->closeCursor();
			
			$monto_abono = $rows8[0]['Monto_Abonado'];
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}		
		
		if ($rows6[0]['id_tipo_cliente'] == 1)
		{
			try
			{		
				$Id_Cliente = $rows6[0]['id_cliente'];
				
				$stmt = $db->prepare("SELECT id_cliente,CONCAT(nombre,' ',apellido) AS Nombre_Cliente,direccion,email,telefono,celular 
				FROM cliente_persona WHERE id_cliente = ?");			
		
				$p = 1;
				$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_STR,255);
			
				$stmt->execute();
				$rows7 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas7 = $stmt->rowCount();
				$stmt->closeCursor();
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}		
		
		
		
		
		
		}
		else if ($rows6[0]['id_tipo_cliente'] == 2)
		{
		
			try
			{		
				$Id_Cliente = $rows6[0]['id_cliente'];
				
				$stmt = $db->prepare("SELECT id_cliente,nombre_empresa AS Nombre_Cliente,ruc_parte_1,ruc_parte_2,ruc_parte_3,dv,direccion,email,telefono,celular
				FROM cliente_empresa WHERE id_cliente = ?");				

				$p = 1;
				$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_STR,255);
			
				$stmt->execute();
				$rows7 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas7 = $stmt->rowCount();
				$stmt->closeCursor();
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}		
		
		}

		
		if ($rows[0]['id_imprenta'] > 0)
		{
		
					$Id_imprenta = $rows[0]['id_imprenta'];
					
					
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM imprenta lb
						INNER JOIN imprenta_tipo_papel lbtp ON (lbtp.id_tipo_papel = lb.id_tipo_papel)
						INNER JOIN imprenta_tipo_material lbm ON (lb.id_tipo_material = lbm.id_tipo_material)
						LEFT JOIN imprenta_tamano_papel lbt ON (lbt.id_tamano_papel = lb.id_tamano)
						INNER JOIN imprenta_color_tinta lbct ON (lbct.id_color = lb.id_color_tinta)
						INNER JOIN imprenta_tipo_forro lbtf ON (lbtf.id_forro = lb.id_forro)
						INNER JOIN cotizacion_producto cp ON (cp.id_imprenta = lb.id_imprenta)
						WHERE lb.id_imprenta = ?");

						$p = 1;
						$stmt->bindParam($p,$Id_imprenta,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas1 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					

					//echo $rows1[0]['descripcion_tipo_material'];
					//echo $rows1[0]['descripcion_imprenta'];
					
					$Cantidad = $rows1[0]['cantidad'];
					$Nombre_Producto = $rows1[0]['descripcion_imprenta'];					
					$Precio = $rows1[0]['precio_venta'];
					$Tipo_Empaque = "Unidad";
					
					$PapelTipo = $rows1[0]['descripcion_papel'];
					$Tamano = $rows1[0]['descripcion_tamano'];
					$Otro_Ancho = $rows1[0]['otro_ancho'];
					$Otro_Largo = $rows1[0]['otro_largo'];					
					$Tipo_Material = $rows1[0]['descripcion_tipo_material'];
					$CantidadCopia = $rows1[0]['cant_copia'];
					$ColorTinta = $rows1[0]['descripcion_color'];
					$TipoForro = $rows1[0]['descripcion_forro'];
					$IdColorPapel[0] = $rows1[0]['id_color_papel'];
					$IdColorPapel[1] = $rows1[0]['id_color_papel1'];
					$IdColorPapel[2] = $rows1[0]['id_color_papel2'];
					$IdColorPapel[3] = $rows1[0]['id_color_papel3'];
					$IdTipoTiempo = $rows1[0]['id_tipo_tiempo'];
					$TipoCategoria = $rows1[0]['id_categoria'];
					$Numeracion_Inicial = $rows1[0]['numeracion_inicial'];
					$Numeracion_Final = $rows1[0]['numeracion_final'];
					$Nota = $rows1[0]['observacion'];
					$ColorPapel = "";
					$ColorPapel1 = "";
					$ColorPapel2 = "";
					$ColorPapel3 = "";					
					
					$cp = 0;
					while ($cp <= $CantidadCopia)
					{
					
						try
						{		
							$stmt = $db->prepare("SELECT * FROM imprenta_color_papel WHERE id_color = ?");

							$p = 1;
							$stmt->bindParam($p,$IdColorPapel[$cp],PDO::PARAM_INT);
			
							$stmt->execute();
							$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas2 = $stmt->rowCount();
							$stmt->closeCursor();
						
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}					
						
						if ($cp == 0)
						{
							$ColorPapel = $rows2[0]['descripcion_color'];
						}
						else if ($cp == 1)
						{
							$ColorPapel1 = $rows2[0]['descripcion_color'];
						}
						else if ($cp == 2)
						{
							$ColorPapel2 = $rows2[0]['descripcion_color'];
						}						
						else if ($cp == 3)
						{
							$ColorPapel3 = $rows2[0]['descripcion_color'];
						}					
					
					
						$cp = $cp + 1;
					}
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM imprenta_tipo_costo WHERE id_tipo_costo = ?");

						$p = 1;
						$stmt->bindParam($p,$IdTipoTiempo,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas3 = $stmt->rowCount();
						$stmt->closeCursor();
						
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}

					$TipoTiempo = $rows3[0]['descripcion_costo'];				
					$Material_Banner = "";
					$Ancho = "";
					$Ancho_Medida = "";
					$Largo = "";
					$Largo_Medida = "";
					$Area_Total = "";
					$Forma_Pago = "";
					$Calidad = "";
					$precio_instalacion = "";
					$precio_recorte = "";
					$precio_arte = "";
					$precio_rotulado = "";
					$precio_basta = "";
					$precio_ojetes = "";
					$precio_bulcaniza = "";
					$precio_venta = $rows3[0]['precio_venta'];
					$Material_Impresion = "";
					$recorte  = "";
					$plastificado  ="";
					$caminado  = "";
					$realce  = "";
					$doblado  = "";
					$repujado  = "";
					$engrapado  = "";
					$uv  = "";
					
					$mensaje[0] = "imprenta";		
		
		
		
		
		}
		else if ($rows[0]['id_banner'] > 0)
		{
		
					$Id_Banner = $rows[0]['id_banner'];
					
					
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM banner bnr
						INNER JOIN banner_material bnrm ON (bnrm.id_material = bnr.id_material)
						INNER JOIN banner_forma_pago bnrf ON (bnrf.id_forma_pago = bnr.id_forma_pago)
						INNER JOIN banner_calidad bnrc ON (bnrc.id_calidad = bnr.id_calidad)
						INNER JOIN cotizacion_producto cp ON (cp.id_banner = bnr.id_banner)
						WHERE bnr.id_banner = ?");

						$p = 1;
						$stmt->bindParam($p,$Id_Banner,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas4 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					

					//echo $rows3[0]['descripcion_imprenta'];
					$Cantidad = $rows4[0]['cantidad'];					
					$Nombre_Producto = $rows4[0]['descripcion_banner'];					
					$Precio = $rows4[0]['precio_venta'];
					$Tipo_Empaque = "Unidad";
					$Material_Banner = $rows4[0]['descripcion_material'];
					$Ancho = $rows4[0]['ancho'];
					$Id_Ancho_Medida = $rows4[0]['id_medida_ancho'];
					$Largo = $rows4[0]['largo'];
					$Id_Largo_Medida = $rows4[0]['id_medida_largo'];
					$Area_Total = $rows4[0]['area_total'];
					$Forma_Pago = $rows4[0]['descripcion_forma_pago'];
					$Calidad = $rows4[0]['descripcion_calidad'];
					$precio_instalacion = $rows4[0]['precio_instalacion'];
					$precio_recorte = $rows4[0]['precio_recorte'];
					$precio_arte = $rows4[0]['precio_arte'];
					$precio_rotulado = $rows4[0]['precio_rotulado'];
					$precio_basta = $rows4[0]['precio_basta'];
					$precio_ojetes = $rows4[0]['precio_ojetes'];
					$precio_bulcaniza = $rows4[0]['precio_bulcaniza'];
					$precio_venta = $rows4[0]['precio_venta'];
					$Nota = $rows4[0]['observacion'];					
					$PapelTipo = "";
					$Tamano = "";
					$Otro_Ancho = "";
					$Otro_Largo = "";					
					$Tipo_Material = "";
					$CantidadCopia = "";
					$ColorTinta = "";
					$TipoForro = "";
					$ColorPapel = "";
					$ColorPapel1 = "";
					$ColorPapel2 = "";
					$ColorPapel3 = "";					
					$TipoTiempo = "";
					$TipoCategoria = "";
					$Numeracion_Inicial = "";
					$Numeracion_Final = "";
					$Material_Impresion = "";
					$recorte  = "";
					$plastificado  ="";
					$caminado  = "";
					$realce  = "";
					$doblado  = "";
					$repujado  = "";
					$engrapado  = "";
					$uv  = "";	
					
					$d = 0;
					while ($d < 2)
					{
						try
						{		
							$stmt = $db->prepare("SELECT * FROM tipo_unidad WHERE id_unidad = ?");

							$p = 1;
							if ($d == 0)
							$stmt->bindParam($p,$Id_Ancho_Medida,PDO::PARAM_INT);
							else if ($d == 1)
							$stmt->bindParam($p,$Id_Largo_Medida,PDO::PARAM_INT);
			
							$stmt->execute();
							$rows5[$d] = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas5[$d] = $stmt->rowCount();
							$stmt->closeCursor();
						
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}
						
						if ($d == 0)						
						$Ancho_Medida = $rows5[0][0]['descripcion_unidad'];
						else if ($d == 1)
						$Largo_Medida = $rows5[1][0]['descripcion_unidad'];
						
						$d = $d + 1;
					}
					
					$mensaje[0] = "banner";
		}
		else if ($rows[0]['id_impresion'] > 0)
		{
		
					$Id_Impresion = $rows[0]['id_impresion'];
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM impresion imp
						INNER JOIN impresion_material impma ON (impma.id_material = imp.id_material)
						INNER JOIN impresion_tamano_pliego imptp ON (imptp.id_tamano = imp.id_tamano)
						INNER JOIN impresion_color_tinta impct ON (impct.id_color = imp.id_color_tinta)
						INNER JOIN cotizacion_producto cp ON (cp.id_impresion = imp.id_impresion)
						WHERE imp.id_impresion = ?");						
						
						$p = 1;
						$stmt->bindParam($p,$Id_Impresion,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows9 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas9 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					

					//echo $rows3[0]['descripcion_imprenta'];
					$Cantidad = $rows9[0]['cantidad'];					
					$Nombre_Producto = $rows9[0]['descripcion_impresion'];					
					$Precio = $rows9[0]['precio_venta'];
					$Tipo_Empaque = "Unidad";
					$Material_Banner = "";
					$Ancho = $rows9[0]['arte_ancho'];
					$Id_Ancho_Medida = $rows9[0]['arte_ancho_medida'];
					$Largo = $rows9[0]['arte_largo'];
					$Id_Largo_Medida = $rows9[0]['arte_largo_medida'];
					$Area_Total = $rows9[0]['arte_area'];
					$Forma_Pago = "";
					$Calidad = "";
					$precio_instalacion = "";
					$precio_recorte = "";
					$precio_arte = $rows6[0]['precio_arte'];
					$precio_rotulado = "";
					$precio_basta = "";
					$precio_ojetes = "";
					$precio_bulcaniza = "";
					$precio_venta = $rows9[0]['precio_venta'];
					$Nota = $rows9[0]['observacion'];					
					$PapelTipo = "";
					$Tamano = $rows9[0]['descripcion_tamano'];	
					$Otro_Ancho = $rows9[0]['otro_ancho'];
					$Otro_Largo = $rows9[0]['otro_largo'];	
					$Tipo_Material = "";
					$CantidadCopia = "";
					$ColorTinta = $rows9[0]['descripcion_color'];
					$TipoForro = "";
					$ColorPapel = "";
					$ColorPapel1 = "";
					$ColorPapel2 = "";
					$ColorPapel3 = "";					
					$TipoTiempo = "";
					$Numeracion_Inicial = "";
					$Numeracion_Final = "";
					$TipoCategoria = $row9[0]['id_categoria'];
					$Material_Impresion = $rows9[0]['descripcion_material'];
					$recorte  = $rows9[0]['recorte'];
					$plastificado  = $rows9[0]['plastificado'];
					$caminado  = $rows9[0]['caminado'];
					$realce  = $rows9[0]['realce'];
					$doblado  = $rows9[0]['doblado'];
					$repujado  = $rows9[0]['repujado'];
					$engrapado  = $rows9[0]['engrapado'];
					$uv  = $rows6[0]['uv'];				
					
					$d = 0;
					while ($d < 2)
					{
						try
						{		
							$stmt = $db->prepare("SELECT * FROM tipo_unidad WHERE id_unidad = ?");

							$p = 1;
							if ($d == 0)
							$stmt->bindParam($p,$Id_Ancho_Medida,PDO::PARAM_INT);
							else if ($d == 1)
							$stmt->bindParam($p,$Id_Largo_Medida,PDO::PARAM_INT);
			
							$stmt->execute();
							$rows10[$d] = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas10[$d] = $stmt->rowCount();
							$stmt->closeCursor();
						
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}
						
						if ($d == 0)						
						$Ancho_Medida = $rows10[0][0]['descripcion_unidad'];
						else if ($d == 1)
						$Largo_Medida = $rows10[1][0]['descripcion_unidad'];
						
						$d = $d + 1;
					}
					
					$mensaje[0] = "impresion";
		}				

		$cotizacion_base = ($rows6[0]['cotizacion_base'] == '')?'NULL':$rows6[0]['cotizacion_base'];

		$mensaje[1] = $Nombre_Producto;
		$mensaje[2] = $Tipo_Empaque;				
		$mensaje[3] = $Precio;
		$mensaje[4] = $PapelTipo;		
		$mensaje[5] = $Tamano;
		$mensaje[6] = $CantidadCopia;
		$mensaje[7] = $ColorTinta;
		$mensaje[8] = $TipoForro;
		$mensaje[9] = $ColorPapel;				
		$mensaje[10] = $ColorPapel1;
		$mensaje[11] = $ColorPapel2;		
		$mensaje[12] = $ColorPapel3;
		$mensaje[13] = $TipoTiempo;
		$mensaje[14] = $Material_Banner;
		$mensaje[15] = $Ancho;
		$mensaje[16] = $Ancho_Medida;
		$mensaje[17] = $Largo;
		$mensaje[18] = $Largo_Medida;
		$mensaje[19] = $Area_Total;				
		$mensaje[20] = $Forma_Pago;
		$mensaje[21] = $Calidad;		
		$mensaje[22] = $precio_instalacion;
		$mensaje[23] = $precio_recorte;		
		$mensaje[24] = $precio_arte;
		$mensaje[25] = $precio_rotulado;		
		$mensaje[26] = $precio_basta;
		$mensaje[27] = $precio_ojetes;
		$mensaje[28] = $precio_bulcaniza;
		$mensaje[29] = $precio_venta;
		$mensaje[30] = $Id_Cotizacion;
		$mensaje[31] = $Numero_Orden;
		$mensaje[32] = $Cantidad;		
		$mensaje[33] = $rows7[0]['Nombre_Cliente'];
		$mensaje[34] = $rows7[0]['direccion'];		
		$mensaje[35] = $rows7[0]['ruc_parte_1']."-".$rows7[0]['ruc_parte_2']."-".$rows7[0]['ruc_parte_3'];
		$mensaje[36] = $rows7[0]['telefono'];
		$mensaje[37] = $rows7[0]['celular'];
		$mensaje[38] = $rows7[0]['email'];
		$mensaje[39] = $Numeracion_Inicial;
		$mensaje[40] = $Numeracion_Final;
		$mensaje[41] = ($Nota == '') ? 'Orden sin ninguna observacion' : $Nota;
		$mensaje[42] = number_format($monto_total,2,'.','');
		$mensaje[43] = number_format($monto_abono,2,'.','');
		$mensaje[44] = number_format($monto_total-$monto_abono,2,'.','');
		$mensaje[45] = $Tipo_Material;
		$mensaje[46] = $recorte;
		$mensaje[47] = $plastificado;
		$mensaje[48] = $caminado;
		$mensaje[49] = $realce;
		$mensaje[50] = $doblado;
		$mensaje[51] = $repujado;
		$mensaje[52] = $engrapado;
		$mensaje[53] = $uv;
		$mensaje[54] = $Otro_Ancho;
		$mensaje[55] = $Otro_Largo;
		$mensaje[56] = $Material_Impresion;
		$mensaje[57] = $Fecha_Entrega;
		$mensaje[58] = $rows1[0]['dv'];	
		$mensaje[59] = $cotizacion_base;
		
		$hoy = date('Y-m-d',strtotime($FechaCreado));
		$desde=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy)),date("Y", strtotime($hoy))));
				
		$objGenerarOrdenTrabajo->Generar_Orden_Trabajo_Imprenta($desde, $hasta, $mensaje);
				
		echo 'tmp/Orden_Trabajo_Innovations_Print_'.$mensaje[30].'_'.$desde.'.pdf';

	
	}
	
	