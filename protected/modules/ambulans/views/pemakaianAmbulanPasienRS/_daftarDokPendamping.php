<?php
    $modParamedis = new DokterV('searchDialog');
    $modParamedis->unsetAttributes();
    if(isset($_GET['DokterV'])){
        $modParamedis->attributes = $_GET['DokterV'];
    }
    $prov = $modParamedis->searchDialog();
    $prov->criteria->group = $prov->criteria->select = "pegawai_id, nama_pegawai, gelardepan, gelarbelakang_nama";
    $prov->sort->defaultOrder = "nama_pegawai";
    echo CHtml::hiddenField('paramedisKe','',array('readonly'=>true));
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'dokter-pendamping-t-grid',
        'dataProvider'=>$prov,
        'filter'=>$modParamedis,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                "id" => "selectPasien",
                                "onClick" => "inputDokPendamping($data->pegawai_id,
                                \'$data->nama_pegawai\');return false;"))',
            ),
//			array(
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
    
