<?php
$modTin = new DaftartindakanM('searchDialog');
$modTin->default = 'kosong';
if(isset($_GET['DaftartindakanM'])){
    $modTin->attributes = $_GET['DaftartindakanM']; 
    $modTin->default = isset($_GET['DaftartindakanM']['default'])?$_GET['DaftartindakanM']['default']:null;    
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-tindakan-grid',
	'dataProvider'=>$modTin->searchDialog(),
	'filter'=>$modTin,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'filter' => CHtml::activeHiddenField($modTin, 'default').
                            CHtml::activeHiddenField($modTin, 'kelompoktindakan_id'),
                'value'=>function($data){    
                    $dt = $data->attributes;                        
                    $res = json_encode($dt);
                    return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                        "id" => "selectObat",
                        "onClick" => "
                            setTindakan(".$res.",'')
                            return false;"
                    ));
                },
            ),
            'daftartindakan_kode',
            'daftartindakan_nama',                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));