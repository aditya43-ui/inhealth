<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if($caraPrint!="PDF"){
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}else{
   echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
   echo '<div style="margin-top:20px">';
   echo '</div>';
}
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
	'id'=>'resumemonev-t-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'No',
                'value'=>'$row+1',
            ),
            
            array(
                'header' => 'Tanggal Pelaporan',
                'name' => 'tgl_pelaporan',
                'value' => function($data) {
                    if (!empty($data->tgl_pelaporan)) {
                        echo MyFormatter::formatDateTimeForUser($data->tgl_pelaporan);
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Nama Pelapor',
                'name' => 'pelapor_nama',
                'value' => function($data) {
                    if (!empty($data->pelapor_id)) {
                        $modPegawai = PegawaiM::model()->findByPk($data->pelapor_id);
                        echo $modPegawai->namaLengkap;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Nomor Kejadian',
                'name' => 'no_kejadian',
                'value' => function($data) {
                    if (!empty($data->no_kejadian)) {
                        echo $data->no_kejadian;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Satuan Kerja',
                'name' => 'unitkerja_pelapor_id',
                'value' => function($data) {
                    if (!empty($data->unitkerja_pelapor_id)) {
                        echo $data->unitkerja->namaunitkerja;
                        ;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Tanggal Insiden',
                'name' => 'tgl_kejadian',
                'value' => function($data) {
                    if (!empty($data->tgl_kejadian)) {
                        echo MyFormatter::formatDateTimeForUser($data->tgl_kejadian);
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Lokasi Kejadian',
                'name' => 'lokasikejadian',
                'value' => function($data) {
                    if (!empty($data->lokasikejadian)) {
                        echo $data->lokasikejadian;
                    } else {
                        echo '';
                    }
                }
            ),
            array(
                'header' => 'Jenis Kejadian',
                'name' => 'jeniskejadian',
                'value' => function($data) {
                    if (!empty($data->jeniskejadian)) {
                        echo $data->jeniskejadian;
                    } else {
                        echo '';
                    }
                }
            ),
            array(
                'header' => 'Nama Korban',
                'name' => 'namakorban',
                'value' => function($data) {
                    if (!empty($data->namakorban)) {
                        echo $data->namakorban;
                    } else {
                        echo '';
                    }
                }
            ),
            array(
                'header' => 'Mengetahui Ketua K3RS',
                'name' => 'pegawai_mengetahui2_id',
                'value' => function($data) {
                    if (!empty($data->pegawai_mengetahui2_id)) {
                        echo $data->pegawai_mengetahui2->namaLengkap;
                    } else {
                        echo '';
                    }
                }
            ),
            array(
                'header' => 'Verifikasi',
                'type' => 'raw',
                'value' => function($data) {
                    $grading = '';
                    if ($data->tglverifikasi_pelaporan === null) {
                            $grading .= 'Belum Diverifikasi';
                    } else {
                        $grading .= 'Sudah Diverifikasi';
                    }
                    return $grading;
                },
                'htmlOptions' => array('style' => 'text-align:center;'),
            ),
        ),
    )); 
?>