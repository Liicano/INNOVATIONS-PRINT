<?php
 $carpeta = "application/views/";//carpeta donde tengas los files a incluir, si es en el mismo directorio dejar en blanco.
 if(!htmlspecialchars(trim(isset($_GET['sec'])))){
    include($carpeta."homepage.php");
 }else{
	 $sec = htmlspecialchars(trim(base64_decode($_GET['sec'])));
	 $file = $carpeta.$sec.".php";
    if(file_exists($file)){
        include($file);
    }else{
       //echo "La p&aacute;gina a la cual intenta acceder no existe.";
	echo "<script language=Javascript> location.href=\"404.php\"; </script>"; 
die(); 

		  
    }
 }
?>