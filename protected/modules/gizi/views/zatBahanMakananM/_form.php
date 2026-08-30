<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzpropinsi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#ZatBahanMakananM_zatgizi_id',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow(
            $model,
            'zatgizi_id',
            CHtml::listData($model->ZatgiziItems, 'zatgizi_id', 'zatgizi_nama'),
            array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)
        ); ?>
        <?php echo $form->dropDownListRow(
            $model,
            'bahanmakanan_id',
            CHtml::listData($model->BahanMakananItems, 'bahanmakanan_id', 'namabahanmakanan'),
            array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)
        ); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kandunganbahan', array('placeholder' => '00', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeyUp' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/zatBahanMakananM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Zat Bahan Makanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('zatBahanMakananM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>