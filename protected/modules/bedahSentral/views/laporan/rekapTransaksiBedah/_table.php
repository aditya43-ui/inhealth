<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$style = '';
if (isset($caraPrint)) {
    $style = '';
    $sort = false;
    $data = $model->searchPrintOpt();
    $template = "{items}";
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>

<div id="div_global">
    <div style="<?php echo $style; ?>">
        <?php
        $this->widget($table, array(
            'id' => 'laporanrekaptransaksi-grid',
            'dataProvider' => $data,
            'enableSorting' => $sort,
            'template' => $template,
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'type' => 'raw',
                    'value' => '$data->no_rekam_medik',
                ),
                array(
                    'header' => 'Tanggal Pendaftaran',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                ),
                array(
                    'header' => 'No. Pendaftaran',
                    'type' => 'raw',
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header' => 'Nama Pasien',
                    'type' => 'raw',
                    'value' => '$data->nama_pasien',
                ),
                array(
                    'header' => 'Tindakan',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"tindakan"))',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Visit',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"visit"))',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Konsul',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"konsul"))',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Farmasi',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"farmasi"))',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ), /*
					array(
					   'header'=>'LAB',
					   'type'=>'raw',
					   'value'=>'MyFormatter::formatNumberForPrint($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"lab"))',
						'htmlOptions'=>array('style'=>'text-align:right;'),
					),
					array(
					   'header'=>'RAD',
					   'type'=>'raw',
					   'value'=>'MyFormatter::formatNumberForPrint($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"rad"))',
						'htmlOptions'=>array('style'=>'text-align:right;'),
					),
                     * 
                     */
                array(
                    'header' => 'Bedah',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"bedah"))',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Ruangan',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"ruangan"))',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ), /*
					array(
					   'header'=>'Obsgyn',
					   'type'=>'raw',
					   'value'=>'MyFormatter::formatNumberForPrint($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"obsgyn"))',
						'htmlOptions'=>array('style'=>'text-align:right;'),
					),
					array(
					   'header'=>'Gizi',
					   'type'=>'raw',
					   'value'=>'MyFormatter::formatNumberForPrint($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"gizi"))',
						'htmlOptions'=>array('style'=>'text-align:right;'),
					),
					array(
					   'header'=>'Lainnya',
					   'type'=>'raw',
					   'value'=>'MyFormatter::formatNumberForPrint($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"lainnya"))',
						'htmlOptions'=>array('style'=>'text-align:right;'),
					),
                     * 
                     */
                array(
                    'header' => 'Total',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->getTotalTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"total"))',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>