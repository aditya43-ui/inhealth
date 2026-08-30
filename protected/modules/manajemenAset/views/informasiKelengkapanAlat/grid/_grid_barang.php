<?php


$model = new BarangM('searchDialog');
if(isset($_GET['BarangM'])){
    $model->attributes = $_GET['BarangM'];           
}
$model->barang_type = ParamsConst::TYPE_BARANG_INVENTARIS;

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'barang-m-grid',
	'dataProvider'=>$model->searchDialog(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>function($data){    
                    $dt['barang_id'] = $data->barang_id;
                    $dt['barang_nama'] = $data->barang_nama;

                    $res = json_encode($dt);
                    return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                "id" => "selectObat",
                                "onClick" => "
                                            setBarang(".$res.")
                                            return false;"));
                },
            ),
            'barang_nama',                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>

