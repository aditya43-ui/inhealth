
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
		////'penilaianpegawai_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->penilaianpegawai_id',
                ),
		'pegawai_id',
		'tglpenilaian',
		'periodepenilaian',
		'sampaidengan',
		'kesetiaan',
		/*
		'prestasikerja',
		'tanggungjawab',
		'ketaatan',
		'kejujuran',
		'kerjasama',
		'prakarsa',
		'kepemimpinan',
		'jumlahpenilaian',
		'nilairatapenilaian',
		'performanceindex',
		'penilaianpegawai_keterangan',
		'keberatanpegawai',
		'tanggal_keberatanpegawai',
		'tanggapanpejabat',
		'tanggal_tanggapanpejabat',
		'keputusanatasan',
		'tanggal_keputusanatasan',
		'lainlain',
		'dibuattanggalpejabat',
		'diterimatanggalpegawai',
		'diterimatanggalatasan',
		'penilainama',
		'penilainip',
		'penilaipangkatgol',
		'penilaijabatan',
		'penilaiunitorganisasi',
		'pimpinannama',
		'pimpinannip',
		'pimpinanpangkatgol',
		'pimpinanjabatan',
		'pimpinanunitorganisasi',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
 
        ),
    )); 
?>
