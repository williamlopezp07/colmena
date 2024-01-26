<style media="screen">
@page{
  margin: 2%
}
body{
  font-family: sans-serif;
  font-size:9pt
}
table,td,th{
  border-collapse: collapse;
}
td,th{
  height: 18pt
}
.border{
  border: 1px solid #C79123;
  padding-left:10pt;
}
</style><br>
<img src="{{asset('img/header.png')}}" width="100%" alt="">

  <table width="100%" style="font-size:9pt">
    <thead>
      <tr>
        <th style="border:1px solid #C79123;background-color:#C79123;color:white;">INFLUENCER</th>
        <th style="border:1px solid #C79123;background-color:#C79123;color:white;">HANDLE</th>
        <th style="border:1px solid #C79123;background-color:#C79123;color:white;">PERFIL</th>
        <th style="border:1px solid #C79123;background-color:#C79123;color:white;">UBICACIÓN</th>
        <th style="border:1px solid #C79123;background-color:#C79123;color:white;">CATEGORIAS</th>
        <th style="border:1px solid #C79123;background-color:#C79123;color:white;">RED SOCIAL</th>
        <th style="border:1px solid #C79123;background-color:#C79123;color:white;">SEGUIDORES</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($influencers as $key ): ?>
      <?php $seguidores = '' ?>
      <?php $handle = '' ?>
      <tr>
        <td class="border"><?php echo $key->influencer_descripcion ?></td>
        <?php foreach (json_decode($key->metricas) as $key1): ?>
          <?php if ($key1[0]->red_social==$red_social): ?>
            <?php foreach (($key1[0]->metricas) as $key2): ?>
              <?php if ($key2->input=='handle' and $key2->valor!=''): ?>
                <?php $handle.= $key2->valor?>
              <?php endif; ?>
              <?php if ($key2->input=='seguidores'): ?>
                <?php $seguidores .= ''.$key2->valor.'' ?>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        <?php endforeach; ?>
        <td class="border"><center><?php echo $handle ?></center></td>
        <td class="border"><?php
        if ($handle!='') {
          if ($red_social=='instagram') {
            echo '<center><a href="https://www.instagram.com/'.str_replace('@','',$handle).'" target="_blank"><span class="" style="display: inline-block;padding: 0.35em 0.65em;font-weight: 400;line-height: 1;color: #fff;text-align: center;white-space: nowrap;vertical-align: baseline;border-radius: 0.35rem;background-color: #e30059;" ><b>IG</b></span> </a></center><br>';
          }elseif ($red_social=='tiktok') {
            echo '<center><a href="https://www.tiktok.com/@'.str_replace('@','',$handle).'" target="_blank"><span class="" style="display: inline-block;padding: 0.35em 0.65em;font-weight: 400;line-height: 1;color: #fff;text-align: center;white-space: nowrap;vertical-align: baseline;border-radius: 0.35rem;background-color: #212832;" ><b>TT</b></span> </a></center><br>';
          }elseif ($red_social=='twitter') {
            echo '<center><a href="https://twitter.com/'.str_replace('@','',$handle).'" target="_blank"><span class="" style="display: inline-block;padding: 0.35em 0.65em;font-weight: 400;line-height: 1;color: #fff;text-align: center;white-space: nowrap;vertical-align: baseline;border-radius: 0.35rem;background-color: #00CFd5;" ><b>TW</b></span> </a></center><br>';
          } elseif ($red_social=='youtube') {
            echo '<center><a href="https://www.youtube.com/c/'.str_replace('@','',$handle).'" target="_blank"><span class="" style="display: inline-block;padding: 0.35em 0.65em;font-weight: 400;line-height: 1;color: #fff;text-align: center;white-space: nowrap;vertical-align: baseline;border-radius: 0.35rem;background-color: #e81500;" ><b>YT</b></span> </a></center><br>';
          }
        }
          ?></td>
        <td class="border"><center><?php echo $key->ciudad ?></center></td>
        <td class="border"><center><?php
          if ($key->categorias!='') {
            $categorias_influencer = explode(",", $key->categorias);
            foreach ($categorias_influencer as $key1 => $value) {
              foreach ($categorias as $key2) {
                if ($value==$key2->id) {
                  echo $key2->descripcion.'<br>';
                }
              }
            }
          }
         ?></center></td>
        <td class="border"><center><?php echo $red_social ?></center></td>
        <td class="border"><center><?php echo $seguidores =='' ? 0  : number_format($seguidores) ?></center></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
