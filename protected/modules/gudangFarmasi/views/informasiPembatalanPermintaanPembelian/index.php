<?php
$this->breadcrumbs = array(
    'Informasi Pembatalan Permintaan Pembelian Obat dan Alkes',
);
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('informasi-batalpermintaan-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pembatalan Permintaan Pembelian Obat dan Alkes</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembatalan Permintaan Pembelian Obat dan Alkes</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasi-batalpermintaan-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No. Permintaan',
                            'type' => 'raw',
                            'value' => '$data->nopermintaan',
                        ),
                        array(
                            'header' => 'Tanggal Permintaan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpermintaanpembelian)',
                        ),
                        array(
                            'header' => 'Nama Supplier',
                            'type' => 'raw',
                            'value' => '$data->supplier_nama',
                        ),
                        array(
                            'header' => 'Pegawai Pemesan',
                            'type' => 'raw',
                            'value' => '$data->pegawaipemesan',
                        ),
                        array(
                            'header' => 'Tanggal Pembatalan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglbatalpermintaan)',
                        ),
                        array(
                            'header' => 'Alasan Pembatalan',
                            'type' => 'raw',
                            'value' => '$data->alasanbatalpermintaan',
                        ),
                        array(
                            'header' => 'Dibatalkan Oleh',
                            'type' => 'raw',
                            'value' => '$data->user_name_otoritasi',
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Rincian", array("permintaanpembelian_id"=>$data->permintaanpembelian_id)),
                                                array("class"=>"", 
                                                          "target"=>"rencana",
                                                          "onclick"=>"$(\"#dialogRencana\").dialog(\"open\");",
                                                          "rel"=>"tooltip",
                                                          "title"=>"Klik untuk melihat Rincian Permintaan Pembelian Obat Alkes",
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
    'id' => 'dialogRencana',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Rincian Permintaan Pembelian Obat Alkes',
        'autoOpen' => false,
        'minWidth' => 900,
        'height' => 320,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="rencana" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

?>