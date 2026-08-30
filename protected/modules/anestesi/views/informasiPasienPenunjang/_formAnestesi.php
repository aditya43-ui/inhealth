<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pasienanastesi-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
));
$this->widget('bootstrap.widgets.BootAlert');?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.'); ?></p>
	<?php echo $form->errorSummary(array($modPasienAnestesi)); ?>
    
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group ">
				<?php echo $form->labelEx($modPasienAnestesi,'tglanastesi', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php   
						$this->widget('MyDateTimePicker',array(
							'model'=>$modPasienAnestesi,
							'attribute'=>'tglanastesi',
							'mode'=>'datetime',
							'options'=> array(
							),
							'htmlOptions'=>array('class'=>'dtPicker3','placeholder'=>'00:00:0000 00:00:00'),
						));
					?>
					<?php echo $form->error($modPasienAnestesi, 'tglanastesi'); ?> 
				</div>
			</div>
			<?php echo $form->textFieldRow($modPasienAnestesi,'noanestesi',array('class'=>'span3','readonly'=>true)); ?>
		</div>
		<div class="span6">
			
		</div>
	</div>
        
    <div class="form-actions">
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
				array('class'=>'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>

        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
				array('class'=>'btn btn-default','onclick'=>"window.parent.$('#dialogStatusDokumen').dialog('close');")); ?>
    </div>
<?php $this->endWidget(); ?>