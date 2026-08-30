<?php
$modRiwayat = new BalancecairanoksigenT();
$modRiwayat->pasienadmisi_id = $pasienadmisi_id;
$modRiwayat->balancecairan_id = $balancecairan_id;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayatoksigen-grid',
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
          'header' => 'Waktu Pemberian',
          'type' => 'raw',
          'value' => '$data->waktu_pemberian',
      ),
      array(
          'header' => 'Jam Pemberian',
          'type' => 'raw',
          'value' => '$data->jam_pemberian',
      ),
      array(
          'header' => 'Jumlah',
          'type' => 'raw',
          'value' => '$data->jumlah ." ".$data->satuan_jumlah',
      ),
      array(
          'header' => 'List Oksigen',
          'type' => 'raw',
          'value' => '$data->list_oksigen',
      )
    ),
    'afterAjaxUpdate' => 'function(id, data){
      jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
      }',
));
?>
