<?php 
$modSupir = new SupirambulansV;
$modSupir->unsetAttributes();
if(isset($_GET['SupirambulansV'])){
    $modSupir->attributes = $_GET['SupirambulansV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'supir-v-grid',
    'dataProvider'=>$modSupir->search(),
    'filter'=>$modSupir,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        'ruangan_nama',
        'nama_pegawai',
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputSupir($data->pegawai_id,
                                                    \'$data->nama_pegawai\');return false;"))',
        )
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

<script type="text/javascript">
function inputSupir(idSupir,namaSupir)
{
    $("#AMPemakaianambulansT_supir_id").val(idSupir);
    $("#AMPemakaianambulansT_supir_nama").val(namaSupir);
    $("#dialogSupir").dialog('close');
}
</script>
    
