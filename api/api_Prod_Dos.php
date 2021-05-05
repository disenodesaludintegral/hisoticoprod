<?php
ini_set('memory_limit', '-1');
header('Content-Type: application/json');
define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);
include_once(ROOT_DIR."/includes/classes/productividad_historico.class.php");
include_once(ROOT_DIR.'/sistema/class/Usuarios.class.php');
$Usuarios = new Usuarios();
$sesion = $Usuarios->getUserID();
//$sitDos = Productividad::getSitiosUsu($sesion);
if($sesion == 520){
  $sit = Productividad::getAllHospMich();
}else if($sesion == 339){
  $sit = Productividad::getAllHospHida();
}else{
  $sit = Productividad::getAllHosp();
}
foreach ($sit as $key => $value) {
  $sitios[]=$value['clave'];
}
foreach ($sitios as $key => $value) {
      if(substr($value,0,4) != "TLAX" &&substr($value,0,4) != "TEST" &&substr($value,0,3) != "MOD" ){
        if (isset($_GET['p'])&&$_GET['p']!="todos") {
          if(substr($value,0,4)==$_GET['p']){
            $cat_hospitales[] = array("clave"=>$value,"nombre_corto"=>Productividad::getHospByClave($value)[0]['nombre_corto']);
          }
        }else{
          $cat_hospitales[] = array("clave"=>$value,"nombre_corto"=>Productividad::getHospByClave($value)[0]['nombre_corto']); 
        }
      }
    }
