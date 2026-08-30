<div class="row">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'tglrenanggaranpen',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
		<?php echo $form->textFieldRow($model,'noren_penerimaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model,'Periode Anggaran', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'deskripsiperiode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
					<?php echo $form->hiddenField($model,'konfiganggaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
				</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model,'Sumber Anggaran', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'sumberanggarannama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
					<?php echo $form->hiddenField($model,'sumberanggaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
				</div>
		</div>
	</div>
</div>