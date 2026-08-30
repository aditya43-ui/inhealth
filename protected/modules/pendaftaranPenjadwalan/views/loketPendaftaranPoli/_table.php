<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
if (isset($caraPrint)) {
    $row = '$row+1';
    $visible = false;
    $data = $model->searchLoket();
    $data->pagination = false;
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    $filter = null;
} else {
    $data = $model->searchLoket();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'filter'=>$filter,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed', 
    'columns' => array(
        array(
            'header' => 'No',
            'value' => $row,
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'Nama Loket',
            'name' => 'loket_nama',            
        ),
        array(
            'header' => 'Poliklinik',
            'name' => 'ruangan_nama',
            'value' => function($data){
                $poli = LoketpendaftaranpoliM::model()->findAll("loket_id = ".$data->loket_id);
                foreach($poli as $key => $val){
                    echo '- '.$val->ruangan_nama.'<br/>';
                }
            } 
        ),        
        array(
            'header' => Yii::t('zii', 'View'),
            'class' => 'bootstrap.widgets.BootButtonColumn',
            'template' => '{view}',
            'visible' => $visible
        ),
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
            'value' => 'CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->loketpendaftaranpoli_id)",array("id"=>"$data->loketpendaftaranpoli_id","rel"=>"tooltip","title"=>"Hapus"))',
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