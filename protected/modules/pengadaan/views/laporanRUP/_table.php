<?php
$data2 = $model->searchLaporanPrint();
$jumlah_paket = 0;
$total_paket = 0;
foreach($data2->data as $item){
    $jumlah_paket += $item['jumlah_paket'];
    $total_paket += $item['total_paket'];
}
$this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
    'id' => 'laporan-grid',
    'dataProvider' => $model->searchLaporan(),
    'template' => "{summary}\n{items}\n{pager}",
    'mergeColumns' => array('namaunitkerja', 'kode_kegiatan', 'nama_kpa' , 'pegawaippk_id', 'rencanaumumpengadaan_kategori'),
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => '($this->grid->dataProvider->pagination) ? 
                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                        : ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'footer' => '<b> Total </b>',
            'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align: center'),
        ),
        array(
            'name' => 'namaunitkerja',
            'headerHtmlOptions' => array( 'style' => 'text-align: center',),
            'type' => 'raw',
            'header' => 'Unit Kerja',
            'value' => function($data) {
                return $data->namaunitkerja . "<span class'hide".$data->kode_kegiatan."</span>";
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'name' => 'kode_kegiatan',
            'htmlOptions' => array('style' => 'text-align: center;',),
            'headerHtmlOptions' => array( 'style' => 'text-align: center'),
            'type' => 'raw',
            'header' => 'Kode Kegiatan',
            'value' => function($data) {
                return $data->kode_kegiatan . "<span class='hide'>".$data->namaunitkerja."</span>";
            },
                    'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
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
            },'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
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
            }, 'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
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
            }, 'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'htmlOptions' => array('style' => 'text-align: center;',),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'header' => 'Status',
            'value' => '$data->rencanaumumpengadaan_status',
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'htmlOptions' => array('style' => 'text-align: center;',),
            'headerHtmlOptions' => array('style' => 'text-align: center', ),
            'header' => 'Jumlah Paket',
            'value' => '$data->jumlah_paket',
            'footer' => "<b>".$jumlah_paket."</b>",
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
        ),
        array(
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'header' => 'Total',
            'htmlOptions' => array('style' => 'text-align: right;',),
            'value' => function($data){
                echo "Rp. ". number_format($data->total_paket, 2, ',', '.');
            },
            'footer' => "<b> Rp. ". number_format($total_paket, 2, ',', '.') ."</b>",
            'footerHtmlOptions' => array('style' => 'text-align: right;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>