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

	if($_GET['action'] == 'Listar_Tipo_Papel')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM imprenta_tipo_papel");
			
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
				$html .= "<option value='".$row['id_tipo_papel']."'>".$row['descripcion_papel']."</option>";
			}
		}
		
		echo $html;
	}	

	
	if($_GET['action'] == 'Listar_Material_Tipo_Papel')	
	{

		$html = "";
		
		try
		{		
			$id_tipo_papel = strip_tags(utf8_decode($_POST["tipopapel"]));
			
			$stmt = $db->prepare("SELECT * FROM imprenta_tipo_material WHERE id_tipo_papel = ?");

			$c = 1;
			$stmt->bindParam($c,$id_tipo_papel,PDO::PARAM_INT);
			
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
				$html .= "<option value='".$row['id_tipo_material']."'>".$row['descripcion_tipo_material']."</option>";
			}
		}
		
		if ($id_tipo_papel == 1)
		echo $html;
	}

	if($_GET['action'] == 'Listar_Resma_Tamano_Papel')	
	{

		$html = "";
		
		try
		{		
			$id_tipo_papel = strip_tags(utf8_decode($_POST["tipopapel"]));
			
			if($id_tipo_papel != "")
			{

				$stmt = $db->prepare("SELECT * FROM imprenta_tamano_papel WHERE papel_bond = 1");
				//$stmt = $db->prepare("SELECT * FROM imprenta_tamano_papel");
			
				$stmt->execute();
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas = $stmt->rowCount();
				$stmt->closeCursor();
			}
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		if ($nfilas > 0)
		{
				
			$c = 1;
			foreach ($rows as $row)
			{
				$html .= "<option value='".$row['id_tamano_papel']."'>".utf8_encode($row['descripcion_tamano'])."</option>";
			}
		}
		
		echo $html;
	}	
	
	
	if($_GET['action'] == 'Listar_Tamano_Papel')	
	{

		$html = "";
		
		try
		{		
			   $id_resmatamano = strip_tags(utf8_decode($_POST["resmatamano"]));
			   $id_tipo_papel = strip_tags(utf8_decode($_POST["tipopapel"]));
			
			//if($id_tipo_papel != "")
			//{
				/*if ($id_tipo_papel == 1)
				$stmt = $db->prepare("SELECT * FROM imprenta_tamano_papel WHERE papel_bond = 1");
				else if ($id_tipo_papel == 2)
				$stmt = $db->prepare("SELECT * FROM imprenta_tamano_papel WHERE papel_quimico = 1");*/
				
			if($id_tipo_papel == 1)
			{				
				
				if ($id_resmatamano == 1)
				$stmt = $db->prepare("SELECT * FROM imprenta_tamano_papel WHERE id_tamano_papel != 2");
				else
				$stmt = $db->prepare("SELECT * FROM imprenta_tamano_papel");
			
				$stmt->execute();
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas = $stmt->rowCount();
				$stmt->closeCursor();
			}
			else
			{
				$stmt = $db->prepare("SELECT * FROM imprenta_tamano_papel");
			
				$stmt->execute();
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas = $stmt->rowCount();
				$stmt->closeCursor();
			}
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
				$html .= "<option value='".$row['id_tamano_papel']."'>".utf8_encode($row['descripcion_tamano'])."</option>";
			}
		}
		
		echo $html;
	}
	

	
	if($_GET['action'] == 'Listar_Color_Tinta')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM imprenta_color_tinta ORDER BY `descripcion_color` ASC");
			
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
				$html .= "<option value='".$row['id_color']."'>".$row['descripcion_color']."</option>";
			}
		}
		
		echo $html;
	}	
	
	if($_GET['action'] == 'Listar_Color_Tinta_Impresion')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM impresion_color_tinta ORDER BY `descripcion_color` ASC");
			
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
				$html .= "<option value='".$row['id_color']."'>".$row['descripcion_color']."</option>";
			}
		}
		
		echo $html;
	}
	
	if($_GET['action'] == 'Listar_Color_Papel')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM imprenta_color_papel");
			
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
				$html .= "<option value='".$row['id_color']."'>".$row['descripcion_color']."</option>";
			}
		}
		
		echo $html;
	}

	if($_GET['action'] == 'Listar_Tipo_Forro')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM imprenta_tipo_forro");
			
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
				$html .= "<option value='".$row['id_forro']."'>".$row['descripcion_forro']."</option>";
			}
		}
		
		echo $html;
	}	

	if($_GET['action'] == 'Tipo_Volumen_Imprenta')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM tipo_volumen_imprenta");
			
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
				$html .= "<option value='".$row['id_rango_volumen']."'>".$row['descripcion_volumen']."</option>";
			}
		}
		
		echo $html;
	}
	
	if($_GET['action'] == 'Tipo_Volumen_Impresion')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM tipo_volumen_impresion");
			
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
				$html .= "<option value='".$row['id_rango_volumen']."'>".$row['descripcion_volumen']."</option>";
			}
		}
		
		echo $html;
	}
	
	if($_GET['action'] == 'Verificar_Otro_Tamano')	
	{
		$OtroTamanoAncho = strip_tags(utf8_decode($_POST["otrotamanoancho"]));
		$OtroTamanoLargo = strip_tags(utf8_decode($_POST["otrotamanolargo"]));
		$id_papel_tipo = strip_tags(utf8_decode($_POST["papeltipo"]));
		$id_resmatamano = strip_tags(utf8_decode($_POST["resmatamano"]));
		
		//echo $id_resmatamano;
		
		$mensaje="";
		
		if ($id_papel_tipo == 1)
		{
			
			if ($OtroTamanoAncho > 8.5)
			$mensaje .= "- El Ancho de Papel no debe ser mayor que el Ancho del Papel Bond.\n";
			
			if ($id_resmatamano == 1)
			{
				if ($OtroTamanoLargo > 11)
				$mensaje .= "- El Largo de Papel no debe ser mayor que el Largo del Papel Bond.\n";
			}
			else if ($id_resmatamano == 2)
			{
				if ($OtroTamanoLargo > 14)
				$mensaje .= "- El Largo de Papel no debe ser mayor que el Largo del Papel Bond.\n";
			}
		}
		else if ($id_papel_tipo == 2)
		{
			if ($OtroTamanoAncho > 28.5)
			$mensaje .= "- El Ancho de Papel no debe ser mayor que el Ancho del Pliego.\n";
			
			if ($OtroTamanoLargo > 34.5)
			$mensaje .= "- El Largo de Papel no debe ser mayor que el Largo del Pliego.\n";	
		}

		echo $mensaje;
		
	}
	

	if($_GET['action'] == 'Lista_Material_Banner')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM banner_material ORDER BY `descripcion_material` ASC");
			
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
				$html .= "<option value='".$row['id_material']."'>".utf8_encode($row['descripcion_material'])."</option>";
			}
		}
		
		echo $html;
	}	

	if($_GET['action'] == 'Lista_Material_Impresion')	
	{

		$html = "";
		
		try
		{		
			$tamanopapel = strip_tags(utf8_decode($_POST["tamanopapel"]));
			
			if ($tamanopapel == "o")
			{
				$stmt = $db->prepare("SELECT * FROM impresion_material immat
				INNER JOIN impresion_precio_tamano_papel_material imtm ON (immat.id_material = imtm.id_material)
				INNER JOIN impresion_tamano_pliego imtp ON (imtp.id_tamano = imtm.id_tamano)
				WHERE immat.estatus_material = 1
				ORDER BY descripcion_material ASC");
			}
			else
			{
				$stmt = $db->prepare("SELECT * FROM impresion_material immat
				INNER JOIN impresion_precio_tamano_papel_material imtm ON (immat.id_material = imtm.id_material)
				INNER JOIN impresion_tamano_pliego imtp ON (imtp.id_tamano = imtm.id_tamano)
				WHERE imtp.id_tamano = ? AND immat.estatus_material = 1
				ORDER BY descripcion_material ASC");

				$c = 1;
				$stmt->bindParam($c,$tamanopapel,PDO::PARAM_INT);
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
				
			$c = 1;
			foreach ($rows as $row)
			{
				$html .= "<option value='".$row['id_material']."'>".utf8_encode($row['descripcion_material'])."</option>";
			}
		}
		
		echo $html;
	}
	
	if($_GET['action'] == 'Lista_Unidad_Medida')	
	{

		$html = "";
		
		$impresion = strip_tags(utf8_decode($_POST["impresion"]));
		
		try
		{	
			if ($impresion == 1)
			$stmt = $db->prepare("SELECT * FROM tipo_unidad WHERE id_unidad < 3");
			else
			$stmt = $db->prepare("SELECT * FROM tipo_unidad");
				
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
				$html .= "<option value='".$row['id_unidad']."'>".utf8_encode($row['descripcion_unidad'])."</option>";
			}
		}
		
		echo $html;
	}	
	
	if($_GET['action'] == 'Lista_Forma_Pago')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM banner_forma_pago");
			
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
				$html .= "<option value='".$row['id_forma_pago']."'>".utf8_encode($row['descripcion_forma_pago'])."</option>";
			}
		}
		
		echo $html;
	}

	if($_GET['action'] == 'Lista_Calidad')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM banner_calidad ");
			
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
				$html .= "<option value='".$row['id_calidad']."'>".utf8_encode($row['descripcion_calidad'])."</option>";
			}
		}
		
		echo $html;
	}
	
	
	if($_GET['action'] == 'Calcular_Precio_Imprenta')	
	{

		$response = "";
		$cantidad = strip_tags(utf8_decode($_POST["cantidad"]));
		$id_papel_tipo = strip_tags(utf8_decode($_POST["papeltipo"]));		
		$id_material_papel_tipo = strip_tags(utf8_decode($_POST["materialpapeltipo"]));			
		$id_tamano = strip_tags(utf8_decode($_POST["tamano"]));	
		$OtroTamanoAncho = strip_tags(utf8_decode($_POST["otrotamanoancho"]));
		$OtroTamanoLargo = strip_tags(utf8_decode($_POST["otrotamanolargo"]));		
		//$cantidad_copia = strip_tags(utf8_decode($_POST["cantidadcopia"]));
		$id_resmatamano = strip_tags(utf8_decode($_POST["resmatamano"]));			
		$id_tamano = strip_tags(utf8_decode($_POST["tamano"]));		
		$cantidad_copia = strip_tags(utf8_decode($_POST["cantidadcopia"]));	
		$tiempo = strip_tags(utf8_decode($_POST["tiempo"]));
		$tipotiempo = strip_tags(utf8_decode($_POST["tipotiempo"]));
		$tipocategoria = strip_tags(utf8_decode($_POST["tipocategoria"]));
		$placa = strip_tags(utf8_decode($_POST["placa"]));		
		
		
		if($cantidad_copia == 0)
		$Cantidad_Hoja = 100;
		else if ($cantidad_copia > 0)
		$Cantidad_Hoja = ($cantidad_copia + 1) * 50;
		
		//$Ganancia = 0.80;
		
		try
		{


			$stmt = $db->prepare("SELECT ancho,largo FROM imprenta_tipo_papel WHERE id_tipo_papel = ?");

			$c = 1;
			$stmt->bindParam($c,$id_papel_tipo,PDO::PARAM_INT);
			
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
				$Ancho_Pliego = $row['ancho'];
				$Largo_Pliego = $row['largo'];				
			}
		}

		if ($id_tamano == "o")
		{
			$Ancho_Papel = $OtroTamanoAncho;
			$Largo_Papel = $OtroTamanoLargo;			
		
		}
		else
		{
			try
			{


				$stmt = $db->prepare("SELECT ancho,largo FROM imprenta_tamano_papel WHERE id_tamano_papel = ?");

				$c = 1;
				$stmt->bindParam($c,$id_tamano,PDO::PARAM_INT);
			
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
					$Ancho_Papel = $row['ancho'];
					$Largo_Papel = $row['largo'];				
				}
			}
		
		}
		
		//echo $Largo_Papel;
		
		try
		{

			if ($id_papel_tipo == 1)
			{
				if ($id_resmatamano == 1){
				$stmt = $db->prepare("SELECT costo_rema_8_por_11 AS Costo FROM imprenta_tipo_material WHERE id_tipo_papel = ? and id_tipo_material = ?");
			}else if ($id_resmatamano == 2){
				$stmt = $db->prepare("SELECT costo_rema_8_por_14 AS Costo FROM imprenta_tipo_material WHERE id_tipo_papel = ? and id_tipo_material = ?");
			}
			
				$c = 1;
				$stmt->bindParam($c,$id_papel_tipo,PDO::PARAM_INT);	
				$c++;
				$stmt->bindParam($c,$id_material_papel_tipo ,PDO::PARAM_INT);						
			
				$stmt->execute();			
			
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas = $stmt->rowCount();
				$stmt->closeCursor();			
			
			}
			else if ($id_papel_tipo == 2)
			{
				
				$id_tipo_copia[0] = 1;
				$id_tipo_copia[1] = 3;
				
				$stmt = $db->prepare("SELECT costo_pliego FROM imprenta_tipo_material WHERE id_tipo_papel = ? AND id_tipo_copia = ?");
			
				$c = 1;
				$stmt->bindParam($c,$id_papel_tipo,PDO::PARAM_INT);				
				$c++;
				$stmt->bindParam($c,$id_tipo_copia[0],PDO::PARAM_INT);	
					
				$stmt->execute();			
			
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas = $stmt->rowCount();
				$stmt->closeCursor();

				$stmt = $db->prepare("SELECT costo_pliego FROM imprenta_tipo_material WHERE id_tipo_papel = ? AND id_tipo_copia = ?");
			
				$c = 1;
				$stmt->bindParam($c,$id_papel_tipo,PDO::PARAM_INT);				
				$c++;
				$stmt->bindParam($c,$id_tipo_copia[1],PDO::PARAM_INT);	
					
				$stmt->execute();			
			
				$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas1 = $stmt->rowCount();
				$stmt->closeCursor();					
				
				//$rows2 = false;
				//$nfilas2 = false;
				
				if ($cantidad_copia > 1)
				{
				
					$id_tipo_copia[2] = 2;
				
					$d = 0;
				
					while ($d < ($cantidad_copia - 1))
					{
					
						$stmt = $db->prepare("SELECT costo_pliego FROM imprenta_tipo_material WHERE id_tipo_papel = ? AND id_tipo_copia = ?");
			
						$c = 1;
						$stmt->bindParam($c,$id_papel_tipo,PDO::PARAM_INT);				
						$c++;
						$stmt->bindParam($c,$id_tipo_copia[2],PDO::PARAM_INT);	
					
						$stmt->execute();			
			
						$rows2[$d] = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas2[$d] = $stmt->rowCount();
						$stmt->closeCursor();					

						$d = $d + 1;
					}
				}	
			}	
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		//echo $id_papel_tipo;
		if ($id_papel_tipo == 1)
		{	
			if ($nfilas > 0)
			{
				foreach ($rows as $row)
				{
					$Costo_Rema = $row['Costo'];;
				}
			}

			
			if ($Largo_Papel <= 11)
			$Pagina_por_Hoja = (8.5*11)/($Ancho_Papel*$Largo_Papel);
			else
			$Pagina_por_Hoja = 1;
			
			//echo $Pagina_por_Hoja;
			
			//$Cantidad_Pliego = ($Ancho_Papel*$Largo_Papel*$cantidad*$Cantidad_Hoja)/($Ancho_Pliego*$Largo_Pliego);	
			$Costo_Libreta = (($Costo_Rema/(500))*$Cantidad_Hoja*$cantidad)/$Pagina_por_Hoja;
			//echo $Costo_Libreta;			
		}
		else if ($id_papel_tipo == 2)
		{		
		
			$Cantidad_Pliego = ($Ancho_Papel*$Largo_Papel*$cantidad*50)/($Ancho_Pliego*$Largo_Pliego);				
			
			if ($nfilas > 0)
			{
				foreach ($rows as $row)
				{
					$Costo_Pliego[0] = $row['costo_pliego'];
				
				}
			}

			$Costo_Libreta = $Costo_Pliego[0]*$Cantidad_Pliego;
			
			if ($nfilas1 > 0)
			{
				foreach ($rows1 as $row)
				{
					$Costo_Pliego[1] = $row['costo_pliego'];
				
				}
			}

			$Costo_Libreta = $Costo_Pliego[1]*$Cantidad_Pliego + $Costo_Libreta;
		
			if ($cantidad_copia > 1)
			{		
				$d = 0;
				while ($d < ($cantidad_copia - 1))
				{		
		
					if ($nfilas2[$d] > 0)
					{
						foreach ($rows2[$d] as $row)
						{
							$Costo_Pliego[2+$d] = $row['costo_pliego'];				
						}
					}		
					
					$Costo_Libreta = $Costo_Pliego[2+$d]*$Cantidad_Pliego + $Costo_Libreta;
					
					$d = $d + 1;
				}		
			}
		}
		
		//echo $Costo_Libreta;	
		
		
		
		
		try
		{


			$stmt = $db->prepare("SELECT precio FROM imprenta_tipo_costo WHERE id_tipo_costo = ?");

			$c = 1;
			$stmt->bindParam($c,$tipotiempo,PDO::PARAM_INT);
			
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
				$Precio = $row['precio'];				
			}
		}		

		try
		{


			$stmt = $db->prepare("SELECT porcentaje FROM tipo_volumen_imprenta WHERE id_rango_volumen = ?");

			//$stmt = $db->prepare("SELECT porcentaje FROM categoria WHERE id_categoria = ?");

			//$c = 1;
			//$stmt->bindParam($c,$tipocategoria,PDO::PARAM_INT);
			
			$c = 1;
			$stmt->bindParam($c,$tipocategoria,PDO::PARAM_INT);			
			
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
				$Ganancia = $row['porcentaje'];				
			}
		}
		
		$Costo_Tiempo = $Precio*$tiempo;
		
		//$Costo_Libreta = $Costo_Libreta + $Costo_Tiempo;
		
		$Precio_Libreta = (($Costo_Libreta + ($Ganancia*$Costo_Libreta))/$cantidad) + $Costo_Tiempo/$cantidad;
		
		//echo $cantidad_copia;
		//echo $Costo_Pliego[2];
		if ($placa == 1)
		$Precio_Libreta = $Precio_Libreta + (5/$cantidad);
		
		
		echo number_format($Precio_Libreta,2,'.','');		

	}

	if($_GET['action'] == 'Calcular_Precio_Banner')	
	{

		$response = "";
		$cantidad = strip_tags(utf8_decode($_POST["cantidad"]));		
		$materialbanner = strip_tags(utf8_decode($_POST["materialbanner"]));
		$ancho = strip_tags(utf8_decode($_POST["ancho"]));
		$anchomedida = strip_tags(utf8_decode($_POST["anchomedida"]));		
		$largo = strip_tags(utf8_decode($_POST["largo"]));			
		$largomedida = strip_tags(utf8_decode($_POST["largomedida"]));	
		$formapago = strip_tags(utf8_decode($_POST["formapago"]));
		$calidadbanner = strip_tags(utf8_decode($_POST["calidadbanner"]));
		$precioinstalacion = strip_tags(utf8_decode($_POST["precioinstalacion"]));
		$preciorecorte = strip_tags(utf8_decode($_POST["preciorecorte"]));		
		$precioarte = strip_tags(utf8_decode($_POST["precioarte"]));			
		$preciorotulado = strip_tags(utf8_decode($_POST["preciorotulado"]));	
		$preciobasta = strip_tags(utf8_decode($_POST["preciobasta"]));
		$precioojete = strip_tags(utf8_decode($_POST["precioojete"]));
		$preciobulcaniza = strip_tags(utf8_decode($_POST["preciobulcaniza"]));

		
		
		try
		{


			$stmt = $db->prepare("SELECT precio_x_pies FROM banner_material WHERE id_material = ?");

			$c = 1;
			$stmt->bindParam($c,$materialbanner,PDO::PARAM_INT);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}			
		
		try
		{
			$stmt = $db->prepare("SELECT factor_conversion FROM tipo_unidad WHERE id_unidad = ?");

			$c = 1;
			$stmt->bindParam($c,$anchomedida,PDO::PARAM_INT);
			
			$stmt->execute();
			$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas1 = $stmt->rowCount();
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}

		try
		{
			$stmt = $db->prepare("SELECT factor_conversion FROM tipo_unidad WHERE id_unidad = ?");

			$c = 1;
			$stmt->bindParam($c,$largomedida,PDO::PARAM_INT);
			
			$stmt->execute();
			$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas2 = $stmt->rowCount();
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		try
		{
			$stmt = $db->prepare("SELECT porcentaje_del_precio FROM banner_forma_pago WHERE id_forma_pago = ?");

			$c = 1;
			$stmt->bindParam($c,$formapago,PDO::PARAM_INT);
			
			$stmt->execute();
			$rows3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas3 = $stmt->rowCount();
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}		

		try
		{
			$stmt = $db->prepare("SELECT porcentaje_del_precio FROM banner_calidad WHERE id_calidad = ?");

			$c = 1;
			$stmt->bindParam($c,$calidadbanner,PDO::PARAM_INT);
			
			$stmt->execute();
			$rows4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas4 = $stmt->rowCount();
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		
		
		$Area_Banner = ($ancho*$rows1[0]['factor_conversion']/30.48)*($largo*$rows2[0]['factor_conversion']/30.48);
		
		
		$Precio_Banner = $rows[0]['precio_x_pies']*$Area_Banner;
		
		if ($calidadbanner > 0)
		$Precio_Banner = $Precio_Banner*($rows3[0]['porcentaje_del_precio']/100)*($rows4[0]['porcentaje_del_precio']/100);
		else
		$Precio_Banner = $Precio_Banner*($rows3[0]['porcentaje_del_precio']/100);		
		
		$Precio_Banner = $Precio_Banner + ($precioinstalacion/$cantidad) + ($preciorecorte/$cantidad) + ($precioarte/$cantidad) + ($preciorotulado/$cantidad) + ($preciobasta/$cantidad) + ($precioojete/$cantidad) + ($preciobulcaniza/$cantidad);
		
		//echo $cantidad;
		//echo $formapago;
		//echo $Precio_Banner;
		$Banner_Info[0] = number_format($Area_Banner,2,'.','');
		$Banner_Info[1] = number_format($Precio_Banner,2,'.','');
		
		echo json_encode($Banner_Info);
	}

	if($_GET['action'] == 'Calcular_Precio_Impresion')	
	{
		$response = "";
		$cantidad = strip_tags(utf8_decode($_POST["cantidad"]));		
		$materialimpresion = strip_tags(utf8_decode($_POST["materialimpresion"]));
		$ancho = strip_tags(utf8_decode($_POST["ancho"]));
		$anchomedida = strip_tags(utf8_decode($_POST["anchomedida"]));		
		$largo = strip_tags(utf8_decode($_POST["largo"]));			
		$largomedida = strip_tags(utf8_decode($_POST["largomedida"]));
		$id_tamano = strip_tags(utf8_decode($_POST["tamano"]));
		$id_color_tinta = strip_tags(utf8_decode($_POST["colortinta"]));		
		$OtroTamanoAncho = strip_tags(utf8_decode($_POST["otrotamanoancho"]));
		$OtroTamanoLargo = strip_tags(utf8_decode($_POST["otrotamanolargo"]));				
		$precioarte = strip_tags(utf8_decode($_POST["precioarte"]));
		$recorte = strip_tags(utf8_decode($_POST["recorte"]));		
		$plastificado = strip_tags(utf8_decode($_POST["plastificado"]));
		$caminado = strip_tags(utf8_decode($_POST["caminado"]));		
		$realce = strip_tags(utf8_decode($_POST["realce"]));
		$doblado = strip_tags(utf8_decode($_POST["doblado"]));		
		$repujado = strip_tags(utf8_decode($_POST["repujado"]));
		$engrapado = strip_tags(utf8_decode($_POST["engrapado"]));		
		$uv = strip_tags(utf8_decode($_POST["uv"]));
		$tipocategoria = strip_tags(utf8_decode($_POST["tipocategoria"]));
		$ajustartamano = strip_tags(utf8_decode($_POST["ajustartamano"]));		
		
		try
		{
			$stmt = $db->prepare("SELECT precio_por_pagina FROM impresion_precio_tamano_papel_material WHERE id_material = ? AND id_tamano = ?");

			$c = 1;
			$stmt->bindParam($c,$materialimpresion,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$id_tamano,PDO::PARAM_INT);			
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}			
		
		try
		{
			$stmt = $db->prepare("SELECT factor_conversion FROM tipo_unidad WHERE id_unidad = ?");

			$c = 1;
			$stmt->bindParam($c,$anchomedida,PDO::PARAM_INT);
			
			$stmt->execute();
			$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas1 = $stmt->rowCount();
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}		
		
		try
		{
			$stmt = $db->prepare("SELECT factor_conversion FROM tipo_unidad WHERE id_unidad = ?");

			$c = 1;
			$stmt->bindParam($c,$largomedida,PDO::PARAM_INT);
			
			$stmt->execute();
			$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas2 = $stmt->rowCount();
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		$Area_Impresion = ($ancho*$rows1[0]['factor_conversion']/2.54)*($largo*$rows2[0]['factor_conversion']/2.54);
		
		$Area_Impresion_con_Margen = ((($ancho*$rows1[0]['factor_conversion'])/2.54)+0.25)*((($largo*$rows2[0]['factor_conversion'])/2.54)+0.25);
		
		if ($id_tamano == "o")
		{
			$Area_Pliego = ($OtroTamanoAncho)*($OtroTamanoLargo);
			$Area_Pliego_Efectivo = ($OtroTamanoAncho-0.5)*($OtroTamanoLargo-0.5);
		}
		else
		{
			try
			{
				$stmt = $db->prepare("SELECT ancho,ancho_efectivo,largo,largo_efectivo FROM impresion_tamano_pliego WHERE id_tamano = ?");

				$c = 1;
				$stmt->bindParam($c,$id_tamano,PDO::PARAM_INT);
			
				$stmt->execute();
				$rows3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas3 = $stmt->rowCount();
				$stmt->closeCursor();
			
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}
			
			$Area_Pliego = ($rows3[0]['ancho'])*($rows3[0]['largo']);
			$Area_Pliego_Efectivo = ($rows3[0]['ancho_efectivo'])*($rows3[0]['largo_efectivo']);
			
			
		}
		

		//$Cantidad_Impresion_por_Pagina = ceil($Area_Pliego_Efectivo/$Area_Impresion_con_Margen);
		//$Cantidad_Impresion_por_Pagina = number_format($Area_Pliego_Efectivo/$Area_Impresion_con_Margen,0,'.','');
		if($ajustartamano==1)
		$Cantidad_Impresion_por_Pagina = ($Area_Pliego/$Area_Impresion);		
		else
		$Cantidad_Impresion_por_Pagina = (int)($Area_Pliego_Efectivo/$Area_Impresion_con_Margen);
		
		//$Cantidad_Pagina = $Cantidad_Impresion_por_Pagina;
		
		$Cantidad_Pagina = ceil($cantidad/((int)number_format($Cantidad_Impresion_por_Pagina)));
		
		/*if ($cantidad <= $Area_Impresion_con_Margen/$Area_Pliego_Efectivo)
		$Cantidad_Pagina = ceil($cantidad*$Area_Impresion_con_Margen/$Area_Pliego_Efectivo);
		else
		{
			if ($Area_Impresion > 0.25)
			$Cantidad_Pagina = (int)($cantidad*$Area_Impresion_con_Margen/$Area_Pliego_Efectivo);
			else
			$Cantidad_Pagina = number_format($cantidad*$Area_Impresion_con_Margen/$Area_Pliego_Efectivo,0,'.','');
		}*/

		if ($id_tamano == "o")
		{
			try
			{
				$stmt = $db->prepare("SELECT AVG(precio_por_pulgada) AS precio_material FROM impresion_precio_tamano_papel_material WHERE id_material = ?");

				$c = 1;
				$stmt->bindParam($c,$materialimpresion,PDO::PARAM_INT);
			
				$stmt->execute();
				$rows4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas4 = $stmt->rowCount();
				$stmt->closeCursor();
			
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}
			
			$Precio_por_Pagina_Pliego = $Area_Pliego*$rows4[0]['precio_material'];
			$Precio_Material = $Cantidad_Pagina*$Precio_por_Pagina_Pliego;
			
			try
			{
				$stmt = $db->prepare("SELECT AVG(precio_por_pulgada) AS precio_tinta FROM impresion_precio_color_tinta_tamano WHERE id_color = ?");

				$c = 1;
				$stmt->bindParam($c,$id_color_tinta,PDO::PARAM_INT);
			
				$stmt->execute();
				$rows5 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas5 = $stmt->rowCount();
				$stmt->closeCursor();
			
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}

			$Precio_por_Pagina_Tinta = $Area_Pliego*$rows5[0]['precio_tinta'];
			$Precio_Tinta = $Cantidad_Pagina*$Precio_por_Pagina_Tinta;			
			
		}
		else
		{		
			$Precio_Material = $Cantidad_Pagina*$rows[0]['precio_por_pagina'];

			try
			{
				$stmt = $db->prepare("SELECT precio_por_pagina FROM impresion_precio_color_tinta_tamano WHERE id_color = ? AND id_tamano = ?");

				$c = 1;
				$stmt->bindParam($c,$id_color_tinta,PDO::PARAM_INT);
				$c++;
				$stmt->bindParam($c,$id_tamano,PDO::PARAM_INT);	
			
				$stmt->execute();
				$rows6 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas6 = $stmt->rowCount();
				$stmt->closeCursor();
			
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}		

			$Precio_Tinta = $Cantidad_Pagina*$rows6[0]['precio_por_pagina'];			
		}
		
		try
		{


			$stmt = $db->prepare("SELECT porcentaje FROM tipo_volumen_impresion WHERE id_rango_volumen = ?");

			//$stmt = $db->prepare("SELECT porcentaje FROM categoria WHERE id_categoria = ?");

			//$c = 1;
			//$stmt->bindParam($c,$tipocategoria,PDO::PARAM_INT);
			
			$c = 1;
			$stmt->bindParam($c,$tipocategoria,PDO::PARAM_INT);			
			
			$stmt->execute();
			$rows7 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas7 = $stmt->rowCount();
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		if ($nfilas7 > 0)
		{
			$c = 1;
			foreach ($rows7 as $row7)
			{
				$Ganancia = $row7['porcentaje'];				
			}
		}
		//$Impresion_Info[1] = $Ganancia;
		
		$Precio_Impresion = ((($Precio_Material + $Precio_Tinta)*$Ganancia)/$cantidad)+(($precioarte/$cantidad) + ($recorte/$cantidad) + ($plastificado/$cantidad) + ($caminado/$cantidad) + ($realce/$cantidad) + ($doblado/$cantidad) + ($repujado/$cantidad) + ($engrapado/$cantidad) + ($uv/$cantidad));
		
		$Impresion_Info[0] = number_format($Area_Impresion,2,'.','');
		$Impresion_Info[1] = number_format($Cantidad_Pagina,2,'.','');
		$Impresion_Info[2] = number_format($Precio_Impresion,2,'.','');
		
		echo json_encode($Impresion_Info);		
	}


	
	if($_GET['action'] == 'Agregar_Cotizacion')	
	{

		session_start();

		
		$db->beginTransaction();
		try
		{

			
			$NombreCliente	= strip_tags(utf8_decode($_POST['NombreCliente']));
			$DescripcionCotizacion	= strip_tags(utf8_decode($_POST['DescripcionCotizacion']));	
		
			$SubTotal	= strip_tags(utf8_decode($_POST['SubTotal']));
			$TotalITBM = strip_tags(utf8_decode($_POST['TotalITBM']));
			$TotalFinal = strip_tags(utf8_decode($_POST['TotalFinal']));
			
			//$Cantidad = explode(',',strip_tags(utf8_decode($_POST['Cantidad'])));
			$Cantidad = json_decode($_POST['Cantidad']);
			
			//$Producto = explode(',',strip_tags(utf8_decode($_POST['Producto'])));
			$Producto = json_decode($_POST['Producto']);
			
			//$Precio = explode(',',strip_tags(utf8_decode($_POST['Precio'])));
			$Precio = json_decode($_POST['Precio']);
			
			//$PapelTipo = explode(',',strip_tags(utf8_decode($_POST['PapelTipo'])));
			$PapelTipo = json_decode($_POST['PapelTipo']);
			
			//$MaterialPapelTipo = explode(',',strip_tags(utf8_decode($_POST['MaterialPapelTipo'])));
			$MaterialPapelTipo = json_decode($_POST['MaterialPapelTipo']);
			
			//$ResmaTamano = explode(',',strip_tags(utf8_decode($_POST['ResmaTamano'])));
			$ResmaTamano = json_decode($_POST['ResmaTamano']);
			
			//$Tamano = explode(',',strip_tags(utf8_decode($_POST['Tamano'])));
			$Tamano = json_decode($_POST['Tamano']);
			
			//$OtroTamanoAncho = explode(',',strip_tags(utf8_decode($_POST['OtroTamanoAncho'])));
			$OtroTamanoAncho = json_decode($_POST['OtroTamanoAncho']);
			
			//$OtroTamanoLargo = explode(',',strip_tags(utf8_decode($_POST['OtroTamanoLargo'])));
			$OtroTamanoLargo = json_decode($_POST['OtroTamanoLargo']);
			
			//$NumeracionInicio = explode(',',strip_tags(utf8_decode($_POST['NumeracionInicio'])));
			$NumeracionInicio = json_decode($_POST['NumeracionInicio']);	
			
			//$NumeracionFinal = explode(',',strip_tags(utf8_decode($_POST['NumeracionFinal'])));	
			$NumeracionFinal = json_decode($_POST['NumeracionFinal']);			
			
			//$CantidadCopia = explode(',',strip_tags(utf8_decode($_POST['CantidadCopia'])));
			$CantidadCopia = json_decode($_POST['CantidadCopia']);
			
			//$ColorTinta = explode(',',strip_tags(utf8_decode($_POST['ColorTinta'])));
			$ColorTinta = json_decode($_POST['ColorTinta']);
			
			//$ColorPapel = explode(',',strip_tags(utf8_decode($_POST['ColorPapel'])));
			$ColorPapel = json_decode($_POST['ColorPapel']);
			
			//$ColorPapel1 = explode(',',strip_tags(utf8_decode($_POST['ColorPapel1'])));
			$ColorPapel1 = json_decode($_POST['ColorPapel1']);
			
			//$ColorPapel2 = explode(',',strip_tags(utf8_decode($_POST['ColorPapel2'])));
			$ColorPapel2 = json_decode($_POST['ColorPapel2']);
			
			//$ColorPapel3 = explode(',',strip_tags(utf8_decode($_POST['ColorPapel3'])));
			$ColorPapel3 = json_decode($_POST['ColorPapel3']);
			
			//$TipoForro = explode(',',strip_tags(utf8_decode($_POST['TipoForro'])));
			$TipoForro = json_decode($_POST['TipoForro']);			
			
			//$Tiempo = explode(',',strip_tags(utf8_decode($_POST['Tiempo'])));
			$Tiempo = json_decode($_POST['Tiempo']);			
			
			//$TipoTiempo = explode(',',strip_tags(utf8_decode($_POST['TipoTiempo'])));
			$TipoTiempo = json_decode($_POST['TipoTiempo']);			
			
			//$TipoCategoria = explode(',',strip_tags(utf8_decode($_POST['TipoCategoria'])));
			$TipoCategoria = json_decode($_POST['TipoCategoria']);			
			
			//$ExentoITBM = explode(',',strip_tags(utf8_decode($_POST['ExentoITBM'])));
			$ExentoITBM = json_decode($_POST['ExentoITBM']);
			
			//$Arte = explode(',',strip_tags(utf8_decode($_POST['Arte'])));
			$Arte = json_decode($_POST['Arte']);
			
			//$Placa = explode(',',strip_tags(utf8_decode($_POST['Placa'])));
			$Placa = json_decode($_POST['Placa']);
			
			//$DescripcionImprenta = explode(',',strip_tags(utf8_decode($_POST['DescripcionImprenta'])));
			$DescripcionImprenta = json_decode($_POST['DescripcionImprenta']);
			
			//$NotaCotizacion = explode(',',strip_tags(utf8_decode($_POST['NotaCotizacion'])));
			$NotaCotizacion = json_decode($_POST['NotaCotizacion']);
			
			//print_r(json_decode($_POST['NotaCotizacion']));
			//print_r($NotaCotizacion);
			//$DescripcionBanner = explode(',',strip_tags(utf8_decode($_POST['DescripcionBanner'])));
			$DescripcionBanner = json_decode($_POST['DescripcionBanner']);
			
			//$MaterialBanner = explode(',',strip_tags(utf8_decode($_POST['MaterialBanner'])));
			$MaterialBanner = json_decode($_POST['MaterialBanner']);
			
			//$Ancho = explode(',',strip_tags(utf8_decode($_POST['Ancho'])));
			$Ancho = json_decode($_POST['Ancho']);			
			
			//$AnchoMedida = explode(',',strip_tags(utf8_decode($_POST['AnchoMedida'])));
			$AnchoMedida = json_decode($_POST['AnchoMedida']);	
			
			//$Largo = explode(',',strip_tags(utf8_decode($_POST['Largo'])));
			$Largo = json_decode($_POST['Largo']);
			
			//$LargoMedida = explode(',',strip_tags(utf8_decode($_POST['LargoMedida'])));
			$LargoMedida = json_decode($_POST['LargoMedida']);
			
			//$AreaTotal = explode(',',strip_tags(utf8_decode($_POST['AreaTotal'])));
			$AreaTotal = json_decode($_POST['AreaTotal']);
			
			//$FormaPago = explode(',',strip_tags(utf8_decode($_POST['FormaPago'])));
			$FormaPago = json_decode($_POST['FormaPago']);
			
			//$CalidadBanner = explode(',',strip_tags(utf8_decode($_POST['CalidadBanner'])));
			$CalidadBanner = json_decode($_POST['CalidadBanner']);
			
			//$PrecioInstalacion = explode(',',strip_tags(utf8_decode($_POST['PrecioInstalacion'])));
			$PrecioInstalacion = json_decode($_POST['PrecioInstalacion']);
			
			//$PrecioRecorte = explode(',',strip_tags(utf8_decode($_POST['PrecioRecorte'])));
			$PrecioRecorte = json_decode($_POST['PrecioRecorte']);
			
			//$PrecioArte = explode(',',strip_tags(utf8_decode($_POST['PrecioArte'])));
			$PrecioArte = json_decode($_POST['PrecioArte']);
			
			//$PrecioRotulado = explode(',',strip_tags(utf8_decode($_POST['PrecioRotulado'])));
			$PrecioRotulado = json_decode($_POST['PrecioRotulado']);
			
			//$PrecioBasta = explode(',',strip_tags(utf8_decode($_POST['PrecioBasta'])));	
			$PrecioBasta = json_decode($_POST['PrecioBasta']);
			
			//$PrecioOjete = explode(',',strip_tags(utf8_decode($_POST['PrecioOjete'])));
			$PrecioOjete = json_decode($_POST['PrecioOjete']);
			
			//$PrecioBulcaniza = explode(',',strip_tags(utf8_decode($_POST['PrecioBulcaniza'])));
			$PrecioBulcaniza = json_decode($_POST['PrecioBulcaniza']);
			
			$DescripcionImpresion = json_decode($_POST['DescripcionImpresion']);
			$MaterialImpresion = json_decode($_POST['MaterialImpresion']);
			$Recorte = json_decode($_POST['Recorte']);
			$Plastificado = json_decode($_POST['Plastificado']);
			$Caminado = json_decode($_POST['Caminado']);
			$Realce = json_decode($_POST['Realce']);			
			$Doblado = json_decode($_POST['Doblado']);
			$Repujado = json_decode($_POST['Repujado']);			
			$Engrapado = json_decode($_POST['Engrapado']);
			$UV = json_decode($_POST['UV']);
			$CantPliego = json_decode($_POST['CantPliego']);
			$AjustarTamano = json_decode($_POST['AjustarTamano']);
			
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
				$Numero_Factura = "";
			}
			else if ($rowsIdPC[0]['Numero_Factura'] < $rowsIdPV[0]['Numero_Factura'])
			{
				$Numero_Factura = $rowsIdPV[0]['Numero_Factura']+1;
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
			
			
			$cotizacion_base = ($_POST['cotizacion_base'] == null) ? 'NULL' : $_POST['cotizacion_base'];
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Cotización Agregado";
			$Tipo = "11";

			if($Numero_Factura!="")
			{
				$stmt = $db->prepare("INSERT INTO cotizaciones (id_cotizaciones,id_estatus, descripcion_cotizacion, monto_subtotal,monto_itbm,monto_total,id_cliente, id_tipo_cliente,fecha_creado, cotizacion_base) VALUES (?,1,?,?,?,?,?,?,NOW(),?)");
			}
			else
			{
				$stmt = $db->prepare("INSERT INTO cotizaciones (id_estatus, descripcion_cotizacion, monto_subtotal,monto_itbm,monto_total,id_cliente, id_tipo_cliente,fecha_creado, cotizacion_base) VALUES (1,?,?,?,?,?,?,NOW(),?)");
			}
			
			$c = 1;
			if($Numero_Factura!="")
			{			
				$stmt->bindParam($c,$Numero_Factura,PDO::PARAM_STR,255);			
				$c++;				
			}
			$stmt->bindParam($c,$DescripcionCotizacion,PDO::PARAM_STR,255);			
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
			$c++;
			$stmt->bindParam($c,$cotizacion_base,PDO::PARAM_STR,255);
			
			//$c++;
			//$stmt->bindParam($c,$NotaCotizacion,PDO::PARAM_STR,255);			
					
			$Insertado = $stmt->execute();
			
			if($Numero_Factura!="")
			{
				$Id_Cotizacion = $Numero_Factura;
			}
			else
			{
				$stmt = $db->query("SELECT MAX(id_cotizaciones) AS Id_Cotizacion FROM cotizaciones");

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$Id_Cotizacion = $results[0]["Id_Cotizacion"];			
			}
			//echo count($Cantidad);
			//print_r ($DescripcionImprenta);
			//echo count($DescripcionImprenta);
			
			$i = 0; $CantItem = 0; $Trabajo = 0;
			while ($i < count($Cantidad))
			{
				$DescImprenta = strip_tags(utf8_decode($DescripcionImprenta[$i]));
				$SinITBM = ($ExentoITBM[$i]==1)?(strip_tags(utf8_decode($ExentoITBM[$i]))):0;
				$Nota_Cotizacion = strip_tags(utf8_decode($NotaCotizacion[$i]));
				$Producto[$i] = strip_tags(utf8_decode($Producto[$i]));
				$TipoPagel = strip_tags(utf8_decode($PapelTipo[$i]));
				
				$Tamanio = strip_tags(utf8_decode($Tamano[$i]));
				$OtroTamanioAncho = strip_tags(utf8_decode($OtroTamanoAncho[$i]));
				$OtroTamanioLargo = strip_tags(utf8_decode($OtroTamanoLargo[$i]));
				$NumeroInicial = strip_tags(utf8_decode($NumeracionInicio[$i]));
				$NumeroFinal = strip_tags(utf8_decode($NumeracionFinal[$i]));				
				$ResmaTamanio = strip_tags(utf8_decode($ResmaTamano[$i]));
				$NumeroCopia = strip_tags(utf8_decode($CantidadCopia[$i]));					
				$Tinta = strip_tags(utf8_decode($ColorTinta[$i]));
				$ColorHoja = ($ColorPapel[$i]!="")?(strip_tags(utf8_decode($ColorPapel[$i]))):0;
				$ColorHoja1 = ($ColorPapel1[$i]!="")?(strip_tags(utf8_decode($ColorPapel1[$i]))):0;
				$ColorHoja2 = ($ColorPapel2[$i]!="")?(strip_tags(utf8_decode($ColorPapel2[$i]))):0;
				$ColorHoja3 = ($ColorPapel3[$i]!="")?(strip_tags(utf8_decode($ColorPapel3[$i]))):0;				
				$Forro = strip_tags(utf8_decode($TipoForro[$i]));					
				$Duracion = strip_tags(utf8_decode($Tiempo[$i]));					
				$TipoDuracion = strip_tags(utf8_decode($TipoTiempo[$i]));
				$Precio_Venta = strip_tags(utf8_decode($Precio[$i]));
				$Categoria = strip_tags(utf8_decode($TipoCategoria[$i]));
				$arte = strip_tags(utf8_decode($Arte[$i]));
				$placa = strip_tags(utf8_decode($Placa[$i]));

				$Descripcion_Banner = strip_tags(utf8_decode($DescripcionBanner[$i]));					
				$Material_Banner = strip_tags(utf8_decode($MaterialBanner[$i]));					
				$Wide = strip_tags(utf8_decode($Ancho[$i]));
				$Ancho_Medida = strip_tags(utf8_decode($AnchoMedida[$i]));
				$Large = strip_tags(utf8_decode($Largo[$i]));				
				$Largo_Medida = strip_tags(utf8_decode($LargoMedida[$i]));
				$Area_Total = strip_tags(utf8_decode($AreaTotal[$i]));
				$Forma_Pago = strip_tags(utf8_decode($FormaPago[$i]));					
				$Calidad_Banner = strip_tags(utf8_decode($CalidadBanner[$i]));
				$Precio_Instalacion = strip_tags(utf8_decode($PrecioInstalacion[$i]));
				$Precio_Recorte = strip_tags(utf8_decode($PrecioRecorte[$i]));
				$Precio_Arte = strip_tags(utf8_decode($PrecioArte[$i]));					
				$Precio_Rotulado = strip_tags(utf8_decode($PrecioRotulado[$i]));					
				$Precio_Basta = strip_tags(utf8_decode($PrecioBasta[$i]));
				$Precio_Ojete = strip_tags(utf8_decode($PrecioOjete[$i]));
				$Precio_Bulcaniza = strip_tags(utf8_decode($PrecioBulcaniza[$i]));
				
			
				
				 $Descripcion_Impresion = strip_tags(utf8_decode($DescripcionImpresion[$i]));				
				 $Material_Impresion = strip_tags(utf8_decode($MaterialImpresion[$i]));				
				 $Costo_Recorte = strip_tags(utf8_decode($Recorte[$i]));
				 $Costo_Plastificado = strip_tags(utf8_decode($Plastificado[$i]));
				 $Costo_Caminado = strip_tags(utf8_decode($Caminado[$i]));
				 $Costo_Realce = strip_tags(utf8_decode($Realce[$i]));				
				 $Costo_Doblado = strip_tags(utf8_decode($Doblado[$i]));
				 $Costo_Repujado = strip_tags(utf8_decode($Repujado[$i]));
				 $Costo_Engrapado = strip_tags(utf8_decode($Engrapado[$i]));
				 $Costo_UV = strip_tags(utf8_decode($UV[$i]));
				 $Cant_Pliego = strip_tags(utf8_decode($CantPliego[$i]));
				 $Ajustar_Tamano = strip_tags(utf8_decode($AjustarTamano[$i]));
			



				if ($TipoPagel==1)
				{
					$TipoMaterial = strip_tags(utf8_decode($MaterialPapelTipo[$i]));
				}
				else
				{
				
					try
					{

						$stmt = $db->prepare("SELECT id_tipo_material FROM imprenta_tipo_material WHERE id_tipo_papel = ? AND id_tipo_copia = ?");

						$c = 1;
						$stmt->bindParam($c,$TipoPagel,PDO::PARAM_INT);
						$c++;
						$stmt->bindParam($c,$NumeroCopia,PDO::PARAM_INT);			

			
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
							$TipoMaterial = $row['id_tipo_material'];
				
						}
					}
				}
				
				try
				{
					
					$stmt = $db->prepare("SELECT porcentaje FROM tipo_volumen_imprenta WHERE id_rango_volumen = ?");

					$c = 1;
					$stmt->bindParam($c,$Categoria,PDO::PARAM_INT);
			
					$stmt->execute();
					$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$nfilas = $stmt->rowCount();
					$stmt->closeCursor();
			
						
			
				if ($nfilas > 0)
				{
					$c = 1;
					foreach ($rows as $row)
					{
						$Ganancia = $row['porcentaje'];				
					}
				}			
			
				$Costo = number_format($Precio_Venta/((1+$Ganancia)),2,'.','');
				
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}		
				//echo $Costo;
				try
				{
					
					$stmt = $db->prepare("SELECT * FROM producto p 
					INNER JOIN categoria c ON (p.id_categoria = c.id_categoria) 
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
			
				if ($Producto[$i] == "timp")
				{				
			//echo "INSERT INTO imprenta (descripcion_imprenta,id_tipo_libreta,id_tipo_papel,id_tipo_material,id_resmatamano,id_tamano,numeracion_inicial,numeracion_final,otro_ancho,otro_largo,cant_copia,id_color_papel,id_color_papel1,id_color_papel2,id_color_papel3,id_color_tinta,id_forro,tiempo,id_tipo_tiempo,id_categoria,costo,precio_venta,exento_itbm,arte,placa,observacion,fecha_agregado)
			//		VALUES ('$DescImprenta', 1,'$TipoPagel','$TipoMaterial',$ResmaTamanio,'$Tamanio',$NumeroInicial,$NumeroFinal,$OtroTamanioAncho,$OtroTamanioLargo,'$NumeroCopia','$ColorHoja',$ColorHoja1,$ColorHoja2,$ColorHoja3,'$Tinta','$Forro','$Duracion','$TipoDuracion','$Categoria','$Costo','$Precio_Venta','$SinITBM',$arte,$placa,$Nota_Cotizacion,NOW())";
					
					//echo $DescImprenta;
					//echo $Producto[$i];	
					
					$stmt = $db->prepare("INSERT INTO imprenta (descripcion_imprenta,id_tipo_libreta,id_tipo_papel,id_tipo_material,id_resmatamano,id_tamano,numeracion_inicial,numeracion_final,otro_ancho,otro_largo,cant_copia,id_color_papel,id_color_papel1,id_color_papel2,id_color_papel3,id_color_tinta,id_forro,tiempo,id_tipo_tiempo,id_categoria,costo,precio_venta,exento_itbm,arte,placa,observacion,fecha_agregado)
					VALUES (?,1,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())");
					$c = 1;
					$stmt->bindParam($c,$DescImprenta,PDO::PARAM_STR,255);			
					$c++;					
					$stmt->bindParam($c,$TipoPagel,PDO::PARAM_INT);			
					$c++;
					$stmt->bindParam($c,$TipoMaterial,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$ResmaTamanio,PDO::PARAM_INT);						
					$c++;
					$stmt->bindParam($c,$Tamanio,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$NumeroInicial,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$NumeroFinal,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$OtroTamanioAncho,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$OtroTamanioLargo,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$NumeroCopia,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$ColorHoja,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$ColorHoja1,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$ColorHoja2,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$ColorHoja3,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$Tinta,PDO::PARAM_INT);				
					$c++;
					$stmt->bindParam($c,$Forro,PDO::PARAM_INT);				
					$c++;
					$stmt->bindParam($c,$Duracion,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$TipoDuracion,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Categoria,PDO::PARAM_INT);					
					$c++;					
					$stmt->bindParam($c,$Costo,PDO::PARAM_STR,255);				
					$c++;
					$stmt->bindParam($c,$Precio_Venta,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$SinITBM,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$arte,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$placa,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$Nota_Cotizacion,PDO::PARAM_STR,255);					

					$Insertado1 = $stmt->execute();
			
			//echo "-$SinITBM-";
			//echo $Insertado1;
			//print_r($stmt->errorInfo());
			
					$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Imprenta");
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$Id_Imprenta = $results[0]["Id_Imprenta"];
					$Tipo_Empaque[$i] = "";
					
					$Trabajo = $Trabajo  + 1;
					//$Nombre_Producto[$i] = "Libreta Factura";
				}
				else if ($Producto[$i] == "tbnr")
				{
			//echo "INSERT INTO imprenta (descripcion_imprenta,id_tipo_libreta,id_tipo_papel,id_tipo_material,id_tamano,cant_copia,id_color_papel,id_color_tinta,id_forro,tiempo,id_tipo_tiempo,id_categoria,costo,precio_venta,exento_itbm,fecha_agregado)
			//		VALUES ('$DescImprenta', 1,'$TipoPagel','$TipoMaterial','$Tamanio','$NumeroCopia','$ColorHoja','$Tinta','$Forro','$Duracion','$TipoDuracion','$Categoria','$Costo','$Precio_Venta','$SinITBM',NOW())";
					
					
					$stmt = $db->prepare("INSERT INTO banner (descripcion_banner,id_material,ancho,id_medida_ancho,largo,id_medida_largo,area_total,id_forma_pago,id_calidad,precio_instalacion,precio_recorte,precio_arte,precio_rotulado,precio_basta,precio_ojetes,precio_bulcaniza,precio_venta,exento_itbm,observacion,fecha_agregado)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())");
					$c = 1;
					$stmt->bindParam($c,$Descripcion_Banner,PDO::PARAM_STR,255);			
					$c++;					
					$stmt->bindParam($c,$Material_Banner,PDO::PARAM_INT);			
					$c++;
					$stmt->bindParam($c,$Wide,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Ancho_Medida,PDO::PARAM_INT);						
					$c++;
					$stmt->bindParam($c,$Large,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Largo_Medida,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Area_Total,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$Forma_Pago,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$Calidad_Banner,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Precio_Instalacion,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Precio_Recorte,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$Precio_Arte,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Precio_Rotulado,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Precio_Basta,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Precio_Ojete,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$Precio_Bulcaniza,PDO::PARAM_STR,255);				
					$c++;
					$stmt->bindParam($c,$Precio_Venta,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$SinITBM,PDO::PARAM_INT);					
					$c++;					
					$stmt->bindParam($c,$Nota_Cotizacion,PDO::PARAM_STR,255);					

					
					$Insertado1 = $stmt->execute();
			
			//echo "-$SinITBM-";
			//echo $Insertado1;
			//print_r($stmt->errorInfo());
			
					$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Banner");
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$Id_Banner = $results[0]["Id_Banner"];
					$Tipo_Empaque[$i] = "";
					//$Nombre_Producto[$i] = "Libreta Factura";				
				
					$Trabajo = $Trabajo  + 1;				
				
				}
				else if ($Producto[$i] == "timpart")
				{
					$stmt = $db->prepare("INSERT INTO impresion (descripcion_impresion,arte_ancho,arte_ancho_medida,arte_largo,arte_largo_medida,arte_area,ajustar_tamano,id_tamano,otro_ancho,otro_largo,cantidad_pliego,id_color_tinta,id_material,precio_arte,recorte,plastificado,caminado,realce,doblado,repujado,engrapado,UV,id_categoria,precio_venta,exento_itbm,observacion,fecha_agregado)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())");
					$c = 1;
					$stmt->bindParam($c,$Descripcion_Impresion,PDO::PARAM_STR,255);			
					$c++;
					$stmt->bindParam($c,$Wide,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Ancho_Medida,PDO::PARAM_INT);						
					$c++;
					$stmt->bindParam($c,$Large,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Largo_Medida,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Area_Total,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Ajustar_Tamano,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$Tamanio,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$OtroTamanioAncho,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$OtroTamanioLargo,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Cant_Pliego,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$Tinta,PDO::PARAM_INT);					
					$c++;					
					$stmt->bindParam($c,$Material_Impresion,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$Precio_Arte,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Costo_Recorte,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Costo_Plastificado,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Costo_Caminado,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$Costo_Realce,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Costo_Doblado,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Costo_Repujado,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Costo_Engrapado,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$Costo_UV,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Categoria,PDO::PARAM_INT);						
					$c++;
					$stmt->bindParam($c,$Precio_Venta,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$SinITBM,PDO::PARAM_INT);					
					$c++;					
					$stmt->bindParam($c,$Nota_Cotizacion,PDO::PARAM_STR,255);					

					
					$Insertado5 = $stmt->execute();
					//print_r($stmt->errorInfo());	
					$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Impresion");
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$Id_Impresion = $results[0]["Id_Impresion"];
					$Tipo_Empaque[$i] = "";
					
				
					$Trabajo = $Trabajo  + 1;

				
				}
				
				
				$Cant = strip_tags(utf8_decode($Cantidad[$i]));
				
		
				$stmt = $db->prepare("INSERT INTO cotizacion_producto (id_cotizacion,cantidad,id_producto,id_imprenta,id_banner,id_impresion,precio_venta,fecha_agregado) VALUES (?,?,?,?,?,?,?,NOW())");
				$c = 1;
				$stmt->bindParam($c,$Id_Cotizacion,PDO::PARAM_INT);	
				$c++;				
				$stmt->bindParam($c,$Cant,PDO::PARAM_INT);				
				
				if (is_numeric($Producto[$i]))
				{
					$Id_Producto = $Producto[$i];
					$Id_Imprenta = 0;
					$Id_Banner = 0;
					$Id_Impresion = 0;
					
					$c++;				
					$stmt->bindParam($c,$Id_Producto,PDO::PARAM_INT);			
					$c++;
					$stmt->bindParam($c,$Id_Imprenta,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Id_Banner,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Id_Impresion,PDO::PARAM_INT);					
				}
				else if ($Producto[$i] == "timp")
				{
					$Id_Producto = 0;
					$Id_Banner = 0;
					$Id_Impresion = 0;
					
					$c++;				
					$stmt->bindParam($c,$Id_Producto,PDO::PARAM_INT);			
					$c++;
					$stmt->bindParam($c,$Id_Imprenta,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Id_Banner,PDO::PARAM_INT);							
					$c++;
					$stmt->bindParam($c,$Id_Impresion,PDO::PARAM_INT);		

				}				
				else if ($Producto[$i] == "tbnr")
				{
					$Id_Producto = 0;
					$Id_Imprenta = 0;
					$Id_Impresion = 0;
					
					$c++;				
					$stmt->bindParam($c,$Id_Producto,PDO::PARAM_INT);			
					$c++;
					$stmt->bindParam($c,$Id_Imprenta,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Id_Banner,PDO::PARAM_INT);							
					$c++;
					$stmt->bindParam($c,$Id_Impresion,PDO::PARAM_INT);		

				}
				else if ($Producto[$i] == "timpart")
				{
					$Id_Producto = 0;
					$Id_Imprenta = 0;
					$Id_Banner = 0;
					
					$c++;				
					$stmt->bindParam($c,$Id_Producto,PDO::PARAM_INT);			
					$c++;
					$stmt->bindParam($c,$Id_Imprenta,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Id_Banner,PDO::PARAM_INT);							
					$c++;
					$stmt->bindParam($c,$Id_Impresion,PDO::PARAM_INT);		

				}				
				
				$c++;
				$stmt->bindParam($c,$Precio[$i],PDO::PARAM_STR,255);
				
			//echo "INSERT INTO cotizacion_producto (id_cotizacion,cantidad,id_producto,id_libreta,id_factura) VALUES ($Id_Cotizacion,$Cant,$Id_Producto,$Id_Libreta,$Id_Factura)";
			
				
				$Insertado2 = $stmt->execute();
				//print_r($stmt->errorInfo());
				//echo $Insertado2;
				$CantItem = $Insertado2 + $CantItem;
				
				$i = $i + 1;
			}				
				
			if ($Trabajo == 0)
			{
				$stmt = $db->prepare("UPDATE cotizaciones SET id_estatus= 3 WHERE id_cotizaciones=?");			
			
				$c = 1;
				$stmt->bindParam($c,$Id_Cotizacion,PDO::PARAM_INT);

				$SoloProducto = $stmt->execute();			
				
				$stmt->closeCursor();				
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
				
			$stmt = $db->prepare("INSERT INTO historial_cotizacion (id_cotizacion,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$Id_Cotizacion,PDO::PARAM_INT);
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
			echo md5($Id_Cotizacion);
			$db->commit();
		}
		else
		{
			echo "false";
			$db->rollBack();
		}
	
	}


	if($_GET['action'] == 'Modificar_Cotizacion')	
	{

		session_start();	
		$db->beginTransaction();
		try
		{




			


			$NumeroCotizacion	= strip_tags(utf8_decode($_POST['NumeroCotizacion']));
			$DescripcionCotizacion	= strip_tags($_POST['DescripcionCotizacion']);			
			$NombreCliente	= strip_tags(utf8_decode($_POST['NombreCliente']));
			$SubTotal	= strip_tags(utf8_decode($_POST['SubTotal']));
			$TotalITBM = strip_tags(utf8_decode($_POST['TotalITBM']));
			$TotalFinal = strip_tags(utf8_decode($_POST['TotalFinal']));
			/*$Cantidad = explode(',',strip_tags(utf8_decode($_POST['Cantidad'])));
			$Producto = explode(',',strip_tags(utf8_decode($_POST['Producto'])));
			$Precio = explode(',',strip_tags(utf8_decode($_POST['Precio'])));			
			$PapelTipo = explode(',',strip_tags(utf8_decode($_POST['PapelTipo'])));
			$MaterialPapelTipo = explode(',',strip_tags(utf8_decode($_POST['MaterialPapelTipo'])));
			$ResmaTamano = explode(',',strip_tags(utf8_decode($_POST['ResmaTamano'])));			
			$Tamano = explode(',',strip_tags(utf8_decode($_POST['Tamano'])));
			$OtroTamanoAncho = explode(',',strip_tags(utf8_decode($_POST['OtroTamanoAncho'])));
			$OtroTamanoLargo = explode(',',strip_tags(utf8_decode($_POST['OtroTamanoLargo'])));
			$NumeracionInicio = explode(',',strip_tags(utf8_decode($_POST['NumeracionInicio'])));
			$NumeracionFinal = explode(',',strip_tags(utf8_decode($_POST['NumeracionFinal'])));				
			$CantidadCopia = explode(',',strip_tags(utf8_decode($_POST['CantidadCopia'])));
			$ColorTinta = explode(',',strip_tags(utf8_decode($_POST['ColorTinta'])));
			$ColorPapel = explode(',',strip_tags(utf8_decode($_POST['ColorPapel'])));				
			$ColorPapel1 = explode(',',strip_tags(utf8_decode($_POST['ColorPapel1'])));
			$ColorPapel2 = explode(',',strip_tags(utf8_decode($_POST['ColorPapel2'])));				
			$ColorPapel3 = explode(',',strip_tags(utf8_decode($_POST['ColorPapel3'])));			
			$TipoForro = explode(',',strip_tags(utf8_decode($_POST['TipoForro'])));
			$Tiempo = explode(',',strip_tags(utf8_decode($_POST['Tiempo'])));
			$TipoTiempo = explode(',',strip_tags(utf8_decode($_POST['TipoTiempo'])));
			$TipoCategoria = explode(',',strip_tags(utf8_decode($_POST['TipoCategoria'])));
			$ExentoITBM = explode(',',strip_tags(utf8_decode($_POST['ExentoITBM'])));
			$Arte = explode(',',strip_tags(utf8_decode($_POST['Arte'])));			
			$Placa = explode(',',strip_tags(utf8_decode($_POST['Placa'])));			
			$DescripcionImprenta = explode(',',strip_tags(utf8_decode($_POST['DescripcionImprenta'])));	
			//$NotaCotizacion = explode(',',strip_tags(utf8_decode($_POST['NotaCotizacion'])));
			$NotaCotizacion = json_decode($_POST['NotaCotizacion']);
			
			$DescripcionBanner = explode(',',strip_tags(utf8_decode($_POST['DescripcionBanner'])));
			$MaterialBanner = explode(',',strip_tags(utf8_decode($_POST['MaterialBanner'])));
			$Ancho = explode(',',strip_tags(utf8_decode($_POST['Ancho'])));
			$AnchoMedida = explode(',',strip_tags(utf8_decode($_POST['AnchoMedida'])));			
			$Largo = explode(',',strip_tags(utf8_decode($_POST['Largo'])));
			$LargoMedida = explode(',',strip_tags(utf8_decode($_POST['LargoMedida'])));
			$AreaTotal = explode(',',strip_tags(utf8_decode($_POST['AreaTotal'])));			
			$FormaPago = explode(',',strip_tags(utf8_decode($_POST['FormaPago'])));
			$CalidadBanner = explode(',',strip_tags(utf8_decode($_POST['CalidadBanner'])));
			$PrecioInstalacion = explode(',',strip_tags(utf8_decode($_POST['PrecioInstalacion'])));
			$PrecioRecorte = explode(',',strip_tags(utf8_decode($_POST['PrecioRecorte'])));
			$PrecioArte = explode(',',strip_tags(utf8_decode($_POST['PrecioArte'])));			
			$PrecioRotulado = explode(',',strip_tags(utf8_decode($_POST['PrecioRotulado'])));
			$PrecioBasta = explode(',',strip_tags(utf8_decode($_POST['PrecioBasta'])));			
			$PrecioOjete = explode(',',strip_tags(utf8_decode($_POST['PrecioOjete'])));
			$PrecioBulcaniza = explode(',',strip_tags(utf8_decode($_POST['PrecioBulcaniza'])));*/

			$Cantidad = json_decode($_POST['Cantidad']);
			$Producto = json_decode($_POST['Producto']);
			$IdImprenta = json_decode($_POST['IdImprenta']);
			$IdBanner = json_decode($_POST['IdBanner']);
			$IdImpresion = json_decode($_POST['IdImpresion']);			
			$Precio = json_decode($_POST['Precio']);
			$PapelTipo = json_decode($_POST['PapelTipo']);
			$MaterialPapelTipo = json_decode($_POST['MaterialPapelTipo']);
			$ResmaTamano = json_decode($_POST['ResmaTamano']);
			$Tamano = json_decode($_POST['Tamano']);
			$OtroTamanoAncho = json_decode($_POST['OtroTamanoAncho']);
			$OtroTamanoLargo = json_decode($_POST['OtroTamanoLargo']);
			$NumeracionInicio = json_decode($_POST['NumeracionInicio']);	
			$NumeracionFinal = json_decode($_POST['NumeracionFinal']);			
			$CantidadCopia = json_decode($_POST['CantidadCopia']);
			$ColorTinta = json_decode($_POST['ColorTinta']);
			$ColorPapel = json_decode($_POST['ColorPapel']);
			$ColorPapel1 = json_decode($_POST['ColorPapel1']);
			$ColorPapel2 = json_decode($_POST['ColorPapel2']);
			$ColorPapel3 = json_decode($_POST['ColorPapel3']);
			$TipoForro = json_decode($_POST['TipoForro']);			
			$Tiempo = json_decode($_POST['Tiempo']);			
			$TipoTiempo = json_decode($_POST['TipoTiempo']);			
			$TipoCategoria = json_decode($_POST['TipoCategoria']);			
			$ExentoITBM = json_decode($_POST['ExentoITBM']);
			$Arte = json_decode($_POST['Arte']);
			$Placa = json_decode($_POST['Placa']);
			$DescripcionImprenta = json_decode($_POST['DescripcionImprenta']);
			$NotaCotizacion = json_decode($_POST['NotaCotizacion']);
			
			$DescripcionBanner = json_decode($_POST['DescripcionBanner']);
			$MaterialBanner = json_decode($_POST['MaterialBanner']);
			$Ancho = json_decode($_POST['Ancho']);			
			$AnchoMedida = json_decode($_POST['AnchoMedida']);	
			$Largo = json_decode($_POST['Largo']);
			$LargoMedida = json_decode($_POST['LargoMedida']);
			$AreaTotal = json_decode($_POST['AreaTotal']);
			$FormaPago = json_decode($_POST['FormaPago']);
			$CalidadBanner = json_decode($_POST['CalidadBanner']);
			$PrecioInstalacion = json_decode($_POST['PrecioInstalacion']);
			$PrecioRecorte = json_decode($_POST['PrecioRecorte']);
			$PrecioArte = json_decode($_POST['PrecioArte']);
			$PrecioRotulado = json_decode($_POST['PrecioRotulado']);
			$PrecioBasta = json_decode($_POST['PrecioBasta']);
			$PrecioOjete = json_decode($_POST['PrecioOjete']);
			$PrecioBulcaniza = json_decode($_POST['PrecioBulcaniza']);			
			
			
			$DescripcionImpresion = json_decode($_POST['DescripcionImpresion']);
			$MaterialImpresion = json_decode($_POST['MaterialImpresion']);
			$Recorte = json_decode($_POST['Recorte']);
			$Plastificado = json_decode($_POST['Plastificado']);
			$Caminado = json_decode($_POST['Caminado']);
			$Realce = json_decode($_POST['Realce']);			
			$Doblado = json_decode($_POST['Doblado']);
			$Repujado = json_decode($_POST['Repujado']);			
			$Engrapado = json_decode($_POST['Engrapado']);
			$UV = json_decode($_POST['UV']);
			$CantPliego = json_decode($_POST['CantPliego']);
			$AjustarTamano = json_decode($_POST['AjustarTamano']);			
			
			$stmt = $db->prepare("DELETE FROM cotizacion_producto WHERE id_cotizacion = ?");
			$c = 1;
			$stmt->bindParam($c,$NumeroCotizacion,PDO::PARAM_INT);
				
			$Eliminado = $stmt->execute();				
			
			
			
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
			
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Cotización Modificado";
			$Tipo = "13";

			
				$stmt1 = $db->prepare("UPDATE cotizaciones SET monto_subtotal=?,monto_itbm=?,monto_total=?,id_cliente=?,id_tipo_cliente=?,descripcion_cotizacion=?,ultima_actualizacion=NOW()
				WHERE id_cotizaciones=?");
			
				
				$c = 1;
				$stmt1->bindParam($c,$SubTotal,PDO::PARAM_STR,255);
				$c++;
				$stmt1->bindParam($c,$TotalITBM,PDO::PARAM_STR,255);
				$c++;
				$stmt1->bindParam($c,$TotalFinal,PDO::PARAM_STR,14);
				$c++;
				$stmt1->bindParam($c,$Id_Cliente,PDO::PARAM_INT);
				$c++;
				$stmt1->bindParam($c,$Id_Tipo_Cliente,PDO::PARAM_INT);
				$c++;
				$stmt1->bindParam($c,$DescripcionCotizacion,PDO::PARAM_STR,255);
				$c++;
				$stmt1->bindParam($c,$NumeroCotizacion,PDO::PARAM_INT);				
					
				$Actualizado = $stmt1->execute();			
			
				//$stmt1->closeCursor();
			//echo $Actualizado."\n";
			//echo $SubTotal."\n";
			//echo $NumeroCotizacion."\n";			
			//echo count($Cantidad);
			//print_r ($stmt1)."\n";
			
			$i = 0; $CantItem = 0; $Trabajo = 0;
			while ($i < count($Cantidad))
			{
				$DescImprenta = strip_tags(utf8_decode($DescripcionImprenta[$i]));
				
				$SinITBM = ($ExentoITBM[$i]==1)?strip_tags(utf8_decode($ExentoITBM[$i])):0;
				
				$Nota_Cotizacion = strip_tags(utf8_decode($NotaCotizacion[$i]));
				$Producto[$i] = strip_tags(utf8_decode($Producto[$i]));
				
				$IdImprenta[$i] = strip_tags(utf8_decode($IdImprenta[$i]));
				$IdBanner[$i] = strip_tags(utf8_decode($IdBanner[$i]));
				$IdImpresion[$i] = strip_tags(utf8_decode($IdImpresion[$i]));
				
				$TipoPagel = strip_tags(utf8_decode($PapelTipo[$i]));
				
				$Tamanio = strip_tags(utf8_decode($Tamano[$i]));
				$OtroTamanioAncho = strip_tags(utf8_decode($OtroTamanoAncho[$i]));
				$OtroTamanioLargo = strip_tags(utf8_decode($OtroTamanoLargo[$i]));
				$NumeroInicial = strip_tags(utf8_decode($NumeracionInicio[$i]));
				$NumeroFinal = strip_tags(utf8_decode($NumeracionFinal[$i]));				
				$ResmaTamanio = strip_tags(utf8_decode($ResmaTamano[$i]));
				$NumeroCopia = strip_tags(utf8_decode($CantidadCopia[$i]));					
				$Tinta = strip_tags(utf8_decode($ColorTinta[$i]));
				$ColorHoja = ($ColorPapel[$i]!="")?(strip_tags(utf8_decode($ColorPapel[$i]))):0;
				$ColorHoja1 = ($ColorPapel1[$i]!="")?(strip_tags(utf8_decode($ColorPapel1[$i]))):0;
				$ColorHoja2 = ($ColorPapel2[$i]!="")?(strip_tags(utf8_decode($ColorPapel2[$i]))):0;
				$ColorHoja3 = ($ColorPapel3[$i]!="")?(strip_tags(utf8_decode($ColorPapel3[$i]))):0;				
				$Forro = strip_tags(utf8_decode($TipoForro[$i]));					
				$Duracion = strip_tags(utf8_decode($Tiempo[$i]));					
				$TipoDuracion = strip_tags(utf8_decode($TipoTiempo[$i]));
				$Precio_Venta = strip_tags(utf8_decode($Precio[$i]));
				$Categoria = strip_tags(utf8_decode($TipoCategoria[$i]));

				$Descripcion_Banner = strip_tags(utf8_decode($DescripcionBanner[$i]));					
				$Material_Banner = strip_tags(utf8_decode($MaterialBanner[$i]));					
				$Wide = strip_tags(utf8_decode($Ancho[$i]));
				$Ancho_Medida = strip_tags(utf8_decode($AnchoMedida[$i]));
				$Large = strip_tags(utf8_decode($Largo[$i]));				
				$Largo_Medida = strip_tags(utf8_decode($LargoMedida[$i]));
				$Area_Total = strip_tags(utf8_decode($AreaTotal[$i]));
				$Forma_Pago = strip_tags(utf8_decode($FormaPago[$i]));					
				$Calidad_Banner = strip_tags(utf8_decode($CalidadBanner[$i]));
				$Precio_Instalacion = strip_tags(utf8_decode($PrecioInstalacion[$i]));
				$Precio_Recorte = strip_tags(utf8_decode($PrecioRecorte[$i]));
				$Precio_Arte = strip_tags(utf8_decode($PrecioArte[$i]));					
				$Precio_Rotulado = strip_tags(utf8_decode($PrecioRotulado[$i]));					
				$Precio_Basta = strip_tags(utf8_decode($PrecioBasta[$i]));
				$Precio_Ojete = strip_tags(utf8_decode($PrecioOjete[$i]));
				$Precio_Bulcaniza = strip_tags(utf8_decode($PrecioBulcaniza[$i]));
				
				$Descripcion_Impresion = strip_tags(utf8_decode($DescripcionImpresion[$i]));				
				$Material_Impresion = strip_tags(utf8_decode($MaterialImpresion[$i]));				
				$Costo_Recorte = strip_tags(utf8_decode($Recorte[$i]));
				$Costo_Plastificado = strip_tags(utf8_decode($Plastificado[$i]));
				$Costo_Caminado = strip_tags(utf8_decode($Caminado[$i]));
				$Costo_Realce = strip_tags(utf8_decode($Realce[$i]));				
				$Costo_Doblado = strip_tags(utf8_decode($Doblado[$i]));
				$Costo_Repujado = strip_tags(utf8_decode($Repujado[$i]));
				$Costo_Engrapado = strip_tags(utf8_decode($Engrapado[$i]));
				$Costo_UV = strip_tags(utf8_decode($UV[$i]));
				$Cant_Pliego = strip_tags(utf8_decode($CantPliego[$i]));
				$Ajustar_Tamano = strip_tags(utf8_decode($AjustarTamano[$i]));
				
				if ($TipoPagel==1)
				{
					$TipoMaterial = strip_tags(utf8_decode($MaterialPapelTipo[$i]));
				}
				else
				{
				
					try
					{

						$stmt = $db->prepare("SELECT id_tipo_material FROM imprenta_tipo_material WHERE id_tipo_papel = ? AND id_tipo_copia = ?");

						$c = 1;
						$stmt->bindParam($c,$TipoPagel,PDO::PARAM_INT);
						$c++;
						$stmt->bindParam($c,$NumeroCopia,PDO::PARAM_INT);			

			
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
							$TipoMaterial = $row['id_tipo_material'];
				
						}
					}
				}				
				
				try
				{
					$stmt = $db->prepare("SELECT porcentaje FROM tipo_volumen_imprenta WHERE id_rango_volumen = ?");

					$c = 1;
					$stmt->bindParam($c,$Categoria,PDO::PARAM_INT);
			
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
						$Ganancia = $row['porcentaje'];				
					}
				}			
			
				$Costo = number_format($Precio_Venta/((1+$Ganancia)),2,'.','');
				
				
				try
				{
					$stmt = $db->prepare("SELECT * FROM producto p 
					INNER JOIN categoria c ON (p.id_categoria = c.id_categoria) 
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
			
				if ($Producto[$i] == "timp")
				{				
			//echo "INSERT INTO imprenta (descripcion_imprenta,id_tipo_libreta,id_tipo_papel,id_tipo_material,id_tamano,cant_copia,id_color_papel,id_color_tinta,id_forro,tiempo,id_tipo_tiempo,id_categoria,costo,precio_venta,exento_itbm,fecha_agregado)
			//		VALUES ('$DescImprenta', 1,'$TipoPagel','$TipoMaterial','$Tamanio','$NumeroCopia','$ColorHoja','$Tinta','$Forro','$Duracion','$TipoDuracion','$Categoria','$Costo','$Precio_Venta','$SinITBM',NOW())";
		
					if ($IdImprenta[$i] != "")
					{
						$stmt = $db->prepare("UPDATE imprenta SET descripcion_imprenta = ?,id_tipo_libreta = 1,id_tipo_papel = ?,id_tipo_material = ?,
						id_resmatamano = ?,id_tamano = ?,numeracion_inicial = ?,numeracion_final = ?,otro_ancho = ?,otro_largo = ?,cant_copia = ?,
						id_color_papel = ?,id_color_papel1 = ?,id_color_papel2 = ?,id_color_papel3 = ?,id_color_tinta = ?,id_forro = ?,tiempo = ?,id_tipo_tiempo = ?,
						id_categoria = ?,costo = ?,precio_venta = ?,exento_itbm = ?,arte = ?,placa = ?,observacion = ?,ultima_actualizacion=NOW()
						WHERE MD5(id_imprenta) = ?");					
					}
					else
					{
						$stmt = $db->prepare("INSERT INTO imprenta (descripcion_imprenta,id_tipo_libreta,id_tipo_papel,id_tipo_material,id_resmatamano,id_tamano,numeracion_inicial,numeracion_final,otro_ancho,otro_largo,cant_copia,id_color_papel,id_color_papel1,id_color_papel2,id_color_papel3,id_color_tinta,id_forro,tiempo,id_tipo_tiempo,id_categoria,costo,precio_venta,exento_itbm,arte,placa,observacion,fecha_agregado)
						VALUES (?,1,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())");
					}
					
					
					$c = 1;
					$stmt->bindParam($c,$DescImprenta,PDO::PARAM_STR,255);			
					$c++;					
					$stmt->bindParam($c,$TipoPagel,PDO::PARAM_INT);			
					$c++;
					$stmt->bindParam($c,$TipoMaterial,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$ResmaTamanio,PDO::PARAM_INT);						
					$c++;
					$stmt->bindParam($c,$Tamanio,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$NumeroInicial,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$NumeroFinal,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$OtroTamanioAncho,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$OtroTamanioLargo,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$NumeroCopia,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$ColorHoja,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$ColorHoja1,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$ColorHoja2,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$ColorHoja3,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$Tinta,PDO::PARAM_INT);				
					$c++;
					$stmt->bindParam($c,$Forro,PDO::PARAM_INT);				
					$c++;
					$stmt->bindParam($c,$Duracion,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$TipoDuracion,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Categoria,PDO::PARAM_INT);					
					$c++;					
					$stmt->bindParam($c,$Costo,PDO::PARAM_STR,255);				
					$c++;
					$stmt->bindParam($c,$Precio_Venta,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$SinITBM,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Arte,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$Placa,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$Nota_Cotizacion,PDO::PARAM_STR,255);
					
					if ($IdImprenta[$i] != "")
					{	
						$c++;
						$stmt->bindParam($c,$IdImprenta[$i],PDO::PARAM_STR,255);
					}

					$Insertado1 = $stmt->execute();
					//echo $Insertado1;
			//echo "-$SinITBM-";
			//echo $Insertado1;
			//echo $TipoMaterial;
			//echo $ColorHoja3;
			//echo $IdImprenta[$i];
			//print_r($stmt->errorInfo());

					if ($IdImprenta[$i] != "")
					{
						$stmt = $db->prepare("SELECT * FROM imprenta WHERE MD5(id_imprenta) = ?");

						$c = 1;
						$stmt->bindParam($c,$IdImprenta[$i],PDO::PARAM_STR,255);		
				
						$stmt->execute();
						$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$Id_Imprenta = $results[0]["id_imprenta"];
						
						$stmt->closeCursor();				
					}
					else
					{
						$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Imprenta");
						$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$Id_Imprenta = $results[0]["Id_Imprenta"];
					}
					
					
					$Tipo_Empaque[$i] = "";
					//$Nombre_Producto[$i] = "Libreta Factura";
					
					$Trabajo = $Trabajo  + 1;					
				}
				else if ($Producto[$i] == "tbnr")
				{
					//echo "INSERT INTO banner (descripcion_banner,id_material,ancho,id_medida_ancho,largo,id_medida_largo,area_total,id_forma_pago,id_calidad,precio_instalacion,precio_recorte,precio_arte,precio_rotulado,precio_basta,precio_ojetes,precio_bulcaniza,precio_venta,exento_itbm,observacion,fecha_agregado)
					//VALUES ('$Descripcion_Banner','$Material_Banner',$Wide,$Ancho_Medida,$Large,$Largo_Medida,$Area_Total,$Forma_Pago,$Calidad_Banner,$Precio_Instalacion,$Precio_Recorte,$Precio_Arte,$Precio_Rotulado,$Precio_Basta,$Precio_Ojete,$Precio_Bulcaniza,$Precio_Venta,$SinITBM,'$Nota_Cotizacion',NOW())";
					
					if ($IdBanner[$i] != "")
					{
						$stmt = $db->prepare("UPDATE banner SET descripcion_banner = ?,id_material = ?,ancho = ?,id_medida_ancho = ?,largo = ?,
						id_medida_largo = ?,area_total = ?,id_forma_pago = ?,id_calidad = ?,precio_instalacion = ?,precio_recorte = ?,precio_arte = ?,
						precio_rotulado = ?,precio_basta = ?,precio_ojetes = ?,precio_bulcaniza = ?,precio_venta = ?,exento_itbm = ?,
						observacion = ?,ultima_actualizacion=NOW()
						WHERE MD5(id_banner) = ?");					
					}
					else
					{					
						$stmt = $db->prepare("INSERT INTO banner (descripcion_banner,id_material,ancho,id_medida_ancho,largo,id_medida_largo,area_total,id_forma_pago,id_calidad,precio_instalacion,precio_recorte,precio_arte,precio_rotulado,precio_basta,precio_ojetes,precio_bulcaniza,precio_venta,exento_itbm,observacion,fecha_agregado)
						VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())");
					}
					
					$stmt->bindParam($c,$Descripcion_Banner,PDO::PARAM_STR,255);			
					$c++;					
					$stmt->bindParam($c,$Material_Banner,PDO::PARAM_INT);			
					$c++;
					$stmt->bindParam($c,$Wide,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Ancho_Medida,PDO::PARAM_INT);						
					$c++;
					$stmt->bindParam($c,$Large,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Largo_Medida,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Area_Total,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$Forma_Pago,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$Calidad_Banner,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Precio_Instalacion,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Precio_Recorte,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$Precio_Arte,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Precio_Rotulado,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Precio_Basta,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Precio_Ojete,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$Precio_Bulcaniza,PDO::PARAM_STR,255);				
					$c++;
					$stmt->bindParam($c,$Precio_Venta,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$SinITBM,PDO::PARAM_INT);					
					$c++;					
					$stmt->bindParam($c,$Nota_Cotizacion,PDO::PARAM_STR,255);					
					
					if ($IdBanner[$i] != "")
					{		
						$c++;
						$stmt->bindParam($c,$IdBanner[$i],PDO::PARAM_STR,255);
					}
			//print_r($stmt);					
					$Insertado1 = $stmt->execute();
			//echo $IdBanner[$i];
			//echo "-$SinITBM-" ;
			//echo $Insertado1;

			//print_r($stmt->errorInfo());

					if ($IdBanner[$i] != "")
					{
						$stmt = $db->prepare("SELECT * FROM banner WHERE MD5(id_banner) = ?");

						$c = 1;
						$stmt->bindParam($c,$IdBanner[$i],PDO::PARAM_STR,255);		
				
						$stmt->execute();
						$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$Id_Banner = $results[0]["id_banner"];
						
						$stmt->closeCursor();				
					}
					else
					{			
						$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Banner");
						$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$Id_Banner = $results[0]["Id_Banner"];
					}
					
					$Tipo_Empaque[$i] = "";
					//$Nombre_Producto[$i] = "Libreta Factura";				
				
					$Trabajo = $Trabajo  + 1;				
				
				}
				else if ($Producto[$i] == "timpart")
				{
					if ($IdImpresion[$i] != "")
					{
						$stmt = $db->prepare("UPDATE impresion SET descripcion_impresion = ?,arte_ancho = ?,arte_ancho_medida = ?,arte_largo = ?,
						arte_largo_medida = ?,arte_area = ?,ajustar_tamano = ?,id_tamano = ?,otro_ancho = ?,otro_largo = ?,cantidad_pliego = ?,
						id_color_tinta = ?,id_material = ?,precio_arte = ?,recorte = ?,plastificado = ?,caminado = ?,realce = ?,doblado = ?,
						repujado = ?,engrapado = ?,UV = ?,id_categoria = ?,precio_venta = ?,exento_itbm = ?,observacion = ?,ultima_actualizacion=NOW()
						WHERE MD5(id_impresion) = ?");					
					}
					else
					{						
						$stmt = $db->prepare("INSERT INTO impresion (descripcion_impresion,arte_ancho,arte_ancho_medida,arte_largo,arte_largo_medida,arte_area,ajustar_tamano,id_tamano,otro_ancho,otro_largo,cantidad_pliego,id_color_tinta,id_material,precio_arte,recorte,plastificado,caminado,realce,doblado,repujado,engrapado,UV,id_categoria,precio_venta,exento_itbm,observacion,fecha_agregado)
						VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())");
					}
					
					$c = 1;
					$stmt->bindParam($c,$Descripcion_Impresion,PDO::PARAM_STR,255);			
					$c++;
					$stmt->bindParam($c,$Wide,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Ancho_Medida,PDO::PARAM_INT);						
					$c++;
					$stmt->bindParam($c,$Large,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Largo_Medida,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Area_Total,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Ajustar_Tamano,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$Tamanio,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$OtroTamanioAncho,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$OtroTamanioLargo,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Cant_Pliego,PDO::PARAM_INT);
					$c++;					
					$stmt->bindParam($c,$Tinta,PDO::PARAM_INT);					
					$c++;					
					$stmt->bindParam($c,$Material_Impresion,PDO::PARAM_INT);					
					$c++;
					$stmt->bindParam($c,$Precio_Arte,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Costo_Recorte,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Costo_Plastificado,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Costo_Caminado,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$Costo_Realce,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Costo_Doblado,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Costo_Repujado,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Costo_Engrapado,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$Costo_UV,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Categoria,PDO::PARAM_INT);						
					$c++;
					$stmt->bindParam($c,$Precio_Venta,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$SinITBM,PDO::PARAM_INT);					
					$c++;					
					$stmt->bindParam($c,$Nota_Cotizacion,PDO::PARAM_STR,255);					

					if ($IdImpresion[$i] != "")
					{					
						$c++;
						$stmt->bindParam($c,$IdImpresion[$i],PDO::PARAM_STR,255);
					}
					
					$Insertado5 = $stmt->execute();
					//print_r($stmt->errorInfo());

					//echo $IdImpresion[$i]."-$Id_Impresion";
					
					if ($IdImpresion[$i] != "")
					{
						$stmt = $db->prepare("SELECT * FROM impresion WHERE MD5(id_impresion) = ?");

						$c = 1;
						$stmt->bindParam($c,$IdImpresion[$i],PDO::PARAM_STR,255);		
				
						$stmt->execute();
						$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$Id_Impresion = $results[0]["id_impresion"];
						
						$stmt->closeCursor();				
					}
					else
					{						
						$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Impresion");
						$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$Id_Impresion = $results[0]["Id_Impresion"];
					}

					
					$Tipo_Empaque[$i] = "";
					
				
					$Trabajo = $Trabajo  + 1;

				
				}
				
				
				$Cant = $Cantidad[$i];
				
		
				$stmt = $db->prepare("INSERT INTO cotizacion_producto (id_cotizacion,cantidad,id_producto,id_imprenta,id_banner,id_impresion,precio_venta,fecha_agregado) VALUES (?,?,?,?,?,?,?,NOW())");
				$c = 1;
				$stmt->bindParam($c,$NumeroCotizacion,PDO::PARAM_INT);	
				$c++;				
				$stmt->bindParam($c,$Cant,PDO::PARAM_INT);				
				
				if (is_numeric($Producto[$i]))
				{
					$Id_Producto = $Producto[$i];
					$Id_Imprenta = 0;
					$Id_Banner = 0;
					$Id_Impresion = 0;
					
					$c++;				
					$stmt->bindParam($c,$Id_Producto,PDO::PARAM_INT);			
					$c++;
					$stmt->bindParam($c,$Id_Imprenta,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Id_Banner,PDO::PARAM_INT);	
					$c++;
					$stmt->bindParam($c,$Id_Impresion,PDO::PARAM_INT);
					
				}
				else if ($Producto[$i] == "timp")
				{
					$Id_Producto = 0;
					$Id_Banner = 0;
					$Id_Impresion = 0;
					
					$c++;				
					$stmt->bindParam($c,$Id_Producto,PDO::PARAM_INT);			
					$c++;
					$stmt->bindParam($c,$Id_Imprenta,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Id_Banner,PDO::PARAM_INT);							
					$c++;
					$stmt->bindParam($c,$Id_Impresion,PDO::PARAM_INT);

				}				
				else if ($Producto[$i] == "tbnr")
				{
					$Id_Producto = 0;
					$Id_Imprenta = 0;
					$Id_Impresion = 0;
					
					$c++;				
					$stmt->bindParam($c,$Id_Producto,PDO::PARAM_INT);			
					$c++;
					$stmt->bindParam($c,$Id_Imprenta,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Id_Banner,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Id_Impresion,PDO::PARAM_INT);					

				}
				else if ($Producto[$i] == "timpart")
				{
					$Id_Producto = 0;
					$Id_Imprenta = 0;
					$Id_Banner = 0;
					
					$c++;				
					$stmt->bindParam($c,$Id_Producto,PDO::PARAM_INT);			
					$c++;
					$stmt->bindParam($c,$Id_Imprenta,PDO::PARAM_INT);
					$c++;
					$stmt->bindParam($c,$Id_Banner,PDO::PARAM_INT);							
					$c++;
					$stmt->bindParam($c,$Id_Impresion,PDO::PARAM_INT);		

				}
				
				$c++;
				$stmt->bindParam($c,$Precio[$i],PDO::PARAM_STR,255);			

			//echo "INSERT INTO cotizacion_producto (id_cotizacion,cantidad,id_producto,id_libreta,id_factura) VALUES ($Id_Cotizacion,$Cant,$Id_Producto,$Id_Libreta,$Id_Factura)";
			
				
				$Insertado2 = $stmt->execute();
				//print_r($stmt->errorInfo());
				//echo $Insertado2;
				$CantItem = $Insertado2 + $CantItem;
				
				$i = $i + 1;
			}				

			if ($Trabajo == 0)
			{
				$stmt = $db->prepare("UPDATE cotizaciones SET id_estatus= 3 WHERE id_cotizaciones=?");			
			
				$c = 1;
				$stmt->bindParam($c,$Id_Cotizacion,PDO::PARAM_INT);

				$SoloProducto = $stmt->execute();			
				
				$stmt->closeCursor();				
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
				
			$stmt = $db->prepare("INSERT INTO historial_cotizacion (id_cotizacion,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$Id_Cotizacion,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado4 = $stmt->execute();			
				
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();		
		}	
	
		echo "$Eliminado-$Actualizado-$Insertado3-$Insertado4-$CantItem-$Cantidad";
	
		if (($Eliminado === true) and ($Actualizado === true)  and ($Insertado3 === true) and ($Insertado4 === true) and ($CantItem > 0) and (count($Cantidad) == $CantItem))
		{
			echo md5($NumeroCotizacion);
			$db->commit();
		}
		else
		{
			echo "false";
			$db->rollBack();
		}	

	}

	if($_GET['action'] == 'Eliminar_Cotizacion')	
	{

		session_start();
		$db->beginTransaction();
		try
		{
			$Id_Cotizaciones = strip_tags(utf8_decode($_POST['IdCotizacion']));				
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Cotización Eliminado";
			$Tipo = "12";			
			
			$stmt = $db->prepare("SELECT * FROM cotizaciones WHERE MD5(id_cotizaciones) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Cotizaciones,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_cotizaciones = $results[0]["id_cotizaciones"];	
			$stmt->closeCursor();

			$stmt = $db->prepare("SELECT * FROM cotizacion_producto WHERE MD5(id_cotizaciones) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Cotizaciones,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			$stmt->closeCursor();
			
			$f = 0;
			foreach ($results as $row)
			{
			
				if ($row["id_imprenta"] > 0)
				{
					$id_imprenta = $row["id_imprenta"];
					
					$stmt = $db->prepare("DELETE FROM imprenta WHERE id_imprenta = ?");
					$c = 1;
					$stmt->bindParam($c,$id_imprenta,PDO::PARAM_STR,255);

					$Eliminado3 = $stmt->execute();							
				
				}
				else if ($row["id_banner"] > 0)
				{
					$id_banner = $row["id_banner"];	

					$stmt = $db->prepare("DELETE FROM banner WHERE id_banner = ?");
					$c = 1;
					$stmt->bindParam($c,$id_banner,PDO::PARAM_STR,255);						
			
			
					$Eliminado2 = $stmt->execute();			
				}
				
				$f = $f + 1;
			}
			
			
			$stmt = $db->prepare("DELETE FROM cotizacion_producto WHERE MD5(id_cotizacion) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Cotizaciones,PDO::PARAM_STR,255);			

			$Eliminado1 = $stmt->execute();
			
			$stmt = $db->prepare("DELETE FROM cotizaciones WHERE MD5(id_cotizaciones) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Cotizaciones,PDO::PARAM_STR,255);

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
				
			$stmt = $db->prepare("INSERT INTO historial_cotizacion (id_cotizacion,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_cotizaciones,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();				
				
			$stmt->closeCursor();
				
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
	
		//echo "$Eliminado-$Eliminado1-$Insertado1-$Insertado2";
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
	
	if($_GET['action'] == 'BuscarCotizacion')
	{
		
		$idCotizacion	= strip_tags(utf8_decode($_POST['idCotizacion']));
		
		try
		{		
			$stmt = $db->prepare("SELECT id_cotizaciones, descripcion_cotizacion FROM cotizaciones
			WHERE MD5(id_cotizaciones) = ?");
			
			//$stmt = $db->prepare("SELECT id_cotizaciones, descripcion_cotizacion FROM cotizaciones c
			//INNER JOIN abono a ON (a.id_cotizacion = c.id_cotizaciones) WHERE MD5(id_cotizaciones) = ?  AND (monto_abonado/monto_total) >= 0.25");			
			
			$c = 1;
			$stmt->bindParam($c,$idCotizacion,PDO::PARAM_STR,255);	
			//$c++;
			//$stmt->bindParam($c,$idCotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
	
		$DetalleCotizacion[0] = $rows[0]['id_cotizaciones'];
		$DetalleCotizacion[1] = $rows[0]['descripcion_cotizacion'];
	
		echo json_encode($DetalleCotizacion);
		
	}
	
	if($_GET['action'] == 'BuscarCliente')
	{
		
		$idCotizacion	= strip_tags(utf8_decode(strtolower($_POST['idCotizacion'])));
		
		try
		{		
			$stmt = $db->prepare("SELECT id_cliente, id_tipo_cliente FROM cotizaciones WHERE MD5(id_cotizaciones) = ?");
			
			$c = 1;
			$stmt->bindParam($c,$idCotizacion,PDO::PARAM_STR,255);				
			
			$stmt->execute();
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
			$stmt = $db->prepare("SELECT CONCAT(nombre,' ',apellido) AS Nombre_Cliente 
			FROM cliente_persona WHERE id_cliente = ?");
			else if($rows[0]['id_tipo_cliente']==2)
			$stmt = $db->prepare("SELECT nombre_empresa AS Nombre_Cliente
			FROM cliente_empresa  WHERE id_cliente = ?");
					
			$p = 1;
			$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_INT);
			
			$stmt->execute();
			$rowsCliente = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
					
			$NombreCliente[0] = utf8_encode($rowsCliente[0]['Nombre_Cliente']);
			$NombreCliente[1] = $Id_Cliente;			
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
	
		//echo $NombreCliente[0];
		echo json_encode($NombreCliente);
		
	}
	
	if($_GET['action'] == 'Listar_Cotizaciones')
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
			array( 'db' => 'Nombre_Cliente',   'dt' => 2 ),
			array( 'db' => 'id_estatus',   'dt' => 3 ),
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
			$stmt = $db->prepare("SELECT SQL_CALC_FOUND_ROWS id_cliente,id_tipo_cliente,id_cotizaciones,id_estatus,descripcion_estatus,monto_subtotal,
			monto_itbm,monto_total,monto_abonado,Nombre_Cliente,credito FROM (
			SELECT id_cliente,id_tipo_cliente,id_cotizaciones,co.id_estatus, descripcion_estatus,monto_subtotal,monto_itbm,monto_total,
			IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones)) AS monto_abonado, 
			IF(id_tipo_cliente = 1,(SELECT CONCAT(nombre,' ',apellido) FROM cliente_persona WHERE id_cliente = co.id_cliente),
			(SELECT nombre_empresa FROM cliente_empresa  WHERE id_cliente = co.id_cliente)) AS Nombre_Cliente,
			(SELECT credito FROM cliente_persona WHERE id_cliente = co.id_cliente) AS credito			
			FROM cotizaciones co INNER JOIN tipo_estatus_cotizacion te ON (te.id_estatus = co.id_estatus)) AS T ".$where."  ".$order." ".$limit);
			
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
			FROM cotizaciones co INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus)");			
				
			$stmt->execute();			
			$recordsTotal = $stmt->fetchColumn (0);
			
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
			
		/*$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable" id="Cotizacion"><thead><tr>';			

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
				<th style="width:6%">Opciones</th>';	

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
					
					$Id_Cliente = $row['id_cliente'];
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
				
				$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
						<td  align="center">'.$c.'</td>
						<td align="center" >'.utf8_encode($row['id_cotizaciones']).'<input type="hidden" id="hidIdCotizacion'.$c.'" name="hidIdCotizacion[]" value="'.utf8_encode($row['id_cotizaciones']).'" /></td>
						<td>'.utf8_encode($NombreCliente).'<input type="hidden" id="hidNombreCliente'.$c.'" name="hidNombreCliente[]" value="'.utf8_encode($NombreCliente).'" /></td>
						<td><i class="fa fa-circle" style="color:'.((($row['id_estatus'])=="3")?'green;':((($row['id_estatus'])=="2")?'yellow;':((($row['id_estatus'])=="1")?'red;':''))).'"></i> '.utf8_encode($row['descripcion_estatus']).'<input type="hidden" id="hidEstatusCotizacion'.$c.'" name="hidEstatusCotizacion[]" value="'.utf8_encode($row['descripcion_estatus']).'" /></td>
						<td>B/.&nbsp;'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'<input type="hidden" id="hidMontoSubTotal'.$c.'" name="hidMontoSubTotal[]" value="'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'" /></td>						
						<td>B/.&nbsp;'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'<input type="hidden" id="hidMontoITBM'.$c.'" name="hidMontoITBM[]" value="'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'" /></td>
						<td>B/.&nbsp;'.utf8_encode(number_format($row['monto_total'],2,'.','')).'<input type="hidden" id="hidMontoTotal'.$c.'" name="hidMontoTotal[]" value="'.utf8_encode(number_format($row['monto_total'],2,'.','')).'" />
						<td>B/.&nbsp;'.utf8_encode(number_format($row['monto_abonado'],2,'.','')).'<input type="hidden" id="hidMontoAbonado'.$c.'" name="hidMontoAbonado[]" value="'.utf8_encode(number_format($row['monto_abonado'],2,'.','')).'" />';						
						
					if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
					{
						$html .='</td><td>';
				
					
						if (($row['id_estatus'] == 3) or ($TrabajoImprenta == 0))
						{
							$html .='<a href="javascript:void(0);" title="Imprimir" class="smallButton" style="margin: 5px;" onclick="Imprimir_Detalle_Venta(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/color/blue-document-pdf-text.png" alt="" class="icon" /><span></span></a>';
						}
						else
						{
							if ((($TrabajoImprenta > 0) and ($ExisteTrabajoImprenta == 0)) or ($TrabajoImprenta > $ExisteTrabajoImprenta))
							{
								if ($row['monto_total'] >= 0)
								{
									if ((((($row['monto_abonado']/$row['monto_total']) > 0.50) or ($Credito == 1)) and ((base64_decode($_SESSION['id_tipo_usuario']) != 1) or (base64_decode($_SESSION['id_tipo_usuario']) != 2)))
									or ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2)))
									$html .='<a href="javascript:void(0);" title="Generar Orden de Trabajo" class="smallButton" style="margin: 5px;" onclick="Generar_Orden_de_Trabajo(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/color/plus.png" alt="" class="icon" /><span></span></a>';								
								}
								else
								{
									$html .='<a href="javascript:void(0);" title="Generar Orden de Trabajo" class="smallButton" style="margin: 5px;" onclick="Generar_Orden_de_Trabajo(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/color/plus.png" alt="" class="icon" /><span></span></a>';								
								}
							}
							
							if(number_format($row['monto_abonado'],2,'.','') < number_format($row['monto_total'],2,'.',''))
							$html .= '<a href="javascript:void(0);" title="Abonar Cotizaci&oacute;n" class="smallButton" style="margin: 5px;" onclick="Agregar_Abono('.$c.');"><img src="public/images/icons/dark/cart.png" alt="" class="icon" /><span></span></a>';
						
							
							$html .='<a href="javascript:void(0);" title="Editar Cotizaci&oacute;n" class="smallButton" style="margin: 5px;" onclick="Editar_Cotizacion(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
						
						}
						$html .='<a href="javascript:void(0);" title="Detalle de Cotizaci&oacute;n" class="smallButton" style="margin: 5px;" onclick="Ver_Detalle_Cotizacion('.$c.')"><i class="fa fa-file-pdf-o"></i><span></span></a>';
						if(number_format($row['monto_abonado'],2,'.','') > 0)
						$html .='<a href="javascript:void(0);" title="Imprimir &Uacute;timo Recibo de Abono" class="smallButton" style="margin: 5px;" onclick="Imprimir_Ultimo_Recibo_Abono('.$c.')"><i class="fa fa-file-text-o"></i><span></span></a>';
						
						$html .='<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar esta Cotización?\')){Eliminar_Cotizacion('.$c.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
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
				
				/*try
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
				}*/

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
					
					$Id_Cliente = $row['id_cliente'];
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


				$Data[$f][$c] = $f+1;
				$c++;
				$Data[$f][$c] = utf8_encode($row['id_cotizaciones']).'<input type="hidden" id="hidIdCotizacion'.$f.'" name="hidIdCotizacion[]" value="'.utf8_encode($row['id_cotizaciones']).'" />';
				$c++;
				$Data[$f][$c] = utf8_encode($row['Nombre_Cliente']).'<input type="hidden" id="hidNombreCliente'.$f.'" name="hidNombreCliente[]" value="'.utf8_encode($row['Nombre_Cliente']).'" />';
				$c++;
				$Data[$f][$c] = '<i class="fa fa-circle" style="color:'.((($row['id_estatus'])=="4")?'green;':((($row['id_estatus'])=="3")?'blue;':((($row['id_estatus'])=="2")?'yellow;':((($row['id_estatus'])=="1")?'red;':'')))).'"></i> '.utf8_encode($row['descripcion_estatus']).'<input type="hidden" id="hidEstatusCotizacion'.$f.'" name="hidEstatusCotizacion[]" value="'.utf8_encode($row['descripcion_estatus']).'" />';
				$c++;
				$Data[$f][$c] = 'B/.&nbsp;'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'<input type="hidden" id="hidMontoSubTotal'.$f.'" name="hidMontoSubTotal[]" value="'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'" />';
				$c++;
				$Data[$f][$c] = 'B/.&nbsp;'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'<input type="hidden" id="hidMontoITBM'.$f.'" name="hidMontoITBM[]" value="'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'" />';
				$c++;
				$Data[$f][$c] = 'B/.&nbsp;'.utf8_encode(number_format($row['monto_total'],2,'.','')).'<input type="hidden" id="hidMontoTotal'.$f.'" name="hidMontoTotal[]" value="'.utf8_encode(number_format($row['monto_total'],2,'.','')).'" />';
				$c++;
				$Data[$f][$c] = 'B/.&nbsp;'.utf8_encode(number_format($row['monto_abonado'],2,'.','')).'<input type="hidden" id="hidMontoAbonado'.$f.'" name="hidMontoAbonado[]" value="'.utf8_encode(number_format($row['monto_abonado'],2,'.','')).'" />';
				$c++;
				
				$Data[$f][$c] = "";
				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
				{
				
					if (($row['id_estatus'] == 4) or ($TrabajoImprenta == 0))
					{
						$Data[$f][$c] .='<a href="javascript:void(0);" title="Imprimir" class="smallButton" style="margin: 5px;" onclick="Imprimir_Detalle_Venta(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/color/blue-document-pdf-text.png" alt="" class="icon" /><span></span></a>';
					}
					else
					{
						if ((($TrabajoImprenta > 0) and ($ExisteTrabajoImprenta == 0)) or ($TrabajoImprenta > $ExisteTrabajoImprenta))
						{
							if ($row['monto_total'] >= 0)
							{
								if ((((($row['monto_abonado']/$row['monto_total']) > 0.50) or ($row['credito'] == 1)) and ((base64_decode($_SESSION['id_tipo_usuario']) != 1) or (base64_decode($_SESSION['id_tipo_usuario']) != 2)))
								or ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2)))
								$Data[$f][$c] .='<a href="javascript:void(0);" title="Generar Orden de Trabajo" class="smallButton" style="margin: 5px;" onclick="Generar_Orden_de_Trabajo(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/color/plus.png" alt="" class="icon" /><span></span></a>';								
							}
							else
							{
								$Data[$f][$c] .='<a href="javascript:void(0);" title="Generar Orden de Trabajo" class="smallButton" style="margin: 5px;" onclick="Generar_Orden_de_Trabajo(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/color/plus.png" alt="" class="icon" /><span></span></a>';								
							}
						}
						
					
						
						$Data[$f][$c] .='<a href="javascript:void(0);" title="Editar Cotizaci&oacute;n" class="smallButton" style="margin: 5px;" onclick="Editar_Cotizacion(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
					
					}
					
					if(number_format($row['monto_abonado'],2,'.','') < number_format($row['monto_total'],2,'.',''))
					$Data[$f][$c] .= '<a href="javascript:void(0);" title="Abonar Cotizaci&oacute;n" class="smallButton" style="margin: 5px;" onclick="Agregar_Abono('.$f.');"><img src="public/images/icons/dark/cart.png" alt="" class="icon" /><span></span></a>';					
					
					$Data[$f][$c].='<a href="javascript:void(0);" title="Detalle de Cotizaci&oacute;n" class="smallButton" style="margin: 5px;" onclick="Ver_Detalle_Cotizacion('.$f.')"><i class="fa fa-file-pdf-o"></i><span></span></a>';
					if(number_format($row['monto_abonado'],2,'.','') > 0)
					$Data[$f][$c] .='<a href="javascript:void(0);" title="Imprimir &Uacute;timo Recibo de Abono" class="smallButton" style="margin: 5px;" onclick="Imprimir_Ultimo_Recibo_Abono('.$f.')"><i class="fa fa-file-text-o"></i><span></span></a>';
					
					$Data[$f][$c] .='<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar esta Cotizaci&oacute;n?\')){Eliminar_Cotizacion('.$f.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
				}
				
				$Data[$f][$c] .='<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_cotizaciones'])).'" />';
				
				//$ResultSet[$c-1]["opciones"] = $html;



				
				$f = $f + 1;
			}

		}		

		$ResultSet['draw'] = $Draw;
		$ResultSet['data'] = $Data;
		$ResultSet['recordsFiltered'] = $resFilterLength;
		$ResultSet['recordsTotal'] = $recordsTotal;		
		echo json_encode($ResultSet);
		
	}

	if($_GET['action'] == 'Listar_Cotizaciones_Server')
	{
		session_start();
		$ResultSet = array();
		
		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,co.id_cotizaciones,co.id_estatus, descripcion_estatus,monto_subtotal,monto_itbm,monto_total, IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = co.id_cotizaciones)) AS monto_abonado 
			FROM cotizaciones co INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus)
			ORDER BY id_cotizaciones DESC");
			
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
					
					$Id_Cliente = $row['id_cliente'];
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


				$ResultSet[$c-1]["No"] = $c;
				$ResultSet[$c-1]["id_cotizaciones"] = utf8_encode($row['id_cotizaciones']).'<input type="hidden" id="hidIdCotizacion'.$c.'" name="hidIdCotizacion[]" value="'.utf8_encode($row['id_cotizaciones']).'" />';
				$ResultSet[$c-1]["nombre_cliente"] = utf8_encode($NombreCliente).'<input type="hidden" id="hidNombreCliente'.$c.'" name="hidNombreCliente[]" value="'.utf8_encode($NombreCliente).'" />';
				$ResultSet[$c-1]["estatus_cotizacion"] = '<i class="fa fa-circle" style="color:'.((($row['id_estatus'])=="3")?'green;':((($row['id_estatus'])=="2")?'yellow;':((($row['id_estatus'])=="1")?'red;':''))).'"></i> '.utf8_encode($row['descripcion_estatus']).'<input type="hidden" id="hidEstatusCotizacion'.$c.'" name="hidEstatusCotizacion[]" value="'.utf8_encode($row['descripcion_estatus']).'" />';
				$ResultSet[$c-1]["monto_subtotal"] = 'B/.&nbsp;'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'<input type="hidden" id="hidMontoSubTotal'.$c.'" name="hidMontoSubTotal[]" value="'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'" />';
				$ResultSet[$c-1]["monto_itbm"] = 'B/.&nbsp;'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'<input type="hidden" id="hidMontoITBM'.$c.'" name="hidMontoITBM[]" value="'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'" />';
				$ResultSet[$c-1]["monto_total"] = 'B/.&nbsp;'.utf8_encode(number_format($row['monto_total'],2,'.','')).'<input type="hidden" id="hidMontoTotal'.$c.'" name="hidMontoTotal[]" value="'.utf8_encode(number_format($row['monto_total'],2,'.','')).'" />';
				$ResultSet[$c-1]["monto_abonado"] = 'B/.&nbsp;'.utf8_encode(number_format($row['monto_abonado'],2,'.','')).'<input type="hidden" id="hidMontoAbonado'.$c.'" name="hidMontoAbonado[]" value="'.utf8_encode(number_format($row['monto_abonado'],2,'.','')).'" />';
				
				$html = "";
				
				if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
				{
				
					if (($row['id_estatus'] == 3) or ($TrabajoImprenta == 0))
					{
						$html .='<a href="javascript:void(0);" title="Imprimir" class="smallButton" style="margin: 5px;" onclick="Imprimir_Detalle_Venta(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/color/blue-document-pdf-text.png" alt="" class="icon" /><span></span></a>';
					}
					else
					{
						if ((($TrabajoImprenta > 0) and ($ExisteTrabajoImprenta == 0)) or ($TrabajoImprenta > $ExisteTrabajoImprenta))
						{
							if ($row['monto_total'] >= 0)
							{
								if ((((($row['monto_abonado']/$row['monto_total']) > 0.50) or ($Credito == 1)) and ((base64_decode($_SESSION['id_tipo_usuario']) != 1) or (base64_decode($_SESSION['id_tipo_usuario']) != 2)))
								or ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2)))
								$html .='<a href="javascript:void(0);" title="Generar Orden de Trabajo" class="smallButton" style="margin: 5px;" onclick="Generar_Orden_de_Trabajo(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/color/plus.png" alt="" class="icon" /><span></span></a>';								
							}
							else
							{
								$html .='<a href="javascript:void(0);" title="Generar Orden de Trabajo" class="smallButton" style="margin: 5px;" onclick="Generar_Orden_de_Trabajo(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/color/plus.png" alt="" class="icon" /><span></span></a>';								
							}
						}
						
						if(number_format($row['monto_abonado'],2,'.','') < number_format($row['monto_total'],2,'.',''))
						$html .= '<a href="javascript:void(0);" title="Abonar Cotizaci&oacute;n" class="smallButton" style="margin: 5px;" onclick="Agregar_Abono('.$c.');"><img src="public/images/icons/dark/cart.png" alt="" class="icon" /><span></span></a>';
					
						
						$html .='<a href="javascript:void(0);" title="Editar Cotizaci&oacute;n" class="smallButton" style="margin: 5px;" onclick="Editar_Cotizacion(\''.utf8_encode(md5($row['id_cotizaciones'])).'\');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
					
					}
					$html .='<a href="javascript:void(0);" title="Detalle de Cotizaci&oacute;n" class="smallButton" style="margin: 5px;" onclick="Ver_Detalle_Cotizacion('.$c.')"><i class="fa fa-file-pdf-o"></i><span></span></a>';
					if(number_format($row['monto_abonado'],2,'.','') > 0)
					$html .='<a href="javascript:void(0);" title="Imprimir &Uacute;timo Recibo de Abono" class="smallButton" style="margin: 5px;" onclick="Imprimir_Ultimo_Recibo_Abono('.$c.')"><i class="fa fa-file-text-o"></i><span></span></a>';
					
					$html .='<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar esta Cotizaci&oacute;n?\')){Eliminar_Cotizacion('.$c.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
				}
				
				$html .='<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_cotizaciones'])).'" />';
				
				$ResultSet[$c-1]["opciones"] = $html;



				
				$c = $c + 1;
			}

		}		
		echo json_encode($ResultSet);
	}
	
	if($_GET['action'] == 'Ver_Detalle_Cotizacion')
	{	
		$Id_Cotizacion	= strip_tags(utf8_decode($_POST['id']));		

		try
		{		
			$stmt = $db->prepare("SELECT id_cotizaciones,id_cliente,id_tipo_cliente,ot.id_orden_trabajo,c.fecha_creado,monto_total,IF(evento LIKE 'Cotización Agregado',CONCAT(u.nombre,' ',u.apellido),'') AS usuario_realizo,
			IF(evento LIKE 'Cotización Eliminado',CONCAT(u.nombre,' ',u.apellido),'') AS usuario_edito,
			DATEDIFF(MAX(NOW()), MIN(c.fecha_creado)) AS dia_lleva_cotizado,
			DATEDIFF(MAX(NOW()), MIN(ot.fecha_creado)) AS dia_lleva_orden_creado,
			DATEDIFF(MAX(NOW()), MIN(ot.fecha_entrega)) AS dia_lleva_orden_finalizado
			FROM cotizaciones c
			LEFT JOIN orden_trabajo ot ON (ot.id_cotizacion=c.id_cotizaciones)
			INNER JOIN historial_cotizacion hc ON (hc.id_cotizacion = c.id_cotizaciones)
			INNER JOIN user_log ul ON (ul.id_log = hc.id_log)
			INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
			WHERE MD5(id_cotizaciones) = ?  AND (evento LIKE 'Cotización Agregado'
			OR evento LIKE 'Cotización Modificado')");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
			//print_r($stmt->errorInfo());
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		//echo $nfilas;
		
		//print_r($stmt->errorInfo());
		$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable" id="Cotizacion"><thead><tr>';			

		$html .= '<th style="width:2%"></th>
				<th>N&uacute;mero de Cotizaci&oacute;n</th>
				<th>Fecha de Cotizaci&oacute;n</th>
				<th>Usuario que Realiz&oacute;</th>
				<th>D&iacute;as Cotizado</th>
				<th>Usuario que Edit&oacute;</th>
				<th>Usuario que Creo la Orden</th>
				<th>D&iacute;as Orden Asignado</th>
				<th>D&iacute;as Entregado</th>
				';	

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
					
					$stmt = $db->prepare("SELECT CONCAT(u.nombre,' ',u.apellido) AS usuario_creo_orden FROM orden_trabajo ot INNER JOIN historial_orden_trabajo hot ON (ot.id_orden_trabajo = hot.id_orden_trabajo)
					INNER JOIN user_log ul ON (ul.id_log = hot.id_log)
					INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
					WHERE ot.id_orden_trabajo = ? AND tipo = 15");

					$p = 1;
					$stmt->bindParam($p,$row['id_orden_trabajo'],PDO::PARAM_STR,255);
					$stmt->execute();
					//print_r($stmt->errorInfo());
					$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$nfilas1 = $stmt->rowCount();			
					
					$stmt->closeCursor();			
			
				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}				
				
			
				$NC = $row['id_cotizaciones'];
				$OT = $row['id_orden_trabajo'];				
				
				$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
						<td  align="center">'.$c.'</td>
						<td  align="center">'.$row['id_cotizaciones'].'</td>
						<td  align="center">'.date('d-m-Y',strtotime($row['fecha_creado'])).'</td>
						<td  align="center">'.utf8_encode($row['usuario_realizo']).'</td>
						<td  align="center">'.$row['dia_lleva_cotizado'].'</td>
						<td  align="center">'.utf8_encode($row['usuario_edito']).'</td>
						<td  align="center">'.utf8_encode($rows1[0]['usuario_creo_orden']).'</td>
						<td  align="center">'.$row['dia_lleva_orden_creado'].'</td>
						<td  align="center">'.(($row['dia_lleva_orden_finalizado'] >= "0")?$row['dia_lleva_orden_finalizado']:"").'</td>
					</tr>';
				
				$Saldo = $row['monto_total'];
				
				$c = $c + 1;
			}

		}

		try
		{		
			$stmt = $db->prepare("SELECT a.id_abono,fecha_abonado,monto_abonado,a.id_tipo_pago,descripcion_tipo_pago,CONCAT(u.nombre,' ',u.apellido) AS usuario_recibio_abono FROM abono a
			INNER JOIN tipo_pago tp ON (tp.id_tipo_pago = a.id_tipo_pago)
			INNER JOIN historial_abono ha ON (ha.id_abono = a.id_abono)
			INNER JOIN user_log ul ON (ul.id_log = ha.id_log)
			INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
			WHERE MD5(id_cotizacion) = ?
			AND evento != 'Abono de Cotización Actualizado' AND evento != 'Abono Eliminado'");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas2 = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}		
		
		$html .= '
              </tbody></table>
			  <table cellpadding="0" cellspacing="0" border="0" class="display dTable" id="Cotizacion">
				<thead>
					<tr>
						<th colspan="4">Listado de Abonos</th>
					</tr>
					<tr>
						<th>N&deg; Transacci&oacute;n
						<input type="hidden" id="num_campos_abono" name="num_campos_abono" value="'.$nfilas.'" />
						<input type="hidden" id="cant_campos_abono" name="cant_campos_abono" value="'.$nfilas.'" /></th>
						<th>Fecha</th>
						<th>Monto</th>
						<th>Tipo de Pago</th>
						<th>Saldo</th>
						<th>Recibi&oacute; Abono</th>
						<th>Opciones</th>
					</tr>
				</thead>
				<tbody>';
				
		if ($nfilas2 > 0)
		{
			$c = 1;
			foreach ($rows2 as $row2)
			{	$Saldo = $Saldo - $row2['monto_abonado'];	
				$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">

						<td  align="center">'.utf8_encode($row2['id_abono']).'</td>
						<td  align="center">'.date('d-m-Y',strtotime($row2['fecha_abonado'])).'</td>
						<td  align="center">'.number_format($row2['monto_abonado'],2,'.','').'</td>
						<td  align="center">'.utf8_encode($row2['descripcion_tipo_pago']).'</td>
						<td  align="center">'.number_format($Saldo,2,'.','').'</td>
						<td  align="center">'.utf8_encode($row2['usuario_recibio_abono']).'</td>
						<td  align="center">';
						
						$html .='<a href="javascript:void(0);" title="Editar Abono" class="smallButton" style="margin: 5px;" onclick="Editar_Abono('.$c.',\''.utf8_encode($Id_Cotizacion).'\');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
						$html .='<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Abono?\')){Eliminar_Abono('.$c.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
						$html .='<a href="javascript:void(0);" title="Imprimir Recibo de Abono" class="smallButton" style="margin: 5px;" onclick="Imprimir_Recibo_Abono('.$c.',\''.utf8_encode($Id_Cotizacion).'\')"><i class="fa fa-file-text-o"></i><span></span></a>';

						$html .='<input type="hidden" id="hdnIdAbonoCampos_'.$c.'" name="hdnIdAbonoCampos[]" value="'.utf8_encode(md5($row2['id_abono'])).'" />';		
				$html .='</td>
					</tr>';
				
				$c = $c + 1;
			}			
		}
		
		$html .= '</tbody>
			</table>';
			
		try
		{		
			if ($row['id_tipo_cliente'] == 1)
			$stmt = $db->prepare("SELECT telefono,celular,email FROM cliente_persona WHERE id_cliente = ?");
			else if ($row['id_tipo_cliente'] == 2)
			$stmt = $db->prepare("SELECT telefono,celular,email FROM cliente_empresa WHERE id_cliente = ?	
");				

			$p = 1;
			$stmt->bindParam($p,$row['id_cliente'],PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas3 = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}		

		
			
		$html .= '
              </tbody></table>
			  <table cellpadding="0" cellspacing="0" border="0" class="display dTable" id="Cotizacion">
				<thead>
					<tr>
						<th colspan="3">Datos del Cliente</th>
					</tr>
					<tr>
						<th>Tel&eacute;fono</th>
						<th>Celular</th>
						<th>E-Mail</th>
					</tr>
				</thead>
				<tbody>';
				
		if ($nfilas3 > 0)
		{
			$c = 1;
			foreach ($rows3 as $row3)
			{		
				$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
						<td  align="center">'.utf8_encode($row3['telefono']).'</td>
						<td  align="center">'.utf8_encode($row3['celular']).'</td>
						<td  align="center">'.utf8_encode($row3['email']).'</td>
					</tr>';
				
				$c = $c + 1;
			}			
		}				
				
				
		$html .= '</tbody>
			</table>';			  
		echo $html;		
	}	
	
	if($_GET['action'] == 'Cantidad_Cotizaciones')
	{
		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,co.id_estatus,descripcion_cotizacion, descripcion_estatus
			FROM cotizaciones co INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus)
			ORDER BY id_cotizaciones DESC");
			
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
	
	if($_GET['action'] == 'Ultimas_Cotizaciones')
	{
		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,co.id_estatus,descripcion_cotizacion, descripcion_estatus
			FROM cotizaciones co INNER JOIN tipo_estatus_cotizacion te ON (te.id_estatus = co.id_estatus)
			ORDER BY id_cotizaciones DESC LIMIT 0,10");
			
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
		
				if ($row['id_tipo_cliente'] == 1)
				{
					try
					{		
						$Id_Cliente = $row['id_cliente'];
				
						$stmt = $db->prepare("SELECT CONCAT(nombre,' ',apellido) AS Nombre_Cliente FROM cliente_persona WHERE id_cliente = ?");			
		
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
				else if ($row['id_tipo_cliente'] == 2)
				{
		
					try
					{		
						$Id_Cliente = $row['id_cliente'];
				
						$stmt = $db->prepare("SELECT nombre_empresa AS Nombre_Cliente FROM cliente_empresa WHERE id_cliente = ?");				

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
				
				
				
				$html .= '<tr>
                                <td><a href="#" title="">'.utf8_encode($row['id_cotizaciones']).'</a></td>
								<td class="taskPr"><a href="#" title="">'.utf8_encode($rows1[0]['Nombre_Cliente']).'</a></td>
								<td><a href="#" title="">'.utf8_encode($rows['descripcion_cotizacion']).'</a></td>
                                <td><span class="green f11">'.utf8_encode($row['descripcion_estatus']).'</span></td>
                                <td class="actBtns"><a href="listar_cotizacion.html" title="Update" class="tipS"><img src="public/images/icons/edit.png" alt="" /></a><a href="listar_cotizacion.html" title="Remove" class="tipS"><img src="public/images/icons/remove.png" alt="" /></a></td>
                            </tr>';			
			
			
			
			
			}
		}
		
		echo $html;
	}	
		
	if($_GET['action'] == 'Buscar_Cotizacion')
	{
		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones, descripcion_cotizacion, descripcion_estatus,monto_subtotal,monto_itbm,monto_total 
			FROM cotizaciones co INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus)  
			WHERE id_cliente = ? ORDER BY id_cotizaciones DESC");
	
			$p = 1;
			$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_INT);
	
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
			
		$html .= '<table cellpadding="0" cellspacing="0" border="0" class="display dTable"><thead><tr>';			

		$html .= '<th style="width:2%"></th>
				<th style="width:9%">N&uacute;mero de Cotizaci&oacute;n</th>
				<th style="width:23%">Nombre del Cliente</th>
				<th style="width:20%">Estatus de Cotizaci&oacute;n
				<input type="hidden" id="num_campos" name="num_campos" value="'.$nfilas.'" />
				<input type="hidden" id="cant_campos" name="cant_campos" value="'.$nfilas.'" /></th>
				<th style="width:12%">Monto Sub-Total</th>
				<th style="width:12%">MontoITBM</th>
				<th style="width:12%">Monto Total</th>
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
				
				
				$html .='<tr  class="gradeA" id="rowDetalle_'.$c.'">
						<td  align="center">'.$c.'</td>
						<td align="center" >'.utf8_encode($row['id_cotizaciones']).'<input type="hidden" id="hidIdCotizacion'.$c.'" name="hidIdCotizacion[]" value="'.utf8_encode($row['id_cotizaciones']).'" /></td>
						<td>'.utf8_encode($NombreCliente).'</td>
						<td>'.utf8_encode($row['descripcion_estatus']).'<input type="hidden" id="hidEstatusCotizacion'.$c.'" name="hidEstatusCotizacion[]" value="'.utf8_encode($row['descripcion_estatus']).'" /></td>
						<td>B/.&nbsp;'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'<input type="hidden" id="hidMontoSubTotal'.$c.'" name="hidMontoSubTotal[]" value="'.utf8_encode(number_format($row['monto_subtotal'],2,'.','')).'" /></td>						
						<td>B/.&nbsp;'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'<input type="hidden" id="hidMontoITBM'.$c.'" name="hidMontoITBM[]" value="'.utf8_encode(number_format($row['monto_itbm'],2,'.','')).'" /></td>
						<td>B/.&nbsp;'.utf8_encode(number_format($row['monto_total'],2,'.','')).'<input type="hidden" id="hidMontoTotal'.$c.'" name="hidMontoTotal[]" value="'.utf8_encode(number_format($row['monto_total'],2,'.','')).'" /></td>
						<td><a href="javascript:void(0);" title="Generar Orden de Trabajo" class="smallButton" style="margin: 5px;" onclick="Generar_Orden_de_Trabajo('.$c.');"><img src="public/images/icons/light/pencil.png" alt="" class="icon" /><span></span></a>';
						
					if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
					$html .='<a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar esta Cotización?\')){Eliminar_Cotizacion('.$c.');}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>';
					
					$html .='<input type="hidden" id="hdnIdCampos_'.$c.'" name="hdnIdCampos[]" value="'.utf8_encode(md5($row['id_cotizaciones'])).'" /></td>					
					</tr>';
					
				$c = $c + 1;
			}

		}
		  
		$html .= '
              </tbody></table>';	
		echo $html;
		
	}	

	if($_GET['action'] == 'Listar_Cotizaciones_Anteriores')
	{
		$html = "";
		
		$Id_Cliente	= strip_tags(utf8_decode($_POST['IdCliente']));
		$Id_Tipo_Cliente	= strip_tags(utf8_decode($_POST['IdTipoCliente']));		
		
		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,descripcion_cotizacion,descripcion_estatus,monto_subtotal,monto_itbm,monto_total 
			FROM cotizaciones co INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus) WHERE id_cliente = ? AND id_tipo_cliente = ?
			ORDER BY id_cotizaciones DESC");
			
			$c = 1;
			$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Tipo_Cliente,PDO::PARAM_INT);
			
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
				$html .= '<option value="'.md5($row['id_cotizaciones']).'">Cotizaci&oacute;n N&deg; '.$row['id_cotizaciones'].' ('.utf8_encode($row['descripcion_cotizacion']).') </option>';
			}
		}
		
		echo $html;		
	}
	
	if($_GET['action'] == 'Tiene_Cotizaciones_Anteriores')
	{
		$response = "false";
		
		$Id_Cliente	= strip_tags(utf8_decode($_POST['IdCliente']));
		$Id_Tipo_Cliente	= strip_tags(utf8_decode($_POST['IdTipoCliente']));
		
		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,descripcion_estatus,monto_subtotal,monto_itbm,monto_total 
			FROM cotizaciones co INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus) WHERE id_cliente = ? AND id_tipo_cliente = ?
			ORDER BY id_cotizaciones DESC");
			
			$c = 1;
			$stmt->bindParam($c,$Id_Cliente,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Tipo_Cliente,PDO::PARAM_INT);			
			
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
			$response = "true";
		}
		
		echo $response;		
	}

	if($_GET['action'] == 'Buscar_Descripcion_Cotizacion')
	{
		$html = "";
		$Id_Cotizacion	= strip_tags(utf8_decode(strtolower($_POST['idCotizacion'])));
		
		try
		{
			$stmt = $db->prepare("SELECT id_cotizaciones, descripcion_cotizacion FROM cotizaciones WHERE MD5(id_cotizaciones) = ?");
			
			$p = 1;		
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);	

			$stmt->execute();
			//print_r($stmt->errorInfo());
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();			
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}		
		
		$html = $rows[0]['descripcion_cotizacion'];
		
		echo $html;
	
	}

	
	if($_GET['action'] == 'Buscar_Cotizaciones')
	{
		// include('detector_cel.php');
		$html = "";
		
		$Id_Cotizacion	= strip_tags(utf8_decode(strtolower($_POST['idCotizacion'])));
		
		try
		{		
			$stmt = $db->prepare("SELECT id_cotizacion, p.id_producto AS Id_Trabajo_Producto, '0' AS tipo_trabajo_producto, cantidad,nombre_producto AS Descripcion, cp.precio_venta,
			descripcion_empaque AS tipo_empaque, '' AS id_tipo_papel, '' AS id_tipo_material, '' AS id_resmatamano, '' AS id_tamano,
			'' AS numeracion_inicial,'' AS numeracion_final,'' AS otro_ancho,'' AS otro_largo,'' AS cant_copia,'' AS id_color_papel,
			'' AS id_color_papel1,'' AS id_color_papel2,'' AS id_color_papel3,'' AS id_color_tinta,'' AS id_forro,'' AS tiempo,'' AS arte,'' AS placa,
			'' AS id_tipo_tiempo,'' AS id_categoria,'' AS exento_itbm,'' AS observacion,'' AS id_material,'' AS ancho,'' AS id_medida_ancho,
			'' AS largo,'' AS id_medida_largo,'' AS area_total,'' AS id_forma_pago,'' AS id_calidad,'' AS precio_instalacion,'' AS precio_recorte,
			'' AS precio_arte,'' AS precio_rotulado,'' AS precio_basta,'' AS precio_ojetes,'' AS precio_bulcaniza,'' AS arte_ancho,'' AS arte_ancho_medida,
			'' AS arte_largo,'' AS arte_largo_medida,'' AS arte_area,'' AS ajustar_tamano,'' AS recorte,'' AS plastificado,'' AS caminado,'' AS realce,'' AS doblado,'' AS repujado,'' AS engrapado,'' AS UV, '' AS cantidad_pliego											
			FROM cotizacion_producto cp
			INNER JOIN producto p ON (cp.id_producto = p.id_producto)
			INNER JOIN tipo_empaque te ON (te.id_tipo_empaque = p.id_tipo_empaque)
			WHERE (id_imprenta IS NULL OR id_imprenta = 0) AND (id_banner IS NULL OR id_banner = 0) AND (id_impresion IS NULL OR id_impresion = 0)  AND MD5(id_cotizacion) = ?
			UNION
			SELECT id_cotizacion, i.id_imprenta AS Id_Trabajo_Producto, '1' AS tipo_trabajo_producto, cantidad, IF(descripcion_imprenta IS NOT NULL,descripcion_imprenta,'Trabajo de Imprenta') AS Descripcion, cp.precio_venta,
			'Unidad' AS tipo_empaque,id_tipo_papel,id_tipo_material,id_resmatamano,id_tamano,numeracion_inicial,numeracion_final,otro_ancho,otro_largo,
			cant_copia,id_color_papel,id_color_papel1,id_color_papel2,id_color_papel3,id_color_tinta,id_forro,tiempo,arte,placa,
			id_tipo_tiempo,id_categoria,exento_itbm,observacion,'' AS id_material,'' AS ancho,'' AS id_medida_ancho,
			'' AS largo,'' AS id_medida_largo,'' AS area_total,'' AS id_forma_pago,'' AS id_calidad,'' AS precio_instalacion,'' AS precio_recorte,
			'' AS precio_arte,'' AS precio_rotulado,'' AS precio_basta,'' AS precio_ojetes,'' AS precio_bulcaniza,'' AS arte_ancho,'' AS arte_ancho_medida,
			'' AS arte_largo,'' AS arte_largo_medida,'' AS arte_area,'' AS ajustar_tamano,'' AS recorte,'' AS plastificado,'' AS caminado,'' AS realce,'' AS doblado,'' AS repujado,'' AS engrapado,'' AS UV, '' AS cantidad_pliego	
			FROM cotizacion_producto cp
			INNER JOIN imprenta i ON (cp.id_imprenta = i.id_imprenta)
			WHERE id_producto IS NULL OR id_producto = 0 AND MD5(id_cotizacion) = ?
			UNION
			SELECT id_cotizacion, b.id_banner AS Id_Trabajo_Producto, '2' AS tipo_trabajo_producto, cantidad, IF(descripcion_banner IS NOT NULL,descripcion_banner,'Trabajo de Banner') AS Descripcion, cp.precio_venta,
			'Unidad' AS tipo_empaque, '' AS id_tipo_papel, '' AS id_tipo_material, '' AS id_resmatamano, '' AS id_tamano,
			'' AS numeracion_inicial,'' AS numeracion_final,'' AS otro_ancho,'' AS otro_largo,'' AS cant_copia,'' AS id_color_papel,
			'' AS id_color_papel1,'' AS id_color_papel2,'' AS id_color_papel3,'' AS id_color_tinta,'' AS id_forro,'' AS tiempo,'' AS arte,'' AS placa,
			'' AS id_tipo_tiempo,'' AS id_categoria,exento_itbm,observacion,id_material,ancho,id_medida_ancho,largo,id_medida_largo,area_total,
			id_forma_pago,id_calidad,precio_instalacion,precio_recorte,precio_arte,precio_rotulado,precio_basta,precio_ojetes,
			precio_bulcaniza,'' AS arte_ancho,'' AS arte_ancho_medida,'' AS arte_largo,'' AS arte_largo_medida,'' AS arte_area,'' AS ajustar_tamano,'' AS recorte,
			'' AS plastificado,'' AS caminado,'' AS realce,'' AS doblado,'' AS repujado,'' AS engrapado,'' AS UV, '' AS cantidad_pliego	
			FROM cotizacion_producto cp
			INNER JOIN banner b ON (cp.id_banner = b.id_banner)
			WHERE id_producto IS NULL OR id_producto = 0 AND MD5(id_cotizacion) = ?
			UNION
			SELECT id_cotizacion, im.id_impresion AS Id_Trabajo_Producto, '3' AS tipo_trabajo_producto, cantidad, IF(descripcion_impresion IS NOT NULL,descripcion_impresion,'Trabajo de Impresión') AS Descripcion, cp.precio_venta,
			'Unidad' AS tipo_empaque, '' AS id_tipo_papel, '' AS id_tipo_material, '' AS id_resmatamano, id_tamano,
			'' AS numeracion_inicial,'' AS numeracion_final,otro_ancho,otro_largo,'' AS cant_copia,'' AS id_color_papel,
			'' AS id_color_papel1,'' AS id_color_papel2,'' AS id_color_papel3, id_color_tinta,'' AS id_forro,'' AS tiempo,'' AS arte,'' AS placa,
			'' AS id_tipo_tiempo,id_categoria,exento_itbm,observacion, id_material,'' AS ancho,'' AS id_medida_ancho,'' AS largo,'' AS id_medida_largo,'' AS area_total,
			'' AS id_forma_pago,'' AS id_calidad,'' AS precio_instalacion,'' AS precio_recorte,precio_arte,'' AS precio_rotulado,'' AS precio_basta,'' AS precio_ojetes,
			'' AS precio_bulcaniza,arte_ancho,arte_ancho_medida,arte_largo,arte_largo_medida,arte_area,ajustar_tamano,recorte,plastificado,caminado,realce,doblado,repujado,engrapado,UV,cantidad_pliego	
			FROM cotizacion_producto cp
			INNER JOIN impresion im ON (cp.id_impresion = im.id_impresion)
			WHERE id_producto IS NULL OR id_producto = 0 AND MD5(id_cotizacion) = ?");
			
			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);			
			$p++;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);	
			
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
			$f = 1;
			foreach ($rows as $row)
			{	
				if ($row['tipo_trabajo_producto'] == 0)
				{
					$html .= '<tr id="rowDetalle_'.$f.'"  valign="center"  >
								<td  align="center">'.$f.'</td>
								<td><span class="req">*</span><input type="text" id="txtCantidad'.$f.'" name="txtCantidad[]" value="'.$row['cantidad'].'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad'.$f.'" name="hidCantidad[]" value="'.$row['cantidad'].'"  /></td>
								<td><input type="text" id="txtTipoEmpaque'.$f.'" name="txtTipoEmpaque[]" value="'.$row['tipo_empaque'].'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque'.$f.'" name="hidTipoEmpaque[]" value=""  /></td>
								<td><span class="req">*</span>';
					/*if ($mobile_browser>0)
					{
						$html .= '<div data-role="page" id="mainPage"><p><input type="text" id="searchField'.$f.'" placeholder="Producto" style="width:85%;" class="validate[required]" value="'.$row['Descripcion'].'">
						<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';
					}
					else
					{*/
						$html .= '<input type="text" id="txtProducto'.$f.'" name="txtProducto[]" style="width:85%;" class="validate[required]" value="'.utf8_encode($row['Descripcion']).'"/>';
					//}
					
					
					$html .= '<input type="hidden" id="hidIdProducto'.$f.'" name="hidIdProducto[]" value="'.$row['Id_Trabajo_Producto'].'"  /><input type="hidden" id="hidDescProducto'.$f.'" name="hidDescProducto[]" value="'.utf8_encode($row['Descripcion']).'"  />
					<input type="hidden" id="hidIdImprenta'.$f.'" name="hidIdImprenta[]" value=""  />
					<input type="hidden" id="hidIdBanner'.$f.'" name="hidIdBanner[]" value=""  />
					<input type="hidden" id="hidIdImpresion'.$f.'" name="hidIdImpresion[]" value=""  /></td>
					<td><input type="text" id="txtPrecio'.$f.'" name="txtPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio'.$f.'" name="hidPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'"  /></td>
					<td><input type="text" id="txtTotal'.$f.'" name="txtTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal'.$f.'" name="hidTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'"  /></td>
					<td><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo('.$f.')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>
					
					<input type="hidden" id="hdnDescripcionImprenta'.$f.'" name="hdnDescripcionImprenta[]" value="" />
					<input type="hidden" id="hdnPapelTipo'.$f.'" name="hdnPapelTipo[]" value="" />
					<input type="hidden" id="hdnMaterialPapelTipo'.$f.'" name="hdnMaterialPapelTipo[]" value="" />
					<input type="hidden" id="hdnResmaTamano'.$f.'" name="hdnResmaTamano[]" value="" />
					<input type="hidden" id="hdnTamano'.$f.'" name="hdnTamano[]" value="" />
					<input type="hidden" id="hdnCantidadCopia'.$f.'" name="hdnCantidadCopia[]" value="" />
					<input type="hidden" id="hdnColorTinta'.$f.'" name="hdnColorTinta[]" value="" />
					<input type="hidden" id="hdnOtroTamanoAncho'.$f.'" name="hdnOtroTamanoAncho[]" value="" />
					<input type="hidden" id="hdnOtroTamanoLargo'.$f.'" name="hdnOtroTamanoLargo[]" value="" />
					<input type="hidden" id="hdnNumeracionInicio'.$f.'" name="hdnNumeracionInicio[]" value="" />
					<input type="hidden" id="hdnNumeracionFinal'.$f.'" name="hdnNumeracionFinal[]" value="" />';
					$c = 0;
			
					while ($c <= 3)
					{
						if ($c == 0)
						$html .= '<input type="hidden" id="hdnColorPapel'.$f.'" name="hdnColorPapel[]" value="" />';					
						else
						$html .= '<input type="hidden" id="hdnColorPapel'.$c.$f.'" name="hdnColorPapel'.$c.'[]" value="" />';
				
						$c = $c + 1;
					}
					
					$html .= '<input type="hidden" id="hdnTipoForro'.$f.'" name="hdnTipoForro[]" value="" />
					<input type="hidden" id="hdnTiempo'.$f.'" name="hdnTiempo[]" value="" />
					<input type="hidden" id="hdnTipoTiempo'.$f.'" name="hdnTipoTiempo[]" value="" />
					<input type="hidden" id="hdnTipoCategoria'.$f.'" name="hdnTipoCategoria[]" value="" />

					<input type="hidden" id="hdnSinNumeracion'.$f.'" name="hdnSinNumeracion[]" value="" />
					<input type="hidden" id="hdnArte'.$f.'" name="hdnArte[]" value="" />
					<input type="hidden" id="hdnPlaca'.$f.'" name="hdnPlaca[]" value="" />
					
					<input type="hidden" id="hdnDescripcionBanner'.$f.'" name="hdnDescripcionBanner[]" value="" />
					<input type="hidden" id="hdnMaterialBanner'.$f.'" name="hdnMaterialBanner[]" value="" />
					<input type="hidden" id="hdnAncho'.$f.'" name="hdnAncho[]" value="" />
					<input type="hidden" id="hdnAnchoMedida'.$f.'" name="hdnAnchoMedida[]" value="" />
					<input type="hidden" id="hdnLargo'.$f.'" name="hdnLargo[]" value="" />
					<input type="hidden" id="hdnLargoMedida'.$f.'" name="hdnLargoMedida[]" value="" />
					<input type="hidden" id="hdnAreaTotal'.$f.'" name="hdnAreaTotal[]" value="" />
					<input type="hidden" id="hdnFormaPago'.$f.'" name="hdnFormaPago[]" value="" />
					<input type="hidden" id="hdnCalidadBanner'.$f.'" name="hdnCalidadBanner[]" value="" />
					<input type="hidden" id="hdnPrecioInstalacion'.$f.'" name="hdnPrecioInstalacion[]" value="" />
					<input type="hidden" id="hdnPrecioRecorte'.$f.'" name="hdnPrecioRecorte[]" value="" />	
					<input type="hidden" id="hdnPrecioArte'.$f.'" name="hdnPrecioArte[]" value="" />
					<input type="hidden" id="hdnPrecioRotulado'.$f.'" name="hdnPrecioRotulado[]" value="" />
					<input type="hidden" id="hdnPrecioBasta'.$f.'" name="hdnPrecioBasta[]" value="" />
					<input type="hidden" id="hdnPrecioOjete'.$f.'" name="hdnPrecioOjete[]" value="" />
					<input type="hidden" id="hdnPrecioBulcaniza'.$f.'" name="hdnPrecioBulcaniza[]" value=""  />

					
					<input type="hidden" id="hdnDescripcionImpresion'.$f.'" name="hdnDescripcionImpresion[]" value="" />
					<input type="hidden" id="hdnMaterialImpresion'.$f.'" name="hdnMaterialImpresion[]" value="" />
					<input type="hidden" id="hdnRecorte'.$f.'" name="hdnRecorte[]" value="" />
					<input type="hidden" id="hdnPlastificado'.$f.'" name="hdnPlastificado[]" value="" />
					<input type="hidden" id="hdnCaminado'.$f.'" name="hdnCaminado[]" value="" />
					<input type="hidden" id="hdnRealce'.$f.'" name="hdnRealce[]" value="" />					
					<input type="hidden" id="hdnDoblado'.$f.'" name="hdnDoblado[]" value="" />
					<input type="hidden" id="hdnRepujado'.$f.'" name="hdnRepujado[]" value="" />
					<input type="hidden" id="hdnEngrapado'.$f.'" name="hdnEngrapado[]" value="" />
					<input type="hidden" id="hdnCantPliego'.$f.'" name="hdnCantPliego[]" value="" />
					<input type="hidden" id="hdnAjustarTamano'.$f.'" name="hdnAjustarTamano[]" value="" />					
					<input type="hidden" id="hdnUV'.$f.'" name="hdnUV[]" value="" />
					
					<input type="hidden" id="hdnExentoITBM'.$f.'" name="hdnExentoITBM[]" value=""  />
					<input type="hidden" id="hdnNotaCotizacion'.$f.'" name="hdnNotaCotizacion[]" value=""  />					
					
					<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.$f.'" /></td>
					</tr>';
				}
				else if ($row['tipo_trabajo_producto'] == 1)
				{
					$html .= '<tr id="rowDetalle_'.$f.'"  valign="center"  >
								<td  align="center"  width="2%">'.$f.'</td>
								<td colspan="6"><table width="100%">
								<tr>
								<td width="15%"><span class="req">*</span><input type="text" id="txtCantidad'.$f.'" name="txtCantidad[]" value="'.$row['cantidad'].'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad'.$f.'" name="hidCantidad[]" value="'.$row['cantidad'].'"  /></td>
								<td width="15%"><input type="text" id="txtTipoEmpaque'.$f.'" name="txtTipoEmpaque[]" value="'.$row['tipo_empaque'].'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque'.$f.'" name="hidTipoEmpaque[]" value=""  /></td>
								<td width="32%"><span class="req">*</span>';
					/*if ($mobile_browser>0)
					{
						$html .= '<div data-role="page" id="mainPage"><p><input type="text" id="searchField'.$f.'" placeholder="Producto" style="width:85%;" class="validate[required]" value="'.$row['Descripcion'].'">
						<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';
					}
					else
					{*/
						$html .= '<input type="text" id="txtProducto'.$f.'" name="txtProducto[]" style="width:85%;" class="validate[required]" value="Trabajo de Imprenta"/>';
					//}
					
					
					$html .= '<input type="hidden" id="hidIdProducto'.$f.'" name="hidIdProducto[]" value="timp"  /><input type="hidden" id="hidDescProducto'.$f.'" name="hidDescProducto[]" value="Trabajo de Imprenta"  />
					<input type="hidden" id="hidIdImprenta'.$f.'" name="hidIdImprenta[]" value="'.md5($row['Id_Trabajo_Producto']).'"  />
					<input type="hidden" id="hidIdBanner'.$f.'" name="hidIdBanner[]" value=""  />
					<input type="hidden" id="hidIdImpresion'.$f.'" name="hidIdImpresion[]" value=""  /></td>
					<td width="15%"><input type="text" id="txtPrecio'.$f.'" name="txtPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio'.$f.'" name="hidPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'"  /></td>
					<td width="15%"><input type="text" id="txtTotal'.$f.'" name="txtTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal'.$f.'" name="hidTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'"  /></td>
					<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo('.$f.')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>
					
					<input type="hidden" id="hdnDescripcionImprenta'.$f.'" name="hdnDescripcionImprenta[]" value="'.utf8_encode($row['Descripcion']).'" />
					<input type="hidden" id="hdnPapelTipo'.$f.'" name="hdnPapelTipo[]" value="'.$row['id_tipo_papel'].'" />
					<input type="hidden" id="hdnMaterialPapelTipo'.$f.'" name="hdnMaterialPapelTipo[]" value="'.$row['id_tipo_material'].'" />
					<input type="hidden" id="hdnResmaTamano'.$f.'" name="hdnResmaTamano[]" value="'.$row['id_resmatamano'].'" />
					<input type="hidden" id="hdnTamano'.$f.'" name="hdnTamano[]" value="'.$row['id_tamano'].'" />
					<input type="hidden" id="hdnCantidadCopia'.$f.'" name="hdnCantidadCopia[]" value="'.$row['cant_copia'].'" />
					<input type="hidden" id="hdnColorTinta'.$f.'" name="hdnColorTinta[]" value="'.$row['id_color_tinta'].'" />
					<input type="hidden" id="hdnOtroTamanoAncho'.$f.'" name="hdnOtroTamanoAncho[]" value="'.$row['otro_ancho'].'" />
					<input type="hidden" id="hdnOtroTamanoLargo'.$f.'" name="hdnOtroTamanoLargo[]" value="'.$row['otro_largo'].'" />
					<input type="hidden" id="hdnNumeracionInicio'.$f.'" name="hdnNumeracionInicio[]" value="'.$row['numeracion_inicial'].'" />
					<input type="hidden" id="hdnNumeracionFinal'.$f.'" name="hdnNumeracionFinal[]" value="'.$row['numeracion_final'].'" />';
					$c = 0;
			
					while ($c <= 3)
					{
						if ($c == 0)
						$html .= '<input type="hidden" id="hdnColorPapel'.$f.'" name="hdnColorPapel[]" value="'.$row['id_color_papel'].'" />';					
						else
						$html .= '<input type="hidden" id="hdnColorPapel'.$c.$f.'" name="hdnColorPapel'.$c.'[]" value="'.$row['id_color_papel'.$c].'" />';
				
						$c = $c + 1;
					}
					
					$html .= '<input type="hidden" id="hdnTipoForro'.$f.'" name="hdnTipoForro[]" value="'.$row['id_forro'].'" />
					<input type="hidden" id="hdnTiempo'.$f.'" name="hdnTiempo[]" value="'.$row['tiempo'].'" />
					<input type="hidden" id="hdnTipoTiempo'.$f.'" name="hdnTipoTiempo[]" value="'.$row['id_tipo_tiempo'].'" />
					<input type="hidden" id="hdnTipoCategoria'.$f.'" name="hdnTipoCategoria[]" value="'.$row['id_categoria'].'" />';

					if (($row['numeracion_final'] > 0) and ($row['numeracion_inicial'] > 0))
					$html .= '<input type="hidden" id="hdnSinNumeracion'.$f.'" name="hdnSinNumeracion[]" value="0" />';
					else
					$html .= '<input type="hidden" id="hdnSinNumeracion'.$f.'" name="hdnSinNumeracion[]" value="1" />';
					
					$html .= '<input type="hidden" id="hdnArte'.$f.'" name="hdnArte[]" value="'.$row['arte'].'" />
					<input type="hidden" id="hdnPlaca'.$f.'" name="hdnPlaca[]" value="'.$row['placa'].'" />
					
					<input type="hidden" id="hdnDescripcionBanner'.$f.'" name="hdnDescripcionBanner[]" value="" />
					<input type="hidden" id="hdnMaterialBanner'.$f.'" name="hdnMaterialBanner[]" value="" />
					<input type="hidden" id="hdnAncho'.$f.'" name="hdnAncho[]" value="" />
					<input type="hidden" id="hdnAnchoMedida'.$f.'" name="hdnAnchoMedida[]" value="" />
					<input type="hidden" id="hdnLargo'.$f.'" name="hdnLargo[]" value="" />
					<input type="hidden" id="hdnLargoMedida'.$f.'" name="hdnLargoMedida[]" value="" />
					<input type="hidden" id="hdnAreaTotal'.$f.'" name="hdnAreaTotal[]" value="" />
					<input type="hidden" id="hdnFormaPago'.$f.'" name="hdnFormaPago[]" value="" />
					<input type="hidden" id="hdnCalidadBanner'.$f.'" name="hdnCalidadBanner[]" value="" />
					<input type="hidden" id="hdnPrecioInstalacion'.$f.'" name="hdnPrecioInstalacion[]" value="" />
					<input type="hidden" id="hdnPrecioRecorte'.$f.'" name="hdnPrecioRecorte[]" value="" />	
					<input type="hidden" id="hdnPrecioArte'.$f.'" name="hdnPrecioArte[]" value="" />
					<input type="hidden" id="hdnPrecioRotulado'.$f.'" name="hdnPrecioRotulado[]" value="" />
					<input type="hidden" id="hdnPrecioBasta'.$f.'" name="hdnPrecioBasta[]" value="" />
					<input type="hidden" id="hdnPrecioOjete'.$f.'" name="hdnPrecioOjete[]" value="" />
					<input type="hidden" id="hdnPrecioBulcaniza'.$f.'" name="hdnPrecioBulcaniza[]" value=""  />
					
					<input type="hidden" id="hdnDescripcionImpresion'.$f.'" name="hdnDescripcionImpresion[]" value="" />
					<input type="hidden" id="hdnMaterialImpresion'.$f.'" name="hdnMaterialImpresion[]" value="" />
					<input type="hidden" id="hdnRecorte'.$f.'" name="hdnRecorte[]" value="" />
					<input type="hidden" id="hdnPlastificado'.$f.'" name="hdnPlastificado[]" value="" />
					<input type="hidden" id="hdnCaminado'.$f.'" name="hdnCaminado[]" value="" />
					<input type="hidden" id="hdnRealce'.$f.'" name="hdnRealce[]" value="" />					
					<input type="hidden" id="hdnDoblado'.$f.'" name="hdnDoblado[]" value="" />
					<input type="hidden" id="hdnRepujado'.$f.'" name="hdnRepujado[]" value="" />
					<input type="hidden" id="hdnEngrapado'.$f.'" name="hdnEngrapado[]" value="" />
					<input type="hidden" id="hdnUV'.$f.'" name="hdnUV[]" value="" />
					<input type="hidden" id="hdnCantPliego'.$f.'" name="hdnCantPliego[]" value="" />
					<input type="hidden" id="hdnAjustarTamano'.$f.'" name="hdnAjustarTamano[]" value="" />
					
					<input type="hidden" id="hdnExentoITBM'.$f.'" name="hdnExentoITBM[]" value="'.$row['exento_itbm'].'"  />
					<input type="hidden" id="hdnNotaCotizacion'.$f.'" name="hdnNotaCotizacion[]" value="'.utf8_encode($row['observacion']).'"  />
					
					<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.$f.'" /></td>
					</tr>
					<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles('.$f.',\'timp\')" >Ver detalle</a></td></tr>
					</table></td>
					</tr>';
					
				}
				else if ($row['tipo_trabajo_producto'] == 2)
				{
					$html .= '<tr id="rowDetalle_'.$f.'"  valign="center"  >
								<td  align="center"  width="2%">'.$f.'</td>
								<td colspan="6"><table width="100%">
								<tr>
								<td width="15%"><span class="req">*</span><input type="text" id="txtCantidad'.$f.'" name="txtCantidad[]" value="'.$row['cantidad'].'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad'.$f.'" name="hidCantidad[]" value="'.$row['cantidad'].'"  /></td>
								<td width="15%"><input type="text" id="txtTipoEmpaque'.$f.'" name="txtTipoEmpaque[]" value="'.$row['tipo_empaque'].'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque'.$f.'" name="hidTipoEmpaque[]" value=""  /></td>
								<td width="32%"><span class="req">*</span>';
					/*if ($mobile_browser>0)
					{
						$html .= '<div data-role="page" id="mainPage"><p><input type="text" id="searchField'.$f.'" placeholder="Producto" style="width:85%;" class="validate[required]" value="'.$row['Descripcion'].'">
						<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';
					}
					else
					{*/
						$html .= '<input type="text" id="txtProducto'.$f.'" name="txtProducto[]" style="width:85%;" class="validate[required]" value="Trabajo de Banner"/>';
					//}
					
					
					$html .= '<input type="hidden" id="hidIdProducto'.$f.'" name="hidIdProducto[]" value="tbnr"  /><input type="hidden" id="hidDescProducto'.$f.'" name="hidDescProducto[]" value="Trabajo de Banner"  />
					<input type="hidden" id="hidIdImprenta'.$f.'" name="hidIdImprenta[]" value=""  />
					<input type="hidden" id="hidIdBanner'.$f.'" name="hidIdBanner[]" value="'.md5($row['Id_Trabajo_Producto']).'"  />
					<input type="hidden" id="hidIdImpresion'.$f.'" name="hidIdImpresion[]" value=""  /></td>
					<td width="15%"><input type="text" id="txtPrecio'.$f.'" name="txtPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio'.$f.'" name="hidPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'"  /></td>
					<td width="15%"><input type="text" id="txtTotal'.$f.'" name="txtTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal'.$f.'" name="hidTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'"  /></td>
					<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo('.$f.')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>
					
					<input type="hidden" id="hdnDescripcionImprenta'.$f.'" name="hdnDescripcionImprenta[]" value="" />
					<input type="hidden" id="hdnPapelTipo'.$f.'" name="hdnPapelTipo[]" value="" />
					<input type="hidden" id="hdnMaterialPapelTipo'.$f.'" name="hdnMaterialPapelTipo[]" value="" />
					<input type="hidden" id="hdnResmaTamano'.$f.'" name="hdnResmaTamano[]" value="" />
					<input type="hidden" id="hdnTamano'.$f.'" name="hdnTamano[]" value="" />
					<input type="hidden" id="hdnCantidadCopia'.$f.'" name="hdnCantidadCopia[]" value="" />
					<input type="hidden" id="hdnColorTinta'.$f.'" name="hdnColorTinta[]" value="" />
					<input type="hidden" id="hdnOtroTamanoAncho'.$f.'" name="hdnOtroTamanoAncho[]" value="" />
					<input type="hidden" id="hdnOtroTamanoLargo'.$f.'" name="hdnOtroTamanoLargo[]" value="" />
					<input type="hidden" id="hdnNumeracionInicio'.$f.'" name="hdnNumeracionInicio[]" value="" />
					<input type="hidden" id="hdnNumeracionFinal'.$f.'" name="hdnNumeracionFinal[]" value="" />';
					$c = 0;
			
					while ($c <= 3)
					{
						if ($c == 0)
						$html .= '<input type="hidden" id="hdnColorPapel'.$f.'" name="hdnColorPapel[]" value="" />';					
						else
						$html .= '<input type="hidden" id="hdnColorPapel'.$c.$f.'" name="hdnColorPapel'.$c.'[]" value="" />';
				
						$c = $c + 1;
					}
					
					$html .= '<input type="hidden" id="hdnTipoForro'.$f.'" name="hdnTipoForro[]" value="" />
					<input type="hidden" id="hdnTiempo'.$f.'" name="hdnTiempo[]" value="" />
					<input type="hidden" id="hdnTipoTiempo'.$f.'" name="hdnTipoTiempo[]" value="" />
					<input type="hidden" id="hdnTipoCategoria'.$f.'" name="hdnTipoCategoria[]" value="" />
					
					<input type="hidden" id="hdnSinNumeracion'.$f.'" name="hdnSinNumeracion[]" value="" />
					<input type="hidden" id="hdnArte'.$f.'" name="hdnArte[]" value="" />
					<input type="hidden" id="hdnPlaca'.$f.'" name="hdnPlaca[]" value="" />
					
					<input type="hidden" id="hdnDescripcionBanner'.$f.'" name="hdnDescripcionBanner[]" value="'.utf8_encode($row['Descripcion']).'" />
					<input type="hidden" id="hdnMaterialBanner'.$f.'" name="hdnMaterialBanner[]" value="'.$row['id_material'].'" />
					<input type="hidden" id="hdnAncho'.$f.'" name="hdnAncho[]" value="'.number_format($row['ancho'],2,'.','').'" />
					<input type="hidden" id="hdnAnchoMedida'.$f.'" name="hdnAnchoMedida[]" value="'.$row['id_medida_ancho'].'" />
					<input type="hidden" id="hdnLargo'.$f.'" name="hdnLargo[]" value="'.number_format($row['largo'],2,'.','').'" />
					<input type="hidden" id="hdnLargoMedida'.$f.'" name="hdnLargoMedida[]" value="'.$row['id_medida_largo'].'" />
					<input type="hidden" id="hdnAreaTotal'.$f.'" name="hdnAreaTotal[]" value="'.number_format($row['area_total'],2,'.','').'" />
					<input type="hidden" id="hdnFormaPago'.$f.'" name="hdnFormaPago[]" value="'.$row['id_forma_pago'].'" />
					<input type="hidden" id="hdnCalidadBanner'.$f.'" name="hdnCalidadBanner[]" value="'.$row['id_calidad'].'" />
					<input type="hidden" id="hdnPrecioInstalacion'.$f.'" name="hdnPrecioInstalacion[]" value="'.number_format($row['precio_instalacion'],2,'.','').'" />
					<input type="hidden" id="hdnPrecioRecorte'.$f.'" name="hdnPrecioRecorte[]" value="'.number_format($row['precio_recorte'],2,'.','').'" />	
					<input type="hidden" id="hdnPrecioArte'.$f.'" name="hdnPrecioArte[]" value="'.number_format($row['precio_arte'],2,'.','').'" />
					<input type="hidden" id="hdnPrecioRotulado'.$f.'" name="hdnPrecioRotulado[]" value="'.number_format($row['precio_rotulado'],2,'.','').'" />
					<input type="hidden" id="hdnPrecioBasta'.$f.'" name="hdnPrecioBasta[]" value="'.number_format($row['precio_basta'],2,'.','').'" />
					<input type="hidden" id="hdnPrecioOjete'.$f.'" name="hdnPrecioOjete[]" value="'.number_format($row['precio_ojetes'],2,'.','').'" />
					<input type="hidden" id="hdnPrecioBulcaniza'.$f.'" name="hdnPrecioBulcaniza[]" value="'.number_format($row['precio_bulcaniza'],2,'.','').'"  />
					
					<input type="hidden" id="hdnDescripcionImpresion'.$f.'" name="hdnDescripcionImpresion[]" value="" />
					<input type="hidden" id="hdnMaterialImpresion'.$f.'" name="hdnMaterialImpresion[]" value="" />
					<input type="hidden" id="hdnRecorte'.$f.'" name="hdnRecorte[]" value="" />
					<input type="hidden" id="hdnPlastificado'.$f.'" name="hdnPlastificado[]" value="" />
					<input type="hidden" id="hdnCaminado'.$f.'" name="hdnCaminado[]" value="" />
					<input type="hidden" id="hdnRealce'.$f.'" name="hdnRealce[]" value="" />					
					<input type="hidden" id="hdnDoblado'.$f.'" name="hdnDoblado[]" value="" />
					<input type="hidden" id="hdnRepujado'.$f.'" name="hdnRepujado[]" value="" />
					<input type="hidden" id="hdnEngrapado'.$f.'" name="hdnEngrapado[]" value="" />
					<input type="hidden" id="hdnUV'.$f.'" name="hdnUV[]" value="" />
					<input type="hidden" id="hdnCantPliego'.$f.'" name="hdnCantPliego[]" value="" />
					<input type="hidden" id="hdnAjustarTamano'.$f.'" name="hdnAjustarTamano[]" value="" />					
					
					<input type="hidden" id="hdnExentoITBM'.$f.'" name="hdnExentoITBM[]" value="'.$row['exento_itbm'].'"  />					
					<input type="hidden" id="hdnNotaCotizacion'.$f.'" name="hdnNotaCotizacion[]" value="'.utf8_encode($row['observacion']).'"  />

					<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.$f.'" /></td>
					</tr>
					<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles('.$f.',\'tbnr\')" >Ver detalle</a></td></tr>
					</table></td>
					</tr>';
				}
				else if ($row['tipo_trabajo_producto'] == 3)
				{
					$html .= '<tr id="rowDetalle_'.$f.'"  valign="center"  >
								<td  align="center"  width="2%">'.$f.'</td>
								<td colspan="6"><table width="100%">
								<tr>
								<td width="15%"><span class="req">*</span><input type="text" id="txtCantidad'.$f.'" name="txtCantidad[]" value="'.$row['cantidad'].'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad'.$f.'" name="hidCantidad[]" value="'.$row['cantidad'].'"  /></td>
								<td width="15%"><input type="text" id="txtTipoEmpaque'.$f.'" name="txtTipoEmpaque[]" value="'.$row['tipo_empaque'].'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque'.$f.'" name="hidTipoEmpaque[]" value=""  /></td>
								<td width="32%"><span class="req">*</span>';
					/*if ($mobile_browser>0)
					{
						$html .= '<div data-role="page" id="mainPage"><p><input type="text" id="searchField'.$f.'" placeholder="Producto" style="width:85%;" class="validate[required]" value="'.$row['Descripcion'].'">
						<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';
					}
					else
					{*/
						$html .= '<input type="text" id="txtProducto'.$f.'" name="txtProducto[]" style="width:85%;" class="validate[required]" value="'.utf8_encode("Trabajo de Impresión").'"/>';
					//}
					
					
					$html .= '<input type="hidden" id="hidIdProducto'.$f.'" name="hidIdProducto[]" value="timpart"  /><input type="hidden" id="hidDescProducto'.$f.'" name="hidDescProducto[]" value="'.utf8_encode("Trabajo de Impresión").'"  />
					<input type="hidden" id="hidIdImprenta'.$f.'" name="hidIdImprenta[]" value=""  />
					<input type="hidden" id="hidIdBanner'.$f.'" name="hidIdBanner[]" value=""  />
					<input type="hidden" id="hidIdImpresion'.$f.'" name="hidIdImpresion[]" value="'.md5($row['Id_Trabajo_Producto']).'"  /></td>
					<td width="15%"><input type="text" id="txtPrecio'.$f.'" name="txtPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio'.$f.'" name="hidPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'"  /></td>
					<td width="15%"><input type="text" id="txtTotal'.$f.'" name="txtTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal'.$f.'" name="hidTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'"  /></td>
					<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo('.$f.')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>

					<input type="hidden" id="hdnDescripcionImprenta'.$f.'" name="hdnDescripcionImprenta[]" value="" />
					<input type="hidden" id="hdnPapelTipo'.$f.'" name="hdnPapelTipo[]" value="" />
					<input type="hidden" id="hdnMaterialPapelTipo'.$f.'" name="hdnMaterialPapelTipo[]" value="" />
					<input type="hidden" id="hdnResmaTamano'.$f.'" name="hdnResmaTamano[]" value="" />
					<input type="hidden" id="hdnTamano'.$f.'" name="hdnTamano[]" value="'.$row['id_tamano'].'" />
					<input type="hidden" id="hdnCantidadCopia'.$f.'" name="hdnCantidadCopia[]" value="" />
					<input type="hidden" id="hdnColorTinta'.$f.'" name="hdnColorTinta[]" value="'.$row['id_color_tinta'].'" />
					<input type="hidden" id="hdnOtroTamanoAncho'.$f.'" name="hdnOtroTamanoAncho[]" value="'.$row['otro_ancho'].'" />
					<input type="hidden" id="hdnOtroTamanoLargo'.$f.'" name="hdnOtroTamanoLargo[]" value="'.$row['otro_largo'].'" />
					<input type="hidden" id="hdnNumeracionInicio'.$f.'" name="hdnNumeracionInicio[]" value="" />
					<input type="hidden" id="hdnNumeracionFinal'.$f.'" name="hdnNumeracionFinal[]" value="" />';
					$c = 0;
			
					while ($c <= 3)
					{
						if ($c == 0)
						$html .= '<input type="hidden" id="hdnColorPapel'.$f.'" name="hdnColorPapel[]" value="" />';					
						else
						$html .= '<input type="hidden" id="hdnColorPapel'.$c.$f.'" name="hdnColorPapel'.$c.'[]" value="" />';
				
						$c = $c + 1;
					}
					
					$html .= '<input type="hidden" id="hdnTipoForro'.$f.'" name="hdnTipoForro[]" value="" />
					<input type="hidden" id="hdnTiempo'.$f.'" name="hdnTiempo[]" value="" />
					<input type="hidden" id="hdnTipoTiempo'.$f.'" name="hdnTipoTiempo[]" value="" />
					<input type="hidden" id="hdnTipoCategoria'.$f.'" name="hdnTipoCategoria[]" value="'.$row['id_categoria'].'" />

					<input type="hidden" id="hdnSinNumeracion'.$f.'" name="hdnSinNumeracion[]" value="" />
					<input type="hidden" id="hdnArte'.$f.'" name="hdnArte[]" value="" />
					<input type="hidden" id="hdnPlaca'.$f.'" name="hdnPlaca[]" value="" />
					
					<input type="hidden" id="hdnDescripcionBanner'.$f.'" name="hdnDescripcionBanner[]" value="" />
					<input type="hidden" id="hdnMaterialBanner'.$f.'" name="hdnMaterialBanner[]" value="" />
					<input type="hidden" id="hdnAncho'.$f.'" name="hdnAncho[]" value="'.number_format($row['arte_ancho'],2,'.','').'" />
					<input type="hidden" id="hdnAnchoMedida'.$f.'" name="hdnAnchoMedida[]" value="'.$row['arte_ancho_medida'].'" />
					<input type="hidden" id="hdnLargo'.$f.'" name="hdnLargo[]" value="'.number_format($row['arte_largo'],2,'.','').'" />
					<input type="hidden" id="hdnLargoMedida'.$f.'" name="hdnLargoMedida[]" value="'.$row['arte_largo_medida'].'" />
					<input type="hidden" id="hdnAreaTotal'.$f.'" name="hdnAreaTotal[]" value="'.number_format($row['arte_area'],2,'.','').'" />
					<input type="hidden" id="hdnFormaPago'.$f.'" name="hdnFormaPago[]" value="" />
					<input type="hidden" id="hdnCalidadBanner'.$f.'" name="hdnCalidadBanner[]" value="" />
					<input type="hidden" id="hdnPrecioInstalacion'.$f.'" name="hdnPrecioInstalacion[]" value="" />
					<input type="hidden" id="hdnPrecioRecorte'.$f.'" name="hdnPrecioRecorte[]" value="" />	
					<input type="hidden" id="hdnPrecioArte'.$f.'" name="hdnPrecioArte[]" value="'.number_format($row['precio_arte'],2,'.','').'" />
					<input type="hidden" id="hdnPrecioRotulado'.$f.'" name="hdnPrecioRotulado[]" value="" />
					<input type="hidden" id="hdnPrecioBasta'.$f.'" name="hdnPrecioBasta[]" value="" />
					<input type="hidden" id="hdnPrecioOjete'.$f.'" name="hdnPrecioOjete[]" value="" />
					<input type="hidden" id="hdnPrecioBulcaniza'.$f.'" name="hdnPrecioBulcaniza[]" value=""  />
					
					<input type="hidden" id="hdnDescripcionImpresion'.$f.'" name="hdnDescripcionImpresion[]" value="'.utf8_encode($row['Descripcion']).'" />
					<input type="hidden" id="hdnMaterialImpresion'.$f.'" name="hdnMaterialImpresion[]" value="'.$row['id_material'].'" />
					<input type="hidden" id="hdnRecorte'.$f.'" name="hdnRecorte[]" value="'.number_format($row['recorte'],2,'.','').'" />
					<input type="hidden" id="hdnPlastificado'.$f.'" name="hdnPlastificado[]" value="'.number_format($row['plastificado'],2,'.','').'" />
					<input type="hidden" id="hdnCaminado'.$f.'" name="hdnCaminado[]" value="'.number_format($row['caminado'],2,'.','').'" />
					<input type="hidden" id="hdnRealce'.$f.'" name="hdnRealce[]" value="'.number_format($row['realce'],2,'.','').'" />					
					<input type="hidden" id="hdnDoblado'.$f.'" name="hdnDoblado[]" value="'.number_format($row['doblado'],2,'.','').'" />
					<input type="hidden" id="hdnRepujado'.$f.'" name="hdnRepujado[]" value="'.number_format($row['repujado'],2,'.','').'" />
					<input type="hidden" id="hdnEngrapado'.$f.'" name="hdnEngrapado[]" value="'.number_format($row['engrapado'],2,'.','').'" />
					<input type="hidden" id="hdnUV'.$f.'" name="hdnUV[]" value="'.number_format($row['UV'],2,'.','').'" />	
					<input type="hidden" id="hdnCantPliego'.$f.'" name="hdnCantPliego[]" value="'.number_format($row['cantidad_pliego'],0,'.','').'" />
					<input type="hidden" id="hdnAjustarTamano'.$f.'" name="hdnAjustarTamano[]" value="'.number_format($row['ajustar_tamano'],0,'.','').'" />					
					
					<input type="hidden" id="hdnExentoITBM'.$f.'" name="hdnExentoITBM[]" value="'.$row['exento_itbm'].'"  />
					<input type="hidden" id="hdnNotaCotizacion'.$f.'" name="hdnNotaCotizacion[]" value="'.utf8_encode($row['observacion']).'"  />
					
					<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.$f.'" /></td>
					</tr>
					<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles('.$f.',\'timpart\')" >Ver detalle</a></td></tr>
					</table></td>
					</tr>';				
				}
				$f = $f + 1;
			}
		}
		//echo "prueba";
		echo $html;		
	}
	
	
	if($_GET['action'] == 'Buscar_Cotizaciones_Anteriores')
	{
		// include('detector_cel.php');
		$html = "";
		
		$Id_Cotizacion	= strip_tags(utf8_decode(strtolower($_POST['idCotizacion'])));
		
		try
		{		
			$stmt = $db->prepare("SELECT id_cotizacion, p.id_producto AS Id_Trabajo_Producto, '0' AS tipo_trabajo_producto, cantidad,nombre_producto AS Descripcion, cp.precio_venta,
			descripcion_empaque AS tipo_empaque, '' AS id_tipo_papel, '' AS id_tipo_material, '' AS id_resmatamano, '' AS id_tamano,
			'' AS numeracion_inicial,'' AS numeracion_final,'' AS otro_ancho,'' AS otro_largo,'' AS cant_copia,'' AS id_color_papel,
			'' AS id_color_papel1,'' AS id_color_papel2,'' AS id_color_papel3,'' AS id_color_tinta,'' AS id_forro,'' AS tiempo,'' AS arte,'' AS placa,
			'' AS id_tipo_tiempo,'' AS id_categoria,'' AS exento_itbm,'' AS observacion,'' AS id_material,'' AS ancho,'' AS id_medida_ancho,
			'' AS largo,'' AS id_medida_largo,'' AS area_total,'' AS id_forma_pago,'' AS id_calidad,'' AS precio_instalacion,'' AS precio_recorte,
			'' AS precio_arte,'' AS precio_rotulado,'' AS precio_basta,'' AS precio_ojetes,'' AS precio_bulcaniza,'' AS arte_ancho,'' AS arte_ancho_medida,
			'' AS arte_largo,'' AS arte_largo_medida,'' AS arte_area,'' AS ajustar_tamano,'' AS recorte,'' AS plastificado,'' AS caminado,'' AS realce,'' AS doblado,'' AS repujado,'' AS engrapado,'' AS UV											
			FROM cotizacion_producto cp
			INNER JOIN producto p ON (cp.id_producto = p.id_producto)
			INNER JOIN tipo_empaque te ON (te.id_tipo_empaque = p.id_tipo_empaque)
			WHERE (id_imprenta IS NULL OR id_imprenta = 0) AND (id_banner IS NULL OR id_banner = 0) AND (id_impresion IS NULL OR id_impresion = 0)  AND MD5(id_cotizacion) = ?
			UNION
			SELECT id_cotizacion, i.id_imprenta AS Id_Trabajo_Producto, '1' AS tipo_trabajo_producto, cantidad, IF(descripcion_imprenta IS NOT NULL,descripcion_imprenta,'Trabajo de Imprenta') AS Descripcion, cp.precio_venta,
			'Unidad' AS tipo_empaque,id_tipo_papel,id_tipo_material,id_resmatamano,id_tamano,numeracion_inicial,numeracion_final,otro_ancho,otro_largo,
			cant_copia,id_color_papel,id_color_papel1,id_color_papel2,id_color_papel3,id_color_tinta,id_forro,tiempo,arte,placa,
			id_tipo_tiempo,id_categoria,exento_itbm,observacion,'' AS id_material,'' AS ancho,'' AS id_medida_ancho,
			'' AS largo,'' AS id_medida_largo,'' AS area_total,'' AS id_forma_pago,'' AS id_calidad,'' AS precio_instalacion,'' AS precio_recorte,
			'' AS precio_arte,'' AS precio_rotulado,'' AS precio_basta,'' AS precio_ojetes,'' AS precio_bulcaniza,'' AS arte_ancho,'' AS arte_ancho_medida,
			'' AS arte_largo,'' AS arte_largo_medida,'' AS arte_area,'' AS ajustar_tamano,'' AS recorte,'' AS plastificado,'' AS caminado,'' AS realce,'' AS doblado,'' AS repujado,'' AS engrapado,'' AS UV
			FROM cotizacion_producto cp
			INNER JOIN imprenta i ON (cp.id_imprenta = i.id_imprenta)
			WHERE id_producto IS NULL OR id_producto = 0 AND MD5(id_cotizacion) = ?
			UNION
			SELECT id_cotizacion, b.id_banner AS Id_Trabajo_Producto, '2' AS tipo_trabajo_producto, cantidad, IF(descripcion_banner IS NOT NULL,descripcion_banner,'Trabajo de Banner') AS Descripcion, cp.precio_venta,
			'Unidad' AS tipo_empaque, '' AS id_tipo_papel, '' AS id_tipo_material, '' AS id_resmatamano, '' AS id_tamano,
			'' AS numeracion_inicial,'' AS numeracion_final,'' AS otro_ancho,'' AS otro_largo,'' AS cant_copia,'' AS id_color_papel,
			'' AS id_color_papel1,'' AS id_color_papel2,'' AS id_color_papel3,'' AS id_color_tinta,'' AS id_forro,'' AS tiempo,'' AS arte,'' AS placa,
			'' AS id_tipo_tiempo,'' AS id_categoria,exento_itbm,observacion,id_material,ancho,id_medida_ancho,largo,id_medida_largo,area_total,
			id_forma_pago,id_calidad,precio_instalacion,precio_recorte,precio_arte,precio_rotulado,precio_basta,precio_ojetes,
			precio_bulcaniza,'' AS arte_ancho,'' AS arte_ancho_medida,'' AS arte_largo,'' AS arte_largo_medida,'' AS arte_area,'' AS ajustar_tamano,'' AS recorte,
			'' AS plastificado,'' AS caminado,'' AS realce,'' AS doblado,'' AS repujado,'' AS engrapado,'' AS UV
			FROM cotizacion_producto cp
			INNER JOIN banner b ON (cp.id_banner = b.id_banner)
			WHERE id_producto IS NULL OR id_producto = 0 AND MD5(id_cotizacion) = ?
			UNION
			SELECT id_cotizacion, im.id_impresion AS Id_Trabajo_Producto, '3' AS tipo_trabajo_producto, cantidad, IF(descripcion_impresion IS NOT NULL,descripcion_impresion,'Trabajo de Impresión') AS Descripcion, cp.precio_venta,
			'Unidad' AS tipo_empaque, '' AS id_tipo_papel, '' AS id_tipo_material, '' AS id_resmatamano, id_tamano,
			'' AS numeracion_inicial,'' AS numeracion_final,otro_ancho,otro_largo,'' AS cant_copia,'' AS id_color_papel,
			'' AS id_color_papel1,'' AS id_color_papel2,'' AS id_color_papel3, id_color_tinta,'' AS id_forro,'' AS tiempo,'' AS arte,'' AS placa,
			'' AS id_tipo_tiempo,id_categoria,exento_itbm,observacion, id_material,'' AS ancho,'' AS id_medida_ancho,'' AS largo,'' AS id_medida_largo,'' AS area_total,
			'' AS id_forma_pago,'' AS id_calidad,'' AS precio_instalacion,'' AS precio_recorte,precio_arte,'' AS precio_rotulado,'' AS precio_basta,'' AS precio_ojetes,
			'' AS precio_bulcaniza,arte_ancho,arte_ancho_medida,arte_largo,arte_largo_medida,arte_area,ajustar_tamano,recorte,plastificado,caminado,realce,doblado,repujado,engrapado,UV
			FROM cotizacion_producto cp
			INNER JOIN impresion im ON (cp.id_impresion = im.id_impresion)
			WHERE id_producto IS NULL OR id_producto = 0 AND MD5(id_cotizacion) = ?");
			
			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);			
			
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
			$f = 1;
			foreach ($rows as $row)
			{	
				if ($row['tipo_trabajo_producto'] == 0)
				{
					$html .= '<tr id="rowDetalle_'.$f.'"  valign="center"  >
								<td  align="center">'.$f.'</td>
								<td><span class="req">*</span><input type="text" id="txtCantidad'.$f.'" name="txtCantidad[]" value="'.$row['cantidad'].'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad'.$f.'" name="hidCantidad[]" value="'.$row['cantidad'].'"  /></td>
								<td><input type="text" id="txtTipoEmpaque'.$f.'" name="txtTipoEmpaque[]" value="'.$row['tipo_empaque'].'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque'.$f.'" name="hidTipoEmpaque[]" value=""  /></td>
								<td><span class="req">*</span>';
					/*if ($mobile_browser>0)
					{
						$html .= '<div data-role="page" id="mainPage"><p><input type="text" id="searchField'.$f.'" placeholder="Producto" style="width:85%;" class="validate[required]" value="'.$row['Descripcion'].'">
						<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';
					}
					else
					{*/
						$html .= '<input type="text" id="txtProducto'.$f.'" name="txtProducto[]" style="width:85%;" class="validate[required]" value="'.utf8_encode($row['Descripcion']).'"/>';
					//}
					
					
					$html .= '<input type="hidden" id="hidIdProducto'.$f.'" name="hidIdProducto[]" value="'.$row['Id_Trabajo_Producto'].'"  /><input type="hidden" id="hidDescProducto'.$f.'" name="hidDescProducto[]" value="'.utf8_encode($row['Descripcion']).'"  />
					<input type="hidden" id="hidIdImprenta'.$f.'" name="hidIdImprenta[]" value=""  />
					<input type="hidden" id="hidIdBanner'.$f.'" name="hidIdBanner[]" value=""  />
					<input type="hidden" id="hidIdImpresion'.$f.'" name="hidIdImpresion[]" value=""  /></td>
					<td><input type="text" id="txtPrecio'.$f.'" name="txtPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio'.$f.'" name="hidPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'"  /></td>
					<td><input type="text" id="txtTotal'.$f.'" name="txtTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal'.$f.'" name="hidTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'"  /></td>
					<td><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo('.$f.')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>
					
					<input type="hidden" id="hdnDescripcionImprenta'.$f.'" name="hdnDescripcionImprenta[]" value="" />
					<input type="hidden" id="hdnPapelTipo'.$f.'" name="hdnPapelTipo[]" value="" />
					<input type="hidden" id="hdnMaterialPapelTipo'.$f.'" name="hdnMaterialPapelTipo[]" value="" />
					<input type="hidden" id="hdnResmaTamano'.$f.'" name="hdnResmaTamano[]" value="" />
					<input type="hidden" id="hdnTamano'.$f.'" name="hdnTamano[]" value="" />
					<input type="hidden" id="hdnCantidadCopia'.$f.'" name="hdnCantidadCopia[]" value="" />
					<input type="hidden" id="hdnColorTinta'.$f.'" name="hdnColorTinta[]" value="" />
					<input type="hidden" id="hdnOtroTamanoAncho'.$f.'" name="hdnOtroTamanoAncho[]" value="" />
					<input type="hidden" id="hdnOtroTamanoLargo'.$f.'" name="hdnOtroTamanoLargo[]" value="" />
					<input type="hidden" id="hdnNumeracionInicio'.$f.'" name="hdnNumeracionInicio[]" value="" />
					<input type="hidden" id="hdnNumeracionFinal'.$f.'" name="hdnNumeracionFinal[]" value="" />';
					$c = 0;
			
					while ($c <= 3)
					{
						if ($c == 0)
						$html .= '<input type="hidden" id="hdnColorPapel'.$f.'" name="hdnColorPapel[]" value="" />';					
						else
						$html .= '<input type="hidden" id="hdnColorPapel'.$c.$f.'" name="hdnColorPapel'.$c.'[]" value="" />';
				
						$c = $c + 1;
					}
					
					$html .= '<input type="hidden" id="hdnTipoForro'.$f.'" name="hdnTipoForro[]" value="" />
					<input type="hidden" id="hdnTiempo'.$f.'" name="hdnTiempo[]" value="" />
					<input type="hidden" id="hdnTipoTiempo'.$f.'" name="hdnTipoTiempo[]" value="" />
					<input type="hidden" id="hdnTipoCategoria'.$f.'" name="hdnTipoCategoria[]" value="" />
					
					<input type="hidden" id="hdnSinNumeracion'.$f.'" name="hdnSinNumeracion[]" value="" />
					<input type="hidden" id="hdnArte'.$f.'" name="hdnArte[]" value="" />
					<input type="hidden" id="hdnPlaca'.$f.'" name="hdnPlaca[]" value="" />
					
					<input type="hidden" id="hdnExentoITBM'.$f.'" name="hdnExentoITBM[]" value=""  />
					<input type="hidden" id="hdnNotaCotizacion'.$f.'" name="hdnNotaCotizacion[]" value=""  />
					
					<input type="hidden" id="hdnDescripcionBanner'.$f.'" name="hdnDescripcionBanner[]" value="" />
					<input type="hidden" id="hdnMaterialBanner'.$f.'" name="hdnMaterialBanner[]" value="" />
					<input type="hidden" id="hdnAncho'.$f.'" name="hdnAncho[]" value="" />
					<input type="hidden" id="hdnAnchoMedida'.$f.'" name="hdnAnchoMedida[]" value="" />
					<input type="hidden" id="hdnLargo'.$f.'" name="hdnLargo[]" value="" />
					<input type="hidden" id="hdnLargoMedida'.$f.'" name="hdnLargoMedida[]" value="" />
					<input type="hidden" id="hdnAreaTotal'.$f.'" name="hdnAreaTotal[]" value="" />
					<input type="hidden" id="hdnFormaPago'.$f.'" name="hdnFormaPago[]" value="" />
					<input type="hidden" id="hdnCalidadBanner'.$f.'" name="hdnCalidadBanner[]" value="" />
					<input type="hidden" id="hdnPrecioInstalacion'.$f.'" name="hdnPrecioInstalacion[]" value="" />
					<input type="hidden" id="hdnPrecioRecorte'.$f.'" name="hdnPrecioRecorte[]" value="" />	
					<input type="hidden" id="hdnPrecioArte'.$f.'" name="hdnPrecioArte[]" value="" />
					<input type="hidden" id="hdnPrecioRotulado'.$f.'" name="hdnPrecioRotulado[]" value="" />
					<input type="hidden" id="hdnPrecioBasta'.$f.'" name="hdnPrecioBasta[]" value="" />
					<input type="hidden" id="hdnPrecioOjete'.$f.'" name="hdnPrecioOjete[]" value="" />
					<input type="hidden" id="hdnPrecioBulcaniza'.$f.'" name="hdnPrecioBulcaniza[]" value=""  />
					
					<input type="hidden" id="hdnDescripcionImpresion'.$f.'" name="hdnDescripcionImpresion[]" value="" />
					<input type="hidden" id="hdnMaterialImpresion'.$f.'" name="hdnMaterialImpresion[]" value="" />
					<input type="hidden" id="hdnRecorte'.$f.'" name="hdnRecorte[]" value="" />
					<input type="hidden" id="hdnPlastificado'.$f.'" name="hdnPlastificado[]" value="" />
					<input type="hidden" id="hdnCaminado'.$f.'" name="hdnCaminado[]" value="" />
					<input type="hidden" id="hdnRealce'.$f.'" name="hdnRealce[]" value="" />					
					<input type="hidden" id="hdnDoblado'.$f.'" name="hdnDoblado[]" value="" />
					<input type="hidden" id="hdnRepujado'.$f.'" name="hdnRepujado[]" value="" />
					<input type="hidden" id="hdnEngrapado'.$f.'" name="hdnEngrapado[]" value="" />
					<input type="hidden" id="hdnUV'.$f.'" name="hdnUV[]" value="" />
					<input type="hidden" id="hdnCantPliego'.$f.'" name="hdnCantPliego[]" value="" />
					<input type="hidden" id="hdnAjustarTamano'.$f.'" name="hdnAjustarTamano[]" value="" />
					
					<input type="hidden" id="hdnExentoITBM'.$f.'" name="hdnExentoITBM[]" value="" />							
					<input type="hidden" id="hdnNotaCotizacion'.$f.'" name="hdnNotaCotizacion[]" value=""  />
		
					<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.$f.'" /></td>
					</tr>';
				}
				else if ($row['tipo_trabajo_producto'] == 1)
				{
					$html .= '<tr id="rowDetalle_'.$f.'"  valign="center"  >
								<td  align="center"  width="2%">'.$f.'</td>
								<td colspan="6"><table width="100%">
								<tr>
								<td width="15%"><span class="req">*</span><input type="text" id="txtCantidad'.$f.'" name="txtCantidad[]" value="'.$row['cantidad'].'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad'.$f.'" name="hidCantidad[]" value="'.$row['cantidad'].'"  /></td>
								<td width="15%"><input type="text" id="txtTipoEmpaque'.$f.'" name="txtTipoEmpaque[]" value="'.$row['tipo_empaque'].'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque'.$f.'" name="hidTipoEmpaque[]" value=""  /></td>
								<td width="32%"><span class="req">*</span>';
					/*if ($mobile_browser>0)
					{
						$html .= '<div data-role="page" id="mainPage"><p><input type="text" id="searchField'.$f.'" placeholder="Producto" style="width:85%;" class="validate[required]" value="'.$row['Descripcion'].'">
						<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';
					}
					else
					{*/
						$html .= '<input type="text" id="txtProducto'.$f.'" name="txtProducto[]" style="width:85%;" class="validate[required]" value="Trabajo de Imprenta"/>';
					//}
					
					
					$html .= '<input type="hidden" id="hidIdProducto'.$f.'" name="hidIdProducto[]" value="timp"  /><input type="hidden" id="hidDescProducto'.$f.'" name="hidDescProducto[]" value="Trabajo de Imprenta"  />
					<input type="hidden" id="hidIdImprenta'.$f.'" name="hidIdImprenta[]" value=""  />
					<input type="hidden" id="hidIdBanner'.$f.'" name="hidIdBanner[]" value=""  />
					<input type="hidden" id="hidIdImpresion'.$f.'" name="hidIdImpresion[]" value=""  /></td>					
					<td width="15%"><input type="text" id="txtPrecio'.$f.'" name="txtPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio'.$f.'" name="hidPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'"  /></td>
					<td width="15%"><input type="text" id="txtTotal'.$f.'" name="txtTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal'.$f.'" name="hidTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'"  /></td>
					<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo('.$f.')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>
					
					<input type="hidden" id="hdnDescripcionImprenta'.$f.'" name="hdnDescripcionImprenta[]" value="'.utf8_encode($row['Descripcion']).'" />
					<input type="hidden" id="hdnPapelTipo'.$f.'" name="hdnPapelTipo[]" value="'.$row['id_tipo_papel'].'" />
					<input type="hidden" id="hdnMaterialPapelTipo'.$f.'" name="hdnMaterialPapelTipo[]" value="'.$row['id_tipo_material'].'" />
					<input type="hidden" id="hdnResmaTamano'.$f.'" name="hdnResmaTamano[]" value="'.$row['id_resmatamano'].'" />
					<input type="hidden" id="hdnTamano'.$f.'" name="hdnTamano[]" value="'.$row['id_tamano'].'" />
					<input type="hidden" id="hdnCantidadCopia'.$f.'" name="hdnCantidadCopia[]" value="'.$row['cant_copia'].'" />
					<input type="hidden" id="hdnColorTinta'.$f.'" name="hdnColorTinta[]" value="'.$row['id_color_tinta'].'" />
					<input type="hidden" id="hdnOtroTamanoAncho'.$f.'" name="hdnOtroTamanoAncho[]" value="'.$row['otro_ancho'].'" />
					<input type="hidden" id="hdnOtroTamanoLargo'.$f.'" name="hdnOtroTamanoLargo[]" value="'.$row['otro_largo'].'" />
					<input type="hidden" id="hdnNumeracionInicio'.$f.'" name="hdnNumeracionInicio[]" value="'.($row['numeracion_final']+1).'" />
					<input type="hidden" id="hdnNumeracionFinal'.$f.'" name="hdnNumeracionFinal[]" value="'.($row['numeracion_final']+($row['numeracion_final']-$row['numeracion_inicial']) + 1).'" />';
					$c = 0;
			
					while ($c <= 3)
					{
						if ($c == 0)
						$html .= '<input type="hidden" id="hdnColorPapel'.$f.'" name="hdnColorPapel[]" value="'.$row['id_color_papel'].'" />';					
						else
						$html .= '<input type="hidden" id="hdnColorPapel'.$c.$f.'" name="hdnColorPapel'.$c.'[]" value="'.$row['id_color_papel'.$c].'" />';
				
						$c = $c + 1;
					}
					
					$html .= '<input type="hidden" id="hdnTipoForro'.$f.'" name="hdnTipoForro[]" value="'.$row['id_forro'].'" />
					<input type="hidden" id="hdnTiempo'.$f.'" name="hdnTiempo[]" value="'.$row['tiempo'].'" />
					<input type="hidden" id="hdnTipoTiempo'.$f.'" name="hdnTipoTiempo[]" value="'.$row['id_tipo_tiempo'].'" />
					<input type="hidden" id="hdnTipoCategoria'.$f.'" name="hdnTipoCategoria[]" value="'.$row['id_categoria'].'" />';
					
					if (($row['numeracion_final'] > 0) and ($row['numeracion_inicial'] > 0))
					$html .= '<input type="hidden" id="hdnSinNumeracion'.$f.'" name="hdnSinNumeracion[]" value="0" />';
					else
					$html .= '<input type="hidden" id="hdnSinNumeracion'.$f.'" name="hdnSinNumeracion[]" value="1" />';
					
					$html .= '<input type="hidden" id="hdnArte'.$f.'" name="hdnArte[]" value="'.$row['arte'].'" />
					<input type="hidden" id="hdnPlaca'.$f.'" name="hdnPlaca[]" value="'.$row['placa'].'" />
					
					<input type="hidden" id="hdnDescripcionBanner'.$f.'" name="hdnDescripcionBanner[]" value="" />
					<input type="hidden" id="hdnMaterialBanner'.$f.'" name="hdnMaterialBanner[]" value="" />
					<input type="hidden" id="hdnAncho'.$f.'" name="hdnAncho[]" value="" />
					<input type="hidden" id="hdnAnchoMedida'.$f.'" name="hdnAnchoMedida[]" value="" />
					<input type="hidden" id="hdnLargo'.$f.'" name="hdnLargo[]" value="" />
					<input type="hidden" id="hdnLargoMedida'.$f.'" name="hdnLargoMedida[]" value="" />
					<input type="hidden" id="hdnAreaTotal'.$f.'" name="hdnAreaTotal[]" value="" />
					<input type="hidden" id="hdnFormaPago'.$f.'" name="hdnFormaPago[]" value="" />
					<input type="hidden" id="hdnCalidadBanner'.$f.'" name="hdnCalidadBanner[]" value="" />
					<input type="hidden" id="hdnPrecioInstalacion'.$f.'" name="hdnPrecioInstalacion[]" value="" />
					<input type="hidden" id="hdnPrecioRecorte'.$f.'" name="hdnPrecioRecorte[]" value="" />	
					<input type="hidden" id="hdnPrecioArte'.$f.'" name="hdnPrecioArte[]" value="" />
					<input type="hidden" id="hdnPrecioRotulado'.$f.'" name="hdnPrecioRotulado[]" value="" />
					<input type="hidden" id="hdnPrecioBasta'.$f.'" name="hdnPrecioBasta[]" value="" />
					<input type="hidden" id="hdnPrecioOjete'.$f.'" name="hdnPrecioOjete[]" value="" />
					<input type="hidden" id="hdnPrecioBulcaniza'.$f.'" name="hdnPrecioBulcaniza[]" value=""  />
					
					<input type="hidden" id="hdnDescripcionImpresion'.$f.'" name="hdnDescripcionImpresion[]" value="" />
					<input type="hidden" id="hdnMaterialImpresion'.$f.'" name="hdnMaterialImpresion[]" value="" />
					<input type="hidden" id="hdnRecorte'.$f.'" name="hdnRecorte[]" value="" />
					<input type="hidden" id="hdnPlastificado'.$f.'" name="hdnPlastificado[]" value="" />
					<input type="hidden" id="hdnCaminado'.$f.'" name="hdnCaminado[]" value="" />
					<input type="hidden" id="hdnRealce'.$f.'" name="hdnRealce[]" value="" />					
					<input type="hidden" id="hdnDoblado'.$f.'" name="hdnDoblado[]" value="" />
					<input type="hidden" id="hdnRepujado'.$f.'" name="hdnRepujado[]" value="" />
					<input type="hidden" id="hdnEngrapado'.$f.'" name="hdnEngrapado[]" value="" />
					<input type="hidden" id="hdnUV'.$f.'" name="hdnUV[]" value="" />
					<input type="hidden" id="hdnCantPliego'.$f.'" name="hdnCantPliego[]" value="" />
					<input type="hidden" id="hdnAjustarTamano'.$f.'" name="hdnAjustarTamano[]" value="" />
					
					<input type="hidden" id="hdnExentoITBM'.$f.'" name="hdnExentoITBM[]" value="'.$row['exento_itbm'].'"  />
					<input type="hidden" id="hdnNotaCotizacion'.$f.'" name="hdnNotaCotizacion[]" value="'.utf8_encode($row['observacion']).'"  />
					
					<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.$f.'" /></td>
					</tr>
					<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles('.$f.',\'timp\')" >Ver detalle</a></td></tr>
					</table></td>
					</tr>';
					
				}
				else if ($row['tipo_trabajo_producto'] == 2)
				{
					$html .= '<tr id="rowDetalle_'.$f.'"  valign="center"  >
								<td  align="center"  width="2%">'.$f.'</td>
								<td colspan="6"><table width="100%">
								<tr>
								<td width="15%"><span class="req">*</span><input type="text" id="txtCantidad'.$f.'" name="txtCantidad[]" value="'.$row['cantidad'].'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad'.$f.'" name="hidCantidad[]" value="'.$row['cantidad'].'"  /></td>
								<td width="15%"><input type="text" id="txtTipoEmpaque'.$f.'" name="txtTipoEmpaque[]" value="'.$row['tipo_empaque'].'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque'.$f.'" name="hidTipoEmpaque[]" value=""  /></td>
								<td width="32%"><span class="req">*</span>';
					/*if ($mobile_browser>0)
					{
						$html .= '<div data-role="page" id="mainPage"><p><input type="text" id="searchField'.$f.'" placeholder="Producto" style="width:85%;" class="validate[required]" value="'.$row['Descripcion'].'">
						<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';
					}
					else
					{*/
						$html .= '<input type="text" id="txtProducto'.$f.'" name="txtProducto[]" style="width:85%;" class="validate[required]" value="Trabajo de Banner"/>';
					//}
					
					
					$html .= '<input type="hidden" id="hidIdProducto'.$f.'" name="hidIdProducto[]" value="tbnr"  /><input type="hidden" id="hidDescProducto'.$f.'" name="hidDescProducto[]" value="Trabajo de Banner"  />
					<input type="hidden" id="hidIdImprenta'.$f.'" name="hidIdImprenta[]" value=""  />
					<input type="hidden" id="hidIdBanner'.$f.'" name="hidIdBanner[]" value=""  />
					<input type="hidden" id="hidIdImpresion'.$f.'" name="hidIdImpresion[]" value=""  /></td>
					<td width="15%"><input type="text" id="txtPrecio'.$f.'" name="txtPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio'.$f.'" name="hidPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'"  /></td>
					<td width="15%"><input type="text" id="txtTotal'.$f.'" name="txtTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal'.$f.'" name="hidTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'"  /></td>
					<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo('.$f.')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>
					
					<input type="hidden" id="hdnDescripcionImprenta'.$f.'" name="hdnDescripcionImprenta[]" value="" />
					<input type="hidden" id="hdnPapelTipo'.$f.'" name="hdnPapelTipo[]" value="" />
					<input type="hidden" id="hdnMaterialPapelTipo'.$f.'" name="hdnMaterialPapelTipo[]" value="" />
					<input type="hidden" id="hdnResmaTamano'.$f.'" name="hdnResmaTamano[]" value="" />
					<input type="hidden" id="hdnTamano'.$f.'" name="hdnTamano[]" value="" />
					<input type="hidden" id="hdnCantidadCopia'.$f.'" name="hdnCantidadCopia[]" value="" />
					<input type="hidden" id="hdnColorTinta'.$f.'" name="hdnColorTinta[]" value="" />
					<input type="hidden" id="hdnOtroTamanoAncho'.$f.'" name="hdnOtroTamanoAncho[]" value="" />
					<input type="hidden" id="hdnOtroTamanoLargo'.$f.'" name="hdnOtroTamanoLargo[]" value="" />
					<input type="hidden" id="hdnNumeracionInicio'.$f.'" name="hdnNumeracionInicio[]" value="" />
					<input type="hidden" id="hdnNumeracionFinal'.$f.'" name="hdnNumeracionFinal[]" value="" />';
					$c = 0;
			
					while ($c <= 3)
					{
						if ($c == 0)
						$html .= '<input type="hidden" id="hdnColorPapel'.$f.'" name="hdnColorPapel[]" value="" />';					
						else
						$html .= '<input type="hidden" id="hdnColorPapel'.$c.$f.'" name="hdnColorPapel'.$c.'[]" value="" />';
				
						$c = $c + 1;
					}
					
					$html .= '<input type="hidden" id="hdnTipoForro'.$f.'" name="hdnTipoForro[]" value="" />
					<input type="hidden" id="hdnTiempo'.$f.'" name="hdnTiempo[]" value="" />
					<input type="hidden" id="hdnTipoTiempo'.$f.'" name="hdnTipoTiempo[]" value="" />
					<input type="hidden" id="hdnTipoCategoria'.$f.'" name="hdnTipoCategoria[]" value="" />				
					
					<input type="hidden" id="hdnSinNumeracion'.$f.'" name="hdnSinNumeracion[]" value="" />
					<input type="hidden" id="hdnArte'.$f.'" name="hdnArte[]" value="" />
					<input type="hidden" id="hdnPlaca'.$f.'" name="hdnPlaca[]" value="" />
					
					<input type="hidden" id="hdnDescripcionBanner'.$f.'" name="hdnDescripcionBanner[]" value="'.utf8_encode($row['Descripcion']).'" />
					<input type="hidden" id="hdnMaterialBanner'.$f.'" name="hdnMaterialBanner[]" value="'.$row['id_material'].'" />
					<input type="hidden" id="hdnAncho'.$f.'" name="hdnAncho[]" value="'.number_format($row['ancho'],2,'.','').'" />
					<input type="hidden" id="hdnAnchoMedida'.$f.'" name="hdnAnchoMedida[]" value="'.$row['id_medida_ancho'].'" />
					<input type="hidden" id="hdnLargo'.$f.'" name="hdnLargo[]" value="'.number_format($row['largo'],2,'.','').'" />
					<input type="hidden" id="hdnLargoMedida'.$f.'" name="hdnLargoMedida[]" value="'.$row['id_medida_largo'].'" />
					<input type="hidden" id="hdnAreaTotal'.$f.'" name="hdnAreaTotal[]" value="'.number_format($row['area_total'],2,'.','').'" />
					<input type="hidden" id="hdnFormaPago'.$f.'" name="hdnFormaPago[]" value="'.$row['id_forma_pago'].'" />
					<input type="hidden" id="hdnCalidadBanner'.$f.'" name="hdnCalidadBanner[]" value="'.$row['id_calidad'].'" />
					<input type="hidden" id="hdnPrecioInstalacion'.$f.'" name="hdnPrecioInstalacion[]" value="'.number_format($row['precio_instalacion'],2,'.','').'" />
					<input type="hidden" id="hdnPrecioRecorte'.$f.'" name="hdnPrecioRecorte[]" value="'.number_format($row['precio_recorte'],2,'.','').'" />	
					<input type="hidden" id="hdnPrecioArte'.$f.'" name="hdnPrecioArte[]" value="'.number_format($row['precio_arte'],2,'.','').'" />
					<input type="hidden" id="hdnPrecioRotulado'.$f.'" name="hdnPrecioRotulado[]" value="'.number_format($row['precio_rotulado'],2,'.','').'" />
					<input type="hidden" id="hdnPrecioBasta'.$f.'" name="hdnPrecioBasta[]" value="'.number_format($row['precio_basta'],2,'.','').'" />
					<input type="hidden" id="hdnPrecioOjete'.$f.'" name="hdnPrecioOjete[]" value="'.number_format($row['precio_ojetes'],2,'.','').'" />
					<input type="hidden" id="hdnPrecioBulcaniza'.$f.'" name="hdnPrecioBulcaniza[]" value="'.number_format($row['precio_bulcaniza'],2,'.','').'"  />
					
					<input type="hidden" id="hdnDescripcionImpresion'.$f.'" name="hdnDescripcionImpresion[]" value="" />
					<input type="hidden" id="hdnMaterialImpresion'.$f.'" name="hdnMaterialImpresion[]" value="" />
					<input type="hidden" id="hdnRecorte'.$f.'" name="hdnRecorte[]" value="" />
					<input type="hidden" id="hdnPlastificado'.$f.'" name="hdnPlastificado[]" value="" />
					<input type="hidden" id="hdnCaminado'.$f.'" name="hdnCaminado[]" value="" />
					<input type="hidden" id="hdnRealce'.$f.'" name="hdnRealce[]" value="" />					
					<input type="hidden" id="hdnDoblado'.$f.'" name="hdnDoblado[]" value="" />
					<input type="hidden" id="hdnRepujado'.$f.'" name="hdnRepujado[]" value="" />
					<input type="hidden" id="hdnEngrapado'.$f.'" name="hdnEngrapado[]" value="" />
					<input type="hidden" id="hdnUV'.$f.'" name="hdnUV[]" value="" />
					<input type="hidden" id="hdnCantPliego'.$f.'" name="hdnCantPliego[]" value="" />
					<input type="hidden" id="hdnAjustarTamano'.$f.'" name="hdnAjustarTamano[]" value="" />
					
					<input type="hidden" id="hdnExentoITBM'.$f.'" name="hdnExentoITBM[]" value="'.$row['exento_itbm'].'"  />					
					<input type="hidden" id="hdnNotaCotizacion'.$f.'" name="hdnNotaCotizacion[]" value="'.utf8_encode($row['observacion']).'"  />
					
					<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.$f.'" /></td>
					</tr>
					<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles('.$f.',\'tbnr\')" >Ver detalle</a></td></tr>
					</table></td>
					</tr>';
				}
				else if ($row['tipo_trabajo_producto'] == 3)
				{
						$html .= '<tr id="rowDetalle_'.$f.'"  valign="center"  >
								<td  align="center"  width="2%">'.$f.'</td>
								<td colspan="6"><table width="100%">
								<tr>
								<td width="15%"><span class="req">*</span><input type="text" id="txtCantidad'.$f.'" name="txtCantidad[]" value="'.$row['cantidad'].'" style="width:80%;" class="validate[required]" onchange=""/><input type="hidden" id="hidCantidad'.$f.'" name="hidCantidad[]" value="'.$row['cantidad'].'"  /></td>
								<td width="15%"><input type="text" id="txtTipoEmpaque'.$f.'" name="txtTipoEmpaque[]" value="'.$row['tipo_empaque'].'" style="width:80%;" class="" readonly="readonly"/><input type="hidden" id="hidTipoEmpaque'.$f.'" name="hidTipoEmpaque[]" value=""  /></td>
								<td width="32%"><span class="req">*</span>';
					/*if ($mobile_browser>0)
					{
						$html .= '<div data-role="page" id="mainPage"><p><input type="text" id="searchField'.$f.'" placeholder="Producto" style="width:85%;" class="validate[required]" value="'.$row['Descripcion'].'">
						<ul id="suggestions" data-role="listview" data-inset="true"></ul></p></div>';
					}
					else
					{*/
						$html .= '<input type="text" id="txtProducto'.$f.'" name="txtProducto[]" style="width:85%;" class="validate[required]" value="'.utf8_encode("Trabajo de Impresión").'"/>';
					//}
					
					
					$html .= '<input type="hidden" id="hidIdProducto'.$f.'" name="hidIdProducto[]" value="timpart"  /><input type="hidden" id="hidDescProducto'.$f.'" name="hidDescProducto[]" value="'.utf8_encode("Trabajo de Impresión").'"  />
					<input type="hidden" id="hidIdImprenta'.$f.'" name="hidIdImprenta[]" value=""  />
					<input type="hidden" id="hidIdBanner'.$f.'" name="hidIdBanner[]" value=""  />
					<input type="hidden" id="hidIdImpresion'.$f.'" name="hidIdImpresion[]" value=""  /></td>					
					<td width="15%"><input type="text" id="txtPrecio'.$f.'" name="txtPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidPrecio'.$f.'" name="hidPrecio[]" value="'.number_format($row['precio_venta'],2,'.','').'"  /></td>
					<td width="15%"><input type="text" id="txtTotal'.$f.'" name="txtTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'" style="width:80%;text-align:right;"  class=""  readonly="readonly"/><input type="hidden" id="hidTotal'.$f.'" name="hidTotal[]" value="'.number_format($row['cantidad']*$row['precio_venta'],2,'.','').'"  /></td>
					<td width="8%"><a href="javascript:void(0);" title="Eliminar" class="smallButton" style="margin: 5px;" onclick="if(confirm(\'Realmente quieres eliminar este Artículo?\')){Eliminar_Articulo('.$f.')}"><img src="public/images/icons/light/close.png" alt="" class="icon" /><span></span></a>
					
					<input type="hidden" id="hdnDescripcionImprenta'.$f.'" name="hdnDescripcionImprenta[]" value="" />
					<input type="hidden" id="hdnPapelTipo'.$f.'" name="hdnPapelTipo[]" value="" />
					<input type="hidden" id="hdnMaterialPapelTipo'.$f.'" name="hdnMaterialPapelTipo[]" value="" />
					<input type="hidden" id="hdnResmaTamano'.$f.'" name="hdnResmaTamano[]" value="" />
					<input type="hidden" id="hdnTamano'.$f.'" name="hdnTamano[]" value="'.$row['id_tamano'].'" />
					<input type="hidden" id="hdnCantidadCopia'.$f.'" name="hdnCantidadCopia[]" value="" />
					<input type="hidden" id="hdnColorTinta'.$f.'" name="hdnColorTinta[]" value="'.$row['id_color_tinta'].'" />
					<input type="hidden" id="hdnOtroTamanoAncho'.$f.'" name="hdnOtroTamanoAncho[]" value="'.$row['otro_ancho'].'" />
					<input type="hidden" id="hdnOtroTamanoLargo'.$f.'" name="hdnOtroTamanoLargo[]" value="'.$row['otro_largo'].'" />
					<input type="hidden" id="hdnNumeracionInicio'.$f.'" name="hdnNumeracionInicio[]" value="" />
					<input type="hidden" id="hdnNumeracionFinal'.$f.'" name="hdnNumeracionFinal[]" value="" />';
					$c = 0;
			
					while ($c <= 3)
					{
						if ($c == 0)
						$html .= '<input type="hidden" id="hdnColorPapel'.$f.'" name="hdnColorPapel[]" value="" />';					
						else
						$html .= '<input type="hidden" id="hdnColorPapel'.$c.$f.'" name="hdnColorPapel'.$c.'[]" value="" />';
				
						$c = $c + 1;
					}
					
					$html .= '<input type="hidden" id="hdnTipoForro'.$f.'" name="hdnTipoForro[]" value="" />
					<input type="hidden" id="hdnTiempo'.$f.'" name="hdnTiempo[]" value="" />
					<input type="hidden" id="hdnTipoTiempo'.$f.'" name="hdnTipoTiempo[]" value="" />
					<input type="hidden" id="hdnTipoCategoria'.$f.'" name="hdnTipoCategoria[]" value="'.$row['id_categoria'].'" />			
					
					<input type="hidden" id="hdnSinNumeracion'.$f.'" name="hdnSinNumeracion[]" value="" />
					<input type="hidden" id="hdnArte'.$f.'" name="hdnArte[]" value="" />
					<input type="hidden" id="hdnPlaca'.$f.'" name="hdnPlaca[]" value="" />
					
					<input type="hidden" id="hdnDescripcionBanner'.$f.'" name="hdnDescripcionBanner[]" value="" />
					<input type="hidden" id="hdnMaterialBanner'.$f.'" name="hdnMaterialBanner[]" value="" />
					<input type="hidden" id="hdnAncho'.$f.'" name="hdnAncho[]" value="'.number_format($row['arte_ancho'],2,'.','').'" />
					<input type="hidden" id="hdnAnchoMedida'.$f.'" name="hdnAnchoMedida[]" value="'.$row['arte_ancho_medida'].'" />
					<input type="hidden" id="hdnLargo'.$f.'" name="hdnLargo[]" value="'.number_format($row['arte_largo'],2,'.','').'" />
					<input type="hidden" id="hdnLargoMedida'.$f.'" name="hdnLargoMedida[]" value="'.$row['arte_largo_medida'].'" />
					<input type="hidden" id="hdnAreaTotal'.$f.'" name="hdnAreaTotal[]" value="'.number_format($row['arte_area_total'],2,'.','').'" />
					<input type="hidden" id="hdnFormaPago'.$f.'" name="hdnFormaPago[]" value="" />
					<input type="hidden" id="hdnCalidadBanner'.$f.'" name="hdnCalidadBanner[]" value="" />
					<input type="hidden" id="hdnPrecioInstalacion'.$f.'" name="hdnPrecioInstalacion[]" value="" />
					<input type="hidden" id="hdnPrecioRecorte'.$f.'" name="hdnPrecioRecorte[]" value="" />	
					<input type="hidden" id="hdnPrecioArte'.$f.'" name="hdnPrecioArte[]" value="'.number_format($row['precio_arte'],2,'.','').'" />
					<input type="hidden" id="hdnPrecioRotulado'.$f.'" name="hdnPrecioRotulado[]" value="" />
					<input type="hidden" id="hdnPrecioBasta'.$f.'" name="hdnPrecioBasta[]" value="" />
					<input type="hidden" id="hdnPrecioOjete'.$f.'" name="hdnPrecioOjete[]" value="" />
					<input type="hidden" id="hdnPrecioBulcaniza'.$f.'" name="hdnPrecioBulcaniza[]" value=""  />
					
					<input type="hidden" id="hdnDescripcionImpresion'.$f.'" name="hdnDescripcionImpresion[]" value="'.$row['Descripcion'].'" />
					<input type="hidden" id="hdnMaterialImpresion'.$f.'" name="hdnMaterialImpresion[]" value="'.$row['id_material'].'" />
					<input type="hidden" id="hdnRecorte'.$f.'" name="hdnRecorte[]" value="'.number_format($row['recorte'],2,'.','').'" />
					<input type="hidden" id="hdnPlastificado'.$f.'" name="hdnPlastificado[]" value="'.number_format($row['plastificado'],2,'.','').'" />
					<input type="hidden" id="hdnCaminado'.$f.'" name="hdnCaminado[]" value="'.number_format($row['caminado'],2,'.','').'" />
					<input type="hidden" id="hdnRealce'.$f.'" name="hdnRealce[]" value="'.number_format($row['realce'],2,'.','').'" />					
					<input type="hidden" id="hdnDoblado'.$f.'" name="hdnDoblado[]" value="'.number_format($row['doblado'],2,'.','').'" />
					<input type="hidden" id="hdnRepujado'.$f.'" name="hdnRepujado[]" value="'.number_format($row['repujado'],2,'.','').'" />
					<input type="hidden" id="hdnEngrapado'.$f.'" name="hdnEngrapado[]" value="'.number_format($row['engrapado'],2,'.','').'" />
					<input type="hidden" id="hdnUV'.$f.'" name="hdnUV[]" value="'.number_format($row['UV'],2,'.','').'" />	
					<input type="hidden" id="hdnCantPliego'.$f.'" name="hdnCantPliego[]" value="'.number_format($row['cantidad_pliego'],0,'.','').'" />
					<input type="hidden" id="hdnAjustarTamano'.$f.'" name="hdnAjustarTamano[]" value="'.number_format($row['ajustar_tamano'],0,'.','').'" />
					
					<input type="hidden" id="hdnExentoITBM'.$f.'" name="hdnExentoITBM[]" value="'.$row['exento_itbm'].'"  />					
					<input type="hidden" id="hdnNotaCotizacion'.$f.'" name="hdnNotaCotizacion[]" value="'.utf8_encode($row['observacion']).'"  />

					<input type="hidden" id="hdnIdCampos_'.$f.'" name="hdnIdCampos[]" value="'.$f.'" /></td>
					</tr>
					<tr><td colspan "6"><a href="javascript:void(0)" onclick="Mostrar_Detalles('.$f.',\'timpart\')" >Ver detalle</a></td></tr>
					</table></td>
					</tr>';			
				
				}
				
				$f = $f + 1;
			}
		}
		//echo "prueba";

		echo $html;
	}
	
	if($_GET['action'] == 'Buscar_Monto_Total_Cotizaciones_Anteriores')
	{
	
		$html = "";	
	
		$Id_Cotizacion	= strip_tags(utf8_decode(strtolower($_POST['idCotizacion'])));
		
		try
		{

			$stmt = $db->prepare("SELECT monto_subtotal,monto_itbm,monto_total FROM cotizaciones WHERE MD5(id_cotizaciones) = ?");			
			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
		
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
			
		
			$f = 1;
			foreach ($rows as $row)
			{
				$html = '<tr id="rowSubTotal"  valign="center"  >
							<td  align="right" colspan="5">Sub-Total:</td>
							<td align="center" ><input type="text" id="txtSubTotal" name="txtSubTotal" style="width:80%;text-align:right;" value="'.number_format($row['monto_subtotal'],2,'.','').'"  readonly="readonly"/><input type="hidden" id="hidSubTotal" name="hidSubTotal" value="'.number_format($row['monto_subtotal'],2,'.','').'"   /></td>
							<td  align="center"></td>
						</tr>
						<tr id="rowTotalITBM"  valign="center"  >
							<td  align="right" colspan="5">ITBM:</td>
							<td align="center" ><input type="text" id="txtTotalITBM" name="txtTotalITBM" style="width:80%;text-align:right;" value="'.number_format($row['monto_itbm'],2,'.','').'"  readonly="readonly"/><input type="hidden" id="hidTotalITBM" name="hidTotalITBM" value="'.number_format($row['monto_itbm'],2,'.','').'"   /></td>
							<td  align="center"></td>
						</tr>
						<tr id="rowTotal"  valign="center"  >
							<td  align="right" colspan="5">Total Final:</td>
							<td align="center" ><input type="text" id="txtTotalFinal" name="txtTotalFinal" style="width:80%;text-align:right;" value="'.number_format($row['monto_total'],2,'.','').'"  readonly="readonly"/><input type="hidden" id="hidTotalFinal" name="hidTotalFinal" value="'.number_format($row['monto_total'],2,'.','').'"   /></td>
							<td  align="center"></td>
						</tr>';				
			
			
			
			}
			
		}
		
		echo $html;			

	}
	
	if($_GET['action'] == 'Listar_Cliente_Autocompletar')
	{

		$html = "";
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		if(isset($_GET["search"]))		
		$criterio = strtolower($_GET["search"]);
		
		if (!$criterio) return;
		
		try
		{		

			$stmt = $db->prepare("SELECT id_cliente, CONCAT(nombre,' ',apellido) AS value, '1' as id_tipo_cliente
			FROM cliente_persona WHERE CONCAT(nombre,' ',apellido) LIKE '".$criterio."%'
			UNION
			SELECT id_cliente, nombre_empresa AS value, '2' as id_tipo_cliente
			FROM cliente_empresa WHERE nombre_empresa LIKE '".$criterio."%'");

				//			WHERE descripcion_producto like '".mysql_real_escape_string(strip_tags(utf8_decode($criterio)))."%'");		
			//$c = 1;
			//$stmt->bindParam($c,$criterio,PDO::PARAM_STR,255);
			
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
			$Nombre_Cliente = array();
			foreach ($rows as $row)
			{

				$Nombre_Cliente[$c]['value'] = utf8_encode($row['value']);
				$Nombre_Cliente[$c]['hidIdCliente'] = utf8_encode($row['id_cliente']);
				$Nombre_Cliente[$c]['hidIdTipoCliente'] = utf8_encode($row['id_tipo_cliente']);
				
				$c++;
			}
		}
		
		$html = json_encode($Nombre_Cliente);
		
		echo $html;		
	
	}

	
	if($_GET['action'] == 'Imprimir_Cotizacion')
	{

	
		include('../../library/Generar_Cotizacion.php');

		$objGenerarCotizacion =  new Generar_Cotizacion();

		$Id_Cotizacion	= strip_tags(utf8_decode($_POST['id']));	
		//echo mysql_error($conexion);

		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,descripcion_estatus,monto_subtotal,monto_itbm,monto_total,fecha_creado
			FROM cotizaciones co INNER JOIN tipo_estatus_cotizacion te ON (te.id_estatus = co.id_estatus) WHERE MD5(id_cotizaciones) = ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
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
			$stmt = $db->prepare("SELECT * FROM cotizacion_producto WHERE MD5(id_cotizacion) = ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
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
				
				if ($row['id_producto'] > 0)
				{
					$Id_Producto = $row['id_producto'];
					try
					{		
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
				
					$Nombre_Producto[$c] = utf8_encode($rows3[0]['nombre_producto']);
					$Precio[$c] = $rows3[0]['precio_venta'];
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
				}
				else if ($row['id_imprenta'] > 0)
				{
					/*if ($row['id_factura'] > 0)
					{
						$Nombre_Producto[$c] = "Libreta Factura";
						$Id_imprenta = $row['id_libreta'];						
					}
					else if ($row['id_libreta'] > 0)
					{
						$Nombre_Producto[$c] = "Libreta";
						$Id_imprenta = $row['id_libreta'];
					}*/
					
					$Id_imprenta = $row['id_imprenta'];
					
					
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM imprenta lb
						INNER JOIN imprenta_tipo_papel lbtp ON (lbtp.id_tipo_papel = lb.id_tipo_papel)
						INNER JOIN imprenta_tipo_material lbm ON (lb.id_tipo_material = lbm.id_tipo_material)
						LEFT JOIN imprenta_tamano_papel lbt ON (lbt.id_tamano_papel = lb.id_tamano)
						INNER JOIN imprenta_color_tinta lbct ON (lbct.id_color = lb.id_color_tinta)
						INNER JOIN imprenta_tipo_forro lbtf ON (lbtf.id_forro = lb.id_forro)
						WHERE id_imprenta = ?");

						$p = 1;
						$stmt->bindParam($p,$Id_imprenta,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas3 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					

					//echo $rows3[0]['descripcion_imprenta'];
					
					$Nombre_Producto[$c] = $rows3[0]['descripcion_imprenta'];					
					$Precio[$c] = $rows3[0]['precio_venta'];
					$Tipo_Empaque[$c] = "";
					/*$PapelTipo[$c] = $rows3[0]['descripcion_papel'];
					$Tamano[$c] = $rows3[0]['descripcion_tamano'];
					$CantidadCopia[$c] = $rows3[0]['cant_copia'];
					$ColorTinta[$c] = $rows3[0]['descripcion_color'];
					$TipoForro[$c] = $rows3[0]['descripcion_forro'];
					$IdColorPapel[0] = $rows3[0]['id_color_papel'];
					$IdColorPapel[1] = $rows3[0]['id_color_papel1'];
					$IdColorPapel[2] = $rows3[0]['id_color_papel2'];
					$IdColorPapel[3] = $rows3[0]['id_color_papel3'];
					$IdTipoTiempo = $rows3[0]['id_tipo_tiempo'];
					$TipoCategoria = $rows3[0]['id_categoria'];
					$ColorPapel[$c] = "";
					$ColorPapel1[$c] = "";
					$ColorPapel2[$c] = "";
					$ColorPapel3[$c] = "";					
					
					$cp = 0;
					while ($cp < $CantidadCopia[$c])
					{
					
						try
						{		
							$stmt = $db->prepare("SELECT * FROM imprenta_color_papel WHERE id_color = ?");

							$p = 1;
							$stmt->bindParam($p,$IdColorPapel[$cp],PDO::PARAM_INT);
			
							$stmt->execute();
							$rows4[$cp] = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas4[$cp] = $stmt->rowCount();
							$stmt->closeCursor();
						
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}					
						
						if ($cp == 0)
						{
							$ColorPapel[$c] = $rows4[$cp][0]['descripcion_color'];
						}
						else if ($cp == 1)
						{
							$ColorPapel1[$c] = $rows4[$cp][0]['descripcion_color'];
						}
						else if ($cp == 2)
						{
							$ColorPapel2[$c] = $rows4[$cp][0]['descripcion_color'];
						}						
						else if ($cp == 3)
						{
							$ColorPapel3[$c] = $rows4[$cp][0]['descripcion_color'];
						}					
					
					
						$cp = $cp + 1;
					}
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM imprenta_tipo_costo WHERE id_tipo_costo = ?");

						$p = 1;
						$stmt->bindParam($p,$IdTipoTiempo,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows5 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas5 = $stmt->rowCount();
						$stmt->closeCursor();
						
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}

					$TipoTiempo[$c] = $rows5[0]['descripcion_costo'];				
*/
				}
				else if ($row['id_banner'] > 0)
				{
					/*if ($row['id_factura'] > 0)
					{
						$Nombre_Producto[$c] = "Libreta Factura";
						$Id_imprenta = $row['id_libreta'];						
					}
					else if ($row['id_libreta'] > 0)
					{
						$Nombre_Producto[$c] = "Libreta";
						$Id_imprenta = $row['id_libreta'];
					}*/
					
					$Id_Banner = $row['id_banner'];
					
					
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM banner bnr
						INNER JOIN banner_material bnrm ON (bnrm.id_material = bnr.id_material)
						LEFT JOIN tipo_unidad tu ON (tu.id_unidad = bnr.id_medida_ancho)
						AND (tu.id_unidad = bnr.id_medida_largo)
						INNER JOIN banner_forma_pago bnrf ON (bnrf.id_forma_pago = bnr.id_forma_pago)
						INNER JOIN banner_calidad bnrc ON (bnrc.id_calidad = bnr.id_calidad)
						WHERE id_banner = ?");

						$p = 1;
						$stmt->bindParam($p,$Id_Banner,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas3 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					

					//echo $rows3[0]['descripcion_imprenta'];
					
					$Nombre_Producto[$c] = $rows3[0]['descripcion_banner'];					
					$Precio[$c] = $rows3[0]['precio_venta'];
					$Tipo_Empaque[$c] = "";
					/*$PapelTipo[$c] = $rows3[0]['descripcion_papel'];
					$Tamano[$c] = $rows3[0]['descripcion_tamano'];
					$CantidadCopia[$c] = $rows3[0]['cant_copia'];
					$ColorTinta[$c] = $rows3[0]['descripcion_color'];
					$TipoForro[$c] = $rows3[0]['descripcion_forro'];
					$IdColorPapel[0] = $rows3[0]['id_color_papel'];
					$IdColorPapel[1] = $rows3[0]['id_color_papel1'];
					$IdColorPapel[2] = $rows3[0]['id_color_papel2'];
					$IdColorPapel[3] = $rows3[0]['id_color_papel3'];
					$IdTipoTiempo = $rows3[0]['id_tipo_tiempo'];
					$TipoCategoria = $rows3[0]['id_categoria'];
					$ColorPapel[$c] = "";
					$ColorPapel1[$c] = "";
					$ColorPapel2[$c] = "";
					$ColorPapel3[$c] = "";					
					
					$cp = 0;
					while ($cp < $CantidadCopia[$c])
					{
					
						try
						{		
							$stmt = $db->prepare("SELECT * FROM imprenta_color_papel WHERE id_color = ?");

							$p = 1;
							$stmt->bindParam($p,$IdColorPapel[$cp],PDO::PARAM_INT);
			
							$stmt->execute();
							$rows4[$cp] = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas4[$cp] = $stmt->rowCount();
							$stmt->closeCursor();
						
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}					
						
						if ($cp == 0)
						{
							$ColorPapel[$c] = $rows4[$cp][0]['descripcion_color'];
						}
						else if ($cp == 1)
						{
							$ColorPapel1[$c] = $rows4[$cp][0]['descripcion_color'];
						}
						else if ($cp == 2)
						{
							$ColorPapel2[$c] = $rows4[$cp][0]['descripcion_color'];
						}						
						else if ($cp == 3)
						{
							$ColorPapel3[$c] = $rows4[$cp][0]['descripcion_color'];
						}					
					
					
						$cp = $cp + 1;
					}
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM imprenta_tipo_costo WHERE id_tipo_costo = ?");

						$p = 1;
						$stmt->bindParam($p,$IdTipoTiempo,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows5 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas5 = $stmt->rowCount();
						$stmt->closeCursor();
						
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}

					$TipoTiempo[$c] = $rows5[0]['descripcion_costo'];				
*/
				}
				else if ($row['id_impresion'] > 0)
				{
					
					$Id_Impresion = $row['id_impresion'];
					
					
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM impresion imp
						INNER JOIN impresion_material impma ON (impma.id_material = imp.id_material)
						INNER JOIN tipo_unidad tu ON (tu.id_unidad = imp.arte_ancho_medida)
						AND (tu.id_unidad = imp.arte_largo_medida)
						INNER JOIN impresion_tamano_pliego imptp ON (imptp.id_tamano = imp.id_tamano)
						INNER JOIN impresion_color_tinta impct ON (impct.id_color = imp.id_color_tinta)
						WHERE id_impresion = ?");

						$p = 1;
						$stmt->bindParam($p,$Id_Impresion,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas4 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					

					//echo $rows3[0]['descripcion_imprenta'];
					
					$Nombre_Producto[$c] = $rows4[0]['descripcion_impresion'];					
					$Precio[$c] = $rows4[0]['precio_venta'];
					$Tipo_Empaque[$c] = "";
				}
				
				$c = $c + 1;
			}
		
		}
		
		
				$mensaje[0] = $rows[0]['id_cotizaciones'];
				$mensaje[1] = $rows1[0]['Nombre_Cliente'];
				$mensaje[2] = $rows1[0]['direccion'];
				$mensaje[3] = $rows1[0]['ruc_parte_1']."-".$rows1[0]['ruc_parte_2']."-".$rows1[0]['ruc_parte_3'];
				$mensaje[4] = $rows[0]['monto_subtotal'];			
				$mensaje[5] = $rows[0]['monto_itbm'];			
				$mensaje[6] = $rows[0]['monto_total'];
				$FechaCreado = $rows[0]['fecha_creado'];
				

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

				$hoy=date('Y-m-d',strtotime($FechaCreado));
				$desde=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy)),date("Y", strtotime($hoy))));
				$hasta=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy))+30,date("Y", strtotime($hoy))));					
				
				$objGenerarCotizacion->Generar_Cotizacion_Imprenta($desde, $hasta, $mensaje);
				
				echo 'tmp/Cotizacion_Innovations_Print_'.$mensaje[0].'_'.$desde.'.pdf';

	}


	

	
	if($_GET['action'] == 'Imprimir_Detalle_Venta')
	{

	
		include('../../library/Generar_Detalle_Venta.php');

		$objGenerarDetalleVenta =  new Generar_Detalle_Venta();

		$Id_Cotizacion	= strip_tags(utf8_decode($_POST['id']));	
		//echo mysql_error($conexion);

		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,descripcion_estatus,monto_subtotal,monto_itbm,monto_total,fecha_creado
			FROM cotizaciones co INNER JOIN tipo_estatus_cotizacion te ON (te.id_estatus = co.id_estatus) WHERE MD5(id_cotizaciones) = ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
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
			$stmt = $db->prepare("SELECT * FROM cotizacion_producto WHERE MD5(id_cotizacion) = ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas2 = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}		
		
		
		$mensaje[0] = $rows[0]['id_cotizaciones'];
		$mensaje[1] = utf8_encode($rows1[0]['Nombre_Cliente']);
		$mensaje[2] = utf8_encode($rows1[0]['direccion']);

		if ( isset($rows1[0]['ruc_parte_1']) && isset($rows1[0]['ruc_parte_2']) && isset($rows1[0]['ruc_parte_3'])) {
			$mensaje[3] = $rows1[0]['ruc_parte_1']."-".$rows1[0]['ruc_parte_2']."-".$rows1[0]['ruc_parte_3'];
		}
		
		$mensaje[4] = $rows[0]['monto_subtotal'];			
		$mensaje[5] = $rows[0]['monto_itbm'];			
		$mensaje[6] = $rows[0]['monto_total'];
		$FechaCreado = $rows[0]['fecha_creado'];
		if ( isset($rows1[0]['dv']) ) {$mensaje[48] = $rows1[0]['dv'];}
			
		//$mensaje[7] = $rows2[0]['cantidad'];
			
		
		if ($nfilas2 > 0)
		{
			$c = 0;
			foreach ($rows2 as $row)
			{			
				$Cantidad[$c] = $row['cantidad'];
				
				if ($row['id_producto'] > 0)
				{
					$Id_Producto = $row['id_producto'];
					try
					{		
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
				
					$Nombre_Producto[$c] = utf8_encode($rows3[0]['nombre_producto']);
					$Precio[$c] = $rows3[0]['precio_venta'];
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
					$Numeracion_Inicial[$c] = "";
					$Numeracion_Final[$c] = "";					
					$TipoCategoria[$c] = "";
					$Material_Banner[$c] = "";
					$Ancho[$c] = "";
					$Ancho_Medida[$c] = "";
					$Largo[$c] = "";
					$Largo_Medida[$c] = "";
					$Area_Total[$c] = "";
					$Forma_Pago[$c] = "";
					$Calidad[$c] = "";
					$precio_instalacion[$c] = "";
					$precio_recorte[$c] = "";
					$precio_arte[$c] = "";
					$precio_rotulado[$c] = "";
					$precio_basta[$c] = "";
					$precio_ojetes[$c] = "";
					$precio_bulcaniza[$c] = "";
					$precio_venta[$c] = "";	
					$tipo_producto[$c] = "";
					$Material_Impresion[$c] = "";
					$recorte[$c]  = "";
					$plastificado[$c]  ="";
					$caminado[$c]  = "";
					$realce[$c]  = "";
					$doblado[$c]  = "";
					$repujado[$c]  = "";
					$engrapado[$c]  = "";
					$uv[$c]  = "";
					
				}
				else if ($row['id_imprenta'] > 0)
				{
					
					$Id_imprenta = $row['id_imprenta'];
					
					
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM imprenta lb
						INNER JOIN imprenta_tipo_papel lbtp ON (lbtp.id_tipo_papel = lb.id_tipo_papel)
						INNER JOIN imprenta_tipo_material lbm ON (lb.id_tipo_material = lbm.id_tipo_material)
						LEFT JOIN imprenta_tamano_papel lbt ON (lbt.id_tamano_papel = lb.id_tamano)
						INNER JOIN imprenta_color_tinta lbct ON (lbct.id_color = lb.id_color_tinta)
						INNER JOIN imprenta_tipo_forro lbtf ON (lbtf.id_forro = lb.id_forro)
						WHERE id_imprenta = ?");

						$p = 1;
						$stmt->bindParam($p,$Id_imprenta,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas4 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					

					//echo $rows3[0]['descripcion_imprenta'];
					
					$Nombre_Producto[$c] = utf8_encode($rows4[0]['descripcion_imprenta']);					
					$Precio[$c] = $rows4[0]['precio_venta'];
					$Tipo_Empaque[$c] = "";
					
					$PapelTipo[$c] = $rows4[0]['descripcion_papel'];
					$Tamano[$c] = $rows4[0]['descripcion_tamano'];
					$Otro_Ancho[$c] = $rows4[0]['otro_ancho'];
					$Otro_Largo[$c] = $rows4[0]['otro_largo'];
					$CantidadCopia[$c] = $rows4[0]['cant_copia'];
					$ColorTinta[$c] = $rows4[0]['descripcion_color'];
					$TipoForro[$c] = $rows4[0]['descripcion_forro'];
					$IdColorPapel[0] = $rows4[0]['id_color_papel'];
					$IdColorPapel[1] = $rows4[0]['id_color_papel1'];
					$IdColorPapel[2] = $rows4[0]['id_color_papel2'];
					$IdColorPapel[3] = $rows4[0]['id_color_papel3'];
					$IdTipoTiempo = $rows4[0]['id_tipo_tiempo'];
					$Numeracion_Inicial[$c] = $rows4[0]['numeracion_inicial'];
					$Numeracion_Final[$c] = $rows4[0]['numeracion_final'];					
					$TipoCategoria[$c] = $rows4[0]['id_categoria'];
					$ColorPapel[$c] = "";
					$ColorPapel1[$c] = "";
					$ColorPapel2[$c] = "";
					$ColorPapel3[$c] = "";					
					
					$cp = 0;
					while ($cp < $CantidadCopia[$c])
					{
					
						try
						{		
							$stmt = $db->prepare("SELECT * FROM imprenta_color_papel WHERE id_color = ?");

							$p = 1;
							$stmt->bindParam($p,$IdColorPapel[$cp],PDO::PARAM_INT);
			
							$stmt->execute();
							$rows5[$cp] = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas5[$cp] = $stmt->rowCount();
							$stmt->closeCursor();
						
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}					
						
						if ($cp == 0)
						{
							$ColorPapel[$c] = $rows5[$cp][0]['descripcion_color'];
						}
						else if ($cp == 1)
						{
							$ColorPapel1[$c] = $rows5[$cp][0]['descripcion_color'];
						}
						else if ($cp == 2)
						{
							$ColorPapel2[$c] = $rows5[$cp][0]['descripcion_color'];
						}						
						else if ($cp == 3)
						{
							$ColorPapel3[$c] = $rows5[$cp][0]['descripcion_color'];
						}					
					
					
						$cp = $cp + 1;
					}
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM imprenta_tipo_costo WHERE id_tipo_costo = ?");

						$p = 1;
						$stmt->bindParam($p,$IdTipoTiempo,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows6 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas6 = $stmt->rowCount();
						$stmt->closeCursor();
						
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}

					$TipoTiempo[$c] = $rows6[0]['descripcion_costo'];				
					$Material_Banner[$c] = "";
					$Ancho[$c] = "";
					$Ancho_Medida[$c] = "";
					$Largo[$c] = "";
					$Largo_Medida[$c] = "";
					$Area_Total[$c] = "";
					$Forma_Pago[$c] = "";
					$Calidad[$c] = "";
					$precio_instalacion[$c] = "";
					$precio_recorte[$c] = "";
					$precio_arte[$c] = "";
					$precio_rotulado[$c] = "";
					$precio_basta[$c] = "";
					$precio_ojetes[$c] = "";
					$precio_bulcaniza[$c] = "";
					$precio_venta[$c] = "";
					$Material_Impresion[$c] = "";
					$recorte[$c]  = "";
					$plastificado[$c]  ="";
					$caminado[$c]  = "";
					$realce[$c]  = "";
					$doblado[$c]  = "";
					$repujado[$c]  = "";
					$engrapado[$c]  = "";
					$uv[$c]  = "";
					$tipo_producto[$c] = "imprenta";

				}
				else if ($row['id_banner'] > 0)
				{
					
					$Id_Banner = $row['id_banner'];
					
					
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM banner bnr
						INNER JOIN banner_material bnrm ON (bnrm.id_material = bnr.id_material)
						INNER JOIN banner_forma_pago bnrf ON (bnrf.id_forma_pago = bnr.id_forma_pago)
						INNER JOIN banner_calidad bnrc ON (bnrc.id_calidad = bnr.id_calidad)
						WHERE id_banner = ?");

						$p = 1;
						$stmt->bindParam($p,$Id_Banner,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows7 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas7 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					

					//echo $rows3[0]['descripcion_imprenta'];
					
					$Nombre_Producto[$c] = utf8_encode($rows7[0]['descripcion_banner']);					
					$Precio[$c] = $rows7[0]['precio_venta'];
					$Tipo_Empaque[$c] = "";
					$Material_Banner[$c] = $rows7[0]['descripcion_material'];
					$Ancho[$c] = $rows7[0]['ancho'];
					$Id_Ancho_Medida[$c] = $rows7[0]['id_medida_ancho'];
					$Largo[$c] = $rows7[0]['largo'];
					$Id_Largo_Medida[$c] = $rows7[0]['id_medida_largo'];
					$Area_Total[$c] = $rows7[0]['area_total'];
					$Forma_Pago[$c] = $rows7[0]['descripcion_forma_pago'];
					$Calidad[$c] = $rows7[0]['descripcion_calidad'];
					$precio_instalacion[$c] = $rows7[0]['precio_instalacion'];
					$precio_recorte[$c] = $rows7[0]['precio_recorte'];
					$precio_arte[$c] = $rows7[0]['precio_arte'];
					$precio_rotulado[$c] = $rows7[0]['precio_rotulado'];
					$precio_basta[$c] = $rows7[0]['precio_basta'];
					$precio_ojetes[$c] = $rows7[0]['precio_ojetes'];
					$precio_bulcaniza[$c] = $rows7[0]['precio_bulcaniza'];
					$precio_venta[$c] = $rows7[0]['precio_venta'];			
					$PapelTipo[$c] = "";
					$Tamano[$c] = "";
					$Otro_Ancho[$c] = "";
					$Otro_Largo[$c] = "";					
					$CantidadCopia[$c] = "";
					$ColorTinta[$c] = "";
					$TipoForro[$c] = "";
					$ColorPapel[$c] = "";
					$ColorPapel1[$c] = "";
					$ColorPapel2[$c] = "";
					$ColorPapel3[$c] = "";					
					$TipoTiempo[$c] = "";
					$TipoCategoria[$c] = "";
					$Numeracion_Inicial[$c] = "";
					$Numeracion_Final[$c] = "";	
					$Material_Impresion[$c] = "";
					$recorte[$c]  = "";
					$plastificado[$c]  ="";
					$caminado[$c]  = "";
					$realce[$c]  = "";
					$doblado[$c]  = "";
					$repujado[$c]  = "";
					$engrapado[$c]  = "";
					$uv[$c]  = "";					
					$tipo_producto[$c] = "banner";
					
					$d = 0;
					while ($d < 2)
					{
						try
						{		
							$stmt = $db->prepare("SELECT * FROM tipo_unidad WHERE id_unidad = ?");

							$p = 1;
							if ($d == 0)
							$stmt->bindParam($p,$Id_Ancho_Medida[$c],PDO::PARAM_INT);
							else if ($d == 1)
							$stmt->bindParam($p,$Id_Largo_Medida[$c],PDO::PARAM_INT);
			
							$stmt->execute();
							$rows8[$d] = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas8[$d] = $stmt->rowCount();
							$stmt->closeCursor();
						
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}
						
						if ($d == 0)						
						$Ancho_Medida[$c] = $rows8[0]['descripcion_unidad'];
						else if ($d == 1)
						$Largo_Medida[$c] = $rows8[0]['descripcion_unidad'];
						
						$d = $d + 1;
					}
				}
				else if ($row['id_impresion'] > 0)
				{					

					$Id_Impresion = $row['id_impresion'];
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM impresion imp
						INNER JOIN impresion_material impma ON (impma.id_material = imp.id_material)
						INNER JOIN impresion_tamano_pliego imptp ON (imptp.id_tamano = imp.id_tamano)
						INNER JOIN impresion_color_tinta impct ON (impct.id_color = imp.id_color_tinta)
						WHERE id_impresion = ?");

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

					$Nombre_Producto[$c] = utf8_encode($rows9[0]['descripcion_impresion']);					
					$Precio[$c] = $rows9[0]['precio_venta'];
					$Tipo_Empaque[$c] = "";
					$Material_Banner[$c] = "";
					$Ancho[$c] = $rows9[0]['arte_ancho'];
					$Id_Ancho_Medida[$c] = $rows9[0]['arte_medida_ancho'];
					$Largo[$c] = $rows9[0]['arte_largo'];
					$Id_Largo_Medida[$c] = $rows9[0]['arte_medida_largo'];
					$Area_Total[$c] = $rows9[0]['area_total'];
					$Forma_Pago[$c] = "";
					$Calidad[$c] = "";
					$precio_instalacion[$c] = "";
					$precio_recorte[$c] = "";
					$precio_arte[$c] = $rows9[0]['precio_arte'];
					$precio_rotulado[$c] = "";
					$precio_basta[$c] = "";
					$precio_ojetes[$c] = "";
					$precio_bulcaniza[$c] = "";
					$precio_venta[$c] = $rows9[0]['precio_venta'];			
					$PapelTipo[$c] = "";
					$Tamano[$c] = $rows9[0]['id_tamano'];	
					$Otro_Ancho[$c] = $rows9[0]['otro_ancho'];
					$Otro_Largo[$c] = $rows9[0]['otro_largo'];					
					$CantidadCopia[$c] = "";
					$ColorTinta[$c] = $rows9[0]['descripcion_color'];
					$TipoForro[$c] = "";
					$ColorPapel[$c] = "";
					$ColorPapel1[$c] = "";
					$ColorPapel2[$c] = "";
					$ColorPapel3[$c] = "";					
					$TipoTiempo[$c] = "";
					$TipoCategoria[$c] = $rows9[0]['id_categoria'];
					$Numeracion_Inicial[$c] = "";
					$Numeracion_Final[$c] = "";
					$Material_Impresion[$c] = $rows9[0]['descripcion_material'];
					$recorte[$c]  = $rows9[0]['recorte'];
					$plastificado[$c]  = $rows9[0]['plastificado'];
					$caminado[$c]  = $rows9[0]['caminado'];
					$realce[$c]  = $rows9[0]['realce'];
					$doblado[$c]  = $rows9[0]['doblado'];
					$repujado[$c]  = $rows9[0]['repujado'];
					$engrapado[$c]  = $rows9[0]['engrapado'];
					$uv[$c]  = $rows9[0]['uv'];					
					$tipo_producto[$c] = "impresion";

					$d = 0;
					while ($d < 2)
					{
						try
						{		
							$stmt = $db->prepare("SELECT * FROM tipo_unidad WHERE id_unidad = ?");

							$p = 1;
							if ($d == 0)
							$stmt->bindParam($p,$Id_Ancho_Medida[$c],PDO::PARAM_INT);
							else if ($d == 1)
							$stmt->bindParam($p,$Id_Largo_Medida[$c],PDO::PARAM_INT);
			
							$stmt->execute();
							$rows10[$d] = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas10[$d] = $stmt->rowCount();
							$stmt->closeCursor();
						
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}
						
						if ($d == 0)						
						$Ancho_Medida[$c] = $rows10[0]['descripcion_unidad'];
						else if ($d == 1)
						$Largo_Medida[$c] = $rows10[0]['descripcion_unidad'];
						
						$d = $d + 1;
					}					
				}
				
				$c = $c + 1;
			}
		
		}
		
		$mensaje[7] = $Cantidad;		
		$mensaje[8] = $Nombre_Producto;
		$mensaje[9] = $Tipo_Empaque;				
		$mensaje[10] = $Precio;
		$mensaje[11] = $tipo_producto;		
		$mensaje[12] = $PapelTipo;		
		$mensaje[13] = $Tamano;
		$mensaje[14] = $CantidadCopia;
		$mensaje[15] = $ColorTinta;
		$mensaje[16] = $TipoForro;
		$mensaje[17] = $ColorPapel;				
		$mensaje[18] = $ColorPapel1;
		$mensaje[19] = $ColorPapel2;		
		$mensaje[20] = $ColorPapel3;
		$mensaje[21] = $TipoTiempo;
		$mensaje[22] = $Material_Banner;
		$mensaje[23] = $Ancho;
		$mensaje[24] = $Ancho_Medida;
		$mensaje[25] = $Largo;
		$mensaje[26] = $Largo_Medida;
		$mensaje[27] = $Area_Total;				
		$mensaje[28] = $Forma_Pago;
		$mensaje[29] = $Calidad;		
		$mensaje[30] = $precio_instalacion;
		$mensaje[31] = $precio_recorte;		
		$mensaje[32] = $precio_arte;
		$mensaje[33] = $precio_rotulado;		
		$mensaje[34] = $precio_basta;
		$mensaje[35] = $precio_ojetes;
		$mensaje[36] = $precio_bulcaniza;
		$mensaje[37] = $precio_venta;
		$mensaje[38] = $recorte;
		$mensaje[39] = $plastificado;
		$mensaje[40] = $caminado;
		$mensaje[41] = $realce;
		$mensaje[42] = $doblado;
		$mensaje[43] = $repujado;
		$mensaje[44] = $engrapado;
		$mensaje[45] = $uv;
		$mensaje[46] = $Otro_Ancho;
		$mensaje[47] = $Otro_Largo;
		
			
	
		$hoy=date('Y-m-d',strtotime($FechaCreado));
		$desde=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy)),date("Y", strtotime($hoy))));
		$hasta=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy))+30,date("Y", strtotime($hoy))));			
		
		$objGenerarDetalleVenta->Generar_Detalle_Venta_Imprenta($desde, $hasta, $mensaje);
		
		echo 'tmp/Detalle_Venta_Innovations_Print_'.$mensaje[0].'_'.$desde.'.pdf';

	}
	
	if($_GET['action'] == 'Listar_Cotizacion_Autocompletar')
	{

		$html = "";
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		if(isset($_GET["search"]))		
		$criterio = strtolower($_GET["search"]);
		
		if (!$criterio) return;
		
		try
		{		

			$stmt = $db->prepare("SELECT id_cotizaciones, descripcion_cotizacion FROM cotizaciones
			WHERE  id_cotizaciones LIKE '".$criterio."%'");

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
		}

		$c = 0;
			
		if ($nfilas > 0)
		{
			foreach ($rows as $row)
			{
				$Numero_Cotizacion[$c]['numero_cotizacion'] = utf8_encode($row['id_cotizaciones']);
				$Numero_Cotizacion[$c]['value'] = utf8_encode($row['id_cotizaciones']." (".$row['descripcion_cotizacion'].")");
				$Numero_Cotizacion[$c]['descripcion_cotizacion'] = utf8_encode($row['descripcion_cotizacion']);
				$c++;
			}
		}
		
		$html = json_encode($Numero_Cotizacion);
		
		echo $html;		
	
	}

	if($_GET['action'] == 'Listar_Descripcion_Cotizacion_Autocompletar')
	{

		$html = "";
		
		if(isset($_GET["term"]))
		$criterio = strtolower($_GET["term"]);
		
		if(isset($_GET["search"]))		
		$criterio = strtolower($_GET["search"]);
		
		if (!$criterio) return;
		
		try
		{		

			$stmt = $db->prepare("SELECT DISTINCT descripcion_cotizacion FROM cotizaciones WHERE  descripcion_cotizacion LIKE '".$criterio."%'");

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
		}

		$c = 0;
			
		if ($nfilas > 0)
		{
			foreach ($rows as $row)
			{
				$Descripcion_Cotizacion[$c] = utf8_encode($row['descripcion_cotizacion']);
				$c++;
			}
		}
		
		$html = json_encode($Descripcion_Cotizacion);
		
		echo $html;		
	
	}
		
	if($_GET['action'] == 'Generar_Listar_Contactos')
	{	

		$html = "";
	
		$Id_Cotizacion	= strip_tags(utf8_decode($_POST['id']));
		echo $Id_Cotizacion;
		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,descripcion_estatus,monto_subtotal,monto_itbm,monto_total 
			FROM cotizaciones co INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus) WHERE MD5(id_cotizaciones) = ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		$Id_Cliente = $rows[0]['id_cliente'];
		
		if ($rows[0]['id_tipo_cliente'] == 2)
		{
			try
			{		
				$stmt = $db->prepare("SELECT * FROM cliente_empresa_contactos WHERE id_cliente_empresa = ?");
				$p = 1;
				$stmt->bindParam($p,$Id_Cliente,PDO::PARAM_STR);
			
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
				
				$html = '<table width="100%">';
				
				
				$c = 0;
				foreach ($rows as $row)
				{		

					$html .= '<tr>';
					$html .= '<td><input name="contacto[]" id="contacto'.$c.'" type="checkbox" value="'.$row['id_contacto'].'"/>&nbsp;&nbsp;'.utf8_encode($row['nombre_de_contacto']).'</td>';
					$html .= '</tr>';

		
					$c = $c + 1;
				}
				
				$html .= '</table>';				
				
			}		
			else
			{
				$html = "undefined";
			}		
		
		
		}

		
		echo $html;
	
	}
	
	if($_GET['action'] == 'Enviar_Cotizacion')
	{
		include('../../config/configuracion.php');
		include('../../library/correo.php');
	
		include('../../library/Generar_Cotizacion.php');
	
		$objGenerarCotizacion =  new Generar_Cotizacion();
		$objCorreo =  new correo();
		
		$Id_Cotizacion	= strip_tags(utf8_decode($_POST['id']));
		//$Contactos	= strip_tags(utf8_decode($_POST['contactos']));
		
		$Contactos = explode(',',$_POST['contactos']);
		//echo mysql_error($conexion);
		
		$cont = 0;
		while ($cont < count($Contactos))
		{
			try
			{			
				$stmt = $db->prepare("SELECT email_de_contacto FROM cliente_empresa_contactos WHERE id_contacto = ?");
				$p = 1;
				$stmt->bindParam($p,$Contactos[$cont],PDO::PARAM_INT);

				$stmt->execute();
				$rowsCont = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilasCont = $stmt->rowCount();
				$stmt->closeCursor();
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}			
			
			
			$P_To[$cont] = $rowsCont[0]['email_de_contacto'];
			$cont++;
		}

		try
		{		
			//$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,descripcion_estatus,monto_subtotal,monto_itbm,monto_total 
			//FROM cotizaciones co INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus) WHERE MD5(id_cotizaciones) = ?");
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,descripcion_estatus,monto_subtotal,monto_itbm,monto_total,fecha_creado
			FROM cotizaciones co INNER JOIN tipo_estatus_cotizacion te ON (te.id_estatus = co.id_estatus) WHERE MD5(id_cotizaciones) = ?");			

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
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
			$stmt = $db->prepare("SELECT * FROM cotizacion_producto WHERE MD5(id_cotizacion) = ?");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
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
				
				if ($row['id_producto'] > 0)
				{
					$Id_Producto = $row['id_producto'];
					try
					{		
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
				
					$Nombre_Producto[$c] = $rows3[0]['nombre_producto'];
					$Precio[$c] = $rows3[0]['precio_venta'];
					$Tipo_Empaque[$c] = $rows3[0]['descripcion_empaque'];
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
				}
				else if ($row['id_imprenta'] > 0)
				{
					/*if ($row['id_factura'] > 0)
					{
						$Nombre_Producto[$c] = "Libreta Factura";
						$Id_imprenta = $row['id_libreta'];						
					}
					else if ($row['id_libreta'] > 0)
					{
						$Nombre_Producto[$c] = "Libreta";
						$Id_imprenta = $row['id_libreta'];
					}*/
					
					$Id_imprenta = $row['id_imprenta'];
					
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM imprenta lb
						INNER JOIN imprenta_tipo_papel lbtp ON (lbtp.id_tipo_papel = lb.id_tipo_papel)
						INNER JOIN imprenta_tipo_material lbm ON (lb.id_tipo_material = lbm.id_tipo_material)
						LEFT JOIN imprenta_tamano_papel lbt ON (lbt.id_tamano_papel = lb.id_tamano)
						INNER JOIN imprenta_color_tinta lbct ON (lbct.id_color = lb.id_color_tinta)
						INNER JOIN imprenta_tipo_forro lbtf ON (lbtf.id_forro = lb.id_forro)
						WHERE id_imprenta = ?");

						$p = 1;
						$stmt->bindParam($p,$Id_imprenta,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas3 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					
					
					$Nombre_Producto[$c] = $rows3[0]['descripcion_imprenta'];
					$Precio[$c] = $rows3[0]['precio_venta'];
					$Tipo_Empaque[$c] = "Unidad";
					/*$PapelTipo[$c] = $rows3[0]['descripcion_papel'];
					$Tamano[$c] = $rows3[0]['descripcion_tamano'];
					$CantidadCopia[$c] = $rows3[0]['cant_copia'];
					$ColorTinta[$c] = $rows3[0]['descripcion_color'];
					$TipoForro[$c] = $rows3[0]['descripcion_forro'];
					$IdColorPapel[0] = $rows3[0]['id_color_papel'];
					$IdColorPapel[1] = $rows3[0]['id_color_papel1'];
					$IdColorPapel[2] = $rows3[0]['id_color_papel2'];
					$IdColorPapel[3] = $rows3[0]['id_color_papel3'];
					$IdTipoTiempo = $rows3[0]['id_tipo_tiempo'];
					$TipoCategoria = $rows3[0]['id_categoria'];
					$ColorPapel[$c] = "";
					$ColorPapel1[$c] = "";
					$ColorPapel2[$c] = "";
					$ColorPapel3[$c] = "";					
					
					$cp = 0;
					while ($cp < $CantidadCopia[$c])
					{
					
						try
						{		
							$stmt = $db->prepare("SELECT * FROM imprenta_color_papel WHERE id_color = ?");

							$p = 1;
							$stmt->bindParam($p,$IdColorPapel[$cp],PDO::PARAM_INT);
			
							$stmt->execute();
							$rows4[$cp] = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas4[$cp] = $stmt->rowCount();
							$stmt->closeCursor();
						
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}					
						
						if ($cp == 0)
						{
							$ColorPapel[$c] = $rows4[$cp][0]['descripcion_color'];
						}
						else if ($cp == 1)
						{
							$ColorPapel1[$c] = $rows4[$cp][0]['descripcion_color'];
						}
						else if ($cp == 2)
						{
							$ColorPapel2[$c] = $rows4[$cp][0]['descripcion_color'];
						}						
						else if ($cp == 3)
						{
							$ColorPapel3[$c] = $rows4[$cp][0]['descripcion_color'];
						}					
					
					
						$cp = $cp + 1;
					}
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM imprenta_tipo_costo WHERE id_tipo_costo = ?");

						$p = 1;
						$stmt->bindParam($p,$IdTipoTiempo,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows5 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas5 = $stmt->rowCount();
						$stmt->closeCursor();
						
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}

					$TipoTiempo[$c] = $rows5[0]['descripcion_costo'];				
					*/
				}
				else if ($row['id_banner'] > 0)
				{
					/*if ($row['id_factura'] > 0)
					{
						$Nombre_Producto[$c] = "Libreta Factura";
						$Id_imprenta = $row['id_libreta'];						
					}
					else if ($row['id_libreta'] > 0)
					{
						$Nombre_Producto[$c] = "Libreta";
						$Id_imprenta = $row['id_libreta'];
					}*/
					
					$Id_Banner = $row['id_banner'];
					
					
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM banner bnr
						INNER JOIN banner_material bnrm ON (bnrm.id_material = bnr.id_material)
						INNER JOIN tipo_unidad tu ON (tu.id_unidad = bnr.id_medida_ancho)
						AND (tu.id_unidad = bnr.id_medida_largo)
						INNER JOIN banner_forma_pago bnrf ON (bnrf.id_forma_pago = bnr.id_forma_pago)
						INNER JOIN banner_calidad bnrc ON (bnrc.id_calidad = bnr.id_calidad)
						WHERE id_banner = ?");

						$p = 1;
						$stmt->bindParam($p,$Id_Banner,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas3 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					

					//echo $rows3[0]['descripcion_imprenta'];
					
					$Nombre_Producto[$c] = $rows3[0]['descripcion_banner'];					
					$Precio[$c] = $rows3[0]['precio_venta'];
					$Tipo_Empaque[$c] = "Unidad";
					/*$PapelTipo[$c] = $rows3[0]['descripcion_papel'];
					$Tamano[$c] = $rows3[0]['descripcion_tamano'];
					$CantidadCopia[$c] = $rows3[0]['cant_copia'];
					$ColorTinta[$c] = $rows3[0]['descripcion_color'];
					$TipoForro[$c] = $rows3[0]['descripcion_forro'];
					$IdColorPapel[0] = $rows3[0]['id_color_papel'];
					$IdColorPapel[1] = $rows3[0]['id_color_papel1'];
					$IdColorPapel[2] = $rows3[0]['id_color_papel2'];
					$IdColorPapel[3] = $rows3[0]['id_color_papel3'];
					$IdTipoTiempo = $rows3[0]['id_tipo_tiempo'];
					$TipoCategoria = $rows3[0]['id_categoria'];
					$ColorPapel[$c] = "";
					$ColorPapel1[$c] = "";
					$ColorPapel2[$c] = "";
					$ColorPapel3[$c] = "";					
					
					$cp = 0;
					while ($cp < $CantidadCopia[$c])
					{
					
						try
						{		
							$stmt = $db->prepare("SELECT * FROM imprenta_color_papel WHERE id_color = ?");

							$p = 1;
							$stmt->bindParam($p,$IdColorPapel[$cp],PDO::PARAM_INT);
			
							$stmt->execute();
							$rows4[$cp] = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$nfilas4[$cp] = $stmt->rowCount();
							$stmt->closeCursor();
						
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}					
						
						if ($cp == 0)
						{
							$ColorPapel[$c] = $rows4[$cp][0]['descripcion_color'];
						}
						else if ($cp == 1)
						{
							$ColorPapel1[$c] = $rows4[$cp][0]['descripcion_color'];
						}
						else if ($cp == 2)
						{
							$ColorPapel2[$c] = $rows4[$cp][0]['descripcion_color'];
						}						
						else if ($cp == 3)
						{
							$ColorPapel3[$c] = $rows4[$cp][0]['descripcion_color'];
						}					
					
					
						$cp = $cp + 1;
					}
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM imprenta_tipo_costo WHERE id_tipo_costo = ?");

						$p = 1;
						$stmt->bindParam($p,$IdTipoTiempo,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows5 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas5 = $stmt->rowCount();
						$stmt->closeCursor();
						
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}

					$TipoTiempo[$c] = $rows5[0]['descripcion_costo'];				
*/
				}
				else if ($row['id_impresion'] > 0)
				{
					$Id_Impresion = $row['id_impresion'];
					
					
					
					try
					{		
						$stmt = $db->prepare("SELECT * FROM impresion imp
						INNER JOIN impresion_material impma ON (impma.id_material = imp.id_material)
						INNER JOIN tipo_unidad tu ON (tu.id_unidad = imp.arte_ancho_medida)
						AND (tu.id_unidad = imp.arte_largo_medida)
						INNER JOIN impresion_tamano_pliego imptp ON (imptp.id_tamano = imp.id_tamano)
						INNER JOIN impresion_color_tinta impct ON (impct.id_color = imp.id_color_tinta)
						WHERE id_impresion = ?");

						$p = 1;
						$stmt->bindParam($p,$Id_Impresion,PDO::PARAM_INT);
			
						$stmt->execute();
						$rows4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$nfilas4 = $stmt->rowCount();
						$stmt->closeCursor();
					}
						catch(PDOException $e) {
						echo $e->getMessage();
					}					

					//echo $rows3[0]['descripcion_imprenta'];
					
					$Nombre_Producto[$c] = $rows4[0]['descripcion_impresion'];					
					$Precio[$c] = $rows4[0]['precio_venta'];
					$Tipo_Empaque[$c] = "Unidad";
				}
				
				$c = $c + 1;
			}
		
		}
		
		
				$mensaje[0] = $rows[0]['id_cotizaciones'];
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
				//$mensaje[23] = $Email;			

			
				
				//print_r($Nombre_Producto);
				
				
				
				
				$hoy=date('Y-m-d',strtotime($FechaCreado));
				
				$desde=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy)),date("Y", strtotime($hoy))));
				$hasta=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy))+30,date("Y", strtotime($hoy))));		
				
				$objGenerarCotizacion->Generar_Cotizacion_Imprenta($desde, $hasta, $mensaje);
				

				$objCorreo->prepararNotificacion($mensaje, 1);
				$P_Asunto = "INNOVATIONS CAFE INTERNET";
				$cont++;
				$P_To[$cont] = $Email;

				//$P_To[3] = APP_CORREOFROM;
				$P_attachment = '../../tmp/Cotizacion_Innovations_Print_'.$mensaje[0].'_'.$desde.'.pdf';

				
				$Enviado = $objCorreo->enviarMensaje($P_To, $P_Asunto, $P_attachment);
					
				

				if ($Enviado == 1)
				echo utf8_encode("El Correo se ha enviado Exitósamente");
				else
				echo "false";	
	}	

	if($_GET['action'] == 'Cargar_Saldo')
	{
		

		$id_cotizacion	= strip_tags(utf8_decode($_POST['Id']));	
		$id_abono = ( isset($_POST['Ab']) ) ? strip_tags(utf8_decode($_POST['Ab'])) : "";	
		
		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,co.id_estatus, descripcion_estatus,monto_subtotal,monto_itbm,monto_total, IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones)) AS monto_abonado 
			FROM cotizaciones co INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus)
			WHERE MD5(id_cotizaciones) = ?
			ORDER BY id_cotizaciones DESC");
			
			$p = 1;
			$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_STR,255);				
			
			$stmt->execute();
			//print_r($stmt->errorInfo());
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		if( $id_abono != "" )
		{
			try
			{		
				$stmt = $db->prepare("SELECT a.id_abono,fecha_abonado,monto_abonado,a.id_tipo_pago,descripcion_tipo_pago,CONCAT(u.nombre,' ',u.apellido) AS usuario_recibio_abono FROM abono a
				INNER JOIN tipo_pago tp ON (tp.id_tipo_pago = a.id_tipo_pago)
				INNER JOIN historial_abono ha ON (ha.id_abono = a.id_abono)
				INNER JOIN user_log ul ON (ul.id_log = ha.id_log)
				INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
				WHERE MD5(id_cotizacion) = ? AND MD5(a.id_abono) = ?");

				$p = 1;
				$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_STR,255);
				$p++;
				$stmt->bindParam($p,$id_abono,PDO::PARAM_STR,255);
				
				$stmt->execute();
				//print_r($stmt->errorInfo());
				$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas1 = $stmt->rowCount();
				
				$stmt = $db->prepare("SELECT SUM(monto_abonado) As total_abonado FROM abono a
				WHERE MD5(id_cotizacion) = ? AND a.id_abono < ?");

				$p = 1;
				$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_STR,255);
				$p++;
				$stmt->bindParam($p,$rows1[0]['id_abono'],PDO::PARAM_STR,255);
				
				$stmt->execute();
				//print_r($stmt->errorInfo());
				$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas2 = $stmt->rowCount();

				$stmt = $db->prepare("SELECT numero_factura_fiscal,fecha_factura_fiscal,hora_factura_fiscal FROM factura_fiscal WHERE MD5(id_cotizacion) = ?");

				$p = 1;
				$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_STR,255);
				
				$stmt->execute();
				//print_r($stmt->errorInfo());
				$rows3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas3 = $stmt->rowCount();					
				
				$stmt->closeCursor();
			}
				catch(PDOException $e) {
				echo $e->getMessage();
			}
		}		
		
		if ($nfilas > 0)
		{	
			$c = 0;
			$Abono = array();
			foreach ($rows as $row)
			{

				
				
				if($id_abono != "")
				{
					$Abono[$c]['txtSaldoAnterior'] = number_format(((($row['monto_total'] - $rows2[0]['total_abonado']) > 0)?($row['monto_total'] - $rows2[0]['total_abonado']):"0.00"),2,'.','');
					$Abono[$c]['hidMontoAbonadoAnt'] = number_format($rows1[0]['monto_abonado'],2,'.','');	
					$Abono[$c]['txtMontoAbonado'] = number_format($rows1[0]['monto_abonado'],2,'.','');	
				}
				else
				{
					$Abono[$c]['txtSaldoAnterior'] = number_format(((($row['monto_total'] - $row['monto_abonado']) > 0)?($row['monto_total'] - $row['monto_abonado']):"0.00"),2,'.','');
					$Abono[$c]['hidMontoAbonadoAnt'] = number_format($row['monto_abonado'],2,'.','');
					$Abono[$c]['txtMontoAbonado'] = number_format(((($row['monto_total'] - $row['monto_abonado']) > 0)?($row['monto_total'] - $row['monto_abonado']):"0.00"),2,'.','');
				}
				$Abono[$c]['hidMontoTotal'] = number_format($row['monto_total'],2,'.','');
				$Abono[$c]['txtNumeroCotizacion'] = number_format($row['id_cotizaciones'],0,'.','');
				$Abono[$c]['txtNumeroTransaccion'] = number_format($rows1[0]['id_abono'],0,'.','');
				$Abono[$c]['lstTipoPago'] = base64_encode($rows1[0]['id_tipo_pago']);
				$Abono[$c]['txtNumFactFiscal'] = $rows3[0]['numero_factura_fiscal'];
				
				$fecha = explode("-",$rows3[0]['fecha_factura_fiscal']);
				$FechaFactFiscal = $fecha[2]."-".$fecha[1]."-".$fecha[0];
				
				$Abono[$c]['txtFechaFactFiscal'] = $FechaFactFiscal;
		
				$Abono[$c]['txtHoraFactFiscal'] = $rows3[0]['hora_factura_fiscal'];
				
				$c++;
			}
		}
		
		if ($nfilas > 0)
		{
			$response = json_encode($Abono);
		}		
	
		echo $response;		
		
	}
	
	if($_GET['action'] == 'Agregar_Abono')
	{
		$Monto_Abonado	= strip_tags(utf8_decode($_POST['MontoAbonadoAnt']));	
		$Monto_Total	= strip_tags(utf8_decode($_POST['MontoTotal']));
		$Id	= strip_tags(utf8_decode($_POST['id']));
		
		$html = '<div class="wrapper">	
					<form name="frmIngresarAbono" id="validate" class="form" method="post" action="javascript:Ingresar_Abono();$( "#dialog-message" ).dialog( "close" );">
						<fieldset>
							<div class="widget">
								<div class="title">
									<img src="public/images/icons/dark/alert.png" alt="" class="titleIcon"/>
									<h6>Llenar todos los campos para Agregar Abono</h6>
								</div>
								<div class="formRow">
									<label>Saldo Anterior:</label>
									<div class="formRight">
										<input type="text" value="'.number_format(((($Monto_Total - $Monto_Abonado) > 0)?($Monto_Total - $Monto_Abonado):"0.00"),2,'.','').'" class="validate[custom[number]]" name="txtSaldoAnterior" id="txtSaldoAnterior" readonly="readonly"/>
									</div>
									<div class="clear">
									</div>
								</div>								
								<div class="formRow">
									<label>Monto a Abonar:<span class="req">*</span></label>
									<div class="formRight">
										<input type="text" value="'.number_format(((($Monto_Total - $Monto_Abonado) > 0)?($Monto_Total - $Monto_Abonado):"0.00"),2,'.','').'" class="validate[custom[number]]" name="txtMontoAbonado" id="txtMontoAbonado" onchange="PrecioMoneda(\'txtMontoAbonado\');"/>
										<input type="hidden" value="'.number_format($Monto_Abonado,2,'.','').'" name="hidMontoAbonadoAnt" id="hidMontoAbonadoAnt"/>
										<input type="hidden" value="'.number_format($Monto_Total,2,'.','').'" name="hidMontoTotal" id="hidMontoTotal"/>
										<input type="hidden" value="'.$Id.'" name="hdnIdCotizacion" id="hdnIdCotizacion"/>
									</div>
									<div class="clear">
									</div>
								</div>
								<div class="formRow">
									<label>Saldo Actual:</label>
									<div class="formRight">
										<input type="text" value="0.00" class="validate[custom[number]]" name="txtSaldoActual" id="txtSaldoActual" readonly="readonly"/>
									</div>
									<div class="clear">
									</div>
								</div>									
								<div class="formRow" id="TipoPaquete">
									<label for="labelFor">Tipo de Pago:</label>
									<div class="formRight">
										<div class="floatL">
											<select name="lstTipoPago" id="lstTipoPago">
												<option value="0">Seleccione el Tipo de Pago</option>
											</select>
											
										</div>
									</div>
									<div class="clear">
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>';

		echo $html;
	}
	
	if($_GET['action'] == 'Listar_Tipo_Pago')	
	{

		$html = "";
		
		try
		{		
			$stmt = $db->prepare("SELECT * FROM tipo_pago");
			
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
				$html .= "<option value='".base64_encode($row['id_tipo_pago'])."'>".utf8_encode($row['descripcion_tipo_pago'])."</option>";
			}
		}
		
		echo $html;
	}	
	
	if($_GET['action'] == 'Ingresar_Abono')
	{

		session_start();
		$Response = array();
		
		$db->beginTransaction();
		try
		{
				
			$Monto_Abonado	= strip_tags(utf8_decode($_POST['Monto_Abonado']));	
			$Id_Cotizacion = strip_tags(utf8_decode($_POST['Id_Cotizacion']));
			$Tipo_Pago = strip_tags(utf8_decode(base64_decode($_POST['TipoPago'])));
			$NumFactFiscal = strip_tags(utf8_decode($_POST['NumFactFiscal']));
			$FechaFactFiscal = strip_tags(utf8_decode($_POST['FechaFactFiscal']));
			$HoraFactFiscal = strip_tags(utf8_decode($_POST['HoraFactFiscal']));

			$fecha = explode("-",$FechaFactFiscal);
			
			$FechaFactFiscal = (($FechaFactFiscal)?($fecha[2]."-".$fecha[1]."-".$fecha[0]):"");
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Abono a Cotización Ingresado";
			$Tipo = "14";
			//echo $Id_Orden_Trabajo;


			$stmt = $db->prepare("SELECT id_cotizaciones,monto_total FROM cotizaciones WHERE md5(id_cotizaciones) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Cotizacion,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$id_cotizacion = $results[0]["id_cotizaciones"];			
			
			$stmt = $db->prepare("SELECT  SUM(IF(id_imprenta,1,0) + IF(id_banner,1,0) + IF(id_impresion,1,0)) AS Trabajo
			FROM cotizaciones co
			INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus)
			INNER JOIN cotizacion_producto cp ON(cp.id_cotizacion = co.id_cotizaciones)
			WHERE id_cotizaciones = ? GROUP BY id_cotizaciones
			ORDER BY id_cotizaciones DESC");

			
			$p = 1;
			$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_INT);
			
			$stmt->execute();
			$rowsTrabajo = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//$nfilas = $stmt->rowCount();
			
			$TrabajoImprenta = $rowsTrabajo[0]['Trabajo'];	
			
			$stmt = $db->prepare("SELECT COUNT(*) As Existe FROM orden_trabajo WHERE id_cotizacion = ?");

			
			$p = 1;
			$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_INT);
			
			$stmt->execute();
			$rowsExisteTrabajo = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//$nfilas = $stmt->rowCount();
			$stmt->closeCursor();
			
			$ExisteTrabajoImprenta = $rowsExisteTrabajo[0]['Existe'];
			
			
			$stmt = $db->prepare("INSERT INTO abono (id_cotizacion,monto_abonado,id_tipo_pago,fecha_abonado) VALUES (?,?,?,NOW())");

			$c = 1;
			$stmt->bindParam($c,$id_cotizacion,PDO::PARAM_STR,255);			
			$c++;
			$stmt->bindParam($c,$Monto_Abonado,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Tipo_Pago,PDO::PARAM_STR,255);			
					
			$Insertado = $stmt->execute();
			//print_r($stmt->errorInfo());
		
			
			
			$stmt = $db->query("SELECT LAST_INSERT_ID() AS Id_Abono");
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$Id_Abono = $results[0]["Id_Abono"];
			
			if($Insertado)
			{

				$stmt = $db->prepare("SELECT SUM(monto_abonado) As total_abonado FROM abono a
				WHERE id_cotizacion = ?");

				$p = 1;
				$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_STR,255);
				
				$stmt->execute();
				//print_r($stmt->errorInfo());
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas = $stmt->rowCount();				
								
				
				if($rows[0]['total_abonado'] >= $results[0]["monto_total"])
				{
					
					$stmt = $db->prepare("INSERT INTO factura_fiscal (id_cotizacion,id_abono,numero_factura_fiscal,fecha_factura_fiscal,hora_factura_fiscal,fecha_agregado) VALUES (?,?,?,?,?,NOW())");

					$c = 1;
					$stmt->bindParam($c,$id_cotizacion,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Id_Abono,PDO::PARAM_STR,255);					
					$c++;
					$stmt->bindParam($c,$NumFactFiscal,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$FechaFactFiscal,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$HoraFactFiscal,PDO::PARAM_STR,255);					
							
					$Insertado3 = $stmt->execute();
				
					if (!((($TrabajoImprenta > 0) and ($ExisteTrabajoImprenta == 0)) or ($TrabajoImprenta > $ExisteTrabajoImprenta)))
					{				
						$stmt = $db->prepare("UPDATE cotizaciones SET id_estatus = 4 WHERE id_cotizaciones = ?");
						$c = 1;
						$stmt->bindParam($c,$id_cotizacion,PDO::PARAM_INT);
					
						$Actualizado = $stmt->execute();										
					}				
				}
				
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
				
			$stmt = $db->prepare("INSERT INTO historial_abono (id_abono,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$Id_Abono,PDO::PARAM_INT);
			$c++;
			$stmt->bindParam($c,$Id_Log,PDO::PARAM_INT);
				
			$Insertado2 = $stmt->execute();			
					
			$stmt->closeCursor();
			
		}
			catch(PDOException $e) {
			echo $e->getMessage();		
		}
		

		//echo "$Actualizado-$Insertado1-$Insertado2";		
		if (($Insertado === true) and ($Insertado1 === true) and ($Insertado2 === true))
		{
			$Response['result'] = "true";
	
			if ((($TrabajoImprenta > 0) and ($ExisteTrabajoImprenta == 0)) or ($TrabajoImprenta > $ExisteTrabajoImprenta))
			$Response['AgregarOrden'] = "true";
			else
			$Response['AgregarOrden'] = "false";
			
			if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
			$Response['admin'] = "true";
			else
			$Response['admin'] = "false";				
			
			$db->commit();
		}
		else
		{
			$Response['result'] = "false";
			
			$db->rollBack();
		}

		echo json_encode($Response);
	
	}
	
	if($_GET['action'] == 'Actualizar_Abono')
	{

		session_start();
		$Response = array();	
		$db->beginTransaction();
		try
		{
			
			$Monto_Abonado	= strip_tags(utf8_decode($_POST['Monto_Abonado']));	
			$Transaccion	= strip_tags(utf8_decode($_POST['Transaccion']));	
			$Tipo_Pago = strip_tags(utf8_decode(base64_decode($_POST['TipoPago'])));
			$NumFactFiscal = strip_tags(utf8_decode($_POST['NumFactFiscal']));
			$FechaFactFiscal = strip_tags(utf8_decode($_POST['FechaFactFiscal']));
			$HoraFactFiscal = strip_tags(utf8_decode($_POST['HoraFactFiscal']));			
			
			$fecha = explode("-",$FechaFactFiscal);
			
			$FechaFactFiscal = (($FechaFactFiscal)?($fecha[2]."-".$fecha[1]."-".$fecha[0]):"");			
			
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Abono de Cotización Actualizado";
			$Tipo = "14";
			//echo $Id_Orden_Trabajo;


			
			
			$stmt = $db->prepare("UPDATE abono SET monto_abonado = ?, id_tipo_pago = ?, fecha_actualizado = NOW() WHERE id_abono = ?");

			$c = 1;
			$stmt->bindParam($c,$Monto_Abonado,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Tipo_Pago,PDO::PARAM_STR,255);
			$c++;			
			$stmt->bindParam($c,$Transaccion,PDO::PARAM_STR,255);			

			
					
			$Actualizado = $stmt->execute();
			//print_r($stmt->errorInfo());
			
			if($Actualizado)
			{

				$stmt = $db->prepare("SELECT id_cotizacion FROM abono a
				WHERE id_abono = ?");

				$p = 1;
				$stmt->bindParam($p,$Transaccion,PDO::PARAM_STR,255);
				
				$stmt->execute();
				//print_r($stmt->errorInfo());
				$rows0 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas0 = $stmt->rowCount();
				
				$id_cotizacion = $rows0[0]['id_cotizacion'];
								
				$stmt = $db->prepare("SELECT  SUM(IF(id_imprenta,1,0) + IF(id_banner,1,0) + IF(id_impresion,1,0)) AS Trabajo
				FROM cotizaciones co
				INNER JOIN tipo_estatus te ON (te.id_estatus = co.id_estatus)
				INNER JOIN cotizacion_producto cp ON(cp.id_cotizacion = co.id_cotizaciones)
				WHERE id_cotizaciones = ? GROUP BY id_cotizaciones
				ORDER BY id_cotizaciones DESC");

				
				$p = 1;
				$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_INT);
				
				$stmt->execute();
				$rowsTrabajo = $stmt->fetchAll(PDO::FETCH_ASSOC);
				//$nfilas = $stmt->rowCount();
				
				$TrabajoImprenta = $rowsTrabajo[0]['Trabajo'];				
				
				$stmt = $db->prepare("SELECT COUNT(*) As Existe FROM orden_trabajo WHERE id_cotizacion = ?");

				
				$p = 1;
				$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_INT);
				
				$stmt->execute();
				$rowsExisteTrabajo = $stmt->fetchAll(PDO::FETCH_ASSOC);
				//$nfilas = $stmt->rowCount();
				$stmt->closeCursor();
				
				$ExisteTrabajoImprenta = $rowsExisteTrabajo[0]['Existe'];				
				
				
				$stmt = $db->prepare("SELECT IFNULL(SUM(monto_abonado),0) As total_abonado FROM abono a
				WHERE id_cotizacion = ?");

				$p = 1;
				$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_STR,255);
				
				$stmt->execute();
				//print_r($stmt->errorInfo());
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas = $stmt->rowCount();

				$stmt = $db->prepare("SELECT id_abono FROM abono a
				WHERE id_cotizacion = ? ORDER BY id_abono DESC  LIMIT 0,1");

				$p = 1;
				$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_STR,255);
				
				$stmt->execute();
				//print_r($stmt->errorInfo());
				$rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas1 = $stmt->rowCount();

				
				$stmt = $db->prepare("SELECT COUNT(*) AS Existe FROM factura_fiscal WHERE id_cotizacion = ?");

				$p = 1;
				$stmt->bindParam($p,$id_cotizacion,PDO::PARAM_STR,255);
				
				$stmt->execute();
				//print_r($stmt->errorInfo());
				$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$nfilas2 = $stmt->rowCount();								
				
				if($rows[0]['total_abonado'] >= $results[0]["monto_total"])
				{
					
					if($rows2[0]['Existe'] == 0)
					{
						$stmt = $db->prepare("INSERT INTO factura_fiscal (id_cotizacion,id_abono,numero_factura_fiscal,fecha_factura_fiscal,hora_factura_fiscal,fecha_agregado) VALUES (?,?,?,?,?,NOW())");

						$c = 1;
						$stmt->bindParam($c,$id_cotizacion,PDO::PARAM_STR,255);
						$c++;
						$stmt->bindParam($c,$rows1[0]['id_abono'],PDO::PARAM_STR,255);					
						$c++;
						$stmt->bindParam($c,$NumFactFiscal,PDO::PARAM_STR,255);
						$c++;
						$stmt->bindParam($c,$FechaFactFiscal,PDO::PARAM_STR,255);
						$c++;
						$stmt->bindParam($c,$HoraFactFiscal,PDO::PARAM_STR,255);					
								
						$Insertado3 = $stmt->execute();
					}
					else
					{
						$stmt = $db->prepare("UPDATE factura_fiscal SET numero_factura_fiscal = ?,fecha_factura_fiscal = ?,hora_factura_fiscal = ?,fecha_actualizado = NOW()
						WHERE id_cotizacion = ? AND id_abono = ?");

						$c = 1;
				
						$stmt->bindParam($c,$NumFactFiscal,PDO::PARAM_STR,255);
						$c++;
						$stmt->bindParam($c,$FechaFactFiscal,PDO::PARAM_STR,255);
						$c++;
						$stmt->bindParam($c,$HoraFactFiscal,PDO::PARAM_STR,255);
						$c++;
						$stmt->bindParam($c,$id_cotizacion,PDO::PARAM_STR,255);
						$c++;
						$stmt->bindParam($c,$rows1[0]['id_abono'],PDO::PARAM_STR,255);
						
						$Actualizado1 = $stmt->execute();						
							
					}
					
					if (!((($TrabajoImprenta > 0) and ($ExisteTrabajoImprenta == 0)) or ($TrabajoImprenta > $ExisteTrabajoImprenta)))
					{				
						$stmt = $db->prepare("UPDATE cotizaciones SET id_estatus = 4 WHERE id_cotizaciones = ?");
						$c = 1;
						$stmt->bindParam($c,$id_cotizacion,PDO::PARAM_INT);
					
						$Actualizado2 = $stmt->execute();										
					}					
					
				}
				
			}			
			
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
				
				if (($Porcentaje_Realizado == 100) and ($results[0]["monto_total"] <= $rows[0]['total_abonado']))
				{
					$stmt = $db->prepare("UPDATE cotizaciones SET id_estatus = 3 WHERE id_cotizaciones = ?");
					$c = 1;
					$stmt->bindParam($c,$id_cotizacion,PDO::PARAM_INT);
				
					$Actualizado1 = $stmt->execute();		
				}				
				
			}
				catch(PDOException $e) {
				echo $e->getMessage();
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
				
			$stmt = $db->prepare("INSERT INTO historial_abono (id_abono,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$Transaccion,PDO::PARAM_INT);
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
			$Response['result'] = "true";
			$Response['Id'] = md5($id_cotizacion);
			if ((($TrabajoImprenta > 0) and ($ExisteTrabajoImprenta == 0)) or ($TrabajoImprenta > $ExisteTrabajoImprenta))
			$Response['AgregarOrden'] = "true";
			else
			$Response['AgregarOrden'] = "false";	
			
			if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))							
			$Response['admin'] = "true";
			else
			$Response['admin'] = "false";
		
			$db->commit();
		}
		else
		{
			$Response['result'] = "false";
			$db->rollBack();
		}

		echo json_encode($Response);
	}
	
	if($_GET['action'] == 'Eliminar_Abono')	
	{

		session_start();
		$db->beginTransaction();
		try
		{
			$Id_Abono = strip_tags(utf8_decode($_POST['IdAbono']));				
			$Id_Usuario = base64_decode($_SESSION['id_usuario']);
			$Evento = "Abono Eliminado";
			$Tipo = "12";			
			
			$stmt = $db->prepare("SELECT * FROM abono WHERE MD5(id_abono) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Abono,PDO::PARAM_STR,255);
			$stmt->execute();				
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$id_abono = $results[0]["id_abono"];	
			$stmt->closeCursor();			
			
			$stmt = $db->prepare("DELETE FROM abono WHERE MD5(id_abono) = ?");
			$c = 1;
			$stmt->bindParam($c,$Id_Abono,PDO::PARAM_STR,255);

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
				
			$stmt = $db->prepare("INSERT INTO historial_abono (id_abono,id_log) VALUES (?,?)");
			$c = 1;
			$stmt->bindParam($c,$id_abono,PDO::PARAM_INT);
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

	if($_GET['action'] == 'Imprimir_Recibo_Abono')	
	{
		include('../../library/Generar_Recibo_Abono.php');
		include('../../library/numeros.php');
		include('../../library/fecha.php');
		
		$objNumeros =  new numeros();
		$objFecha =  new fecha();		
		$objGenerarReciboAbono =  new Generar_Recibo_Abono();
		
		$Id_Abono	= strip_tags(utf8_decode($_POST['id']));
		$Id_Cotizacion	= strip_tags(utf8_decode($_POST['idCotizacion']));

		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,id_orden_trabajo,fecha_entrega,descripcion_estatus,monto_subtotal,monto_itbm,monto_total,co.fecha_creado,
			IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones)) AS monto_abonado_total
			FROM cotizaciones co INNER JOIN tipo_estatus_cotizacion te ON (te.id_estatus = co.id_estatus)
			LEFT JOIN orden_trabajo ot ON (ot.id_cotizacion=co.id_cotizaciones)
			WHERE MD5(id_cotizaciones) = ? ORDER BY ot.fecha_entrega DESC LIMIT 0,1");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
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
			$stmt = $db->prepare("SELECT a.id_cotizacion,a.id_abono,fecha_abonado,monto_abonado,a.id_tipo_pago,descripcion_tipo_pago,CONCAT(u.nombre,' ',u.apellido) AS usuario_recibio_abono FROM abono a
			INNER JOIN tipo_pago tp ON (tp.id_tipo_pago = a.id_tipo_pago)
			INNER JOIN historial_abono ha ON (ha.id_abono = a.id_abono)
			INNER JOIN user_log ul ON (ul.id_log = ha.id_log)
			INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
			WHERE MD5(id_cotizacion) = ? AND MD5(a.id_abono) = ?
			AND evento != 'Abono de Cotización Actualizado' AND evento != 'Abono Eliminado'");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			$p++;
			$stmt->bindParam($p,$Id_Abono,PDO::PARAM_STR,255);			
			
			$stmt->execute();
			$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas2 = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		$mensaje[0] = $rows2[0]['id_cotizacion'];
		$mensaje[1] = $rows[0]['id_orden_trabajo'];
		$mensaje[2] = $rows2[0]['id_abono'];
		$mensaje[3] = $rows2[0]['fecha_abonado'];
		$mensaje[4] = number_format($rows2[0]['monto_abonado'],2,'.',',');
		$mensaje[5] = utf8_encode($rows1[0]['Nombre_Cliente']);
		$mensaje[6] = $rows2[0]['descripcion_tipo_pago'];
		$mensaje[7] = $objFecha->converfecha($rows[0]['fecha_entrega']);
		$mensaje[8] = number_format(($rows[0]['monto_total'] - $rows[0]['monto_abonado_total']),2,'.',',');
		
		/*$mensaje[2] = utf8_encode($rows1[0]['direccion']);
		$mensaje[3] = $rows1[0]['ruc_parte_1']."-".$rows1[0]['ruc_parte_2']."-".$rows1[0]['ruc_parte_3'];
		$mensaje[4] = $rows[0]['monto_subtotal'];			
		$mensaje[5] = $rows[0]['monto_itbm'];			
		$mensaje[6] = $rows[0]['monto_total'];*/
		/*$mensaje[1] = utf8_encode($rows1[0]['Nombre_Cliente']);
		$mensaje[2] = utf8_encode($rows1[0]['direccion']);
		$mensaje[3] = $rows1[0]['ruc_parte_1']."-".$rows1[0]['ruc_parte_2']."-".$rows1[0]['ruc_parte_3'];
		$mensaje[4] = $rows[0]['monto_subtotal'];			
		$mensaje[5] = $rows[0]['monto_itbm'];			
		$mensaje[6] = $rows[0]['monto_total'];*/		
		
		$hoy=date('Y-m-d',strtotime($mensaje[3]));
		$desde=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy)),date("Y", strtotime($hoy))));
		$hasta=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy))+30,date("Y", strtotime($hoy))));			
		
		$objGenerarReciboAbono->Generar_Recibo($desde, $hasta, $mensaje);

		echo 'tmp/Recibo_Abono_'.$mensaje[2].'_'.$desde.'.pdf';		
	}	
	
	
	if($_GET['action'] == 'Imprimir_Ultimo_Recibo_Abono')	
	{
		include('../../library/Generar_Recibo_Abono.php');
		include('../../library/numeros.php');
		include('../../library/fecha.php');
		
		$objNumeros =  new numeros();
		$objFecha =  new fecha();		
		$objGenerarReciboAbono =  new Generar_Recibo_Abono();
		
		$Id_Cotizacion	= strip_tags(utf8_decode($_POST['id']));	

		try
		{		
			$stmt = $db->prepare("SELECT id_cliente,id_tipo_cliente,id_cotizaciones,id_orden_trabajo,fecha_entrega,descripcion_estatus,monto_subtotal,monto_itbm,monto_total,co.fecha_creado,
			IF((SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones) IS NULL,0,(SELECT SUM(monto_abonado) FROM abono WHERE id_cotizacion = id_cotizaciones)) AS monto_abonado_total
			FROM cotizaciones co INNER JOIN tipo_estatus_cotizacion te ON (te.id_estatus = co.id_estatus)
			LEFT JOIN orden_trabajo ot ON (ot.id_cotizacion=co.id_cotizaciones) 
			WHERE MD5(id_cotizaciones) = ? ORDER BY ot.fecha_entrega DESC LIMIT 0,1");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
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
			$stmt = $db->prepare("SELECT a.id_cotizacion,a.id_abono,fecha_abonado,monto_abonado,a.id_tipo_pago,descripcion_tipo_pago,CONCAT(u.nombre,' ',u.apellido) AS usuario_recibio_abono FROM abono a
			INNER JOIN tipo_pago tp ON (tp.id_tipo_pago = a.id_tipo_pago)
			INNER JOIN historial_abono ha ON (ha.id_abono = a.id_abono)
			INNER JOIN user_log ul ON (ul.id_log = ha.id_log)
			INNER JOIN usuarios u ON (u.id_usuario = ul.id_usuario)
			WHERE MD5(id_cotizacion) = ?
			AND evento != 'Abono de Cotización Actualizado' AND evento != 'Abono Eliminado' ORDER BY fecha_abonado DESC LIMIT 0,1");

			$p = 1;
			$stmt->bindParam($p,$Id_Cotizacion,PDO::PARAM_STR,255);
			
			$stmt->execute();
			$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas2 = $stmt->rowCount();
			$stmt->closeCursor();
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		
		$mensaje[0] = $rows2[0]['id_cotizacion'];
		$mensaje[1] = $rows[0]['id_orden_trabajo'];
		$mensaje[2] = $rows2[0]['id_abono'];
		$mensaje[3] = $rows2[0]['fecha_abonado'];
		$mensaje[4] = number_format($rows2[0]['monto_abonado'],2,'.',',');
		$mensaje[5] = utf8_encode($rows1[0]['Nombre_Cliente']);
		$mensaje[6] = $rows2[0]['descripcion_tipo_pago'];
		$mensaje[7] = $objFecha->converfecha($rows[0]['fecha_entrega']);
		$mensaje[8] = number_format(($rows[0]['monto_total'] - $rows[0]['monto_abonado_total']),2,'.',',');
		
		/*$mensaje[2] = utf8_encode($rows1[0]['direccion']);
		$mensaje[3] = $rows1[0]['ruc_parte_1']."-".$rows1[0]['ruc_parte_2']."-".$rows1[0]['ruc_parte_3'];
		$mensaje[4] = $rows[0]['monto_subtotal'];			
		$mensaje[5] = $rows[0]['monto_itbm'];			
		$mensaje[6] = $rows[0]['monto_total'];*/
		/*$mensaje[1] = utf8_encode($rows1[0]['Nombre_Cliente']);
		$mensaje[2] = utf8_encode($rows1[0]['direccion']);
		$mensaje[3] = $rows1[0]['ruc_parte_1']."-".$rows1[0]['ruc_parte_2']."-".$rows1[0]['ruc_parte_3'];
		$mensaje[4] = $rows[0]['monto_subtotal'];			
		$mensaje[5] = $rows[0]['monto_itbm'];			
		$mensaje[6] = $rows[0]['monto_total'];*/		
		
		$hoy=date('Y-m-d',strtotime($mensaje[3]));
		$desde=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy)),date("Y", strtotime($hoy))));
		$hasta=date("d-m-Y",mktime(0,0,0,date("m", strtotime($hoy)),date("d", strtotime($hoy))+30,date("Y", strtotime($hoy))));			
		
		$objGenerarReciboAbono->Generar_Recibo($desde, $hasta, $mensaje);

		echo 'tmp/Recibo_Abono_'.$mensaje[2].'_'.$desde.'.pdf';		
	}

?>