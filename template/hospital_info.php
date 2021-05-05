  <!-- == TABLA DE HOSPITALES == -->
 <!-- <div style="padding:20px 0;margin: auto;text-align: center;width: 100%;">
  <md-progress-circular style="margin: auto;display: block;" ng-if="carga==0" class="md-hue-2" md-diameter="120"></md-progress-circular>
</div>--aqui estaba una comentario 
<div class="table-responsive" style="padding:1px;">
<table class="table" width="100%" style="margin-bottom: 0px !important;" >
  <thead>
    <tr>
      <td colspan="2" style="background:#315496;text-align:center;vertical-align: middle;font-size: 120%;border: 2px solid rgba(116, 116, 116, 0.4);color: white;width: 16%;max-width: 16%;min-width: 16%;">
        <p style="vertical-align: middle;">{{getMes(filtros.mes)}}</p>
      </td>
      <td style="background:#f3f3f3;width: 1%;max-width: 1%;min-width: 1%;">
      </td>
      <td ng-repeat="d in productividad.encabezados" class="bordes" style="background:#315496;text-align:center;font-size: 11px;font-family: Verdana;color: white;width:{{66/productividad.encabezados.length}}%;min-width:{{66/productividad.encabezados.length}}%;max-width:{{70/productividad.encabezados.length}}%">
        <span style="padding: 0 2px;font-size: 120%;">{{d}}</span>
      </td>
      <td style="background:#f3f3f3;width: 1%;max-width: 1%;min-width: 1%;">
      </td>
     <!-- <td class="bordes" style="width: 3%;min-width: 3%;max-width: 3%;background:#315496;text-align:center;font-size: 110%;font-family: Verdana;color: white;">
        <p style="vertical-align: middle;">Total</p>
      </td>
      <td class="bordes" style="width: 3%;min-width: 3%;max-width: 3%;background:#315496;text-align:center;font-size: 110%;font-family: Verdana;color: white;">
         <p style="vertical-align: middle;">Prod</p>
      </td>
      <td class="bordes" style="width: 3%;min-width: 3%;max-width: 3%;background:#315496;text-align:center;font-size: 110%;font-family: Verdana;color: white;">
         <p style="vertical-align: middle;">Min</p>
      </td>
      <td class="bordes" style="width: 3%;min-width: 3%;max-width: 3%;background:#315496;text-align:center;font-size: 110%;font-family: Verdana;color: white;">
         <p style="vertical-align: middle;">Max</p>
      </td> -otro comentatario
    </tr>
    <tr>
      <td colspan="2" style="background:#f3f3f3;border: 0px solid #f3f3f3;border-bottom: 1px solid  rgb(150, 150, 150);">
      </td>
      <td style="background:#f3f3f3;border: 1px solid #f3f3f3;">
      </td>
      <td ng-repeat="d in productividad.encabezados" style="background:#f3f3f3;border: 1px solid #f3f3f3;border-bottom: 1px solid  rgb(150, 150, 150);">
      </td>
      <td style="background:#f3f3f3;border: 1px solid #f3f3f3;">
      </td>
      <td style="background:#f3f3f3;border: 1px solid #f3f3f3;border-bottom: 1px solid  rgb(150, 150, 150);">
      </td>
      <td style="background:#f3f3f3;border: 1px solid #f3f3f3;border-bottom: 1px solid  rgb(150, 150, 150);">
      </td>
      <td style="background:#f3f3f3;border: 1px solid #f3f3f3;border-bottom: 1px solid  rgb(150, 150, 150);">
      </td>
      <td style="background:#f3f3f3;border: 1px solid #f3f3f3;border-bottom: 1px solid  rgb(150, 150, 150);">
      </td>
    </tr>
    <tr>
      <td  colspan="2" style="background:#232524d9;text-align:center;font-size: 11px;font-family: Verdana;border: 2px solid rgba(116, 116, 116, 0.4);color: white;">
        TOTAL
      </td>
      <td style="background:#f3f3f3;border: 1px solid #f3f3f3;">
      </td>
      <td ng-repeat="d in productividad.totales" class="bordes" style="background:#232524d9;text-align:center;font-size: 10px;font-family: Verdana;color: white;">
        <span ng-if="d!=0">{{d | number:0}}</span>
        <span ng-if="d==0">-</span>
      </td>
      <td style="background:#f3f3f3;border: 1px solid #f3f3f3;">
      </td>
     <!-- <td class="bordes" style="background:#232524d9;text-align:center;font-size: 10px;font-family: Verdana;color: white;">
          {{productividad.total | number:0}}
      </td>
      <td class="bordes" style="background:#232524d9;text-align:center;font-size: 10px;font-family: Verdana;color: white;">
        {{getAVG(productividad.totales,productividad.total) || 0 | number:1}}
      </td>
      <td class="bordes" style="background:#232524d9;text-align:center;font-size: 10px;font-family: Verdana;color: white;">
        {{getMin(productividad.totales,getAVG(productividad.totales,productividad.total)) || 0 | number:0}}
      </td>
      <td class="bordes" style="background:#232524d9;text-align:center;font-size: 10px;font-family: Verdana;color: white;">
        {{getMax(productividad.totales,getAVG(productividad.totales,productividad.total)) || 0 | number:0}}
      </td> -otro comentario
    </tr>
  </thead>
  <tbody ng-if="key != 'CTC' && key != 'CRC' && key != 'DXC' && key != 'MGC' && key != 'MRC' && key != 'RFC' && key != 'OTC' && key != 'USC' && key != 'XAC'" ng-repeat="(key, value) in productividad.por_hospital.desglose" ng-init="detalle[key]=false">
    <tr class="tbl-row">
      <td style="text-overflow:ellipsis;white-space:nowrap;overflow:hidden; text-align: left;padding-left: 8px;width: 6%;">
        <md-button ng-click="detalle[key] = !detalle[key]" aria-label="btn-mp" class="md-raised" style="margin: 0px;font-size: 10px;min-width: 20px;width: 20px;max-width: 20px;min-height: 20px;height: 20px;max-height: 20px;line-height: 0px !important;">
          <i ng-show="!detalle[key]" class="fas fa-plus" aria-label="plus"></i>
          <i ng-show="detalle[key]" class="fas fa-minus" aria-label="minus"></i>
        </md-button>
        {{key}}
      </td>
      <td style="padding-top: 11px;text-overflow:ellipsis;white-space:nowrap;overflow:hidden; text-align: left;padding-left: 8px;width: 10%;">
        {{value.nombre_corto}}
      </td>
      <td style="background:#f3f3f3;border-bottom: 1px solid #f3f3f3;"></td>
      <td ng-repeat="d in value.por_dia" style="border-right: 1px solid #bac8ce;color: {{getColor(d)}};">
        <span ng-if="d!=0">{{d | number:0}}</span>
        <span ng-if="d==0">-</span>
      </td>
      <td style="background:#f3f3f3;border-bottom: 1px solid #f3f3f3;"></td>
      <td style="">
         <span ng-if="value.total!=0">{{value.total | number:0}}</span>
         <span ng-if="value.total==0">-</span>
      </td>
      <td>{{getAVG(value.por_dia,value.total) || 0 | number:1}}</td>
      <td>{{getMin(value.por_dia,getAVG(value.por_dia,value.total)) || 0 | number:0}}</td>
      <td>{{getMax(value.por_dia,getAVG(value.por_dia,value.total)) || 0 | number:0}}</td>
    </tr>
    <tr ng-if="km != 'CTC' && km != 'CRC' && km != 'DXC' && km != 'MGC' && km != 'MRC' && km != 'RFC' && km != 'OTC' && km != 'USC' && km != 'XAC'" ng-repeat="(km,m) in value.por_modalidad" ng-show="detalle[key]" style="background: #bac8ce;color: #333;font-weight: bolder;">
      <td  colspan="2" style="text-align: left;padding-left: 20px;">{{km+" "+m.modalidad}}</td>
      <td style="background:#f3f3f3;border-bottom: 1px solid #f3f3f3;"></td>
      <td ng-repeat="d in m.por_dia">
        <span ng-if="d!=0">{{d | number:0}}</span>
        <span ng-if="d==0">-</span>
      </td>
      <td style="background:#f3f3f3;border-bottom: 1px solid #f3f3f3;"></td>
      <td style="border: 1px solid #bac8ce;">
         <span ng-if="m.total!=0">{{m.total | number:0}}</span>
         <span ng-if="m.total==0">-</span>
      </td>
      <td style="border: 1px solid #bac8ce;">{{getAVG(m.por_dia,m.total) || 0 | number:1}}</td>
      <td style="border: 1px solid #bac8ce;">{{getMin(m.por_dia,getAVG(m.por_dia,m.total)) || 0 | number:0}}</td>
      <td style="border: 1px solid #bac8ce;">{{getMax(m.por_dia,getAVG(m.por_dia,m.total)) || 0 | number:0}}</td>
    </tr>
  </tbody>
 <!-- <tfoot>
    <tr>
      <td colspan="{{productividad.encabezados.length+8}}" style="background-color: #f3f3f3;border: none;color: #f3f3f3;height: 20px;"></td>
    </tr>
    <tr ng-repeat="(k,m) in productividad.por_hospital.markers">
      <td colspan="2">
        {{k.toUpperCase()}}
      </td>
      <td style="background:#f3f3f3;border: 1px solid #f3f3f3;"></td>    
      <td ng-repeat="d in m track by $index">
         <span ng-if="d!=0">{{d | number:0}}</span>
         <span ng-if="d==0">-</span>
      </td>
      <td style="background:#f3f3f3;border: 1px solid #f3f3f3;"></td>

      <td style="border: 1px solid #bac8ce;">{{getAVG(m,getSum(m)) || 0 | number:1}}</td>
      <td style="border: 1px solid #bac8ce;">{{getMin(m,getAVG(m,getSum(m))) || 0 | number:0}}</td>
      <td style="border: 1px solid #bac8ce;">{{getMin(m,getAVG(m,getSum(m))) || 0 | number:0}}</td>
      <td style="border: 1px solid #bac8ce;">{{getMax(m,getAVG(m,getSum(m))) || 0 | number:0}}</td>
    </tr>
  </tfoot
</table>
</div>
== END TABLA DE HOSPITALES == -->
