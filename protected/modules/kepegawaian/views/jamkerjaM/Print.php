
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
                                            array(
                                                        'header'=>'ID',
                                                        'value'=>'$data->presensi_id',
                                            ),
                                            array(
                                                        'header'=>'Status Kehadiran',
                                                        'value'=>'$data->statuskehadiran->statuskehadiran_nama',
                                             ),
                                             array(
                                                        'header'=>'Nama Pegawai',
                                                        'value'=>'$data->pegawai->nama_pegawai',
                                             ),
                                             array(
                                                        'name'=>'statusscan_nama',
                                                        'value'=>'$data->statusscan->statusscan_nama',
                                             ),
                                             array(
                                                        'name'=>'tglpresensi',
                                                        'value'=>'$data->tglpresensi',
                                             ),
                                             array(
                                                        'name'=>'no_fingerprint',
                                                        'value'=>'$data->no_fingerprint',
                                             ),
		/*
		'verifikasi',
		'keterangan',
		'jamkerjamasuk',
		'jamkerjapulang',
		'terlambat_mnt',
		'pulangawal_mnt',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
 
        ),
    )); 
?>