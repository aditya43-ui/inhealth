<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ppjadwal-hemodialisa-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Jadwal Pasien Hemodialisa',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Jadwal Pasien Hemodialisa</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
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
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jadwal Pasien Hemodialisa</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                    'id' => 'ppjadwal-hemodialisa-t-grid',
                    'dataProvider' => $model->searchJadwalHD(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'mergeColumns' => array('jadwalhemodialisa_hari', 'jadwalhemodialisa_tgl_ke', 'shift_id'),
                    'columns' => array(
                        array(
                            'header' => 'Hari / Tanggal',
                            'name' => 'jadwalhemodialisa_hari',
                            'type' => 'raw',
                            'value' => '$data->jadwalhemodialisa_hari." / ".MyFormatter::formatDateTimeForUser($data->jadwalhemodialisa_tgl_ke)',
                        ),
                        array(
                            'header' => 'Shift',
                            'name' => 'shift_id',
                            'type' => 'raw',
                            'value' => '$data->shift->shift_nama',
                        ),
                        array(
                            'header' => 'Ruangan',
                            'name' => 'ruangan_id',
                            'type' => 'raw',
                            'value' => '$data->getNamaRuangan()',
                        ),
                        array(
                            'header' => 'No. R.M',
                            'type' => 'raw',
                            'value' => '$data->pasienrl->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->pasienrl->nama_pasien',
                        ),
                        array(
                            'header' => 'Jenis Kelamin',
                            'type' => 'raw',
                            'value' => '$data->pasienrl->jeniskelamin',
                        ),
                        array(
                            'header' => 'Umur',
                            'type' => 'raw',
                            'value' => 'CustomFunction::getUmur($data->pasienrl->tanggal_lahir)',
                        ),
                        array(
                            'header' => 'No. Handphone',
                            'type' => 'raw',
                            'value' => '$data->pasienrl->no_mobile_pasien',
                        ),
                        array(
                            'header' => 'Alamat',
                            'type' => 'raw',
                            'value' => '$data->pasienrl->alamat_pasien',
                        ),
                        array(
                            'header' => 'Deskripsi',
                            'type' => 'raw',
                            'value' => '$data->getDeskripsiUbah($data->gantijadwalhd_id)',
                        ),
                        array(
                            'header' => 'Ubah',
                            'type' => 'raw',
                            'value' => '(!empty($data->pendaftaran_id)) ? "Sudah Daftar" :
                               CHtml::link("<i class=\'entypo-pencil\'></i>", 
                               Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/ubahJadwal",array("jadwalhemodialisa_id"=>$data->jadwalhemodialisa_id)),
                                   array("title"=>"Klik untuk Ubah Jadwal Hemodialisa", "target"=>"iframeUbahJadwal", "onclick"=>"$(\"#dialogUbahJadwal\").dialog(\"open\");", "rel"=>"tooltip"))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => '(!empty($data->pendaftaran_id)) ? "Sudah Daftar" : 
                               CHtml::link("<i class=\'glyphicon glyphicon-remove-circle\'></i>", 
                               Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/batalJadwal",array("jadwalhemodialisa_id"=>$data->jadwalhemodialisa_id)),
                                   array("title"=>"Klik untuk Batal Jadwal Hemodialisa", "target"=>"iframeBatalJadwal", "onclick"=>"$(\"#dialogBatalJadwal\").dialog(\"open\");", "rel"=>"tooltip"))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Pendaftaran',
                            'type' => 'raw',
                            'value' => '(!empty($data->pendaftaran_id)) ? "Sudah Daftar" : 
                               CHtml::link("<i class=\'glyphicon glyphicon-log-in\'></i>", 
                               Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/pendaftaranRawatDaruratHD/index",array("jadwalhemodialisa_id"=>$data->jadwalhemodialisa_id)),
                                   array("title"=>"Klik untuk Mendaftarkan Pasien HD", "rel"=>"tooltip"))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
// Dialog untuk batal jadwal hemodialisa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatalJadwal',
    'options' => array(
        'title' => 'Pembatalan Jadwal Hemodialisa',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 850,
        'height' => 600,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeBatalJadwal" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk ubah jadwal hemodialisa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUbahJadwal',
    'options' => array(
        'title' => 'Perubahan Jadwal Hemodialisa',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 850,
        'height' => 400,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeUbahJadwal" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>