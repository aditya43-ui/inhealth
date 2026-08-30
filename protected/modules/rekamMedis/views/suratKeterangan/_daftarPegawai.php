<?php 
$modPegawai = new PegawaiM;
$modPegawai->unsetAttributes();
if(isset($_GET['PegawaiM'])){
    $modPegawai->attributes = $_GET['PegawaiM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawai-m-grid',
    'dataProvider'=>$modPegawai->search(),
    'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        'nomorindukpegawai',
        'kelompokjabatan',
        array('name'=>'nama_pegawai', 'value'=>'$data->namaLengkap'),
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputPegawai($data->pegawai_id,
                                                    \'$data->namaLengkap\',\'$data->kelompokjabatan\');return false;"))',
        )
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

<script type="text/javascript">
function inputPegawai(idPegawai,namaPegawai,kelompokJabatan)
{
    $("#RKSuratketeranganR_ygbertandatangan_id").val(idPegawai);
    $("#ygbertandatangan_nama").val(namaPegawai);
    $("#jabatan").val(kelompokJabatan);
    $("#dialogPegawai").dialog('close');
}
</script>
    
