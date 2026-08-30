<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
$data = $model->searchInformasi();
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
    'id' => 'informasi-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed', 
    'replaceUrl' => true,
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
            'value' => $row
        ),
       array(
                'header'=>'Tanggal Pendaftaran  <br> / No. Pendaftaran',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)." <br> /  ".$data->no_pendaftaran',
            ),
        array(
                'header'=>'Tanggal Meninggal',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_meninggal)',
            ),
        array(
                'header'=>'Nama Pasien',
                'type'=>'raw',
                'value'=>'$data->nama_pasien',
            ),
        array( 
                'header'=>'Alamat',
                'type'=>'raw',
                'value'=>'$data->alamat_pasien',
            ),
        array(
                'header'=>'Umur ',
                'type'=>'raw',
                'value'=>'$data->umur',
            ),
        array(
                'header'=>'Golongan Umur ',
                'type'=>'raw',
                'value'=>'$data->golonganumur_nama',
            ),
         'kondisipulang',
        array(
                'header'=>'Jenis Penjamin /<br>Penjamin ',
                'type'=>'raw',
                'value'=>'$data->carabayar_nama."/<br/>".$data->penjamin_nama',
            ),
        'caramasuk_nama',   
        [
            'header' => 'Pembuatan Surat Keterangan',
            'type' => 'raw',
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'value' => function($data){
                return CHtml::link("<span class='fa fa-file-o' style='font-size:20px;'></i>",'javascript:;',['onclick'=>'setSuratkematian('.$data->pendaftaran_id.')','title'=>'menambahkan surat kematian']);
            }
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});            
    }',
));
?>
