<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'potonganpph21-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'penghasilandari', array('placeholder' => 'Penghasilan Dari', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right')); ?>
        <?php echo $form->textFieldRow($model, 'sampaidgn_thn', array('placeholder' => 'Sampai Dengan Tahun', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'persentarifpenghsl', array('placeholder' => 'Persentase Tarif Penghasilan', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right')); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Potongan PPh 21', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>