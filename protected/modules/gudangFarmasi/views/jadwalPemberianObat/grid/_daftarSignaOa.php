<?php
$model = new LookupM('searchByDokter');
$model->unsetAttributes();
$model->default = 'kosong';
if(isset($_GET['LookupM'])){
    $model->attributes = $_GET['LookupM'];    
    $model->default = isset($_GET['LookupM']['default'])?$_GET['LookupM']['default']:''; 
}
$model->lookup_type = Params::LOOKUPTYPE_SIGNA_OA;
$model->lookup_aktif = true;

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'signa-oa-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data){    
                $res['name'] = $data->lookup_name;
                $res['value'] = $data->lookup_value;
                $res = json_encode($res);
                
                return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"setSigna(".$res.")"
                ));
            }
        ),
        [
            'header' => 'Name',
            'name' => 'lookup_name'
        ],
        [
            'header' => 'Value',
            'name' => 'lookup_value'
        ]
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));