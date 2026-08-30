<?php
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$itemCssClass = 'table table-striped table-condensed';
$sort = true;
$isprint = false;
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    $isprint = true;
    if ($caraPrint == "EXCEL") {
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
    $data = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    //    'filter'=>$model,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'mergeColumns' => array('instalasi_nama', 'ruangan_nama', 'dokter_nama'),
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => $isprint ? '$row' : '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'type' => 'raw',
        ),
        array(
            'header' => 'Dokter',
            'type' => 'raw',
            'name' => 'dokter_nama',
            'value' => function ($data) {
                $p = PegawaiM::model()->findByAttributes(array('nama_pegawai' => $data->dokter_nama));
                return $p->namaLengkap;
            }
        ),
        array(
            'header' => 'Status',
            'value' => '$data->statusdokter',
            'type' => 'raw',
        ),

        array(
            'header' => 'No. Rekam Medik',
            'value' => '$data->no_rekam_medik',
            'type' => 'raw',
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => function ($data) {
                $pasien = PendaftaranT::model()->find(" no_pendaftaran = '" . $data->no_pendaftaran . "' ");

                echo $pasien->pasien->namadepan . ' ' . $pasien->pasien->nama_pasien;
            },
            'type' => 'raw',
        ),
        array(
            'header' => 'Tgl. Tindakan',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_tindakan)',
            'type' => 'raw',
        ),

        array(
            'header' => 'Instalasi/<br>Ruangan',
            'value' => '$data->instalasi_nama."/<br>".$data->ruangan_nama',
            'type' => 'raw',
        ),
        array(
            'header' => 'Jenis Pelayanan',
            'value' => '$data->daftartindakan_nama',
            'type' => 'raw',
        ),
        array(
            'header' => 'Tarif (Rp)',
            'value' => 'number_format($data->tarif_tindakan,0,"",".")',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        //          array(
        //            'header'=>'Harga',
        //            'name'=>'tarif_satuan',
        //            'type'=>'raw',
        //            'value'=>'MyFunction::formatNumber($data->tarif_satuan)',
        //            'htmlOptions'=>array('style'=>'text-align:right'),
        //            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
        //            'footer'=>'sum(tarif_satuan)',
        //        ),

        array(
            'header' => 'Penjamin',
            'value' => '$data->penjamin_nama',
            'type' => 'raw',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?> 
