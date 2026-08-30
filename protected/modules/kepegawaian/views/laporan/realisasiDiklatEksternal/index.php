<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#laporan-search').submit(function(){
	$.fn.yiiGridView.update('laporan-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Realisasi Pelatihan Eksternal</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'laporan-search',
                    'type' => 'horizontal',
                )); ?>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tgl_awal', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'changeYear' => true,
                                        'changeMonth' => true,
                                        'yearRange' => '-70y:+4y',
                                        'maxDate' => 'd',
                                        'showAnim' => 'fold',
                                        'timeText' => 'Waktu',
                                        'hourText' => 'Jam',
                                        'minuteText' => 'Menit',
                                        'secondText' => 'Detik',
                                        'showSecond' => true,
                                        'timeFormat' => 'hh:mm:ss',

                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3 dtPicker3',
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'nama_pegawai', array('class' => 'span3', 'maxlength' => 30)); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tgl_akhir', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'changeYear' => true,
                                        'changeMonth' => true,
                                        'yearRange' => '-70y:+4y',
                                        'maxDate' => 'd',
                                        'showAnim' => 'fold',
                                        'timeText' => 'Waktu',
                                        'hourText' => 'Jam',
                                        'minuteText' => 'Menit',
                                        'secondText' => 'Detik',
                                        'showSecond' => true,
                                        'timeFormat' => 'hh:mm:ss',

                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3 dtPicker3',
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <?php // echo $form->dropDownListRow($model,'jabatan_id',CHtml::listData($model->getJabatanItems(),'jabatan_id','jabatan_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); 
                        ?>
                    </div>
                </div>

                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/Laporan/laporanPenggajian'),
                        array('class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')
                    ); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Realisasi Pelatihan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('realisasiDiklatEksternal/_table', array('model' => $model)); ?>
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintLaporanPenggajian');
                $url = ""; //?
                $this->renderPartial('_footerWithoutgrafik', array('urlPrint' => $urlPrint, 'url' => $url));
                ?>
            </div>
        </div>
    </div>
</div>