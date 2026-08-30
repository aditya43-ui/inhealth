<?php
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$dataProvider = $model->printTableRekap();
$template = "{items}";
$sort = false;

if ($caraPrint == "EXCEL") {
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $data['judulLaporan'] . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}

echo $this->renderPartial(
    'application.views.headerReport.headerLaporan',
    array(
        'judulLaporan' => $data['judulLaporan'],
        'periode' => $data['periode']
    )
);
?>
<?php
if (isset($caraPrint) && $caraPrint == "EXCEL") {
    $this->widget(
        $table,
        array(
            'id' => 'tableLaporanKelompok',
            'dataProvider' => $dataProvider,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'mergeColumns' => array('penjamin_nama', 'no_rekam_medik'),
            'columns' => array(
                array(
                    'header' => 'Tanggal Transaksi',
                    'type' => 'raw',
                    'value' => 'isset($data->tglpelayanan)?$data->tglpelayanan:" - "',
                ),
                array(
                    'header' => 'Penjamin P3',
                    'type' => 'raw',
                    'name' => 'penjamin_nama',
                    'value' => 'isset($data->penjamin->penjamin_nama)?$data->penjamin->penjamin_nama:" - "',
                ),
                array(
                    'header' => 'No. RM',
                    'type' => 'raw',
                    'name' => 'no_rekam_medik',
                    'value' => 'isset($data->pasien->no_rekam_medik)?$data->pasien->no_rekam_medik:" - "',
                ),
                array(
                    'header' => 'No. Pendaftaran',
                    'type' => 'raw',
                    'value' => 'isset($data->pendaftaran->no_pendaftaran)?$data->pendaftaran->no_pendaftaran:" - "',
                ),
                array(
                    'header' => 'Nama Pasien',
                    'type' => 'raw',
                    'value' => 'isset($data->pasien->nama_pasien)?$data->pasien->nama_pasien:" - "',
                ),
                array(
                    'header' => 'Jenis Kelamin',
                    'type' => 'raw',
                    'value' => 'isset($data->pasien->jeniskelamin)?$data->pasien->jeniskelamin:" - "',
                ),
                array(
                    'header' => 'Usia',
                    'type' => 'raw',
                    'value' => 'isset($data->pendaftaran->umur)?$data->pendaftaran->umur:" - "',
                ),
                array(
                    'header' => 'Golongan',
                    'type' => 'raw',
                    'value' => 'isset($data->obatalkes->obatalkes_golongan)?$data->obatalkes->obatalkes_golongan:" - "',
                ),
                array(
                    'header' => 'Kategori',
                    'type' => 'raw',
                    'value' => 'isset($data->obatalkes->obatalkes_kategori)?$data->obatalkes->obatalkes_kategori:" - "',
                ),
                array(
                    'header' => 'Kelompok',
                    'type' => 'raw',
                    'value' => '($data->oa == "OA" ? "Alkes" : "Obat")',
                ),
                array(
                    'header' => 'Status Barang',
                    'type' => 'raw',
                    'value' => '$data->getAsalBarang()',
                ),
                array(
                    'header' => 'Jenis',
                    'type' => 'raw',
                    'value' => '$data->getJenisObat()',
                ),
                array(
                    'header' => 'Apotek (Rp)',
                    'type' => 'raw',
                    'value' => '($data->hargasatuan_oa)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Pasien (Rp)',
                    'type' => 'raw',
                    'value' => '($data->hargasatuan_oa)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Tanggungan P3 (Rp)',
                    'type' => 'raw',
                    'value' => '($data->subsidiasuransi)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
    );
} else {
    $this->widget(
        $table,
        array(
            'id' => 'tableLaporanKelompok',
            'dataProvider' => $dataProvider,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'mergeColumns' => array('penjamin_nama', 'no_rekam_medik'),
            'columns' => array(
                array(
                    'header' => 'Tanggal Transaksi',
                    'type' => 'raw',
                    'value' => 'isset($data->tglpelayanan)?$data->tglpelayanan:" - "',
                ),
                array(
                    'header' => 'Penjamin P3',
                    'type' => 'raw',
                    'name' => 'penjamin_nama',
                    'value' => 'isset($data->penjamin->penjamin_nama)?$data->penjamin->penjamin_nama:" - "',
                ),
                array(
                    'header' => 'No. RM',
                    'type' => 'raw',
                    'name' => 'no_rekam_medik',
                    'value' => 'isset($data->pasien->no_rekam_medik)?$data->pasien->no_rekam_medik:" - "',
                ),
                array(
                    'header' => 'No. Pendaftaran',
                    'type' => 'raw',
                    'value' => 'isset($data->pendaftaran->no_pendaftaran)?$data->pendaftaran->no_pendaftaran:" - "',
                ),
                array(
                    'header' => 'Nama Pasien',
                    'type' => 'raw',
                    'value' => 'isset($data->pasien->nama_pasien)?$data->pasien->nama_pasien:" - "',
                ),
                array(
                    'header' => 'Jenis Kelamin',
                    'type' => 'raw',
                    'value' => 'isset($data->pasien->jeniskelamin)?$data->pasien->jeniskelamin:" - "',
                ),
                array(
                    'header' => 'Usia',
                    'type' => 'raw',
                    'value' => 'isset($data->pendaftaran->umur)?$data->pendaftaran->umur:" - "',
                ),
                array(
                    'header' => 'Golongan',
                    'type' => 'raw',
                    'value' => 'isset($data->obatalkes->obatalkes_golongan)?$data->obatalkes->obatalkes_golongan:" - "',
                ),
                array(
                    'header' => 'Kategori',
                    'type' => 'raw',
                    'value' => 'isset($data->obatalkes->obatalkes_kategori)?$data->obatalkes->obatalkes_kategori:" - "',
                ),
                array(
                    'header' => 'Kelompok',
                    'type' => 'raw',
                    'value' => '($data->oa == "OA" ? "Alkes" : "Obat")',
                ),
                array(
                    'header' => 'Status Barang',
                    'type' => 'raw',
                    'value' => '$data->getAsalBarang()',
                ),
                array(
                    'header' => 'Jenis',
                    'type' => 'raw',
                    'value' => '$data->getJenisObat()',
                ),
                array(
                    'header' => 'Apotek (Rp)',
                    'type' => 'raw',
                    'value' => 'number_format($data->hargasatuan_oa,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Pasien (Rp)',
                    'type' => 'raw',
                    'value' => 'number_format($data->hargasatuan_oa,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Tanggungan P3 (Rp)',
                    'type' => 'raw',
                    'value' => 'number_format($data->subsidiasuransi,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
    );
}
?>