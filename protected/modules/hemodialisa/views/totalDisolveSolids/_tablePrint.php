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
            'name'=>'<center>Shift 1</center>',
            'start'=>3,
            'end'=>6,
        ),           
        array(
            'name'=>'<center>Shift 2</center>',
            'start'=>7,
            'end'=>10,
        ),           
    ),
    'mergeColumns'=>array('tahun','bulan'),
    'columns' => array(
        [
            'header' => 'Tahun',
            'name' => 'tahun',
            'type' => 'raw',
            'htmlOptions' => ['style'=>'text-align:center'],
            'value' => function($data){    
                $pecah = str_split($data['tahun']);
                
                $temp = '';
                foreach($pecah as $det){
                    $temp .= $det.'<br/>';
                }
                return '<h3><b>'.$temp.'</b></h3>';
            }
        ],
        [
            'header' => 'Bulan',
            'name' => 'bulan',
            'type' => 'raw',
            'htmlOptions' => ['style'=>'text-align:center'],
            'value' => function($data){
                $pecah = str_split($data['bulan']);
                
                $temp = '';
                foreach($pecah as $det){
                    $temp .= $det.'<br/>';
                }
                return '<h3><b>'.$temp.'</b></h3>';
            }
        ],
        [
            'header' => 'Tgl',
            'name' => 'tanggal',
             'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function($data){
                return $data['tanggal'];
            }
        ],        
        [
            'header' => '<center>Time</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'shift1_jam'
        ],
        [
            'header' => '<center>Feed</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'shift1_feed'
        ],
        [
            'header' => '<center>Product</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'shift1_product'
        ],
        [
            'header' => '<center>% Reject</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'shift1_rejection'
        ],
        [
            'header' => '<center>Jam</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'shift2_jam'
        ],
        [
            'header' => '<center>Feed</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'shift2_feed'
        ],
        [
            'header' => '<center>Product</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'shift2_product'
        ],
        [
            'header' => '<center>% Rejection</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'shift2_rejection'
        ],     
    ),
    'afterAjaxUpdate' => 'function(id, data){
           
    }',
));
        
        echo $this->renderPartial($this->path_view.'_instruksi',[], true);
?>