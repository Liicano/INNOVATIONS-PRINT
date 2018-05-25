<?

class fecha
{

function calcularFecha($dias){
	$calculo = strtotime("$dias days");
	return date("Y-m-d", $calculo);
}

function calculaFecha($modo,$valor,$fecha_inicio=false){

   if($fecha_inicio!=false) {
          $fecha_base = strtotime($fecha_inicio);
   }else {
          $time=time();
          $fecha_actual=date("Y-m-d",$time);
          $fecha_base=strtotime($fecha_actual);
   }

   $calculo = strtotime("$valor $modo","$fecha_base");

   return date("Y-m-d", $calculo);

}

 function restaFechas($dFecIni, $dFecFin){
	//$dFecIni=explode("-",$dFecIni);
	//$dFecFin=explode("-",$dFecFin);

	//calculo timestam de las dos fechas 
	//$dFecIni[1]=mes
	//$dFecIni[2]=dia
	//$dFecIni[0]=año
	//$timestamp1 = mktime(0,0,0,$dFecIni[1],$dFecIni[2],$dFecIni[0]); 
	//$timestamp2 = mktime(0,0,0,$dFecFin[1],$dFecFin[2],$dFecFin[0]); 

	//resto a una fecha la otra 
	//$segundos_diferencia = $timestamp1 - $timestamp2;

	$segundos_diferencia = abs(strtotime($dFecFin) - strtotime($dFecIni));
	//$segundos_diferencia = $timestamp1 - $timestamp2;	

	//convierto segundos en días 
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 

	//obtengo el valor absoulto de los días (quito el posible signo negativo) 
	$dias_diferencia = abs($dias_diferencia); 

	//quito los decimales a los días de diferencia 
	$dias_diferencia = floor($dias_diferencia);
	
	$tiempo_diferencia['anio'] = floor($dias_diferencia/365.2425);
	$tiempo_diferencia['meses'] = floor(abs(($dias_diferencia-(365.2425*$tiempo_diferencia['anio']))/30.436875));
	$tiempo_diferencia['dias'] = floor(abs($dias_diferencia-(365.2425*$tiempo_diferencia['anio'])-(30.436875*$tiempo_diferencia['meses'])));
	

	return $tiempo_diferencia;
}
 
function compararFechas($fecha1,$fecha2){
	if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
		list($año1,$mes1,$dia1)=split("/",$fecha1);
		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
			list($año1,$mes1,$dia1)=split("-",$fecha1);
			if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
				list($año2,$mes2,$dia2)=split("/",$fecha2);
				if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
					list($año2,$mes2,$dia2)=split("-",$fecha2);
					$dif = mktime(0,0,0,$mes1,$dia1,$año1) - mktime(0,0,0, $mes2,$dia2,$año2);
	$dif=round($dif/86400,0);
	return ($dif);                         
}

function RestarHoras($horaini,$horafin){
	$horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$segi=substr($horaini,6,2);

	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$segf=substr($horafin,6,2);

	$ini=((($horai*60)*60)+($mini*60)+$segi);
	$fin=((($horaf*60)*60)+($minf*60)+$segf);

	$dif=$fin-$ini;

	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	$difs=$dif-($difm*60)-($difh*3600);
	return date("H:i:s",mktime($difh,$difm,$difs));
}

function sumaHora($hora1,$hora2){
	$hora1=explode(":",$hora1);
	$hora2=explode(":",$hora2);
	$horas=(int)$hora1[0]+(int)$hora2[0];
	$minutos=(int)$hora1[1]+(int)$hora2[1];
	$segundos=(int)$hora1[2]+(int)$hora2[2];
	$horas+=(int)($minutos/60);
	$minutos=(int)($minutos%60)+(int)($segundos/60);
	$segundos=(int)($segundos%60);
	if(intval($horas)<10){
		$horas='0'.intval($horas);
	}else{
		$horas=intval($horas);
	}
	if(intval($minutos)<10){
		$minutos='0'.intval($minutos);
	}else{
		$minutos=intval($minutos);
	}
	return $horas.':'.$minutos;
}

function compararHora($hora1,$hora2){
	$hora1 = strtotime( $hora1 );
	$hora2 = strtotime( $hora2 );
	return $hora1 > $hora2;
}

function converfecha($fechanum){
$mes=substr($fechanum,5,2);
switch($mes){
	case "01":
		$nomes="ENERO";
		break;
	case "02":
		$nomes="FEBRERO";
		break;
	case "03":
		$nomes="MARZO";
		break;
	case "04":
		$nomes="ABRIL";
		break;
	case "05":
		$nomes="MAYO";
		break;
	case "06":
		$nomes="JUNIO";
		break;
	case "07":
		$nomes="JULIO";
		break;
	case "08":
		$nomes="AGOSTO";
		break;
	case "09":
		$nomes="SEPTIEMBRE";
		break;
	case "10":
		$nomes="OCTUBRE";
		break;
	case "11":
		$nomes="NOVIEMBRE";
		break;
	case "12":
		$nomes="DICIEMBRE";
		break;
}
$fechareturn=substr($fechanum,8,2).' DE '.$nomes.' DE '.substr($fechanum,0,4);
return $fechareturn;
}

function converfechacorta($fechanum){
$mes=substr($fechanum,5,2);
switch($mes){
	case "01":
		$nomes="ENE";
		break;
	case "02":
		$nomes="FEB";
		break;
	case "03":
		$nomes="MAR";
		break;
	case "04":
		$nomes="ABR";
		break;
	case "05":
		$nomes="MAY";
		break;
	case "06":
		$nomes="JUN";
		break;
	case "07":
		$nomes="JUL";
		break;
	case "08":
		$nomes="AGO";
		break;
	case "09":
		$nomes="SEP";
		break;
	case "10":
		$nomes="OCT";
		break;
	case "11":
		$nomes="NOV";
		break;
	case "12":
		$nomes="DIC";
		break;
}
$fechareturn=substr($fechanum,8,2).' - '.$nomes.' - '.substr($fechanum,0,4);
return $fechareturn;
}

function converdate($fechanum){
$mes=substr($fechanum,5,2);
switch($mes){
	case "01":
		$nomes="JANUARY";
		break;
	case "02":
		$nomes="FEBRUARY";
		break;
	case "03":
		$nomes="MARCH";
		break;
	case "04":
		$nomes="APRIL";
		break;
	case "05":
		$nomes="MAY";
		break;
	case "06":
		$nomes="JUNE";
		break;
	case "07":
		$nomes="JULY";
		break;
	case "08":
		$nomes="AUGUST";
		break;
	case "09":
		$nomes="SEPTEMBER";
		break;
	case "10":
		$nomes="OCTOBER";
		break;
	case "11":
		$nomes="NOVEMBER";
		break;
	case "12":
		$nomes="DECEMBER";
		break;
}
$fechareturn=$nomes.' '.substr($fechanum,8,2).', '.substr($fechanum,0,4);
return $fechareturn;
}

function convershortdate($fechanum){
$mes=substr($fechanum,5,2);
switch($mes){
	case "01":
		$nomes="JAN";
		break;
	case "02":
		$nomes="FEB";
		break;
	case "03":
		$nomes="MAR";
		break;
	case "04":
		$nomes="APR";
		break;
	case "05":
		$nomes="MAY";
		break;
	case "06":
		$nomes="JUN";
		break;
	case "07":
		$nomes="JUL";
		break;
	case "08":
		$nomes="AUG";
		break;
	case "09":
		$nomes="SEP";
		break;
	case "10":
		$nomes="OCT";
		break;
	case "11":
		$nomes="NOV";
		break;
	case "12":
		$nomes="DEC";
		break;
}
$fechareturn=$nomes.' '.substr($fechanum,8,2).', '.substr($fechanum,0,4);
return $fechareturn;
}

function caledad($fechanaci){
	//fecha actual 
	$dia=date(d); 
	$mes=date(m); 
	$ano=date(Y); 

	$dianaz=substr($fechanaci,8,2);
	$mesnaz=substr($fechanaci,5,2);
	$anonaz=substr($fechanaci,0,4);

	//si el mes es el mismo pero el dia inferior aun no ha cumplido años, le quitaremos un año al actual 
	if (($mesnaz == $mes) && ($dianaz > $dia)) { 
	$ano=($ano-1); } 

	//si el mes es superior al actual tampoco abra cumplido años, por eso le quitamos un año al actual 
	if ($mesnaz > $mes) { 
	$ano=($ano-1);} 

	$edad=($ano-$anonaz); 
	return $edad; 
}
	
function ConvertirMes($MES)
{
	
	if (($MES == "JAN") or ($MES == "1"))
	$mes = 'ENERO';
	else if (($MES == "FEB") or ($MES == "2"))
	$mes = 'FEBRERO';
	else if (($MES == "MAR") or ($MES == "3"))
	$mes = 'MARZO';	
	else if (($MES == "APR") or ($MES == "4"))
	$mes = 'ABRIL';
	else if (($MES == "MAY") or ($MES == "5"))
	$mes = 'MAYO';							
	else if (($MES == "JUN") or ($MES == "6"))
	$mes = 'JUNIO';
	else if (($MES == "JUL") or ($MES == "7"))
	$mes = 'JULIO';	
	else if (($MES == "AUG") or ($MES == "8"))
	$mes = 'AGOSTO';
	else if (($MES == "SEP") or ($MES == "9"))
	$mes = 'SEPTIEMBRE';
	else if (($MES == "OCT") or ($MES == "10"))
	$mes = 'OCTUBRE';	
	else if (($MES == "NOV") or ($MES == "11"))
	$mes = 'NOVIEMBRE';
	else if (($MES == "DEC") or ($MES == "12"))
	$mes = 'DICIEMBRE';	

	return $mes;
	
}	

	






}

?>