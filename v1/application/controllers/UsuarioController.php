<?php
	include('../../config/configuracion.php');
	include('../../library/Database.php');		
	//echo date_default_timezone_get();
	date_default_timezone_set ('America/Panama');
	//echo date('d-m-Y H:i');
	if (!isset($_SERVER['HTTP_REFERER']))
	header('Location: ../index.html');

	try {
		$db = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NOMBRE, DB_USER, DB_CLAVE);
		//echo 'Connected to database<br />';
	}
		catch(PDOException $e) {
		echo $e->getMessage();
	}

	if($_GET['action'] == 'Listar_Usuario_Autocompletar')
	{

		$html = "";
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		if(isset($_GET["search"]))		
		$criterio = strtolower($_GET["search"]);
		
		if (!$criterio) return;
		
		try
		{		

			$stmt = $db->prepare("SELECT id_usuario, CONCAT(nombre,' ',apellido) AS value FROM usuarios WHERE  CONCAT(nombre,' ',apellido) LIKE '".$criterio."%'OR usuario LIKE '".$criterio."%'");
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
			$Nombre_Usuario = array();
			foreach ($rows as $row)
			{

				$Nombre_Usuario[$c]['id_usuario'] = utf8_encode($row['id_usuario']);
				$Nombre_Usuario[$c]['value'] = utf8_encode($row['value']);
				
				$c++;
			}		
		}

		$html = json_encode($Nombre_Usuario);
		echo $html;		
	
	}	
	
	if($_GET['action'] == 'Listar_Tipo_Usuario')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM tipo_usuario");
			
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
				$html .= "<option value='".$row['id_tipo_usuario']."'>".utf8_encode($row['descripcion_tipo_usuario'])."</option>";
			}
		}
		
		echo $html;
	}

	if($_GET['action'] == 'Listar_Estatus_Usuario')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM tipo_estatus_usuario");
			
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
				$html .= "<option value='".$row['id_estatus']."'>".utf8_encode($row['descripcion_estatus'])."</option>";
			}
		}
		
		echo $html;
	}

	if($_GET['action'] == 'Agregar_Usuario')
	{
	
		session_start();
		$db->beginTransaction();
		try
		{
				
			$NombreUsuario	= strip_tags(utf8_decode($_POST['NombreUsuario']));
			$ApellidoUsuario = strip_tags(utf8_decode($_POST['ApellidoUsuario']));
			$DescripcionUsuario = strip_tags(utf8_decode($_POST['DescripcionUsuario']));
			$Usuario = strip_tags(utf8_decode($_POST['Usuario']));
			$Clave = strip_tags(utf8_decode($_POST['Clave']));
			$TipoUsuario = strip_tags(utf8_decode($_POST['TipoUsuario']));			
			$EstatusUsuario = strip_tags(utf8_decode($_POST['EstatusUsuario']));

			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Usuario Agregado";
			$Tipo = "18";

			$stmt = $db->prepare("INSERT INTO usuarios (usuario,clave,nombre,apellido,posicion,id_tipo_usuario,id_estatus,fecha_agregado)
			VALUES (?,?,?,?,?,?,?,NOW())");
			$c = 1;
			$stmt->bindParam($c,$Usuario,PDO::PARAM_STR,255);			
			$c++;
			$stmt->bindParam($c,$Clave,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$NombreUsuario,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$ApellidoUsuario,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$DescripcionUsuario,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$TipoUsuario,PDO::PARAM_INT);	
			$c++;
			$stmt->bindParam($c,$EstatusUsuario,PDO::PARAM_INT);				
					
			$Insertado = $stmt->execute();
			
			//print_r($stmt->errorInfo());
			//echo "INSERT INTO usuarios (usuarios,clave,nombre,apellido,posicion,id_tipo_usuario,id_estatus,fecha_agregado)
			//VALUES (".$Usuario.",".$Clave.","..","..","..","..","..",NOW())";

			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Usuario");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Usuario_Editado = $results[0]["Id_Usuario"];	

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
				
			$stmt = $db->prepare("INSERT INTO historial_usuario (id_usuario,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$Id_Usuario_Editado,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();			
				
			$stmt->closeCursor();

		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		//echo "$Insertado-$Insertado1-$Insertado2";
		if (($Insertado === true) and ($Insertado1 === true) and ($Insertado2 === true))
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

	if($_GET['action'] == 'Listar_Usuarios')
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
			array( 'db' => 'id_usuario', 'dt' => 0 ),
			array( 'db' => 'nombre',  'dt' => 1 ),
			array( 'db' => 'apellido',   'dt' => 2 ),
			array( 'db' => 'posicion',   'dt' => 3 ),
			array( 'db' => 'usuario',   'dt' => 4 ),
			array( 'db' => 'clave',   'dt' => 5 ),
			array( 'db' => 'descripcion_tipo_usuario',   'dt' => 6 ),
			array( 'db' => 'descripcion_estatus',   'dt' => 7 ),	
			array( 'db' => 'opciones',   'dt' => 8 )		
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];

		
		try
		{		
			$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS id_usuario,nombre,apellido,posicion,usuario,clave,descripcion_tipo_usuario,descripcion_estatus,u.id_tipo_usuario,u.id_estatus FROM usuarios u
			INNER JOIN tipo_usuario tu ON (tu.id_tipo_usuario = u.id_tipo_usuario)
			INNER JOIN tipo_estatus_usuario eu ON (eu.id_estatus = u.id_estatus) ".$where." ".$order." ".$limit);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			
			if ( is_array( $bindings ) ) {
				for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
					$binding = $bindings[$i];
									
					$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
				}
			}			
			
			$stmt = $db->prepare("SELECT FOUND_ROWS()");
			
			$stmt->execute();
			$resFilterLength = $stmt->fetchColumn (0);

			$stmt = $db->prepare("SELECT count(id_usuario)
			FROM usuarios u
			INNER JOIN tipo_usuario tu ON (tu.id_tipo_usuario = u.id_tipo_usuario)
			INNER JOIN tipo_estatus_usuario eu ON (eu.id_estatus = u.id_estatus)");			
				
			$stmt->execute();			
			$recordsTotal = $stmt->fetchColumn (0);
			
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
			
		/*$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable"><thead><tr>';			

		$html .= '<th style="width:2%"></th>
				<th style="width:15%">Nombre
				<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
				<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
				<th style="width:15%">Apellido</th>
				<th style="width:16%">Descripci&oacute;n del Usuario</th>
				<th style="width:10%">Usuario</th>
				<th style="width:10%">Clave</th>
				<th style="width:10%">Tipo de Usuario</th>				
				<th style="width:10%">Estatus de Usuario</th>';
				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
				$html .='<th style="width:13%">Opciones</th>';	

		$html .= '</tr>
            </thead>
            <tbody>';
			  			  
			  

		if ($nfilas > 0)
		{
				
			$c = 1;
			foreach ($rows as $row)
			{
							
				$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
						<td>'.$c.'</td>
						<td>'.utf8_encode($row['nombre']).'<input type="hidden" id="hidNombreUsuario'.$c.'" name="hidNombreUsuario[]" value="'.utf8_encode($row['nombre']).'" /></td>
						<td>'.utf8_encode($row['apellido']).'<input type="hidden" id="hidApellidoUsuario'.$c.'" name="hidApellidoUsuario[]" value="'.utf8_encode($row['apellido']).'" /></td>						
						<td>'.utf8_encode($row['posicion']).'<input type="hidden" id="hidDescripcionUsuario'.$c.'" name="hidDescripcionUsuario[]" value="'.utf8_encode($row['posicion']).'" /></td>
						<td>'.utf8_encode($row['usuario']).'<input type="hidden" id="hidUsuario'.$c.'" name="hidUsuario[]" value="'.utf8_encode($row['usuario']).'" /></td>
						<td style="overflow:hidden"><input type="password" id="txtClave'.$c.'" name="txtClave[]" value="'.utf8_encode($row['clave']).'" readonly="readonly"/></td>						
						<td>'.utf8_encode($row['descripcion_tipo_usuario']).'<input type="hidden" id="hidTipoUsuario'.$c.'" name="hidTipoUsuario[]" value="'.utf8_encode($row['id_tipo_usuario']).'" /><input type="hidden" id="hidDescTipoUsuario'.$c.'" name="hidDescTipoUsuario[]" value="'.utf8_encode($row['descripcion_tipo_usuario']).'" /></td>
						<td>'.utf8_encode($row['descripcion_estatus']).'<input type="hidden" id="hidEstatusUsuario'.$c.'" name="hidEstatusUsuario[]" value="'.utf8_encode($row['id_estatus']).'" /><input type="hidden" id="hidDescEstatusUsuario'.$c.'" name="hidDescEstatusUsuario[]" value="'.utf8_encode($row['descripcion_estatus']).'" />';
					
					if (base64_decode($_SESSION['id_tipo_usuario']) == 1)							
					$html .='</td><td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Usuario('.$c.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
						
					$html .='<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_usuario'])).'" /></td>';					
					$html .='</tr>';
					
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
				$Data[$f][$c] = utf8_encode($row['nombre']).'<input type="hidden" id="hidNombreUsuario'.$f.'" name="hidNombreUsuario[]" value="'.utf8_encode($row['nombre']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['apellido']).'<input type="hidden" id="hidApellidoUsuario'.$f.'" name="hidApellidoUsuario[]" value="'.utf8_encode($row['apellido']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['posicion']).'<input type="hidden" id="hidDescripcionUsuario'.$f.'" name="hidDescripcionUsuario[]" value="'.utf8_encode($row['posicion']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['usuario']).'<input type="hidden" id="hidUsuario'.$f.'" name="hidUsuario[]" value="'.utf8_encode($row['usuario']).'" />';
				$c++;
				$Data[$f][$c] = '<input type="password" id="txtClave'.$f.'" name="txtClave[]" value="'.utf8_encode($row['clave']).'" readonly="readonly"/>';
				$c++;
				$Data[$f][$c] = utf8_encode($row['descripcion_tipo_usuario']).'<input type="hidden" id="hidTipoUsuario'.$f.'" name="hidTipoUsuario[]" value="'.utf8_encode($row['id_tipo_usuario']).'" /><input type="hidden" id="hidDescTipoUsuario'.$f.'" name="hidDescTipoUsuario[]" value="'.utf8_encode($row['descripcion_tipo_usuario']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['descripcion_estatus']).'<input type="hidden" id="hidEstatusUsuario'.$f.'" name="hidEstatusUsuario[]" value="'.utf8_encode($row['id_estatus']).'" /><input type="hidden" id="hidDescEstatusUsuario'.$f.'" name="hidDescEstatusUsuario[]" value="'.utf8_encode($row['descripcion_estatus']).'" />';
				$c++;
				
				$Data[$f][$c] = "";
			
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				$Data[$f][$c] .= '<a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Usuario('.$f.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
				$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_usuario'])).'" />';
				
				$f = $f + 1;
			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;		
		echo json_encode($ResultSet);	
		
	}
	
	if($_GET['action'] == 'Actualizar_Usuario')
	{
	
		session_start();	
		$db->beginTransaction();
		try
		{
			// print_r($_POST);	

			$NombreUsuario	= strip_tags(utf8_decode($_POST['NombreUsuario']));
			$ApellidoUsuario = strip_tags(utf8_decode($_POST['ApellidoUsuario']));
			$DescripcionUsuario = strip_tags(utf8_decode($_POST['DescripcionUsuario']));
			$Usuario = strip_tags(utf8_decode($_POST['Usuario']));
			$Clave = strip_tags(utf8_decode($_POST['Clave']));
			$TipoUsuario = strip_tags(utf8_decode($_POST['TipoUsuario']));			
			$EstatusUsuario = strip_tags(utf8_decode($_POST['EstatusUsuario']));	
			$Id_Usuario_Editado = strip_tags(utf8_decode($_POST['IdUsuario']));
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Usuario Actualizado";
			$Tipo = "19";

			if ($EstatusUsuario == 2)
			{
				$stmt = $db->prepare("UPDATE usuarios SET nombre=?,apellido=?,posicion=?,usuario=?,clave=?,id_tipo_usuario=?,id_estatus=?,ultima_actualizacion=NOW(),fecha_inactivado=NOW() 
				WHERE MD5(id_usuario)=?");			
			}
			else
			{
				$stmt = $db->prepare("UPDATE usuarios SET nombre=?,apellido=?,posicion=?,usuario=?,clave=?,id_tipo_usuario=?,id_estatus=?,fecha_actualizado=NOW()
				WHERE MD5(id_usuario)=?");
			}
			
			$c = 1;
			$stmt->bindParam($c,$NombreUsuario,PDO::PARAM_STR,255);			
			$c++;
			$stmt->bindParam($c,$ApellidoUsuario,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$DescripcionUsuario,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Usuario,PDO::PARAM_STR,255);
			$c++;			
			$stmt->bindParam($c,$Clave,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$TipoUsuario,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$EstatusUsuario,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Usuario_Editado,PDO::PARAM_STR,255);			
					
			$Actualizado = $stmt->execute();
			// print_r($stmt->errorInfo());
		
		
			$stmt = $db->prepare("SELECT * FROM usuarios WHERE md5(id_usuario) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Usuario_Editado,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_usuario = $results[0]["id_usuario"];	
			$stmt->closeCursor();				

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
				
			$stmt = $db->prepare("INSERT INTO historial_usuario (id_usuario,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();			
				
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();		
		}
		

		//echo "$Actualizado-$Insertado1-$Insertado2";		
		if (($Actualizado === true) && ($Insertado1 === true) && ($Insertado2 === true))
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