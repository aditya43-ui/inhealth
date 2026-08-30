<?php 
    $modPelaksana = new AMSupirambulansV('searchDialog');
    $modPelaksana->unsetAttributes();
    if(isset($_GET['AMSupirambulansV'])){
        $modPelaksana->attributes = $_GET['AMSupirambulansV'];
    }
    $prov = $modPelaksana->searchDialog();
    $prov->criteria->group = $prov->criteria->select = "pegawai_id, nama_pegawai, gelardepan, gelarbelakang_nama";
    $prov->sort->defaultOrder = "nama_pegawai";
    
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'supir-t-grid',
        'dataProvider'=>$prov,
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
//            array(
//				'header'=>'Ruangan',
//				'name'=>'ruangan_nama',
//				'type'=>'raw',
//				'value'=>'$data->ruangan_nama'
//			),
            array(
                'name'=>'nama_pegawai',
                'value'=>'$data->namaLengkap',
            ),        
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?> 
