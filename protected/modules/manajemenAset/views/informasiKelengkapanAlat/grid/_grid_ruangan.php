<?php

$model = new RuanganM('searchDialog');
if(isset($_GET['RuanganM'])){
    $model->attributes = $_GET['RuanganM'];    
    $model->instalasi_nama = isset($_GET['RuanganM']['instalasi_nama'])?$_GET['RuanganM']['instalasi_nama']:null;  
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'ruangan-m-grid',
	'dataProvider'=>$model->searchDialog(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>function($data){    
                    $dt['ruangan_id'] = $data->ruangan_id;
                    $dt['ruangan_nama'] = $data->ruangan_nama;

                    $res = json_encode($dt);
                    return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                "id" => "selectObat",
                                "onClick" => "
                                            setRuangan(".$res.")
                                            return false;"));
                },
            ),
            'instalasi_nama',
            'ruangan_nama',                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

?>

