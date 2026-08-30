<?php
$modRiwayat = new ObatalkespasienT();
$modRiwayat->pendaftaran_id = $modKunjungan->pendaftaran_id;
$modRiwayat->pasienadmisi_id = $modKunjungan->pasienadmisi_id;
$modRiwayat->ruangan_id = Yii::app()->user->getState('ruangan_id');

if(isset($_GET['ObatalkespasienT'])) {
  $modRiwayat->attributes = $_GET['ObatalkespasienT'];
}

$this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
  'id' => 'riwayatbmhp-grid',
  'dataProvider' => $modRiwayat->searchRiwayatBMHP(),
  'template' => "{summary}\n{items}\n{pager}",
  'itemsCssClass' => 'table table-bordered table-striped table-condensed',
  'mergeColumns'=>array('tipepaket_id'),
  'columns' => array(
      array(
          'header' => 'No',
          'type' => 'raw',
          'value' => '$row+1',
      ),
      array(
          'header' => 'Tgl. Pemakaian',
          'type' => 'raw',
          'name'=>'tipepaket_id',
          'value' => 'MyFormatter::formatDateTimeForUser($data->tglpelayanan)',
      ),
      array(
          'header' => 'Tipe Paket',
          'type' => 'raw',
          'name'=>'tipepaket_id',
          'value' => function ($data){
              $tipepake = TipepaketM::model()->findByPk($data->tipepaket_id);
              return (!empty($tipepake)?$tipepake->tipepaket_nama:"");
          },
      ),
      array(
          'header' => 'Jenis Obat Alkes',
          'type' => 'raw',
          'value' => function ($data){
            $oa = ObatalkesM::model()->findByPk($data->obatalkes_id);
            return (!empty($oa)?$oa->jenisobatalkes->jenisobatalkes_nama:"");
        },
      ),
      array(
          'header' => 'Nama Bahan Medis',
          'type' => 'raw',
          'value' => function ($data){
            $oa = ObatalkesM::model()->findByPk($data->obatalkes_id);
            return (!empty($oa)?$oa->obatalkes_nama:"");
        },
      ),
      array(
          'header' => 'Harga',
          'type' => 'raw',
          'value' => 'MyFormatter::formatNumberForPrint($data->hargasatuan_oa,2)',
      ),
      array(
          'header' => 'Jumlah',
          'type' => 'raw',
          'value' => 'MyFormatter::formatNumberForPrint($data->qty_oa,2)',
      ),
      array(
          'header' => 'Sub Total Harga',
          'type' => 'raw',
          'value' => 'MyFormatter::formatNumberForPrint($data->hargajual_oa,2)',
      ),
      array(
        'header' => 'Hapus',
        'type' => 'raw',
        'name'=>'tipepaket_id',
        'value'=>function($data) {
            return CHtml::link('<i class="entypo-trash" style="font-size:14pt"></i>', '#', array(
                'onclick'=>'hapusRiwayat("'.$data->tipepaket_id.'",'.$data->pendaftaran_id.',"'.$data->pasienadmisi_id.'",'.$data->ruangan_id.'); return false'
            ));
        },
        'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
    ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
      jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));



?>
