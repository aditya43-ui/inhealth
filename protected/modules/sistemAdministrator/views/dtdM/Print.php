
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
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'dtd_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->dtd_id',
                ),
		//'diagnosa_id',
		//'dtd_no',
		'dtd_noterperinci',
		'dtd_nama',
		'dtd_namalainnya',
                 array
                (
                        'header'=>'Menular',
                        'type'=>'raw',
                        'value'=>'($data->dtd_menular==TRUE)?"Menular":"Tidak Menular"',
                ),
             array
                (
                        'header'=>'Status',
                        'type'=>'raw',
                        'value'=>'($data->dtd_aktif==TRUE)?"Aktif":"Tidak Aktif"',
                ),
		/*
		'dtd_katakunci',
		'dtd_nourut',
		'dtd_menular',
		'dtd_aktif',
		*/
 
        ),
    )); 
?>