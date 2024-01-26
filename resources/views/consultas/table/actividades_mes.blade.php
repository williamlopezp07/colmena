<?php function accion($accion){
  if ($accion == 'tarifa_story') { echo 'ST';}
  elseif ($accion == 'tarifa_reel') { echo 'R';}
  elseif ($accion == 'tarifa_foto_feed') { echo 'FF';}
  elseif ($accion == 'tarifa_video_feed') { echo 'VF';}
  elseif ($accion == 'tarifa_video') { echo 'V';}
  elseif ($accion == 'tarifa_tweet') { echo 'T';}

}
function color($red_social){
  if ($red_social=='instagram') { echo "table-primary bg-pink";}
  elseif ($red_social=='facebook') { echo "table-dark bg-navy";}
  elseif ($red_social=='tiktok') { echo "table-dark";}
  elseif ($red_social=='twitter') { echo "table-primary bg-cyan";}
  elseif ($red_social=='youtube') { echo "table-dark bg-red";}
}
function dia($dia){
  if (date('N',strtotime($dia))==1) {echo "L";}
  elseif (date('N',strtotime($dia))==2) {echo "M";}
  elseif (date('N',strtotime($dia))==3) {echo "X";}
  elseif (date('N',strtotime($dia))==4) {echo "J";}
  elseif (date('N',strtotime($dia))==5) {echo "V";}
  elseif (date('N',strtotime($dia))==6) {echo "S";}
  elseif (date('N',strtotime($dia))==7) {echo "D";}
}
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 ?>
<table class="table table-bordered" style="font-size:8pt">
  <thead>
    <tr>
      <th colspan="{{4+date('t',strtotime($mes))}}" style="text-align:center">{{$meses[date('n',strtotime($mes))-1].' '.date('Y',strtotime($mes)); }}</th>
    </tr>
    <tr>
      <th rowspan="2">EC</th>
      <th rowspan="2">CAMPAÑA</th>
      <th rowspan="2">INFLUENCER</th>
      <th rowspan="2">ESTADO</th>

      <?php for ($i=1; $i <= date('t',strtotime($mes)); $i++) { ?>
        <th>{{ dia(date('Y-m-d',strtotime(date('Y-m-1',strtotime($mes)). '+ '.($i-1).' days'))) }}</th>
      <?php } ?>
    </tr>
    <tr>

      <?php for ($i=1; $i <= date('t',strtotime($mes)); $i++) { ?>
        <th>{{$i}}</th>
      <?php } ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data as $key): ?>
      <tr>
        <td>{{$key->usuario_nom}}</td>
        <td><b></b>{{$key->campaña}}</td>
        <td>{{$key->PDCODIGO.'-'.$key->nom_acciones}}</td>
        <td>{{$key->PDESTADOINFO}}</td>
        <?php for ($i=1; $i <= date('t',strtotime($mes)); $i++) { ?>
          <?php $condicion = (date('Y-m-d',strtotime(date('Y-m-1',strtotime($mes)). '+ '.($i-1).' days'))==date('Y-m-d',strtotime($key->start))) ? true : false ?>
          <td class="{{ $condicion ? color($key->PDREDSOCIAL) : '' }}"><b><?php  echo ($condicion) ? accion($key->PDINPUT) : '' ; ?></b> </td>
        <?php } ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script type="text/javascript">
  $('.table').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'excel'
    ],
});
</script>
