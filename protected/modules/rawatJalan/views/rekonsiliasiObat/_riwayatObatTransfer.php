<?php
$modRiwayat = new RekonobattransferT();
$modRiwayat->pendaftaran_id = $modPendaftaran->pendaftaran_id;
// $modRiwayat->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
// $modRiwayat->create_ruangan = Yii::app()->user->getState("ruangan_id");

if(isset($_GET['RekonobattransferT'])) {
    $modRiwayat->attributes = $_GET['RekonobattransferT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayatAlergiTransfer-grid',
    'dataProvider' => $modRiwayat->searchRiwayat(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
      array(
          'header' => 'No',
          'type' => 'raw',
          'value' => '$row+1',
      ),
      array(
          'header' => 'Tanggal',
          'type' => 'raw',
          'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_pengisian)',
      ),
      array(
          'header' => 'Dari Rujukan Lainnya',
          'type' => 'raw',
          'value' => '$data->rujukansebelumnya',
      ),
      array(
          'header' => 'Rujukan Ke',
          'type' => 'raw',
          'value' => '$data->rujukanke',
      ),
      array(
          'header' => 'Nama Obat',
          'type' => 'raw',
          'value' => '$data->nama_obat',
      ),
      array(
          'header' => 'Dosis',
          'type' => 'raw',
          'value' => '$data->dosis',
      ),
      array(
          'header' => 'Frekuensi',
          'type' => 'raw',
          'value' => '$data->frekuensi',
      ),
      array(
          'header' => 'Cara Pemberian',
          'type' => 'raw',
          'value' => '$data->cara_pemberian',
      ),
      array(
          'header' => 'Waktu Pemberian Terakhir',
          'type' => 'raw',
          'value' => '$data->waktu_pemberian',
      ),

      array(
          'header' => 'Jumlah',
          'type' => 'raw',
          'value' => '$data->jumlah_obat',
      ),
      array(
          'header' => 'Tindak Lanjut',
          'type' => 'raw',
          'value' => '$data->tindaklanjut',
      ),
      array(
          'header' => 'Keterangan',
          'type' => 'raw',
          'value' => '$data->keterangan',
      ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
			jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
			}',
));
?>
