<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model, 'nilaipenerimaananggaran', array('class' =>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'nilaipenerimaananggaran',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<?php echo $form->hiddenField($model,'digitnilai',array('class'=>'span3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)) ?>
				<span id="digit"></span>
			</div>
		</div>
	</div>
	
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model, 'berapaxpenerimaan', array('class' =>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'berapaxpenerimaan',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<?php echo CHtml::label('kali / tahun',''); ?>
			</div>
			<div style="margin-left:250px; margin-top: -5px;">
				<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Hitung',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),
						array('onclick'=>'tambahRencana();return false;',
							  'onkeypress'=>'tambahRencana();return false;',
							  'class' => 'btn btn-danger',
							  'rel'=>"tooltip",
							  'title'=>"Klik untuk hitung",)); ?>
			</div> 
		</div>
	</div>
</div>
