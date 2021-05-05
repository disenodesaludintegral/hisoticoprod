<?php
  /*************************************************************************************/
  /*    
  /* 
  /*    Creado por:     Luis E. Marquez & Ricardo Alejo
  /*                    Database Administrator-Admo Contenidos
  /*    Versión:        1.0
  /*    Fecha:          04/02/2021 - 
  /*************************************************************************************/
  define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);
  require(ROOT_DIR."/includes/classes/portal.usuarios.class.php"); 
  include_once $_SERVER['DOCUMENT_ROOT']."/menu/Menu.class.php";
  
  $Usuarios = new PortalUsuarios($portalConexion);
  $sesion = $Usuarios->getSesionUsuario();
  if($sesion === false){ 
    header('Location: /login/');
    exit;
  }
  Menu::start("Registro del Checklist", "menu_Encuestas");
?>
<!DOCTYPE html>
<html lang="es" >
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <title>Dashboard Encuestas</title>
    <!-- Angular Material style sheet -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.12/angular-material.min.css">
    <!-- Css Bootstrap-->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <!--Datatable CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/datatables.bootstrap.css">

    <!-- Css Master -->
    <link rel="stylesheet" type="text/css" href="assets/css/master.css">
     <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Dashboard CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/DashBoardMaster.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  </head>
  <body ng-app="app" ng-controller="encuestasCtrl" style="background: #f8f8f8; font-family: 'Mandali', sans-serif; ">
    <?php include_once 'modal/ModalReporte.php' ?>
     <div class="container-fluid hidden-xs">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 14px 21px;">
          <h1 class="page-header">Reporteador Histórico Productividad<small></small>
        <small class="corte">Corte al <?php 
          $mes = '';
          if(date("M") == 'Jan'){
            $mes = 'Enero';
          }else if(date("M") == 'Feb'){
            $mes = 'Febrero';
          }else if(date("M") == 'Mar'){
            $mes = 'Marzo';
          }else if(date("M") == 'Apr'){
            $mes = 'Abril';
          }else if(date("M") == 'May'){
            $mes = 'Mayo';
          }else if(date("M") == 'Jun'){
            $mes = 'Junio';
          }else if(date("M") == 'Jul'){
            $mes = 'Julio';
          }else if(date("M") == 'Aug'){
            $mes = 'Agosto';
          }else if(date("M") == 'Sep'){
            $mes = 'Septiembre';
          }else if(date("M") == 'Oct'){
            $mes = 'Octubre';
          }else if(date("M") == 'Nov'){
            $mes = 'Noviembre';
          }else if(date("M") == 'Dec'){
            $mes = 'Diciembre';
          }
          echo date("d");
          echo (" de ");
          echo $mes;
          echo (" del "); 
          echo date("Y - g:i a"); 
        ?></small></h1>
        <div class="col-1-1" style="text-align: right; margin-top: 0%">
          <span style="font-weight: 300;font-size: 90%; color: rgba(0,0,0,0.5)"><b>S</b>istema para el 
            <b>R</b>egistro  de <b>E</b>encuestas</span>
        </div>
      </div>
    </div>
  </div>
 
<style type="text/css">
      #buscador{
            margin-top:20px;
            width:90%;
            border:1px solid #beb2b2;
            margin-bottom: 100px;
            position: relative;
            
        }
        #buscador2{
            margin-top:20px;
            width:90%;
            border:1px solid #beb2b2;
            margin-bottom: 100px;
        }
           #buscador2 h1 {
            width: 85px;
            font-size: 19px;
            margin-top: -13px;
            margin-left: -1px;    
            background:#fff;
                    
                     }


       #buscador h1 {
            width: 85px;
            font-size: 19px;
            margin-top: -13px;
            margin-left: -1px;    
            background:#fff;
                    
                     }
        #ap{
             width: 85px;
            font-size: 19px;
            
            /*margin-left: 600px; */
            background: #3f6575;
            
           
           margin-top: -6px;
          }
          .btn-outline-secondary {
                    color: #6c757d;
                    border-color: #6c757d;
                    width: 102px;
                }
            .btn-info {
            color: #fff;
            background-color: #0c1745;
            border-color: #02343f;
        }
        .btn-info:hover {
    color: #fff;
    background-color: #004957;
    border-color: #033b47;
}


.detail-tbl{
  width: 100%;
  font-size: 15px;
  margin-top: 0%;
}

.detail-tbl th{
  text-align: center;
  color: #F2FAFB;
  background-color:#407a87;
  padding: 6px 0;
}

.detail-tbl td{
  text-align: center;
  color: #424242;
  padding: 4px 0;
}

.detail-tbl tr{
  background-color: #F2FAFB;
}

.detail-tbl tr:nth-child(odd){
  background-color: #E0F0FC;
}

