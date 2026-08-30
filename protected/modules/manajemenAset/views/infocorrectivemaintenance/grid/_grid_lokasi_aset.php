<?php

$modL = new LokasiasetM;
$modL->lokasiaset_aktif = true;
$modL->default = 'kosong';
if(isset($_GET['LokasiasetM'])){
    $modL->attributes = $_GET['LokasiasetM'];
    $modL->lokasiaset_aktif = true;
    $modL->default = isset($_GET['LokasiasetM']['default'])?$_GET['LokasiasetM']['default']:null;
    $modL->ruangan_nama = isset($_GET['LokasiasetM']['ruangan_nama'])?$_GET['LokasiasetM']['ruangan_nama']:null;
}


if ($model->is_pj_asset){
    $modL->lokasi_aset_pj = true;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'lokasi-grid',
	'dataProvider'=>$modL->search(),
	'filter'=>$modL,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'filter' => CHtml::activeHiddenField($modL, 'ruangan_id').CHtml::activeHiddenField($modL, 'default'),
                    'value'=>function($data){                            
                        $dt = $data->attributes;
                        $res = json_encode($dt);
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                            "id" => "selectObat",
                            "onClick" => "
                                setLokasi(".$res.");
                                return false;"
                        ));
                    },
                ),
                'ruangan_nama',
                'kode_internal',
                [
                    'header' => 'Lokasi Aset',
                    'name' => 'lokasiaset_namalokasi'
                ]                     
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));