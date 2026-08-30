<?php $linkHalaman = CustomFunction::getUrlByMenuID(1233); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pemusnahan Obat dan Alkes',
);
Yii::app()->clientScript->registerScript('search', "
$('#info-pemusnahanoa-search').submit(function(){
	$.fn.yiiGridView.update('info-pemusnahanoa-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemusnahan Obat dan Alkes</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('search', array('model' => $model, 'format' => $format, 'instalasiTujuan' => $instalasiTujuan, 'ruanganAsal' => $ruanganAsal)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemusnahan Obat dan Alkes</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'info-pemusnahanoa-m-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'tglpemusnahan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemusnahan)',
                        ),
                        array(
                            'name' => 'nopemusnahan',
                            'type' => 'raw',
                            'value' => '$data->nopemusnahan',
                        ),
                        array(
                            'name' => 'instalasi_nama',
                            'type' => 'raw',
                            'value' => '$data->instalasi_nama',
                        ),
                        array(
                            'name' => 'ruangan_nama',
                            'type' => 'raw',
                            'value' => '$data->ruangan_nama',
                        ),
                        array(
                            'name' => 'pegawaimengetahui_id',
                            'type' => 'raw',
                            'value' => '$data->PegawaimengetahuiLengkap',
                        ),
                        array(
                            'name' => 'pegawaimenyetujui_id',
                            'type' => 'raw',
                            'value' => '$data->PegawaimenyetujuiLengkap',
                        ),
                        array(
                            'name' => 'keterangan',
                            'type' => 'raw',
                            'value' => '$data->keterangan',
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("InformasiPemusnahanOA/print",array("pemusnahanobatalkes_id"=>$data->pemusnahanobatalkes_id,"frame"=>true)),
											array("class"=>"", 
											"target"=>"rencana",
											"onclick"=>"$(\"#dialogPemusnahan\").dialog(\"open\");",
											"rel"=>"tooltip",
											"title"=>"Klik untuk melihat detail Pemusnahan Obat dan Alkes",
										))',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPemusnahan',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pemusnahan Obat dan Alkes',
        'autoOpen' => false,
        'minWidth' => 900,
        'height' => 460,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="rencana" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>