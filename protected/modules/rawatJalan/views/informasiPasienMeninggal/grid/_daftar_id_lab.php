<?php
$modDiag = new DaftarperawatanselpuncaV('searchDialog');
$modDiag->default = 'kosong';
if(isset($_GET['DaftarperawatanselpuncaV'])){
    $modDiag->attributes = $_GET['DaftarperawatanselpuncaV'];        
    $modDiag->default = isset($_GET['DaftarperawatanselpuncaV']['default'])?$_GET['DaftarperawatanselpuncaV']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-id-lab-grid',
	'dataProvider'=>$modDiag->search(),
	'filter'=>$modDiag,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'filter' => CHtml::activeHiddenField($modDiag, 'default'),
                    'value'=>function($data){    
                        $dt = $data->attributes;                        
                        $res = json_encode($dt);
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                                setIdLab(".$res.",'')
                                                return false;"));
                    },
                ),
                'id_lab',
                'dpjp',
                'pasien_norm',
                'pasien_nama',
                'jaringansumberstemcell_nama'
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
