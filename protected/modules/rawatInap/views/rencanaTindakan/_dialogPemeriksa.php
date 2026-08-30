<?php 
//========= Dialog buat cari data pemeriksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPemeriksa',
    'options'=>array(
        'title'=>'Dokter Pemeriksa',
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
			'gelardepan',
			array(
				'name'=>'nama_pegawai',
				'header'=>'Nama Dokter',
			),
			'gelarbelakang_nama',
			'jeniskelamin',
			'agama',
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
        $.get("<?php echo Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'); ?>",{idPegawai:idPegawai},function(data){
            $(obj).parents("tr").addClass("yellow_background");
            setDokterPemeriksa1(data[0]);
            $("#dialogPemeriksa").dialog("close");
        },"json");
    }
</script>