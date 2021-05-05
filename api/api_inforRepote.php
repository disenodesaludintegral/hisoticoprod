<?php
ini_set('memory_limit', '-1');
header('Content-Type: application/json');
header("Content-Type: text/html;charset=utf-8");
define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);
include(ROOT_DIR."/includes/classes/plantrabajo.class.php");
include(ROOT_DIR."/includes/conexiones/plantrabajo.conexion.php");
include(ROOT_DIR.'/sistema/class/Usuarios.class.php');
require("include/ReporteadorHist.class.php");
/*Objetos de clases*/
$Usuarios = new Usuarios();
/*Variables*/
$arregloHospiatales = array();
$sesion = $Usuarios->getUserID();
if($sesion === false){
	die(json_encode($response));
}
else{
	$sesionName = $Usuarios->getNombreUsuario($sesion);
	$nivel = $Usuarios->getNivelDeUsuario($sesion);
	$sitios = $Usuarios->getSitios($sesion);
}

$ProyectosAsignados = ReporteadorHistorico::getSitiosAsignados($sesion);

if($ProyectosAsignados[0]['clave_hosp'] != NULL ){
	$HospitalesAsignados = ReporteadorHistorico::getSitiosAsignadosUsuarios($sesion);
}else{
	
	$HospitalesAsignados = ReporteadorHistorico::getSitiosAsignadosFull();	
}

/*Captar as vairbles de los filros*/

if($_GET['hosp'] == 'todos' && $_GET['mod'] == 'todos' && $_GET['mes'] == 'todos'){
	if($_GET['origen'] == 'estudios_local'){
		$EstudiosLocales = ReporteadorHistorico::getInfoAllLocal('estudios_local', "");
	}else{
		$EstudiocCentrales = ReporteadorHistorico::getInfoAllCentral('estudios', "");
	}
}
else if($_GET['hosp'] != 'todos' && $_GET['mod'] == 'todos' && $_GET['mes'] == 'todos'){

}
else if($_GET['hosp'] == 'todos' && $_GET['mod'] != 'todos' && $_GET['mes'] == 'todos'){

}
//echo var_dump($_GET);
//echo json_encode($response);
//die();

//$response['reporteLocal'] = $EstudiosLocales = ReporteadorHistorico::getInfoAllLocal('estudios_local', "");




$arrayMeses  = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO'];
foreach ($HospitalesAsignados as $key => $value) {
	//echo $value['hosp_alias'];
	array_push($arregloHospiatales, $value['hosp_alias']);
}

$acomodo = array(COULUMNAS =>[], FILAS =>[]);
$array = array(ESTUDIOS =>[
Enero => 0,
Febrero => 0,
Marzo => 0,
Abril => 0,
Mayo => 0,
Junio => 0,
Julio => 0,
Agosto => 0,
Septiembre => 0,
Octubre => 0,
Noviembre => 0,
Diciembre => 0]);

$response['Locales'] = $HospitalesAsignados;
$response['Centrales'] = $HospitalesAsignados;
/*Estudios Locales*/
foreach ($response['Locales']  as $key => $value) {
	$response{'Locales'}[$key][$value['hosp_alias']] = $array;
}

foreach ($EstudiosLocales as $kr => $estudio) {
	foreach ($response['Locales'] as $k => $locales) {
		if($estudio['Clave'] == $locales['hosp_alias']){
			if($estudio['Mes'] == $arrayMeses[0]){
				if($estudio['CUANTO'] > 0){
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Enero'] = $estudio['CUANTO'];
				}else{
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Enero'] = 0;
				}
			}else{
				$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Enero'];
			}	
			if($estudio['Mes'] == $arrayMeses[1]){
				if($estudio['CUANTO'] > 0){
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Febrero'] = $estudio['CUANTO'];
				}else{
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Febrero'] = 0;
				}
			}else{
				$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Febrero'];
			}
			if($estudio['Mes'] == $arrayMeses[2]){
				if($estudio['CUANTO'] > 0){
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Marzo'] = $estudio['CUANTO'];
				}else{
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Marzo'] = 0;
				}
			}else{
				$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Marzo'];
			}
			if($estudio['Mes'] == $arrayMeses[3]){
				if($estudio['CUANTO'] > 0){
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Abril'] = $estudio['CUANTO'];
				}else{
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Abril'] = 0;
				}
			}else{
				$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Abril'];
			}
			if($estudio['Mes'] == $arrayMeses[4]){
				if($estudio['CUANTO'] > 0){
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Mayo'] = $estudio['CUANTO'];
				}else{
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Mayo'] = 0;
				}
			}else{
				$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Mayo'];
			}
			if($estudio['Mes'] == $arrayMeses[5]){
				if($estudio['CUANTO'] > 0){
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Junio'] = $estudio['CUANTO'];
				}else{
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Junio'] = 0;
				}
			}else{
				$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Junio'];
			}
			if($estudio['Mes'] == $arrayMeses[6]){
				if($estudio['CUANTO'] > 0){
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Julio'] = $estudio['CUANTO'];
				}else{
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Julio'] = 0;
				}
			}else{
				$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Julio'];
			}
			if($estudio['Mes'] == $arrayMeses[7]){
				if($estudio['CUANTO'] > 0){
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Agosto'] = $estudio['CUANTO'];
				}else{
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Agosto'] = 0;
				}
			}else{
				$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Agosto'];
			}
			if($estudio['Mes'] == $arrayMeses[8]){
				if($estudio['CUANTO'] > 0){
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Septiembre'] = $estudio['CUANTO'];
				}else{
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Septiembre'] = 0;
				}
			}else{
				$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Septiembre'];
			}
			if($estudio['Mes'] == $arrayMeses[9]){
				if($estudio['CUANTO'] > 0){
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Octubre'] = $estudio['CUANTO'];
				}else{
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Octubre'] = 0;
				}
			}else{
				$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Mayo'];
			}
			if($estudio['Mes'] == $arrayMeses[10]){
				if($estudio['CUANTO'] > 0){
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Noviembre'] = $estudio['CUANTO'];
				}else{
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Noviembre'] = 0;
				}
			}else{
				$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Noviembre'];
			}
			if($estudio['Mes'] == $arrayMeses[11]){
				if($estudio['CUANTO'] > 0){
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Diciembre'] = $estudio['CUANTO'];
				}else{
					$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Diciembre'] = 0;
				}
			}else{
				$response{'Locales'}[$k][$estudio['Clave']]['ESTUDIOS']['Diciembre'];
			}
		}		
	}
}

