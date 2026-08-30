<?php
/**
* digunakan untuk Master grading risiko
* @author Elham Budianto <elhambudianto@.com>
**/
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != "PDF") {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'colspan' => 5));
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'colspan' => 5));
    echo '<div style="margin-top:20px;">';
    echo '</div>';
}
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'monevchecklist-m-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$row+1',
        ),
        array(
            'header' => 'Peluang',
            'name' => 'peluang_id',
            'value' => function($data) {
                $peluang = PeluangM::model()->findByPk($data->peluang_id);
                if (!empty($peluang)) {
                    return $peluang->peluang_descriptor;
                } else {
                    return '-';
                }
            },
        ),
        array(
            'header' => 'Konsekuensi',
            'name' => 'konsekuensi_id',
            'value' => function($data) {
                $konsekuensi = KonsekuensiM::model()->findByPk($data->konsekuensi_id);
                if (!empty($konsekuensi)) {
                    return $konsekuensi->konsekuensi_namabobot;
                } else {
                    return '-';
                }
            },
        ),
        array(
            'header' => 'Detectability',
            'name' => 'detectability_id',
            'value' => function($data){
                $detectability = DetectabilityM::model()->findByPk($data->detectability_id);
                if(!empty($detectability)){
                    return $detectability->detectability_deskripsi;
                }else{
                    return '-';
                }
            },
        ),
        array(
            'header' => 'Tingkat Risiko',
            'name' => 'tingkatrisiko_riskregister_id',
            'value' => function($data) {
                $tingkatrisiko = TingkatrisikoRiskregisterM::model()->findByPk($data->tingkatrisiko_riskregister_id);
                if (!empty($tingkatrisiko)) {
                    return $tingkatrisiko->tingkatrisiko_nama;
                } else {
                    return '-';
                }
            },
        ),
        array(
            'header' => '<center>Status</center>',
            'value' => '($data->gradingrisiko_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
    ),
));
?>