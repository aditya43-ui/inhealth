<?php
$rim = 'max-width:1300px;overflow-x:scroll;';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchLaporan();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$itemCss = 'table table-bordered table-striped table-condensed';

if (isset($caraPrint)) {
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
    $sort = false;
    $data = $model->searchPrintLaporan();
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
			'header' => 'Periode',
			'type' => 'raw',
			'value' => 'date("F", strtotime($data->tglbayarjasa))',
		),
        array(
            'header' => 'Dokter',
            'type' => 'raw',
            'value' => function($data) use (&$peg) {
                $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                
                if (empty($peg)) {
                    return "-";
                }
                
                return $peg->namaLengkap;
            }
        ),
        array(
            'header' => 'NPWP',
            'type' => 'raw',
            'value' => function($data) use (&$peg) {
                if (empty($peg)) {
                    return "-";
                }
                
                return $peg->npwp;
            }
        ),
		array(
			'header' => 'Nomor Bukti Potong',
			'type' => 'raw',
			'value' => '$data->no_perhitungan',
		),
            array(
                    'header' => 'Penghasilan Bruto',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->penghasilanbruto)',
                     'htmlOptions'=>array('style' => 'text-align:right;'),
            ),
             array(
                    'header' => 'Dasar Pengenaan Pajak (DPP)',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->pkp)',
                     'htmlOptions'=>array('style' => 'text-align:right;'),
            ),
             array(
                    'header' => 'Tarif (%)',
                    'type' => 'raw',
                    'value' => '$data->getTarifPersen($data->pkpkumulatif)',
                     'htmlOptions'=>array('style' => 'text-align:right;'),
            ),
             array(
                    'header' => 'PKP Kumulatif',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->pkpkumulatif)',
                     'htmlOptions'=>array('style' => 'text-align:right;'),
            ),
		array(
                    'header' => 'Pajak Progressif',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->pajakprogressif)',
                     'htmlOptions'=>array('style' => 'text-align:right;'),
            ),	
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
      