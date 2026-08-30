<?php
$this->breadcrumbs = array(
    'Informasi Pembatalan Permintaan Pembelian Bahan Makanan',
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
            <i class="entypo-info-circled"></i> Informasi <b>Pembatalan Permintaan Pembelian Bahan Makanan</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pembatalan Permintaan Pembelian Bahan Makanan</b>
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
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("rincian",array("id"=>$data->permintaanpembelian_id,"frame"=>TRUE)),array("id"=>"$data->permintaanpembelian_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk melihat Rincian Permintaan Pembelian Bahan Makanan", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: left')
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Rincian Permintaan Pembelian Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1100,
        'height' => 500,
        'resizable' => false,
    ),
));
// echo '<iframe src="" name="frameDetail" width="100%" height="100%" onload="javascript:resizeIframe(this);"></iframe>';
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>