<?php
$modRiwayat = new RekonobatalergiT();
$modRiwayat->pendaftaran_id = $modPendaftaran->pendaftaran_id;
// $modRiwayat->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
// $modRiwayat->create_ruangan = Yii::app()->user->getState("ruangan_id");

if(isset($_GET['RekonobatalergiT'])) {
    $modRiwayat->attributes = $_GET['RekonobatalergiT'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayatAlergiObat-grid',
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
          'header' => 'Nama Obat',
          'type' => 'raw',
          'value' => '$data->nama_obat',
      ),
      array(
          'header' => 'Keparahan Reaksi Obat',
          'type' => 'raw',
          'value' => '$data->reaksialergi',
      ),
      array(
          'header' => 'Bentuk Reaksi',
          'type' => 'raw',
          'value' => '$data->bentukreaksi',
      ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
			jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
			}',
));
?>
