<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<title>Innovations Print</title>
<link href="public/css/main.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="public/css/sexyalertbox.css" />
</head>

<body class="nobg loginPage">
	<div id="main_content">
	<!-- Top fixed navigation -->
	<div class="topNav">
		<div class="wrapper">
			<div class="userNav">
				<ul>
					<li><a href="#" title=""><img src="public/images/icons/topnav/mainWebsite.png" alt="" /><span>Sitio Web Principal</span></a></li>
					<li><a href="#" title=""><img src="public/images/icons/topnav/profile.png" alt="" /><span>Contactar con el Administrador</span></a></li>
					<li><a href="#" title=""><img src="public/images/icons/topnav/messages.png" alt="" /><span>Soporte</span></a></li>
					<!--<li><a href="index.html" title=""><img src="images/icons/topnav/settings.png" alt="" /><span>Configuraci&oacute;n</span></a></li>!-->
				</ul>
			</div>
			<div class="clear"></div>
		</div>
	</div>


	<!-- Main content wrapper -->
	<div class="loginWrapper">
		<div class="loginLogo"><img src="public/images/loginLogo.png" alt="" /></div>
		<div class="widget">
			<div class="title"><img src="public/images/icons/dark/files.png" alt="" class="titleIcon" /><h6>Panel de Acceso al Sistema</h6></div>
			<form action="" id="validate" class="form">
				<fieldset>
					<div class="formRow">
						<label for="login">Usuario:</label>
						<div class="loginInput"><input type="text" name="login" class="validate[required]" id="login" /></div>
						<div class="clear"></div>
					</div>
                
					<div class="formRow">
						<label for="pass">Contrase&ntilde;a:</label>
						<div class="loginInput"><input type="password" name="password" class="validate[required]" id="pass"  onfocus="this.select()" onchange="this.value=calcMD5(this.value)"/></div>
						<div class="clear"></div>
					</div>
                
					<div class="loginControl">
						<div class="rememberMe"><input type="checkbox" id="remMe" name="remMe" /><label for="remMe">Recu&eacute;rdame</label></div>
						<input type="button" value="Iniciar Sesión" class="dredB logMeIn"  onclick="Iniciar_Session()"/>
						<div class="clear"></div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>		
    <!-- Footer line -->
    <div id="footer">
        <div class="wrapper">Todos los Derechos Reservados <a href="http://innovations.ideamospanama.com/" title="">Innovations</a></div>
	</div>
	</div>
	<div id="loading">
	</div>
	
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>!-->
<script type="text/javascript" src="public/js/plugins/jquery/jquery.min.js"></script>

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>!-->
<script type="text/javascript" src="public/js/plugins/jquery/jquery-ui.min.js"></script>

<!-- SexyAlertBox -->
<script type="text/javascript" charset="ISO-8859-1"  src="public/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" charset="ISO-8859-1"  src="public/js/sexyalertbox.v1.2.jquery.js"></script>		
<script type="text/javascript" src="public/js/funciones.js"></script>
<script charset="ISO-8859-1">
$(document).ready(function(){	
	
	$(window).load(function(){
		
		Verificar_Recordar_Sesion();
		$('#loading').css("visibility","hidden");
		$('#main_conten').css("opacity",1);
	
	});
});
</script>	
</body>
</html>