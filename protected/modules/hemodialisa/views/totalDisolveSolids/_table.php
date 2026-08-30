<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
$excel = false;
if (isset($caraPrint)) {
    $row = '$row+1';
    $visible = false;
    $data = $model->search();
    $data->pagination = false;
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL"){
        $excel = true;
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    $filter = null;
} else {
    $data = $model->search();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
//    'filter'=>$filter,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',   
    'mergeHeaders'=>array(
        array(
            'name'=>'<center>Shift 1</center>',
            'start'=>1,
            'end'=>4,
        ),           
        array(
            'name'=>'<center>Shift 2</center>',
            'start'=>5,
            'end'=>8,
        ),           
    ),
    'columns' => array(
        [
            'header' => '<center>Date</center>',
            'name' => 'tgl_monitoring',
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'value' => function($data){
                return MyFormatter::formatDateTimeForUser($data->tgl_monitoring,'long');
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
            'header' => '<center>Time</center>',            
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
        array(
            'header' => '<center>Ubah</center>',
            'class' => 'bootstrap.widgets.BootButtonColumn',
            'template' => '{update}',            
            'visible' => $visible,
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
        ),
        array(
            'header' => '<center>Hapus</center>',
            'type' => 'raw',
            'visible' => $visible,          
            'value' => 'CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->hd_tds_id)",array("id"=>"$data->hd_tds_id","rel"=>"tooltip","title"=>"Hapus"))',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
         ), 
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                    cekForm(this);
            });
             $("table").find("select").each(function(){
                    cekForm(this);
            });
            $(".numbers-only").keyup(function() {
                    setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
                    setNumbersOnly(this);
            });
    }',
));
?>