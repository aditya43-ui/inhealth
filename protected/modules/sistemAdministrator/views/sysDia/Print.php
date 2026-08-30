
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>6));      

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		// array(
        //     'header'=>'ID',
        //     'value'=>'$data->sysdia_id',
        // ),
        array(
            'header'=>'No.',
            'value' => '($this->grid->dataProvider->pagination) ?
                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                : ($row+1)',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:center;'),
        ),
		'kelompokumur.kelompokumur_nama',
		'systolic_min',
		'systolic_max',
		'diastolic_min',
		'diastolic_max',
        array(
            'header'=>'Aktif',
            'type'=>'raw',
            'value'=>'(($data->sysdia_aktif==1)? "Ya" : "Tidak")'
        ),
		/*
		'sysdia_range',
		'sysdia_nama',
		'sysdia_desc',
		'sysdia_aktif',
		*/
 
        ),
    )); 
?>