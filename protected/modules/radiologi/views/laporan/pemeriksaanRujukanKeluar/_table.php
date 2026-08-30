<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridViewRp';
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
        $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
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
    'itemsCssClass' => $itemCssClass,
    //'mergeColumns'=>array('nama_pasien','nama_pegawai','tgl_tindakan'),
    'mergeHeaders' => array(
        array(
            'name' => '<p style="margin: 0; text-align: center;">Jenis Pemeriksaan</p>',
            'start' => '5',
            'end' => '7',
        ),
        array(
            'name' => '<p style="margin: 0; text-align: center;">Rujukan Keluar</p>',
            'start' => '8',
            'end' => '9',
        ),
    ),
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => $row,
        ),
        array(
            'header' => 'Tanggal Rujukan Keluar',
            'type' => 'raw',
            'name' => 'pemeriksaankeluar_tgl',
            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->pemeriksaankeluar_tgl)))',
        ),
        array(
            'header' => 'No. Rekam Medik',
            'type' => 'raw',
            'name' => 'no_rekam_medik',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'header' => 'Nama Pasien',
            'type' => 'raw',
            'name' => 'nama_pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien',
        ),
        array(
            'header' => 'Dokter Pengirim',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'USG',
            'value' => function ($data) {
                if ($data->jenispemeriksaanrad_nama == Params::JENISPEMERIKSAANRAD_USG) {
                    return 'v';
                } else {
                    return '';
                }
            }
        ),
        array(
            'header' => 'FOTO X-RAY',
            'value' => function ($data) {
                if ($data->jenispemeriksaanrad_nama == Params::JENISPEMERIKSAANRAD_FOTOXRAY) {
                    return 'v';
                } else {
                    return '';
                }
            }
        ),
        array(
            'header' => 'Lain-Lain',
            'value' => function ($data) {
                if ($data->jenispemeriksaanrad_nama != Params::JENISPEMERIKSAANRAD_USG && $data->jenispemeriksaanrad_nama != Params::JENISPEMERIKSAANRAD_FOTOXRAY) {
                    return 'v';
                } else {
                    return '';
                }
            }
        ),
        array(
            'header' => 'Pemeriksaan',
            'value' => '$data->daftartindakan_nama'
        ),
        array(
            'header' => 'Jumlah PX',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'value' => '$data->qty_tindakan."px"'
        ),
        /*array(
				'header' => 'Harga (Rp)',
				'htmlOptions' => array('style' => 'text-align: right;'),
				//'value' => 'number_format($data->tarif_satuan,0,"",".")'
				'value' => 'number_format($data->tarif_tindakankomp,0,"",".")',
				'footer' => '<b>Total</b>',
				'footerHtmlOptions' => array('colspan' => 10,'style'=>'text-align:right;')
			),
			array(
				'header' => 'Sub Total (Rp)',
				'htmlOptions' => array('style' => 'text-align: right;'),
				//'value' => 'number_format($data->tarif_satuan,0,"",".")'
				'name' => 'subtotal',
				'value' => 'number_format($data->subtotal,0,"",".")',
				'footer' => 'sum(subtotal)',
				'footerHtmlOptions' => array('style'=>'text-align:right;')
			),*/
        array(
            'header' => 'Tujuan Rujukan',
            'value' => '$data->labklinikrujukan_nama',
            //'footer' => ' '
        ),
        array(
            'header' => 'Jenis PX',
            'value' => '$data->penjamin_nama."/".substr($data->no_pendaftaran,0,2)',
            //'footer' => ' '
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>