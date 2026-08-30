
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
		////'pasien_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->pasien_id',
                ),
		'pekerjaan_id',
		'kelurahan_id',
		'pendidikan_id',
		'propinsi_id',
		'kecamatan_id',
		/*
		'suku_id',
		'profilrs_id',
		'kabupaten_id',
		'no_rekam_medik',
		'tgl_rekam_medik',
		'jenisidentitas',
		'no_identitas_pasien',
		'namadepan',
		'nama_pasien',
		'nama_bin',
		'jeniskelamin',
		'kelompokumur',
		'tempat_lahir',
		'tanggal_lahir',
		'alamat_pasien',
		'rt',
		'rw',
		'statusperkawinan',
		'agama',
		'golongandarah',
		'rhesus',
		'anakke',
		'jumlah_bersaudara',
		'no_telepon_pasien',
		'no_mobile_pasien',
		'warga_negara',
		'photopasien',
		'alamatemail',
		'statusrekammedis',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'tgl_meninggal',
		*/
 
        ),
    )); 
?>