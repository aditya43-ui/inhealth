
<?php 
if($caraPrint == 'EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode, 'colspan'=>10));      
?>
<?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'laporanpresensi-t-grid',
	'dataProvider'=>$model->searchPrintpresensi(),
//	'filter'=>$model,
        'template'=>"{pager}\n{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        'mergeColumns' => array('pegawai.nomorindukpegawai'),
         'mergeHeaders'=>array(
                    array(
                        'name'=>'<p style="margin: 0; text-align: center;">Jadwal Presensi</p>',
                        'start'=>'6',
                        'end'=>'10',
                    ),
                ),
	'columns'=>array(
		/* array(
                    'header'=>'No.',
                    'type'=>'raw',
                    'value' => '$row+1'
                ),*/
                array(
                    'header' => 'No. FP',
                    'value' => '$data->no_fingerprint'
                ),
               'pegawai.kelompokpegawai.kelompokpegawai_nama',
                'pegawai.jabatan.jabatan_nama',
                'pegawai.nomorindukpegawai',
                'pegawai.nama_pegawai',  
                  array(
                        'header' => 'Shift / Jam Kerja',
                        'value'=>'$this->grid->owner->renderPartial("presensiT/_shift",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_MASUK, "datepresensi"=>$data->datepresensi),true)',
                    ),
                array(
                    'header'=>'Tanggal Presensi',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->datepresensi)',
                ),
                /*
                array(
                    'header'=>'Jabatan',
                    'value'=>'$data->pegawai->jabatan->jabatan_nama',
                ),
                 * 
                 */
//                array(
//                    'header'=>'Tanggal Presensi',
//                    'value'=>'$data->tglpresensi',
//                ),
               array(
                    'header'=>'<p style="margin: 0; text-align: center;">Masuk</p>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_MASUK, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Keluar</p>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_KELUAR, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Pulang</p>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_PULANG, "datepresensi"=>$data->datepresensi),true)',
                ),                
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Datang</p>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_DATANG, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header' => 'Terlambat (Menit)',
                     'value'=>'$this->grid->owner->renderPartial("presensiT/_terlambat",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_MASUK, "datepresensi"=>$data->datepresensi),true)',
                      'htmlOptions' => array('style'=>'text-align:center;')   
                ),
                array(
                    'header' => 'Pulang Awal (Menit)',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_pulangAwal",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_PULANG, "datepresensi"=>$data->datepresensi),true)',
                     'htmlOptions' => array('style'=>'text-align:center;')   
                ),
                array(
                    'header' => 'Status',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statuskehadiran",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id, "datepresensi"=>$data->datepresensi),true)',
                ),
            )
)); ?>

