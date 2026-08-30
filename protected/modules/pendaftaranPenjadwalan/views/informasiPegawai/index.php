<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('PPPegawai-m', {
		data: $(this).serialize()
	});
	return false;
});
"); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pegawai',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Pegawai</b>
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
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'type' => 'horizontal',
                    'focus' => '#' . CHtml::activeId($modPPPegawaiM, 'nama_pegawai'),
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                )); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($modPPPegawaiM, 'nomorindukpegawai', array('placeholder' => 'No. Induk Pegawai', 'class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 15)); ?>
                        <?php echo $form->textFieldRow($modPPPegawaiM, 'nama_pegawai', array('placeholder' => 'Nama Pegawai', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <?php echo $form->dropDownListRow(
                            $modPPPegawaiM,
                            'pendidikan_nama',
                            LookupM::getItems('kategoripegawai'),
                            array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            )
                        ); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow(
                            $modPPPegawaiM,
                            'pangkat_id',
                            CHtml::listData($modPPPegawaiM->getPangkatItems(), 'pangkat_id', 'pangkat_nama'),
                            array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            )
                        ); ?>
                        <?php echo $form->dropDownListRow(
                            $modPPPegawaiM,
                            'kelompokpegawai_id',
                            CHtml::listData($modPPPegawaiM->getKelompokPegawaiItems(), 'kelompokpegawai_id', 'kelompokpegawai_nama'),
                            array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            )
                        ); ?>
                        <?php echo $form->dropDownListRow(
                            $modPPPegawaiM,
                            'jabatan_id',
                            CHtml::listData($modPPPegawaiM->getJabatanItems(), 'jabatan_id', 'jabatan_nama'),
                            array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            )
                        ); ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <!-- <?php echo CHtml::link(
                                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                                $this->createUrl('informasiPegawai/index'),
                                array('title' => 'Ulang', 'class' => 'btn btn-default')
                            ); ?> -->
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array(
                            'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasiPegawai', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Informasi Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'PPPegawai-m',
                    'dataProvider' => $modPPPegawaiM->search(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        'nomorindukpegawai',
                        array(
                            'name' => 'nama_pegawai',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=icon-form-lihat></i>", Yii::app()->createUrl("pendaftaranPenjadwalan/InformasiPegawai/viewPegawai",array("id"=>"$data->pegawai_id")), array("rel"=>"tooltip","title"=>"Klik untuk Melihat Data Pegawai Lebih Lanjut"))." ".CHtml::link($data->nama_pegawai, Yii::app()->createUrl("pendaftaranPenjadwalan/InformasiPegawai/viewPegawai",array("id"=>"$data->pegawai_id")))',
                            'htmlOptions' => array('style' => 'text-align: left')
                        ),
                        'tempatlahir_pegawai',
                        array(
                            'name' => 'tgl_lahirpegawai',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
                        ),
                        'alamat_pegawai',
                        'jeniskelamin'
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>