

<?php

  $count = count($modTindakans);

  if($count > 0) {
    $i = 1;
    $k = 1;

    $path = Yii::app()->user->getState('modul_id') !== 9 ? $this->path_view.'print.print' : $this->path_view_rj . 'print';
    foreach($modTindakans as $ii => $tindakan) {
        $this->render(
          $this->path_view.'print.print',
          array(
            'format' => $format,
            'judul_print' => $judul_print,
            'modPendaftaran' => $modPendaftaran,
            'modTindakans' => $tindakan,
            'modViewBmhp' => $modViewBmhp,
            'modPasien' => $modPasien,
            'i' => $i,
            'k' => $k,
            'count' => $count
          )
        );
      $i++;
      $k++;
    }
  } else {
    echo '<h1><b>Tidak Ditemukan Tindakan</b></h1>';
  }


?>