<?php

$modLokasi = new LokasiasetM('searchDialog');
$modLokasi->lokasiaset_aktif = true;
if(isset($_GET['LokasiasetM'])){
    $modLokasi->attributes = $_GET['LokasiasetM'];        
    $modLokasi->ruangan_nama = isset($_GET['LokasiasetM']['ruangan_nama'])?$_GET['LokasiasetM']['ruangan_nama']:null;
    $modLokasi->lokasiaset_aktif = true;  
    
    $aset = PenanggungjawabasetM::model()->find(" pegawai_id = ".Yii::app()->user->getState('pegawai_id')." ");
    if (!empty($aset)){
        $modLokasi->lokasi_aset_pj = isset($_GET['LokasiasetM']['lokasi_aset_pj'])?$_GET['LokasiasetM']['lokasi_aset_pj']:null;
    }
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
                'filter'=> CHtml::activeHiddenField($modLokasi, 'lokasi_aset_pj').CHtml::activeHiddenField($modLokasi, 'ruangan_id'),                
                'value'=>function($data){    
                    $dt['lokasi_id'] = $data->lokasi_id;                    
                    $dt['lokasiaset_namalokasi'] = $data->lokasiaset_namalokasi;                    
                    $dt['ruangan_id'] = $data->ruangan_id;                    
                    $dt['ruangan_nama'] = $data->ruangan_nama;                    

                    $res = json_encode($dt);
                    return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                "id" => "selectObat",
                                "onClick" => "
                                            setLokasi(".$res.",'')
                                    return false;"));
                },
            ),
            'ruangan_nama',
            'lokasiaset_namalokasi',                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

?>

