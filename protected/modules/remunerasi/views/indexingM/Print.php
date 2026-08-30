
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->search();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table, array(
	'id'=>'indexing-m-grid',
	'dataProvider'=>$data,
        'enableSorting'=>$sort,
        'template'=>$template,
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
		array(
                    'header' => 'ID',
                    'value' => '$data->indexing_id'
                ),
                array(
                    'header' => 'Kelompok Remunerasi',
                    'name' => 'kelrem_id',
                    'value' => '$data->kelrem->kelrem_nama',
                    'filter' => CHtml::dropDownList('IndexingM[kelrem_id]', $model->kelrem_id, CHtml::listData(KelremM::model()->findAll("kelrem_aktif = TRUE ORDER BY kelrem_nama ASC"), 'kelrem_id', 'kelrem_nama'),array('empty'=>'-- Pilih --')),
                ),
		//'indexing_urutan',
		'indexing_nama',
		'indexing_singk',
		'indexing_nilai',
		/*
		'indexing_aktif',
		*/
                                array(
                                        'header'=>'Aktif',
                                        'value'=>'(($data->indexing_aktif==TRUE) ? "Ya" : "Tidak")',
                                ),
	),
)); ?>