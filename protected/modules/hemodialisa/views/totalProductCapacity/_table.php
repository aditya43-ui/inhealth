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
            'name'=>'<center>RO-1</center>',
            'start'=>1,
            'end'=>4,
        ),           
        array(
            'name'=>'<center>RO-2</center>',
            'start'=>5,
            'end'=>8,
        ),           
        array(
            'name'=>'<center>RO-3</center>',
            'start'=>9,
            'end'=>12,
        ),              
    ),
    'columns' => array(
        [
            'header' => '<center>Tanggal</center>',
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
            'name' => 'ro1_jam'
        ],
        [
            'header' => '<center>Permeate</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'ro1_permeate'
        ],
        [
            'header' => '<center>Concentrate</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'ro1_concentrate'
        ],
        [
            'header' => '<center>% Reject</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'ro1_rejection'
        ],        
        //ro 2
        [
            'header' => '<center>Time</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'ro2_jam'
        ],
        [
            'header' => '<center>Permeate</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'ro2_permeate'
        ],
        [
            'header' => '<center>Concentrate</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'ro2_concentrate'
        ],
        [
            'header' => '<center>% Reject</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'ro2_rejection'
        ],  
        //end ro2
        //ro 3
        [
            'header' => '<center>Time</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'ro3_jam'
        ],
        [
            'header' => '<center>Permeate</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'ro3_permeate'
        ],
        [
            'header' => '<center>Concentrate</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'ro3_concentrate'
        ],
        [
            'header' => '<center>% Reject</center>',            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'name' => 'ro3_rejection'
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
            'value' => 'CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->hd_tpc_id)",array("id"=>"$data->hd_tpc_id","rel"=>"tooltip","title"=>"Hapus"))',            
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