.detail-tbl tbody>tr>td:nth-child(1){
  text-align: left;
  padding-left: 5px;
}

.btn-check:active+.btn-outline-secondary, .btn-check:checked+.btn-outline-secondary, .btn-outline-secondary.active, .btn-outline-secondary.dropdown-toggle.show, .btn-outline-secondary:active {
    color: #fff;
    background-color: #407a87;
    border-color: #407a87;
}
table.table {
    border: #fff;
    box-shadow: 0 3px 6px rgb(0 0 0 / 30%), 0 3px 6px rgb(0 0 0 / 23%);
}





  
    </style>

   <div class="container-fluid " id="buscador">
      <h1>Buscador</h1>
      <div style="font-family: 'Heebo', border-color: lightgray; width: 100%;  border-collapse: collapse; overflow: hidden; margin-top: -0.1%; margin-bottom: 0px; text-align: right;">
        <!---==Tabla Filtro===--->
           <table class="table display panel-heading table-sm" style="font-family: 'Heebo', border-color: lightgray; width: 100%;  border-collapse: collapse; overflow: hidden; margin-top: -0.1%; margin-bottom: 0px; text-align: right;">
               <tr>
                   <th  style="text-align: right;"><span style="color:#777777;">Filtros Aplicados</span> 
                       <button  type="button" class="btn btn-info" style="width: 10%; background: #3f6575; color: #fff;" ng-click="mostrarDetalle($event)">
                        <span >Filtros</span>                      
                       </button>
                  </th>
              </tr>            
           </table>
           <!---==End Tabla Filtro===--->
       </div>
    
      <div class="row">
       <!--===Tabla Columnas====--->             
         <div  class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 " style="text-align: center;"> 
            <div class="table-responsive col-12" style="overflow-x: hidden; margin: 10px 10px 10px 10px; padding-right: 41px;">
              <span class="d-block p-2" style="background: #407a87; color: #fff;">Columnas</span>
              
            <table class="table table-condensed table-borde col-12 "> 
                <tr style="background:white; color:#000;">
                    <th col-4>                    
                       <input type="checkbox" class="btn-check" id="btn-check-1-outlined"  ng-click="proyecto()"  ng-model="Pro" ng-disabled="Pro1">
                       <label class="btn btn-outline-secondary" for="btn-check-1-outlined">Proyecto</label>                      
                    </th >                       
                    <th col-4>
                        <input type="checkbox" class="btn-check" id="btn-check-2-outlined" ng-click="Hospital()" ng-model="Hos" ng-disabled="Hos1">
                        <label class="btn btn-outline-secondary"  for="btn-check-2-outlined">Hospital</label>                       
                    </th>                    
                    <th col-4>
                        <input type="checkbox" class="btn-check" id="btn-check-3-outlined" ng-click="Modalidad()" ng-model="Mod" ng-disabled="Mod1"  >
                        <label class="btn btn-outline-secondary" for="btn-check-3-outlined" >Modalidad</label>
                    </th>
                </tr>
                 <tr style="background:white; color:#000;">
                    <th col-4>
                        <input type="checkbox" class="btn-check" id="btn-check-4-outlined"  ng-click="Anu()" ng-model="An" ng-disabled="An1">
                        <label class="btn btn-outline-secondary" for="btn-check-4-outlined">Año</label>
                    </th>                     
                    <th col-4>
                        <input type="checkbox" class="btn-check" id="btn-check-5-outlined" ng-click="Mes()" ng-model="Me" ng-disabled="Me1" ng-disabled="Di1" >
                        <label class="btn btn-outline-secondary" for="btn-check-5-outlined">Mes</label>
                    </th>                   
                    <th col-4>
                       <input type="checkbox" class="btn-check" id="btn-check-6-outlined" ng-click="Dia()" ng-model="Di" ng-disabled="Di1" >
                       <label class="btn btn-outline-secondary" for="btn-check-6-outlined">Día</label>
                    </th>                              
                 </tr>                 
            </table> 
             
            </div>
          </div>
          <!--=== End Tabla Columnas====--->


          <!--===  Tabla Filas====--->
           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 box box-primary" style="text-align: center;">
             <div class="table-responsive col-12" style="overflow-x: hidden; margin: 10px 10px 10px 10px; ">
              <span class="d-block p-2 " style="background: #407a87; color: #fff;">Filas</span>              
              <table class="table table-condensed table-borde " > 
                <tr style="background:white; color:#000;">
                    <th col-4>                      
                       <input type="checkbox" class="btn-check"  id="btn-check-7-outlined" ng-click="Fproyecto()" ng-disabled="Di" ng-disabled="Pro" ng-model="Pro1">
                       <label class="btn btn-outline-secondary" for="btn-check-7-outlined">Proyecto</label>
                    </th >                       
                    <th col-4>
                        <input type="checkbox" class="btn-check" id="btn-check-8-outlined" ng-click="FHospital()" ng-disabled="Di"  ng-disabled="Hos" ng-model="Hos1" >
                        <label class="btn btn-outline-secondary" for="btn-check-8-outlined">Hospital</label>                        
                    </th >                     
                    <th col-4>
                        <input type="checkbox" class="btn-check" id="btn-check-9-outlined" ng-click="FModalidad()" ng-disabled="Di" ng-disabled="Mod" ng-model="Mod1" >
                        <label class="btn btn-outline-secondary" for="btn-check-9-outlined">Modalidad</label> 
                    </th>                                
                </tr>
                 <tr style="background:white; color:#000;">
                    <th col-4>
                        <input type="checkbox" class="btn-check" id="btn-check-10-outlined" ng-click="FAnu()" ng-disabled="Di"  ng-disabled="An" ng-model="An1" >
                        <label class="btn btn-outline-secondary" for="btn-check-10-outlined">Año</label>
                    </th>                     
                    <th col-4>
                      <input type="checkbox" class="btn-check" id="btn-check-11-outlined" ng-disabled="Me" ng-model="Me1"  ng-disabled="Di" >
                      <label class="btn btn-outline-secondary" for="btn-check-11-outlined" ng-click="FMes()">Mes</label>
                    </th>                   
                   <th col-4>
                       <input type="checkbox" class="btn-check" id="btn-check-12-outlined" ng-click="FDia()" ng-disabled="Di" ng-model="Di1" >
                       <label class="btn btn-outline-secondary form-control-lg"  for="btn-check-12-outlined">  Día  </label>
                    </th>                              
                 </tr>                 
            </table>
            </div>
  
          </div>
     
          <p style="text-align: right;">
            <button id="ap"  type="button" class="btn btn-info" ng-click="BtnAplicar()">
              <span>Aplicar</span>
            </button> 
          </p>
     </div>
  </div>
  <!--=== End Tabla Filas====--->

  <!--====Totales===-->
