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
                    'name'=>'<center>Brine Tank Inspection</center>',
                    'start'=>1, //indeks kolom 3
                    'end'=>3, //indeks kolom 4
            ),           
    ),
    'columns' => array(
        [
            'header' => 'Time',
            'name' => 'tgl_minitoring',
            'value' => function($data){
                return MyFormatter::formatDateTimeForUser($data->tgl_minitoring);
            }
        ],
        [
            'header' => 'Water Level',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                return CustomFunction::set_pilihan_ceklis($data->is_waterlevel, $excel);
            }
        ],
        [
            'header' => 'Water Condition',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                return CustomFunction::set_pilihan_ceklis($data->is_watercondition, $excel);
            }
        ],
        [
            'header' => 'Salt Bridge',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                return CustomFunction::set_pilihan_ceklis($data->is_saltbridge, $excel);
            }
        ],
        [
            'header' => 'Salt Adding Procedure',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                return CustomFunction::set_pilihan_ceklis($data->is_saltaddingprocedure, $excel);
            }
        ],
        [
            'header' => 'Pegawai',
            'type' => 'raw',
            'name' => 'nama_pegawai'
        ],
        array(
            'header' => Yii::t('zii', 'Update'),
            'class' => 'bootstrap.widgets.BootButtonColumn',
            'template' => '{update}',
            
                    'visible' => $visible
               
        ),
        array(
            'header' => 'Hapus',
            'type' => 'raw',
            'visible' => $visible,          
            'value' => 'CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->hd_brinetank_id)",array("id"=>"$data->hd_brinetank_id","rel"=>"tooltip","title"=>"Hapus"))',
            'htmlOptions' => array('style' => 'text-align:left; width:80px'),
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