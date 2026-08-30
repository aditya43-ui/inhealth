<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'golongan-gaji-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'kelompokpegawai_id', CHtml::listData(KPKelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true'), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", "empty" => '-- Pilih --')); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'periodeharikerjaawl', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'periodeharikerjaawl', CustomFunction::getNamaHari(), array('class' => 'span2  required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
                <label class="controls"> sampai</label>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'periodeharikerjaakhir', CustomFunction::getNamaHari(), array('class' => 'span2  required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'harikerjagol_aktif', array('checked' => 'harikerjagol_aktif')); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>