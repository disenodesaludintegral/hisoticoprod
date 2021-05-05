
   <div style="visibility: hidden">
<div class="md-dialog-container"  id="myDialogDetalle" >
  <md-dialog aria-label="Filtros" style="width:450px">
    <form ng-cloak>
      <md-dialog-content>
        <md-button class="md-icon-button cerrar-modal" aria-label="close-btn" ng-click="close()">
          <i class="fa fa-times" aria-hidden="true"></i>
        </md-button>
        <div class="md-dialog-content">
          <h2 style="text-align: center;">Filtros</h2>
        <table width="100%">
          <tr>
            <th  colspan="2" style="background: white;padding: 3px;padding-bottom: 6px;font-size: 15px;font-weight: 600;">
              <span class="d-block p-2 bg-dark text-white">Estudio</span>
            </th>
          </tr>
          <tr style="background: white;">
            <th>
                <md-input-container>
                  <label>Proyecto</label>
                  <md-select  ng-model="filtros.proy">
                    <md-option value="todos">TODO</md-option>
                    <md-option value="{{k}}" ng-repeat="(k,v) in proyectos">{{k}}</md-option>
                  </md-select>
                </md-input-container>
            </th>
            <th style="background: white;max-width:50%;">
              <md-input-container>
                <label>Hospital</label>
                <md-select  ng-model="filtros.hosp" style="overflow-x: hidden;" ng-disabled="filtros.proy == undefined">
                  <md-option value="todos">Todos</md-option>
                  <md-option  value="{{v}}" ng-repeat="(k,v) in proyectos[filtros.proy]">{{v}}</md-option>
                </md-select>
              </md-input-container>
            </th>
          </tr>
          <tr>
            <th style="background: white;">
              <md-input-container>
                <label>Modalidad</label>
                <md-select  ng-model="filtros.mod" ng-disabled="filtros.hosp == undefined">
                  <md-option value="todos">Todas</md-option>
                  <md-option value="{{v.clave_mod}}" ng-repeat="(k, v) in modalidades">{{v.clave_mod}}</md-option>
                  
                </md-select>
              </md-input-container>
            </th>
            <th style="background: white;">
              <md-input-container>
                <label>Origen</label>
                <md-select  ng-model="filtros.origen">
                  <md-option value="estudios_local">Local</md-option>
                  <md-option value="estudios">Central</md-option>
                </md-select>
              </md-input-container>
            </th>
          </tr>
          <tr>
            <th  colspan="2" style="background: white;padding: 3px;padding-bottom: 6px;font-size: 15px;font-weight: 600;">
              <span class="d-block p-2 bg-dark text-white">Selección de Fecha</span>
            </th>
          </tr>
          <tr>
            <th colspan="2" style="background: white;">
              <md-input-container>
                <label>Tipo de Fecha</label>
                <md-select  ng-model="filtros.tipo_fecha">
                  <md-option value="study_Date_Time">Fecha de Estudio</md-option>
                  <md-option value="last_Modified_Timestamp">Fecha de Última Modificación</md-option>
                </md-select>
              </md-input-container>
            </th>
          </tr>
          <tr>
            <th style="background: white;">
              <md-input-container>
                <label>Año</label>
                <md-select  ng-model="filtros.anio">
                  <!--<md-option ng-value=0>Todos</md-option>-->
                  <md-option >año</md-option>
                  <md-option value="{{v}}" ng-repeat="(k,v) in anus">{{v}}</md-option>
                </md-select>
              </md-input-container>
            </th>
            <th style="background: white;">
              <md-input-container>
                <label>Mes</label>
                <md-select  ng-model="filtros.mes">
                   <md-option value="todos">YTD</md-option>
                   <md-option value="{{v}}" ng-repeat="(k,v) in meses">{{k}}</md-option>
                </md-select>
              </md-input-container>
            </th>
          </tr>
          <tr>
          <!--  <th  colspan="2" style="background: white;padding: 3px;padding-bottom: 6px;font-size: 15px;font-weight: 600;">
              <span class="d-block p-2 bg-dark text-white">Complementaria</span>
            </th>
          </tr>
          <tr >
            <th colspan="2" style="background: white;">
              <md-input-container>
                <label>Referencia</label>
                <md-select  ng-model="filtros.referencia">
                  <md-option value='real'>Real</md-option>
                  <md-option value='esperado'>Esperado</md-option>
                  <md-option value='diferencia'>Diferencia</md-option>
                </md-select>
              </md-input-container>
            </th>
          </tr>-->
        </table>
       <div layout="row" layout-sm="column" layout-align="space-around">
         <md-progress-circular md-mode="indeterminate" ng-show="aplicandoFiltros"></md-progress-circular>
       </div>
        </div>
      </md-dialog-content>
      <md-dialog-actions layout="row">
        <md-button ng-click="aplicarFiltros(filtros)" style="color:#315496;">Aplicar</md-button>
      </md-dialog-actions>
    </form>
  </md-dialog>
</div>
</div>