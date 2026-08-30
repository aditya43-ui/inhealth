
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
		////'warnadokrm_id',
		array(
			'header'=>'ID',
			'value'=>'$data->warnadokrm_id',
		),
		'warnadokrm_namawarna',
                    
                    array(
                        'name'=>'warnadokrm_kodewarna',
                        'type'=>'raw',
                        'header'=>'Warna',
                        'value'=>function($data) {
                            return '<div style="width:100px; border: 1px solid black; background-color:#'.$data->warnadokrm_kodewarna.';">&nbsp;</div>';
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        ),
                        'filter'=>false,
                    ),
		'warnadokrm_fungsi',
                            array(
                                'header' => 'Status',
                                'value'=>'($data->warnadokrm_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions'=>array('style'=>'text-align:center;'),
                            ),
 
	),
)); 
?>