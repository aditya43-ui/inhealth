<?php
$rim = 'max-width:1300px;overflow-x:scroll;';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchRekapJasaDokter();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$itemCss = 'table table-bordered table-striped table-condensed';

if (isset($caraPrint)) {
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
    $sort = false;
    $data = $model->searchRekapPrintJasaDokter();
    $rim = '';
    $template = "{items}";
    if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
	
	$itemCss = 'table border';
}
?>

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
			'header' => 'Dokter',
			'type' => 'raw',
			'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
		),
		array(
			'header' => 'Komponen Tarif',
			'type' => 'raw',
			'value' => '$data->komponentarif_nama',
			'footer' => '<b>Total</b>',				
				'footerHtmlOptions'  => array('style' => 'text-align:right;','colspan'=>3),
		),
		array(
			'header' => 'Jasa Pelayanan',
			'type' => 'raw',
			'name'=>'totaljasa_komponen',
			'value' => 'MyFormatter::formatNumberForPrint($data->totaljasa_komponen)',
			'htmlOptions'=>array('style' => 'text-align:right;'),
			'footer'=>'sum(totaljasa_komponen)',
			'footerHtmlOptions'=>array('style' => 'text-align:right;')
		),		
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
      