
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
			'header'=>'Tgl. Masuk Penunjang',
			'type'=>'raw',
			'value'=>'isset($data->tglmasukpenunjang) ? MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang) : ""',
		),
		array(
			'header'=>'No. Masuk Penunjang',
			'type'=>'raw',
			'value'=>'$data->no_masukpenunjang',
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
			'header'=>'Instalasi',
			'type'=>'raw',
			'value'=>'(isset($data->instalasi_nama) ? $data->instalasi_nama : "")',
		),
		array(
			'header'=>'Ruangan Penunjang',
			'type'=>'raw',
			'value'=>'(isset($data->ruangan_nama) ? $data->ruangan_nama : "")',
		),
		array(
			'header'=>'Dokter',
			'type'=>'raw',
			'value'=>'(isset($data->NamaDokter) ? $data->NamaDokter : "")',
		),
		array(
			'header'=>'Anestesi',
			'type'=>'raw',
			'value'=>'CHtml::link("<icon class=\'icon-form-ubah\' ></icon> ", Yii::app()->createUrl("/anestesi/informasiPasienPenunjang/anestesi", array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameAnestesi","rel"=>"tooltip", "title"=>"untuk melakukan anestesi", "onclick"=>"$(\'#dialogAnestesi\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
		),
    ),
		'afterAjaxUpdate'=>'function(id, data){
		jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>