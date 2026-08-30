
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftarpasien-v-grid',
    'dataProvider'=>$model->searchInformasiPasien(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
		array(
			'header'=>'No.',
			'type'=>'raw',
			'value'=>'$row+1',
		),
		array(
			'header'=>'Tanggal Pra Anestesi',
			'type'=>'raw',
			'value'=>'isset($data->tglpraanestesi) ? MyFormatter::formatDateTimeForUser($data->tglpraanestesi) : ""',
		),
		array(
			'header'=>'No. Pra Anestesi',
			'type'=>'raw',
			'value'=>'$data->nopraanestesi',
		),
		array(
			'header'=>'No. Rekam Medik',
			'type'=>'raw',
			'value'=>'$data->no_rekam_medik',
		),
		array(
			'header'=>'Nama Pasien',
			'type'=>'raw',
			'value'=>'$data->nama_pasien',
		),
		array(
			'header'=>'Dokter Anestesi',
			'type'=>'raw',
			'value'=>'$data->nama_dokter',
		),
		array(
			'header'=>'Perawat Anestesi',
			'type'=>'raw',
			'value'=>'$data->nama_perawat1',
		),
		array(
			'header'=>'Kamar Ruangan',
			'type'=>'raw',
			'value'=>'"No. Kamar: ".(isset($data->kamarruangan_nokamar) ? $data->kamarruangan_nokamar : "-")." No. Bed: ".(isset($data->kamarruangan_nobed) ? $data->kamarruangan_nobed : "-")',
		),
		array(
			'header'=>'Lihat',
			'type'=>'raw',
			'value'=>'CHtml::link("<icon class=\'icon-form-lihat\' ></icon> ", Yii::app()->createUrl("/anestesi/informasiPraAnestesi/view", array("pasienanastesi_id"=>$data->pasienanastesi_id,"praanestesi_id"=>$data->praanestesi_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"klik untuk melihat pra anestesi", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
		),
		array(
			'header'=>'Ubah',
			'type'=>'raw',
			'value'=>'CHtml::link("<icon class=\'icon-form-ubah\' ></icon> ", Yii::app()->createUrl("/anestesi/praAnestesi/index", array("pasienanastesi_id"=>$data->pasienanastesi_id,"praanestesi_id"=>$data->praanestesi_id)), array("rel"=>"tooltip", "title"=>"klik untuk mengubah pra anestesi"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
		),
		array(
			'header'=>'Intra Anestesi',
			'type'=>'raw',
			'value'=>'CHtml::link("<icon class=\'icon-form-ubah\' ></icon> ", Yii::app()->createUrl("/anestesi/IntraAnestesi/index", array("pasienanastesi_id"=>$data->pasienanastesi_id)), array("rel"=>"tooltip", "title"=>"klik untuk intra anestesi"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
		),
		array(
			'header'=>'Batal Pemeriksaan',
			'type'=>'raw',
			'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalPeriksa(\'$data->praanestesi_id\',\'$data->pasienanastesi_id\')",array("id"=>"$data->praanestesi_id","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"))',
			'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
		 ),
    ),
		'afterAjaxUpdate'=>'function(id, data){
		jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>