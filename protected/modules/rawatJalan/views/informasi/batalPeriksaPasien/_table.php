<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftarpasien-v-grid',
	'dataProvider'=>$model->searchInformasiBatalPeriksaPasien(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
		array(
			'header'=>'Tanggal Pembatalan',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglbatal)',
		),	
		array(
                        'header'=>'Tgl. Pendaftaran<br>No. Pendaftaran',
			'name'=>'tgl_pendaftaran',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."<br>".$data->no_pendaftaran',
		),
		array(
			'name'=>'no_rekam_medik',
			'header'=>'No. Rekam Medik',
			'type'=>'raw',
			'value'=>'$data->no_rekam_medik',
		),
		array(
			'name'=>'nama_pasien',
			'header'=>'Nama Pasien',
			'type'=>'raw',
			'value'=>'$data->namadepan.$data->nama_pasien',
		),
		array(
			'name'=>'carabayar_nama',
			'header'=>'Jenis Penjamin'.'/<br>'.'Penjamin',
			'type'=>'raw',
			'value'=>'"$data->carabayar_nama"."<br>"."$data->penjamin_nama"',
		),
		array(
			'name'=>'nama_pegawai',
			'header'=>'Dokter',
			'type'=>'raw',
			'value'=>'$data->gelardepan.$data->nama_pegawai.",".$data->gelarbelakang_nama',
		),
		array(
			'name'=>'jeniskasuspenyakit_nama',
			'header'=>'Kasus Penyakit',
			'type'=>'raw',
			'value'=>'$data->jeniskasuspenyakit_nama',
		),
		array(
			'name'=>'keterangan_batal',
			'header'=>'Keterangan Batal',
			'type'=>'raw',
			'value'=>'$data->keterangan_batal',
		),
		array(        
			'name'=>'nama_pemakai',
			'header'=>'Dibatalkan Oleh',
			'type'=>'raw',
			'value'=>'$data->nama_pemakai',
		),               
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>