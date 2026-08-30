<?php
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$itemCssClass = 'table table-bordered datatable';
if (isset($caraPrint)) {
    $data = $model->searchUnitPelayananPrint();
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
    $data = $model->searchUnitPelayanan();
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
        //        'mergeColumns'=>array('ruangan_nama'),
        'itemsCssClass' => $itemCssClass,
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '$row+1',
                'htmlOptions' => array('style' => 'width:30px;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Nama Ruangan',
                //  'name'=>'ruangan_nama',
                'value' => '$data->ruangan_nama',
                'htmlOptions' => array('style' => 'text-align:left;'),
                'type' => 'raw',
            ),

            array(
                'header' => 'Kunjungan Baru',
                //'value'=>'$data->getKunjungan("PENGUNJUNG BARU",$data->ruangan_id)',
                'value' => 'number_format($data->jumlahkunjunganbaru,0,"",".")',
                'htmlOptions' => array('style' => 'width:30px;text-align:right;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Kunjungan Lama',
                //'value'=>'$data->getKunjungan("PENGUNJUNG LAMA",$data->ruangan_id)',
                'value' => 'number_format($data->jumlahkunjunganlama,0,"",".")',
                'htmlOptions' => array('style' => 'width:30px;text-align:right;'),
                'type' => 'raw',
            ),
            array(
                'header' => 'Jumlah',
                //          'value'=>'$data->getJmlKunjungan($data->ruangan_id)',
                //          'value'=>'number_format($data->jumlahkunjunganbaru)',
                'value' => 'number_format($data->jumlahkunjungan,0,"",".")',
                'htmlOptions' => array('style' => 'width:30px;text-align:right;'),
                'type' => 'raw',
            ),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>
    <?php if (isset($caraPrint)) { ?>

    <?php } else { ?>
    </div>
<?php } ?>