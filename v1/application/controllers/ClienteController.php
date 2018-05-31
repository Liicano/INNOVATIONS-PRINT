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

	if($_GET['action'] == 'Listar_Tipo_Cliente')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM tipo_cliente");
			
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
				$html .= "<option value='".$row['id_tipo_cliente']."'>".utf8_encode($row['descripcion_tipo_cliente'])."</option>";
			}
		}
		
		echo $html;
	}


	if ($_GET['action'] == 'subir_logotipo') {
		
		$ruta="../../public/images/logotipos/";
		foreach ($_FILES as $key) {
			if($key['error'] == UPLOAD_ERR_OK )
			{//Verificamos si se subio correctamente
				$nombre = $key['name'];//Obtenemos el nombre del archivo
				$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
				//$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
				$tamano= $key['size']; //Obtenemos el tamaño en KB
				move_uploaded_file($temporal, $ruta . $nombre); //Movemos el archivo temporal a la ruta especificada
				//El echo es para que lo reciba jquery y lo ponga en el div "cargados"
			
				
		}
	}
	echo "true";
	}

	
	if($_GET['action'] == 'Agregar_Cliente')
	{
		session_start();
		$db->beginTransaction();
		
		if ($_POST['TipoCliente'] == "1")
		{
			try
			{
				
				$Nombre	= strip_tags(utf8_decode($_POST['NombreCliente']));
				$Apellido =strip_tags(utf8_decode($_POST['ApellidoCliente']));
				$Telefono = strip_tags(utf8_decode($_POST['Telefono']));
				$Celular = strip_tags(utf8_decode($_POST['Celular']));
				$Email = strip_tags(utf8_decode($_POST['Email']));
				$Direccion = strip_tags(utf8_decode($_POST['Direccion']));
				$Credito = strip_tags(utf8_decode($_POST['Credito']));
				$Id_Usuario = base64_decode($_SESSION['id_usuario']);
				$Evento = "Cliente Persona Agregado";
				$Tipo = "1";


				$stmt = $db->prepare("INSERT INTO cliente_persona (nombre,apellido,telefono,celular,email,direccion,credito,fecha_creado)
				VALUES (?,?,?,?,?,?,?,NOW())");
				$c = 1;
				$stmt->bindParam($c,$Nombre,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Apellido,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Telefono,PDO::PARAM_STR,14);
				$c++;
				$stmt->bindParam($c,$Celular,PDO::PARAM_STR,15);
				$c++;
				$stmt->bindParam($c,$Email,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Direccion,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Credito,PDO::PARAM_INT);				
					
				$Insertado = $stmt->execute();

				
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
	
				$Insertado1 = $stmt->execute();
				
				$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Log");
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$Id_Log = $results[0]["Id_Log"];
				
				$stmt = $db->prepare("INSERT INTO historial_cliente_persona (id_cliente_persona,id_log) VALUES (?,?)");
				$c = 1;
				$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
				$Insertado2 = $stmt->execute();				
				
				$stmt->closeCursor();
				
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}			
 						
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
		else if ($_POST['TipoCliente'] == "2")
		{
			
			try
			{	
				
				
				$NombreEmpresa	= strip_tags(utf8_decode($_POST['NombreEmpresa']));
				$RUC1 = strip_tags(utf8_decode($_POST['RUC1']));
				$RUC2 = strip_tags(utf8_decode($_POST['RUC2']));
				$RUC3 = strip_tags(utf8_decode($_POST['RUC3']));
				$DV = strip_tags(utf8_decode($_POST['DV']));				
				$Telefono = strip_tags(utf8_decode($_POST['Telefono']));
				$Celular = strip_tags(utf8_decode($_POST['Celular']));
				$Email = strip_tags(utf8_decode($_POST['Email']));
				$Direccion = strip_tags(utf8_decode($_POST['Direccion']));
				$Credito = strip_tags(utf8_decode($_POST['Credito']));
				$Id_Usuario = base64_decode($_SESSION['id_usuario']);
				$Evento = "Cliente Empresa Agregado";
				$Tipo = "2";
				$Logo = strip_tags(utf8_decode($_POST['Logo']));
				$Logo = ($Logo == 'NULL') ? 'logo.png' : $Logo;
				 

				$stmt = $db->prepare("INSERT INTO cliente_empresa (nombre_empresa, logo_empresa,ruc_parte_1,ruc_parte_2,ruc_parte_3,dv,telefono,celular,email,direccion,credito,fecha_creado)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,NOW())");		
		
				$c = 1;
				$stmt->bindParam($c,$NombreEmpresa,PDO::PARAM_STR,255);
				$c++;
				 $stmt->bindParam($c,$Logo,PDO::PARAM_STR,255);
				 $c++;
				$stmt->bindParam($c,$RUC1,PDO::PARAM_INT);				
				$c++;
				$stmt->bindParam($c,$RUC2,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$RUC3,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$DV,PDO::PARAM_INT);				
				$c++;
				$stmt->bindParam($c,$Telefono,PDO::PARAM_STR,14);
				$c++;
				$stmt->bindParam($c,$Celular,PDO::PARAM_STR,15);
				$c++;
				$stmt->bindParam($c,$Email,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Direccion,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Credito,PDO::PARAM_INT);			

				$Insertado = $stmt->execute();

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
	
				$Insertado1 = $stmt->execute();
				
				$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Log");
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$Id_Log = $results[0]["Id_Log"];
				
				$stmt = $db->prepare("INSERT INTO historial_cliente_empresa (id_cliente_empresa,id_log) VALUES (?,?)");
				$c = 1;
				$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
				$Insertado2 = $stmt->execute();
				
				if ($Insertado)
				{	
					$NombreContacto = explode(',',$_POST['NombreContacto']);	
					$TelefonoContacto = explode(',',$_POST['TelefonoContacto']);
					$CelularContacto = explode(',',$_POST['CelularContacto']);
					$EmailContacto = explode(',',$_POST['EmailContacto']);
			
					$f = 0; $CantContacto = 0;
					while ($f < count($NombreContacto))
					{					
						$Nombre_Contacto	= strip_tags(utf8_decode($NombreContacto[$f]));
						$Telefono_Contacto = strip_tags(utf8_decode($TelefonoContacto[$f]));
						$Celular_Contacto = strip_tags(utf8_decode($CelularContacto[$f]));
						$Email_Contacto = strip_tags(utf8_decode($EmailContacto[$f]));					
				
						$stmt = $db->prepare("INSERT INTO cliente_empresa_contactos (id_cliente_empresa,nombre_de_contacto,telefono_de_contacto,celular_de_contacto,email_de_contacto,fecha_creado)
						VALUES (?,?,?,?,?,NOW())");
						$c = 1;
						$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_INT);
						$c++;
						$stmt->bindParam($c,$Nombre_Contacto,PDO::PARAM_STR,255);
						$c++;
						$stmt->bindParam($c,$Telefono_Contacto,PDO::PARAM_STR,14);
						$c++;
						$stmt->bindParam($c,$Celular_Contacto,PDO::PARAM_STR,15);
						$c++;
						$stmt->bindParam($c,$Email_Contacto,PDO::PARAM_STR,255);						
				
						$Insertado3 = $stmt->execute();				
				
						$CantContacto = $Insertado3  + $CantContacto ;
						
						$f = $f + 1;
					}				
				
				}
				
				$stmt->closeCursor();				
			
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}		
			
			// echo "".$Insertado."-".$Insertado1."-".$Insertado2."-".$CantContacto."-".count($NombreContacto);
			
			//echo count($NombreContacto);
			if (($Insertado === true)  and ($Insertado1 === true) and ($Insertado2 === true) and ($CantContacto > 0) and (count($NombreContacto) == $CantContacto))
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
	}
	




if($_GET['action'] == 'Ver_Logotipo')
{

	$id_cliente = $_POST['id_cliente'];
	$resp = array();


	$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS id_cliente,nombre_empresa,logo_empresa,ruc_parte_1,ruc_parte_2,ruc_parte_3,ruc,dv,telefono,celular,email,direccion,credito
	FROM (SELECT ce.id_cliente,ce.nombre_empresa,ce.logo_empresa,ce.ruc_parte_1,ce.ruc_parte_2,ce.ruc_parte_3,CONCAT(ce.ruc_parte_1,' ',ce.ruc_parte_2,' ',ce.ruc_parte_3) AS ruc,ce.dv,ce.telefono,ce.celular,ce.email,ce.direccion,ce.credito		
	FROM cliente_empresa ce) AS T WHERE id_cliente = '$id_cliente' ");



	$stmt->execute();
	$cliente = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$resp = json_encode($cliente);
	echo $resp;
}


	if($_GET['action'] == 'Listar_Cliente')
	{
		$html = "";
		session_start();
		$objDatabase = new Database();
		$bindings = array();
		$ResultSet = array();
		$Length = ($_POST['length']);
		$Start = ($_POST['start']);
		$Draw = ($_POST['draw']);	
		
		$TipoCliente = $_POST['TipoCliente'];
		
		$limit = $objDatabase->limit($_POST);		
		
		if($TipoCliente == 1)
		{
			$columns = array(
				array( 'db' => 'id_cliente', 'dt' => 0 ),
				array( 'db' => 'nombre',  'dt' => 1 ),
				array( 'db' => 'apellido',   'dt' => 2 ),
				array( 'db' => 'telefono',   'dt' => 3 ),
				array( 'db' => 'celular',   'dt' => 4 ),
				array( 'db' => 'email',   'dt' => 5 ),				
				array( 'db' => 'direccion',   'dt' => 6 ),
				array( 'db' => 'credito',   'dt' => 7 ),
				array( 'db' => 'creado_actualizado_por',   'dt' => 8 ),
				array( 'db' => 'opciones',   'dt' => 9 ),			
			);
		}
		else
		{
			$columns = array(
				array( 'db' => 'id_cliente', 'dt' => 0 ),
				array( 'db' => 'nombre_empresa',  'dt' => 1 ),
				array( 'db' => 'ruc',   'dt' => 2 ),
				array( 'db' => 'dv',   'dt' => 3 ),
				array( 'db' => 'telefono',   'dt' => 4 ),
				array( 'db' => 'celular',   'dt' => 5 ),
				array( 'db' => 'email',   'dt' => 6 ),				
				array( 'db' => 'direccion',   'dt' => 7 ),				
				array( 'db' => 'credito',   'dt' => 8 ),
				array( 'db' => 'creado_actualizado_por',   'dt' => 9 ),
				array( 'db' => 'opciones',   'dt' => 10 ),
				array( 'db' => 'logo_empresa',   'dt' => 11 ),			
			);			 
			
		}

		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			if ($TipoCliente == 1)
			{
				$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS cp.id_cliente,cp.nombre,cp.apellido,cp.telefono,cp.celular,cp.email,cp.direccion,cp.credito		
				FROM cliente_persona cp ".$where." ".$order." ".$limit);
			}
			else
			{
				$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS id_cliente,nombre_empresa,logo_empresa,ruc_parte_1,ruc_parte_2,ruc_parte_3,ruc,dv,telefono,celular,email,direccion,credito
				FROM (SELECT ce.id_cliente,ce.nombre_empresa,ce.logo_empresa,ce.ruc_parte_1,ce.ruc_parte_2,ce.ruc_parte_3,CONCAT(ce.ruc_parte_1,' ',ce.ruc_parte_2,' ',ce.ruc_parte_3) AS ruc,ce.dv,ce.telefono,ce.celular,ce.email,ce.direccion,ce.credito		
				FROM cliente_empresa ce) AS T ".$where." ".$order." ".$limit);
			}

			//$c = 1;
			//$stmt->bindParam($c,$TipoCliente,PDO::PARAM_INT);

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
			
			if ($TipoCliente == 1)
			{
				$stmt = $db->prepare("SELECT COUNT(cp.id_cliente)		
				FROM cliente_persona cp");
			}
			else
			{
				$stmt = $db->prepare("SELECT COUNT(ce.id_cliente)		
				FROM cliente_empresa ce");
			}

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
				$Id_Cliente = $row['id_cliente'];

				if ($_POST['TipoCliente'] == 1)
				{					
					
					try
					{
						$stmt = $db->prepare("SELECT CONCAT(nombre,' ',apellido) AS Creado_Por, usuario, u.id_usuario FROM historial_cliente_persona hcp
						INNER JOIN user_log ul ON (hcp.id_log = ul.id_log)
						INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
						WHERE  tipo = 1 AND hcp.id_cliente_persona = ?");	
						
						$d = 1;
						$stmt->bindParam($d,$Id_Cliente,PDO::PARAM_INT);						
						
						$stmt->execute();
						$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						//$nfilas = $stmt->rowCount();
						$stmt->closeCursor();
				
						$Creado_Por =$rows1[0]['usuario'];
						
						$stmt = $db->prepare("SELECT CONCAT(nombre,' ',apellido) AS Actualizado_Por, usuario, u.id_usuario FROM historial_cliente_persona hcp
						INNER JOIN user_log ul ON (hcp.id_log = ul.id_log)
						INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
						WHERE tipo = 5 AND hcp.id_cliente_persona = ?
						ORDER BY fecha_log DESC LIMIT 0,1");
						
						$d = 1;
						$stmt->bindParam($d,$Id_Cliente,PDO::PARAM_INT);						
						
						$stmt->execute();
						$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						//$nfilas = $stmt->rowCount();
						$stmt->closeCursor();

						$Actualizado_Por =$rows2[0]['usuario'];	


					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}
					
					$Data[$f][$c] = $f+1;
					$c++;
					$Data[$f][$c] = utf8_encode($row['nombre']).'<input type="hidden" id="hidNombreCliente'.$f.'" name="hidNombreCliente[]" value="'.utf8_encode($row['nombre']).'" />';
					$c++;
					$Data[$f][$c] = utf8_encode($row['apellido']).'<input type="hidden" id="hidApellidoCliente'.$f.'" name="hidApellidoCliente[]" value="'.utf8_encode($row['apellido']).'" />';
					$c++;
					$Data[$f][$c] = utf8_encode($row['telefono']).'<input type="hidden" id="hidTelefono'.$f.'" name="hidTelefono[]" value="'.utf8_encode($row['telefono']).'" />';	
					$c++;
					$Data[$f][$c] = utf8_encode($row['celular']).'<input type="hidden" id="hidCelular'.$f.'" name="hidCelular[]" value="'.utf8_encode($row['celular']).'" />';
					$c++;
					$Data[$f][$c] = utf8_encode($row['email']).'<input type="hidden" id="hidEmail'.$f.'" name="hidEmail[]" value="'.utf8_encode($row['email']).'" />';
					$c++;
					$Data[$f][$c] = utf8_encode($row['direccion']).'<input type="hidden" id="hidDireccion'.$f.'" name="hidDireccion[]" value="'.utf8_encode($row['direccion']).'" />';
					$c++;
					$Data[$f][$c] = utf8_encode(($row['credito']==1)?"Sí":"No").'<input type="hidden" id="hidCredito'.$f.'" name="hidCredito[]" value="'.utf8_encode(($row['credito']==1)?"Sí":"No").'" />';
					$c++;

					$Data[$f][$c] = utf8_encode($Creado_Por.(($Actualizado_Por)?' / '.utf8_encode($Actualizado_Por):'')).'<input type="hidden" id="hidCreadoPor'.$f.'" name="hidCreadoPor[]" value="'.utf8_encode($Creado_Por).'" /><input type="hidden" id="hidActualizadoPor'.$f.'" name="hidActualizadoPor[]" value="'.utf8_encode($Actualizado_Por).'" />';
					$c++;
					
					$Data[$f][$c] = "";	
					$Data[$f][$c] .= '<a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Cliente('.$f.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
					
					if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
					$Data[$f][$c] .='<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Cliente - Persona?\')){Eliminar_Cliente('.$f.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					
					$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_cliente'])).'" />';

				}
				else
				{
								
					try
					{
						$stmt = $db->prepare("SELECT CONCAT(u.nombre,' ',u.apellido) AS Creado_Por, u.usuario, u.id_usuario FROM historial_cliente_empresa hce
						INNER JOIN user_log ul ON (hce.id_log = ul.id_log)
						INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
						WHERE ul.tipo = 2 AND hce.id_cliente_empresa = ?");
						
						$d = 1;
						$stmt->bindParam($d,$Id_Cliente,PDO::PARAM_INT);						
						
						$stmt->execute();
						$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						//$nfilas = $stmt->rowCount();
						$stmt->closeCursor();
						
						$Creado_Por =$rows1[0]['usuario'];
						
						$stmt = $db->prepare("SELECT CONCAT(u.nombre,' ',u.apellido) AS Creado_Por, u.usuario, u.id_usuario FROM historial_cliente_empresa hce
						INNER JOIN user_log ul ON (hce.id_log = ul.id_log)
						INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
						WHERE ul.tipo = 6 AND hce.id_cliente_empresa = ?");
						
						$d = 1;
						$stmt->bindParam($d,$Id_Cliente,PDO::PARAM_INT);						
						
						$stmt->execute();
						$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						//$nfilas = $stmt->rowCount();
						$stmt->closeCursor();

						$Actualizado_Por =$rows2[0]['usuario'];						
					}
					catch(PDOException $e) {
						echo $e->getMessage();
					}					

					$Data[$f][$c] = $f+1;
					$c++;

					$Data[$f][$c] = utf8_encode($row['nombre_empresa']).'<input type="hidden" id="hidNombreEmpresa'.$f.'" name="hidNombreEmpresa[]" value="'.utf8_encode($row['nombre_empresa']).'" />';
					$c++;
					$Data[$f][$c] = utf8_encode($row['ruc_parte_1']."-".$row['ruc_parte_2']."-".$row['ruc_parte_3']).'<input type="hidden" id="hidRUC'.$f.'" name="hidRUC[]" value="'.utf8_encode($row['ruc_parte_1']."-".$row['ruc_parte_2']."-".$row['ruc_parte_3']).'" />';
					$c++;
					$Data[$f][$c] = utf8_encode($row['dv']).'<input type="hidden" id="hidDV'.$f.'" name="hidDV[]" value="'.utf8_encode($row['dv']).'" />';	
					$c++;
					$Data[$f][$c] = utf8_encode($row['telefono']).'<input type="hidden" id="hidTelefono'.$f.'" name="hidTelefono[]" value="'.utf8_encode($row['telefono']).'" />';
					$c++;
					$Data[$f][$c] = utf8_encode($row['celular']).'<input type="hidden" id="hidCelular'.$f.'" name="hidCelular[]" value="'.utf8_encode($row['celular']).'" />';
					$c++;
					$Data[$f][$c] = utf8_encode($row['email']).'<input type="hidden" id="hidEmail'.$f.'" name="hidEmail[]" value="'.utf8_encode($row['email']).'" />';
					$c++;
					$Data[$f][$c] = utf8_encode($row['direccion']).'<input type="hidden" id="hidDireccion'.$f.'" name="hidDireccion[]" value="'.utf8_encode($row['direccion']).'" />';
					$c++;
					$Data[$f][$c] = utf8_encode(($row['credito']==1)?"Si":"No").'<input type="hidden" id="hidCredito'.$f.'" name="hidCredito[]" value="'.utf8_encode(($row['credito']==1)?"Sí":"No").'" />';
					$c++;

					
					$Data[$f][$c] = utf8_encode($Creado_Por.(($Actualizado_Por)?' / '.utf8_encode($Actualizado_Por):'')).'<input type="hidden" id="hidCreadoPor'.$f.'" name="hidCreadoPor[]" value="'.utf8_encode($Creado_Por).'" /><input type="hidden" id="hidActualizadoPor'.$f.'" name="hidActualizadoPor[]" value="'.utf8_encode($Actualizado_Por).'" />';
					$c++;

					// =========

					$row['logo_empresa'] = ($row['logo_empresa'] == NULL)?'logo.png':$row['logo_empresa'];
					$hay_logotipo = ($row['logo_empresa'] == 'logo.png') ? 'NO' : 'SI';

					if ($hay_logotipo == 'SI') {
						$Data[$f][$c] = '<p class="text-center" id ="LogoValue'.$f.'" value="'.$row['logo_empresa'].'"><b><img src="public/images/icons/taskProgress.png" alt="" class="icon"/> SI </b></p><input type="hidden" id="LogoHidden'.$f.'" value="SI">';
					}else{
						$Data[$f][$c] = '<p class="text-center" id ="LogoValue'.$f.'" value="'.$row['logo_empresa'].'"><b><img src="public/images/icons/taskDone.png" alt="" class="icon"/> NO </b></p><input type="hidden" id="LogoHidden'.$f.'" value="NO">';
					}
					$c++;
					// =========
					
					$Data[$f][$c] = "";	

					$Data[$f][$c] .= '<a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Cliente('.$f.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
					$Data[$f][$c] .= '<a href="javascript:void(0);" title="Editar Contactos" class="smallButton" style="margin: 5px;" onclick="Editar_Contacto_Listado('.$f.');"><img src="public/images/icons/light/user.png" alt="" class="icon" /><span></span></a>';

					if ($hay_logotipo == 'SI') {
						$Data[$f][$c] .= '<a title="Ver Logo" id="verLogo'.$row['id_cliente'].'" class="smallButton" style="margin: 5px;" onclick="verLogo('.$row['id_cliente'].');"><img src="public/images/icons/light/image.png" alt="" class="icon"/><span></span></a>';
					}
					
					
							
					
					if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
					$Data[$f][$c] .='<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Cliente - Empresa?\')){Eliminar_Cliente('.$f.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					
					$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_cliente'])).'" />';			
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

	if($_GET['action'] == 'Ultimos_Clientes')
	{
		try
		{		
			$stmt = $db->prepare("(SELECT CONCAT(nombre,' ',apellido) AS Nombre_Cliente, telefono, celular, fecha_creado 
			FROM cliente_persona)
			UNION
			(SELECT nombre_empresa AS Nombre_Cliente, telefono, celular, fecha_creado
			FROM cliente_empresa)
			ORDER BY fecha_creado DESC LIMIT 0,10");
			
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
				$html .= '<li>
                            <a href="#" title="" class="floatL"><img src="public/images/user.png" alt="" /></a>
                            <div class="pInfo">
                                <a href="#" title=""><strong>'.utf8_encode($row['Nombre_Cliente']).'</strong></a>
                                <i></i>	
                            </div>
                            <div class="pLinks">
                                <a href="#" title="Direct call" class="tipW"><img src="public/images/icons/pSkype.png" alt="" /></a>
                                <a href="#" title="Send an email" class="tipW"><img src="public/images/icons/pEmail.png" alt="" /></a>
                            </div>
                            <div class="clear"></div>
                        </li>';			
			
			
			
			
			}
		}
		
		echo $html;
	}
	
	if($_GET['action'] == 'Actualizar_Cliente')
	{

		session_start();
		$db->beginTransaction();
		$Id_Cliente = strip_tags(utf8_decode($_POST['IdCliente']));				
		$Id_Usuario = base64_decode($_SESSION['id_usuario']);		
		if ($_POST['TipoCliente'] == 1)
		{			
			
			try
			{
				
				$Nombre	= strip_tags(utf8_decode($_POST['NombreCliente']));
				$Apellido = strip_tags(utf8_decode($_POST['ApellidoCliente']));
				$Telefono = strip_tags(utf8_decode($_POST['Telefono']));
				$Celular = strip_tags(utf8_decode($_POST['Celular']));
				$Email = strip_tags(utf8_decode($_POST['Email']));
				$Direccion = strip_tags(utf8_decode($_POST['Direccion']));
				$Credito = strip_tags(utf8_decode($_POST['Credito']));
				$Evento = "Cliente Persona Actualizado";
				$Tipo = "5";

				$stmt = $db->prepare("UPDATE cliente_persona SET nombre=?,apellido=?,telefono=?,celular=?,email=?,direccion=?,credito=?,ultima_actualizacion=NOW()
				WHERE MD5(id_cliente)=?");
				$c = 1;
				$stmt->bindParam($c,$Nombre,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Apellido,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Telefono,PDO::PARAM_STR,14);
				$c++;
				$stmt->bindParam($c,$Celular,PDO::PARAM_STR,15);
				$c++;
				$stmt->bindParam($c,$Email,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Direccion,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Credito,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_STR,255);				
					
				$Actualizado = $stmt->execute();

				$stmt = $db->prepare("SELECT * FROM cliente_persona WHERE md5(id_cliente) = ?");
				$c = 1;
				$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_STR,255);
				$stmt->execute();				
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$id_cliente = $results[0]["id_cliente"];	
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
				
				$stmt = $db->prepare("INSERT INTO historial_cliente_persona (id_cliente_persona,id_log) VALUES (?,?)");
				$c = 1;
				$stmt->bindParam($c,$id_cliente,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
				$Insertado2 = $stmt->execute();				
				
				$stmt->closeCursor();

			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}			

		}
		else
		{
			
			try
			{
				
				$NombreEmpresa	= strip_tags(utf8_decode($_POST['NombreEmpresa']));
				$RUC1 = strip_tags(utf8_decode($_POST['RUC1']));
				$RUC2 = strip_tags(utf8_decode($_POST['RUC2']));
				$RUC3 = strip_tags(utf8_decode($_POST['RUC3']));
				$DV = strip_tags(utf8_decode($_POST['DV']));
				$Telefono = strip_tags(utf8_decode($_POST['Telefono']));
				$Celular = strip_tags(utf8_decode($_POST['Celular']));
				$Email = strip_tags(utf8_decode($_POST['Email']));
				$Direccion = strip_tags(utf8_decode($_POST['Direccion']));
				$Credito = strip_tags(utf8_decode($_POST['Credito']));
				$Logo_Editado = strip_tags(utf8_decode($_POST['Logo_Editado']));
				$Logo_Editado = ($Logo_Editado == 'NULL') ? 'logo.png' : $Logo_Editado;
				$Evento = "Cliente Empresa Actualizado";
				$Tipo = "6";
		
				$stmt = $db->prepare("UPDATE cliente_empresa SET nombre_empresa=?, logo_empresa=?, ruc_parte_1=?,ruc_parte_2=?,ruc_parte_3=?,dv=?,telefono=?,celular=?,email=?,direccion=?,credito=?,ultima_actualizacion=NOW()
				WHERE MD5(id_cliente)=?");
				$c = 1;
				$stmt->bindParam($c,$NombreEmpresa,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Logo_Editado,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$RUC1,PDO::PARAM_INT);				
				$c++;
				$stmt->bindParam($c,$RUC2,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$RUC3,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$DV,PDO::PARAM_INT);				
				$c++;
				$stmt->bindParam($c,$Telefono,PDO::PARAM_STR,14);
				$c++;
				$stmt->bindParam($c,$Celular,PDO::PARAM_STR,15);
				$c++;
				$stmt->bindParam($c,$Email,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Direccion,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$Credito,PDO::PARAM_INT);	
				$c++;
				$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_STR,255);				
					
				$Actualizado = $stmt->execute();

				$stmt = $db->prepare("SELECT * FROM cliente_empresa WHERE md5(id_cliente) = ?");
				$c = 1;
				$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_STR,255);
				$stmt->execute();				
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$id_cliente = $results[0]["id_cliente"];	
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
				
				$stmt = $db->prepare("INSERT INTO historial_cliente_empresa (id_cliente_empresa,id_log) VALUES (?,?)");
				$c = 1;
				$stmt->bindParam($c,$id_cliente,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
				$Insertado2 = $stmt->execute();	
				
				$stmt->closeCursor();				
			
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}			
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
	
	if($_GET['action'] == 'Eliminar_Cliente')	
	{
		session_start();		
		$db->beginTransaction();		
		$Id_Cliente = strip_tags(utf8_decode($_POST['IdCliente']));		
		$Id_Usuario = base64_decode($_SESSION['id_usuario']);		
		
		if ($_POST['TipoCliente'] == 1)
		{
			$Evento = "Cliente Persona Eliminado";
			$Tipo = "9";

			try
			{			
			
				$stmt = $db->prepare("SELECT * FROM cliente_persona WHERE md5(id_cliente) = ?");
				$c = 1;
				$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_STR,255);
				$stmt->execute();				
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$id_cliente = $results[0]["id_cliente"];	
				$stmt->closeCursor();				
				
				$stmt = $db->prepare("DELETE FROM cliente_persona WHERE MD5(id_cliente) = ?");
				$c = 1;
				$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_STR,255);

				$Eliminado = $stmt->execute();				
				
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
				
				$stmt = $db->prepare("INSERT INTO historial_cliente_persona (id_cliente_persona,id_log) VALUES (?,?)");
				$c = 1;
				$stmt->bindParam($c,$id_cliente,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
				$Insertado2 = $stmt->execute();				
				
				$stmt->closeCursor();
				
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}	
		}
		else
		{
			$Evento = "Cliente Empresa Eliminado";
			$Tipo = "10";		

			try
			{			
			
				$stmt = $db->prepare("SELECT * FROM cliente_empresa WHERE md5(id_cliente) = ?");
				$c = 1;
				$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_STR,255);
				$stmt->execute();				
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$id_cliente = $results[0]["id_Cliente"];	
				$stmt->closeCursor();							
			
				$stmt = $db->prepare("DELETE FROM cliente_empresa_contactos WHERE MD5(id_cliente_empresa) = ?");
				$c = 1;
				$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_STR,255);
				
				$Eliminado = $stmt->execute();				
				
				$stmt = $db->prepare("DELETE FROM cliente_empresa WHERE MD5(id_cliente) = ?");
				$c = 1;
				$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_STR,255);

				$Eliminado = $stmt->execute();	
				
		
		
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
				
				$stmt = $db->prepare("INSERT INTO historial_cliente_empresa (id_cliente_empresa,id_log) VALUES (?,?)");
				$c = 1;
				$stmt->bindParam($c,$id_cliente,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
				$Insertado2 = $stmt->execute();	
				
				$stmt->closeCursor();					
				
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}	
		}

	
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
	
	if($_GET['action'] == 'Listar_Contactos')
	{
		$html = "";
		session_start();
		
		try
		{		
			$IdFila = $_POST['IdFila'];
			$Id_Customer = $_POST['IdCliente'];
			$stmt = $db->prepare("SELECT * FROM cliente_empresa_contactos WHERE MD5(id_cliente_empresa) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Customer,PDO::PARAM_STR);
			
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
				
				$html .='<tr  class="gradeA" id="rowDetalleMin_'.$IdFila.$c.'">
						<td  align="center">'.$c.'</td>
						<td>'.utf8_encode($row['nombre_de_contacto']).'<input type="hidden" id="hidNombreContacto'.$IdFila.$c.'" name="hidNombreContacto'.$IdFila.'[]" value="'.utf8_encode($row['nombre_de_contacto']).'" /></td>
						<td>'.utf8_encode($row['telefono_de_contacto']).'<input type="hidden" id="hidTelefonoContacto'.$IdFila.$c.'" name="hidTelefonoContacto'.$IdFila.'[]" value="'.utf8_encode($row['telefono_de_contacto']).'" /></td>						
						<td>'.utf8_encode($row['celular_de_contacto']).'<input type="hidden" id="hidCelularContacto'.$IdFila.$c.'" name="hidCelularContacto'.$IdFila.'[]" value="'.utf8_encode($row['celular_de_contacto']).'" /></td>
						<td>'.utf8_encode($row['email_de_contacto']).'<input type="hidden" id="hidEmailContacto'.$IdFila.$c.'" name="hidEmailContacto'.$IdFila.'[]" value="'.utf8_encode($row['email_de_contacto']).'" /></td>
						<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Contacto_Cliente('.$IdFila.','.$c.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
						
					if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
					$html .='<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Contacto?\')){Eliminar_Contacto_Cliente('.$IdFila.','.$c.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					
					$html .='<input type="hidden" id="hdnIdCamposMin_'.$c.'" name="hdnIdCamposMin[]" value="'.utf8_encode(md5($row['id_cliente_empresa'])).'" /></td>					
					</tr>';
					
				$c = $c + 1;
			}

		}
		
		echo $html;
		
	}
	
	if($_GET['action'] == 'Editar_Contactos')
	{
		session_start();
		$db->beginTransaction(); 		
		try
		{		
			
			$Id_Customer = $_POST['IdCliente'];
			$stmt = $db->prepare("SELECT * FROM cliente_empresa_contactos WHERE MD5(id_cliente_empresa) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Customer,PDO::PARAM_STR);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		
		foreach ($rows as $row)
		{
			$Id_Cliente = $row['id_cliente_empresa'];
		}
		
		try
		{
			$Id_Customer = strip_tags(utf8_decode($_POST['IdCliente']));				
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Cliente Empresa Actualizado";
			$Tipo = "6";			
			
			$stmt = $db->prepare("SELECT id_cliente FROM cliente_empresa WHERE  MD5(id_cliente)= ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Customer,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_cliente = $results[0]["id_cliente"];	
			$stmt->closeCursor();

			//echo $Id_Customer;
			
			/*$stmt = $db->prepare("SELECT id_cliente_empresa FROM cliente_empresa_contactos WHERE  MD5(id_cliente_empresa)= ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Customer,PDO::PARAM_STR,255);
			$stmt->execute();
			$nfilasC = $stmt->rowCount();	
			//$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//$id_cliente = $results[0]["id_cliente"];	
			$stmt->closeCursor();*/			
			
			$stmt = $db->prepare("DELETE FROM cliente_empresa_contactos WHERE MD5(id_cliente_empresa) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Customer,PDO::PARAM_STR,255);
				
			$Eliminado = $stmt->execute();				

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
				
			$stmt = $db->prepare("INSERT INTO historial_cliente_empresa (id_cliente_empresa,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_cliente,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();	
				
			$stmt->closeCursor();
			

		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		$NombreContacto = explode(',',$_POST['NombreContacto']);	
		$TelefonoContacto = explode(',',$_POST['TelefonoContacto']);
		$CelularContacto = explode(',',$_POST['CelularContacto']);
		$EmailContacto = explode(',',$_POST['EmailContacto']);
		
		//echo count($NombreContacto)."-";
		//echo $NombreContacto[0];
		
		$f = 0; $CantContacto = 0;
		while ($f < count($NombreContacto))
		{

			$Nombre_Contacto	= strip_tags(utf8_decode($NombreContacto[$f]));
			$Telefono_Contacto = strip_tags(utf8_decode($TelefonoContacto[$f]));
			$Celular_Contacto = strip_tags(utf8_decode($CelularContacto[$f]));
			$Email_Contacto = strip_tags(utf8_decode($EmailContacto[$f]));				

			//echo $id_cliente;
			
			$stmt = $db->prepare("INSERT INTO cliente_empresa_contactos (id_cliente_empresa,nombre_de_contacto,telefono_de_contacto,celular_de_contacto,email_de_contacto,fecha_creado)
			VALUES (?,?,?,?,?,NOW())");
			$c = 1;
			$stmt->bindParam($c,$id_cliente,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Nombre_Contacto,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Telefono_Contacto,PDO::PARAM_STR,14);
			$c++;
			$stmt->bindParam($c,$Celular_Contacto,PDO::PARAM_STR,15);
			$c++;
			$stmt->bindParam($c,$Email_Contacto,PDO::PARAM_STR,255);						
				
			$Insertado3 = $stmt->execute();				
			//print_r($stmt->errorInfo());			
			$CantContacto = $Insertado3  + $CantContacto ;

			$f = $f + 1;	
		}
			
		//echo "$Eliminado-$nfilasC-$Insertado1-$Insertado2-$CantContacto-$Insertado3-$NombreContacto-$CantContacto";
			
		if (($Eliminado == true)  and ($Insertado1 === true) and ($Insertado2 === true)  and ($CantContacto > 0) and (count($NombreContacto) == $CantContacto))
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