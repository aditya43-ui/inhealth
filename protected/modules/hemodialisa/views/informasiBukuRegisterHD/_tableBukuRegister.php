<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$sort=true;
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'enableSorting'=>$sort,
	'dataProvider'=>$data,
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
//            'instalasi_nama',
		array(
			'header'=>'No. Rekam Medik',
			'value'=>'$data->no_rekam_medik',
		),
			// 'NamaNamaBIN',
		array(
			   'header'=>'Nama / Nama Bin',
			   'value'=>'$data->NamaNamaBIN',

		),  
		array(
			'header'=>'No. Pendaftaran',
			'value'=>'$data->no_pendaftaran',
		),
		array(
			'header'=>'Umur',
			'value'=>'$data->umur',
		),
		array(
			'header'=>'Jenis Kelamin',
			'value'=>'$data->jeniskelamin',
		),
		array(
			'header'=>'Nama Perujuk',
			'value'=>'$data->nama_perujuk',
		),
		array(
			   'header'=>'Jenis Penjamin /Penjamin',
			   'type'=>'raw',
			   'value'=>'$data->CaraBayarPenjamin',
			   'htmlOptions'=>array('style'=>'text-align: center')
		),  
		array(
			'header'=>'Alamat Pasien',
			'value'=>'$data->alamat_pasien',
		),
		array(
			'header'=>'Riwayat Pasien',
//			'value'=>'$data->alamat_pasien',
            'type'=>'raw',
            'value'=>'(CHtml::link("<i class=\'icon-form-detail\'></i> ", Yii::app()->controller->createUrl("riwayatPasien",array("id"=>$data->pendaftaran_id)),array("id"=>"$data->pendaftaran_id","rel"=>"tooltip","title"=>"Klik untuk Melihat Riwayat Pasien")))',
             'htmlOptions'=>array('style'=>'text-align: center'),
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>