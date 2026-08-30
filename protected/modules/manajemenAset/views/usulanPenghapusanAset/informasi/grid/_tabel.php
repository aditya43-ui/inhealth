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
            'header' => 'Tanggal Usulan',
            'type'=>'raw',
            'value' => function($data){
                return MyFormatter::formatDateTimeForUser($data->usulanpenghapusanaset_tanggal);
            }
        ],
        'usulanpenghapusanaset_nomor',       
        'lokasi_aset',
        'pegpengusul_nama',
        [
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function ($data){
                echo CHtml::link("<span class='fa fa-list'></span>",$this->createUrl('detail',['usulanpenghapusanaset_id'=>$data->usulanpenghapusanaset_id]),['class'=>'btn btn-info','rel'=>'tooltip','title'=>'Detai Data']);
            },
            'visible' => $visible,
            'htmlOptions' => ['style'=>'text-align:center']
        ]  ,
        [
            'header' => 'Verifikasi',
            'type' => 'raw',
            'value' => function ($data){                     
                if ($data->verifikasi == 'Belum Verifikasi'){                
                    echo CHtml::link("<span class='fa fa-check'></span>",$this->createUrl('verifikasi',['usulanpenghapusanaset_id'=>$data->usulanpenghapusanaset_id]),['class'=>'btn btn-success','rel'=>'tooltip','title'=>'Verifikasi Usulan']);
                }else{
                    echo $data->verifikasi;
                }
            },
            'visible' => $visible,
            'htmlOptions' => ['style'=>'text-align:center']
        ]  ,        
//        [
//            'header' => 'Penghapusan Aset',
//            'type' => 'raw',
//            'value' => function ($data){                
//                if ($data->penghapusanaset == 'Belum Dihapus'){                
//                    echo CHtml::link("<span class='fa fa-arrow-circle-o-right'></span>",$this->createUrl('pengemasan/index',['usulanpenghapusanaset_id'=>$data->usulanpenghapusanaset_id]),['class'=>'btn btn-danger','rel'=>'tooltip','title'=>'Verifikasi Usulan']);
//                }
//            },
//            'visible' => $visible,
//            'htmlOptions' => ['style'=>'text-align:center']
//        ]  ,
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});            
    }',
));
?>
