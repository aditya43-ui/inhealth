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
                'value' => '$data->tgl_pendaftaran',
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
                'header' => 'Tindakan<br>(Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"tindakan"))',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Visit<br>(Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"visit"))',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Konsul<br>(Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"konsul"))',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Farmasi<br>(Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"farmasi"))',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'LAB<br>(Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"lab"))',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'RAD<br>(Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"rad"))',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Bedah<br>(Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"bedah"))',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Ruangan<br>(Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"ruangan"))',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Obsgyn<br>(Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"obsgyn"))',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Gizi<br>(Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"gizi"))',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Lainnya<br>(Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->getTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"lainnya"))',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            array(
                'header' => 'Total<br>(Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->getTotalTagihanOpt($data->pendaftaran_id,$data->tgl_pendaftaran,"total"))',
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    ?>
</div>