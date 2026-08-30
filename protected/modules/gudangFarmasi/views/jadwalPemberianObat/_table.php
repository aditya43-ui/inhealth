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
    $data = $model->search();
    $data->pagination = false;
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL"){
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
        [
            'header' => 'Sub Jenis Obat',
            'name' => 'subjenis_nama'
        ],        
        'signa_oa',
        [
            'name' => 'jadwal',
            'filter' => CHtml::activeDropDownList($model, 'jadwal', LookupM::getItemsUrutan('jammonitoring'),['empty'=>'-- Pilih --'])
        ],
        'urutan',
        array(
            'header' => '<center>Status</center>',
            'value' => '($data->jadwalpemberianobat_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
            'htmlOptions' => array('style' => 'text-align:center;'),
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
            'value' => '($data->jadwalpemberianobat_aktif)?CHtml::link("<i class=\'glyphicon glyphicon-remove\'></i> ","javascript:removeTemporary($data->jadwalpemberianobat_id)",array("id"=>"$data->jadwalpemberianobat_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->jadwalpemberianobat_id)",array("id"=>"$data->jadwalpemberianobat_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'glyphicon glyphicon-check\'></i> ","javascript:aktif($data->jadwalpemberianobat_id)",array("id"=>"$data->jadwalpemberianobat_id","rel"=>"tooltip","title"=>"mengaktifkan"))." ".CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->jadwalpemberianobat_id)",array("id"=>"$data->jadwalpemberianobat_id","rel"=>"tooltip","title"=>"Hapus"));',
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