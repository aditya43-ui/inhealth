
<?php
$table = 'ext.bootstrap.widgets.BootGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'kegiatanoperasi_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->kegiatanoperasi_id',
                ),
		'kegiatanoperasi_kode',
		'kegiatanoperasi_nama',
		'kegiatanoperasi_namalainnya',
		 array
                (
                        'name'=>'kegiatanoperasi_aktif',
                        'type'=>'raw',
                        'value'=>'($data->kegiatanoperasi_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
 
        ),
    )); 
?>