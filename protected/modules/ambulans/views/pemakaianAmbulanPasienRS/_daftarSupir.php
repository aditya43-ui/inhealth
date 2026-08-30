<?php 
    $modSupir = new AMSupirambulansV('searchDialog');
    $modSupir->unsetAttributes();
    $modSupir->jabatan_id = Params::JABATAN_ID_DRIVER;
    $modSupir->ruangan_id = Params::RUANGAN_ID_AMBULANCE;
    if(isset($_GET['AMSupirambulansV'])){
        $modSupir->attributes = $_GET['AMSupirambulansV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'supir-v-grid',
        'dataProvider'=>$modSupir->searchDialog(),
        'filter'=>$modSupir,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
								"id" => "selectSupir",
								"onClick" => "inputSupir($data->pegawai_id,
								\'$data->nama_pegawai\');return false;"))',
			),
			array(
				'header'=>'Ruangan',
				'name'=>'ruangan_nama',
				'type'=>'raw',
				'value'=>'$data->ruangan_nama'
			),
			'nama_pegawai',       
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?> 
    
