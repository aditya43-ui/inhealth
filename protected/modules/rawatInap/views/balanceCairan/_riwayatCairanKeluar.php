<?php
$modRiwayat = new BalancecairankeluarT();
$modRiwayat->pasienadmisi_id = $pasienadmisi_id;
$modRiwayat->balancecairan_id = $balancecairan_id;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayatcairankeluar-grid',
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
          'header' => 'Nama Cairan',
          'type' => 'raw',
          'value' => '$data->nama_cairan',
      ),
      array(
          'header' => 'Waktu Pemberian',
          'type' => 'raw',
          'value' => '$data->waktu_pemberian',
      ),
      array(
          'header' => 'Jam Pemberian',
          'type' => 'raw',
          'value' => '$data->jam',
      ),
      array(
          'header' => 'Jumlah',
          'type' => 'raw',
          'value' => '$data->jumlah ." ".$data->satuan_jumlah',
      ),
      array(
          'header' => 'Status Penggunaan',
          'type' => 'raw',
          'value' => '(($data->statuspenggunaan)?"Ya":"Tidak")',
      ),
      array(
          'header' => 'Keterangan',
          'type' => 'raw',
          'value' => '$data->keterangan',
      ),
      array(
          'header' => 'Waktu Pemasangan',
          'type' => 'raw',
          'value' => '(!empty($data->waktu_pemasangan)? MyFormatter::formatDateTimeForUser($data->waktu_pemasangan) : "")',
      )
    ),
    'afterAjaxUpdate' => 'function(id, data){
      jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
      }',
));
?>
