<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$itemCssClass = 'table table-bordered datatable';
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = '{items}';
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
    $itemCssClass = 'table border';
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
        'itemsCssClass' => $itemCssClass,
        'columns' => array(
            array(
                'header' => 'Golongan Umur',
                'type' => 'raw',
                'value' => '$data->golonganumur_nama',
            ),
            array(
                'header' => 'Umur',
                'type' => 'raw',
                'value' => '$data->umur',
            ),
            array(
                'header' => 'Nama Pasien / Alias',
                'type' => 'raw',
                'value' => '$data->NamaNamaBIN',
            ),

            array(
                'header' => 'No. Rekam Medik',
                'type' => 'raw',
                'value' => '$data->no_rekam_medik',
            ),

            array(
                'header' => 'No. Pendaftaran',
                'type' => 'raw',
                'value' => '$data->no_pendaftaran',
            ),
            array(
                'header' => 'Tanggal Masuk',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgladmisi)',
            ),
            array(
                'header' => 'Tanggal Keluar',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpulang)',
            ),
            array(
                'header' => 'Instalasi/<br>Ruangan',
                'type' => 'raw',
                'value' => '$data->instalasi_nama."/<br>".$data->ruangan_nama'
            ),
            //            
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>
    <?php if (isset($caraPrint)) { ?>

    <?php } else { ?>
    </div>
<?php } ?>