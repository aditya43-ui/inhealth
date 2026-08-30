<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
$data = $model->searchInfoPasienTriage();
if (isset($caraPrint)) {
    $row = '$row+1';
    $visible = false;
    $data->pagination = false;
    
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    $filter = null;
} else {
    
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'informasi-stok-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed', 
    'columns' => array(
        array(
            'header' => 'No',
            'value' => $row,
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        [
            'name' => 'tanggal',
            'value' => '!empty($data->tanggal)?MyFormatter::formatDateTimeForUser($data->tanggal):""'
        ],
        'no_bed_triage',
        'no_triage_pasien',
        
        [            
            'name'=>'nama_pasien',
            'header'=>'Pasien',
            'type'=>'raw',
            'value'=>'$data->nama_pasien."<br/>".$data->no_rekam_medik'
        ],
        [
            'header' => 'Rincian Tagihan Sementara',
            'type' => 'raw',
            'value' => function($data) {
                $htmlLink2 = '<div class="small-container">' . CHtml::link('<i class="icon-form-detail"></i><br>Rincian Tagihan Sementara', Yii::app()->controller->createUrl('/billingKasir/pembayaranTagihanPasien/printRincianBelumBayarRD', array(
                    "instalasi_id" => $data->instalasi_id, "pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id, "frame" => true)),
                     array('target' => 'iframeRincianTagihanSementara',  "rel" => "tooltip", "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",
                    'onclick' => "$('#dialogRincianTagihanSementara').dialog('open');",
                )) . '</div>';

                echo $htmlLink2;
            }
        ],
        [            
            'name'=>' pengambilanobat_triage_id',
            'header'=>'Pengambilan Obat',
            'type'=>'raw',
            'value'=>function ($data)  { 
                 return CHtml::Link(
                "<i class='icon-form-jualresep'></i>Pengambilan Obat",
                Yii::app()->controller->createUrl("InformasiPasienTriage/PengambilanObat", array("pendaftaran_id" => $data->pendaftaran_id,"notriage_pasien_id" => $data->notriage_pasien_id)),
                array(
                    "class" => "",
                    // "target"=>"iframePenjualanResep",
                    "rel" => "tooltip",
                    "title" => "Klik untuk mengambil obat",
                    // "onclick"=>'$("#dialogPenjualanResep").dialog("open");',
                ));
            }
        ],
        [
            'name'=>'statusperiksa',
            'type'=>'raw',
            'value'=>'Params::getWrStatusPeriksa($data->statusperiksa);'
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});            
    }',
));
?>