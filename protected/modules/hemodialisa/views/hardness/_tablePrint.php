<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$sort = true;
$visible = true;
$filter = $model;
$excel = false;

$row = '$row+1';
$visible = false;
$data = $model->searchPrint();
$data->pagination = false;
$template = "{items}";
$sort = false;
if ($caraPrint == "EXCEL"){
    $excel = true;
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
$filter = null;
$tableCss = 'grid prinout w100';


$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
//    'filter'=>$filter,
    'template' => $template,
    'itemsCssClass' => $tableCss, 
    'mergeHeaders'=>array(
        array(
                'name'=>'<center>Sampling Time</center>',
                'start'=>1,
                'end'=>1,
        ),           
         array(
                'name'=>'<center>Sign.</center>',
                'start'=>2,
                'end'=>2,
        ), 
    ),    
    'columns' => array(
        [
            'header' => 'No',
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'value' => $row
        ],
        [
            'header' => '<center>Date/Month/Year</center>',
            'name' => 'tahun',
            'type' => 'raw',
            'htmlOptions' => ['style'=>'text-align:center'],
            'value' => function($data){    
                return $data['tanggal'].'/'.$data['bulan'].'/'.$data['tahun'];
            }
        ],
        [
            'header' => '<center>Clock<br/>(24h Format)</center>',
            'name' => 'bulan',
            'type' => 'raw',
            'htmlOptions' => ['style'=>'text-align:center'],
            'value' => function($data){
                return '';
            }
        ],
        [
            'header' => '<center>Test Result<br/>(mg/l CaCO3)</center>',
            'name' => 'tanggal',
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'value' => function($data){
                return $data['test_result'];
            }
        ],       
        [
            'header' => '<center>Status</center>',
            'type' => 'raw',
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'status'
        ],        
    ),
    'afterAjaxUpdate' => 'function(id, data){
           
    }',
));
        
        echo $this->renderPartial($this->path_view.'_instruksi',[], true);
?>