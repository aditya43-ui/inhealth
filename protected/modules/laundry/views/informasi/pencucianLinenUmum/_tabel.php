<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
$data = $model->search();
if (isset($caraPrint)) {
    $row = '$row+1';
    $visible = false;
    $data->pagination = false;
    
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    $filter = null;
} else {
    
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'informasi-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
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
            'header' => 'Tgl Penerimaan',
            'name' => 'tglpenerimaan',
            'value' => function($data){
                return MyFormatter::formatDateTimeForUser($data->tglpenerimaan, 'long');
            }
        ],
        [
            'header' => 'Tgl Pencucian',
            'name' => 'tglpencucian',
            'value' => function($data){
                return MyFormatter::formatDateTimeForUser($data->tglpencucian, 'long');
            }
        ],
        'nopenerimaan',
        'nopencucian',
        'namapengirim',
        'mesinpencucian_nama',   
        'keterangan',      
        [
            'header' => 'Pengambilan',
            'type' => 'raw',
            'value' => function ($data){
                echo CHtml::link("<span class='fa fa-shopping-cart' style='font-size:15pt;'></span>",$this->createUrl('ambilPencucianLinenUmum',['pencucianumum_id'=>$data->pencucianlinenumum_id]),['rel'=>'tooltip','title'=>'Pengambilan data']);
            },
            'visible' => $visible,
            'htmlOptions' => ['style'=>'text-align:center']
        ], 
        [
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function ($data){
                echo CHtml::link("<span class='icon-form-lihat'></span>",$this->createUrl('detail',['id'=>$data->pencucianlinenumum_id]),['rel'=>'tooltip','title'=>'Detail data', 'target'=>'frameDetail', 'onclick'=>'$("#dialogDetail").dialog("open");']);                                                                        
            },
            'visible' => $visible,
            'htmlOptions' => ['style'=>'text-align:center']
        ],               
        [
            'header' => 'Batal',
            'type' => 'raw',
            'value' => function ($data){
                echo CHtml::link("<span class='icon-form-silang'></span>",'javascript:;',['rel'=>'tooltip','title'=>'Batal', 'onclick'=>'batalPencucian('.$data->pencucianlinenumum_id.')']);
            },
            'visible' => $visible,
            'htmlOptions' => ['style'=>'text-align:center']
        ],   
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});            
    }',
));
?>
<script>
    function print(id) {
        
        window.open('<?php echo $this->createUrl('printSampelKeluar'); ?>&sampelkeluarstemcell_id=' + id, 'location=_new', 'left=100,top=100,width=800,height=900');

    }
</script>