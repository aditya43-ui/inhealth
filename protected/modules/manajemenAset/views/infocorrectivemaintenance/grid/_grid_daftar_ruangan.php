<?php
$modR = new RuanganM;
if(isset($_GET['RuanganM'])){
    $modR->attributes = $_GET['RuanganM'];
    $modR->instalasi_nama = isset($_GET['RuanganM']['instalasi_nama'])?$_GET['RuanganM']['instalasi_nama']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'ruangan-grid',
	'dataProvider'=>$modR->searchDialog(),
	'filter'=>$modR,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data){                            
                        $dt = $data->attributes;
                        $res = json_encode($dt);
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                            "id" => "selectObat",
                            "onClick" => "
                                setRuangan(".$res.");
                                return false;"
                        ));
                    },
                ),
                'instalasi_nama',
                'ruangan_nama',                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));