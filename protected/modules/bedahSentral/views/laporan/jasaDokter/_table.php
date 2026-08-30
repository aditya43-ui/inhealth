<?php
$rim = '';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchJasaDokter();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)) {
    $sort = false;
    $data = $model->searchPrintJasaDokter();
    $rim = '';
    $template = "{items}";
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>

<div id="div_rekap">
    <div style="<?php echo $rim; ?>">
        <?php
        if (isset($caraPrint)) {
        } else {
        ?>
            <legend class="rim"> Tabel Rekap Jasa Dokter </legend>
        <?php } ?>
        <?php
        $this->widget($table, array(
            'id' => 'laporanrekapjasadokter-grid',
            'dataProvider' => $data,
            'enableSorting' => $sort,
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'mergeHeaders' => array(
                array(
                    'name' => '<p style="margin: 0; text-align: center;">Dokter</p>',
                    'start' => 1, //indeks kolom 3
                    'end' => 4, //indeks kolom 4
                ),
                array(
                    'name' => '<p style="margin: 0; text-align: center;">Bedah</p>',
                    'start' => 7, //indeks kolom 3
                    'end' => 9, //indeks kolom 4
                ),
            ),
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header' => 'Gelar Depan',
                    'type' => 'raw',
                    'value' => '(empty($data->gelardepan) ? "-" : "$data->gelardepan" )',
                ),
                array(
                    'header' => 'Nama Dokter',
                    'type' => 'raw',
                    'value' => '(empty($data->nama_pegawai) ? "-" : "$data->nama_pegawai" )',
                ),
                array(
                    'header' => 'Gelar Belakang',
                    'type' => 'raw',
                    'value' => '(empty($data->gelarbelakang_nama) ? "-" : "$data->gelarbelakang_nama" )',
                ),
                array(
                    'header' => 'Visite',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifVisit",array(pegawai_id=>"$data->pegawai_id"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Konsul',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifKonsul",array(pegawai_id=>"$data->pegawai_id"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Tindakan',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifTindakan",array(pegawai_id=>"$data->pegawai_id"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Jasa Operator',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifOperator",array(pegawai_id=>"$data->pegawai_id"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Sewa Alat',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifSewaAlat",array(pegawai_id=>"$data->pegawai_id"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Alat Bahan',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifAlatBahan",array(pegawai_id=>"$data->pegawai_id"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Total',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifTotal",array(pegawai_id=>"$data->pegawai_id"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),

            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>

<div id="div_detail">
    <div style="<?php echo $rim; ?>">
        <?php
        if (isset($caraPrint)) {
            $dataDetail = $model->searchPrintDetailJasaDokter();
        } else {
            $dataDetail = $model->searchDetailJasaDokter();
        ?>
            <legend class="rim"> Tabel Rekap Detail Jasa Dokter </legend>
        <?php } ?>
        <?php
        $this->widget($table, array(
            'id' => 'laporandetailjasadokter-grid',
            'dataProvider' => $dataDetail,
            'enableSorting' => $sort,
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'mergeHeaders' => array(
                array(
                    'name' => '<p style="margin: 0; text-align: center;">Dokter</p>',
                    'start' => 7, //indeks kolom 3
                    'end' => 9, //indeks kolom 4
                ),
                array(
                    'name' => '<p style="margin: 0; text-align: center;">Bedah</p>',
                    'start' => 12, //indeks kolom 3
                    'end' => 15, //indeks kolom 4
                ),
            ),
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header' => 'Tgl. Transaksi',
                    'type' => 'raw',
                    'value' => '$data->tgl_pendaftaran',
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'type' => 'raw',
                    'value' => '$data->no_rekam_medik',
                ),
                array(
                    'header' => 'Nama Lengkap',
                    'type' => 'raw',
                    'value' => '$data->nama_pasien',
                ),
                array(
                    'header' => 'Unit Pelayanan',
                    'type' => 'raw',
                    'value' => '$data->instalasi_nama',
                ),
                array(
                    'header' => 'Nama Ruangan',
                    'type' => 'raw',
                    'value' => '$data->ruangan_nama',
                ),
                array(
                    'header' => 'Jumlah',
                    'type' => 'raw',
                    'value' => '$data->qty_tindakan',
                ),
                array(
                    'header' => 'Gelar Depan',
                    'type' => 'raw',
                    'value' => '(empty($data->gelardepan) ? "-" : "$data->gelardepan" )',
                ),
                array(
                    'header' => 'Nama Dokter',
                    'type' => 'raw',
                    'value' => '(empty($data->nama_pegawai) ? "-" : "$data->nama_pegawai" )',
                ),
                array(
                    'header' => 'Gelar Belakang',
                    'type' => 'raw',
                    'value' => '(empty($data->gelarbelakang_nama) ? "-" : "$data->gelarbelakang_nama" )',
                ),
                array(
                    'header' => 'Visite',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifVisit",array(pendaftaran_id=>"$data->pendaftaran_id",ruangan_id=>"$data->ruangan_id",tgl_pendaftaran=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Konsul',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifKonsul",array(pendaftaran_id=>"$data->pendaftaran_id",ruangan_id=>"$data->ruangan_id",tgl_pendaftaran=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Tindakan',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifTindakan",array(pendaftaran_id=>"$data->pendaftaran_id",ruangan_id=>"$data->ruangan_id",tgl_pendaftaran=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Jasa Operator',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifOperator",array(pendaftaran_id=>"$data->pendaftaran_id",ruangan_id=>"$data->ruangan_id",tgl_pendaftaran=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Sewa Alat',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifSewaAlat",array(pendaftaran_id=>"$data->pendaftaran_id",ruangan_id=>"$data->ruangan_id",tgl_pendaftaran=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Alat Bahan',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifAlatBahan",array(pendaftaran_id=>"$data->pendaftaran_id",ruangan_id=>"$data->ruangan_id",tgl_pendaftaran=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),
                array(
                    'header' => 'Total',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifTotal",array(pendaftaran_id=>"$data->pendaftaran_id",ruangan_id=>"$data->ruangan_id",tgl_pendaftaran=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                ),

            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>

<br>