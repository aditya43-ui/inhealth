
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'propinsi-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#PropinsiM_propinsi_nama',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($modelPropinsi); ?>

	<?php echo $form->textFieldRow($modelPropinsi,'propinsi_nama',array('size'=>25,'maxlength'=>25)); ?>

	<?php echo $form->textFieldRow($modelPropinsi,'propinsi_namalainnya',array('size'=>25,'maxlength'=>25)); ?>
		
	<div class="form-actions">
                <?php echo CHtml::htmlButton($modelPropinsi->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                       Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                                        array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
	</div>

<?php $this->endWidget(); ?>
