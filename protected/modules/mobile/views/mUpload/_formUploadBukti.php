<?php 
$this->widget('bootstrap.widgets.BootAlert');
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'buktipembayaran-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('enctype' => 'multipart/form-data', 'onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>
<div class="row">
    <span style="font-size: 15px;">Silakan unggah foto bukti transfer agar dapat dilakukan verifikasi oleh pihak rumah sakit!</span>
    <div class="control-group ">
    <?php echo CHtml::label("", '', array('class' => 'control-label', 'style'=>'font-size: 14px;')); ?>
        <div class="controls">
        <?php echo $form->fileField($model, 'bukti_pembayaran', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
        </div>
    </div>
</div>
<div class="row-fluid" style="text-align: right;">
    <?php 
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
    ?>
</div>
    
<?php $this->endWidget(); ?>


