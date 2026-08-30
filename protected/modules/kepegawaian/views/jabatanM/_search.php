<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sajabatan-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jabatan_nama', array('placeholder' => 'Jabatan', 'class' => 'span3', 'maxlength' => 20)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jabatan_lainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'maxlength' => 20)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'jabatan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jabatan_aktif', array('checked' => 'jabatan_aktif', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <label for="KPJabatanM_jabatan_aktif">Aktif</label>
            </div>
        </div>
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