/*$sesion = $Usuarios->getUserID();
if($sesion === false){
  $response['success'] = 1000;
    die(json_encode($response));
}else{
    $sitios = $Usuarios->getSitios($sesion);
    foreach ($sitios as $key => $value) {
      if(substr($value,0,4) != "TLAX" &&substr($value,0,4) != "TEST" &&substr($value,0,3) != "MOD" ){
        if (isset($_GET['p'])&&$_GET['p']!="todos") {
          if(substr($value,0,4)==$_GET['p']){
            $cat_hospitales[] = array("clave"=>$value,"nombre_corto"=>Productividad::getHospByClave($value)[0]['nombre_corto']);
          }
        }else{
          $cat_hospitales[] = array("clave"=>$value,"nombre_corto"=>Productividad::getHospByClave($value)[0]['nombre_corto']); 
        }
      }
    }
}*/
function getFullMes($mes){
  switch($mes){
    case '01': return "Enero"; break;
    case '02': return "Febrero"; break;
    case '03': return "Marzo"; break;
    case '04': return "Abril"; break;
    case '05': return "Mayo"; break;
    case '06': return "Junio"; break;
    case '07': return "Julio"; break;
    case '08': return "Agosto"; break;
    case '09': return "Septiembre"; break;
    case '10': return "Octubre"; break;
    case '11': return "Noviembre"; break;
    case '12': return "Diciembre"; break;
    }
}
function getDiaSem($dia){
  switch($dia){
    case 1: return "L"; break;
    case 2: return "M"; break;
    case 3: return "Mi"; break;
    case 4: return "J"; break;
    case 5: return "V"; break;
    case 6: return "S"; break;
    case 7: return "D"; break;
    }
}
function getMes($mes){
  switch($mes){
    case '01': return "Ene"; break;
    case '02': return "Feb"; break;
    case '03': return "Mar"; break;
    case '04': return "Abr"; break;
    case '05': return "May"; break;
    case '06': return "Jun"; break;
    case '07': return "Jul"; break;
    case '08': return "Ago"; break;
    case '09': return "Sep"; break;
    case '10': return "Oct"; break;
    case '11': return "Nov"; break;
    case '12': return "Dic"; break;
    }
}
function getInfoMes($mes_m){
switch($mes_m){
    case '01': return '31'; break;
    case '02': if(intval($_GET['anio'])%4==0){return '29';}else{return '28';} break;
    case '03': return '31'; break;
    case '04': return '30'; break;
    case '05': return '31'; break;
    case '06': return '30'; break;
    case '07': return '31'; break;
    case '08': return '31'; break;
    case '09': return '30'; break;
    case '10': return '31'; break;
    case '11': return '30'; break;
    case '12': return '31'; break;
    }
}
function getMarkers($arr_it,$totals){
  $auxm = array();
  $auxM = array();
  $prod = array();
  if($arr_it!=false&&$totals!=false){
    foreach ($arr_it as $key => $value) {
      foreach ($value['por_dia'] as $key2 => $value2){
        if(!isset($prod[$key2])){
          $k = $value2==0?0:1;
          $prod[$key2]=$k;
        }else{
          $k = $value2==0?0:1;
          $prod[$key2]+=$k;
        }
        if(!isset($auxm[$key2])){
            $auxm[$key2][]=$value2;
        }else{
            array_push($auxm[$key2],$value2);
            sort($auxm[$key2]);
        }
      }
    }
    foreach ($totals as $key => $value){
      foreach ($prod as $key2 => $value2){
        if($value2 != 0 && $key == $key2){
          $prod[$key2]=$value/$value2;
        }
      }
    }
    foreach ($auxm as $key => $value){
      $auxM[$key]= $value[count($value)-1];
      for ($i=0; $i<count($value); $i++) {
        if($value[$i]<$value[$i+1]){
          if($value[$i]==0&&($value[$i+1]<$prod[$key])){
             $auxm[$key]=$value[$i+1];
            break;
          }else{
            $auxm[$key]=$value[$i];
            break;
          }
        }elseif($value[$i]==$value[$i+1]&&$value[$i]!=0){
          $auxm[$key]=$value[$i];
        }elseif ($value[0]==0&&$value[count($value)-1]==0){
          $auxm[$key]=0;
          break;
        }else{
          $auxm[$key]=$value[0];
        }
      }
    }
  }
  $aux['prod']=$prod;
  $aux['min']=$auxm;
  $aux['max']=$auxM;
  return $aux;
}
function getEsperados($anio,$mes,$hospitales_asignados,$hospital,$modalidad){
  $periodo = "AND a.consecutivo LIKE '%".$anio.$mes."%'";
  $esp = Productividad::getEsperadosProductividad($hospitales_asignados,$hospital,$modalidad,$periodo,'AND hora_pro = 23');
  if(count($esp)>0){
    $r = $esp; 
  }else{
    if($mes == "01"){
      $mes = "12"; 
      $anio--;
    }else{
      $mes = intval($mes)-1;
    }
    if($anio == 2014){
      $r = false;
    }else{
      $r = getEsperados($anio,substr("0".$mes,-2),$hospitales_asignados,$hospital,$modalidad);
    }
  }
  return $r;
}
// SECCION DE FILTROS
$dias_f = Productividad::getDiasFestivos();
if($dias_f!=false){
  foreach ($dias_f as $key => $value) {
    $cat_festivos[] = $value['fecha_festivo'];
  }
}else{
  $cat_festivos = [];
}
//echo json_encode(Productividad::getDiasFestivos());die();
$cat_modalidades = Productividad::getCatModalidades();
$cat_modalidades = isset($_GET['mod'])&&$_GET['mod']!="todos"?array(array("alias"=>$_GET['mod'],"modalidad"=>Productividad::getModByAlias($_GET['mod'])[0]['modalidad'])):$cat_modalidades;
$cat_hospitales = isset($_GET['h'])&&$_GET['h']!="todos"?array(array("clave"=>$_GET['h'],"nombre_corto"=>Productividad::getHospByClave($_GET['h'])[0]['nombre_corto'])):$cat_hospitales;
$referencia=isset($_GET['r'])?$_GET['r']:"real";
$mes_aux = isset($_GET['m'])&&$_GET['m']!="todos"?$_GET['m']:date('m');
$anio_aux = isset($_GET['a'])?$_GET['a']:date("Y");
$agrupar_meses = $_GET['m']=="todos"?true:false;
$origen = isset($_GET['o'])?$_GET['o']:"estudios";
$tipo_fecha = isset($_GET['t_f'])?$_GET['t_f']:"study_Date_Time";
if($agrupar_meses){
    for ($i=1; $i<=12; $i++) { 
      $response['encabezados'][]=getFullMes($i)." ".$anio_aux;
      $response['totales'][$i] = 0;
      $response['totales_contrast'][$i] = 0; 
    }
  }else{
    for ($i=1; $i<=getInfoMes($mes_aux); $i++) { 
      $response['encabezados'][]= substr("0".$i,-2)." (".getDiaSem(date("N",strtotime($anio_aux."-".$mes_aux."-".$i))).")";
      $response['totales'][$i] = 0; 
      $response['totales_contrast'][$i] = 0; 

    }
  }

  //echo json_encode($response);
  //die();
  //echo(json_encode($cat_hospitales));die();
