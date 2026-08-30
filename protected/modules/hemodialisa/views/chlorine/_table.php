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
                    'name'=>'<center>Sampling</center>',
                    'start'=>1, //indeks kolom 3
                    'end'=>6, //indeks kolom 4
            ),           
    ),
    'columns' => array(
        [
            'header' => 'Tanggal',
            'name' => 'tgl_monitoring',
            'value' => function($data){
                return MyFormatter::formatDateTimeForUser($data->tgl_monitoring);
            }
        ],
        [
            'header' => 'Shift 1',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                return CustomFunction::set_pilihan_ceklis($data->is_shift1, $excel);
            }
        ],
        [
            'header' => 'Pegawai',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                return $data->pegawai_shift1_nama;
            }
        ],
        [
            'header' => 'Shift 2',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                return CustomFunction::set_pilihan_ceklis($data->is_shift2, $excel);
            }
        ],
        [
            'header' => 'Pegawai',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                return $data->pegawai_shift2_nama;
            }
        ],
        [
            'header' => 'Late Shift',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                return CustomFunction::set_pilihan_ceklis($data->is_lateshift, $excel);
            }
        ],
        [
            'header' => 'Pegawai',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                return $data->pegawai_lateshift_nama;
            }
        ],
        [
            'header' => 'Status',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                return $data->status;
            }
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
            'value' => 'CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->hd_chlorine_id)",array("id"=>"$data->hd_chlorine_id","rel"=>"tooltip","title"=>"Hapus"))',
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
    }',
));
?>