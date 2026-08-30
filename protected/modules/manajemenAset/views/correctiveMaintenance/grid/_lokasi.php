<?php
$modLokasi = new LokasiasetM('searchDialog');
$modLokasi->lokasiaset_aktif = true;
if(isset($_GET['LokasiasetM'])){
    $modLokasi->attributes = $_GET['LokasiasetM'];        
    $modLokasi->lokasiaset_aktif = true;
    $modLokasi->ruangan_nama = isset($_GET['LokasiasetM']['ruangan_nama'])?$_GET['LokasiasetM']['ruangan_nama']:null;
}

$lokasi_id = PenanggungjawabasetM::getDropIdByPegawai(Yii::app()->user->getState('pegawai_id'));
if (!empty($lokasi_id)){
    $modLokasi->lokasi_id = $lokasi_id;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'lokasi-grid',
	'dataProvider'=>$modLokasi->search(),
	'filter'=>$modLokasi,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',                
                'value'=>function($data){    
                    $dt['lokasi_id'] = $data->lokasi_id;
                    $dt['lokasiaset_kode'] = $data->lokasiaset_kode;
                    $dt['lokasiaset_namalokasi'] = $data->lokasiaset_namalokasi;

                    $res = json_encode($dt);
                    return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                "id" => "selectObat",
                                "onClick" => "
                                            setLokasi(".$res.")
                                            return false;"));
                },
            ),
            'ruangan_nama',
            'lokasiaset_namalokasi',                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

?>

<script>
    var setLokasi = (data) => {
        
        $(".lokasi_id").val(data.lokasi_id);
        $(".lokasiaset_namalokasi").val(data.lokasiaset_namalokasi);
   
        $("#dialogLokasi").dialog("close");
    }
</script>