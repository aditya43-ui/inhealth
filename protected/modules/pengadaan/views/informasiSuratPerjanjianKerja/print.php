<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != "PDF") {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
} else {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
    echo '<div style="margin-top:20px">';
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
    'id' => 'resumemonev-t-grid',
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
            'header' => 'Tanggal & <br>Nomor Transaksi',
            'name' => 'tglsuratperjanjian',
            'value' => function($data) {
                $tanggal = !empty($data->tglsuratperjanjian) ? MyFormatter::formatDateTimeForUser($data->tglsuratperjanjian) : '';
                $nomor = !empty($data->nosuratperjanjiankerja) ? $data->nosuratperjanjiankerja : '';
                echo $tanggal . '<br>' . $nomor;
            },
        ),
        array(
            'header' => 'Nomor Kontrak',
            'name' => 'nomor_dokumen'
        ),
        array(
            'header' => 'Nama Pekerjaan',
            'name' => 'namapekerjaan'
        ),
        array(
            'header' => 'Penyedia',
            'name' => 'supplier_nama'
        ),
        array(
            'header' => 'Nilai Pekerjaan',
            'name' => 'nilaikontrak',
            'value' => function ($data) {
                return 'Rp. ' . number_format($data->nilaikontrak, 2);
            },
            'htmlOptions' => array('style' => 'text-align:right')
        ),
        array(
            'header' => 'Status',
            'name' => 'suratperjanjiankerja_status'
        ),
        array(
                'header' => 'Riwayat Addendum',
                'type' => 'raw',
                'value' => function($data){
                    $criteria = new CDbCriteria();
                    $criteria->addCondition("persiapanpengadaan_id = ".$data->persiapanpengadaan_id);
                    $criteria->addCondition('suratperjanjiankerjaasal_id is not null');
                    $criteria->order = "nomor_urut asc";
                    $cariSPK = SuratperjanjiankerjaT::model()->findAll($criteria);
                    
                    if (!empty($cariSPK)) {
                        foreach($cariSPK as $model){
                            echo "(".$model->nomor_urut."). ".$model->nomor_dokumen."<br>";
                        }
                    } else {
                        return "Belum ada Addendum";
                    }
                }
            ),
    ),
));
?>