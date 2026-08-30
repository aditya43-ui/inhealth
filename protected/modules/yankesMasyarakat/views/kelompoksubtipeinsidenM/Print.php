<?php
/**
 * digunakan untuk Master kelompok subtipe insiden
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * */

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != "PDF") {
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
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
            'header' => 'Tipe Insiden',
            'name' => 'tipeinsiden_id',
            'value' => function($data) {
                $tipeinsiden = TipeinsidenM::model()->findByPk($data->tipeinsiden_id);
                if (!empty($tipeinsiden)) {
                    return $tipeinsiden->tipeinsiden_nama;
                } else {
                    return '-';
                }
            },
        ),
        array(
            'header' => 'Nama Kelompok Subtipe Insiden',
            'name' => 'kelompoksubtipeinsiden_nama',
            'value' => '$data->kelompoksubtipeinsiden_nama',
        ),
        array(
            'header' => 'Nama Lain Subtipe Insiden',
            'name' => 'kelompoksubtipeinsiden_namalainnya',
            'value' => '$data->kelompoksubtipeinsiden_namalainnya',
        ),
        array(
            'header' => '<center>Status</center>',
            'value' => '($data->kelompoksubtipeinsiden_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
    ),
));
?>