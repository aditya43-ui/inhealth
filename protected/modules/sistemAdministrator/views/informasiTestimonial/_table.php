<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$action = $this->getAction()->getId();
$currentUrl = Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'informasipegawailogin-v-grid',
	'dataProvider'=>$model->search(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-bordered table-striped datatable',
	'columns'=>array(
            array(
				'header'=>'No',
				'value'=>'$row+1',
			),
            array(
				'header'=>'Nama Pasien',
				'type'=>'raw',
				'value'=>'$data->pasien ? $data->pasien->nama_pasien : ""',
			),
			  array(
				'header'=>'Nomor Mobile',
				'type'=>'raw',
				'value'=>'$data->no_mobile',
			),
			   array(
				'header'=>'Email',
				'type'=>'raw',
				'value'=>'$data->email',
			),
			array(
				'header'=>'Deskripsi Testimoni',
				'type'=>'raw',
				'value'=>'$data->deskripsitestimoni',
			),
			array(
				'header'=>'Create Time',
				'type'=>'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_testimoni)',
			),
			array(
				'header'=>'Verifikasi Publish',
				'type'=>'raw',
				'value'=>function($data){
					if($data->is_publish){
						echo '<button class="btn btn-sm btn-danger" onclick="unpublish('.$data->testimonial_id.')">Unpublish</button>';
					}else{
						echo '<button class="btn btn-sm btn-success" onclick="publish('.$data->testimonial_id.')">Publish</button>';
					}
				},
			),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>