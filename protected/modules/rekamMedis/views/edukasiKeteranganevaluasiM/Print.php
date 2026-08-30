
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'edukasi_keteranganevaluasi_id',
		array(
            'name' => 'kodeedukator',
            'filter' => CHtml::activeDropDownList($model, 'kodeedukator', LookupM::getItems('kodeedukator'), array(
                'empty' => '-- Pilih --',
            ))
        ),
        'keterangan_evaluasi',
        'urutan',
        array(
            'header' => 'Status',
            'name' => 'is_aktif',
            'type' => 'raw',
            'value' => function($data) {
                return $data->is_aktif ? "Aktif" : "Tidak Aktif";
            },
            'filter' => false,
        ),
		/*
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
 
	),
)); 
?>