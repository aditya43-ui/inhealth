<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridViewRp';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchLaporanPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridViewRp';
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
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass = 'table border';
} else {
    $data = $model->searchLaporanPrint();
    $template = "{summary}\n{items}\n{pager}";
}

$data2 = $model->searchLaporanPrint();
$jumlah_paket = 0;
$total_paket = 0;
foreach($data2->data as $item){
    $jumlah_paket += $item['jumlah_paket'];
    $total_paket += $item['total_paket'];
}
$this->widget($table, array(
    'id' => 'laporanrup-v-grid',
    'replaceUrl' => true,
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'mergeColumns' => array('namaunitkerja', 'kode_kegiatan', 'nama_kpa' , 'pegawaippk_id', 'rencanaumumpengadaan_kategori'),
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions' => array('style' => 'text-align: center; vertical-align: middle',),
            'value' => '($this->grid->dataProvider->pagination) ? 
                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                        : ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:left;'),
        ),
        array(
            'name' => 'namaunitkerja',
            'htmlOptions' => array('style' => 'text-align: left; ',),
            'headerHtmlOptions' => array( 'style' => 'text-align: center',),
            'type' => 'raw',
            'header' => 'Unit Kerja',
            'value' => function($data) {
                return $data->namaunitkerja . "<span style='display: none'>" . $data->kode_kegiatan . "</span>";
            },
        ),
        array(
            'name' => 'kode_kegiatan',
            'htmlOptions' => array('style' => 'text-align: center;',),
            'headerHtmlOptions' => array( 'style' => 'text-align: center'),
            'type' => 'raw',
            'header' => 'Kode Kegiatan',
            'value' => function($data) {
                return $data->kode_kegiatan . "<span style='display: none'>" . $data->namaunitkerja . "</span>";
            },
        ),
        array(
            'name' => 'nama_kpa',
            'htmlOptions' => array('style' => 'text-align: left;',),
            'headerHtmlOptions' => array('style' => 'text-align: center'),
            'type' => 'raw',
            'header' => 'KPA',
            'value' => function($data) {
                $modPegawai = PegawaiM::model()->findByPk($data->pegawaikpa_id);
                return $modPegawai->namaLengkap . "<span style='display: none; color: white !important'>" . $data->kode_kegiatan . $data->namaunitkerja . "</span>";
            },
        ),
        array(
            'name' => 'pegawaippk_id',
            'htmlOptions' => array('style' => 'text-align: left;',),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'type' => 'raw',
            'header' => 'PPK',
            'value' => function($data) {
                $modPegawai = PegawaiM::model()->findByPk($data->pegawaippk_id);
                return $modPegawai->namaLengkap. "<span style='display:none'>" . $data->pegawaikpa_id . $data->kode_kegiatan . $data->namaunitkerja . "</span>";
            },
        ),
        array(
            'name' => 'rencanaumumpengadaan_kategori',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center;',),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'header' => 'Kategori',
            'value' => function($data){
                return $data->rencanaumumpengadaan_kategori. "<span style='display:none'>" . $data->pegawaippk_id  .$data->pegawaikpa_id . $data->kode_kegiatan . $data->namaunitkerja . "</span>";
            }
        ),
        array(
            'htmlOptions' => array('style' => 'text-align: center;',),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'header' => 'Status',
            'value' => '$data->rencanaumumpengadaan_status',
            'footer' => '<b> Total </b>',
            'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align: center;'),
        ),
        array(
            'htmlOptions' => array('style' => 'text-align: center;',),
            'headerHtmlOptions' => array('style' => 'text-align: center', ),
            'header' => 'Jumlah Paket',
            'value' => '$data->jumlah_paket',
            'footer' => $jumlah_paket,
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'header' => 'Total',
            'htmlOptions' => array('style' => 'text-align: right;',),
            'value' => function($data){
                echo "Rp. ". number_format($data->total_paket, 2, ',', '.');
            },
            'footer' => "Rp. ". number_format($total_paket, 2, ',', '.'),
            'footerHtmlOptions' => array('style' => 'text-align: right;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>