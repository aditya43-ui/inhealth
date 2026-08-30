<?php echo $form->textFieldRow($model,'nostruk_trf',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<div class='control-group'>
	<?php echo CHtml::label('Tgl. Transfer', 'tgltransfer', array('class' => 'control-label')) ?>
	<div class="controls">
		<?php $model->tgltransfer = MyFormatter::formatDateTimeForUser($model->tgltransfer); ?>
		<?php 
			$this->widget('MyDateTimePicker', array(
				'model' => $model,
				'attribute' => 'tgltransfer', 
				'mode'=>'date',
				'options'=>array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,
					'class' => "span2",
					'onkeypress' => "return $(this).focusNextInputField(event)"),
			));  
		?>
	</div>
</div>
<?php echo $form->textFieldRow($model,'namabank_trf',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model,'norek_trf',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model,'atasnama_trf',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>