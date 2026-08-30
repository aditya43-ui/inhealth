<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$action = $this->getAction()->getId();
$currentUrl = Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'logpembatalanolehuser-v-grid',
	'dataProvider'=>$model->searchInformasi(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-bordered table-striped datatable',
	'columns'=>array(
            array(
			'header' => 'No.',
			'type'=>'raw',
			'value'=>'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
		),
            array(
			'header'=>'Tanggal Log',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_log)',
		),
            array(
			'header'=>'Nama Pegawai',
			'type'=>'raw',
			'value'=>'$data->nama_pegawai',
		),
            array(
			'header'=>'Ruangan',
			'type'=>'raw',
			'value'=>'$data->ruangan_nama',
		),
            array(
			'header'=>'Jenis Log',
			'type'=>'raw',
			'value'=>'$data->jenislog',
		),
            array(
			'header'=>'Keterangan',
			'type'=>'raw',
			'value'=>'$data->keterangan_log',
		),	
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>