<div class="container-fluid" id="buscador2">
     <h1>Reporte</h1>
    <div class="row">
<!---Tabla Columnas 1---->
   <!--  --><div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" ng-show="!showDia" >                     
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="margin-bottom: 0px; margin-top: 138px; "  ng-show="showBtnAplicar">
              <div class="col-12" >
              <table class="detail-tbl"  width="100%" >
                <tbody ng-repeat="(key, value) in productividad.por_hospital.desglose">
                  <tr ng-repeat="(km,m) in value.por_modalidad"   >
                    <td style=" white-space: nowrap; text-align: center; padding: 1px;" ng-show="showMes">Enero</td>
                    <td style=" white-space: nowrap; text-align: center; padding: 1px;" ng-show="showAnu">2021</td>
                    <td style=" white-space: nowrap; text-align: center; padding: 1px;" ng-show="showMe">ISEM</td>
                    <td style=" white-space: nowrap; text-align: center; padding: 1px;" ng-show="showMe">{{key}}</td>
                    <td style="  white-space: nowrap; text-align: center; padding: 1px;"ng-show="showHospital" >{{value.nombre_corto}}</td>
                     <td style="  white-space: nowrap; border: 0px; text-align: center; padding: 1px;"  ng-show="showModalidad" >
                           {{km}}
                    </td>
                
                  </tr>
                </tbody>
              </table>
            </div>            
            </div>          
        </div>
  
<!----End Tabla Columnas---->
<!----Tabla fila---->
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12" style="text-align: center;" ng-show="!showDia">
          <div class="table-responsive col-12" style="overflow-x: hidden;" >
              <div class="table-responsive">                    
                     <table class="detail-tbl" width="100%"   ng-show="showBtnAplicar">
                      <thead>
              
                        <tr   ng-show="showFAnu"  >         
                            <th colspan="31"  class="bordes" >
                                <span style="padding: 0 2px;font-size: 120%;">2021 </span>
                             </th>     
                         </tr>
                         
                         <tr  ng-show="showFMes">
                            <th colspan="31"  class="bordes">
                              <span style="padding: 0 2px;font-size: 120%;">Enero</span>
                           </th>     
                        </tr>
                         <tr  ng-show="showFDia">
                              <th   ng-repeat="d in productividad.encabezados" class="bordes">
                                <span style="padding: 0 2px;font-size: 120%;">{{d}}</span>
                              </th>    
                         </tr>
                         
                      </thead>
                      
                      <tbody ng-show="showFDia" ng-if="key != 'CTC' && key != 'CRC' && key != 'DXC' && key != 'MGC' && key != 'MRC' && key != 'RFC' && key != 'OTC' && key != 'USC' && key != 'XAC'" ng-repeat="(key, value) in productividad.por_hospital.desglose" ng-init="detalle[key]=false">

                             <tr ng-if="km != 'CTC' && km != 'CRC' && km != 'DXC' && km != 'MGC' && km != 'MRC' && km != 'RFC' && km != 'OTC' && km != 'USC' && km != 'XAC'" ng-repeat="(km,m) in value.por_modalidad">
                                <td ng-repeat="d in m.por_dia" style="white-space: nowrap; padding: 1px;">
                                  <span ng-if="d!=0" style="white-space: nowrap; padding: 1px;">{{d | number:0}}</span>
                                  <span ng-if="d==0" style="white-space: nowrap; padding: 1px;">-</span>
                                </td>
                            </tr>
                      </tbody>                  
                    </table>
                  </div>  
              </div> 
          </div> 
