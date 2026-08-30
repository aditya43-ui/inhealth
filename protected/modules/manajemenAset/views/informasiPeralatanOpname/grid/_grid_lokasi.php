<?php

$modLokasi = new LokasiasetM('searchDialog');
$modLokasi->lokasiaset_aktif = true;
if(isset($_GET['LokasiasetM'])){
    $modLokasi->attributes = $_GET['LokasiasetM'];        
    $modLokasi->lokasiaset_aktif = true;
}


if ($model->ada_pj_aset){
    $modLokasi->lokasi_id = empty($modLokasi->lokasi_id)?$model->lokasi_id:$modLokasi->lokasi_id;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'lokasi-grid',
	'dataProvider'=>$modLokasi->search(),
	'filter'=>$modLokasi,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>function($data){    
                    $dt['lokasi_id'] = $data->lokasi_id;
                    $dt['lokasiaset_kode'] = $data->lokasiaset_kode;
                    $dt['lokasiaset_namalokasi'] = $data->lokasiaset_namalokasi;
                    $dt['ruangan_id'] = $data->ruangan_id;
                    $dt['ruangan_nama'] = $data->ruangan_nama;

                    $res = json_encode($dt);
                    return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                "id" => "selectObat",
                                "onClick" => "
                                            setLokasi(".$res.")
                                            return false;"));
                },
            ),
            'lokasiaset_kode',
            'lokasiaset_namalokasi',                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

?>

