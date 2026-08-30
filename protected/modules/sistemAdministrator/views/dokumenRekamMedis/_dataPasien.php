<?php 
    $modPasien = new SAPasienM;
    $modPasien->unsetAttributes();
    if(isset($_GET['SAPasienM'])){
        $modPasien->attributes = $_GET['SAPasienM'];
		$modPasien->pasien_id = $_GET['SAPasienM']['pasien_id'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'pasien-v-grid',
        'dataProvider'=>$modPasien->searchDialog(),
        'filter'=>$modPasien,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "inputPasien($data->pasien_id,
                                        \'$data->nama_pasien\');return false;"))',
                    ),  
                    'pasien_id',
					array(
					'name'=>'nama_pasien',
					'type'=>'raw',
					'value'=>'isset($data->namadepan)?$data->namadepan." ".$data->nama_pasien:$data->nama_pasien',
					),
                    'jeniskelamin',  
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?> 
    
