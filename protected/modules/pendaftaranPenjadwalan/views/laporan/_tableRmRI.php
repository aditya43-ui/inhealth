<?php
$table = 'ext.bootstrap.widgets.BootGridView';
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = '{items}';
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
} else {
    $data = $model->searchTableLaporan();
    $template = "{summary}{items}{pager}";
}
?>
<?php if (isset($caraPrint)) { ?>

<?php } else { ?>
    <div style='width:100%;'>
    <?php } ?>
    <?php $this->widget($table, array(
        'id' => 'PPInfoKunjungan-v',
        'dataProvider' => $data,
        'template' => $template,
        'itemsCssClass' => 'table table-bordered datatable',
        'columns' => array(
            array(
                'header' => 'Rekam Medik',
                'type' => 'raw',
                'value' => '$data->no_rekam_medik',
            ),
            array(
                'header' => 'Nama Pasien / Alias',
                'type' => 'raw',
                'value' => '$data->NamaNamaBIN',
            ),

            array(
                'header' => 'No. Pendaftaran',
                'type' => 'raw',
                'value' => '$data->no_pendaftaran',
            ),
            array(
                'header' => 'Tgl. Masuk',
                'type' => 'raw',
                'value' => '$data->tgladmisi',
            ),
            array(
                'header' => 'Tgl. Keluar',
                'type' => 'raw',
                'value' => '$data->tglpulang',
            ),
            //            
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>
    <?php if (isset($caraPrint)) { ?>

    <?php } else { ?>
    </div>
<?php } ?>