<!----End Tabla Fila---->



      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 53px;"  ng-show="showDia" >                     
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " >
              <div class="col-10" style="float:left;  " >
              <table class="detail-tbl">
                <thead style="background:#176EAE; color:#fff;">
                  <tr >
                    <th style=" white-space: nowrap; text-align: center; padding: 1px;" >Mes</th>
                    <th style=" white-space: nowrap; text-align: center; padding: 1px;">Año</th>
                    <th style=" white-space: nowrap; text-align: center; padding: 1px;" ng-show="showMe">Proyecto</th>
                    <th style=" white-space: nowrap; text-align: center; padding: 1px;">clave</th>
                    <th style=" white-space: nowrap; text-align: center; padding: 1px;">Hospital</th>
                    <th style=" white-space: nowrap; text-align: center; padding: 1px;">Modalidad</th>
                    <th style=" white-space: nowrap; text-align: center; padding: 1px;">Dia</th>
                  </tr>
                </thead>
                <tbody ng-repeat="(key, value) in productividad.por_hospital.desglose">
                  <tr ng-repeat="(km,m) in value.por_modalidad" >
                    <td style=" white-space: nowrap; text-align: center; padding: 1px;">Enero</td>
                    <td style=" white-space: nowrap; text-align: center; padding: 1px;">2021</td>
                    <td style=" white-space: nowrap; text-align: center; padding: 1px;" ng-show="showMe">ISEM</td>
                    <td style=" white-space: nowrap; text-align: center; padding: 1px;">{{key}}</td>
                    <td style="  white-space: nowrap; text-align: center; padding: 1px;">{{value.nombre_corto}}</td>
                    <td style="  white-space: nowrap; border: 0px; text-align: center; padding: 1px;" >
                           {{km}}
                    </td>
                    <td style=" white-space: nowrap; text-align: center;  padding: 1px;" > <span  style=" padding: 1px;" ng-repeat="d in productividad.encabezados" layout="column">{{d}}</span> 
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-2" style="float:left;">
                <table class="detail-tbl">
                  <thead>
                  <tr  >
                    <th style=" white-space: nowrap; text-align: center; padding: 1px; color:#dbe3e7; " >Mes</th>
                  </tr>
                </thead>
                    <tbody  ng-if="key != 'CTC' && key != 'CRC' && key != 'DXC' && key != 'MGC' && key != 'MRC' && key != 'RFC' && key != 'OTC' && key != 'USC' && key != 'XAC'" ng-repeat="(key, value) in productividad.por_hospital.desglose" ng-init="detalle[key]=false">

                             <tr ng-if="km != 'CTC' && km != 'CRC' && km != 'DXC' && km != 'MGC' && km != 'MRC' && km != 'RFC' && km != 'OTC' && km != 'USC' && km != 'XAC'" ng-repeat="(km,m) in value.por_modalidad">
                                <td ng-repeat="d in m.por_dia" layout="column" style="white-space: nowrap; padding: .5px;" >
                                  <span ng-if="d!=0" style="white-space: nowrap; text-align: center; padding: .5px;">{{d | number:0}}</span>
                                  <span ng-if="d==0" style="white-space: nowrap; text-align: center; padding: .5px;">-</span>
                                </td>
                              </tr>
                    </tbody> 
                 </table>
            </div>             
            </div>          
         </div>



     </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script src="assets/js/jquery.dataTables.min.js"></script>
<!-- Angular js-->
<script type="text/javascript" src="assets/js/angular.min.js"></script>
<script src="assets/js/angular-datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<!-- Angular Material-->
 <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular-animate.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular-aria.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.6/angular-messages.min.js"></script>

 <!-- Angular Material Library -->
 <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.12/angular-material.min.js"></script>
 
 <!-- Controlador EncuestasController -->
 <script type="text/javascript" src="assets/js/historicoController.js"></script>

 <!-- Google Charts-->
 <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
   
  <!-- Sweet Alert-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  </body>


  </html> 