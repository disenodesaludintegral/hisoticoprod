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
$response['Modalidades'] = ReporteadorHistorico::getModalidades();	
$response['anu'] = ['2019','2020','2021'];
$response['mes'] = [Enero => '01',
Febrero => '02',
Marzo => '03',
Abril => '04',
Mayo => '05',
Junio => '06',
Julio => '07',
Agosto => '08',
Septiembre => '09',
Octubre => '10',
Noviembre => '11',
Diciemre => '12'];
if($ProyectosAsignados[0]['clave_hosp'] != NULL ){
	$HospitalesAsignados = ReporteadorHistorico::getSitiosAsignadosUsuarios($sesion);
}else{
	
	$HospitalesAsignados = ReporteadorHistorico::getSitiosAsignadosFull();	
}
foreach ($HospitalesAsignados as $key => $value) {
	if(substr($value['hosp_alias'], 0, 4) == 'ISEM'){
		$response{'Poryectos'}['ISEM'][] = $value['hosp_alias'];
	}
	else if(substr($value['hosp_alias'], 0, 4) == 'HIDA'){
		$response{'Poryectos'}['HIDA'][] = $value['hosp_alias'];
	}
	else if(substr($value['hosp_alias'], 0, 4) == 'CHIS'){
		$response{'Poryectos'}['CHIS'][] = $value['hosp_alias'];
	}
	else if(substr($value['hosp_alias'], 0, 4) == 'MICH'){
		$response{'Poryectos'}['MICH'][] = $value['hosp_alias'];
	}
}




echo json_encode($response);