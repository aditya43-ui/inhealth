<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'lksamplelab-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#LKSamplelabM_samplelab_nama',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'samplelab_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nama Sampel')); ?>
        <?php echo $form->checkBoxRow($model, 'samplelab_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>

    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'samplelab_namalainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nama Lainnya')); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array(
            'class' => 'btn btn-danger',
            'type' => 'submit',
            'title' => 'Simpan',
            'onKeypress' => 'return formSubmit(this,event)'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Sampel Lab', array('{icon}' => '<i class="icon-file icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('LKSamplelabM_samplelab_namalainnya').value = nama.value.toUpperCase();
    }
</script>