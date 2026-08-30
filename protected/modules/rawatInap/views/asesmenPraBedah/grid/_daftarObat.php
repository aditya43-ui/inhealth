<?php
$modObat = new ObatalkesM('searchDialog');
$modObat->default = 'kosong';
if(isset($_GET['ObatalkesM'])){
    $modObat->attributes = $_GET['ObatalkesM']; 
    $modObat->default = isset($_GET['ObatalkesM']['default'])?$_GET['ObatalkesM']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-obat-grid',
	'dataProvider'=>$modObat->searchObat(),
	'filter'=>$modObat,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'filter' => CHtml::activeHiddenField($modObat, 'default'),
                    'value'=>function($data){    
                        $dt = $data->attributes;                        
                        $res = json_encode($dt);
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                                setObat(".$res.",'','')
                                                return false;"));
                    },
                ),
                'obatalkes_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));