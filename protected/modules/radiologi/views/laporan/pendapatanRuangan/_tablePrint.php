<?php
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $row = '$row+1';
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.BootGridViewPDF';
    }

    echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass = 'table border';
} else {
    $data = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}
?>

<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    //'mergeHeaders'=>array(
    //  array(
    //    'name'=>'<p style="margin: 0; text-align: center;">Tarif</p>',
    //  'start'=>7, //indeks kolom 3
    //'end'=>12, //indeks kolom 4
    //),
    //),
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'value' => $row
        ),
        array(
            'header' => 'Tanggal Pendaftaran/ <br> No. Pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran'
        ),
        array(
            'header' => 'No. Rekam Medik',
            'value' => '$data->no_rekam_medik'
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien'
        ),
        array(
            'header' => 'Dokter',
            'value' => function ($data) {
                $d = PegawaiM::model()->findByPk($data->dokterpemeriksa1_id);

                if (!empty($d)) {
                    return $d->namaLengkap;
                } else {
                    return '-';
                }
            },
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Jenis Penjamin/<br>Penjamin',
            'type' => 'raw',
            'name' => 'carabayarPenjamin',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
        ),
        array(
            'header' => 'Kelas Pelayanan',
            'type' => 'raw',
            'value' => '$data->kelaspelayanan_nama',
            //                    'name'=>'kelaspelayanan_nama',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
            'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align:right;font-style:italic;'),
            'footer' => '<b>Total</b>',
        ),
        /*array(
                    'header'=>'Satuan',
                    'name'=>'tarif_satuan',
                    'value'=>'"Rp".number_format($data->tarif_satuan,0,"",".")',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_satuan)',
                ),
                array(
                    'header'=>'CytoTindakan',
                    'name'=>'tarifcyto_tindakan',
                    'value'=>'"Rp".number_format($data->tarifcyto_tindakan,0,"",".")',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarifcyto_tindakan)',
                ),
                array(
                      'header'=>'Biaya Operasional',
                    'name'=>'tarif_rsakomodasi',
                    'value'=>'"Rp".number_format($data->tarif_rsakomodasi,0,"",".")',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_rsakomodasi)',
                ),
                array(
                      'header'=>'Jasa Pelayanan',
                    'name'=>'tarif_medis',
                    'value'=>'"Rp".number_format($data->tarif_medis,0,"",".")',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_medis)',
                ),
//                array(
//                    'name'=>'tarif_paramedis',
//                    'value'=>'number_format($data->tarif_paramedis)',
//                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
//                    'htmlOptions'=>array('style'=>'text-align:right;'),
//                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
//                    'footer'=>'sum(tarif_paramedis)',
//                ),
                array(
                    'name'=>'tarif_bhp',
                    'value'=>'"Rp".number_format($data->tarif_bhp,0,"",".")',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>'sum(tarif_bhp)',
                ),*/
        array(
            'header' => 'Total (Rp)',
            'name' => 'totalTarif',
            'value' => 'number_format($data->totalTarif,0,"",".")',
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:right;'),
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'sum(totalTarif)',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>