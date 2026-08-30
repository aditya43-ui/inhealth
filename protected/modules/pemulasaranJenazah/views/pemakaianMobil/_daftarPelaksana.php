<?php 
$modPelaksana = new PJSupirambulansV('searchDialog');
$modPelaksana->unsetAttributes();
if(isset($_GET['PJSupirambulansV'])){
    $modPelaksana->attributes = $_GET['PJSupirambulansV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pelaksana-t-grid',
    'dataProvider'=>$modPelaksana->searchDialog(),
    'filter'=>$modPelaksana,
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
                            "onClick" => "inputPelaksana($data->pegawai_id,\'$data->nama_pegawai\');return false;"))',
        )
    ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?> 

<script type="text/javascript">
function inputPelaksana(idPegawai,namaPegawai)
{
    $("#PJPemakaianambulansT_pelaksana_id").val(idPegawai);
    $("#PJPemakaianambulansT_pelaksana_nama").val(namaPegawai);
    $("#dialogPelaksana").dialog('close');
}
</script>
    
