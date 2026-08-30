<?php 
//========= Dialog buat cari data pemeriksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPemeriksa',
    'options'=>array(
        'title'=>'Petugas',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>440,
        'resizable'=>false,
    ),
));
?> 
<?php echo CHtml::hiddenField('baris', '', array('id'=>'rowTindakan','readonly'=>true)) ?>
<?php 
    $pegawai = new DokterpegawaiV('searchByDokter');
    if (isset($_GET['DokterpegawaiV'])){
        $pegawai->attributes = $_GET['DokterpegawaiV'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'giladiagnosa-m-grid',
    'dataProvider'=>$pegawai->searchByDokter(),
    'filter'=>$pegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-condensed',
    'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                "id" => "selectObat",
                                "href"=>"",
                                "onClick"=>"setDokterBaru($data->pegawai_id, this);return false;",
                               // "onClick" => "setTindakanAuto($data->kelaspelayanan_id,$data->daftartindakan_id);return false;"
                               ))',
            ),
//            'pegawai_id',
            'gelardepan',
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Dokter',
            ),
            'gelarbelakang_nama',
            'jeniskelamin',
            'agama',
//            'kelaspelayanan_id',
//            array(
//                'header'=>'Kategori',
//                'name'=>'kategoritindakan_nama',
//                'value'=>'$data["kategoritindakan_nama"]',
//            ),
////            array(
////                'header'=>'Kode',
////                'name'=>'daftartindakan_kode',
////                'value'=>'$data["daftartindakan_kode"]',
////            ),
//            array(
//                'header'=>'Nama Tindakan',
//                'name'=>'daftartindakan_nama',
//                'value'=>'$data["daftartindakan_nama"]',
//            ),
//            array(
//                'header'=>'Harga',
//                'value'=>'number_format($data["harga_tariftindakan"])',
//                'htmlOptions'=>array('style'=>'text-align:right'),
//            ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?>
<?php

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end pemeriksa dialog =============================
?>  

<script>
    function setDokterBaru(idPegawai,obj){
        $(obj).parents("tbody").find("tr").removeClass("yellow_background");
        $.get("<?php echo Yii::app()->createUrl('perawatanIntensif/tindakanTPI/GetDokter'); ?>",{idPegawai:idPegawai},function(data){
            $(obj).parents("tr").addClass("yellow_background");
            setDokterPemeriksa1(data[0]);
            $("#dialogPemeriksa").dialog("close");
        },"json");
    }
</script>