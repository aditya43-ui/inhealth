
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
    $template = "{items}";
}
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');   
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));      

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'layarantrian_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->layarantrian_id',
                ),
		'layarantrian_jenis',
		'layarantrian_nama',
		'layarantrian_judul',
		'layarantrian_runningtext',
		'layarantrian_latarbelakang',
                array(
                    'header' => 'Status',
                     'value' => '($data->layarantrian_aktif)?"Aktif":"Tidak Aktif"'
                ),
		/*
		'layarantrian_maksitem',
		'layarantrian_itemhigh',
		'layarantrian_itemwidth',
		'layarantrian_intrefresh',
		'layarantrian_aktif',
		*/
 
        ),
    )); 
?>