<?php echo $form->textFieldRow($model,'nocek',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<div class='control-group'>
	<?php echo CHtml::label('Tgl. Cek', 'tglcek', array('class' => 'control-label')) ?>
	<div class="controls">
		<?php $model->tgltransfer = MyFormatter::formatDateTimeForUser($model->tgltransfer); ?>
		<?php 
			$this->widget('MyDateTimePicker', array(
				'model' => $model,
				'attribute' => 'tglcek', 
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
<?php echo $form->textFieldRow($model,'atasnama_cek',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model,'namabank_cek',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model,'utkkeperluan_cek',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>