/*Estudios Centrales*/
foreach ($response['Centrales']  as $key => $value) {
	$response{'Centrales'}[$key][$value['hosp_alias']] = $array;
}

foreach ($EstudiocCentrales as $kr => $estudio) {
	foreach ($response['Centrales'] as $k => $locales) {
		if($estudio['Clave'] == $locales['hosp_alias']){
			if($estudio['Mes'] == $arrayMeses[0]){
				if($estudio['CUANTO'] > 0){
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Enero'] = $estudio['CUANTO'];
				}else{
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Enero'] = 0;
				}
			}else{
				$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Enero'];
			}	
			if($estudio['Mes'] == $arrayMeses[1]){
				if($estudio['CUANTO'] > 0){
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Febrero'] = $estudio['CUANTO'];
				}else{
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Febrero'] = 0;
				}
			}else{
				$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Febrero'];
			}
			if($estudio['Mes'] == $arrayMeses[2]){
				if($estudio['CUANTO'] > 0){
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Marzo'] = $estudio['CUANTO'];
				}else{
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Marzo'] = 0;
				}
			}else{
				$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Marzo'];
			}
			if($estudio['Mes'] == $arrayMeses[3]){
				if($estudio['CUANTO'] > 0){
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Abril'] = $estudio['CUANTO'];
				}else{
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Abril'] = 0;
				}
			}else{
				$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Abril'];
			}
			if($estudio['Mes'] == $arrayMeses[4]){
				if($estudio['CUANTO'] > 0){
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Mayo'] = $estudio['CUANTO'];
				}else{
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Mayo'] = 0;
				}
			}else{
				$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Mayo'];
			}
			if($estudio['Mes'] == $arrayMeses[5]){
				if($estudio['CUANTO'] > 0){
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Junio'] = $estudio['CUANTO'];
				}else{
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Junio'] = 0;
				}
			}else{
				$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Junio'];
			}
			if($estudio['Mes'] == $arrayMeses[6]){
				if($estudio['CUANTO'] > 0){
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Julio'] = $estudio['CUANTO'];
				}else{
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Julio'] = 0;
				}
			}else{
				$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Julio'];
			}
			if($estudio['Mes'] == $arrayMeses[7]){
				if($estudio['CUANTO'] > 0){
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Agosto'] = $estudio['CUANTO'];
				}else{
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Agosto'] = 0;
				}
			}else{
				$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Agosto'];
			}
			if($estudio['Mes'] == $arrayMeses[8]){
				if($estudio['CUANTO'] > 0){
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Septiembre'] = $estudio['CUANTO'];
				}else{
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Septiembre'] = 0;
				}
			}else{
				$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Septiembre'];
			}
			if($estudio['Mes'] == $arrayMeses[9]){
				if($estudio['CUANTO'] > 0){
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Octubre'] = $estudio['CUANTO'];
				}else{
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Octubre'] = 0;
				}
			}else{
				$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Mayo'];
			}
			if($estudio['Mes'] == $arrayMeses[10]){
				if($estudio['CUANTO'] > 0){
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Noviembre'] = $estudio['CUANTO'];
				}else{
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Noviembre'] = 0;
				}
			}else{
				$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Noviembre'];
			}
			if($estudio['Mes'] == $arrayMeses[11]){
				if($estudio['CUANTO'] > 0){
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Diciembre'] = $estudio['CUANTO'];
				}else{
					$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Diciembre'] = 0;
				}
			}else{
				$response{'Centrales'}[$k][$estudio['Clave']]['ESTUDIOS']['Diciembre'];
			}
		}		
	}
}

echo json_encode($response);