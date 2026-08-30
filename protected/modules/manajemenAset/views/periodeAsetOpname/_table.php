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
//    'filter'=>$filter,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed', 
    'columns' => array(
        array(
            'header' => 'No',
            'value' => $row,
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        'periodeasetopname_nama',
        [
            'header' => 'Tanggal',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_awal,"long")." - ".MyFormatter::formatDateTimeForUser($data->tanggal_akhir,"long")'
        ],        
        array(
            'header' => '<center>Status</center>',
            'value' => '($data->periodeasetopname_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
            'value' => '($data->periodeasetopname_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->periodeasetopname_id)",array("id"=>"$data->periodeasetopname_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->periodeasetopname_id)",array("id"=>"$data->periodeasetopname_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-check\'></i> ","javascript:aktif($data->periodeasetopname_id)",array("id"=>"$data->periodeasetopname_id","rel"=>"tooltip","title"=>"mengaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->periodeasetopname_id)",array("id"=>"$data->periodeasetopname_id","rel"=>"tooltip","title"=>"Hapus"));',
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