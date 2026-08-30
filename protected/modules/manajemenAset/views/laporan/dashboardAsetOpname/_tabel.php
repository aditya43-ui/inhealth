<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
$data = $model->searchDashboardInvenBaru();
$template = "{items}";

$this->widget($table, array(
    'id' => 'invperalatan-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,    
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed', 
    'columns' => array(        
        [
            'header' => 'Nama Peralatan',
            'name' => 'invperalatan_namabrg'
        ],
        [
            'header' => 'Lokasi Aset',
            'name' => 'lokasiaset_namalokasi'
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){    
                
    }',
));
?>