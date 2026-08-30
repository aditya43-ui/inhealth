<h6>Tabel <b>Setoran Kasir ke Bendahara</b></h6>
<?php 
    
	
	
    
    $rim = '';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $data = $model->searchLaporan();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
    if (isset($caraPrint)){
      $sort = false;
      $data = $model->searchPrintLaporan(); 
      $rim = '';
      $template = "{items}";
      if ($caraPrint == "EXCEL")
          $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
	
	$datatotal = clone $data;
	$pasien = 0;
	$retribusi = 0;
	$medis = 0;
	$paramedis = 0;
	$administrasi = 0;
	$totals = 0;
	
	$datatotal->pagination = false;
	
	foreach ($datatotal->data as $item) {
		$pasien += $item->jml_pasien_l + $item->jml_pasien_p;
		$retribusi += $item->jml_retribusi_pl + $item->jml_retribusi_pb;
		$medis += $item->jml_jasamedis_pl + $item->jml_jasamedis_pb;
		$paramedis += $item->jml_paramedis_pl + $item->jml_paramedis_pb;
		$administrasi += $item->jml_administrasi_pl + $item->jml_administrasi_pb;
		$totals += $item->totsetkasirruangan;
	}
	
	
	$kolom = array(
		array(
			'name'=>'tglsetorankasir',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglsetorankasir)',
			'footer'=>'Total',
			'footerHtmlOptions'=>array(
				'colspan'=>5,
				'style'=>'font-weight: bold;'
			)
		),
		'nosetorankasir',
		'ruangan_nama',
		array(
			'name'=>'nama_pegawai',
			'value'=>'$data->gelardepan.$data->nama_pegawai.", ".$data->gelarbelakang_nama',
		),
		array(
			'name'=>'nama_bendahara',
			'value'=>'$data->gelardepan_bendahara.$data->nama_bendahara.", ".$data->gelarbelakang_bendahara',
		),
		array(
			'header'=>'Jml Pasien',
			'type'=>'raw',
			'value'=>'$data->jml_pasien_l + $data->jml_pasien_p',
			'htmlOptions'=>array('style'=>'text-align: right;'),
			'footer'=>$pasien,
			'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
		),
		array(
			'header'=>'Retribusi',
			'type'=>'raw',
			'value'=>'MyFormatter::formatNumberForPrint($data->jml_retribusi_pl + $data->jml_retribusi_pb)',
			'htmlOptions'=>array('style'=>'text-align: right;'),
			'footer'=>MyFormatter::formatNumberForPrint($retribusi),
			'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
		),
		array(
			'header'=>'Jasa Medis',
			'type'=>'raw',
			'value'=>'MyFormatter::formatNumberForPrint($data->jml_jasamedis_pl + $data->jml_jasamedis_pb)',
			'htmlOptions'=>array('style'=>'text-align: right;'),
			'footer'=>MyFormatter::formatNumberForPrint($medis),
			'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
		),
		array(
			'header'=>'Jasa Paramedis',
			'type'=>'raw',
			'value'=>'MyFormatter::formatNumberForPrint($data->jml_paramedis_pl + $data->jml_paramedis_pb)',
			'htmlOptions'=>array('style'=>'text-align: right;'),
			'footer'=>MyFormatter::formatNumberForPrint($paramedis),
			'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
		),
		array(
			'header'=>'Administrasi',
			'type'=>'raw',
			'value'=>'MyFormatter::formatNumberForPrint($data->jml_administrasi_pl + $data->jml_administrasi_pb)',
			'htmlOptions'=>array('style'=>'text-align: right;'),
			'footer'=>MyFormatter::formatNumberForPrint($administrasi),
			'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
		),
		array(
			'header'=>'Total',
			'type'=>'raw',
			'value'=>'MyFormatter::formatNumberForPrint($data->totsetkasirruangan)',
			'htmlOptions'=>array('style'=>'text-align: right;'),
			'footer'=>  MyFormatter::formatNumberForPrint($totals),
			'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
		),
	); 
?>
    <div style="<?php echo $rim; ?>">
    <?php 
        $this->widget($table,array(
            'id'=>'laporansetorankebank-grid',
            'dataProvider'=>$data,
            'enableSorting'=>$sort,
            'template'=>$template,
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>$kolom,
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); 
        ?>
    </div>
<br> 