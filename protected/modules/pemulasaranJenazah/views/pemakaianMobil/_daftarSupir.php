<?php 
$modSupir = new PJSupirambulansV('searchDialog');
$modSupir->unsetAttributes();
if(isset($_GET['PJSupirambulansV'])){
    $modSupir->attributes = $_GET['PJSupirambulansV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'supir-t-grid',
    'dataProvider'=>$modSupir->searchDialog(),
    'filter'=>$modSupir,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Ruangan',
            'name'=>'ruangan_nama',
            'value'=>'$data->ruangan_nama',
        ),
        'nama_pegawai',
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputSupir($data->pegawai_id,\'$data->nama_pegawai\');return false;"))',
        )
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

<script type="text/javascript">
function inputSupir(idSupir,namaSupir)
{
    $("#PJPemakaianambulansT_supir_id").val(idSupir);
    $("#PJPemakaianambulansT_supir_nama").val(namaSupir);
    $("#dialogSupir").dialog('close');
}
</script>
    
