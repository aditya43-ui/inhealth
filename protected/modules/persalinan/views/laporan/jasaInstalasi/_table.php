<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrint();
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
<?php
if (isset($caraPrint) && $caraPrint == "EXCEL") {
    $this->widget($table, array(
        'id' => 'tableLaporan',
        'dataProvider' => $data,
        'template' => $template,
        'enableSorting' => $sort,
        'mergeHeaders' => array(
            array(
                'name' => '<p style="margin: 0; text-align: center;">Tindakan</p>',
                'start' => 8, //indeks kolom 3
                'end' => 13, //indeks kolom 4
            ),
            array(
                'name' => '<p style="margin: 0; text-align: center;">Karcis</p>',
                'start' => 14, //indeks kolom 3
                'end' => 18, //indeks kolom 4
            ),
        ),
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => $row,
            ),
            array(
                'header' => 'No. Pendaftaran',
                'value' => '$data->no_pendaftaran',
            ),
            array(
                'header' => 'No. Rekam Medik',
                'value' => '$data->no_rekam_medik',
            ),
            array(
                'header' => 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien'
            ),
            array(
                'header' => 'Dokter',
                'value' => function ($data) {
                    $pegawai_id = TindakanpelayananT::model()->findByPk($data->tindakanpelayanan_id)->dokterpemeriksa1_id;

                    $nama = PegawaiM::model()->findByPk($pegawai_id);

                    if (!empty($nama)) {
                        return $nama->namaLengkap;
                    } else {
                        return '-';
                    }
                }
            ),
            array(
                'header' => 'Kelas Pelayanan',
                'value' => '$data->kelaspelayanan_nama'
            ),
            array(
                'header' => 'Jenis Penjamin Penjamin',
                'name' => 'carabayarPenjamin',
            ),
            array(
                'header' => 'Daftar Uraian Tindakan',
                'name' => 'daftartindakan_nama',
                'value' => '($data->daftartindakan_karcis == false) ? $data->daftartindakan_nama : \'\'',
            ),
            array(
                'name' => 'qty_tindakan',
                'value' => '($data->daftartindakan_karcis == false) ? $data->qty_tindakan : \'\'',
            ),
            array(
                'header' => 'Tarif RS Akomodasi (Rp)',
                'name' => 'tarif_rsakomodasi',
                'value' => '($data->daftartindakan_karcis == false) ? number_format($data->tarif_rsakomodasi,0,"",".") : \'\'',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Tarif Medis (Rp)',
                'name' => 'tarif_medis',
                'value' => '($data->daftartindakan_karcis == false) ? number_format($data->tarif_medis,0,"",".") : \'\'',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Tarif Paramedis (Rp)',
                'name' => 'tarif_paramedis',
                'value' => '($data->daftartindakan_karcis == false) ? number_format($data->tarif_paramedis,0,"",".") : \'\'',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Tarif BHP (Rp)',
                'name' => 'tarif_bhp',
                'value' => '($data->daftartindakan_karcis == false) ? number_format($data->tarif_bhp,0,"",".") : \'\'',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Sub Total (Rp)',
                'name' => 'subtotal',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                'value' => '($data->daftartindakan_karcis == false) ? number_format(($data->tarif_rsakomodasi+$data->tarif_medis+$data->tarif_paramedis+$data->tarif_bhp),0,"",".") : \'\'',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'name' => 'karcisnama',
                'value' => '($data->daftartindakan_karcis == false) ? \'\' : $data->daftartindakan_nama',
            ),
            array(
                'name' => 'karcisqty',
                'value' => '($data->daftartindakan_karcis == false) ? \'\' : $data->qty_tindakan',
            ),
            array(
                'name' => 'karcisrs',
                'value' => '($data->daftartindakan_karcis == false) ? \'\' : number_format($data->tarif_rsakomodasi,0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'name' => 'karcismedis',
                'value' => '($data->daftartindakan_karcis == false) ? \'\' : number_format($data->tarif_medis,0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),

            array(
                'name' => 'subtotal',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                'value' => '($data->daftartindakan_karcis == false) ? \'\' : number_format($data->qty_tindakan*($data->tarif_rsakomodasi+$data->tarif_medis),0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
} else {
    $this->widget($table, array(
        'id' => 'tableLaporan',
        'dataProvider' => $data,
        'template' => $template,
        'enableSorting' => $sort,
        'mergeHeaders' => array(
            array(
                'name' => '<p style="margin: 0; text-align: center;">Tindakan</p>',
                'start' => 8, //indeks kolom 3
                'end' => 13, //indeks kolom 4
            ),
            array(
                'name' => '<p style="margin: 0; text-align: center;">Karcis</p>',
                'start' => 14, //indeks kolom 3
                'end' => 18, //indeks kolom 4
            ),
        ),
        'itemsCssClass' => $itemCssClass,
        'columns' => array(
            array(
                'header' => 'No.',
                'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                'value' => $row,
            ),
            array(
                'header' => 'No. Pendaftaran',
                'value' => '$data->no_pendaftaran',
            ),
            array(
                'header' => 'No. Rekam Medik',
                'value' => '$data->no_rekam_medik',
            ),
            array(
                'header' => 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien'
            ),
            array(
                'header' => 'Dokter',
                'value' => function ($data) {
                    $pegawai_id = TindakanpelayananT::model()->findByPk($data->tindakanpelayanan_id)->dokterpemeriksa1_id;

                    $nama = PegawaiM::model()->findByPk($pegawai_id);

                    if (!empty($nama)) {
                        return $nama->namaLengkap;
                    } else {
                        return '-';
                    }
                }
            ),
            array(
                'header' => 'Kelas Pelayanan',
                'value' => '$data->kelaspelayanan_nama'
            ),
            array(
                'header' => 'Jenis Penjamin Penjamin',
                'name' => 'carabayarPenjamin',
            ),
            array(
                'header' => 'Daftar Uraian Tindakan',
                'name' => 'daftartindakan_nama',
                'value' => '($data->daftartindakan_karcis == false) ? $data->daftartindakan_nama : \'\'',
            ),
            array(
                'name' => 'qty_tindakan',
                'value' => '($data->daftartindakan_karcis == false) ? $data->qty_tindakan : \'\'',
            ),
            array(
                'name' => 'tarif_rsakomodasi',
                'value' => '($data->daftartindakan_karcis == false) ? number_format($data->tarif_rsakomodasi,0,"",".") : \'\'',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'name' => 'tarif_medis',
                'value' => '($data->daftartindakan_karcis == false) ? number_format($data->tarif_medis,0,"",".") : \'\'',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'name' => 'tarif_paramedis',
                'value' => '($data->daftartindakan_karcis == false) ? number_format($data->tarif_paramedis,0,"",".") : \'\'',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'name' => 'tarif_bhp',
                'value' => '($data->daftartindakan_karcis == false) ? number_format($data->tarif_bhp,0,"",".") : \'\'',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'name' => 'subtotal',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                'value' => '($data->daftartindakan_karcis == false) ? number_format(($data->tarif_rsakomodasi+$data->tarif_medis+$data->tarif_paramedis+$data->tarif_bhp),0,"",".") : \'\'',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'name' => 'karcisnama',
                'value' => '($data->daftartindakan_karcis == false) ? \'\' : $data->daftartindakan_nama',
            ),
            array(
                'name' => 'karcisqty',
                'value' => '($data->daftartindakan_karcis == false) ? \'\' : $data->qty_tindakan',
            ),
            array(
                'name' => 'karcisrs',
                'value' => '($data->daftartindakan_karcis == false) ? \'\' : number_format($data->tarif_rsakomodasi,0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'name' => 'karcismedis',
                'value' => '($data->daftartindakan_karcis == false) ? \'\' : number_format($data->tarif_medis,0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),

            array(
                'name' => 'subtotal',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                'value' => '($data->daftartindakan_karcis == false) ? \'\' : number_format($data->qty_tindakan*($data->tarif_rsakomodasi+$data->tarif_medis),0,"",".")',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
        ),

        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
}
?>