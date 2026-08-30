<?php

/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php
$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$mergeColumns = array('obatalkes_nama');
$data = $model->searchTabelServices();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)) {
    $sort = false;
    $data = $model->searchPrintServices();
    $template = "{items}";
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
}
?>
<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    //    'mergeColumns'=>$mergeColumns,
    'dataProvider' => $data,
    'enableSorting' => $sort,
    'template' => $template,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(

        array(
            'header' => 'No.',
            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
        ),
        array(
            'header' => 'Tanggal Pendaftaran <br> / No. Pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s",strtotime($data->tgl_pendaftaran)))." <br> / ".$data->no_pendaftaran',
        ),
        array(
            'header' => 'No. Rekam Medik',
            'type' => 'raw',
            'value' => 'isset($data->no_rekam_medik) ? $data->no_rekam_medik:"-"',
        ),
        array(
            'header' => 'Jenis Kelamin',
            'type' => 'raw',
            'value' => 'isset($data->jeniskelamin) ? $data->jeniskelamin:"-"',
        ),
        array(
            'header' => 'Nama Pasien',
            'type' => 'raw',
            'value' => '$data->namadepan." ".$data->nama_pasien', //$data->getNamaBin($data->pegawai_id)
        ),
        array(
            'header' => 'Instalasi <br> / Ruangan Asal',
            'type' => 'raw',
            'value' => '$data->instalasiasal_nama." <br> / ".$data->ruanganasal_nama',
        ),
        array(
            'header' => 'Tanggal Resep <br> / No. Resep',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s",strtotime($data->tglresep)))."/<br>".$data->noresep',
        ),
        array(
            'header' => 'Nama Dokter',
            'type' => 'raw',
            'value' => 'isset($data->nama_pegawai) ? $data->gelardepan." ".$data->nama_pegawai." ".$data->getGelarBelakang($data->pegawai_id):"-"',
        ),
        array(
            'header' => 'Tanggal Penjualan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s",strtotime($data->tglpenjualan)))',
        ),
        array(
            'header' => 'Biaya Administrasi (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->biayaadministrasi,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Biaya Konseling (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->biayakonseling,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Total Tarif Service (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->totaltarifservice,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>