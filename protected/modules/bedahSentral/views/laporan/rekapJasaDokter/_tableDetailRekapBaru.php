<?php
$rim = 'max-width:1300px;overflow-x:scroll;';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchDetailRekapJasaDokter();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$itemCss = 'table table-bordered table-striped table-condensed';

if (isset($caraPrint)) {
//	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
    $sort = false;
    $data = $model->searchDetailRekapPrintJasaDokter();
    $rim = '';
    $template = "{items}";
    if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
            if ($caraPrint == "PDF"){
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
                $itemCss = 'table border';
            }
	
}

$prov = $model->searchDetailRekapPrintJasaDokter();

$total_tarifkomp = 0;
foreach ($prov->data as $item) {
    $total_tarifkomp += $item->total_tarifkomp;
}
	$this->widget($table, array(
		'id' => 'laporandetailjasadokter-grid',
		'dataProvider' => $data,
		'enableSorting' => $sort,
		'template' => $template,
		'itemsCssClass' => $itemCss,
		'mergeHeaders' => array(			
			array(
				'name' => '<p style="margin: 0; text-align: center;">Jasa Pelayanan</p>',
				'start' => 8, //indeks kolom 3
				'end' => 14, //indeks kolom 4
			),
		),
		'columns' => array(
			array(
				'header' => 'No.',
				'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1'
			),
            array(
				'header' => 'Tgl. Pembayaran/<br> No. Pembayaran',
				'type' => 'raw',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembayaran)."/<br> ".$data->nopembayaran'
			),
			array(
				'header' => 'Tgl. Pendaftaran/<br> No. Pendaftaran',
				'type' => 'raw',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br> ".$data->no_pendaftaran'
			),
			array(
				'header' => 'No. Rekam Medik',
				'value' => '$data->no_rekam_medik'
			),        
			array(
				'header'=>'Nama Pasien',
				'value' => '$data->nama_pasien'
			),
			array(
				'header' => 'Kelas Pelayanan',
				'value' => '$data->kelaspelayanan_nama'
			),
			array(
				'header' => 'Jenis Penjamin/<br>Penjamin',
				'type' => 'raw',
				'value' => '$data->carabayar_nama."/<br> ".$data->penjamin_nama'
			),
			array(
				'header' => 'Dokter',
				'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama'
			),
			array(
				'header' => 'Komponen Tarif',
				'value' => '$data->komponentarif_nama'
			),
			array(
				'header' => 'Uraian Tindakan',
				'value' => '$data->daftartindakan_nama'
			),			
			array(
				'header' => 'Visite',
				'value' => function($data){
					if ($data->daftartindakan_visite == true){
						return MyFormatter::formatNumberForPrint($data->total_tarifkomp/$data->total_qty);
					}else{
						return 0;
					}
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
			),
			array(
				'header' => 'Konsul',
				'value' => function($data){
					if ($data->daftartindakan_konsul == true){
						return MyFormatter::formatNumberForPrint($data->total_tarifkomp/$data->total_qty);
					}else{
						return 0;
					}
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
			),
			array(
				'header' => 'Tindakan',
				'value' => function($data){
					if ($data->daftartindakan_tindakan == true){
						return MyFormatter::formatNumberForPrint($data->total_tarifkomp/$data->total_qty);
					}else{
						return 0;
					}
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
			),
			array(
				'header' => 'Pemeriksaan',
				'value' => function($data){
					if ($data->daftartindakan_periksa == true){
						return MyFormatter::formatNumberForPrint($data->total_tarifkomp/$data->total_qty);
					}else{
						return 0;
					}
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
			),
			array(
				'header' => 'Jumlah',
				'value' => function($data){					
					return MyFormatter::formatNumberForPrint($data->total_qty);					
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
				'footer' => '<b>Total</b>',				
				'footerHtmlOptions'  => array('style' => 'text-align:right;','colspan'=>15),
			),
			array(
				'header' => 'Total',
				'value' => function($data){					
					return MyFormatter::formatNumberForPrint($data->total_tarifkomp);					
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
				'footer' => MyFormatter::formatNumberForPrint($total_tarifkomp),
				'name'=>'total_tarifkomp',
				'footerHtmlOptions'  => array('style' => 'text-align:right;'),
			),   
		),
		'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
	));
?>
      