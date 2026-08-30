<div class="row">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'tglalokasianggaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
		<div class="control-group">
				<?php echo $form->labelEx($model,'Periode Anggaran <span class="required">*</span>', array('class'=>'control-label required')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model, 'konfiganggaran_id', CHtml::listData(AGAlokasianggaranT::model()->getTglPeriode(), 'konfiganggaran_id', 'deskripsiperiode'), array('empty'=>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'validasiDigit();')); ?>
					<?php echo CHtml::hiddenField('konfiganggaran_id','',array('class'=>'span2 integer2','style'=>'width:90px;','readonly'=>true))?>
				</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($model,'Unit <span class="required">*</span>', array('class'=>'control-label required')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model, 'unitkerja_id', CHtml::listData(AGUnitkerjaM::model()->findAllByAttributes(array('unitkerja_aktif'=>true),array('order'=>'namaunitkerja')), 'unitkerja_id', 'unitRek'), array('empty'=>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				</div>
		</div>
	</div>
</div>