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
			'header'=>'Tanggal Anestesi',
			'type'=>'raw',
			'value'=>'isset($data->tglanastesi) ? MyFormatter::formatDateTimeForUser($data->tglanastesi) : ""',
		),
		array(
			'header'=>'No. Anestesi',
			'type'=>'raw',
			'value'=>'$data->noanestesi',
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
			'header'=>'Jenis Kelamin',
			'type'=>'raw',
			'value'=>'$data->jeniskelamin',
		),
		array(
			'header'=>'Umur',
			'type'=>'raw',
			'value'=>'$data->umur',
		),
		array(
			'header'=>'Alamat',
			'type'=>'raw',
			'value'=>'$data->alamat_pasien',
		),
		array(
			'header'=>'Jenis Kasus Penyakit',
			'type'=>'raw',
			'value'=>'isset($data->jeniskasuspenyakit_nama) ? $data->jeniskasuspenyakit_nama : ""',
		),
		array(
			'header'=>'Jenis Penjamin /Penjamin',
			'type'=>'raw',
			'value'=>'(isset($data->carabayar_nama) ? $data->carabayar_nama : "")."/".(isset($data->penjamin_nama) ? $data->penjamin_nama : "")',
		),
		array(
			'header'=>'Pra Anestesi',
			'type'=>'raw',
			'value'=>'CHtml::link("<icon class=\'icon-form-ubah\' ></icon> ", Yii::app()->createUrl("/anestesi/PraAnestesi/index", array("pasienanastesi_id"=>$data->pasienanastesi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)), array("rel"=>"tooltip", "title"=>"klik untuk pra anestesi"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
		),
		array(
			'header'=>'Intra Anestesi',
			'type'=>'raw',
			'value'=>'CHtml::link("<icon class=\'icon-form-ubah\' ></icon> ", Yii::app()->createUrl("/anestesi/IntraAnestesi/index", array("pasienanastesi_id"=>$data->pasienanastesi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)), array("rel"=>"tooltip", "title"=>"klik untuk intra anestesi"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
		),
		array(
			'header'=>'Status Anestesi',
			'type'=>'raw',
			'value'=>'isset($data->statusanestesi) ? $data->statusanestesi : ""',
		),
		array(
			'header'=>'Rincian Tagihan',
			'type'=>'raw',
			'value'=>'CHtml::link("<icon class=\'icon-form-detailtagihan\' ></icon> ", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printDetailRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat detail rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
		),
    ),
		'afterAjaxUpdate'=>'function(id, data){
		jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>