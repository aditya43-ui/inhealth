<?php 
    $modPelaksana = new SupirambulansV;
    $modPelaksana->unsetAttributes();
    if(isset($_GET['SupirambulansV'])){
        $modPelaksana->attributes = $_GET['SupirambulansV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'supir-t-grid',
        'dataProvider'=>$modPelaksana->search(),
        'filter'=>$modPelaksana,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                "id" => "selectPasien",
                                "onClick" => "inputPelaksana($data->pegawai_id,
                                                            \'$data->nama_pegawai\');return false;"))',
            ),
            'ruangan_nama',
            'nama_pegawai',        
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?> 
