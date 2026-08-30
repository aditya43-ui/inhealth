

<?php
// echo '<pre>';
  $count = count($modTindakans);

  if($count > 0) {
    $i = 1;
    $k = 1;
    foreach($modTindakans as $ii => $tindakan) {
      foreach($tindakan as $data) {
       
        $this->render(
          $this->path_view.'printUlang',
          array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modPendaftaran' => $modPendaftaran,
            'modTindakans' => $data['data'],
            'modViewBmhp' => $modViewBmhp,
            'modPasien' => $modPasien,
            'i' => $i,
            'k' => $k,
            'count' => $count,
            'nomulai' => $data['nomulai']
          )
        );
        $i++;
        $k++;
        
      }
    }
  }
// die;

?>