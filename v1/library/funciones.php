<?php
 //error_reporting(E_ALL);
  //ini_set("display_errors", 1);
//set_time_limit(0);
	include('../config/configuracion.php');
	//echo date_default_timezone_get();
	date_default_timezone_set ('America/Panama');
	//echo date('d-m-Y H:i');
	if (!isset($_SERVER['HTTP_REFERER']))
	header('Location: ../index.php');
	
	// Conectar con el servidor de base de datos
	//$conexion = mysql_connect(DB_HOST, DB_USER, DB_CLAVE)
	//or die ("No se puede conectar con el servidor");

	// Seleccionar base de datos
	//mysql_select_db (DB_NOMBRE)
	//or die ("No se puede seleccionar la base de datos");	
	
	// Conectar con el servidor de base de datos y Seleccionar base de datos 
	// Display message if successfully connect, otherwise retains and outputs the potential error
	try {
		$db = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NOMBRE, DB_USER, DB_CLAVE);
		//echo 'Connected to database<br />';
	}
		catch(PDOException $e) {
		echo $e->getMessage();
	}
		
	function getRealIP()
	{	

 	    $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                // trim for safety measures
                $ip = trim($ip);
                // attempt to validate IP
                if (validate_ip($ip)) {
                    return $ip;
                }
            }
        }
    }
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
 
	}	

	function validate_ip($ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return false;
    }
    return true;
}

	
	if($_GET['action'] == 'Iniciar_Session')
	{
		session_start();	
		ob_start();
		

		$Usuario=strip_tags($_POST['usuario']);
		$Clave=strip_tags(strtoupper($_POST['clave']));

		try
		{	
			
		
			$stmt = $db->prepare("SELECT * FROM usuarios u INNER JOIN tipo_estatus_usuario eu ON (eu.id_estatus = u.id_estatus) WHERE usuario = '$Usuario' AND clave = '$Clave' ");
			$c = 1;
			$stmt->bindParam($c,$Usuario,PDO::PARAM_STR,255);
			$c++;
			$stmt->bindParam($c,$Clave,PDO::PARAM_STR,255);		
			
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$nfilas = $stmt->rowCount();	
			$stmt->closeCursor();
			

			
		}
			catch(PDOException $e) {
			echo $e->getMessage();
		}
		

		
		if($nfilas==1){
		
			foreach ($rows as $row)
			{	
				
				
				if ($row['id_estatus'] != "1")
				{
				$msj =  "false1";
				}
				else
				{	
					$_SESSION['EXPIRES'] = time() + TIME_SESSION;
					$_SESSION['nombre'] = base64_encode($row['nombre']);
					$_SESSION['apellido'] = base64_encode($row['apellido']);
					$usuario = $row['usuario'];
					$_SESSION['usuario'] = base64_encode($usuario);
					$id_usuario = $row['id_usuario'];
					$_SESSION['id_usuario'] = base64_encode($id_usuario);
					$_SESSION['id_tipo_usuario'] = base64_encode($row['id_tipo_usuario']);
					$_SESSION['id_tienda'] = base64_encode($row['id_tienda']);
					$_SESSION['id_bodega'] = base64_encode($row['id_bodega']);
					$_SESSION['id_estatus'] = base64_encode($row['id_estatus']);
					$_SESSION['fecha_ultimo_acceso'] = base64_encode($row['fecha_ultimo_acceso']);
					
					if ($_POST['rem']== true)
					{
						$numero_aleatorio = md5(uniqid(rand(), true));
						

						$ip = getRealIP();
					

						$id_recordatorio = md5($usuario)."%".$numero_aleatorio."%".md5($ip);						
						
						//echo $ip;
						try
						{			
							$cookie = $numero_aleatorio;
							//$IP = $ip;
							//$Id_Usuario = $id_usuario;
					
							$stmt = $db->prepare("UPDATE usuarios SET cookie = ?, ip= ? WHERE id_usuario= ?");
							$c = 1;
							$stmt->bindParam($c,$cookie,PDO::PARAM_STR,255);
							$c++;
							$stmt->bindParam($c,$ip,PDO::PARAM_STR,255);
							$c++;
							$stmt->bindParam($c,$id_usuario,PDO::PARAM_INT);							
			
							$stmt->execute();							
							
							
							//$stmt = $db->exec("CALL Recordar_Sesion ('".$Cookie."','".$IP."','".$Id_Usuario."')");
							//print_r($stmt);
						}
							catch(PDOException $e) {
							echo $e->getMessage();
						}
						
						setcookie("marca_aleatoria_usuario", $numero_aleatorio, time()+(60));
						
						setcookie("id_usuario", md5($id_usuario), time()+(60));
						setcookie("ip", md5($ip), time()+(60));
				
					}

				}
	
			}		
			if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
			{$msj = "admin.php";}else{$msj = "admin.php?sec=".base64_encode("listar_ordenes_trabajos");}
			

		}else{
			$msj =  "false";
		}
		
		ob_end_flush();	
		echo $msj;
	}
	
	if($_GET['action'] == 'Verificar_Recordar_Sesion')
	{
		//primero tengo que ver si el usuario está memorizado en una cookie
		if (isset($_COOKIE["id_usuario"]) and isset($_COOKIE["marca_aleatoria_usuario"]) and isset($_COOKIE["ip"])){

			//Tengo cookies memorizadas
			//además voy a comprobar que esas variables no estén vacías
			if ($_COOKIE["id_usuario"]!="" or $_COOKIE["marca_aleatoria_usuario"]!="" or $_COOKIE["ip"]){
				//Voy a ver si corresponden con algún usuario

				try
				{
					$Id_User = $_COOKIE["id_usuario"];
					$Galleta = $_COOKIE["marca_aleatoria_usuario"];
					$DireccionIP = $_COOKIE["ip"];
				
					$stmt = $db->prepare("SELECT * FROM usuarios WHERE MD5(id_usuario)= ?  AND cookie= ? AND MD5(ip)= ? AND cookie <> '' AND ip <> ''");
					$c = 1;
					$stmt->bindParam($c,$Id_User,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$Galleta,PDO::PARAM_STR,255);
					$c++;
					$stmt->bindParam($c,$DireccionIP,PDO::PARAM_STR,255);
					$stmt->execute();
					$nfilas = $stmt->rowCount();
					$stmt->closeCursor();


				}
					catch(PDOException $e) {
					echo $e->getMessage();
				}
			
				if($nfilas==1){
		
					echo "admin.php";
			
				}
				else
				{	
					echo "false";	
				}
			}
			else
			{
				echo "false";		
			}			
		}
		else
		{
			echo "false";		
		}
				
	}
	
	
	if($_GET['action'] == 'Verificar_Sesion')
	{	
		session_start();
		
		if (!base64_decode($_SESSION['usuario'])) {
			echo "false";
		}	
		else if ($_SESSION['EXPIRES'] < time()) {
			session_destroy();	
			echo "false";
		}
		else
		{
			echo "true";
		}

	}
	
	if($_GET['action'] == 'Nombre_Sesion')
	{	

		session_start();
		$Nombre_Usuario = "Bienvenido, ".utf8_encode(base64_decode($_SESSION['nombre']))." ".utf8_encode(base64_decode($_SESSION['apellido']));

		echo $Nombre_Usuario;
	}


	if($_GET['action'] == 'Usuario_Sesion')
	{	
		session_start();
		$Usuario = utf8_encode(base64_decode($_SESSION['nombre']))." ".utf8_encode(base64_decode($_SESSION['apellido']));

		echo $Usuario;
	}	
	
	if($_GET['action'] == 'Generar_Perfil_Menu')
	{	

		session_start();

		if ((base64_decode($_SESSION['id_tipo_usuario']) == 1) or (base64_decode($_SESSION['id_tipo_usuario']) == 2))
		echo $aministrador = "true";
		else 
		echo $aministrador = "false";
	}	
	
	if($_GET['action'] == 'Verificar_Administrador')
	{	

		session_start();

		if (base64_decode($_SESSION['id_tipo_usuario']) == 1)
		echo $aministrador = "true";
		else 
		echo $aministrador = "false";
	}
	
	if($_GET['action'] == 'Cerrar_Sesion')
	{	

		session_start();
		$_SESSION=array();	
		session_destroy();
		session_unset();
		setcookie("marca_aleatoria_usuario", "", time()-3600);
		setcookie("id_usuario", "", time()-3600);
		setcookie("ip", "", time()-3600);		
		
		echo "index.php";
	}
	
?>