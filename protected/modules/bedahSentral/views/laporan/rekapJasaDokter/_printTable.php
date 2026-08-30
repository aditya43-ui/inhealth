<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
//    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$itemCss = 'table table-bordered table-striped table-condensed';
if (isset($caraPrint)) {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
    $row = '$row+1';
    $data = $model->searchPrintJasaDokter();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    $itemCss = 'table border';
} else {
    $data = $model->searchJasaDokter();
    $template = "{summary}\n{items}\n{pager}";
}
?>

<?php if ($tab == "rekap") { ?>
    <div id="div_rekap">
        <?php if (isset($caraPrint)) {
        } else { ?>
            <legend class="rim">
                <i class="entypo-credit-card"></i> Tabel <b>Rekap Jasa Dokter</b>
            </legend>
        <?php } ?>
        <?php
        $this->widget($table, array(
            'id' => 'laporanrekapjasadokter-grid',
            'dataProvider' => $data,
            'enableSorting' => $sort,
            'template' => $template,
            'itemsCssClass' => $itemCss,
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1'
                ),
                array(
                    'header' => 'Tgl. Pendaftaran/<br> No. Pendaftaran',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran',
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'type' => 'raw',
                    'value' => '$data->no_rekam_medik',
                ),
                array(
                    'header' => 'Nama Pasien',
                    'type' => 'raw',
                    'value' => '$data->namadepan." ".$data->nama_pasien',
                ),
                array(
                    'header' => 'Kelas Pelayanan',
                    'type' => 'raw',
                    'value' => '$data->kelaspelayanan_nama',
                ),
                array(
                    'header' => 'Uraian Tindakan',
                    'type' => 'raw',
                    'value' => '$data->daftartindakan_nama',
                ),
                array(
                    'header' => 'Nama Dokter',
                    'type' => 'raw',
                    'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                ),
                array(
                    'header' => 'Tanggal Keluar',
                    'type' => 'raw',
                    'value' => '(isset($data->tgl_keluar) ?MyFormatter::formatDateTimeForUser($data->tgl_keluar) : "-")',
                ),
                array(
                    'header' => 'Jasa Pelayanan',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->tarif_tindakankomp)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Instalasi/ <br>Ruangan',
                    'type' => 'raw',
                    'value' => '$data->instalasi_nama."/<br>".$data->ruangan_nama'
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
<?php } else if ($tab == "detail") { ?>
    <div id="div_detail">
        <?php if (isset($caraPrint)) {
            $dataDetail = $model->searchPrintDetailJasaDokter();
        } else {
            $dataDetail = $model->searchDetailJasaDokter();
        ?>
            <legend class="rim">Table Rekap Detail Jasa Dokter</legend>
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
                    'value' => '$row+1'
                ),
                array(
                    'header' => 'Tgl. Transaksi',
                    'type' => 'raw',
                    'value' => 'date("d/m/Y",strtotime($data->tgl_pendaftaran))',
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
                    'header' => 'Instalasi/ <br> Ruangan',
                    'type' => 'raw',
                    'value' => '$data->instalasi_nama."/<br>".$data->ruangan_nama',
                ),
                array(
                    'header' => 'Jumlah',
                    'type' => 'raw',
                    //'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/rekapJasaDokter/_qty",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                    'value' => '$data->qty_tindakan',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ), /*
                        array(
                            'header' => 'Gelar Depan',
                            'type' => 'raw',
                            'value' => '',
                        ), */
                array(
                    'header' => 'Dokter',
                    'type' => 'raw',
                    'value' => '(empty($data->gelardepan) ? "-" : "$data->gelardepan" ).(empty($data->nama_pegawai) ? "-" : "$data->nama_pegawai" ).", ".(empty($data->gelarbelakang_nama) ? "" : ", $data->gelarbelakang_nama" )',
                ), /*
                        array(
                            'header' => 'Gelar Belakang',
                            'type' => 'raw',
                            'value' => '(empty($data->gelarbelakang_nama) ? "" : "$data->gelarbelakang_nama" )',
                        ), */
                array(
                    'header' => 'Visite',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifVisit",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Konsul',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifKonsul",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Tindakan',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifTindakan",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Jasa Operator',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifOperator",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Sewa Alat',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifSewaAlat",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Alat Bahan',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifAlatBahan",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Total',
                    'type' => 'raw',
                    'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifTotal",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                    //'value' => '"Rp ".MyFormatter::formatNumberForPrint($data->tarif_tindakan)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),

            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
<?php } ?>