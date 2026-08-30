
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
		////'kembalirm_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->kembalirm_id',
                ),
		'pengirimanrm_id',
		'pendaftaran_id',
		'peminjamanrm_id',
		'pasien_id',
		'dokrekammedis_id',
		/*
		'tglkembali',
		'lengkapdokumenkembali',
		'petugaspenerima',
		'keterangan_pengembalian',
		'ruanganasal_id',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
 
        ),
    )); 
?>