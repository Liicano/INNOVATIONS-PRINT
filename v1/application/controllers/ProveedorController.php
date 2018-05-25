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

	if($_GET['action'] == 'Listar_Proveedor_Autocompletar')
	{
		$html = "";
		
		if(isset($_POST["Proveedor"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["Proveedor"])));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;	
				
		try
		{
			if((isset($_POST["Proveedor"])) and ($_POST["Proveedor"] != ""))
			{
				$stmt = $db->prepare("SELECT id_proveedor,nombre_proveedor FROM proveedores WHERE nombre_proveedor LIKE '".$criterio."'");			
			}
			else
			{
				$stmt = $db->prepare("SELECT id_proveedor,nombre_proveedor FROM proveedores WHERE nombre_proveedor LIKE '".$criterio."%'");
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
			$Proveedor = array();
			foreach ($rows as $row)
			{
				$Proveedor[$c]['value'] = utf8_encode($row['nombre_proveedor']);
				$Proveedor[$c]['hidProveedor'] = utf8_encode(base64_encode($row['id_proveedor']));
				$c++;
			}
			$html = json_encode($Proveedor);
		}
		else
		{
			$html = "null";		
		}
		
		echo $html;
	}	

	if($_GET['action'] == 'Listar_Proveedor')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM proveedores ORDER BY nombre_proveedor ASC");
			
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
				$html .= "<option value='".base64_encode($row['id_proveedor'])."'>".$row['nombre_proveedor']."</option>";
			}
		}
		
		echo $html;
	}	
	
	if($_GET['action'] == 'Agregar_Proveedor')
	{
		session_start();
		$db->beginTransaction();		
		$RUC = explode("-",$_POST['RUC']);		

		try
		{
				
			$Nombre_Proveedor	= strip_tags(utf8_decode($_POST['NombreProveedor']));
			$Ruc_Parte_1 = strip_tags(utf8_decode($_POST['RUC1']));
			$Ruc_Parte_2 = strip_tags(utf8_decode($_POST['RUC2']));
			$Ruc_Parte_3 = strip_tags(utf8_decode($_POST['RUC3']));
			$DV = strip_tags(utf8_decode($_POST['DV']));			
			$Telefono = strip_tags(utf8_decode($_POST['Telefono']));
			$Celular = strip_tags(utf8_decode($_POST['Celular']));
			$Fax = strip_tags(utf8_decode($_POST['Fax']));			
			$Email = strip_tags(utf8_decode($_POST['Email']));
			$Direccion = strip_tags(utf8_decode($_POST['Direccion']));
			$Nombre_Vendedor = strip_tags(utf8_decode($_POST['NombreVendedor']));
			$Celular_Vendedor = strip_tags(utf8_decode($_POST['CelularVendedor']));
			$Email_Vendedor = strip_tags(utf8_decode($_POST['EmailVendedor']));			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Proveedor Agregado";
			$Tipo = "3";

			$stmt = $db->prepare("INSERT INTO proveedores (nombre_proveedor,ruc_parte_1,ruc_parte_2,ruc_parte_3,dv,telefono,celular,fax,email,direccion,nombre_vendedor,celular_vendedor,email_vendedor,fecha_creado)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())");
			$c = 1;
			$stmt->bindParam($c,$Nombre_Proveedor,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Ruc_Parte_1,PDO::PARAM_INT);				
			$c++;
			$stmt->bindParam($c,$Ruc_Parte_2,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Ruc_Parte_3,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$DV,PDO::PARAM_INT);				
			$c++;
			$stmt->bindParam($c,$Telefono,PDO::PARAM_STR,14);
			$c++;
			$stmt->bindParam($c,$Celular,PDO::PARAM_STR,15);
			$c++;
			$stmt->bindParam($c,$Fax,PDO::PARAM_STR,14);
			$c++;
			$stmt->bindParam($c,$Email,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Direccion,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Nombre_Vendedor,PDO::PARAM_STR,255);	
			$c++;
			$stmt->bindParam($c,$Celular_Vendedor,PDO::PARAM_STR,255);	
			$c++;
			$stmt->bindParam($c,$Email_Vendedor,PDO::PARAM_STR,255);				
					
			$Insertado = $stmt->execute();
			

			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Proveedor");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Proveedor = $results[0]["Id_Proveedor"];	

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
				
			$stmt = $db->prepare("INSERT INTO historial_proveedores (id_proveedor,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$Id_Proveedor,PDO::PARAM_INT);
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

	if($_GET['action'] == 'Listar_Proveedores')
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
			array( 'db' => 'id_proveedor', 'dt' => 0 ),
			array( 'db' => 'nombre_proveedor',  'dt' => 1 ),
			array( 'db' => 'ruc',   'dt' => 2 ),
			array( 'db' => 'dv',   'dt' => 3 ),
			array( 'db' => 'telefono',   'dt' => 4 ),
			array( 'db' => 'celular',   'dt' => 5 ),
			array( 'db' => 'fax',   'dt' => 6 ),
			array( 'db' => 'email',   'dt' => 7 ),
			array( 'db' => 'direccion',   'dt' => 8 ),
			array( 'db' => 'nombre_vendedor',   'dt' => 9 ),
			array( 'db' => 'celular_vendedor',   'dt' => 10 ),
			array( 'db' => 'email_vendedor',   'dt' => 11 ),	
			array( 'db' => 'opciones',   'dt' => 12 ),			
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS id_proveedor,nombre_proveedor,ruc_parte_1,ruc_parte_2,ruc_parte_3,ruc,dv,telefono,celular,fax,email,direccion,nombre_vendedor,
			celular_vendedor, email_vendedor
			FROM (SELECT id_proveedor,nombre_proveedor,ruc_parte_1,ruc_parte_2,ruc_parte_3,CONCAT(ruc_parte_1,ruc_parte_2,ruc_parte_3) AS ruc,dv,telefono,celular,fax,email,direccion,nombre_vendedor,
			celular_vendedor, email_vendedor FROM proveedores) AS T ".$where." ".$order." ".$limit);

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

			$stmt = $db->prepare("SELECT count(id_proveedor)
			FROM proveedores");			
				
			$stmt->execute();			
			$recordsTotal = $stmt->fetchColumn (0);
			
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		/*$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable" style="table-layout: fixed;word-wrap:break-word;"><thead><tr>';			

		$html .= '<th style="width:2%"></th>
				<th style="width:12%">Nombre del Proveedor
				<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
				<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
				<th style="width:7%">RUC</th>
				<th style="width:3%">DV</th>
				<th style="width:7%">Tel&eacute;fono</th>
				<th style="width:8%">Celular</th>
				<th style="width:7%">Fax</th>				
				<th style="width:8%">Correo Electr&oacute;nico</th>
				<th style="width:15%">Direcci&oacute;n</th>
				<th style="width:10%">Nombre del Vendedor</th>				
				<th style="width:8%">Celular del Vendedor</th>
				<th style="width:8%">Correo Electr&oacute;nico del Vendedor</th>				
				<th style="width:5%">Opciones</th>';	

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
						<td>'.utf8_encode($row['nombre_proveedor']).'<input type="hidden" id="hidNombreProveedor'.$c.'" name="hidNombreProveedor[]" value="'.utf8_encode($row['nombre_proveedor']).'" /></td>
						<td>'.utf8_encode($row['ruc_parte_1']."-".$row['ruc_parte_2']."-".$row['ruc_parte_3']).'<input type="hidden" id="hidRUC'.$c.'" name="hidRUC[]" value="'.utf8_encode($row['ruc_parte_1']."-".$row['ruc_parte_2']."-".$row['ruc_parte_3']).'" /></td>						
						<td>'.utf8_encode($row['dv']).'<input type="hidden" id="hidDV'.$c.'" name="hidDV[]" value="'.utf8_encode($row['dv']).'" /></td>
						<td>'.utf8_encode($row['telefono']).'<input type="hidden" id="hidTelefono'.$c.'" name="hidTelefono[]" value="'.utf8_encode($row['telefono']).'" /></td>
						<td>'.utf8_encode($row['celular']).'<input type="hidden" id="hidCelular'.$c.'" name="hidCelular[]" value="'.utf8_encode($row['celular']).'" /></td>
						<td>'.utf8_encode($row['fax']).'<input type="hidden" id="hidFax'.$c.'" name="hidFax[]" value="'.utf8_encode($row['fax']).'" /></td>						
						<td style="overflow:hidden;" >'.utf8_encode($row['email']).'<input type="hidden" id="hidEmail'.$c.'" name="hidEmail[]" value="'.utf8_encode($row['email']).'" /></td>
						<td>'.utf8_encode($row['direccion']).'<input type="hidden" id="hidDireccion'.$c.'" name="hidDireccion[]" value="'.utf8_encode($row['direccion']).'" /></td>
						<td>'.utf8_encode($row['nombre_vendedor']).'<input type="hidden" id="hidNombreVendedor'.$c.'" name="hidNombreVendedor[]" value="'.utf8_encode($row['nombre_vendedor']).'" /></td>						
						<td>'.utf8_encode($row['celular_vendedor']).'<input type="hidden" id="hidCelularVendedor'.$c.'" name="hidCelularVendedor[]" value="'.utf8_encode($row['celular_vendedor']).'" /></td>
						<td style="overflow:hidden;">'.utf8_encode($row['email_vendedor']).'<input type="hidden" id="hidEmailVendedor'.$c.'" name="hidEmailVendedor[]" value="'.utf8_encode($row['email_vendedor']).'" /></td>						
						<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Proveedor('.$c.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
					
					if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
					$html .='<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Proveedor?\')){Eliminar_Proveedor('.$c.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					
					$html .='<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_proveedor'])).'" /></td>					
					</tr>';
					
				$c = $c + 1;
			}

		}

				  
		$html .= '</tbody></table>';

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
				$Data[$f][$c] = utf8_encode($row['nombre_proveedor']).'<input type="hidden" id="hidNombreProveedor'.$f.'" name="hidNombreProveedor[]" value="'.utf8_encode($row['nombre_proveedor']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['ruc_parte_1']."-".$row['ruc_parte_2']."-".$row['ruc_parte_3']).'<input type="hidden" id="hidRUC'.$f.'" name="hidRUC[]" value="'.utf8_encode($row['ruc_parte_1']."-".$row['ruc_parte_2']."-".$row['ruc_parte_3']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['dv']).'<input type="hidden" id="hidDV'.$f.'" name="hidDV[]" value="'.utf8_encode($row['dv']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['telefono']).'<input type="hidden" id="hidTelefono'.$f.'" name="hidTelefono[]" value="'.utf8_encode($row['telefono']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['celular']).'<input type="hidden" id="hidCelular'.$f.'" name="hidCelular[]" value="'.utf8_encode($row['celular']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['fax']).'<input type="hidden" id="hidFax'.$f.'" name="hidFax[]" value="'.utf8_encode($row['fax']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['email']).'<input type="hidden" id="hidEmail'.$f.'" name="hidEmail[]" value="'.utf8_encode($row['email']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['direccion']).'<input type="hidden" id="hidDireccion'.$f.'" name="hidDireccion[]" value="'.utf8_encode($row['direccion']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['nombre_vendedor']).'<input type="hidden" id="hidNombreVendedor'.$f.'" name="hidNombreVendedor[]" value="'.utf8_encode($row['nombre_vendedor']).'" />';				
				$c++;
				$Data[$f][$c] = utf8_encode($row['celular_vendedor']).'<input type="hidden" id="hidCelularVendedor'.$f.'" name="hidCelularVendedor[]" value="'.utf8_encode($row['celular_vendedor']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['email_vendedor']).'<input type="hidden" id="hidEmailVendedor'.$f.'" name="hidEmailVendedor[]" value="'.utf8_encode($row['email_vendedor']).'" />';				
				$c++;				
				
				
				$Data[$f][$c] = "";
				$Data[$f][$c] .= '<a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Proveedor('.$f.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';				
				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				$Data[$f][$c] .= '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Proveedor?\')){Eliminar_Proveedor('.$f.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
				$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_proveedor'])).'" />';
				
				$f = $f + 1;
			}

		}		
		
		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;		
		echo json_encode($ResultSet);	
		
	}
	
	if($_GET['action'] == 'Actualizar_Proveedor')
	{
	
		session_start();
		$db->beginTransaction();		
		$RUC = explode("-",$_POST['RUC']);		
		
		try
		{
				
			$Nombre_Proveedor	= strip_tags(utf8_decode($_POST['NombreProveedor']));
			$Ruc_Parte_1 = strip_tags(utf8_decode($_POST['RUC1']));
			$Ruc_Parte_2 = strip_tags(utf8_decode($_POST['RUC2']));
			$Ruc_Parte_3 = strip_tags(utf8_decode($_POST['RUC3']));
			$DV = strip_tags(utf8_decode($_POST['DV']));			
			$Telefono = strip_tags(utf8_decode($_POST['Telefono']));
			$Celular = strip_tags(utf8_decode($_POST['Celular']));
			$Fax = strip_tags(utf8_decode($_POST['Fax']));			
			$Email = strip_tags(utf8_decode($_POST['Email']));
			$Direccion = strip_tags(utf8_decode($_POST['Direccion']));
			$Nombre_Vendedor = strip_tags(utf8_decode($_POST['NombreVendedor']));
			$Celular_Vendedor = strip_tags(utf8_decode($_POST['CelularVendedor']));
			$Email_Vendedor = strip_tags(utf8_decode($_POST['EmailVendedor']));
			$Id_Proveedor = strip_tags(utf8_decode($_POST['IdProveedor']));			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Proveedor Actualizado";
			$Tipo = "7";

			$stmt = $db->prepare("UPDATE proveedores SET nombre_proveedor=?,ruc_parte_1=?,ruc_parte_2=?,ruc_parte_3=?,dv=?,telefono=?,celular=?,fax=?,email=?,direccion=?,nombre_vendedor=?,celular_vendedor=?,email_vendedor=?,ultima_actualizacion=NOW()
			WHERE MD5(id_proveedor)=?");
			$c = 1;
			$stmt->bindParam($c,$Nombre_Proveedor,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Ruc_Parte_1,PDO::PARAM_INT);				
			$c++;
			$stmt->bindParam($c,$Ruc_Parte_2,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Ruc_Parte_3,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$DV,PDO::PARAM_INT);				
			$c++;
			$stmt->bindParam($c,$Telefono,PDO::PARAM_STR,14);
			$c++;
			$stmt->bindParam($c,$Celular,PDO::PARAM_STR,15);
			$c++;
			$stmt->bindParam($c,$Fax,PDO::PARAM_STR,14);
			$c++;
			$stmt->bindParam($c,$Email,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Direccion,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Nombre_Vendedor,PDO::PARAM_STR,255);	
			$c++;
			$stmt->bindParam($c,$Celular_Vendedor,PDO::PARAM_STR,255);	
			$c++;
			$stmt->bindParam($c,$Email_Vendedor,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Id_Proveedor ,PDO::PARAM_STR,255);			
					
			$Actualizado = $stmt->execute();

			//print_r($db->errorInfo ());
			
			$stmt = $db->prepare("SELECT * FROM proveedores WHERE md5(id_proveedor) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Proveedor,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_proveedor = $results[0]["id_proveedor"];	
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
				
			$stmt = $db->prepare("INSERT INTO historial_proveedores (id_proveedor,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_proveedor,PDO::PARAM_INT);
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
	
	if($_GET['action'] == 'Eliminar_Proveedor')	
	{
		session_start();
		$db->beginTransaction();
		
		try
		{		
			$Id_Proveedor = strip_tags(utf8_decode($_POST['IdProveedor']));				
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Proveedor Eliminado";
			$Tipo = "11";			

			$stmt = $db->prepare("SELECT * FROM proveedores WHERE  MD5(id_proveedor) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Proveedor,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_proveedor = $results[0]["id_proveedor"];	
			$stmt->closeCursor();
				
			$stmt = $db->prepare("DELETE FROM proveedores WHERE MD5(id_proveedor) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Proveedor,PDO::PARAM_STR,255);

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
				
			$stmt = $db->prepare("INSERT INTO historial_proveedores (id_proveedor,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_proveedor,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
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