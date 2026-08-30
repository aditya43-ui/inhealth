<?php
$modDaftar = new DaftarpasaseperawatanselpuncaV('searchDialog');
$modDaftar->default = 'kosong';
if(isset($_GET['DaftarpasaseperawatanselpuncaV'])){
    $modDaftar->attributes = $_GET['DaftarpasaseperawatanselpuncaV'];
    $modDaftar->default = isset($_GET['DaftarpasaseperawatanselpuncaV']['default'])?$_GET['DaftarpasaseperawatanselpuncaV']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-pasase-grid',
	'dataProvider'=>$modDaftar->searchDialogPerawatan(),
	'filter'=>$modDaftar,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'filter' => CHtml::activeHiddenField($modDaftar, 'default').CHtml::activeHiddenField($modDaftar, 'sampelmasukstemcell_id'),
                    'value'=>function($data){    
                        $dt = $data->attributes;                        
                        $res = json_encode($dt);
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                                setPasase(".$res.",'')
                                                return false;"));
                    },
                ),
                'pasase',
                'jenisstemcell_nama',
                [
                    'header'=>'Jumlah Plate',
                    'name'=>'jumlah'
                ],                
                [
                    'header'=>'Ukuran Plate',
                    'name'=>'ukuran_plate',
                    'value'=>function($data){
                        return $data->ukuran_plate;
                    }
                ],                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
