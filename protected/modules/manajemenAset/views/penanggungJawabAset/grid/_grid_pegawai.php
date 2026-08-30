<?php

$modPeg = new PegawaiV;
if(isset($_GET['PegawaiV'])){
    $modPeg->attributes = $_GET['PegawaiV'];    
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-v-grid',
	'dataProvider'=>$modPeg->searchAllPegawai(),
	'filter'=>$modPeg,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data) use ($model){
    
                        $dt = $data->attributes;                           
                        $res = json_encode($dt);
                        
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $('#".CHtml::activeId($model, 'pegawai_id')."').val(".$data->pegawai_id.");
                                        $('#".CHtml::activeId($model, 'nama_pegawai')."').val('".$data->nama_pegawai."');
                                        $('#dialogPegawai').dialog('close');
                                        return false;"
                            ));
                    },
                ),
                'nomorindukpegawai',
                 [
                     'header' => 'Nama Pegawai',
                     'name' => 'nama_pegawai',
                     'value' => '$data->namaLengkap'
                 ]                   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));