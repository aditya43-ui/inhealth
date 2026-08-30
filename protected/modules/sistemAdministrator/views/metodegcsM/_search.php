<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'metodegcs-m-search',
    'type' => 'horizontal',
)); ?>

<?php // echo $form->textFieldRow($model,'metodegcs_id',array('class'=>'span3 numbers-only')); 
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'metodegcs_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 300)); ?>
        <?php echo $form->textFieldRow($model, 'metodegcs_singkatan', array('placeholder' => 'Singkatan', 'class' => 'span3', 'maxlength' => 2)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'metodegcs_nilai', array('placeholder' => 'Nilai', 'class' => 'span3 numbers-only')); ?>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'metodegcs_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label for="MetodegcsM_metodegcs_aktif">Aktif</label>
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