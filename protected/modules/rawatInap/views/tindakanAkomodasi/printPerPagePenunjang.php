<?php

$instalasi = Yii::app()->user->getState('instalasi_id');

$crit2 = new CDbCriteria;
$crit2->select = 'nopelayanan';
$crit2->group = $crit2->select;
$crit2->addCondition(' pendaftaran_id = ' . $modPendaftaran->pendaftaran_id . ' and ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' and verifbataltindakan_id is null ');
$crit2->order = 'nopelayanan desc';


$notatindakan_last = TindakanpelayananT::model()->find($crit2);

$notatindakan = null;
$total_tarif = 0;

// echo '<pre>'; var_dump($notatindakan_last->attributes); die;
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$ruangan_id = Yii::app()->user->getState('ruangan_id');
$nopelayanan = '';

if(!empty($notatindakan_last)) {

  $nopelayanan = $notatindakan_last->nopelayanan;
  $condition = ' pendaftaran_id = ' . $modPendaftaran->pendaftaran_id . ' and ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' and nopelayanan = \'' . $notatindakan_last->nopelayanan . '\'  and verifbataltindakan_id is null ';

  if(isset($_GET['is_all'])) {
    $condition = ' pendaftaran_id = ' . $modPendaftaran->pendaftaran_id . ' and ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' and verifbataltindakan_id is null ';
  }

  if(isset($_GET['nopelayanan'])) {
    $nopelayanan = $_GET['nopelayanan'];
    $condition = ' pendaftaran_id = ' . $modPendaftaran->pendaftaran_id . ' and ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' and nopelayanan = \'' . $_GET['nopelayanan'] . '\'  and verifbataltindakan_id is null ';
  }

  $crit = new CDbCriteria;
  $crit->select = 'nopelayanan';
  $crit->group = $crit->select;
  $crit->addCondition($condition);
  $crit->order = 'nopelayanan';
  
  $notatindakan = TindakanpelayananT::model()->findAll($crit);

  $cr = new CDbCriteria;
  $cr->select = 'sum(tarif_tindakan) as total_tarif';
  $cr->addCondition($condition);

  $total = TindakanpelayananT::model()->find($cr);
}
if(!empty($notatindakan)) {
    $hal = 1;
    foreach($notatindakan as $i => $nota) {

        $limit = 6;
        $offset = 0;
        $is_last = false;
        $is_first = false;
        $ctr = 0;

        while(!$is_last) {

          $tindakan = TindakanPelayananT::model()
                      ->with('daftartindakan', 'dokter1', 'dokter2',
                        'dokterPendamping', 'dokterAnastesi', 'dokterDelegasi',
                        'bidan', 'suster', 'perawat', 'tipePaket'
                      )->findAll(array('condition' => "pendaftaran_id = $modPendaftaran->pendaftaran_id and nopelayanan = '$nota->nopelayanan'  and verifbataltindakan_id is null ", 'limit' => $limit, 'offset' => $offset));

          $tindakan_next = TindakanPelayananT::model()
                      ->with('daftartindakan', 'dokter1', 'dokter2',
                        'dokterPendamping', 'dokterAnastesi', 'dokterDelegasi',
                        'bidan', 'suster', 'perawat', 'tipePaket'
                        )->findAll(array('condition' => "pendaftaran_id = $modPendaftaran->pendaftaran_id and nopelayanan = '$nota->nopelayanan'  and verifbataltindakan_id is null ", 'limit' => $limit, 'offset' => $offset + $limit));

          if($is_first) {
            $is_first = ($offset == 0);
          }
          
          if(empty($tindakan_next)) {
            $is_last = true;
          }

          $is_notasama = true;

          if(!empty($tindakan) && !empty($tindakan_next)) {
            $is_notasama = ($tindakan[0]->nopelayanan == $tindakan[1]->nopelayanan);
          }

          $this->render(
            $this->path_view.'printPenunjang',
            array(
              'format' => $format,
              'judul_print' => $judul_print,
              'modPendaftaran' => $modPendaftaran,
              'modTindakans' => $tindakan,
              'modViewBmhp' => $modViewBmhp,
              'modPasien' => $modPasien,
              'total' => $total,
              'is_last' => $is_last,
              'is_first' => $is_first,
              'i' => $i + 1,
              'hal' => $hal,
              'is_notasama' => $is_notasama,
              'offset' => $offset,
              'penunjang' => $penunjang,
              'kirim' => $kirim,
            )
          );

          $offset += $limit;

          $hal++;
          $ctr++;
        }

        

    }

}

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

?>

<script>

  function updatePrint() {

    var url = '<?php echo $url . "/updateCetakanKe"; ?>';
    var pendaftaran_id = '<?= $pendaftaran_id ?>';
    var ruangan_id = '<?= $ruangan_id ?>';
    var nopelayanan = '<?= $nopelayanan ?>';

        $.ajax({
            type: 'POST',
            url: url,
            data: {pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id, nopelayanan: nopelayanan},
            dataType: "json",
            success: function (data) {
                console.log(data.form);
                console.log('jumlah cetakan terupdate');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }

        });
    }

  $(document).ready(function(){
    updatePrint();
  });

</script>