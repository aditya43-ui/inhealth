	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftarpasien-v-grid',
	'dataProvider'=>$model->searchInformasiBatalPeriksaPasien(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		'no_pendaftaran',
		array(
			'name'=>'tgl_pendaftaran',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
		),
		array(
			'name'=>'no_pendaftaran',
			'header'=>'No. Pendaftaran'.'/<br>'.'No. Rekam Medik',
			'type'=>'raw',
			'value'=>'"$data->no_pendaftaran"."<br>"."$data->no_rekam_medik"',
		),
		array(
			'name'=>'nama_pasien',
			'header'=>'Nama Pasien'.'/<br>'.'Alias',
			'type'=>'raw',
			'value'=>'"$data->nama_pasien"."<br>"."$data->nama_bin"',
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
			'value'=>'$data->nama_pegawai',
		),
		array(
			'name'=>'jeniskasuspenyakit_nama',
			'header'=>'Kasus Penyakit',
			'type'=>'raw',
			'value'=>'$data->jeniskasuspenyakit_nama',
		),
		array(
			'header'=>'Tanggal Pembatalan',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglbatal)',
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