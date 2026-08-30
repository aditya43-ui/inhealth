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
    'id' => 'sajenis-kelas-m-grid',
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
            'header' => 'Jenis Peralatan',
            'name' => 'invperalatan_namabrg'
        ],
        [
            'header' => 'Kode Aset',
            'name' => 'invperalatan_kode'
        ],                
        [
            'header' => 'Lokasi Aset',
            'value' => function($data){
                if (!empty($data['lokasi'])){
                    foreach($data['lokasi'] as $lok){
                        echo $lok.'<br/>';
                    }
                }
            }
        ],
        [
            'header' => 'Jenis Kelengkapan',
            'name' => 'jenis_kelengkapan'
        ],         
        [
            'header' => 'Jatuh Tempo',
            'name' => 'jatuh_tempo',
            'value' => function($data){
                return !empty($data['jatuh_tempo'])?MyFormatter::formatDateTimeForUser($data['jatuh_tempo'], 'long'):'';
            }
        ],         
        [
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function ($data){
                $url = $this->createUrl('DetailPerizinan',['id'=>$data['id']]);
                if ($data['jenis_kelengkapan'] == 'Kalibrasi'){
                    $url = $this->createUrl('InformasiKalibrasi/Detail',['id'=>$data['id']]);
                }
                
                echo CHtml::link("<span class='fa fa-list'></span>",$url,['class'=>'btn btn-info','rel'=>'tooltip','title'=>'Detai Data']);
            },
            'visible' => $visible,
            'htmlOptions' => ['style'=>'text-align:center']
        ]  ,
              
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});            
    }',
));
?>
