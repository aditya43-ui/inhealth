<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != "PDF") {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
}
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchInformasiPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'rencanaumumpengadaan-m-grid',
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
            'header' => 'Nomor&nbsp;dan&nbsp;Tanggal ',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data)) {
                    return $data->notadinaspptk_nomor . '<br>' . date('d M Y', strtotime($data->notadinaspptk_tanggal));
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Nomor Nota Dinas',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->nomor_notadinas)) {
                    return $data->nomor_notadinas;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array('style' => 'text-align: center',),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
        ),
        array(
            'header' => 'Nama Pekerjaan',
            'type' => 'raw',
            'value' => function($data) {
                $modNota = NotadinaspptkT::model()->findByPk($data->notadinaspptk_id);
                if (!empty($modNota->paket_pekerjaan)) {
                    return $modNota->paket_pekerjaan;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Total',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->jumlah_diterima)) {
                    return 'Rp ' . number_format($data->jumlah_diterima, 2, ',', '.');
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Tahun Anggaran',
            'type' => 'raw',
            'value' => function($data) {
                $modNota = NotadinaspptkT::model()->findByPk($data->notadinaspptk_id);                
                if (!empty($modNota->suratperjanjiankerja_id)) {
                    $modInfo = DaftarnomorNotadinaspptkV::model()->findByAttributes(array('nomor_id' => $modNota->suratperjanjiankerja_id, 'kategori_pengadaan' => 'Penyedia'));
                } else {
                    $modInfo = DaftarnomorNotadinaspptkV::model()->findByAttributes(array('nomor_id' => $modNota->rencanaumumpengadaan_id, 'kategori_pengadaan' => 'Swakelola'));
                }

                if (!empty($modInfo->tahun)) {
                    return $modInfo->tahun;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'PPTK',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->pegpptk)) {
                    return $data->pegpptk;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'PJK',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->pegpjk)) {
                    return $data->pegpjk;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'PPK',
            'type' => 'raw',
            'value' => function($data) {
                if (!empty($data->pegppk)) {
                    return $data->pegppk;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
    ),
));
?>