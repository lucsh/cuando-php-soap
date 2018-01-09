<?php

$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data


//por defecto el dpto
$parada = ($parada) ?: 'N2894'; 
$linea = ($linea) ?: '17'; 

if (empty($_POST['parada']))
	$errors['parada'] = 'Ingresar el nro de parada';

if (empty($_POST['linea']))
	$errors['linea'] = 'Seleccionar la linea';


if ( ! empty($errors)) {

        // if there are items in our errors array, return those errors
	$data['success'] = false;
	$data['errors']  = $errors;
} else {
	$data['errors']  = $errors;

	$parada = htmlspecialchars($_REQUEST['parada']);
	$linea = htmlspecialchars($_REQUEST['linea']);


	switch ($linea) {
		case "1": 
		$linea = "1398";
		break; 
		case "2": 
		$linea = "1433";
		break; 
		case "3": 
		$linea = "1434";
		break; 
		case "4": 
		$linea = "1406";
		break; 
		case "6": 
		$linea = "1414";
		break; 
		case "8": 
		$linea = "1417";
		break; 
		case "9": 
		$linea = "1419";
		break; 
		case "12": 
		$linea = "1400";
		break; 
		case "13": 
		$linea = "1393";
		break; 
		case "14": 
		$linea = "1397";
		break; 
		case "15": 
		$linea = "1401";
		break; 
		case "17": 
		$linea = "1431";
		break; 
		case "18": 
		$linea = "1432";
		break; 
		case "101": 
		$linea = "1399";
		break; 
		case "102": 
		$linea = "1394";
		break; 
		case "401": 
		$linea = "1435";
		break; 
		case "404": 
		$linea = "1436";
		break; 
		case "501": 
		$linea = "1395";
		break; 
		case "502": 
		$linea = "1409";
		break; 
		case "516": 
		$linea = "1396";
		break; 
		case "50A": 
		$linea = "1410";
		break; 
		case "50B": 
		$linea = "1411";
		break; 
		case "5A": 
		$linea = "1412";
		break; 
		case "5B": 
		$linea = "1413";
		break; 
		case "5E": 
		$linea = "1408";
		break; 
		case "7A": 
		$linea = "1415";
		break; 
		case "7B": 
		$linea = "1416";
		break; 
		case "URBANO": 
		$linea = "1418";
		break;
		default: 
		$linea = "1431";
	}

$servicio="http://swandroidcuandollegasmp03.efibus.com.ar/Paradas.asmx?wsdl"; //url del servicio
$client = new SoapClient($servicio);
//$fcs = $client->__getFunctions();
//var_dump($fcs);
$namespace= 'http://tempuri.org/';
//Body of the Soap Header.
$headerbody = array('userName'=>'UsAnCL3280.',
	'password'=>'PsAnCL3280.');

//Create Soap Header.       
$header = new SOAPHeader($namespace, 'UserDetails', $headerbody);       

//set the Headers of Soap Client.
$client->__setSoapHeaders($header);


$data ['result'] = $client->RecuperarProximosArribos(array(
	identificadorParada => $parada, 
	codigoLineaParada => $linea, 
	codigoAplicacion => '0', 
	codigoEntidad => '15', 
	localidad => 'NEUQUEN'));

//echo 'parada ' . $parada;
//echo 'linea ' . $linea;

//var_dump($data);
//$data['errors']  = $errors; 
$data['success'] = true;
}
echo json_encode($data);
?>