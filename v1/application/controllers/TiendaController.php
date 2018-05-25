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
	
	if($_GET['action'] == 'Listar_Tienda_Autocompletar')
	{
		$html = "";
		
		if(isset($_POST["Tienda"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["Tienda"])));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;			
		
		
		try
		{
			if((isset($_POST["Tienda"])) and ($_POST["Tienda"] != ""))
			{
				$stmt = $db->prepare("SELECT id_tienda,descripcion_tienda FROM tiendas WHERE descripcion_tienda LIKE '".$criterio."'");			
			}
			else
			{
				$stmt = $db->prepare("SELECT id_tienda,descripcion_tienda FROM tiendas WHERE descripcion_tienda LIKE '".$criterio."%'");
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
			$Tienda = array();
			foreach ($rows as $row)
			{
				$Tienda[$c]['value'] = utf8_encode($row['descripcion_tienda']);
				$Tienda[$c]['hidTienda'] = utf8_encode(base64_encode($row['id_tienda']));
				$c++;
			}
			$html = json_encode($Tienda);
		}
		else
		{
			$html = "null";		
		}
		
		echo $html;
	}	
	

	if($_GET['action'] == 'Listar_Tienda')
	{
		$html = "";		
		try
		{
			$stmt = $db->prepare("SELECT id_tienda,descripcion_tienda FROM tiendas");
			
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
				$html .= "<option value='".base64_encode($row['id_tienda'])."'>".utf8_encode($row['descripcion_tienda'])."</option>";
			}
		}
		
		echo $html;
	}	
	
	if($_GET['action'] == 'Agregar_Tienda')
	{
		session_start();
		$db->beginTransaction();
		
		$Descripcion = strip_tags(utf8_decode($_POST['Descripcion']));
		$Telefono = strip_tags(utf8_decode($_POST['Telefono']));
		$Direccion = strip_tags(utf8_decode($_POST['Direccion']));
		
		try
		{
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Tienda Agregada";
			$Tipo = "1";
						
			$stmt = $db->prepare("INSERT INTO tiendas (descripcion_tienda,telefono,direccion,fecha_agregado)
			VALUES (?,?,?,'".date('Y-m-d H:i:s')."')");		
	
			$p = 1;
			$stmt->bindParam($p,$Descripcion,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Telefono,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Direccion,PDO::PARAM_STR,255);
			
			$Insertado = $stmt->execute();
			//print_r($stmt->errorInfo());
			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Tienda");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Tienda = $results[0]["Id_Tienda"];	

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
			
			$stmt = $db->prepare("INSERT INTO historial_tiendas (id_tienda,id_log) VALUES (?,?)");
			$p = 1;
			$stmt->bindParam($p,$Id_Tienda,PDO::PARAM_INT);
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

	if($_GET['action'] == 'Listar_Tiendas')
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
			array( 'db' => 'id_tienda', 'dt' => 0 ),
			array( 'db' => 'descripcion_tienda',  'dt' => 1 ),
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
			$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS id_tienda,descripcion_tienda,telefono,direccion
			FROM tiendas ".$where.(($where == "")?"WHERE":" AND")." estatus_tienda = 1 ".$order." ".$limit);

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

			$stmt = $db->prepare("SELECT count(id_tienda)
			FROM tiendas WHERE estatus_tienda = 1");			
			
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
				$Data[$f][$c] = utf8_encode($row['descripcion_tienda']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['telefono']);
				$c++;
				$Data[$f][$c]= utf8_encode($row['direccion']);
				$c++;
				
				$Data[$f][$c] = "";				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				{
					$Data[$f][$c] .= '<button type="button" class="btn btn-success btn-circle" onclick="Editar_Tienda('.$f.')" title="Editar Tienda"><i class="fa fa-link"></i></button>&nbsp;';
					$Data[$f][$c] .= '<button type="button" class="btn btn-danger btn-circle" onclick="if(confirm(\'Realmente quieres eliminar esta Tienda?\')){Eliminar_Tienda('.$f.');}" title="Eliminar_Tienda"><i class="fa fa-times"></i></button>&nbsp;';
				}
					

				
				$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_tienda'])).'" />';
				
				$c = $c + 1;
			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;		
		echo json_encode($ResultSet);		
		
	}

	if($_GET['action'] == 'Ver_Tienda')
	{
		try
		{
			$id_tienda = strip_tags(utf8_decode($_POST['IdTienda']));
			$stmt = $db->prepare("SELECT id_tienda,descripcion_tienda,telefono,direccion
			FROM tiendas WHERE  MD5(id_tienda) = ?");
			
			$p = 1;
			$stmt->bindParam($p,$id_tienda,PDO::PARAM_STR,255);			

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
			$Tienda = array();
			foreach ($rows as $row)
			{

				$Tienda[$c]['txtDescripcion'] = utf8_encode($row['descripcion_tienda']);
				$Tienda[$c]['txtTelefono'] = utf8_encode($row['telefono']);
				$Tienda[$c]['txtDireccion'] = utf8_encode($row['direccion']);
				
				$c++;
			}
		}		

		if ($nfilas > 0)
		{
			$response = json_encode($Tienda);
		}		
	
		echo $response;
	
	}

	if($_GET['action'] == 'Actualizar_Tienda')
	{
		session_start();
		$db->beginTransaction();
		
		$Descripcion = strip_tags(utf8_decode($_POST['Descripcion']));
		$Telefono = strip_tags(utf8_decode($_POST['Telefono']));
		$Direccion = strip_tags(utf8_decode($_POST['Direccion']));
		
		$Id_Tienda = strip_tags(utf8_decode($_POST['IdTienda']));		
		$Id_Usuario = base64_decode($_SESSION['id_usuario']);
		$Evento = "Tienda Actualizada";
		$Tipo = "2";

		try
		{		
			
			$stmt = $db->prepare("UPDATE tiendas SET descripcion_tienda=?,telefono=?,direccion=?,fecha_actualizado='".date('Y-m-d H:i:s')."'
			WHERE MD5(id_tienda)=?");
			$p = 1;
			$stmt->bindParam($p,$Descripcion,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Telefono,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Direccion,PDO::PARAM_STR,255);
			$p++;			
			$stmt->bindParam($p,$Id_Tienda,PDO::PARAM_STR,255);			
					
			$Actualizado = $stmt->execute();
		//print_r($stmt->errorInfo());
			$stmt = $db->prepare("SELECT id_tienda FROM tiendas WHERE MD5(id_tienda) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Tienda,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_tienda = $results[0]["id_tienda"];	
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
				
			$stmt = $db->prepare("INSERT INTO historial_tiendas (id_tienda,id_log) VALUES (?,?)");
			$p = 1;
			$stmt->bindParam($p,$id_tienda,PDO::PARAM_INT);
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
	
	if($_GET['action'] == 'Eliminar_Tienda')	
	{
		session_start();
		$db->beginTransaction();
		
		try
		{		
			$Id_Grupo = strip_tags(utf8_decode($_POST['IdGrupo']));				
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Tienda Eliminada";
			$Tipo = "11";			

			$stmt = $db->prepare("SELECT id_tienda FROM tiendas WHERE MD5(id_tienda) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Tienda,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_tienda = $results[0]["id_tienda"];	
			$stmt->closeCursor();
				
			$stmt = $db->prepare("UPDATE tiendas SET estatus_tienda=0,fecha_actualizado='".date('Y-m-d H:i:s')."' WHERE MD5(id_tienda) = ?");
			$p = 1;
			$stmt->bindParam($p,$Id_Tienda,PDO::PARAM_STR,255);

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
				
			$stmt = $db->prepare("INSERT INTO historial_tiendas (id_tienda,id_log) VALUES (?,?)");
			$p = 1;
			$stmt->bindParam($p,$id_tienda,PDO::PARAM_INT);
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
