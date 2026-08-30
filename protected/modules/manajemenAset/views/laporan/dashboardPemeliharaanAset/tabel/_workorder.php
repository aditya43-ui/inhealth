<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
$data = $model->searchDashboardWo();
$template = "{items}";

$this->widget($table, array(
    'id' => 'invperalatan-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,    
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed', 
    'columns' => array(        
        [
            'header' => 'Peralatan',
            'type' => 'raw',
            'name' => 'invperalatan_namabrg',
            'value' => function($data){
                return $data->invperalatan_namabrg.'<br/>'.$data->invperalatan_kode.'<br/>'.$data->lokasiaset_namalokasi;
            }
        ],
        array(
            'header'=>'Status',
            'type' => 'raw',
            'value'=>function($data){
            
                return ParamsConst::getWrStatusWo($data->status_pemeliharaan);                            
                
            },
        ), 
    ),
    'afterAjaxUpdate' => 'function(id, data){    
                
    }',
));
?>