<?php
$url = Yii::app()->createUrl('mcu/LaporanKunjungan/FrameGrafik&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('#searchLaporan').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('tableLaporan', {
            data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Laporan <b>Kunjungan Pasien</b></legend>
    <div class="box search-form">
        <?php 
            $this->renderPartial($this->path_view_mcu.'_search',array(
            'model'=>$model,
            )); 
        ?>
    </div>
    <div class="block-tabel">
        <h6>Tabel <b>Kunjungan Pasien</b></h6>
        <?php $this->renderPartial($this->path_view_mcu.'_table', array('model'=>$model)); ?>
    </div>
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $this->renderPartial($this->path_view_mcu.'_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
</div>
<?php 
//========= Dialog buat cari data Pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Pencarian Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>500,
        'height'=>600,
		'zIndex'=>1002,
        'resizable'=>false,
    ),
));
?>
<?php
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'dokter-grid',
		'dataProvider'=>$modDokter->searchDokterDialog(),
		'filter'=>$modDokter,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
								"href"=>"",
								"id" => "selectDokter",
								"onClick" => "
											  $(\"#'.CHtml::activeId($model,'nama_pegawai').'\").val(\"$data->nama_pegawai\");
											  $(\"#dialogDokter\").dialog(\"close\"); 
											  return false;
									"))',
			),
			array(
				'header'=>'Nama Dokter',
				'name'=>'nama_pegawai',
				'value'=>'$data->nama_pegawai',
			),
		),
			'afterAjaxUpdate' => 'function(id, data){
			jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
	));
?>
<?php
$this->endWidget();
//========= end Dokter dialog =============================
?>