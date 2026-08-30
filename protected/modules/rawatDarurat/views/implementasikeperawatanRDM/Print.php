
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'implementasikeperawatan_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->implementasikeperawatan_id',
                ),
		'diagnosakeperawatan_id',
		'rencanakeperawatan_id',
		'implementasikeperawatan_kode',
		'implementasi_nama',
		'iskolaborasiimplementasi',
 
        ),
    )); 
?>