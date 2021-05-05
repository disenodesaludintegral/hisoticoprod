var app = angular.module('app',['datatables','ngMaterial']);
app.controller("encuestasCtrl",['$scope','$rootScope','$http','$timeout','$interval','$mdDialog',function($scope,$rootScope,$http,$timeout,$interval,$mdDialog){

/*Vairables del Modal Filtros*/
var d = new Date();
$scope.hoy = new Date();
$scope.mes = d.getMonth();
$scope.meses = [];
$scope.anus = [];
$scope.proyectos = [];
$scope.hospitales =[];
$scope.modalidades = [];
$scope.filtros = [];
$scope.filtros.proy = "ISEM";
$scope.filtros.hosp = "todos";
$scope.filtros.mod = "todos";
$scope.filtros.anio = $scope.hoy.getFullYear();
$scope.filtros.mes = d.getMonth()+1;
$scope.filtros.origen = "estudios";
$scope.filtros.referencia = 'real';
$scope.filtros.tipo_fecha="study_Date_Time";
$scope.origenes = {estudios_local:'Local',estudios:'Central'};
$scope.tipos_fecha = {study_Date_Time:'Fecha de Estudio',last_Modified_Timestamp:'Fecha de LM'};

$http.get("api/api_filtros.php").then(function (response){
  $scope.proyectos = response.data.Poryectos;
  $scope.modalidades = response.data.Modalidades;
  $scope.meses = response.data.mes;
  $scope.anus = response.data.anu;

});

$http.get("api/api_Prod_Dos.php?p="+$scope.filtros.proy).then(function (response) {
    $scope.productividad=response.data;
    $scope.carga = 1;
});
/*Aplicar Filtros*/
$scope.aplicarFiltros = function (f){
  $scope.carga = 0;
  $scope.productividad=[];
  let mes = f.mes == "todos"? f.mes : ("0"+f.mes).substr(-2);
  console.log(f);
  $scope.filtros.proy = f.proy;
  $scope.filtros.hosp = f.hosp;
  $scope.filtros.mod = f.mod;
  $scope.filtros.mes = f.mes;
  $scope.filtros.origen = f.origen;
  $scope.filtros.referencia = f.referencia;
  $scope.filtros.tipo_fecha = f.tipo_fecha;
  $http.get("api/api_Prod_Dos.php?p="+f.proy+"&h="+f.hosp+"&a="+f.anio+"&m="+mes+"&o="+f.origen+"&t_f="+f.tipo_fecha+"&mod="+f.mod).then(function (response) {
  $scope.carga = 1;
   if(response.data!=false){
    $scope.productividad=response.data;
    $scope.vacio = 0;
  }else{
    $scope.vacio = 1;
  }
  });
  $mdDialog.hide();
}


$http.get("api/api_inforRepote.php").then(function (response){
  $scope.DetalleReporte = response.data.reporteLocal;
  for (var i = response.data.length - 1; i >= 0; i--) {
    
  }
})





/*Mostrar Detalle de Encuesta*/
$scope.mostrarDetalle = function(ev){

  $mdDialog.show({
      contentElement: '#myDialogDetalle',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose: true
    })
};

/*Mostrar u ocultar columnas*/
$scope.showMe = false;
    $scope.proyecto = function() {
        $scope.showMe = !$scope.showMe;
    }
 $scope.showHospital = false;
    $scope.Hospital = function() {
        $scope.showHospital = !$scope.showHospital;
    }
  $scope.showModalidad = false;
    $scope.Modalidad = function() {
        $scope.showModalidad = !$scope.showModalidad;
    }
  $scope.showAnu = false;
    $scope.Anu = function() {
        $scope.showAnu = !$scope.showAnu;
    }
    $scope.showMes = false;
    $scope.Mes = function() {
        $scope.showMes = !$scope.showMes;
    }
     $scope.showDia = false;
    $scope.Dia = function() {
        $scope.showDia = !$scope.showDia;
    }
  /*====Mostrar u ocultar Filar====*/
  $scope.showFproyecto = false;
    $scope.Fproyecto = function() {
        $scope.showFproyecto = !$scope.showFproyecto;
    }
    $scope.showFAnu = false;
    $scope.FAnu = function() {
        $scope.showFAnu = !$scope.showFAnu;
    }
    $scope.showFMes = false;
    $scope.FMes = function() {
        $scope.showFMes = !$scope.showFMes;
    }
    $scope.showFHospital = false;
    $scope.FHospital = function() {
        $scope.showFHospital = !$scope.showFHospital;
    }
    $scope.showFModalidad = false;
    $scope.FModalidad = function() {
        $scope.showFModalidad = !$scope.showFModalidad;
    }
    $scope.showFDia = false;
    $scope.FDia = function() {
        $scope.showFDia = !$scope.showFDia;
    }
    /*=====Boton Aplicar======*/
     $scope.showBtnAplicar = false;
    $scope.BtnAplicar = function() {
      
        $scope.showBtnAplicar = !$scope.showBtnAplicar;
    }

  



}])


app.filter('reverse', function() {
  return function(items) {
    return items.slice().reverse();
  };
});




/*Mostrar modal detalle por encuesta Dashboard**/////////////////////////////////////////////////////
