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
        $data = $model->searchPrintInformasi();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrintInformasi();
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
                'header' => 'Nomor Dokumen',
                'name' => 'no_dokumen',
                'value' => function($data) {
                    if (!empty($data->no_dokumen)) {
                        echo $data->no_dokumen;
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
                'header' => 'NIP',
                'value' => function($data) {
                    if (!empty($data->nomorindukpegawai)) {
                        echo $data->nomorindukpegawai;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Saksi',
                'value' => function($data) {
                    if (!empty($data->saksi1)) {
                        echo $data->saksi1. " / <br>" . $data->saksi2. " / <br>" . $data->saksi3;
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
                        echo $data->tgl_kejadian;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Unit Kerja Kejadian',
                'name' => 'unitkerja_kejadian_nama',
                'value' => function($data) {
                    if (!empty($data->unitkerja_kejadian_id)) {
                        $modDialogUnitKerja = UnitkerjaM::model()->findByPk($data->unitkerja_kejadian_id);
                        echo $modDialogUnitKerja->namaunitkerja;
                    } else {
                        echo '';
                    }
                },
                'htmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Lokasi Kejadian',
                'value' => function($data) {
                    if (!empty($data->lokasikejadian)) {
                        echo $data->lokasikejadian;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Mengetahui Ketua K3RS',
                'name' => 'mengetahuipegawai_nama',
                'value' => function($data) {
                    if (!empty($data->mengetahuipegawai_id)) {
                        echo $data->pegawai_mengetahui->namaLengkap;
                    } else {
                        echo '';
                    }
                },
                'htmlOptions' => array('style' => 'text-align:center;'),
            ),
        ),
    )); 
?>