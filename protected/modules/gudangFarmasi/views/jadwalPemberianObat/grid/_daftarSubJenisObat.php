<?php
$model = new SubjenisM('searchByDokter');
$model->unsetAttributes();
$model->default = 'kosong';
if(isset($_GET['SubjenisM'])){
    $model->attributes = $_GET['SubjenisM'];
    $model->jenisobatalkes_nama = isset($_GET['SubjenisM']['jenisobatalkes_nama'])?$_GET['SubjenisM']['jenisobatalkes_nama']:null;
    $model->default = isset($_GET['SubjenisM']['default'])?$_GET['SubjenisM']['default']:''; 
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'subjenis-oa-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data){    
                $res['name'] = $data->subjenis_nama;
                $res['id'] = $data->subjenis_id;
                $res = json_encode($res);
                
                return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"setSubjenis(".$res.")"
                ));
            }
        ),
        'subjenis_kode',
        'subjenis_nama',       
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));