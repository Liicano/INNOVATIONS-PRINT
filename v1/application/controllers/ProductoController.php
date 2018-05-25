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

	$mysqli = mysqli_connect (DB_HOST, DB_USER, DB_CLAVE, DB_NOMBRE);

	if($_GET['action'] == 'Verificar_Codigo_Producto')
	{	
		
		$CodigoProducto	= strip_tags(utf8_decode($_POST['CodigoProducto']));
		$hidCodigoProducto	= strip_tags(utf8_decode($_POST['hidCodigoProducto']));
			
		try
		{		
			$stmt = $db->prepare("SELECT count(*) AS Existe FROM producto WHERE codigo_producto = ?");
			
			$p = 1;
			if ($hidCodigoProducto != "")
			$stmt->bindParam($p,$hidCodigoProducto,PDO::PARAM_STR,255);
			else
			$stmt->bindParam($p,$CodigoProducto,PDO::PARAM_STR,255);	
							
			$stmt->execute();
			$Existe = $stmt->fetchColumn();
							
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}

		if($Existe == 0)
		echo "true";
		else
		echo "false";		
	}
	
	if($_GET['action'] == 'Verificar_Codigo_Barra')
	{	
		
		$CodigoBarra	= strip_tags(utf8_decode($_POST['CodigoBarra']));			
		
		try
		{		
			$stmt = $db->prepare("SELECT count(*) AS Existe FROM producto WHERE codigo_barra = ?");
			
			$p = 1;
			$stmt->bindParam($p,$CodigoBarra,PDO::PARAM_STR,255);				
							
			$stmt->execute();
			$Existe = $stmt->fetchColumn();
				
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}

		if($Existe == 0)
		echo "true";
		else
		echo "false";
	}	

	if($_GET['action'] == 'Listar_Tipo_Descripcion_Producto_Autocompletar')
	{
		$html = "";
		
		if(isset($_POST["Tipo"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["Tipo"])));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;	

		try
		{
			if((isset($_POST["Tipo"])) and ($_POST["Tipo"] != ""))
			{
				$stmt = $db->prepare("SELECT id_tipo,descripcion_tipo FROM tipo_descripcion_producto WHERE descripcion_tipo LIKE '".$criterio."'");			
			}
			else
			{
				$stmt = $db->prepare("SELECT id_tipo,descripcion_tipo FROM tipo_descripcion_producto WHERE descripcion_tipo LIKE '".$criterio."%'");
			}
			
			$stmt->execute();
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
				
			$c = 0;
			$Tipo = array();	
			foreach ($rows as $row)
			{
				$Tipo[$c]['value'] = utf8_encode($row['descripcion_tipo']);
				$Tipo[$c]['hidTipo'] = utf8_encode(base64_encode($row['id_tipo']));
				$c++;
			}
			
			$html = json_encode($Tipo);		
		}
		else
		{
			$html = "null";		
		}
		
		echo $html;
	}
	
	if($_GET['action'] == 'Listar_Marcas_Autocompletar')
	{
		$html = "";
		
		if(isset($_POST["Marca"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["Marca"])));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;	

		try
		{
			if((isset($_POST["Marca"])) and ($_POST["Marca"] != ""))
			{
				$stmt = $db->prepare("SELECT id_marca,descripcion_marca FROM marcas WHERE descripcion_marca LIKE '".$criterio."'");			
			}
			else
			{
				$stmt = $db->prepare("SELECT id_marca,descripcion_marca FROM marcas WHERE descripcion_marca LIKE '".$criterio."%' group by descripcion_marca");
			}
			
			$stmt->execute();
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
				
			$c = 0;
			$Marca = array();	
			foreach ($rows as $row)
			{
				$Marca[$c]['value'] = utf8_encode($row['descripcion_marca']);
				$Marca[$c]['hidMarca'] = utf8_encode(base64_encode($row['id_marca']));
				$c++;
			}
			
			$html = json_encode($Marca);		
		}
		else
		{
			$html = "null";		
		}
		
		echo $html;
	}	
	
	
	if($_GET['action'] == 'Listar_Modelos_Autocompletar')
	{
		$html = "";
		
		if(isset($_POST["Modelo"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["Modelo"])));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;	
	
		try
		{
			if((isset($_POST["Modelo"])) and ($_POST["Modelo"] != ""))
			{
				$stmt = $db->prepare("SELECT id_modelo,descripcion_modelo FROM modelos WHERE descripcion_modelo LIKE '".$criterio."'");			
			}
			else
			{
				$stmt = $db->prepare("SELECT id_modelo,descripcion_modelo FROM modelos WHERE descripcion_modelo LIKE '".$criterio."%'");
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
			$Modelo = array();	
			foreach ($rows as $row)
			{
				$Modelo[$c]['value'] = utf8_encode($row['descripcion_modelo']);
				$Modelo[$c]['hidModelo'] = utf8_encode(base64_encode($row['id_modelo']));
				$c++;
			}
			
			$html = json_encode($Modelo);		
		}
		else
		{
			$html = "null";		
		}
		
		echo $html;
	}	
		
	
	if($_GET['action'] == 'Listar_Tamanos_Autocompletar')
	{
		$html = "";
		
		if(isset($_POST["Tamano"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["Tamano"])));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;		
		
		
		try
		{
			if((isset($_POST["Tamano"])) and ($_POST["Tamano"] != ""))
			{
				$stmt = $db->prepare("SELECT id_tamano,descripcion_tamano FROM tamanos WHERE descripcion_tamano LIKE '".$criterio."'");			
			}
			else
			{
				$stmt = $db->prepare("SELECT id_tamano,descripcion_tamano FROM tamanos WHERE descripcion_tamano LIKE '".$criterio."%'");
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
			$Tamano = array();	
			foreach ($rows as $row)
			{
				$Tamano[$c]['value'] = utf8_encode($row['descripcion_tamano']);
				$Tamano[$c]['hidTamano'] = utf8_encode(base64_encode($row['id_tamano']));
				$c++;
			}
			$html = json_encode($Tamano);		
		}
		else
		{
			$html = "null";		
		}
				
		echo $html;
	}
	
	if($_GET['action'] == 'Listar_Colores_Autocompletar')
	{
		$html = "";
		
		if(isset($_POST["Color"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["Color"])));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;			
		
		
		try
		{
			if((isset($_POST["Color"])) and ($_POST["Color"] != ""))
			{
				$stmt = $db->prepare("SELECT id_color,descripcion_color FROM colores WHERE descripcion_color LIKE '".$criterio."'");			
			}
			else
			{
				$stmt = $db->prepare("SELECT id_color,descripcion_color FROM colores WHERE descripcion_color LIKE '".$criterio."%'");
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
			$Color = array();	
			foreach ($rows as $row)
			{
				$Color[$c]['value'] = utf8_encode($row['descripcion_color']);
				$Color[$c]['hidColor'] = utf8_encode(base64_encode($row['id_color']));				
				$c++;
			}
			$html = json_encode($Color);		
		}
		else
		{
			$html = "null";		
		}		
		
		echo $html;
	}
	
	
	if($_GET['action'] == 'Listar_Tipo_Producto')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM tipo_producto");
			
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
				$html .= "<option value='".base64_encode($row['id_tipo_producto'])."'>".utf8_encode($row['descripcion_tipo_producto'])."</option>";
			}
		}
		
		echo $html;
	}	
	
	if($_GET['action'] == 'Listar_Tipo_Categoria')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM categoria ORDER BY descripcion_categoria ASC");
			
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
				$html .= "<option value='".base64_encode($row['id_categoria'])."'>".$row['descripcion_categoria']."</option>";
			}
		}
		
		echo $html;
	}

	if($_GET['action'] == 'Calcular_Precio')	
	{

		$html = "";
		
		$TipoCategoria = base64_decode($_POST['TipoCategoria']);
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
			$c = 1;
			$stmt->bindParam($c,$TipoCategoria,PDO::PARAM_INT);
			
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
			foreach ($rows as $row)
			{
				$Precio_Venta = $_POST['Costo'] + $_POST['Costo']*$row['porcentaje'];
				$Precio_Venta = number_format($Precio_Venta,2,'.','');
			}
		}else{
			$Precio_Venta = 0;
		}
		
		echo $Precio_Venta;
	}	
	
	if($_GET['action'] == 'Listar_Tipo_Empaque')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM tipo_empaque ORDER BY `descripcion_empaque` ASC");
			
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
				$html .= "<option value='".base64_encode($row['id_tipo_empaque'])."'>".$row['descripcion_empaque']."</option>";
			}
		}
		
		echo $html;
	}	

	if($_GET['action'] == 'Listar_Codigo_Barra_Autocompletar')
	{
		$html = "";
		
		$Proveedor = strip_tags(utf8_decode(base64_decode($_GET['idP'])));
		$Tipo = strip_tags(utf8_decode(base64_decode($_GET['tipo'])));
				
		if(isset($_POST["CodigoBarra"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["CodigoBarra"])));		

		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;		
		

		try
		{
			if((isset($_POST["CodigoBarra"])) and ($_POST["CodigoBarra"] != ""))
			{
				if ($Tipo == 1)
				{
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE codigo_barra LIKE '".$criterio."' AND id_proveedor = ".$Proveedor);
				}
				else			
				{
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE codigo_barra LIKE '".$criterio."'");		
				}			
			}
			else
			{
				if ($Tipo == 1)
				{
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE codigo_barra LIKE '".$criterio."%' AND id_proveedor = ".$Proveedor);
				}
				else			
				{
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE codigo_barra LIKE '".$criterio."%'");		
				}
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
			$CodigoProducto = array();	
			foreach ($rows as $row)
			{
				$CodigoProducto[$c]['value'] = utf8_encode($row['codigo_barra']);
				$CodigoProducto[$c]['hidProducto'] = utf8_encode(base64_encode($row['id_producto']));
				$CodigoProducto[$c]['txtNombreProducto'] = utf8_encode($row['nombre_producto']);
				$c++;
			}
			
			$html = json_encode($CodigoProducto);

		}
		else
		{
			$html = "null";		
		
		}			
		
		echo $html;
	}	

	if($_GET['action'] == 'Listar_Nombre_Producto_Autocompletar')
	{
		$html = "";
		
		$Proveedor = strip_tags(utf8_decode(base64_decode($_GET['idP'])));
		$Tipo = strip_tags(utf8_decode(base64_decode($_GET['tipo'])));
		
		if(isset($_POST["NombreProducto"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["NombreProducto"])));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;		
		
		
		try
		{
			if((isset($_POST["NombreProducto"])) and ($_POST["NombreProducto"] != ""))
			{
				if ($Tipo == 1)
				{	
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto 
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE nombre_producto LIKE '".$criterio."' AND id_proveedor = ".$Proveedor);
				}
				else			
				{
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto 
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE nombre_producto LIKE '".$criterio."'");	
										
				}
			}
			else
			{
				if ($Tipo == 1)
				{	
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto 
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE nombre_producto LIKE '".$criterio."%' AND id_proveedor = ".$Proveedor);
				}
				else			
				{
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto 
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE nombre_producto LIKE '".$criterio."%'");	
										
				}
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
			$DescripcionProducto = array();
			foreach ($rows as $row)
			{
				$DescripcionProducto[$c]['value'] = utf8_encode($row['nombre_producto']);
				$DescripcionProducto[$c]['hidProducto'] = utf8_encode(base64_encode($row['id_producto']));
				$DescripcionProducto[$c]['txtCodigoBarra'] = utf8_encode($row['codigo_barra']);
				$c++;
			}
			$html = json_encode($DescripcionProducto);		
		}
		else
		{
			$html = "null";		
		}
		
		echo $html;
	}
	
	
	if($_GET['action'] == 'Listar_Codigo_Barra_Venta_Autocompletar')
	{
		$html = "";
		
		$Proveedor = strip_tags(utf8_decode(base64_decode($_GET['idP'])));
		$Tipo = strip_tags(utf8_decode(base64_decode($_GET['tipo'])));
				
		if(isset($_POST["CodigoBarra"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["CodigoBarra"])));		

		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;		
		

		try
		{
			if((isset($_POST["CodigoBarra"])) and ($_POST["CodigoBarra"] != ""))
			{
				if ($Tipo == 1)
				{
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto,precio_venta  
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE codigo_barra LIKE '".$criterio."' AND id_proveedor = ".$Proveedor);
				}
				else			
				{
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto,precio_venta  
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE codigo_barra LIKE '".$criterio."'");		
				}			
			}
			else
			{
				if ($Tipo == 1)
				{
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto,precio_venta  
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE codigo_barra LIKE '".$criterio."%' AND id_proveedor = ".$Proveedor);
				}
				else			
				{
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto,precio_venta  
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE codigo_barra LIKE '".$criterio."%'");		
				}
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
			$CodigoProducto = array();	
			foreach ($rows as $row)
			{
				$CodigoProducto[$c]['value'] = utf8_encode($row['codigo_barra']);
				$CodigoProducto[$c]['hidIdProducto'] = utf8_encode(base64_encode($row['id_producto']));
				$CodigoProducto[$c]['txtNombreProducto'] = utf8_encode($row['nombre_producto']);
				$CodigoProducto[$c]['txtPrecio'] = utf8_encode($row['precio_venta']);
				$CodigoProducto[$c]['hidPrecio'] = utf8_encode($row['precio_venta']);
				
				$c++;
			}
			
			$html = json_encode($CodigoProducto);

		}
		else
		{
			$html = "null";		
		
		}			
		
		echo $html;
	}	

	if($_GET['action'] == 'Listar_Nombre_Producto_Venta_Autocompletar')
	{
		$html = "";
		
		$Proveedor = strip_tags(utf8_decode(base64_decode($_GET['idP'])));
		$Tipo = strip_tags(utf8_decode(base64_decode($_GET['tipo'])));
		
		if(isset($_POST["NombreProducto"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["NombreProducto"])));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;		
		
		
		try
		{
			if((isset($_POST["NombreProducto"])) and ($_POST["NombreProducto"] != ""))
			{
				if ($Tipo == 1)
				{	
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto,precio_venta  
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE nombre_producto LIKE '".$criterio."' AND id_proveedor = ".$Proveedor);
				}
				else			
				{
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto,precio_venta   
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE nombre_producto LIKE '".$criterio."'");	
										
				}
			}
			else
			{
				if ($Tipo == 1)
				{	
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto,precio_venta   
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE nombre_producto LIKE '".$criterio."%' AND id_proveedor = ".$Proveedor);
				}
				else			
				{
					$stmt = $db->prepare("SELECT id_producto,codigo_barra,descripcion_color,nombre_producto,precio_venta   
										FROM producto p INNER JOIN colores c ON (c.id_color = p.id_color)
										WHERE nombre_producto LIKE '".$criterio."%'");	
										
				}
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
			$NombreProducto = array();
			foreach ($rows as $row)
			{
				$NombreProducto[$c]['value'] = utf8_encode($row['nombre_producto']);
				$NombreProducto[$c]['hidIdProducto'] = utf8_encode(base64_encode($row['id_producto']));
				$NombreProducto[$c]['txtCodigoBarra'] = utf8_encode($row['codigo_barra']);
				$NombreProducto[$c]['txtPrecio'] = utf8_encode($row['precio_venta']);
				$NombreProducto[$c]['hidPrecio'] = utf8_encode($row['precio_venta']);				
				$c++;
			}
			$html = json_encode($NombreProducto);		
		}
		else
		{
			$html = "null";		
		}
		
		echo $html;
	}	
	
	if($_GET['action'] == 'Listar_Producto_Select')
	{
	
		$html = "";
		
		try
		{		

			$stmt = $db->prepare("SELECT * FROM producto p 
			LEFT JOIN categoria c ON (p.id_categoria = c.id_categoria) 
			INNER JOIN tipo_empaque te ON (p.id_tipo_empaque = te.id_tipo_empaque)");
			
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
				$html .= "<option value='".$row['id_producto']."'>".$row['nombre_producto']."</option>";
			}
		}
		
		echo $html;
		
	}

	if($_GET['action'] == 'Listar_Producto_Autocompletar')
	{	
	
		$html = "";
		
		if(isset($_GET["v"]))
		$venta_rapida = strip_tags(utf8_decode($_GET["v"]));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		if(isset($_GET["search"]))		
		$criterio = strtolower($_GET["search"]);
		
		if (!$criterio) return;
				
		try
		{		

			$stmt = $db->prepare("SELECT id_producto, nombre_producto AS value, descripcion_producto, p.id_tipo_empaque, descripcion_empaque, precio_venta FROM producto p 
			LEFT JOIN categoria c ON (p.id_categoria = c.id_categoria) 
			INNER JOIN tipo_empaque te ON (p.id_tipo_empaque = te.id_tipo_empaque)
			WHERE nombre_producto like '".$criterio."%'");

			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}

		$c = 0;
		$producto = array();
		
		if($venta_rapida != 1)
		{
			if (((strpos("trabajo de imprenta", $criterio))!==false) and ((substr($criterio,0,1)) == "t"))
			{
				$producto[$c]['id_producto'] = "timp";	
				$producto[$c]['value'] = "Trabajo de Imprenta";
				$producto[$c]['id_tipo_empaque'] = "";
				$producto[$c]['descripcion_empaque'] = "Unidad";
				$producto[$c]['precio_venta'] = "0.00";
				
				$c++;
			}
			
			if (((strpos("trabajo de banner", $criterio))!==false) and ((substr($criterio,0,1)) == "t"))
			{
				$producto[$c]['id_producto'] = "tbnr";
				$producto[$c]['value'] = "Trabajo de Banner";
				$producto[$c]['id_tipo_empaque'] = "";
				$producto[$c]['descripcion_empaque'] = "Unidad";
				$producto[$c]['precio_venta'] = "0.00";			
				
				$c++;
			}

			if (((strpos("trabajo de impresion", $criterio))!==false) and ((substr($criterio,0,1)) == "t"))
			{
				$producto[$c]['id_producto'] = "timpart";
				$producto[$c]['value'] = "Trabajo de Impresiones";
				$producto[$c]['id_tipo_empaque'] = "";
				$producto[$c]['descripcion_empaque'] = "Unidad";
				$producto[$c]['precio_venta'] = "0.00";			
				
				$c++;
			}
		}
		
		/*if (((strpos("libreta factura", $criterio))!==false) and ((substr($criterio,0,1)) == "l"))
		{
			$producto[$c] = "Libreta Factura";
			$c++;
		}
		if (((strpos("libreta", $criterio))!==false) and ((substr($criterio,0,1)) == "l"))
		{
			$producto[$c] = "Libreta";		
			$c++;
		}*/
		
		if ($nfilas > 0)
		{
			foreach ($rows as $row)
			{
				$producto[$c]['id_producto'] = $row['id_producto'];
				$producto[$c]['value'] = $row['value'];
				$producto[$c]['id_tipo_empaque'] = $row['id_tipo_empaque'];
				$producto[$c]['descripcion_empaque'] = $row['descripcion_empaque'];	
				$producto[$c]['precio_venta'] = $row['precio_venta'];	
				
				$c++;
			}
		}
		
		$html = json_encode($producto);
		
		echo $html;	
	
	
	
	}
	
	if($_GET['action'] == 'BuscarID_Producto')
	{	
	
		$response = "";
		$Nombre_Producto	= strip_tags(utf8_decode($_POST['NombreProducto']));
		
		try
		{		

			$stmt = $db->prepare("SELECT * FROM producto p 
			INNER JOIN categoria c ON (p.id_categoria = c.id_categoria) 
			INNER JOIN tipo_empaque te ON (p.id_tipo_empaque = te.id_tipo_empaque)
			WHERE descripcion_producto like ?");

			$c = 1;
			$stmt->bindParam($c,$Nombre_Producto,PDO::PARAM_STR,255);		
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}


		$response = json_encode($rows);


		
		echo $response;	
	
	
	
	}
	
	if($_GET['action'] == 'Producto_Seleccionado')
	{
		try
		{
			$id_producto = $_POST['IdProducto'];
			$stmt = $db->prepare("SELECT * FROM producto p 
			INNER JOIN categoria c ON (p.id_categoria = c.id_categoria) 
			INNER JOIN tipo_empaque te ON (p.id_tipo_empaque = te.id_tipo_empaque)
			WHERE id_producto = ?");
			
			$c = 1;
			$stmt->bindParam($c,$id_producto,PDO::PARAM_INT);			

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
			$response = json_encode($rows);
		}		
	
		echo $response;
	
	}	
	
	if($_GET['action'] == 'Subir_Imagen_Producto')
	{	
	
		$ruta="../../public/images/imagen_producto/";
		$ruta1="public/images/imagen_producto/";
		$Response = array();
		//$ruta="";	
		
		//print_r($_FILES);	
		if($_FILES)
		{
			foreach ($_FILES as $key) {
				if(($key['error'] == UPLOAD_ERR_OK ) and ((stripos($key['type'],"jpg") != false) or (stripos($key['type'],"jpeg") != false) or (stripos($key['type'],"gif") != false) or (stripos($key['type'],"png") != false)))
				{//Verificamos si se subio correctamente
					$nombre = $key['name'];//Obtenemos el nombre del archivo
					$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
					//$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
					$tamano= $key['size']; //Obtenemos el tamaño en KB
					move_uploaded_file($temporal, $ruta . $nombre); //Movemos el archivo temporal a la ruta especificada

					$Response['result'] = "true";
					$Response['msj'] = "";
					$Response['url'] = $ruta1.$nombre;
				}
				else if(($key['error'] == UPLOAD_ERR_OK ) and ((stripos($key['type'],"jpg") === false) and (stripos($key['type'],"jpeg") === false) and (stripos($key['type'],"gif") === false) and (stripos($key['type'],"png") === false)))
				{
					$Response['result'] = "false";
					$Response['msj'] = "Error Guardar Imagen de Producto, tipo de Archivo de Imagen Incorrecto.  Solo JPEG,GIF o PNG.";
					$Response['url'] = "";								
				}
				else
				{
					$Response['result'] = "false";
					$Response['msj'] = "Error Guardar Imagen de Producto";
					$Response['url'] = "";
					//echo $key['error']; //Si no se cargo mostramos el error
				}
				$f++;
			}
		}
		else
		{
			$Response['result'] = "true";
			$Response['msj'] = "";
			//$Response['msj'] = "Debes Insertar la Imagen del Producto";
			$Response['url'] = "";			
		}
		
		echo json_encode($Response);	
	}
	
	if($_GET['action'] == 'Agregar_Producto')
	{
		session_start();
		$db->beginTransaction();
		try
		{	
			print_r($_POST);

			$IdTipoProducto = (isset($_POST['IdTipoProducto'])) ? strip_tags(utf8_decode(base64_decode($_POST['IdTipoProducto']))) : '';
			$Nombre_Producto = (isset($_POST['NombreProducto'])) ? strip_tags(utf8_decode($_POST['NombreProducto'])) : '';
			$CodGrupoProducto = '';
			$CodigoBarra = (isset($_POST['CodigoBarra'])) ? strip_tags(utf8_decode($_POST['CodigoBarra'])) : '';
			$IdTipo = (isset($_POST['IdTipo'])) ? strip_tags(utf8_decode(base64_decode($_POST['IdTipo']))) : '';
			$TipoProducto = (isset($_POST['Tipo'])) ? strip_tags(utf8_decode($_POST['Tipo'])) : '';
			$IdMarca = (isset($_POST['IdMarca'])) ? strip_tags(utf8_decode(base64_decode($_POST['IdMarca']))) : '';
			$Marca = (isset($_POST['Marca'])) ? trim(strip_tags(utf8_decode($_POST['Marca']))) : '';
			$IdModelo = (isset($_POST['IdModelo'])) ? strip_tags(utf8_decode(base64_decode($_POST['IdModelo']))) : '';
			$Modelo = (isset($_POST['Modelo'])) ? trim(strip_tags(utf8_decode($_POST['Modelo']))) : '';
			$IdColor = (isset($_POST['IdColor'])) ? strip_tags(utf8_decode(base64_decode($_POST['IdColor']))) : '';
			$Color = (isset($_POST['Color'])) ? trim(strip_tags(utf8_decode($_POST['Color']))) : '';
			$IdTamano = (isset($_POST['IdTamano'])) ? strip_tags(utf8_decode(base64_decode($_POST['IdTamano']))) : '';
			$Tamano = (isset($_POST['Tamano'])) ? trim(strip_tags(utf8_decode($_POST['Tamano']))) : '';
			$Id_Categoria = (isset($_POST['TipoCategoria'])) ? strip_tags(utf8_decode(base64_decode($_POST['TipoCategoria']))) : '';
			$IdProveedor = (isset($_POST['IdProveedor'])) ? strip_tags(utf8_decode(base64_decode($_POST['IdProveedor']))) : '';
			$Proveedor = (isset($_POST['Proveedor'])) ? trim(strip_tags(utf8_decode($_POST['Proveedor']))) : '';
			$Id_Ubicacion = (isset($_POST['Ubicacion'])) ? strip_tags(utf8_decode(base64_decode($_POST['Ubicacion']))) : '';
			$Costo = (isset($_POST['Costo'])) ? strip_tags(utf8_decode($_POST['Costo'])) : 0;
			$Precio_Venta = (isset($_POST['PrecioVenta'])) ? strip_tags(utf8_decode($_POST['PrecioVenta'])) : '';
			$Id_Tipo_Empaque = (isset($_POST['TipoPaquete'])) ? strip_tags(utf8_decode(base64_decode($_POST['TipoPaquete']))) : '';
			$Cantidad_Existencia_Inicial = 0;
			$Cantidad_Minima = (isset($_POST['CantMin']) ) ? strip_tags(utf8_decode($_POST['CantMin'])) : 0;
			$Cantidad_Alerta_Minima = 0;
			$Observacion_Producto = (isset($_POST['ObservacionProducto'])) ? strip_tags(utf8_decode($_POST['ObservacionProducto'])) : '';
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Producto Agregado";
			$Tipo = "4";

			$CodigoProducto = "";
			$CodigoProducto = $CodigoProducto.$IdProveedor;

			if($IdTipoProducto == 2){
				if ($IdTipo == ""){
					$stmt = $db->prepare("INSERT INTO tipo_descripcion_producto (descripcion_tipo,fecha_agregado)
					VALUES (?,'".date('Y-m-d H:i:s')."')");	
					
					$p = 1;
					$stmt->bindParam($p,$TipoProducto,PDO::PARAM_STR,255);				
					
					$TipoInsertado = $stmt->execute();
					echo " TipoInsertado QUERY -> ".$TipoInsertado;

					$stmt = $db->query("SELECT MAX(id_tipo) AS Id_Tipo FROM tipo_descripcion_producto");
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$IdTipo = $results[0]["Id_Tipo"];
					echo " IdTipo -> ".$IdTipo;

					$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo;
				}else{
					$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo;
				}		

				// ESTO NO SE ESTA GUARDANDO !!
				if ($IdMarca == ""){ 
					$stmt = $db->prepare("INSERT INTO marcas (descripcion_marca,fecha_agregado)
					VALUES (?,'".date('Y-m-d H:i:s')."')");	
					
					$p = 1;
					$stmt->bindParam($p,$Marca,PDO::PARAM_STR,255);				
					
					$MarcaInsertado = $stmt->execute();
					echo " MarcaInsertado QUERY -> ".$MarcaInsertado;

					$stmt = $db->query("SELECT MAX(id_marca) AS Id_Marca FROM marcas");
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$IdMarca = $results[0]["Id_Marca"];
					echo " IdMarca -> ".$IdMarca;


					$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca;
				}else{
					$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca;
				}
				
				// ESTO TAMPOCO SE ESTA GUARDANDO
				if ($IdModelo == ""){
					$stmt = $db->prepare("INSERT INTO modelos (descripcion_modelo,fecha_agregado)
					VALUES (?,'".date('Y-m-d H:i:s')."')");	
					
					$p = 1;
					$stmt->bindParam($p,$Modelo,PDO::PARAM_STR,255);				
					
					$ModeloInsertado = $stmt->execute();
					
					$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Modelo");
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$IdModelo = $results[0]["Id_Modelo"];
					
					$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca.$IdModelo;
				}else{
					$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca.$IdModelo;
				}
				

				if ($IdTamano == ""){			
					$stmt = $db->prepare("INSERT INTO tamanos (descripcion_tamano,fecha_agregado)
					VALUES (?,'".date('Y-m-d H:i:s')."')");	

					$p = 1;
					$stmt->bindParam($p,$Tamano,PDO::PARAM_STR,255);	
					
					$TamanoInsertado = $stmt->execute();
					
					$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Tamano");
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$IdTamano = $results[0]["Id_Tamano"];
					
					$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca.$IdModelo.$IdTamano;			
				}else{
					$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca.$IdModelo.$IdTamano;	
				}			
				
				// esto no se esta guardando
				if ($IdColor == ""){			
					$stmt = $db->prepare("INSERT INTO colores (descripcion_color,fecha_agregado)
					VALUES (?,'".date('Y-m-d H:i:s')."')");	

					$p = 1;
					$stmt->bindParam($p,$Color,PDO::PARAM_STR,255);	
					
					$ColorInsertado = $stmt->execute();
					
					$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Color");
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$IdColor = $results[0]["Id_Color"];
					
					$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca.$IdModelo.$IdTamano.$IdColor;
				}else{
					$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca.$IdModelo.$IdTamano.$IdColor;
				}	

				print_r($CodigoProducto);
				// ESTO TAMPOCO SE ESTA AGREGANDO
				$query = mysqli_query ($mysqli, "INSERT INTO producto 
				(id_tipo_producto, nombre_producto, descripcion_producto, codigo_producto, codigo_barra, id_tipo, id_marca, id_modelo,
				id_color, id_tamano, id_categoria, id_proveedor, id_ubicacion, costo, precio_venta, id_tipo_empaque, cantidad_existencia,
				cantidad_minima, cantidad_alerta_minima, observacion_producto, fecha_creado, ultima_actualizacion)
				VALUES (".$IdTipoProducto.", 
				'".$Nombre_Producto."', 
				NULL,
				'".$CodigoProducto."',
				'".$CodigoBarra."', 
				".$IdTipo.",
				".$IdMarca.",
				".$IdModelo.",
				".$IdColor.",
				".$IdTamano.",
				".$Id_Categoria.",
				".$IdProveedor.",
				".$Id_Ubicacion.",
				".$Costo.",
				".$Precio_Venta.", 
				".$Id_Tipo_Empaque.", 
				".$Cantidad_Existencia_Inicial.", 
				".$Cantidad_Minima.", 
				".$Cantidad_Alerta_Minima.", 
				'".$Observacion_Producto."', 
				NOW(),
				NULL)");

				$inserted = 1;
			}else{

					$idCategoriaServicio = 41;
					$idTipoEmpaqueServicio = 15; 


				$query = mysqli_query ($mysqli, "INSERT INTO producto 
				(id_tipo_producto, nombre_producto, descripcion_producto, codigo_producto, codigo_barra, id_tipo, id_marca, id_modelo,
				id_color, id_tamano, id_categoria, id_proveedor, id_ubicacion, costo, precio_venta, id_tipo_empaque, cantidad_existencia,
				cantidad_minima, cantidad_alerta_minima, observacion_producto, fecha_creado, ultima_actualizacion)
				VALUES (".$IdTipoProducto.", 
				'".$Nombre_Producto."', 
				NULL,
				NULL,
				'".$CodigoBarra."', 
				NULL,
				NULL,
				NULL,
				NULL,
				NULL,
				'".$idCategoriaServicio."',
				NULL,
				NULL,
				".$Costo.",
				".$Precio_Venta.", 
				'".$idTipoEmpaqueServicio."', 
				0, 
				0, 
				0, 
				'".$Observacion_Producto."', 
				NOW(),
				NULL)");

				$inserted = 1;
			}
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		if ($inserted == 1){
			echo "true";
			$db->commit();
		}else{
			$db->rollBack();
		}	
	}

	if($_GET['action'] == 'Listar_Productos')
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
			array( 'db' => 'id_producto', 'dt' => 0 ),
			array( 'db' => 'nombre_producto',  'dt' => 1 ),
			array( 'db' => 'costo',   'dt' => 2 ),
			array( 'db' => 'descripcion_categoria',   'dt' => 3 ),
			array( 'db' => 'precio_venta',   'dt' => 4 ),
			array( 'db' => 'descripcion_empaque',   'dt' => 5 ),
			array( 'db' => 'cantidad_minima',   'dt' => 6 ),
			array( 'db' => 'opciones',   'dt' => 7 ),			
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS p.id_producto,p.nombre_producto,p.costo,c.descripcion_categoria,p.precio_venta,te.descripcion_empaque, p.cantidad_minima, c.id_categoria, te.id_tipo_empaque 
				FROM producto p 
				INNER JOIN categoria c ON (p.id_categoria = c.id_categoria) 
				INNER JOIN tipo_empaque te ON (p.id_tipo_empaque = te.id_tipo_empaque) ".$where."  ".$order." ".$limit);
						
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

			$stmt = $db->prepare("SELECT count(id_producto)
			FROM producto p 
			LEFT JOIN categoria c ON (p.id_categoria = c.id_categoria) 
			LEFT JOIN tipo_empaque te ON (p.id_tipo_empaque = te.id_tipo_empaque)");			
				
			$stmt->execute();			
			$recordsTotal = $stmt->fetchColumn (0);
			
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
			
		/*$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable"><thead><tr>';			

		$html .= '<th style="width:2%"></th>
				<th style="width:10%">Nombre del Producto
				<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
				<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
				<th style="width:28%">Descripci&oacute;n de Producto</th>
				<th style="width:5%">Costo</th>
				<th style="width:10%">Categor&iacute;a del Producto</th>
				<th style="width:5%">Precio de Venta</th>				
				<th style="width:10%">Tipo de Empaque</th>
				<th style="width:5%">Cantidad en Existencia Inicial</th>				
				<th style="width:5%">Cantidad M&iacute;nima</th>				
				<th style="width:7%">Cant. Alr. M&iacute;n.</th>
				<th style="width:13%">Opciones</th>';	

		$html .= '</tr>
            </thead>
            <tbody>';
			  			  
			  

		if ($nfilas > 0)
		{
				
			$c = 1;
			foreach ($rows as $row)
			{
				
				$Sql = "SELECT * FROM historial_producto hpdo
				INNER JOIN user_log ul ON (hpdo.id_log = ul.id_log)
				INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)";					
				
				$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
						<td>'.$c.'</td>
						<td>'.utf8_encode($row['nombre_producto']).'<input type="hidden" id="hidNombreProducto'.$c.'" name="hidNombreProducto[]" value="'.utf8_encode($row['nombre_producto']).'" /></td>
						<td>'.utf8_encode($row['descripcion_producto']).'<input type="hidden" id="hidDescripcionProducto'.$c.'" name="hidDescripcionProducto[]" value="'.utf8_encode($row['descripcion_producto']).'" /></td>						
						<td>B/.&nbsp;'.utf8_encode(number_format($row['costo'],2,'.','')).'<input type="hidden" id="hidCosto'.$c.'" name="hidCosto[]" value="'.utf8_encode(number_format($row['costo'],2,'.','')).'" /></td>
						<td>'.utf8_encode($row['descripcion_categoria']).'<input type="hidden" id="hidTipoCategoria'.$c.'" name="hidTipoCategoria[]" value="'.utf8_encode($row['id_categoria']).'" /><input type="hidden" id="hidDescTipoCategoria'.$c.'" name="hidDescTipoCategoria[]" value="'.utf8_encode($row['descripcion_categoria']).'" /></td>
						<td>B/.&nbsp;'.utf8_encode(number_format($row['precio_venta'],2,'.','')).'<input type="hidden" id="hidPrecioVenta'.$c.'" name="hidPrecioVenta[]" value="'.utf8_encode(number_format($row['precio_venta'],2,'.','')).'" /></td>						
						<td>'.utf8_encode($row['descripcion_empaque']).'<input type="hidden" id="hidTipoPaquete'.$c.'" name="hidTipoPaquete[]" value="'.utf8_encode($row['id_tipo_empaque']).'" /><input type="hidden" id="hidDescTipoPaquete'.$c.'" name="hidDescTipoPaquete[]" value="'.utf8_encode($row['descripcion_empaque']).'" /></td>
						<td>'.utf8_encode($row['cantidad_existencia']).'<input type="hidden" id="hidCantExistInicial'.$c.'" name="hidCantExistInicial[]" value="'.utf8_encode($row['cantidad_existencia']).'" /></td>												
						<td>'.utf8_encode($row['cantidad_minima']).'<input type="hidden" id="hidCantMin'.$c.'" name="hidCantMin[]" value="'.utf8_encode($row['cantidad_minima']).'" /></td>						
						<td>'.utf8_encode($row['cantidad_alerta_minima']).'<input type="hidden" id="hidCantAlertMin'.$c.'" name="hidCantAlertMin[]" value="'.utf8_encode($row['cantidad_alerta_minima']).'" /></td>
						<td><a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Producto('.$c.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
						
					if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
					$html .='<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Producto?\')){Eliminar_Producto('.$c.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					
					$html .='<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_producto'])).'" /></td>					
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
				$Data[$f][$c] = utf8_encode($row['nombre_producto']).'<input type="hidden" id="hidNombreProducto'.$f.'" name="hidNombreProducto[]" value="'.utf8_encode($row['nombre_producto']).'" />';
				$c++;
				$Data[$f][$c] = 'B/.&nbsp;'.utf8_encode(number_format($row['costo'],2,'.','')).'<input type="hidden" id="hidCosto'.$f.'" name="hidCosto[]" value="'.utf8_encode(number_format($row['costo'],2,'.','')).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['descripcion_categoria']).'<input type="hidden" id="hidTipoCategoria'.$f.'" name="hidTipoCategoria[]" value="'.utf8_encode($row['id_categoria']).'" /><input type="hidden" id="hidDescTipoCategoria'.$f.'" name="hidDescTipoCategoria[]" value="'.utf8_encode($row['descripcion_categoria']).'" />';
				$c++;
				$Data[$f][$c] = 'B/.&nbsp;'.utf8_encode(number_format($row['precio_venta'],2,'.','')).'<input type="hidden" id="hidPrecioVenta'.$f.'" name="hidPrecioVenta[]" value="'.utf8_encode(number_format($row['precio_venta'],2,'.','')).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['descripcion_empaque']).'<input type="hidden" id="hidTipoPaquete'.$f.'" name="hidTipoPaquete[]" value="'.utf8_encode($row['id_tipo_empaque']).'" /><input type="hidden" id="hidDescTipoPaquete'.$f.'" name="hidDescTipoPaquete[]" value="'.utf8_encode($row['descripcion_empaque']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['cantidad_minima']).'<input type="hidden" id="hidCantMin'.$f.'" name="hidCantMin[]" value="'.utf8_encode($row['cantidad_minima']).'" />';			
				$c++;
				
				$Data[$f][$c] = "";
				$Data[$f][$c] .= '<a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Producto('.$f.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';				
				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				$Data[$f][$c] .= '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Producto?\')){Eliminar_Producto('.$f.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
				$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_producto'])).'" />';
				
				$f = $f + 1;
			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;		
		echo json_encode($ResultSet);		
	}

	if($_GET['action'] == 'Ver_Producto')
	{
		try
		{
			

			$id_producto = strip_tags(utf8_decode($_POST['IdProducto']));

			

			$stmt = $db->prepare("SELECT id_producto,id_tipo_producto,p.id_categoria,p.id_tipo_empaque,codigo_barra,codigo_producto,p.id_tipo,descripcion_tipo,p.id_marca,descripcion_marca,p.id_modelo,descripcion_modelo,nombre_producto,
			descripcion_producto,costo,precio_venta,p.id_tamano,descripcion_tamano,p.id_color,descripcion_color,cantidad_existencia,cantidad_alerta_minima,cantidad_minima,observacion_producto,p.id_ubicacion
			FROM producto p 
			INNER JOIN categoria cat ON (p.id_categoria = cat.id_categoria) 
			INNER JOIN tipo_empaque te ON (p.id_tipo_empaque = te.id_tipo_empaque)
			LEFT JOIN colores c ON (c.id_color = p.id_color)
			LEFT JOIN modelos m ON (m.id_modelo = p.id_modelo)
			LEFT JOIN marcas ma ON (ma.id_marca = p.id_marca)
			LEFT JOIN tamanos t ON (t.id_tamano = p.id_tamano)
			LEFT JOIN tipo_descripcion_producto tdp ON (tdp.id_tipo = p.id_tipo)
			LEFT JOIN ubicaciones u ON (u.id_ubicacion = p.id_ubicacion)
			WHERE MD5(id_producto) = ?");
			
			$p = 1;
			$stmt->bindParam($p,$id_producto,PDO::PARAM_STR,255);			

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
			$Producto = array();
			foreach ($rows as $row)
			{

				$Producto[$c]['txtCodigoProducto'] = utf8_encode($row['codigo_producto']);
				$Producto[$c]['txtCodigoBarra'] = utf8_encode($row['codigo_barra']);
				$Producto[$c]['lstTipoProducto'] = utf8_encode(base64_encode($row['id_tipo_producto']));
				$Producto[$c]['lstTipoPaquete'] = utf8_encode(base64_encode($row['id_tipo_empaque']));
				$Producto[$c]['lstCategoria'] = utf8_encode(base64_encode($row['id_categoria']));
				$Producto[$c]['lstUbicacion'] = utf8_encode(base64_encode($row['id_ubicacion']));				
				$Producto[$c]['txtTipo'] = utf8_encode($row['descripcion_tipo']);
				$Producto[$c]['hidTipo'] = utf8_encode(base64_encode($row['id_tipo']));				
				$Producto[$c]['txtModelo'] = utf8_encode($row['descripcion_modelo']);
				$Producto[$c]['hidModelo'] = utf8_encode(base64_encode($row['id_modelo']));
				$Producto[$c]['txtProveedor'] = utf8_encode($row['descripcion_marca']);
				$Producto[$c]['hidProveedor'] = utf8_encode(base64_encode($row['id_marca']));				
				$Producto[$c]['txtMarca'] = utf8_encode($row['descripcion_marca']);
				$Producto[$c]['hidMarca'] = utf8_encode(base64_encode($row['id_marca']));	
				$Producto[$c]['txtNombreProducto'] = utf8_encode($row['nombre_producto']);
				$Producto[$c]['txtCosto'] = utf8_encode(number_format($row['costo'],2,'.',''));
				$Producto[$c]['txtPrecioVenta'] = utf8_encode(number_format($row['precio_venta'],2,'.',''));
				$Producto[$c]['txtTamano'] = utf8_encode($row['descripcion_tamano']);
				$Producto[$c]['hidTamano'] = utf8_encode(base64_encode($row['id_tamano']));
				$Producto[$c]['txtColor'] = utf8_encode($row['descripcion_color']);
				$Producto[$c]['hidColor'] = utf8_encode(base64_encode($row['id_color']));
				$Producto[$c]['txtCantExistInicial'] = utf8_encode($row['cantidad_existencia']);
				$Producto[$c]['txtCantMin'] = utf8_encode($row['cantidad_minima']);
				$Producto[$c]['txtObservacionProducto'] = utf8_encode($row['observacion_producto']);
				// $Producto[$c]['imgImagenProducto'] = utf8_encode($row['imagen_producto']);
				
				$c++;
			}
		}		

		if ($nfilas > 0)
		{
			$response = json_encode($Producto);
		}		
		
		
		echo $response;
	
	}	

	if($_GET['action'] == 'Actualizar_Producto')
	{
	
		session_start();	
		$db->beginTransaction();
		try
		{
			$Codigo_Producto = strip_tags(utf8_decode($_POST['CodigoProducto']));
			$CodigoBarra = strip_tags(utf8_decode($_POST['CodigoBarra']));
			$Nombre_Producto	= strip_tags(utf8_decode($_POST['NombreProducto']));
			$IdTipoProducto = strip_tags(utf8_decode(base64_decode($_POST['IdTipoProducto'])));	
			$IdTipo = strip_tags(utf8_decode(base64_decode($_POST['IdTipo'])));
			$TipoProducto = strip_tags(utf8_decode($_POST['Tipo']));
			$IdProveedor = strip_tags(utf8_decode(base64_decode($_POST['IdProveedor'])));
			$Proveedor = strip_tags(utf8_decode($_POST['Proveedor']));
			$Proveedor = trim($Proveedor);			
			$IdMarca = strip_tags(utf8_decode(base64_decode($_POST['IdMarca'])));
			$Marca = strip_tags(utf8_decode($_POST['Marca']));
			$Marca = trim($Marca);			
			$IdModelo = strip_tags(utf8_decode(base64_decode($_POST['IdModelo'])));
			$Modelo = strip_tags(utf8_decode($_POST['Modelo']));
			$Modelo = trim($Modelo);
			$IdTamano = strip_tags(utf8_decode(base64_decode($_POST['IdTamano'])));
			$Tamano = strip_tags(utf8_decode($_POST['Tamano']));
			$Tamano = trim($Tamano);
			$IdColor = strip_tags(utf8_decode(base64_decode($_POST['IdColor'])));
			$Color = strip_tags(utf8_decode($_POST['Color']));
			$Color = trim($Color);			
			$Costo = strip_tags(utf8_decode($_POST['Costo']));
			$Id_Categoria = strip_tags(utf8_decode(base64_decode($_POST['TipoCategoria'])));
			$Id_Ubicacion = strip_tags(utf8_decode(base64_decode($_POST['Ubicacion'])));			
			$Id_Tipo_Empaque = strip_tags(utf8_decode(base64_decode($_POST['TipoPaquete'])));			
			$Precio_Venta = strip_tags(utf8_decode($_POST['PrecioVenta']));
			$Cantidad_Minima = strip_tags(utf8_decode($_POST['CantMin']));			
			$Observacion_Producto = strip_tags(utf8_decode($_POST['ObservacionProducto']));
			$Id_Producto = strip_tags(utf8_decode($_POST['IdProducto']));
			$ImagenProducto = (isset($_POST['ImagenProducto']))?strip_tags($_POST['ImagenProducto']):"";				
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Producto Agregado";
			$Tipo = "4";

			$CodigoProducto = "";
			$CodigoProducto = $CodGrupoProducto.$IdProveedor;
		
			if ($IdTipo == "")
			{
				$stmt = $db->prepare("INSERT INTO tipo_descripcion_producto (descripcion_tipo,fecha_agregado)
				VALUES (?,'".date('Y-m-d H:i:s')."')");	
				
				$p = 1;
				$stmt->bindParam($p,$TipoProducto,PDO::PARAM_STR,255);				
				
				$TipoInsertado = $stmt->execute();
				
				$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Tipo");
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$IdTipo = $results[0]["Id_Tipo"];
				
				$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo;
				
			}
			else
			{
				$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo;
			}		
		
			if ($IdMarca == "")
			{
				$stmt = $db->prepare("INSERT INTO marcas (descripcion_marca,fecha_agregado)
				VALUES (?,'".date('Y-m-d H:i:s')."')");	
				
				$p = 1;
				$stmt->bindParam($p,$Marca,PDO::PARAM_STR,255);				
				
				$MarcaInsertado = $stmt->execute();
				
				$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Marca");
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$IdMarca = $results[0]["Id_Marca"];
				
				$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca;
				
			}
			else
			{
				$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca;
			}
			
			if ($IdModelo == "")
			{
				$stmt = $db->prepare("INSERT INTO modelos (descripcion_modelo,fecha_agregado)
				VALUES (?,'".date('Y-m-d H:i:s')."')");	
				
				$p = 1;
				$stmt->bindParam($p,$Modelo,PDO::PARAM_STR,255);				
				
				$ModeloInsertado = $stmt->execute();
				
				$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Modelo");
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$IdModelo = $results[0]["Id_Modelo"];
				
				$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca.$IdModelo;
				
			}
			else
			{
				$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca.$IdModelo;
			}
			
			if ($IdTamano == "")
			{			
				$stmt = $db->prepare("INSERT INTO tamanos (descripcion_tamano,fecha_agregado)
				VALUES (?,'".date('Y-m-d H:i:s')."')");	

				$p = 1;
				$stmt->bindParam($p,$Tamano,PDO::PARAM_STR,255);	
				
				$TamanoInsertado = $stmt->execute();
				
				$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Tamano");
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$IdTamano = $results[0]["Id_Tamano"];
				
				$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca.$IdModelo.$IdTamano;			
			}
			else
			{
				$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca.$IdModelo.$IdTamano;	
			}			
			
			if ($IdColor == "")
			{			
				$stmt = $db->prepare("INSERT INTO colores (descripcion_color,fecha_agregado)
				VALUES (?,'".date('Y-m-d H:i:s')."')");	

				$p = 1;
				$stmt->bindParam($p,$Color,PDO::PARAM_STR,255);	
				
				$ColorInsertado = $stmt->execute();
				
				$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Color");
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$IdColor = $results[0]["Id_Color"];
				
				$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca.$IdModelo.$IdTamano.$IdColor;
				
			}
			else
			{
				$CodigoProducto = $CodGrupoProducto.$IdProveedor.$IdTipo.$IdMarca.$IdModelo.$IdTamano.$IdColor;
				
			}			
			
			if ($IdTipoProducto == 1)			
			$stmt = $db->prepare("UPDATE producto SET id_tipo_producto=?,nombre_producto=?,costo=?,id_categoria=?,precio_venta=?,cantidad_existencia=0,cantidad_minima=0,cantidad_alerta_minima=0,ultima_actualizacion=NOW()
			WHERE MD5(id_producto)=?");
			else
			{
				if($ImagenProducto != "")
				$stmt = $db->prepare("UPDATE producto SET id_tipo_producto=?,nombre_producto=?,codigo_barra=?,codigo_producto=?,id_tipo=?,id_proveedor=?,id_marca=?,id_modelo=?,id_tamano=?,id_color=?,costo=?,id_categoria=?,id_ubicacion=?,id_tipo_empaque=?,precio_venta=?,cantidad_minima=?,observacion_producto=?,imagen_producto=?,ultima_actualizacion=NOW()
				WHERE MD5(id_producto)=?");				
				else
				$stmt = $db->prepare("UPDATE producto SET id_tipo_producto=?,nombre_producto=?,codigo_barra=?,codigo_producto=?,id_tipo=?,id_proveedor=?,id_marca=?,id_modelo=?,id_tamano=?,id_color=?,costo=?,id_categoria=?,id_ubicacion=?,id_tipo_empaque=?,precio_venta=?,cantidad_minima=?,observacion_producto=?,ultima_actualizacion=NOW()
				WHERE MD5(id_producto)=?");
			}
			$c = 1;
			$stmt->bindParam($c,$IdTipoProducto,PDO::PARAM_STR,255);			
			$c++;
			$stmt->bindParam($c,$Nombre_Producto,PDO::PARAM_STR,255);			
			$c++;			
			if ($IdTipoProducto == 2)
			{

				$stmt->bindParam($c,$CodigoBarra,PDO::PARAM_STR,255);
				$c++;				
				$stmt->bindParam($c,$CodigoProducto,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$IdTipo,PDO::PARAM_STR,255);
				$c++;				
				$stmt->bindParam($c,$IdProveedor,PDO::PARAM_STR,255);				
				$c++;				
				$stmt->bindParam($c,$IdMarca,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$IdModelo,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$IdTamano,PDO::PARAM_STR,255);
				$c++;
				$stmt->bindParam($c,$IdColor,PDO::PARAM_STR,255);
				$c++;
			}
			$stmt->bindParam($c,$Costo,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Id_Categoria,PDO::PARAM_INT);
			$c++;
			
			if ($IdTipoProducto == 2)
			{			
				$stmt->bindParam($c,$Id_Ubicacion,PDO::PARAM_INT);
				$c++;					
				$stmt->bindParam($c,$Id_Tipo_Empaque,PDO::PARAM_INT);
				$c++;
			}
			$stmt->bindParam($c,$Precio_Venta,PDO::PARAM_STR,255);
			$c++;
			if ($IdTipoProducto == 2)
			{
				$stmt->bindParam($c,$Cantidad_Minima,PDO::PARAM_INT);	
				$c++;
				$stmt->bindParam($c,$Observacion_Producto,PDO::PARAM_STR,255);
				$c++;
				if($ImagenProducto != "")
				{
					$stmt->bindParam($c,$ImagenProducto,PDO::PARAM_STR,255);				
					$c++;
				}
			}

			$stmt->bindParam($c,$Id_Producto,PDO::PARAM_STR,255);			
					
			$Actualizado = $stmt->execute();
			//print_r($stmt->errorInfo());
		
			$stmt = $db->prepare("SELECT * FROM producto WHERE md5(id_producto) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Producto,PDO::PARAM_STR,255);
			$stmt->execute();
			
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_producto = $results[0]["id_producto"];	
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
				
			$stmt = $db->prepare("INSERT INTO historial_producto (id_producto,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_producto,PDO::PARAM_INT);
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
	
	if($_GET['action'] == 'Eliminar_Producto')	
	{

		session_start();
		$db->beginTransaction();
		try
		{
			$Id_Producto = strip_tags(utf8_decode($_POST['IdProducto']));				
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Producto Eliminado";
			$Tipo = "12";			
			
			$stmt = $db->prepare("SELECT * FROM producto WHERE MD5(id_producto) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Producto,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_producto = $results[0]["id_producto"];	
			$stmt->closeCursor();			
			
			$stmt = $db->prepare("DELETE FROM producto WHERE MD5(id_producto) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Producto,PDO::PARAM_STR,255);

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
				
			$stmt = $db->prepare("INSERT INTO historial_producto (id_producto,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_producto,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();				
				
			$stmt->closeCursor();
				
		}
			catch(PDOException $e) {
			echo $e->getMessage();
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

	if($_GET['action'] == 'Listar_Categoria_Productos')	
	{

		$html = "";
		$html1 = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT id_categoria,descripcion_categoria FROM categoria");
			
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
				$html .= '<div class="widget"><a class="wButton redwB" name="Categoria[]" id="Categoria'.$c.'" onclick="Listar_Productos_por_Categoria(\''.base64_encode(md5($row['id_categoria'])).'\')">'.$row['descripcion_categoria'].'</a></div>';
				$c++;
			}
				
		}
		
		echo $html;	
	}
	
	if($_GET['action'] == 'Listar_Productos_Mas_Vendidos')	
	{

		$html = "";
		$html1 = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT vp.id_producto,c.descripcion_categoria,pr.nombre_proveedor,p.codigo_producto,
			nombre_producto,p.precio_venta, COUNT(vp.id_producto) AS Cantidad,imagen_categoria
			FROM venta_detalle vp
			INNER JOIN producto p ON (vp.id_producto = p.id_producto)
			INNER JOIN proveedores pr ON (pr.id_proveedor = p.id_proveedor)
			INNER JOIN categoria c ON (c.id_categoria = p.id_categoria)
			GROUP BY id_producto
			ORDER BY Cantidad DESC LIMIT 0,10");
			
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
			//$html .= '<ul>';
			
			$c = 1;
			foreach ($rows as $row)
			{
				//$html .= '<li><a onmouseover="this.style.cursor=\'pointer\'" onmouseout="this.style.cursor=\'default\'" onclick="Agregar_Articulo_Venta(\''.base64_encode($row['id_producto']).'\')" title="'.$row['descripcion_producto'].'"><img src="public/images/icons/control/32/copia.png" alt="" /><span>'.$row['descripcion_producto'].'</span></a></li>';
				$html .= '<div class="controlB"><ul><li><a class="" onmouseover="this.style.cursor=\'pointer\'" onmouseout="this.style.cursor=\'default\'" onclick="Agregar_Articulo_Venta(\''.base64_encode($row['id_producto']).'\')"  title="'.$row['nombre_producto'].'"><img src="'.(($row['imagen_categoria']=="")?"public/images/noimage.png":$row['imagen_categoria']).'" alt="" width="64" height="64" /><span>'.$row['codigo_producto'].'</span></a></li></ul></div>';
				
				$c++;
			}
			
			//$html .= '</ul>';	
		}
		
		echo $html;	
	}	
	
	if($_GET['action'] == 'Listar_Productos_por_Categoria')	
	{
		
		$CategoriaProducto = strip_tags(utf8_decode(base64_decode($_POST['CategoriaProducto'])));		

		$html = "";
		
		try
		{		
			if($CategoriaProducto != "")
			$Sql = "SELECT id_producto,nombre_producto,codigo_producto,imagen_producto FROM producto WHERE MD5(id_categoria) = ? AND id_tipo_producto = 2";
			else
			$Sql = "SELECT id_producto,nombre_producto,codigo_producto,imagen_producto FROM producto WHERE id_categoria = 1 AND id_tipo_producto = 2";		
		
			$stmt = $db->prepare($Sql);
			
			$p = 1;		
			if($CategoriaProducto != "")
			{
				$stmt->bindParam($p,$CategoriaProducto,PDO::PARAM_STR,255);
				$p++;
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
			//$html .= '<ul>';
	
			$c = 0;$i=0;
			foreach ($rows as $row)
			{
				if($i%6==0)
				$html .= '<div class="controlB">
							<div class="formRow" id="CodigoBarra">
								<label for="labelFor">Buscar Producto:</label>								
								<div class="formRight">
									<input type="text" id="txtBuscarProducto" name="txtBuscarProducto" value=""  class="form-control"  style="width:90%;"/>
									<input type="hidden" id="hidBuscarProducto" name="hidBuscarProducto" value=""/>
								</div>								
								<div class="clear">
								</div>
							</div>	
							<ul>';
				
				if($c<6)
				$html .= '<li>
							<a class="" onmouseover="this.style.cursor=\'pointer\'" onmouseout="this.style.cursor=\'default\'" onclick="Agregar_Articulo_Venta(\''.base64_encode($row['id_producto']).'\')"  title="'.$row['nombre_producto'].'">
								<img src="'.(($row['imagen_producto']=="")?"public/images/noimage.png":$row['imagen_producto']).'" alt="" width="64" height="64" />
								<span>'.$row['codigo_producto'].'</span>
							</a>
						</li>';
				
				if($i%6==5)
				{
					$html .= '</ul>
					</div>';
					$c = 0;
				}

				$i++;
		
			}
			
			//$html .= '</ul>';	
		}
		
		echo $html;	

			
		/*$html = "";
		session_start();
		$objDatabase = new Database();
		$bindings = array();
		$ResultSet = array();
		$Length = ($_POST['length']);
		$Start = ($_POST['start']);
		$Draw = ($_POST['draw']);		
		$CategoriaProducto = strip_tags(utf8_decode(base64_decode($_POST['CategoriaProducto'])));

		$limit = $objDatabase->limit($_POST);

		$columns = array(
			array( 'db' => 'id_producto', 'dt' => 0 ),
			array( 'db' => 'nombre_producto',  'dt' => 1 ),
			array( 'db' => 'codigo_producto',  'dt' => 2 ),
			array( 'db' => 'imagen_producto',  'dt' => 3 ),
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];		
		
		try
		{		
			if($CategoriaProducto != "")
			$Sql1 = "SELECT id_producto,nombre_producto,codigo_producto,imagen_producto FROM producto WHERE MD5(id_categoria) = ? AND id_tipo_producto = 2";
			else
			$Sql1 = "SELECT id_producto,nombre_producto,codigo_producto,imagen_producto FROM producto WHERE id_categoria = 1 AND id_tipo_producto = 2";
			
			$Sql = "SELECT SQL_CALC_FOUND_ROWS id_producto,nombre_producto,codigo_producto,imagen_producto FROM (".$Sql1.") AS T ".$where."  ".$order." ".$limit;
			
			$stmt = $db->prepare($Sql);			
								
			if ( is_array( $bindings ) ) {
				for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
					$binding = $bindings[$i];
					$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
				}
			}
			
			$p = 1;		
			if($CategoriaProducto != "")
			{
				$stmt->bindParam($p,$CategoriaProducto,PDO::PARAM_STR,255);
				$p++;
			}
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			
			$stmt = $db->prepare("SELECT FOUND_ROWS()");
			
			$stmt->execute();
			$resFilterLength = $stmt->fetchColumn (0);	

			if($CategoriaProducto != "")
			$Sql = "SELECT count(id_producto) FROM producto WHERE MD5(id_categoria) = ? AND id_tipo_producto = 2";
			else
			$Sql = "SELECT count(id_producto) FROM producto WHERE id_categoria = 1 AND id_tipo_producto = 2";	
			
			$stmt = $db->prepare($Sql);		
			
			$p = 1;
			if ($CategoriaProducto != "")
			{
				$stmt->bindParam($p,$CategoriaProducto,PDO::PARAM_STR,255);
				$p++;
			}

			$stmt->execute();			
			$recordsTotal = $stmt->fetchColumn (0);		
			
			$stmt->execute();			
			
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
				$Data[$f][$c] = '<span onclick="Agregar_Articulo_Venta(\''.base64_encode($row['id_producto']).'\')">'.($f+1).'</span>';
				$c++;
				$Data[$f][$c] = '<span onclick="Agregar_Articulo_Venta(\''.base64_encode($row['id_producto']).'\')">'.utf8_encode($row['nombre_producto']).'</span><input type="hidden" name="hidProducto" id="hidProducto" value="'.base64_encode($row['id_producto']).'" />';
				$c++;
				$Data[$f][$c] = '<span onclick="Agregar_Articulo_Venta(\''.base64_encode($row['id_producto']).'\')">'.utf8_encode($row['codigo_producto']).'</span>';				
				$c++;
				$Data[$f][$c] = '<span onclick="Agregar_Articulo_Venta(\''.base64_encode($row['id_producto']).'\')"><img src="'.utf8_encode($row['imagen_producto']).'" width="64" alt="" /></span>';				

				
				$f = $f + 1;
			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;
		echo json_encode($ResultSet);*/		
	}
	
	if($_GET['action'] == 'Listar_Producto_Venta_Rapida_Autocompletar')
	{
		$html = "";
		
		if(isset($_POST["NombreProducto"]))
		$criterio = strip_tags(utf8_decode(strtolower($_POST["NombreProducto"])));		
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		//if(isset($_GET["search"]))		
		//$criterio = strtolower($_GET["search"]);
		
		if ((!$criterio) and ($criterio != "0")) return;		
		
		
		try
		{
			if((isset($_POST["NombreProducto"])) and ($_POST["NombreProducto"] != ""))
			{
				$stmt = $db->prepare("SELECT id_producto,nombre_producto,codigo_producto,imagen_producto FROM producto WHERE nombre_producto LIKE '".$criterio."' AND id_tipo_producto = 2");
			}
			else
			{
				$stmt = $db->prepare("SELECT id_producto,nombre_producto,codigo_producto,imagen_producto FROM producto WHERE nombre_producto LIKE '%".$criterio."%' AND id_tipo_producto = 2");								
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
			$DescripcionProducto = array();
			foreach ($rows as $row)
			{
				$DescripcionProducto[$c]['value'] = utf8_encode($row['nombre_producto']);
				$DescripcionProducto[$c]['hidBuscarProducto'] = utf8_encode(base64_encode(md5($row['id_producto'])));
				$DescripcionProducto[$c]['hidProductoBuscar'] = utf8_encode(base64_encode(md5($row['id_producto'])));
				$c++;
			}
			$html = json_encode($DescripcionProducto);		
		}
		else
		{
			$html = "null";		
		}
		
		echo $html;
	}	
	
	if($_GET['action'] == 'Listar_Productos_por_Busqueda')	
	{
		$BuscarProducto = strip_tags(utf8_decode(base64_decode($_POST['BuscarProducto'])));		

		$html = "";
		
		try
		{		
			if(md5($BuscarProducto) != md5(""))
			$Sql = "SELECT id_producto,nombre_producto,codigo_producto,imagen_producto FROM producto WHERE MD5(id_producto) = ? AND id_tipo_producto = 2";
			else
			$Sql = "SELECT id_producto,nombre_producto,codigo_producto,imagen_producto FROM producto WHERE id_tipo_producto = 2";		
		
			$stmt = $db->prepare($Sql);
			
			$p = 1;		
			if(md5($BuscarProducto) != md5(""))
			{
				$stmt->bindParam($p,$BuscarProducto,PDO::PARAM_STR,255);
				$p++;
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
			//$html .= '<ul>';
	
			$c = 0;$i=0;
			foreach ($rows as $row)
			{
				if($i%6==0)
				$html .= '<div class="controlB">
							<div class="formRow" id="CodigoBarra">
								<label for="labelFor">Buscar Producto:</label>								
								<div class="formRight">
									<input type="text" id="txtBuscarProducto" name="txtBuscarProducto" value=""  class="form-control"  style="width:90%;"/>
									<input type="hidden" id="hidBuscarProducto" name="hidBuscarProducto" value=""/>
								</div>								
								<div class="clear">
								</div>
							</div>	
							<ul>';
				
				if($c<6)
				$html .= '<li>
							<a class="" onmouseover="this.style.cursor=\'pointer\'" onmouseout="this.style.cursor=\'default\'" onclick="Agregar_Articulo_Venta(\''.base64_encode($row['id_producto']).'\')"  title="'.$row['nombre_producto'].'">
								<img src="'.(($row['imagen_producto']=="")?"public/images/noimage.png":$row['imagen_producto']).'" alt="" width="64" height="64" />
								<span>'.$row['codigo_producto'].'</span>
							</a>
						</li>';
				
				if($i%6==5)
				{
					$html .= '</ul>
					</div>';
					$c = 0;
				}

				$i++;
		
			}
			
			//$html .= '</ul>';	
		}
		
		echo $html;	

	}
	
	if($_GET['action'] == 'Listar_Inventario_Productos')	
	{
		$html = "";
		session_start();
		$objDatabase = new Database();
		$bindings = array();
		$ResultSet = array();
		$Length = ($_POST['length']);
		$Start = ($_POST['start']);
		$Draw = ($_POST['draw']);		
		$TipoCategoria = strip_tags(utf8_decode(base64_decode($_POST['TipoCategoria'])));
		$Proveedor = strip_tags(utf8_decode(base64_decode($_POST['Proveedor'])));

		$limit = $objDatabase->limit($_POST);

		$columns = array(
			array( 'db' => 'id_producto', 'dt' => 0 ),
			array( 'db' => 'descripcion_categoria',  'dt' => 1 ),
			array( 'db' => 'nombre_proveedor',   'dt' => 2 ),
			array( 'db' => 'nombre_producto',   'dt' => 3 ),
			array( 'db' => 'codigo_producto',   'dt' => 4 ),
			array( 'db' => 'total_bodega',   'dt' => 5 ),
			array( 'db' => 'total_tienda',   'dt' => 6 ),
			array( 'db' => 'total_inventario',   'dt' => 7 ),
			array( 'db' => 'total_inventario_costo',   'dt' => 7 ),
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			$where1 = "";			
			if ($TipoCategoria != "")
			$where1 .= " AND p.id_categoria = ?";
			else
			$where1 = "";
			
			if ($Proveedor != "")
			$where1 .= " AND p.id_proveedor = ?";
			else
			$where1 .= "";					
					
			
			
			$Sql1 = "SELECT c.descripcion_categoria,pr.nombre_proveedor,m.id_producto,codigo_producto,nombre_producto,id_bodega,id_tienda,
			(IFNULL(SUM(balance_bodega),0)) AS total_bodega,(IFNULL(SUM(balance_tienda),0)) AS total_tienda,(IFNULL(SUM(balance_bodega),0) + (IFNULL(SUM(balance_tienda),0))) AS total_inventario,
			((IFNULL(SUM(balance_bodega),0) + (IFNULL(SUM(balance_tienda),0)))*costo) AS total_inventario_costo
			FROM movimientos m
			INNER JOIN producto p ON (m.id_producto = p.id_producto)
			INNER JOIN proveedores pr ON (pr.id_proveedor = p.id_proveedor)
			INNER JOIN categoria c ON (c.id_categoria = p.id_categoria)
			WHERE m.estatus_movimiento = 1 ".$where1."
			GROUP BY m.id_producto";
			
			$Sql = "SELECT SQL_CALC_FOUND_ROWS descripcion_categoria,nombre_proveedor,id_producto,codigo_producto,nombre_producto,id_bodega,id_tienda,total_bodega,total_tienda,total_inventario,total_inventario_costo
			FROM (".$Sql1.") AS T ".$where." ".$order." ".$limit;			
			
			$stmt = $db->prepare($Sql);			
							
			if ( is_array( $bindings ) ) {
				for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
					$binding = $bindings[$i];
					$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
				}
			}
			$p = 1;
			if ($TipoCategoria != "")
			{
				$stmt->bindParam($p,$TipoCategoria,PDO::PARAM_STR,255);
				$p++;
			}
			
			if ($Proveedor != "")
			{
				$stmt->bindParam($p,$Proveedor,PDO::PARAM_STR,255);
				$p++;	
			}				
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			
			$stmt = $db->prepare("SELECT FOUND_ROWS()");
			
			$stmt->execute();
			$resFilterLength = $stmt->fetchColumn (0);

			$stmt = $db->prepare("SELECT count(DISTINCT m.id_producto)
			FROM movimientos m
			INNER JOIN producto p ON (m.id_producto = p.id_producto)
			INNER JOIN proveedores p ON (p.id_proveedor = p.id_proveedor)
			INNER JOIN categoria c ON (c.id_categoria = c.id_categoria) WHERE m.estatus_movimiento = 1 ".$where1);			
		
			$p = 1;
			if ($TipoCategoria != "")
			{
				$stmt->bindParam($p,$TipoCategoria,PDO::PARAM_STR,255);
				$p++;
			}
			
			if ($Proveedor != "")
			{
				$stmt->bindParam($p,$Proveedor,PDO::PARAM_STR,255);
				$p++;	
			}			
			
			$stmt->execute();			
			$recordsTotal = $stmt->fetchColumn (0);		
			
			$stmt->execute();			
			
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
				$Data[$f][$c] = utf8_encode($row['descripcion_categoria']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['nombre_proveedor']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['nombre_producto']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['codigo_producto']);	
				$c++;
				$Data[$f][$c] = utf8_encode($row['total_bodega']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['total_tienda']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['total_inventario']);
				$c++;
				$Data[$f][$c] = utf8_encode(number_format($row['total_inventario_costo'],2,'.',''));				
											
				$f = $f + 1;
			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;
		echo json_encode($ResultSet);
	
	}
	
	if($_GET['action'] == 'Listar_Precios_Productos')
	{
		$html = "";
		session_start();
		$objDatabase = new Database();
		$bindings = array();
		$ResultSet = array();
		$Length = ($_POST['length']);
		$Start = ($_POST['start']);
		$Draw = ($_POST['draw']);	
		
		$TipoCategoria = strip_tags(utf8_decode(base64_decode($_POST['TipoCategoria'])));
		$Proveedor = strip_tags(utf8_decode(base64_decode($_POST['Proveedor'])));

		$limit = $objDatabase->limit($_POST);

		$columns = array(
			array( 'db' => 'id_producto', 'dt' => 0 ),
			array( 'db' => 'descripcion_categoria',  'dt' => 1 ),
			array( 'db' => 'nombre_proveedor',   'dt' => 2 ),
			array( 'db' => 'nombre_producto',   'dt' => 3 ),
			array( 'db' => 'codigo_producto',   'dt' => 4 ),
			array( 'db' => 'precio_venta',   'dt' => 5 ),
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{	
			$where1 = "";
			if ($TipoCategoria != "")
			{
				$where1  .= (($where1=="")?" WHERE":" AND")."";				
				$where1  .= " p.id_categoria = ?";
			}
			else
			$where1 = "";
			
			if ($Proveedor != "")
			{
				$where1 .= (($where1=="")?" WHERE":" AND")."";								
				$where1 .= " p.id_proveedor = ?";
			}
			else
			$where1 .= "";	
		
			$Sql1 = "SELECT p.id_producto,c.descripcion_categoria,pr.nombre_proveedor,p.codigo_producto,nombre_producto,p.precio_venta
			FROM producto p INNER JOIN proveedores pr ON (pr.id_proveedor = p.id_proveedor)
			INNER JOIN categoria c ON (c.id_categoria = p.id_categoria) ".$where1;			
			
			$Sql = "SELECT SQL_CALC_FOUND_ROWS descripcion_categoria,nombre_proveedor,id_producto,codigo_producto,nombre_producto,precio_venta 
			FROM (".$Sql1.") AS T ".$where." ".$order." ".$limit;				
		
			$stmt = $db->prepare($Sql);			
							
			if ( is_array( $bindings ) ) {
				for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
					$binding = $bindings[$i];
					$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
				}
			}
			
			$p = 1;
			if ($TipoCategoria != "")
			{
				$stmt->bindParam($p,$TipoCategoria,PDO::PARAM_STR,255);
				$p++;
			}
			
			if ($Proveedor != "")
			{
				$stmt->bindParam($p,$Proveedor,PDO::PARAM_STR,255);
				$p++;	
			}					
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();

			$stmt = $db->prepare("SELECT FOUND_ROWS()");
			
			$stmt->execute();
			$resFilterLength = $stmt->fetchColumn (0);

			$stmt = $db->prepare("SELECT count(DISTINCT id_producto)
			FROM producto p INNER JOIN proveedores pr ON (pr.id_proveedor = p.id_proveedor)
			INNER JOIN categoria c ON (c.id_categoria = p.id_categoria) ".$where1);			
		
			$p = 1;
			if ($TipoCategoria != "")
			{
				$stmt->bindParam($p,$TipoCategoria,PDO::PARAM_STR,255);
				$p++;
			}
			
			if ($Proveedor != "")
			{
				$stmt->bindParam($p,$Proveedor,PDO::PARAM_STR,255);
				$p++;	
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
				$Data[$f][$c] = $f+1;
				$c++;
				$Data[$f][$c] = utf8_encode($row['descripcion_categoria']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['nombre_proveedor']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['nombre_producto']);
				$c++;
				$Data[$f][$c] = utf8_encode($row['codigo_producto']);	
				$c++;
				$Data[$f][$c] = utf8_encode(number_format($row['precio_venta'],2,'.',''));			
											
				$f = $f + 1;
			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;
		echo json_encode($ResultSet);		
		
	}	
	
	if($_GET['action'] == 'Subir_Imagen_Categoria_Producto')
	{	
	
		$ruta="../../public/images/imagen_categoria_producto/";
		$ruta1="public/images/imagen_categoria_producto/";
		$Response = array();
		//$ruta="";	
		if($_FILES)
		{
			foreach ($_FILES as $key) {
				if(($key['error'] == UPLOAD_ERR_OK ) and ((stripos($key['type'],"jpg") != false) or (stripos($key['type'],"jpeg") != false) or (stripos($key['type'],"gif") != false) or (stripos($key['type'],"png") != false)))
				{//Verificamos si se subio correctamente
					$nombre = $key['name'];//Obtenemos el nombre del archivo
					$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
					//$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
					$tamano= $key['size']; //Obtenemos el tamaño en KB
					move_uploaded_file($temporal, $ruta . $nombre); //Movemos el archivo temporal a la ruta especificada

					$Response['result'] = "true";
					$Response['msj'] = "";
					$Response['url'] = $ruta1.$nombre;
				}
				else if(($key['error'] == UPLOAD_ERR_OK ) and ((stripos($key['type'],"jpg") === false) and (stripos($key['type'],"jpeg") === false) and (stripos($key['type'],"gif") === false) and (stripos($key['type'],"png") === false)))
				{
					$Response['result'] = "false";
					$Response['msj'] = "Error Guardar Imagen de Categor&iacute;a del Producto, tipo de Archivo de Imagen Incorrecto.  Solo JPEG,GIF o PNG.".$key['type'];
					$Response['url'] = "";								
				}
				else
				{
					$Response['result'] = "false";
					$Response['msj'] = "Error Guardar Imagen de Categor&iacute;a del Producto";
					$Response['url'] = "";
					//echo $key['error']; //Si no se cargo mostramos el error
				}
				$f++;
			}
		}
		else
		{
			$Response['result'] = "true";
			$Response['msj'] = "";
			//$Response['msj'] = "Debes Insertar la Imagen de Categor&iacute;a del Producto";
			$Response['url'] = "";			
		}
		
		echo json_encode($Response);	
	}	
	
	if($_GET['action'] == 'Agregar_Categoria_Producto')
	{
	
		session_start();
		$db->beginTransaction();
		try
		{
			print_r($_POST);

			$NombreCategoriaProducto = strip_tags(utf8_decode($_POST['NombreCategoriaProducto']));
			$Porcentaje = $_POST['Porcentaje'];
			echo "Categoria -> ".$NombreCategoriaProducto;
			echo "Porcentaje -> ".$Porcentaje;
			// $ImagenCategoriaProducto = (isset($_POST['ImagenCategoriaProducto']))?strip_tags($_POST['ImagenCategoriaProducto']):"";	
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Categoria de Producto Agregado";
			$Tipo = "4";


			$stmt = $db->prepare("INSERT INTO categoria (descripcion_categoria, porcentaje, fecha_agregado) VALUES (?,?,'".date('Y-m-d H:i:s')."')");	
			
			
			$p = 1;
			$stmt->bindParam($p,$NombreCategoriaProducto,PDO::PARAM_STR,255);			
			$p++;
			$stmt->bindParam($p,$Porcentaje,PDO::PARAM_STR,255);
			// $p++;
			// $stmt->bindParam($p,$ImagenCategoriaProducto,PDO::PARAM_STR,255);			
			
			$Insertado = $stmt->execute();
			//print_r($stmt->errorInfo());

			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Categoria_Producto");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Categoria_Producto = $results[0]["Id_Categoria_Producto"];	

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
				
			$stmt = $db->prepare("INSERT INTO historial_categoria_producto (id_categoria_producto,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$Id_Categoria_Producto,PDO::PARAM_INT);
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

	if($_GET['action'] == 'Listar_Categorias_Productos')
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
			array( 'db' => 'id_categoria', 'dt' => 0 ),
			array( 'db' => 'descripcion_categoria',  'dt' => 1 ),
			array( 'db' => 'porcentaje',   'dt' => 2 ),
			array( 'db' => 'opciones',   'dt' => 3 ),			
		);
		
		$order = $objDatabase->order($_POST,$columns);
				
		$Where = $objDatabase->filter($_POST,$columns,$bindings);
		$where = $Where['sql'];
		$bindings = $Where['bindings'];
		
		try
		{		
			$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS id_categoria,descripcion_categoria,porcentaje
			FROM categoria ".$where."  ".$order." ".$limit);
						
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

			$stmt = $db->prepare("SELECT count(id_categoria_producto)
			FROM categoria");			
				
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
				$Data[$f][$c] = utf8_encode($row['descripcion_categoria']).'<input type="hidden" id="hidCategoriaProducto'.$f.'" name="hidCategoriaProducto[]" value="'.utf8_encode($row['descripcion_categoria']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode(number_format($row['porcentaje'],2,'.','')).'&nbsp;%<input type="hidden" id="hidPorcentaje'.$f.'" name="hidPorcentaje[]" value="'.utf8_encode(number_format($row['porcentaje'],2,'.','')).'" />';
				$c++;
				
				$Data[$f][$c] = "";
				$Data[$f][$c] .= '<a href="javascript:void(0);" title="Editar" class="smallButton" style="margin: 5px;" onclick="Editar_Categoria_Producto('.$f.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';				
				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
				$Data[$f][$c] .= '<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar esta Categoria de Producto?\')){Eliminar_Categoria_Producto('.$f.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
				$Data[$f][$c] .= '<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_categoria'])).'" />';
				
				$f = $f + 1;
			}

		}

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;		
		echo json_encode($ResultSet);		
	}

	if($_GET['action'] == 'Ver_Categoria_Producto')
	{
		try
		{
			$id_categoria_producto = strip_tags(utf8_decode($_POST['IdCatProducto']));
			$stmt = $db->prepare("SELECT id_categoria,descripcion_categoria,porcentaje
			FROM categoria
			WHERE MD5(id_categoria) = ?");
			
			$p = 1;
			$stmt->bindParam($p,$id_categoria_producto,PDO::PARAM_STR,255);			

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
			$Producto = array();
			foreach ($rows as $row)
			{
				$Producto[$c]['txtNombreCategoriaProducto'] = utf8_encode($row['descripcion_categoria']);
				$Producto[$c]['txtPorcentaje'] = utf8_encode(number_format($row['porcentaje'],2,'.',''));
				// $Producto[$c]['imgImagenCategoriaProducto'] = utf8_encode($row['imagen_categoria']);				
				$c++;
			}
		}		

		if ($nfilas > 0)
		{
			$response = json_encode($Producto);
		}		
	
		echo $response;	
	
	}

	if($_GET['action'] == 'Actualizar_Categoria_Producto')
	{
	
		session_start();
		$db->beginTransaction();
		try
		{
			$NombreCategoriaProducto = strip_tags(utf8_decode($_POST['NombreCategoriaProducto']));
			$Porcentaje = strip_tags(utf8_decode($_POST['Porcentaje']));
			$ImagenCategoriaProducto = (isset($_POST['ImagenCategoriaProducto']))?strip_tags($_POST['ImagenCategoriaProducto']):"";			
			$id_categoria_producto = strip_tags(utf8_decode($_POST['IdCatProducto']));
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Categoria de Producto Actualizado";
			$Tipo = "4";

			if($ImagenCategoriaProducto != "")
			$stmt = $db->prepare("UPDATE categoria SET descripcion_categoria=?,porcentaje=?,imagen_categoria=?,fecha_actualizado='".date('Y-m-d H:i:s')."'
			WHERE MD5(id_categoria) = ?");				
			else
			$stmt = $db->prepare("UPDATE categoria SET descripcion_categoria=?,porcentaje=?,fecha_actualizado='".date('Y-m-d H:i:s')."'
			WHERE MD5(id_categoria) = ?");	
			
			
			$p = 1;
			$stmt->bindParam($p,$NombreCategoriaProducto,PDO::PARAM_STR,255);			
			$p++;
			$stmt->bindParam($p,$Porcentaje,PDO::PARAM_STR,255);
			$p++;
			if($ImagenCategoriaProducto != "")
			{
				$stmt->bindParam($p,$ImagenCategoriaProducto,PDO::PARAM_STR,255);
				$p++;
			}
			$stmt->bindParam($p,$id_categoria_producto,PDO::PARAM_STR,255);			
			
			$Insertado = $stmt->execute();
			//print_r($stmt->errorInfo());
		
			$stmt = $db->prepare("SELECT * FROM categoria WHERE md5(id_categoria) = ?");
			$c = 1;
			$stmt->bindParam($c,$id_categoria_producto,PDO::PARAM_STR,255);
			$stmt->execute();
			
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_categoria = $results[0]["id_categoria"];	
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
				
			$stmt = $db->prepare("INSERT INTO historial_categoria_producto (id_categoria_producto,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_categoria,PDO::PARAM_INT);
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

	if($_GET['action'] == 'Eliminar_Categoria_Producto')	
	{

		session_start();
		$db->beginTransaction();
		try
		{
			print_r($_POST);

			$id_categoria_producto = strip_tags(utf8_decode($_POST['IdCatProducto']));			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Categoria de Producto Eliminado";
			$Tipo = "12";			
			
			$stmt = $db->prepare("SELECT * FROM categoria WHERE MD5(id_categoria) = ?");
			$c = 1;
			$stmt->bindParam($c,$id_categoria_producto,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_categoria = $results[0]["id_categoria"];	
			$stmt->closeCursor();			
			
			$stmt = $db->prepare("DELETE FROM categoria WHERE MD5(id_categoria) = ?");
			$c = 1;
			$stmt->bindParam($c,$id_categoria_producto,PDO::PARAM_STR,255);

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
				
			$stmt = $db->prepare("INSERT INTO historial_categoria_producto (id_categoria_producto,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_categoria,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();				
				
			$stmt->closeCursor();
				
		}
			catch(PDOException $e) {
			echo $e->getMessage();
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

	if($_GET['action'] == 'Generar_Inventario_Productos_Total_Costo')
	{

		set_time_limit(0);
		ini_set('memory_limit', '384M');	
		include('../../library/Generar_Inventario.php');
		$TipoCategoria = strip_tags(utf8_decode(base64_decode($_POST['TipoCategoria'])));
		$Proveedor = strip_tags(utf8_decode(base64_decode($_POST['Proveedor'])));
		$objGenerarInventario =  new Generar_Inventario();

		try
		{		
			$Sql = "SELECT c.descripcion_categoria,pr.nombre_proveedor,m.id_producto,codigo_producto,id_bodega,id_tienda,costo,
			(IFNULL(SUM(balance_bodega),0)) AS total_bodega,(IFNULL(SUM(balance_tienda),0)) AS total_tienda,
			(IFNULL(SUM(balance_bodega),0) + IFNULL(SUM(balance_tienda),0)) AS total_inventario,
			ROUND(((IFNULL(SUM(balance_bodega),0) + IFNULL(SUM(balance_tienda),0))*costo),2) AS total_costo_inventario
			FROM movimientos m
			INNER JOIN producto p ON (m.id_producto = p.id_producto)
			INNER JOIN categoria c ON (c.id_categoria = p.id_categoria)
			INNER JOIN proveedores pr ON (pr.id_proveedor = p.id_proveedor)";	
			
			$Where = " WHERE m.estatus_movimiento = 1";
			
			if ($TipoCategoria != "")
			$Where .= " AND p.id_categoria = ?";
			else
			$Where .= "";
			
			if ($Proveedor != "")
			$Where .= " AND pr.id_proveedor = ?";
			else
			$Where .= "";
			
			$Group = " GROUP BY p.id_producto";
			$Order = " ORDER BY c.descripcion_categoria ASC,pr.nombre_proveedor ASC,p.codigo_producto ASC";
			
			$stmt = $db->prepare($Sql.$Where.$Group.$Order);			
						
			$p = 1;			
			if ($TipoCategoria != "")
			{
				$stmt->bindParam($p,$TipoCategoria,PDO::PARAM_STR,255);
				$p++;
			}
			
			if ($Proveedor != "")
			{
				$stmt->bindParam($p,$Proveedor,PDO::PARAM_STR,255);
				$p++;	
			}

			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}		
		
		$hoy=date('Y-m-d');
		$desde=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy)),date("Y", strtotime($hoy))));
		$hasta=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy))+30,date("Y", strtotime($hoy))));							
		
		if($nfilas != false)
		{
		
			$f = 0;$Total_Costo_Inventario = 0;
			foreach ($rows as $row)
			{
				$Descripcion_Categoria[$f] = utf8_encode($row['descripcion_categoria']);
				$Nombre_Proveedor[$f] = utf8_encode($row['nombre_proveedor']);
				$Codigo_Producto[$f] = utf8_encode($row['codigo_producto']);
				$Balance_Bodega[$f] = number_format($row['total_bodega'],0,'.','');
				$Balance_Tienda[$f] = number_format($row['total_tienda'],0,'.','');
				$Balance_Inventario[$f] = number_format($row['total_inventario'],0,'.','');
				$Precio_Costo[$f] = number_format($row['costo'],0,'.','');
				$Total_Costo[$f] = number_format($row['total_costo_inventario'],2,'.','');
				$Total_Costo_Inventario = $row['total_costo_inventario'] + $Total_Costo_Inventario;
				
				$f++;
			}
			
			$Total_Costo_Inventario = number_format($Total_Costo_Inventario,2,'.',',');
		}
		
		$mensaje[0] = $Nombre_Proveedor;
		$mensaje[1] = $Codigo_Producto;
		$mensaje[2] = $Balance_Bodega;
		$mensaje[3] = $Descripcion_Categoria;
		$mensaje[4] = $Balance_Tienda;
		$mensaje[5] = $Balance_Inventario;
		$mensaje[6] = $Total_Costo;
		$mensaje[7] = $Total_Costo_Inventario;
		
		$objGenerarInventario->Generar_Inventario_Total_Costo($desde, $hasta, $mensaje);

		echo 'tmp/Inventario_Producto_Total_Costo'.$desde.'.pdf';

	}	
	
	if($_GET['action'] == 'Generar_Inventario_Productos_Bodega')
	{

		set_time_limit(0);
		ini_set('memory_limit', '384M');	
		include('../../library/Generar_Inventario.php');
		$TipoCategoria = strip_tags(utf8_decode(base64_decode($_POST['TipoCategoria'])));
		$Proveedor = strip_tags(utf8_decode(base64_decode($_POST['Proveedor'])));
		$objGenerarInventario =  new Generar_Inventario();

		try
		{		
			$Sql = "SELECT c.descripcion_categoria,pr.nombre_proveedor,m.id_producto,codigo_producto,id_bodega,id_tienda,costo,(IFNULL(SUM(balance_bodega),0)) AS total_bodega
			FROM movimientos m
			INNER JOIN producto p ON (m.id_producto = p.id_producto)
			INNER JOIN categoria c ON (c.id_categoria = p.id_categoria)
			INNER JOIN proveedores pr ON (pr.id_proveedor = p.id_proveedor)";
			
			$Where = " WHERE m.estatus_movimiento = 1";
			
			if ($TipoCategoria != "")
			$Where .= " AND p.id_categoria = ?";
			else
			$Where .= "";
			
			if ($Proveedor != "")
			$Where .= " AND pr.id_proveedor = ?";
			else
			$Where .= "";
			
			$Group = " GROUP BY p.id_producto";
			$Order = " ORDER BY c.descripcion_categoria ASC,pr.nombre_proveedor ASC,p.codigo_producto ASC";
			
			$stmt = $db->prepare($Sql.$Where.$Group.$Order);			
						
			$p = 1;			
			if ($TipoCategoria != "")
			{
				$stmt->bindParam($p,$TipoCategoria,PDO::PARAM_STR,255);
				$p++;
			}
			
			if ($Proveedor != "")
			{
				$stmt->bindParam($p,$Proveedor,PDO::PARAM_STR,255);
				$p++;	
			}

			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}		
		
		$hoy=date('Y-m-d');
		$desde=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy)),date("Y", strtotime($hoy))));
		$hasta=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy))+30,date("Y", strtotime($hoy))));							
		
		if($nfilas != false)
		{
		
			$f = 0;
			foreach ($rows as $row)
			{
				$Descripcion_Categoria[$f] = utf8_encode($row['descripcion_categoria']);
				$Nombre_Proveedor[$f] = utf8_encode($row['nombre_proveedor']);
				$Codigo_Producto[$f] = utf8_encode($row['codigo_producto']);
				$Balance_Bodega[$f] = number_format($row['total_bodega'],0,'.','');
			
				$f++;
			}
		}
		
		$mensaje[0] = $Nombre_Proveedor;
		$mensaje[1] = $Codigo_Producto;
		$mensaje[2] = $Balance_Bodega;
		$mensaje[3] = $Descripcion_Categoria;
		
		$objGenerarInventario->Generar_Inventario_Bodega($desde, $hasta, $mensaje);

		echo 'tmp/Inventario_Bodega_Producto_'.$desde.'.pdf';

	}



	if($_GET['action'] == 'Generar_Inventario_Productos_Tienda')
	{

		set_time_limit(0);
		ini_set('memory_limit', '384M');	
		include('../../library/Generar_Inventario.php');
		$TipoCategoria = strip_tags(utf8_decode(base64_decode($_POST['TipoCategoria'])));
		$Proveedor = strip_tags(utf8_decode(base64_decode($_POST['Proveedor'])));
		$objGenerarInventario =  new Generar_Inventario();

		try
		{
			$Sql = "SELECT c.descripcion_categoria,pr.nombre_proveedor,m.id_producto,codigo_producto,id_bodega,id_tienda,costo,(IFNULL(SUM(balance_tienda),0)) AS total_tienda
			FROM movimientos m
			INNER JOIN producto p ON (m.id_producto = p.id_producto)
			INNER JOIN categoria c ON (c.id_categoria = p.id_categoria)
			INNER JOIN proveedores pr ON (pr.id_proveedor = p.id_proveedor)";	
			
			$Where = " WHERE m.estatus_movimiento = 1";
			
			if ($TipoCategoria != "")
			$Where .= " AND p.id_categoria = ?";
			else
			$Where .= "";
			
			if ($Proveedor != "")
			$Where .= " AND pr.id_proveedor = ?";
			else
			$Where .= "";
			
			$Group = " GROUP BY p.id_producto";
			$Order = " ORDER BY c.descripcion_categoria ASC,pr.nombre_proveedor ASC,p.codigo_producto ASC";
			
			$stmt = $db->prepare($Sql.$Where.$Group.$Order);			
						
			$p = 1;			
			if ($TipoCategoria != "")
			{
				$stmt->bindParam($p,$TipoCategoria,PDO::PARAM_STR,255);
				$p++;
			}
			
			if ($Proveedor != "")
			{
				$stmt->bindParam($p,$Proveedor,PDO::PARAM_STR,255);
				$p++;	
			}			
			
				
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}		
		
		$hoy=date('Y-m-d');
		$desde=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy)),date("Y", strtotime($hoy))));
		$hasta=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy))+30,date("Y", strtotime($hoy))));							
		
		if($nfilas != false)
		{
		
			$f = 0;
			foreach ($rows as $row)
			{
				$Descripcion_Categoria[$f] = utf8_encode($row['descripcion_categoria']);
				$Nombre_Proveedor[$f] = utf8_encode($row['nombre_proveedor']);
				$Codigo_Producto[$f] = utf8_encode($row['codigo_producto']);
				$Balance_Tienda[$f] = number_format($row['total_tienda'],0,'.','');
			
				$f++;
			}
		}
		
		$mensaje[0] = $Nombre_Proveedor;
		$mensaje[1] = $Codigo_Producto;
		$mensaje[2] = $Balance_Tienda;
		$mensaje[3] = $Descripcion_Categoria;
		
		$objGenerarInventario->Generar_Inventario_Tienda($desde, $hasta, $mensaje);

		echo 'tmp/Inventario_Tienda_Producto_'.$desde.'.pdf';

	}		
?>