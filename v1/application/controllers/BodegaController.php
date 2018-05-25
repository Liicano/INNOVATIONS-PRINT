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
	
	if($_GET['action'] == 'Listar_Bodega_Autocompletar')
	{
		$html = "";
		
		if(isset($_POST["Bodega"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["Bodega"])));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);	
		if ((!$criterio) and ($criterio != "0")) return;		
		
		try
		{
			if((isset($_POST["Bodega"])) and ($_POST["Bodega"] != ""))
			{
				$stmt = $db->prepare("SELECT id_bodega,descripcion_bodega FROM bodegas WHERE descripcion_bodega LIKE '".$criterio."'");			
			}
			else
			{
				$stmt = $db->prepare("SELECT id_bodega,descripcion_bodega FROM bodegas WHERE descripcion_bodega LIKE '".$criterio."%'");
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
			$Bodega = array();
			foreach ($rows as $row)
			{
				$Bodega[$c]['value'] = utf8_encode($row['descripcion_bodega']);
				$Bodega[$c]['hidBodega'] = utf8_encode(base64_encode($row['id_bodega']));
				$c++;
			}
			$html = json_encode($Bodega);
		}
		else
		{
			$html = "null";		
		}		
		
		echo $html;
	}	
	

	if($_GET['action'] == 'Listar_Bodega')
	{
		$html = "";		
		try
		{
			$stmt = $db->prepare("SELECT id_bodega,descripcion_bodega FROM bodegas");
			
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
				$html .= "<option value='".base64_encode($row['id_bodega'])."'>".utf8_encode($row['descripcion_bodega'])."</option>";
			}
		}
		
		echo $html;
	}	
		
	if($_GET['action'] == 'Agregar_Bodega')
	{
		session_start();
		$db->beginTransaction();
		
		$Descripcion = strip_tags(utf8_decode($_POST['Descripcion']));
		$Telefono = strip_tags(utf8_decode($_POST['Telefono']));
		$Direccion = strip_tags(utf8_decode($_POST['Direccion']));
		
		try
		{
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Bodega Agregada";
			$Tipo = "1";
						
			$stmt = $db->prepare("INSERT INTO bodegas (descripcion_bodega,telefono,direccion,fecha_agregado)
			VALUES (?,?,?,'".date('Y-m-d H:i:s')."')");		
	
			$p = 1;
			$stmt->bindParam($p,$Descripcion,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Telefono,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Direccion,PDO::PARAM_STR,255);
			
			$Insertado = $stmt->execute();
			//print_r($stmt->errorInfo());
			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Bodega");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Bodega = $results[0]["Id_Bodega"];	

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
			
			$stmt = $db->prepare("INSERT INTO historial_bodegas (id_bodega,id_log) VALUES (?,?)");
			$p = 1;
			$stmt->bindParam($p,$Id_Bodega,PDO::PARAM_INT);
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

	if($_GET['action'] == 'Listar_Bodegas')
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
			array( 'db' => 'id_bodega', 'dt' => 0 ),
			array( 'db' => 'descripcion_bodega',  'dt' => 1 ),
			array( 'db' => 'telefono',   'dt' => 2 ),
			array( 'db' => 'direccion',   'dt' => 3 ),
			array( 'db' => 'opciones',   'dt' => 4 ),
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS id_bodega,descripcion_bodega,telefono,direccion
			FROM bodegas ".$where.(($where == "")?"WHERE":" AND")." estatus_bodega = 1 ".$order." ".$limit);

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

			$stmt = $db->prepare("SELECT count(id_bodega)
			FROM bodegas WHERE estatus_bodega = 1");			
			
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
				$Data[$f][$c] = utf8_encode($row['descripcion_bodega']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['telefono']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['direccion']);
				$c++;
				
				$Data[$f][$c] = "";				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{
					$Data[$f][$c] .= '<button type="button" class="btn btn-success btn-circle" onclick="Editar_Bodega('.$f.')" title="Editar Bodega"><i class="fa fa-edit"></i></button>&nbsp;';
					$Data[$f][$c] .= '<button type="button" class="btn btn-danger btn-circle" onclick="if(confirm(\'Realmente quieres eliminar esta Bodega?\')){Eliminar_Bodega('.$f.');}" title="Eliminar_Bodega"><i class="fa fa-times"></i></button>&nbsp;';
				}
					

				
				$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_bodega'])).'" />';
				
				$f = $f + 1;
			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;		
		echo json_encode($ResultSet);			
		
	}

	if($_GET['action'] == 'Ver_Bodega')
	{
		try
		{
			$id_bodega = strip_tags(utf8_decode($_POST['IdBodega']));
			$stmt = $db->prepare("SELECT id_bodega,descripcion_bodega,telefono,direccion
			FROM bodegas WHERE  MD5(id_bodega) = ?");
			
			$p = 1;
			$stmt->bindParam($p,$id_bodega,PDO::PARAM_STR,255);			

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
			$Bodega = array();
			foreach ($rows as $row)
			{

				$Bodega[$c]['txtDescripcion'] = utf8_encode($row['descripcion_bodega']);
				$Bodega[$c]['txtTelefono'] = utf8_encode($row['telefono']);
				$Bodega[$c]['txtDireccion'] = utf8_encode($row['direccion']);
				
				$c++;
			}
		}		

		if ($nfilas > 0)
		{
			$response = json_encode($Bodega);
		}		
	
		echo $response;
	
	}

	if($_GET['action'] == 'Actualizar_Bodega')
	{
		session_start();
		$db->beginTransaction();
		
		$Descripcion = strip_tags(utf8_decode($_POST['Descripcion']));
		$Telefono = strip_tags(utf8_decode($_POST['Telefono']));
		$Direccion = strip_tags(utf8_decode($_POST['Direccion']));
		
		$Id_Bodega = strip_tags(utf8_decode($_POST['IdBodega']));		
		$Id_Usuario = base64_decode($_SESSION['id_usuario']);
		$Evento = "Bodega Actualizada";
		$Tipo = "2";

		try
		{		
			
			$stmt = $db->prepare("UPDATE bodegas SET descripcion_bodega=?,telefono=?,direccion=?,fecha_actualizado='".date('Y-m-d H:i:s')."'
			WHERE MD5(id_bodega)=?");
			$p = 1;
			$stmt->bindParam($p,$Descripcion,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Telefono,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Direccion,PDO::PARAM_STR,255);
			$p++;			
			$stmt->bindParam($p,$Id_Bodega,PDO::PARAM_STR,255);			
					
			$Actualizado = $stmt->execute();
			//print_r($stmt->errorInfo());
			$stmt = $db->prepare("SELECT id_bodega FROM bodegas WHERE MD5(id_bodega) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Bodega,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_bodega = $results[0]["id_bodega"];	
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
				
			$stmt = $db->prepare("INSERT INTO historial_bodegas (id_bodega,id_log) VALUES (?,?)");
			$p = 1;
			$stmt->bindParam($p,$id_bodega,PDO::PARAM_INT);
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
	
	if($_GET['action'] == 'Eliminar_Bodega')	
	{
		session_start();
		$db->beginTransaction();
		
		try
		{		
			$Id_Grupo = strip_tags(utf8_decode($_POST['IdGrupo']));				
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Bodega Eliminada";
			$Tipo = "11";			

			$stmt = $db->prepare("SELECT id_bodega FROM bodegas WHERE MD5(id_bodega) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Bodega,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_bodega = $results[0]["id_bodega"];	
			$stmt->closeCursor();
				
			$stmt = $db->prepare("UPDATE bodegas SET estatus_bodega=0,fecha_actualizado='".date('Y-m-d H:i:s')."' WHERE MD5(id_bodega) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Bodega,PDO::PARAM_STR,255);

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
				
			$stmt = $db->prepare("INSERT INTO historial_bodegas (id_bodega,id_log) VALUES (?,?)");
			$p = 1;
			$stmt->bindParam($p,$id_bodega,PDO::PARAM_INT);
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
