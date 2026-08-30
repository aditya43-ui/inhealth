<?php
$this->breadcrumbs = array(
    'Barang Pecah Belah' => array('create'),
    'Informasi',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#barangpecahbelah-t-search').submit(function(){
	$.fn.yiiGridView.update('barangpecahbelah-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pencatatan Barang Pecah Belah</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pencatatan Barang Pecah Belah</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'barangpecahbelah-t-grid',
                    'dataProvider' => $model->searchInformasi(),
                    //'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                    : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        'barangpecahbelah_no',
                        array(
                            'name' => 'barangpecahbelah_tgl',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->barangpecahbelah_tgl)',
                        ),
                        array(
                            'header' => 'Instalasi',
                            'name' => 'ruangan.instalasi.instalasi_nama'
                        ),
                        array(
                            'header' => 'Ruangan',
                            'name' => 'ruangan.ruangan_nama'
                        ),
                        'keterangan',
                        array(
                            'header' => 'Menerima',
                            'name' => 'pegmenerima.nama_pegawai'
                        ),
                        array(
                            'header' => 'Mengetahui',
                            'name' => 'pegmengetahui.nama_pegawai'
                        ),
                        array(
                            'header' => Yii::t('zii', 'Detail'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'icon' => 'icon-form-view',
                                    'options' => array('target' => 'frameDetail', 'title' => 'Detail Pencatatan'),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("barangpecahbelah_id"=>$data->barangpecahbelah_id))',
                                    'click' => "function(){ $(\"#dialogDetail\").dialog(\"open\"); }",
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Batal',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'options' => array('title' => Yii::t('mds', 'Batal Pencatatan')),
                                    'icon' => "icon-form-silang",
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog Detail Konsultasi Gizi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pencatatan Barang Pecah Belah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 510,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="frameDetail" id="detailDialog" style="width: 100%; height: 98%;" onload="javascript:resizeIframe(this);"></iframe>
<?php
$this->endWidget();
?>