<?php
$modDiag = new DiagnosaM('searchDialog');
$modDiag->default = 'kosong';
if(isset($_GET['DiagnosaM'])){
    $modDiag->attributes = $_GET['DiagnosaM']; 
    $modDiag->default = isset($_GET['DiagnosaM']['default'])?$_GET['DiagnosaM']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-diagnosa-grid',
	'dataProvider'=>$modDiag->searchDialog(),
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
                            setDiagnosa(".$res.",'','')
                        return false;"));
                    },
                ),
                'diagnosa_kode',
                'diagnosa_nama'
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));