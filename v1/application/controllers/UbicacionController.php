<?php
	include('../../config/configuracion.php');
	include('../../library/Database.php');	
	date_default_timezone_set ('America/Panama');
	if (!isset($_SERVER['HTTP_REFERER']))
	header('Location: ../index.php');
	

	try {
		$db = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NOMBRE, DB_USER, DB_CLAVE);
	}
		catch(PDOException $e) {
		echo $e->getMessage();
	}
	
	if($_GET['action'] == 'Listar_Ubicacion_Autocompletar')
	{
		$html = "";
		
		if(isset($_POST["Ubicacion"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["Ubicacion"])));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;			
		
		
		try
		{
			if((isset($_POST["Ubicacion"])) and ($_POST["Ubicacion"] != ""))
			{
				$stmt = $db->prepare("SELECT id_ubicacion,descripcion_ubicacion FROM ubicaciones WHERE descripcion_ubicacion LIKE '".$criterio."'");			
			}
			else
			{
				$stmt = $db->prepare("SELECT id_ubicacion,descripcion_ubicacion FROM ubicaciones WHERE descripcion_ubicacion LIKE '".$criterio."%'");
			}
			
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
			$Ubicacion = array();
			foreach ($rows as $row)
			{
				$Ubicacion[$c]['value'] = utf8_encode($row['descripcion_ubicacion']);
				$Ubicacion[$c]['hidUbicacion'] = utf8_encode(base64_encode($row['id_ubicacion']));
				$c++;
			}
			$html = json_encode($Ubicacion);
		}
		else
		{
			$html = "null";		
		}
		
		echo $html;
	}	
	

	if($_GET['action'] == 'Listar_Ubicacion')
	{
		$html = "";		
		try
		{
			$stmt = $db->prepare("SELECT id_ubicacion,descripcion_ubicacion,descripcion_tienda FROM ubicaciones u
			INNER JOIN tiendas t ON(t.id_tienda = u.id_tienda)");
			
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
				$html .= "<option value='".base64_encode($row['id_ubicacion'])."'>".utf8_encode($row['descripcion_ubicacion'])." (".utf8_encode($row['descripcion_tienda']).")</option>";
			}
		}
		
		echo $html;
	}	
		
	if($_GET['action'] == 'Agregar_Ubicacion')
	{
		session_start();
		$db->beginTransaction();
		
		$Descripcion = strip_tags(utf8_decode($_POST['Descripcion']));
		$Tienda = strip_tags(utf8_decode(base64_decode($_POST['Tienda'])));	
		
		try
		{
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Ubicacion Agregada";
			$Tipo = "1";
						
			$stmt = $db->prepare("INSERT INTO ubicaciones (descripcion_ubicacion,id_tienda,fecha_agregado)
			VALUES (?,?,'".date('Y-m-d H:i:s')."')");		
	
			$p = 1;
			$stmt->bindParam($p,$Descripcion,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Tienda,PDO::PARAM_STR,255);			
			
			$Insertado = $stmt->execute();
			//print_r($stmt->errorInfo());
			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Ubicacion");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Ubicacion = $results[0]["Id_Ubicacion"];	

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
			
			$stmt = $db->prepare("INSERT INTO historial_ubicaciones (id_ubicacion,id_log) VALUES (?,?)");
			$p = 1;
			$stmt->bindParam($p,$Id_Ubicacion,PDO::PARAM_INT);
			$p++;
			$stmt->bindParam($p,$Id_Log,PDO::PARAM_INT);
			
			$Insertado2 = $stmt->execute();
						
			$stmt->closeCursor();				
		
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}			

		if (($Insertado === true)  and ($Insertado1 === true) and ($Insertado2 === true))
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

	if($_GET['action'] == 'Listar_Ubicaciones')
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
			array( 'db' => 'id_ubicacion', 'dt' => 0 ),
			array( 'db' => 'descripcion_ubicacion',  'dt' => 1 ),
			array( 'db' => 'opciones',   'dt' => 2 ),
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS id_ubicacion,descripcion_ubicacion	FROM ubicaciones ".$where.(($where == "")?"WHERE":" AND")." estatus_ubicacion = 1 ".$order." ".$limit);

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

			$stmt = $db->prepare("SELECT count(id_ubicacion)
			FROM ubicaciones WHERE estatus_ubicacion = 1");			
			
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
				$Data[$f][$c] = $f+1;
				$c++;
				$Data[$f][$c] = utf8_encode($row['descripcion_ubicacion']);
				$c++;
				
				$Data[$f][$c] = "";				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{
					$Data[$f][$c] .= '<button type="button" class="btn btn-success btn-circle" onclick="Editar_Ubicacion('.$f.')" title="Editar Ubicacion"><i class="fa fa-link"></i></button>&nbsp;';
					$Data[$f][$c] .= '<button type="button" class="btn btn-danger btn-circle" onclick="if(confirm(\'Realmente quieres eliminar esta Ubicacion?\')){Eliminar_Ubicacion('.$f.');}" title="Eliminar_Ubicacion"><i class="fa fa-times"></i></button>&nbsp;';
				}
					

				
				$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_ubicacion'])).'" />';
				
				$f = $f + 1;

			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;		
		echo json_encode($ResultSet);		
		
	}

	if($_GET['action'] == 'Ver_Ubicacion')
	{
		try
		{
			$id_ubicacion = strip_tags(utf8_decode($_POST['IdUbicacion']));
			$stmt = $db->prepare("SELECT id_ubicacion,descripcion_ubicacion,id_tienda
			FROM ubicaciones WHERE  MD5(id_ubicacion) = ?");
			
			$p = 1;
			$stmt->bindParam($p,$id_ubicacion,PDO::PARAM_STR,255);			

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
			$Ubicacion = array();
			foreach ($rows as $row)
			{

				$Ubicacion[$c]['txtDescripcion'] = utf8_encode($row['descripcion_ubicacion']);
				$Ubicacion[$c]['lstTienda'] = utf8_encode(base64_encode($row['id_tienda']));
				
				$c++;
			}
		}		

		if ($nfilas > 0)
		{
			$response = json_encode($Ubicacion);
		}		
	
		echo $response;
	
	}

	if($_GET['action'] == 'Actualizar_Ubicacion')
	{
		session_start();
		$db->beginTransaction();
		
		$Descripcion = strip_tags(utf8_decode($_POST['Descripcion']));
		$Tienda = strip_tags(utf8_decode(base64_decode($_POST['Tienda'])));		
		$Id_Ubicacion = strip_tags(utf8_decode($_POST['IdUbicacion']));		
		$Id_Usuario = base64_decode($_SESSION['id_usuario']);
		$Evento = "Ubicacion Actualizada";
		$Tipo = "2";

		try
		{		
			
			$stmt = $db->prepare("UPDATE ubicaciones SET descripcion_ubicacion=?,id_tienda=?,fecha_actualizado='".date('Y-m-d H:i:s')."'
			WHERE MD5(id_ubicacion)=?");
			$p = 1;
			$stmt->bindParam($p,$Descripcion,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Tienda,PDO::PARAM_STR,255);
			$p++;		
			$stmt->bindParam($p,$Id_Ubicacion,PDO::PARAM_STR,255);			
					
			$Actualizado = $stmt->execute();
		//print_r($stmt->errorInfo());
			$stmt = $db->prepare("SELECT id_ubicacion FROM ubicaciones WHERE MD5(id_ubicacion) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Ubicacion,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_ubicacion = $results[0]["id_ubicacion"];	
			$stmt->closeCursor();				

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
				
			$stmt = $db->prepare("INSERT INTO historial_ubicaciones (id_ubicacion,id_log) VALUES (?,?)");
			$p = 1;
			$stmt->bindParam($p,$id_ubicacion,PDO::PARAM_INT);
			$p++;
			$stmt->bindParam($p,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();			
			
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();		
		}
		

		//echo "$Actualizado-$Insertado1-$Insertado2";
		if (($Actualizado === true)  and ($Insertado1 === true) and ($Insertado2 === true))
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
	
	if($_GET['action'] == 'Eliminar_Ubicacion')	
	{
		session_start();
		$db->beginTransaction();
		
		try
		{		
			$Id_Ubicacion = strip_tags(utf8_decode($_POST['IdUbicacion']));				
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Ubicacion Eliminada";
			$Tipo = "11";			

			$stmt = $db->prepare("SELECT id_ubicacion FROM ubicaciones WHERE MD5(id_ubicacion) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Ubicacion,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_ubicacion = $results[0]["id_ubicacion"];	
			$stmt->closeCursor();
				
			$stmt = $db->prepare("UPDATE ubicaciones SET estatus_ubicacion=0,fecha_actualizado='".date('Y-m-d H:i:s')."' WHERE MD5(id_ubicacion) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Ubicacion,PDO::PARAM_STR,255);

			$Eliminado = $stmt->execute();	
				
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
				
			$stmt = $db->prepare("INSERT INTO historial_ubicaciones (id_ubicacion,id_log) VALUES (?,?)");
			$p = 1;
			$stmt->bindParam($p,$id_ubicacion,PDO::PARAM_INT);
			$p++;
			$stmt->bindParam($p,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();				
				
			$stmt->closeCursor();	

		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
	
		//echo "$Eliminado-$Insertado1-$Insertado2";
	
		if (($Eliminado === true) and ($Insertado1 === true) and ($Insertado2 === true))
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
	
?>
