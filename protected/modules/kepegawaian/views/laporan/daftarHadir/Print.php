
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
		////'shift_id',
		array(
                         'header' => 'No. FP',
                         'value' => '$data->nofingerprint',
                     ),                             
                    'kelompokpegawai.kelompokpegawai_nama',
                    'jabatan.jabatan_nama',
                    'nomorindukpegawai',
                    'nama_pegawai',                         
                     array(
                         'header' => 'Rerata Jam Masuk',                        
                         'value' => function ($data) use ($model){                            
                            return $this->renderPartial("daftarHadir/_rerataJamMasuk",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
                         }
                     ),                  
                    array(
                         'header' => 'Rerata Jam Pulang',
                         'value' => function ($data) use ($model){                            
                            return $this->renderPartial("daftarHadir/_rerataJamKeluar",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
                         }
                        
                     ),                                     
                    array(
                         'header' => 'Hadir',
                        // 'value' => '$data->getTotalStatusKehadiran(1, $data->pegawai_id)',
                         'value' => function ($data) use ($model){                            
                            return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_HADIR, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                         }   
                     ),
                    array(
                         'header' => 'Izin',
                        // 'value' => '$data->getTotalStatusKehadiran(2, $data->pegawai_id)'
                         'value' => function ($data) use ($model){                            
                            return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_IZIN, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                         } 
                     ),
                    array(
                         'header' => 'Sakit',
                         //'value' => '$data->getTotalStatusKehadiran(3, $data->pegawai_id)'
                         'value' => function ($data) use ($model){                            
                            return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_SAKIT, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                         } 
                     ),
                    array(
                         'header' => 'Dinas',
                         //'value' => '$data->getTotalStatusKehadiran(4, $data->pegawai_id)'
                         'value' => function ($data) use ($model){                            
                            return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_DINAS, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                         } 
                     ),
                    array(
                         'header' => 'Alpha',
                         //'value' => '$data->getTotalStatusKehadiran(5, $data->pegawai_id)'
                         'value' => function ($data) use ($model){                            
                            return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_ALPHA, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                         } 
                     ),
                    array(
                         'header' => 'Total Terlambat (Jam)',
                        // 'value'=>'$this->grid->owner->renderPartial("daftarHadir/_terlambat",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1),true)',
                         'value' => function ($data) use ($model){                            
                            return $this->renderPartial("daftarHadir/_terlambat",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
                         }   
                     ),
                    array(
                         'header' => 'Total Pulang Awal (Jam)',
                         //'value'=>'$this->grid->owner->renderPartial("daftarHadir/_pulangAwal",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2),true)',
                        'value' => function ($data) use ($model){                            
                            return $this->renderPartial("daftarHadir/_pulangAwal",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
                         } 
                     ),   
        ),
    )); 
?>