<?php

$modR = new RuanganM;
if(isset($_GET['RuanganM'])){
    $modR->attributes = $_GET['RuanganM'];    
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'ruangan-m-grid',
	'dataProvider'=>$modR->searchDialog(),
	'filter'=>$modR,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data) use ($model){                            
                        
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $('#".CHtml::activeId($model, 'ruangan_nama')."').val('".trim($data->ruangan_nama)."');
                                        $('#".CHtml::activeId($model, 'ruangan_id')."').val(".$data->ruangan_id.");
                                        $('#dialogRuangan').dialog('close');                                                                            
                                        return false;"
                            ));
                    },
                ),
                [
                    'header' => 'Instalasi',
                    'name' => 'instalasi_nama'
                ],
                [
                    'header' => 'Ruangan',
                    'name' => 'ruangan_nama'
                ],                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));