<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'batalinvoice-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
));
$this->widget('bootstrap.widgets.BootAlert'); 
echo $form->errorSummary(array($modInvoice)); ?>

<div class="row">
	<div class="col-sm-12">

        <?php echo $form->textFieldRow($modInvoice,'tglbatal',array('class'=>'span3','readonly'=>true))?>
		<?php echo $form->hiddenField($modInvoice,'pegawaibatal_id',array('class'=>'span3','readonly'=>true))?>

		<?php echo $form->textFieldRow($modInvoice,'pegawaibatal_nama',array('class'=>'span3','readonly'=>true))?>
		<div class="control-group">
			<label for="alasanbatal" class="control-label required">Alasan Pembatalan <span class="required">*</span></label>
			<div class="controls">
					<?php echo $form->textArea($modInvoice,'alasanbatal',array('class'=>'span3'))?>
			</div>
		</div>
	
		   <div class="form-actions">
        <?php 
	 	echo CHtml::htmlButton($modInvoice->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                               Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                array('disabled'=>false,'class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); 
	?>
        <?php //echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
              //                                                  array('class'=>'btn btn-danger')); 
        ?>
    </div> 
	</div>
</div>
<?php $this->endWidget(); ?>