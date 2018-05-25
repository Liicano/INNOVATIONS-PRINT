<?php
class numeros
{

function numeros()
{
	$this->Numero[0] = "Cero";
	$this->Numero[1] = "Uno";
	$this->Numero[2] = "Dos";
	$this->Numero[3] = "Tres";
	$this->Numero[4] = "Cuatro";
	$this->Numero[5] = "Cinco";
	$this->Numero[6] = "Seis";
	$this->Numero[7] = "Siete";
	$this->Numero[8] = "Ocho";
	$this->Numero[9] = "Nueve";
	$this->Numero[10] = "Diez";
	$this->Numero[11] = "Once";
	$this->Numero[12] = "Doce";
	$this->Numero[13] = "Trece";
	$this->Numero[14] = "Catorce";
	$this->Numero[15] = "Quince";
	$this->Numero[20] = "Veinte";
	$this->Numero[30] = "Treinta";
	$this->Numero[40] = "Cuarenta";
	$this->Numero[50] = "Cincuenta";
	$this->Numeros[60] = "Sesenta";
	$this->Numeros[70] = "Setenta";
	$this->Numero[80] = "Ochenta";
	$this->Numero[90] = "Noventa";
	$this->Numero[100] = "Ciento";
	$this->Numero[101] = "Quinientos";
	$this->Numero[102] = "Setecientos";
	$this->Numero[103] = "Novecientos";


}

function Centenas($VCentena) {

	$Numeros = $this->Numero;
If ($VCentena == 1) { return $Numeros[100]; }
Else If ($VCentena == 5) { return $Numeros[101];}
Else If ($VCentena == 7 ) {return ( $Numeros[102]); }
Else If ($VCentena == 9) {return ($Numeros[103]);}
Else {return $Numeros[$VCentena];}

}



function Unidades($VUnidad) {

	$Numeros = $this->Numero;
	
$tempo=$Numeros[$VUnidad];
return $tempo;
}

function Decenas($VDecena) {

	$Numeros = $this->Numero;
	
$tempo = ($Numeros[$VDecena]);
return $tempo;
}





function NumerosALetras($Numero){


$Decimales = 0;
//$Numero = intval($Numero);
$letras = "";

while ($Numero != 0){

// '*---> Validación si se pasa de 100 millones

If ($Numero >= 1000000000) {
$letras = "Error en Conversión a Letras";
$Numero = 0;
$Decimales = 0;
}

// '*---> Centenas de Millón
If (($Numero < 1000000000) And ($Numero >= 100000000)){
If ((Intval($Numero / 100000000) == 1) And (($Numero - (Intval($Numero / 100000000) * 100000000)) < 1000000)){
$letras .= (string) "cien millones ";
}
Else {
$letras = $letras & Centenas(Intval($Numero / 100000000));
If ((Intval($Numero / 100000000) <> 1) And (Intval($Numero / 100000000) <> 5) And (Intval($Numero / 100000000) <> 7) And (Intval($Numero / 100000000) <> 9)) {
$letras .= (string) "cientos ";
}
Else {
$letras .= (string) " ";
}
}
$Numero = $Numero - (Intval($Numero / 100000000) * 100000000);
}

// '*---> Decenas de Millón
If (($Numero < 100000000) And ($Numero >= 10000000)) {
If (Intval($Numero / 1000000) < 16) {
$tempo = $this->ecenas(Intval($Numero / 1000000));
$letras .= (string) $tempo;
$letras .= (string) " millones ";
$Numero = $Numero - (Intval($Numero / 1000000) * 1000000);
}
Else {
$letras = $letras & Decenas(Intval($Numero / 10000000) * 10);
$Numero = $Numero - (Intval($Numero / 10000000) * 10000000);
If ($Numero > 1000000) {
$letras .= $letras & " y ";
}
}
}

// '*---> Unidades de Millón
If (($Numero < 10000000) And ($Numero >= 1000000)) {
$tempo=(Intval($Numero / 1000000));
If ($tempo == 1) {
$letras .= (string) " Un millón ";
}
Else {
$tempo= $this->Unidades(Intval($Numero / 1000000));
$letras .= (string) $tempo;
$letras .= (string) " millones ";
}
$Numero = $Numero - (Intval($Numero / 1000000) * 1000000);
}

// '*---> Centenas de Millar
If (($Numero < 1000000) And ($Numero >= 100000)) {
$tempo=(Intval($Numero / 100000));
$tempo2=($Numero - ($tempo * 100000));
If (($tempo == 1) And ($tempo2 < 1000)) {
$letras .= (string) "Cien mil ";
}
Else {
$tempo=$this->Centenas(Intval($Numero / 100000));
$letras .= (string) $tempo;
$tempo=(Intval($Numero / 100000));
If (($tempo <> 1) And ($tempo <> 5) And ($tempo <> 7) And ($tempo <> 9)) {
$letras .= (string) "cientos ";
}
Else {
$letras .= (string) " ";
}
}
$Numero = $Numero - (Intval($Numero / 100000) * 100000);
}

// '*---> Decenas de Millar
If (($Numero < 100000) And ($Numero >= 10000)) {
$tempo= (Intval($Numero / 1000));
If ($tempo < 16) {
$tempo = $this->Decenas(Intval($Numero / 1000));
$letras .= (string) $tempo;
$letras .= (string) " mil ";
$Numero = $Numero - (Intval($Numero / 1000) * 1000);
}
Else {
$tempo = $this->Decenas(Intval($Numero / 10000) * 10);
$letras .= (string) $tempo;
$Numero = $Numero - (Intval(($Numero / 10000)) * 10000);
If ($Numero > 1000) {
$letras .= (string) " y ";
}
Else {
$letras .= (string) " mil ";

}
}
}


// '*---> Unidades de Millar
If (($Numero < 10000) And ($Numero >= 1000)) {
$tempo=(Intval($Numero / 1000));
If ($tempo == 1) {
$letras .= (string) "Un";
}
Else {
$tempo = $this->Unidades(Intval($Numero / 1000));
$letras .= (string) $tempo;
}
$letras .= (string) " mil ";
$Numero = $Numero - (Intval($Numero / 1000) * 1000);
}

// '*---> Centenas
If (($Numero < 1000) And ($Numero > 99)) {
If ((Intval($Numero / 100) == 1) And (($Numero - (Intval($Numero / 100) * 100)) < 1)) {
$letras = $letras & "Cien ";
}
Else {
$temp=(Intval($Numero / 100));
$l2=$this->Centenas($temp);
$letras .= (string) $l2;
If ((Intval($Numero / 100) <> 1) And (Intval($Numero / 100) <> 5) And (Intval($Numero / 100) <> 7) And (Intval($Numero / 100) <> 9)) {
$letras .= "Cientos ";
}
Else {
$letras .= (string) " ";
}
}

$Numero = $Numero - (Intval($Numero / 100) * 100);

}

// '*---> Decenas
If (($Numero < 100) And ($Numero > 9) ) {
If ($Numero < 16 ) {
$tempo = $this->Decenas(Intval($Numero));
$letras .= $tempo;
$Numero = $Numero - Intval($Numero);
}
Else {
$tempo= $this->Decenas(Intval(($Numero / 10)) * 10);
$letras .= (string) $tempo;
$Numero = $Numero - (Intval(($Numero / 10)) * 10);
If ($Numero > 0.99) {
$letras .=(string) " y ";

}
}
}

// '*---> Unidades
If (($Numero < 10) And ($Numero > 0.99)) {
$tempo=$this->Unidades(Intval($Numero));
$letras .= (string) $tempo;


$Numero = $Numero - Intval($Numero);
}

$letras .= (string) " Balboa";

$Decimales = ($Numero - Intval($Numero));
// '*---> Decimales
If ($Decimales > 0) {

	$letras .=(string) " con ";
	$Decimales= $Decimales*100;
	//echo ("*");
	$Decimales = number_format($Decimales, 2);
	//echo ($Decimales);
	
	If (($Decimales < 100) And ($Decimales > 9) ) {
	If ($Decimales < 16 ) {
	$tempo = $this->Decenas(Intval($Decimales));
	$letras .= $tempo;
	$Decimales = $Decimales - Intval($Decimales);
	}
	Else {
	$tempo= $this->Decenas(Intval(($Decimales / 10)) * 10);
	$letras .= (string) $tempo;
	$Decimales = $Decimales - (Intval(($Decimales / 10)) * 10);
	If ($Decimales > 0.99) {
	$letras .=(string) " y ";

	}
	}
	}	
	
	// '*---> Unidades
	If (($Decimales < 10) And ($Decimales > 0.99)) {
	$tempo=$this->Unidades(Intval($Decimales));
	$letras .= (string) $tempo;

	$Decimales = $Decimales - Intval($Decimales);
	}	
	//$tempo = $this->Decenas(Intval($Decimales));
	//$letras .= (string) $tempo;
	$letras .= (string) " centavos";
}
Else {
If (($letras <> "Error en Conversión a Letras") And (strlen(Trim($letras)) > 0)) {
$letras .= (string) " ";

}
}
return $letras;
}
}

/*
//favor de teclear a mano la cantidad numerica a convertir y asignarla a $tt
$tt = 151.21;

$tt = $tt+0.009;
$Numero = intval($tt);
$Decimales = $tt - Intval($tt);
$Decimales= $Decimales*100;
$Decimales= Intval($Decimales);
$x=NumerosALetras($Numero);
echo ($x);
If ($Decimales > 0){

$y=NumerosALetras($Decimales);
echo (" pesos con ");
echo ($y);
echo (" centavos");
}
else {
echo ("cero centavos");
}
*/
}
?>