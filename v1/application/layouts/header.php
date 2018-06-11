<?php
	 /*// calc an offset of 24 hours
	 $offset = 3600 * 24;
	 // calc the string in GMT not localtime and add the offset
	 $expire = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
	 //output the HTTP header*/
	 //header($expire);
	header("Cache-Control: max-age=3600, must-revalidate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<title>Innovations Print</title>
	<link href="public/css/main.css" rel="stylesheet" type="text/css" />

	<!-- SexyAlertBox -->	
	<link rel="stylesheet" type="text/css" href="public/css/sexyalertbox.css" />
	
	<!-- ============================== -->
	<link rel="stylesheet" type="text/css" href="public/css/TableTools/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="public/css/TableTools/buttons.dataTable.css">

	<!-- =============================== -->
	<link rel="stylesheet" type="text/css" href="public/css/TableTools/dataTables.tableTools.min.css" />
	
    <!-- Custom Fonts -->
    <link href="public/fonts/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Icono de Favorito  --> 
	<link rel="shortcut icon" href="favicon.ico">
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<div id="main_content">
