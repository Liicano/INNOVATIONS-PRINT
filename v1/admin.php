<?php 
	session_start();	
	include_once 'application/layouts/header.php';
	include_once 'application/layouts/menu.php';


	/*switch(base64_decode($_SESSION['id_tipo_usuario'])){
			case '1':
			   include_once 'application/layouts/menu-super-admin.php';
				break;			
			case '2':
			   include_once 'application/layouts/menu-admin.php';
				break;
			case '3':
				include_once 'application/layouts/menu-cajera.php';
				break;
			case '4':
				include_once 'application/layouts/menu-usuario-agregar-precio.php';
				break;
			case '5':
				include_once 'application/layouts/menu-usuario.php';
				break;
	}*/
	   
	//include_once 'application/layouts/menu-admin.php';
	include_once 'application/layouts/pages.php'; 
	include_once 'application/layouts/footer.php';
	
?>