//---->
// INICIALIZANDO CON 0
$response['total']=0;
if($agrupar_meses){
  //agrupa para la pestaña de x hospital
  foreach ($cat_hospitales as $key => $value) {
    $response['por_hospital']['desglose'][$value['clave']]['nombre_corto']=$value['nombre_corto'];
    $response['por_hospital']['desglose'][$value['clave']]['total']=0;
    for ($i=1; $i<=12; $i++) { 
      $response['por_hospital']['desglose'][$value['clave']]['por_dia'][$i]=0;
    }
    //agrupa para la pestaña de x hospital x mod
    foreach ($cat_modalidades as $key2 => $value2) {
      $response['por_hospital']['desglose'][$value['clave']]['por_modalidad'][$value2['alias']]['modalidad']=$value2['modalidad'];
      $response['por_hospital']['desglose'][$value['clave']]['por_modalidad'][$value2['alias']]['total']=0;
       for ($i=1; $i<=12; $i++) { 
         $response['por_hospital']['desglose'][$value['clave']]['por_modalidad'][$value2['alias']]['por_dia'][$i]=0;
      }
    }
  }

  //agrupa para la pestaña de x mod
  foreach ($cat_modalidades as $key => $value) {
    $response['por_modalidad']['desglose'][$value['alias']]['modalidad']=$value['modalidad'];
    $response['por_modalidad']['desglose'][$value['alias']]['total']=0;
    for ($i=1; $i<=12; $i++) { 
      $response['por_modalidad']['desglose'][$value['alias']]['por_dia'][$i]=0;
    }
    //agrupa para la pestaña de x mod x hosp
    foreach ($cat_hospitales as $key2 => $value2) {
      $response['por_modalidad']['desglose'][$value['alias']]['por_hospital'][$value2['clave']]['nombre_corto']=$value2['nombre_corto'];
      $response['por_modalidad']['desglose'][$value['alias']]['por_hospital'][$value2['clave']]['total']=0;
       for ($i=1; $i<=12; $i++) { 
         $response['por_modalidad']['desglose'][$value['alias']]['por_hospital'][$value2['clave']]['por_dia'][$i]=0;
      }
    }
  }
  //agrupa para la pestaña de contrastados x mod
  foreach ($cat_modalidades as $key => $value) {
    $response['por_modalidad_contrast']['desglose'][$value['alias']]['modalidad']=$value['modalidad'];
    $response['por_modalidad_contrast']['desglose'][$value['alias']]['total']=0;
    for ($i=1; $i<=12; $i++) { 
      $response['por_modalidad_contrast']['desglose'][$value['alias']]['por_dia'][$i]=0;
    }
    //agrupa para la pestaña de x mod x hosp
    foreach ($cat_hospitales as $key2 => $value2) {
      $response['por_modalidad_contrast']['desglose'][$value['alias']]['por_hospital'][$value2['clave']]['nombre_corto']=$value2['nombre_corto'];
      $response['por_modalidad_contrast']['desglose'][$value['alias']]['por_hospital'][$value2['clave']]['total']=0;
       for ($i=1; $i<=12; $i++) { 
         $response['por_modalidad_contrast']['desglose'][$value['alias']]['por_hospital'][$value2['clave']]['por_dia'][$i]=0;
      }
    }
  }
  //agrupa para la pestaña de x hora 
  for ($h=0; $h<=23; $h++) {
    $response['por_hora']['desglose'][$h]['total']=0;
    for ($i=1; $i<=12; $i++) { 
      $response['por_hora']['desglose'][$h]['por_dia'][$i]=0;
    }
    foreach ($cat_hospitales as $key2 => $value2) {
      $response['por_hora']['desglose'][$h]['por_hospital'][$value2['clave']]['nombre_corto']=$value2['nombre_corto'];
      $response['por_hora']['desglose'][$h]['por_hospital'][$value2['clave']]['total']=0;
       for ($i=1; $i<=12; $i++) { 
         $response['por_hora']['desglose'][$h]['por_hospital'][$value2['clave']]['por_dia'][$i]=0;
      }
    }
  }
}else{
  foreach ($cat_hospitales as $key => $value) {
    $response['por_hospital']['desglose'][$value['clave']]['nombre_corto']=$value['nombre_corto'];
    $response['por_hospital']['desglose'][$value['clave']]['total']=0;
    for ($i=1; $i<=getInfoMes($mes_aux); $i++) { 
      $response['por_hospital']['desglose'][$value['clave']]['por_dia'][$i]=0;
    }
    foreach ($cat_modalidades as $key2 => $value2) {
      $response['por_hospital']['desglose'][$value['clave']]['por_modalidad'][$value2['alias']]['modalidad']=$value2['modalidad'];
      $response['por_hospital']['desglose'][$value['clave']]['por_modalidad'][$value2['alias']]['total']=0;
       for ($i=1; $i<=getInfoMes($mes_aux); $i++) { 
         $response['por_hospital']['desglose'][$value['clave']]['por_modalidad'][$value2['alias']]['por_dia'][$i]=0;
      }
    }
  }
  foreach ($cat_modalidades as $key => $value) {
    $response['por_modalidad']['desglose'][$value['alias']]['modalidad']=$value['modalidad'];
    $response['por_modalidad']['desglose'][$value['alias']]['total']=0;
    for ($i=1; $i<=getInfoMes($mes_aux); $i++) { 
      $response['por_modalidad']['desglose'][$value['alias']]['por_dia'][$i]=0;
    }
    foreach ($cat_hospitales as $key2 => $value2) {
      $response['por_modalidad']['desglose'][$value['alias']]['por_hospital'][$value2['clave']]['nombre_corto']=$value2['nombre_corto'];
      $response['por_modalidad']['desglose'][$value['alias']]['por_hospital'][$value2['clave']]['total']=0;
       for ($i=1; $i<=getInfoMes($mes_aux); $i++) { 
         $response['por_modalidad']['desglose'][$value['alias']]['por_hospital'][$value2['clave']]['por_dia'][$i]=0;
      }
    }
  }
   foreach ($cat_modalidades as $key => $value) {
    $response['por_modalidad_contrast']['desglose'][$value['alias']]['modalidad']=$value['modalidad'];
    $response['por_modalidad_contrast']['desglose'][$value['alias']]['total']=0;
    for ($i=1; $i<=getInfoMes($mes_aux); $i++) { 
      $response['por_modalidad_contrast']['desglose'][$value['alias']]['por_dia'][$i]=0;
    }
    foreach ($cat_hospitales as $key2 => $value2) {
      $response['por_modalidad_contrast']['desglose'][$value['alias']]['por_hospital'][$value2['clave']]['nombre_corto']=$value2['nombre_corto'];
      $response['por_modalidad_contrast']['desglose'][$value['alias']]['por_hospital'][$value2['clave']]['total']=0;
       for ($i=1; $i<=getInfoMes($mes_aux); $i++) { 
         $response['por_modalidad_contrast']['desglose'][$value['alias']]['por_hospital'][$value2['clave']]['por_dia'][$i]=0;
      }
    }
  }
  for ($h=0; $h<=23; $h++) {
    $response['por_hora']['desglose'][$h]['total']=0;
    for ($i=1; $i<=getInfoMes($mes_aux); $i++) {  
      $response['por_hora']['desglose'][$h]['por_dia'][$i]=0;
    }
    foreach ($cat_hospitales as $key2 => $value2) {
      $response['por_hora']['desglose'][$h]['por_hospital'][$value2['clave']]['nombre_corto']=$value2['nombre_corto'];
      $response['por_hora']['desglose'][$h]['por_hospital'][$value2['clave']]['total']=0;
       for ($i=1; $i<=getInfoMes($mes_aux); $i++) {  
         $response['por_hora']['desglose'][$h]['por_hospital'][$value2['clave']]['por_dia'][$i]=0;
      }
    }
  }
}
//echo json_encode($response);die();
// ---->
switch ($referencia) {
  case 'real': 
    $modalidad = "AND a.modality IN (";
    foreach ($cat_modalidades as $key => $value) {
      $modalidad.="'".$value['alias']."',";
    }
    $hospitales_asignados = "AND a.clave IN (";
    foreach ($cat_hospitales as $key => $value) {
      $hospitales_asignados.="'".$value['clave']."',"; 
    }
    $hospitales_asignados = substr($hospitales_asignados,0,strlen($hospitales_asignados)-1).")";
    $modalidad=substr($modalidad,0,strlen($modalidad)-1).")";
    $hospital = isset($_GET['p'])&&$_GET['p']!='todos'?"AND a.accession_No LIKE '%".$_GET['p']."%'":"";
    $hospital = isset($_GET['h'])&&$_GET['h']!='todos'?"AND a.accession_No LIKE '%".$_GET['h']."%'":$hospital;
    $anio = isset($_GET['a'])?"AND YEAR($tipo_fecha) = ".$_GET['a']:"AND YEAR($tipo_fecha) = ".date('Y');
    $mes = isset($_GET['m'])?"AND MONTH($tipo_fecha) = ".$_GET['m']:"AND MONTH($tipo_fecha) = ".date('m');
    $mes = $_GET['m']=="todos"?"":$mes;
    $dia = $mes_aux==date('m')?"AND DAY($tipo_fecha)<".date('d'):"";
    $estudios = Productividad::getEstudiosProductividad($hospitales_asignados,$hospital,$modalidad,$origen,$tipo_fecha,$anio,$mes,$dia);
    /*foreach ($estudios as $key => $value) {
      //var_dump($value['p_c']);
      if (strpos($value['p_c'], 'CONTRAS') !== false) {
      //echo strpos($value['p_c'], 'contras');
        echo $value['p_c'];
      }
    }
    //echo json_encode($estudios);
    echo "ya termino";
    die();*/
    if(count($estudios)>0){
      if($agrupar_meses){
        foreach ($estudios as $key => $value) {
          $response['total']++;
          $response['totales'][$value['mes']]++;


          $response['por_hospital']['desglose'][$value['sitio']]['total']++;
          $response['por_hospital']['desglose'][$value['sitio']]['por_dia'][$value['mes']]++;
          $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['total']++;
          $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['por_dia'][$value['mes']]++;

          $response['por_modalidad']['desglose'][$value['modalidad']]['total']++;
          $response['por_modalidad']['desglose'][$value['modalidad']]['por_dia'][$value['mes']]++;
          $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['total']++;
          $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['por_dia'][$value['mes']]++;

          if (strpos(strtoupper($value['p_c']), 'CONTRAS') !== false || $value['modi'] == 'CTC' || $value['modi'] == 'CRC' || $value['modi'] == 'DXC' || $value['modi'] == 'MGC' || $value['modi'] == 'MRC' || $value['modi'] == 'RFC' || $value['modi'] == 'OTC' || $value['modi'] == 'USC' || $value['modi'] == 'XAC') {
            
            $response['total_contrast']++;
            $response['totales_contrast'][$value['mes']]++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['total']++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['por_dia'][$value['mes']]++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['total']++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['por_dia'][$value['mes']]++;
          }

          $response['por_hora']['desglose'][$value['hora']]['total']++;
          $response['por_hora']['desglose'][$value['hora']]['por_dia'][$value['mes']]++;
          $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['total']++;
          $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['por_dia'][$value['mes']]++;
        }
      }else{
        foreach ($estudios as $key => $value) {
          $response['total']++;
          $response['totales'][$value['dia']]++;

         

          $response['por_hospital']['desglose'][$value['sitio']]['total']++;
          $response['por_hospital']['desglose'][$value['sitio']]['por_dia'][$value['dia']]++;
          $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['total']++;
          $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['por_dia'][$value['dia']]++;

          $response['por_modalidad']['desglose'][$value['modalidad']]['total']++;
          $response['por_modalidad']['desglose'][$value['modalidad']]['por_dia'][$value['dia']]++;
          $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['total']++;
          $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['por_dia'][$value['dia']]++;

          if (strpos(strtoupper($value['p_c']), 'CONTRAS') !== false || $value['modi'] == 'CTC' || $value['modi'] == 'CRC' || $value['modi'] == 'DXC' || $value['modi'] == 'MGC' || $value['modi'] == 'MRC' || $value['modi'] == 'RFC' || $value['modi'] == 'OTC' || $value['modi'] == 'USC' || $value['modi'] == 'XAC') {
            // Aqui entro //
            
             $response['total_contrast']++;
             $response['totales_contrast'][$value['dia']]++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['total']++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['por_dia'][$value['dia']]++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['total']++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['por_dia'][$value['dia']]++;
          }

          $response['por_hora']['desglose'][$value['hora']]['total']++;
          $response['por_hora']['desglose'][$value['hora']]['por_dia'][$value['dia']]++;
          $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['total']++;
          $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['por_dia'][$value['dia']]++;
        }
      }
    }
  break;
  case 'esperado':
    $modalidad = "AND a.mod_pro IN (";
    foreach ($cat_modalidades as $key => $value) {
      $modalidad.="'".$value['alias']."',";
    }
    $modalidad=substr($modalidad,0,strlen($modalidad)-1).")";
    $hospitales_asignados = "AND a.hosp_pro IN (";
    foreach ($cat_hospitales as $key => $value) {
      $hospitales_asignados.="'".$value['clave']."',"; 
    }
    $hospitales_asignados = substr($hospitales_asignados,0,strlen($hospitales_asignados)-1).")";
    $hospital = isset($_GET['p'])&&$_GET['p']!='todos'?"AND a.hosp_pro LIKE '%".$_GET['p']."%'":"";
    $hospital = isset($_GET['h'])&&$_GET['h']!='todos'?"AND a.hosp_pro LIKE '%".$_GET['h']."%'":$hospital;
    $anio = isset($_GET['a'])?$_GET['a']:date('Y');
    $mes = isset($_GET['m'])?$_GET['m']:date('m');
    $mes = $_GET['m']=="todos"?"":$mes;
    $esperados = getEsperados($anio,$mes,$hospitales_asignados,$hospital,$modalidad);
    //echo json_encode($esperados);die();
    if($esperados!=false){
       if($agrupar_meses){
        foreach ($esperados as $key => $value) {
            $m = $value['mes'];
            $var_dia = $m==date('m')?date('d'):getInfoMes($m);
            for ($d=1;$d<=$var_dia;$d++) { 
              $d_s = in_array($anio_aux."-".substr("0".$m,-2)."-".$d,$cat_festivos) ? 0 : date('w',strtotime($anio_aux."-".substr("0".$m,-2)."-".$d));
              if($value['dia_s']==$d_s){
                $var_hora = $m==date('m')&&$d==date('d')?date('H'):23;
                if($value['hora']==$var_hora){
                  $response['total']+=$value['valor'];
                  $response['totales'][$value['mes']]+=$value['valor'];

                  $response['por_hospital']['desglose'][$value['sitio']]['total']+=$value['valor'];
                  $response['por_hospital']['desglose'][$value['sitio']]['por_dia'][$value['mes']]+=$value['valor'];
                  $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['total']+=$value['valor'];
                  $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['por_dia'][$value['mes']]+=$value['valor'];

                  $response['por_modalidad']['desglose'][$value['modalidad']]['total']+=$value['valor'];
                  $response['por_modalidad']['desglose'][$value['modalidad']]['por_dia'][$value['mes']]+=$value['valor'];
                  $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['total']+=$value['valor'];
                  $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['por_dia'][$value['mes']]+=$value['valor'];
                }
                if($value['hora']<=$var_hora){
                  $response['por_hora']['desglose'][$value['hora']]['total']+=$value['valor'];
                  $response['por_hora']['desglose'][$value['hora']]['por_dia'][$value['mes']]+=$value['valor'];
                  $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['total']+=$value['valor'];
                  $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['por_dia'][$value['mes']]+=$value['valor'];
                }
              }
            }
        }
      }else{
        $var_dia = $mes_aux==date('m')?date('d'):getInfoMes($mes_aux);
        foreach ($esperados as $key => $value) {      
          for ($i=1; $i<=$var_dia; $i++) {  
            $d_s = in_array($anio_aux."-".$mes_aux."-".$i,$cat_festivos) ? 0 : date('w',strtotime($anio_aux."-".$mes_aux."-".$i));
            if($value['dia_s']==$d_s){
              $var_hora = $mes_aux==date('m')&&$i==date('d')?date('H'):23;
              if($value['hora']==$var_hora){
                $response['total']+=$value['valor'];
                $response['totales'][$i]+=$value['valor'];

                $response['por_hospital']['desglose'][$value['sitio']]['total']+=$value['valor'];
                $response['por_hospital']['desglose'][$value['sitio']]['por_dia'][$i]+=$value['valor'];
                $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['total']+=$value['valor'];
                $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['por_dia'][$i]+=$value['valor'];

                $response['por_modalidad']['desglose'][$value['modalidad']]['total']+=$value['valor'];
                $response['por_modalidad']['desglose'][$value['modalidad']]['por_dia'][$i]+=$value['valor'];
                $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['total']+=$value['valor'];
                $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['por_dia'][$i]+=$value['valor'];                
              }
              if($value['hora']<=$var_hora){
                $response['por_hora']['desglose'][$value['hora']]['total']+=$value['valor'];
                $response['por_hora']['desglose'][$value['hora']]['por_dia'][$i]+=$value['valor'];
                $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['total']+=$value['valor'];
                $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['por_dia'][$i]+=$value['valor'];
              }
            }
          }
        }
      }
      krsort($response['por_hora']['desglose']);
      foreach ($response['por_hora']['desglose'] as $key => $value) {
        if($key!="00"){
          $nk = substr("0".intval($key)-1,-2);
          if($response['por_hora']['desglose'][$key]['total']>0){
            $response['por_hora']['desglose'][$key]['total']-=$response['por_hora']['desglose'][$nk]['total'];
          }
          foreach ($value['por_dia'] as $key2 => $value2) {
            if($response['por_hora']['desglose'][$key]['por_dia'][$key2]>0){
            $response['por_hora']['desglose'][$key]['por_dia'][$key2]-=$response['por_hora']['desglose'][$nk]['por_dia'][$key2];
            }
          }
          foreach ($value['por_hospital'] as $key2 => $value2) {
            if($response['por_hora']['desglose'][$key]['por_hospital'][$key2]['total']>0){
              $response['por_hora']['desglose'][$key]['por_hospital'][$key2]['total']-=$response['por_hora']['desglose'][$nk]['por_hospital'][$key2]['total'];
            }
            foreach ($value['por_dia'] as $key2 => $value2) { 
              if($response['por_hora']['desglose'][$key]['por_hospital'][$key2]['por_dia'][$key3]>0){
                $response['por_hora']['desglose'][$key]['por_hospital'][$key2]['por_dia'][$key3]-=$response['por_hora']['desglose'][$nk]['por_hospital'][$key2]['por_dia'][$key3];
              }
            }
          }
        } 
      }
      ksort($response['por_hora']['desglose']);
    }
  break;
  case 'diferencia':
    $modalidad = "AND a.modality IN (";
    foreach ($cat_modalidades as $key => $value) {
      $modalidad.="'".$value['alias']."',";
    }
    $hospitales_asignados = "AND a.clave IN (";
    foreach ($cat_hospitales as $key => $value) {
      $hospitales_asignados.="'".$value['clave']."',"; 
    }
    $hospitales_asignados = substr($hospitales_asignados,0,strlen($hospitales_asignados)-1).")";
    $modalidad=substr($modalidad,0,strlen($modalidad)-1).")";
    $hospital = isset($_GET['p'])&&$_GET['p']!='todos'?"AND a.accession_No LIKE '%".$_GET['p']."%'":"";
    $hospital = isset($_GET['h'])&&$_GET['h']!='todos'?"AND a.accession_No LIKE '%".$_GET['h']."%'":$hospital;
    $anio = isset($_GET['a'])?"AND YEAR($tipo_fecha) = ".$_GET['a']:"AND YEAR($tipo_fecha) = ".date('Y');
    $mes = isset($_GET['m'])?"AND MONTH($tipo_fecha) = ".$_GET['m']:"AND MONTH($tipo_fecha) = ".date('m');
    $mes = $_GET['m']=="todos"?"":$mes;
    $dia = $mes_aux==date('m')?"AND DAY($tipo_fecha)<".date('d'):"";
    $estudios = Productividad::getEstudiosProductividad($hospitales_asignados,$hospital,$modalidad,$origen,$tipo_fecha,$anio,$mes,$dia);
    if($estudios!=false){
      if($agrupar_meses){
        foreach ($estudios as $key => $value) {
          $response['total']++;
          $response['totales'][$value['mes']]++;

          $response['por_hospital']['desglose'][$value['sitio']]['total']++;
          $response['por_hospital']['desglose'][$value['sitio']]['por_dia'][$value['mes']]++;
          $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['total']++;
          $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['por_dia'][$value['mes']]++;

          $response['por_modalidad']['desglose'][$value['modalidad']]['total']++;
          $response['por_modalidad']['desglose'][$value['modalidad']]['por_dia'][$value['mes']]++;
          $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['total']++;
          $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['por_dia'][$value['mes']]++;

          if (strpos(strtoupper($value['p_c']), 'CONTRAS') !== false || $value['modi'] == 'CTC' || $value['modi'] == 'CRC' || $value['modi'] == 'DXC' || $value['modi'] == 'MGC' || $value['modi'] == 'MRC' || $value['modi'] == 'RFC' || $value['modi'] == 'OTC' || $value['modi'] == 'USC' || $value['modi'] == 'XAC') {
            
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['total']++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['por_dia'][$value['mes']]++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['total']++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['por_dia'][$value['mes']]++;

          }

          $response['por_hora']['desglose'][$value['hora']]['total']++;
          $response['por_hora']['desglose'][$value['hora']]['por_dia'][$value['mes']]++;
          $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['total']++;
          $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['por_dia'][$value['mes']]++;
        }
      }else{
        foreach ($estudios as $key => $value) {
          $response['total']++;
          $response['totales'][$value['dia']]++;


          $response['por_hospital']['desglose'][$value['sitio']]['total']++;
          $response['por_hospital']['desglose'][$value['sitio']]['por_dia'][$value['dia']]++;
          $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['total']++;
          $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['por_dia'][$value['dia']]++;

         
          $response['por_modalidad']['desglose'][$value['modalidad']]['total']++;
          $response['por_modalidad']['desglose'][$value['modalidad']]['por_dia'][$value['dia']]++;
          $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['total']++;
          $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['por_dia'][$value['dia']]++;

           if (strpos(strtoupper($value['p_c']), 'CONTRAS') !== false || $value['modi'] == 'CTC' || $value['modi'] == 'CRC' || $value['modi'] == 'DXC' || $value['modi'] == 'MGC' || $value['modi'] == 'MRC' || $value['modi'] == 'RFC' || $value['modi'] == 'OTC' || $value['modi'] == 'USC' || $value['modi'] == 'XAC') {
           
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['total']++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['por_dia'][$value['dia']]++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['total']++;
            $response['por_modalidad_contrast']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['por_dia'][$value['dia']]++;
          }


          $response['por_hora']['desglose'][$value['hora']]['total']++;
          $response['por_hora']['desglose'][$value['hora']]['por_dia'][$value['dia']]++;
          $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['total']++;
          $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['por_dia'][$value['dia']]++;
        }
      }
    $modalidad = "AND a.mod_pro IN (";
    foreach ($cat_modalidades as $key => $value) {
      $modalidad.="'".$value['alias']."',";
    }
    $modalidad=substr($modalidad,0,strlen($modalidad)-1).")";
    $hospitales_asignados = "AND a.hosp_pro IN (";
    foreach ($cat_hospitales as $key => $value) {
      $hospitales_asignados.="'".$value['clave']."',"; 
    }
    $hospitales_asignados = substr($hospitales_asignados,0,strlen($hospitales_asignados)-1).")";
    $hospital = isset($_GET['p'])&&$_GET['p']!='todos'?"AND a.hosp_pro LIKE '%".$_GET['p']."%'":"";
    $hospital = isset($_GET['h'])&&$_GET['h']!='todos'?"AND a.hosp_pro LIKE '%".$_GET['h']."%'":$hospital;
    $anio = isset($_GET['a'])?$_GET['a']:date('Y');
    $mes = isset($_GET['m'])?$_GET['m']:date('m');
    $mes = $_GET['m']=="todos"?"":$mes;
    $esperados = getEsperados($anio,$mes,$hospitales_asignados,$hospital,$modalidad);
    //echo json_encode($esperados);die();
    if($esperados!=false){
       if($agrupar_meses){
        foreach ($esperados as $key => $value) {
            $m = $value['mes'];
            $var_dia = $m==date('m')?date('d'):getInfoMes($m);
            for ($d=1;$d<=$var_dia;$d++) { 
              $d_s = in_array($anio_aux."-".substr("0".$m,-2)."-".$d,$cat_festivos) ? 0 : date('w',strtotime($anio_aux."-".substr("0".$m,-2)."-".$d));
              if($value['dia_s']==$d_s){
                $var_hora = $m==date('m')&&$d==date('d')?date('H'):23;
                if($value['hora']==$var_hora){
                  $response['total']-=$value['valor'];
                  $response['totales'][$value['mes']]-=$value['valor'];

                  $response['por_hospital']['desglose'][$value['sitio']]['total']-=$value['valor'];
                  $response['por_hospital']['desglose'][$value['sitio']]['por_dia'][$value['mes']]-=$value['valor'];
                  $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['total']-=$value['valor'];
                  $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['por_dia'][$value['mes']]-=$value['valor'];

                  $response['por_modalidad']['desglose'][$value['modalidad']]['total']-=$value['valor'];
                  $response['por_modalidad']['desglose'][$value['modalidad']]['por_dia'][$value['mes']]-=$value['valor'];
                  $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['total']-=$value['valor'];
                  $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['por_dia'][$value['mes']]-=$value['valor'];
                }
                if($value['hora']<=$var_hora){
                  $response['por_hora']['desglose'][$value['hora']]['total']-=$value['valor'];
                  $response['por_hora']['desglose'][$value['hora']]['por_dia'][$value['mes']]-=$value['valor'];
                  $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['total']-=$value['valor'];
                  $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['por_dia'][$value['mes']]-=$value['valor'];
                }
              }
            }
        }
      }else{
        $var_dia = $mes_aux==date('m')?date('d'):getInfoMes($mes_aux);
        foreach ($esperados as $key => $value) {      
          for ($i=1; $i<=$var_dia; $i++) {  
            $d_s = in_array($anio_aux."-".$mes_aux."-".$i,$cat_festivos) ? 0 : date('w',strtotime($anio_aux."-".$mes_aux."-".$i));
            if($value['dia_s']==$d_s){
              $var_hora = $mes_aux==date('m')&&$i==date('d')?date('H'):23;
              if($value['hora']==$var_hora){
                $response['total']-=$value['valor'];
                $response['totales'][$i]-=$value['valor'];

                $response['por_hospital']['desglose'][$value['sitio']]['total']-=$value['valor'];
                $response['por_hospital']['desglose'][$value['sitio']]['por_dia'][$i]-=$value['valor'];
                $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['total']-=$value['valor'];
                $response['por_hospital']['desglose'][$value['sitio']]['por_modalidad'][$value['modalidad']]['por_dia'][$i]-=$value['valor'];

                $response['por_modalidad']['desglose'][$value['modalidad']]['total']-=$value['valor'];
                $response['por_modalidad']['desglose'][$value['modalidad']]['por_dia'][$i]-=$value['valor'];
                $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['total']-=$value['valor'];
                $response['por_modalidad']['desglose'][$value['modalidad']]['por_hospital'][$value['sitio']]['por_dia'][$i]-=$value['valor'];

              }
              if($value['hora']<=$var_hora){
                $response['por_hora']['desglose'][$value['hora']]['total']-=$value['valor'];
                $response['por_hora']['desglose'][$value['hora']]['por_dia'][$i]-=$value['valor'];
                $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['total']-=$value['valor'];
                $response['por_hora']['desglose'][$value['hora']]['por_hospital'][$value['sitio']]['por_dia'][$i]-=$value['valor'];
              }
            }
          }
        }
      }
      krsort($response['por_hora']['desglose']);
      foreach ($response['por_hora']['desglose'] as $key => $value) {
        if($key!="00"){
          $nk = substr("0".intval($key)-1,-2);
          if($response['por_hora']['desglose'][$key]['total']<0){
            $response['por_hora']['desglose'][$key]['total']-=$response['por_hora']['desglose'][$nk]['total'];
          }
          foreach ($value['por_dia'] as $key2 => $value2) {
            if($response['por_hora']['desglose'][$key]['por_dia'][$key2]<0){
            $response['por_hora']['desglose'][$key]['por_dia'][$key2]-=$response['por_hora']['desglose'][$nk]['por_dia'][$key2];
            }
          }
          foreach ($value['por_hospital'] as $key2 => $value2) {
            if($response['por_hora']['desglose'][$key]['por_hospital'][$key2]['total']<0){
              $response['por_hora']['desglose'][$key]['por_hospital'][$key2]['total']-=$response['por_hora']['desglose'][$nk]['por_hospital'][$key2]['total'];
            }
            foreach ($value['por_dia'] as $key2 => $value2) { 
              if($response['por_hora']['desglose'][$key]['por_hospital'][$key2]['por_dia'][$key3]<0){
                $response['por_hora']['desglose'][$key]['por_hospital'][$key2]['por_dia'][$key3]-=$response['por_hora']['desglose'][$nk]['por_hospital'][$key2]['por_dia'][$key3];
              }
            }
          }
        } 
      }
      ksort($response['por_hora']['desglose']);
    }
  }
  break;
  
  default: $response = false; break;
} 
$response['por_hospital']['markers']=getMarkers($response['por_hospital']['desglose'],$response['totales']);
$response['por_modalidad']['markers']=getMarkers($response['por_modalidad']['desglose'],$response['totales']);
$response['por_modalidad_contrast']['markers']=getMarkers($response['por_modalidad_contrast']['desglose'],$response['totales_contrast']);
$response['por_hora']['markers']=getMarkers($response['por_hora']['desglose'],$response['totales']);
echo json_encode($response);
 ?>
