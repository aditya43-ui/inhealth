
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
	'id'=>'sapemeriksaan-rad-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                        'name'=>'pemeriksaanrad_id',
                        'value'=>'$data->pemeriksaanrad_id',
                        'filter'=>false,

                ),
        //'daftartindakan_id',
            array(
                        'name'=>'daftartindakan_nama',
                        //'filter'=>  CHtml::listData($model->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'),
                        'value'=>'$data->daftartindakan->daftartindakan_nama',

                ),
        'pemeriksaanrad_jenis',
		'pemeriksaanrad_nama',
		'pemeriksaanrad_namalainnya',
		'pemeriksaanrad_aktif',
 
        ),
    )); 
?>