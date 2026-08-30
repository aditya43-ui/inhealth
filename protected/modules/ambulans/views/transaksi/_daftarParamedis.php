<?php 
$modParamedis = new ParamedisV;
$modParamedis->unsetAttributes();
if(isset($_GET['ParamedisV'])){
    $modParamedis->attributes = $_GET['ParamedisV'];
}
echo CHtml::hiddenField('paramedisKe','',array('readonly'=>true));
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'paramedis-t-grid',
    'dataProvider'=>$modParamedis->search(),
    'filter'=>$modParamedis,
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
                            "onClick" => "inputParamedis($data->pegawai_id,
                                                    \'$data->nama_pegawai\');return false;"))',
        )
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

<script type="text/javascript">
function inputParamedis(idPegawai,namaPegawai)
{
    var paramedisKe = $('#dialogParamedis #paramedisKe').val();
    $("#AMPemakaianambulansT_paramedis"+paramedisKe+"_id").val(idPegawai);
    $("#AMPemakaianambulansT_paramedis"+paramedisKe+"_nama").val(namaPegawai);
    $("#dialogParamedis").dialog('close');
}
</script>
    
