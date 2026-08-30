<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saasal-rujukan-m-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('onsubmit' => 'return requiredCheck(this);'),
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'asalrujukan_nama'),
)); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'asalrujukan_nama', array('placeholder' => 'Asal Rujukan', 'class' => 'span3 form-control hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'asalrujukan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'asalrujukan_aktif', array('checked' => 'checked')); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'asalrujukan_institusi', array('placeholder' => 'Rujukan Institusi', 'class' => 'span3  form-control  hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'asalrujukan_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3 form-control  hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
    </div>
</div>


<?php //echo $form->checkBoxRow($model,'asalrujukan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Asal Rujukan', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>