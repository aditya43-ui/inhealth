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
                        'name'=>'<p style="margin: 0; text-align: center;">Jam Presensi</p>',
                        'start'=>'5',
                        'end'=>'8',
                    ),
                ),
	'columns'=>array(
		 array(
                    'header' => 'No.',
                    'type'=>'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
               'pegawai.nomorindukpegawai',
               'pegawai.nofingerprint',
               'pegawai.nama_pegawai',
               'pegawai.unit_perusahaan',
                array(
                    'header'=>'Tanggal presensi',
                    'value'=>'$data->datepresensi',
                ),
                /*
                array(
                    'header'=>'Jabatan',
                    'value'=>'$data->pegawai->jabatan->jabatan_nama',
                ),
                 * 
                 */
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Masuk</p>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array(pegawai_id=>$data->pegawai_id ,statusscan_id=>1, datepresensi=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Pulang</p>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array(pegawai_id=>$data->pegawai_id ,statusscan_id=>2, datepresensi=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Keluar</p>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array(pegawai_id=>$data->pegawai_id ,statusscan_id=>3, datepresensi=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Datang</p>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array(pegawai_id=>$data->pegawai_id ,statusscan_id=>4, datepresensi=>$data->datepresensi),true)',
                ),
                array(
                    'header' => 'Status',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statuskehadiran",array(pegawai_id=>$data->pegawai_id, datepresensi=>$data->datepresensi),true)',
                ),
                
            )
)); ?>

