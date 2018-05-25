<?php
	include('../../config/configuracion.php');
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
	
	if($_GET['action'] == 'Listar_Tamano_Pliego')	
	{	

		$html = "";
		
		try
		{		

			$stmt = $db->prepare("SELECT * FROM impresion_tamano_pliego");			
				
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();

			//}
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		if ($nfilas > 0)
		{
				
			$c = 1;
			foreach ($rows as $row)
			{
				$html .= "<option value='".$row['id_tamano']."'>".utf8_encode($row['descripcion_tamano'])."</option>";
			}
		}
		
		echo $html;

	
	}

	if($_GET['action'] == 'Listar_Tamano_Pagina')
	{
		$html = "";
		session_start();
		
		try
		{		
			$stmt = $db->prepare("SELECT id_tamano,descripcion_tamano FROM impresion_tamano_pliego");
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
			
		$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable"  style="table-layout: fixed;word-wrap:break-word;"><thead><tr>';			
		//$html .= '<table cellpadding="0" cellspacing="0" border="0" class="sTable"><thead><tr>';
		$html .= '<th style="width:2%"></th>
				<th style="width:30%">Tama&ntilde;o de P&aacute;gina
				<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
				<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
				<th style="width:29%">Precio por Pulgada</th>
				<th style="width:29%">Precio por P&aacute;gina</th>
				<th style="width:10%">Seleccionar</th>';	

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
						<td>'.utf8_encode($row['descripcion_tamano']).'<input type="hidden" id="hidIdTamano'.$c.'" name="hidIdTamano[]" value="'.utf8_encode(base64_encode($row['id_tamano'])).'" /></td>
						<td align="center">B/.&nbsp;<input type="text" value="0.00000000" class="validate[required custom[number]]" name="txtPrecioPulgada[]" id="txtPrecioPulgada'.$c.'" onchange="DecimalesPulgada(\'txtPrecioPulgada'.$c.'\');" style="width:75%"/></td>						
						<td align="center">B/.&nbsp;<input type="text" value="0.00000000" class="validate[required custom[number]]" name="txtPrecioPagina[]" id="txtPrecioPagina'.$c.'" onchange="DecimalesPulgada(\'txtPrecioPagina'.$c.'\');" style="width:75%" />
						<td align="center"><input type="checkbox" id="chkSeleccionar'.$c.'" name="chkSeleccionar[]" value="1" /><input type="hidden" name="hdnSeleccionar[]" id="hdnSeleccionar'.$c.'" />				
						<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(base64_encode($row['id_tamano'])).'" /></td>
						</tr>';
					
				$c = $c + 1;
			}

		}
		  
		$html .= '
              </tbody></table>';	
		echo $html;
		
	}

	if($_GET['action'] == 'Calcular_Precio_Pulgada')	
	{
		$response = 0;
		$Precio	= strip_tags(utf8_decode($_POST['Precio']));
		$TamanoAncho	= strip_tags(utf8_decode($_POST['TamanoAncho']));			
		$TamanoLargo	= strip_tags(utf8_decode($_POST['TamanoLargo']));
		$response = number_format(($Precio/($TamanoAncho*$TamanoLargo)),8,'.','');
		echo $response;
	}
	
	if($_GET['action'] == 'Calcular_Precio_Material')	
	{
		$response = 0;
		$Precio	= strip_tags(utf8_decode($_POST['Precio']));
		$TamanoAncho	= strip_tags(utf8_decode($_POST['TamanoAncho']));			
		$TamanoLargo	= strip_tags(utf8_decode($_POST['TamanoLargo']));
		$response = number_format(($Precio*($TamanoAncho*$TamanoLargo)),8,'.','');
		echo $response;
	}

	if($_GET['action'] == 'Calcular_Precio_Material_Pagina')	
	{	
		$html = "";
		session_start();
		
		$Precio	= strip_tags(utf8_decode($_POST['Precio']));
		$Tamano	= strip_tags(utf8_decode(base64_decode($_POST['Tamano'])));			
		
		try
		{		
			$stmt = $db->prepare("SELECT ancho,largo FROM impresion_tamano_pliego WHERE id_tamano = ?");

			$c = 1;
			$stmt->bindParam($c,$Tamano,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		$Precio_x_Pagina = number_format($rows[0]['ancho']*$rows[0]['largo']*$Precio,8,'.','');
		
	
		echo $Precio_x_Pagina;	

	}
	
	if($_GET['action'] == 'Calcular_Precio_Material_Pulgada')	
	{	
		$html = "";
		session_start();
		
		$Precio	= strip_tags(utf8_decode($_POST['Precio']));
		$Tamano	= strip_tags(utf8_decode(base64_decode($_POST['Tamano'])));			
		
		try
		{		
			$stmt = $db->prepare("SELECT ancho,largo FROM impresion_tamano_pliego WHERE id_tamano = ?");

			$c = 1;
			$stmt->bindParam($c,$Tamano,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		$Precio_x_Pagina = number_format(($Precio/($rows[0]['ancho']*$rows[0]['largo'])),8,'.','');
		
	
		echo $Precio_x_Pagina;	

	}
	
	//Lista_Material
	if($_GET['action'] == 'Lista_Material_Edicion')	
	{	
		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM impresion_material WHERE estatus_material = 1 ORDER BY descripcion_material ASC");
		
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
				$html .= "<option value='".utf8_encode($row['id_material'])."'>".utf8_encode($row['descripcion_material'])."</option>";
			}
		}
		
		echo $html;	
	}

	
	if($_GET['action'] == 'Listar_Materiales')
	{
		$html = "";
		session_start();
		
		try
		{	

			$IdMaterial	= utf8_decode($_POST['IdMaterial']);
			
			if($IdMaterial!="")
			{		
				$stmt = $db->prepare("SELECT iptpm.id_material,iptpm.id_tamano,descripcion_material,descripcion_tamano,ancho,largo,precio_por_pagina,precio_por_pulgada FROM impresion_precio_tamano_papel_material iptpm
						INNER JOIN impresion_material im ON (im.id_material = iptpm.id_material)
						INNER JOIN impresion_tamano_pliego itp ON (itp.id_tamano = iptpm.id_tamano)
						WHERE im.estatus_material = 1 AND im.id_material = '$IdMaterial' ");	
			}
			else
			{
				$stmt = $db->prepare("SELECT iptpm.id_material,iptpm.id_tamano,descripcion_material,descripcion_tamano,ancho,largo,precio_por_pagina,precio_por_pulgada FROM impresion_precio_tamano_papel_material iptpm
				INNER JOIN impresion_material im ON (im.id_material = iptpm.id_material)
				INNER JOIN impresion_tamano_pliego itp ON (itp.id_tamano = iptpm.id_tamano)
				WHERE im.estatus_material = 1");			
			}
		
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		
		if($IdMaterial != "")
		{		
				
			$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable"  style="table-layout: fixed;word-wrap:break-word;"><thead><tr>';			
			//$html .= '<table cellpadding="0" cellspacing="0" border="0" class="sTable"><thead><tr>';
			$html .= '<th style="width:5%"></th>
					<th style="width:30%">Nombre de material</th>
					<th style="width:30%">Tama&ntilde;o de P&aacute;gina
					<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
					<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
					<th style="width:29%">Precio por Pulgada</th>
					<th style="width:29%">Precio por P&aacute;gina</th>
					<th style="width:10%">Seleccionar</th>';	

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
						$stmt = $db->prepare("SELECT iptpm.id_material,iptpm.id_tamano,descripcion_material,descripcion_tamano,ancho,largo,precio_por_pagina,precio_por_pulgada FROM impresion_precio_tamano_papel_material iptpm
						INNER JOIN impresion_material im ON (im.id_material = iptpm.id_material)
						INNER JOIN impresion_tamano_pliego itp ON (itp.id_tamano = iptpm.id_tamano)
						WHERE im.estatus_material = 1 AND im.id_material = ? ");			
					
						$p = 1;
						$stmt->bindParam($p,$IdMaterial,PDO::PARAM_STR,255);
						$p++;
						// $stmt->bindParam($p,$row['id_tamano'],PDO::PARAM_STR,255);				
						
						$stmt->execute();
						//print_r($stmt->errorInfo());

						$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						
						$nfilas1 = $stmt->rowCount();
						//$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}				
					
					if ($nfilas1 > 0 ) {
						$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
							<td>'.$c.'</td>
							<td>'.utf8_encode($row['descripcion_material']).'<input type="hidden" id="hidIdTamano'.$c.'" name="hidIdTamano[]" value="'.utf8_encode(base64_encode($row['id_tamano'])).'" /></td>
							<td>'.utf8_encode($row['descripcion_tamano']).'<input type="hidden" id="hidIdTamano'.$c.'" name="hidIdTamano[]" value="'.utf8_encode(base64_encode($row['id_tamano'])).'" /></td>
							<td align="center">B/.&nbsp;<input type="text" value="'.utf8_encode(number_format($rows1[0]['precio_por_pulgada'],8,'.','')).'" class="validate[required custom[number]]" name="txtPrecioPulgada[]" id="txtPrecioPulgada'.$c.'" onchange="DecimalesPulgada(\'txtPrecioPulgada'.$c.'\');" style="width:75%"/></td>						
							<td align="center">B/.&nbsp;<input type="text" value="'.utf8_encode(number_format($rows1[0]['precio_por_pagina'],8,'.','')).'" class="validate[required custom[number]]" name="txtPrecioPagina[]" id="txtPrecioPagina'.$c.'" onchange="DecimalesPulgada(\'txtPrecioPagina'.$c.'\');" style="width:75%" />
							<td align="center"><input type="checkbox" id="chkSeleccionar'.$c.'" name="chkSeleccionar[]" value="1" '.(($nfilas1!=false)?'checked="checked"':'').' /><input type="hidden" name="hdnSeleccionar[]" id="hdnSeleccionar'.$c.'" />				
							<input type="hidden" id="hdnIdCamposM_'.$c.'" name="hdnIdCamposM[]" value="'.utf8_encode(md5($row['id_material'])).'" />
							<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(base64_encode($row['id_tamano'])).'" /></td>
							</tr>';
						
					$c = $c + 1;
					}
					
				}

			}
			  
			$html .= '
				  </tbody></table>';	

		}
		else
		{
			$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable"><thead><tr>';			

			$html .= '<th style="width:2%"></th>
					<th style="width:25%">Nombre de Material
					<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
					<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
					<th style="width:25%">Tana&ntilde;o de P&aacute;gina</th>
					<th style="width:18%">Precio por Pulgada</th>
					<th style="width:18%">Precio por P&aacute;gina</th>
					';
					
					if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
					$html .='<th style="width:12%">Opciones</th>';	

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
							<td>'.utf8_encode($row['descripcion_material']).'<input type="hidden" id="hidDescripcionMaterial'.$c.'" name="hidDescripcionMaterial[]" value="'.utf8_encode($row['descripcion_material']).'" /></td>
							<td>'.utf8_encode($row['descripcion_tamano']).'<input type="hidden" id="hidDescripcionTamano'.$c.'" name="hidDescripcionTamano[]" value="'.utf8_encode($row['descripcion_tamano']).'" /><input type="hidden" id="hidTamanoAncho'.$c.'" name="hidTamanoAncho[]" value="'.utf8_encode($row['ancho']).'" /><input type="hidden" id="hidTamanoLargo'.$c.'" name="hidTamanoLargo[]" value="'.utf8_encode($row['largo']).'" /></td>						
							<td>B/.&nbsp;'.utf8_encode(number_format($row['precio_por_pulgada'],8,'.','')).'<input type="hidden" id="hidPrecioPulgada'.$c.'" name="hidPrecioPulgada[]" value="'.utf8_encode(number_format($row['precio_por_pulgada'],8,'.','')).'" /></td>
							<td>B/.&nbsp;'.utf8_encode(number_format($row['precio_por_pagina'],8,'.','')).'<input type="hidden" id="hidPrecioPagina'.$c.'" name="hidPrecioPagina[]" value="'.utf8_encode(number_format($row['precio_por_pagina'],8,'.','')).'" /></td>
							<td>';
						
						if (base64_decode($_SESSION['id_tipo_usuario']) == 1)
						{					
							$html .='<a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Material('.$c.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
							$html .='<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Material?\')){Eliminar_Material('.$c.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';	
							
						}
						
						$html .='<input type="hidden" id="hdnIdCamposM_'.$c.'" name="hdnIdCamposM[]" value="'.utf8_encode(md5($row['id_material'])).'" />
								<input type="hidden" id="hdnIdCamposT_'.$c.'" name="hdnIdCamposT[]" value="'.utf8_encode(base64_encode($row['id_tamano'])).'" /></td>';
						
					$c = $c + 1;
				}

			}
			  
			$html .= '
				  </tbody></table>';
		}
		
		
		
		echo $html;
		
	}


	
	if($_GET['action'] == 'Agregar_Material')	
	{
		session_start();	
		
		$db->beginTransaction();
		
		try
		{
			$NombreMaterial	= strip_tags(utf8_decode($_POST['NombreMaterial']));

			$PrecioPulgada = json_decode($_POST['PrecioPulgada']);
			$PrecioPagina = json_decode($_POST['PrecioPagina']);	
			$IdTamano = json_decode($_POST['IdTamano']);
			$Seleccionar = json_decode($_POST['Seleccionar']);
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Material Agregado";
			$Tipo = "20";
			
			$i = 0;
			while ($i < count($PrecioPulgada))
			{
				$Precio_Pulgada[$i] = strip_tags(utf8_decode($PrecioPulgada[$i]));
				$Precio_Pagina[$i] = strip_tags(utf8_decode($PrecioPagina[$i]));
				$Id_Tamano[$i] = strip_tags(utf8_decode(base64_decode($IdTamano[$i])));
				$Seleccionado[$i] = strip_tags(utf8_decode($Seleccionar[$i]));

				$i++;
			}
			
			$stmt = $db->prepare("INSERT INTO impresion_material (descripcion_material,fecha_creado) VALUES (?,NOW())");
			$p = 1;
			$stmt->bindParam($p,$NombreMaterial,PDO::PARAM_STR,255);			
		
					
			$Insertado = $stmt->execute();
					//print_r($stmt->errorInfo());				
			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Material");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Material = $results[0]["Id_Material"];	

			if ($Insertado)
			{
				$i=0;
				$CantItem = 0;
				while ($i < count($PrecioPulgada))
				{
					if ($Seleccionado[$i] == 1)
					{
						$stmt = $db->prepare("INSERT INTO impresion_precio_tamano_papel_material (id_material,id_tamano,precio_por_pagina,precio_por_pulgada,fecha_creado) VALUES (?,?,?,?,NOW())");
						$p = 1;
						$stmt->bindParam($p,$Id_Material,PDO::PARAM_STR,255);			
						$p++;
						$stmt->bindParam($p,$Id_Tamano[$i],PDO::PARAM_STR,255);	
						$p++;
						$stmt->bindParam($p,$Precio_Pagina[$i],PDO::PARAM_STR,255);	
						$p++;
						$stmt->bindParam($p,$Precio_Pulgada[$i],PDO::PARAM_STR,255);						
								
						$Insertado1 = $stmt->execute();	
					}
					$CantItem += $Insertado1;
					
					$i++;
				}			
			
			}
			
			
	
			$stmt = $db->prepare("INSERT INTO user_log (id_usuario,anio,fecha_log,evento,tipo) VALUES (?,YEAR(NOW()), NOW(),?,?)");
			$c = 1;
			$stmt->bindParam($c,$Id_Usuario,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Evento,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Tipo,PDO::PARAM_INT);
	
			$Insertado2 = $stmt->execute();
				
			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Log");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Log = $results[0]["Id_Log"];
				
			$stmt = $db->prepare("INSERT INTO historial_material (id_material,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$Id_Material,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado3 = $stmt->execute();		
				
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();		
		}
		
		if (($Insertado === true)  and ($Insertado2 === true) and ($Insertado3 === true) and ($CantItem > 0) and (count($PrecioPulgada) >= $CantItem))
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
	
	if($_GET['action'] == 'Actualizar_Material')
	{
	
		session_start();	
		$db->beginTransaction();
		try
		{
			
			print_r($_POST);

			$IdMaterial	= utf8_decode($_POST['IdMaterial']);
			

			echo " ID_MATERIAL ->".$IdMaterial." <-";

			$PrecioPulgada = json_decode($_POST['PrecioPulgada']);
			$PrecioPagina = json_decode($_POST['PrecioPagina']);	
			$IdTamano = json_decode($_POST['IdTamano']);
			if ( isset($_POST['Seleccionar']) ) {$Seleccionar = json_decode($_POST['Seleccionar']);}			
			
			if (is_array($PrecioPulgada))
			{			
				$i = 0;
				while ($i < count($PrecioPulgada))
				{
					$Precio_Pulgada[$i] = strip_tags(utf8_decode($PrecioPulgada[$i]));
					$Precio_Pagina[$i] = strip_tags(utf8_decode($PrecioPagina[$i]));
					$Id_Tamano[$i] = strip_tags(utf8_decode(base64_decode($IdTamano[$i])));
					$Seleccionado[$i] = strip_tags(utf8_decode($Seleccionar[$i]));
					
					$Precio_Pulgada[$i] = number_format($PrecioPulgada[$i],8,'.','');
					$Precio_Pagina[$i] = number_format($PrecioPagina[$i],8,'.','');							

					$i++;
				}			
			
			}
			else
			{
				$IdTamano = strip_tags(utf8_decode(base64_decode($_POST['IdTamano'])));
				
				$PrecioPulgada = strip_tags(utf8_decode($_POST['PrecioPulgada']));
				$PrecioPagina = strip_tags(utf8_decode($_POST['PrecioPagina']));
				
				$PrecioPulgada = number_format($PrecioPulgada,8,'.','');
				$PrecioPagina = number_format($PrecioPagina,8,'.','');				
			}
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Material Actualizado";
			$Tipo = "21";

			$stmt = $db->prepare("SELECT * FROM impresion_material WHERE MD5(id_material) = ? ");
			
			$c = 1;
			$stmt->bindParam($c,$IdMaterial,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// Aqui esta el problema
			$id_material = $results[0]["id_material"];
			//======================== 
			

			$stmt->closeCursor();					
			
			if (is_array($PrecioPulgada))
			{
				$i=0;
				$CantItem = 0; 
				while ($i < count($PrecioPulgada))
				{
					if ($Seleccionado[$i] == 1)
					{
						try
						{		
							
							
							$stmt = $db->prepare("SELECT id_material FROM impresion_precio_tamano_papel_material
							WHERE id_material= ? AND id_tamano = ? ");			
						
							$p = 1;
							$stmt->bindParam($p,$IdMaterial,PDO::PARAM_STR,255);			
							$p++;
							$stmt->bindParam($p,$Id_Tamano[$i],PDO::PARAM_STR,255);				
							
							$stmt->execute();
							//print_r($stmt->errorInfo());

							$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
							
							$nfilas = $stmt->rowCount();
							//$stmt->closeCursor();
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}						
						//echo $IdMaterial."-".$Id_Tamano[$i]."|";
						if ($nfilas != false)
						{
							$stmt = $db->prepare("UPDATE impresion_precio_tamano_papel_material SET precio_por_pagina=?,precio_por_pulgada=?,ultima_actualizacion=NOW()
							WHERE MD5(id_material)=? AND id_tamano=?");
							$p = 1;
							$stmt->bindParam($p,$Precio_Pagina[$i],PDO::PARAM_STR,255);	
							$p++;
							$stmt->bindParam($p,$Precio_Pulgada[$i],PDO::PARAM_STR,255);
							$p++;						
							$stmt->bindParam($p,$IdMaterial,PDO::PARAM_STR,255);			
							$p++;
							$stmt->bindParam($p,$Id_Tamano[$i],PDO::PARAM_STR,255);
									
							$Actualizado1 = $stmt->execute();
							
							$CantItem += $Actualizado1;							
						}
						else
						{
							$stmt = $db->prepare("INSERT INTO impresion_precio_tamano_papel_material (id_material,id_tamano,precio_por_pagina,precio_por_pulgada,fecha_creado) VALUES (?,?,?,?,NOW())");
							$p = 1;
							$stmt->bindParam($p,$id_material,PDO::PARAM_STR,255);			
							$p++;
							$stmt->bindParam($p,$Id_Tamano[$i],PDO::PARAM_STR,255);	
							$p++;
							$stmt->bindParam($p,$Precio_Pagina[$i],PDO::PARAM_STR,255);	
							$p++;
							$stmt->bindParam($p,$Precio_Pulgada[$i],PDO::PARAM_STR,255);						
									
							$Insertado1 = $stmt->execute();							
							//print_r($stmt->errorInfo());
							$CantItem = $Insertado1 + $CantItem;						
						}

					}

					
					$i++;
				}
			}
			else
			{
				$stmt = $db->prepare("UPDATE impresion_precio_tamano_papel_material SET precio_por_pagina=?,precio_por_pulgada=?,ultima_actualizacion=NOW()
				WHERE MD5(id_material)=? AND id_tamano=?");
				
				$p = 1;
				$stmt->bindParam($p,$PrecioPagina,PDO::PARAM_STR,255);			
				$p++;
				$stmt->bindParam($p,$PrecioPulgada,PDO::PARAM_STR,255);
				$p++;
				$stmt->bindParam($p,$IdMaterial,PDO::PARAM_STR,255);
				$p++;
				$stmt->bindParam($p,$IdTamano,PDO::PARAM_STR,255);
				
				$Actualizado = $stmt->execute();
			}
			

			//print_r($stmt->errorInfo());
		
		
		

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
				
			$stmt = $db->prepare("INSERT INTO historial_material (id_material,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_material,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();			
			$Actualizado = ($Insertado2 == true) ? true : false;
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();		
		}
		

		//echo "$Actualizado-$Insertado1-$Insertado2";		
		if ((($Actualizado === true) and ($Insertado1 === true) and ($Insertado2 === true)) or (($Insertado1 === true) and ($Insertado2 === true) and ($CantItem > 0) and (count($PrecioPulgada) >= $CantItem)))
		{
			
			$db->commit();
		}
		else
		{
			echo "false";
			$db->rollBack();
		}
	}	

	if($_GET['action'] == 'Eliminar_Material')	
	{
		session_start();	
		$db->beginTransaction();
		try
		{
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Material Actualizado";
			$Tipo = "21";			
			
			$IdMaterial	= strip_tags(utf8_decode($_POST['IdMaterial']));

			$stmt = $db->prepare("UPDATE impresion_material SET estatus_material=0,ultima_actualizacion=NOW()
			WHERE MD5(id_material)=?");			

			$c = 1;
			$stmt->bindParam($c,$IdMaterial,PDO::PARAM_STR,255);
			$Actualizado = $stmt->execute();
			//print_r($stmt->errorInfo());
		
		
			$stmt = $db->prepare("SELECT * FROM impresion_material WHERE md5(id_material) = ?");
			$c = 1;
			$stmt->bindParam($c,$IdMaterial,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_material = $results[0]["id_material"];	
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
				
			$stmt = $db->prepare("INSERT INTO historial_material (id_material,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_material,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();			
				
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
?>