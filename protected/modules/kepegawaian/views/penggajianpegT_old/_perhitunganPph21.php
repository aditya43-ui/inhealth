<fieldset id="fieldsetpph21" class="">
	<div class="control-group">
		<?php echo $form->labelEx($model,'Gaji dan Tunjangan', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'gajipph',array('class'=>'inputFormTabel currency', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->hiddenField($model,'persentasepph21',array('class'=>'inputFormTabel currency', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->hiddenField($model,'kodeptkp',array('class'=>'inputFormTabel', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			/ Tahun
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'Biaya Jabatan (5%)', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'biayajabatan',array('class'=>'inputFormTabel currency', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			Maks. 6.000.000 / Tahun
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'Iuran Pensiun', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'iuranpensiun',array('class'=>'inputFormTabel currency', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			Maks. 2.400.000 / Tahun
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'Penerimaan Bersih', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'penerimaanpph',array('class'=>'inputFormTabel currency', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			/ Tahun
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'PTKP', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'ptkp',array('class'=>'inputFormTabel currency', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'PKP', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'pkp',array('class'=>'inputFormTabel currency', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'', array('class'=>'control-label', 'id'=>'label_persen')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'pphpersen',array('class'=>'inputFormTabel currency', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			/ Tahun
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'PPh 21', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'pph21',array('class'=>'inputFormTabel currency', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			/ Bulan
		</div>
	</div>
</fieldset>

<script type="text/javascript">
	function setPtkp(pegawai_id){
        $.ajax({
	        type:'POST',
	        url:'<?php echo $this->createUrl('SetPtkp'); ?>',
	        data: { pegawai_id: pegawai_id},
	        dataType: "json",
	        success:function(data){
	            if(data.status="ada"){
	                $('#<?php echo CHtml::activeId($model,"ptkp") ?>').val(data.ptkp);
	            }
	        },
	        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	    });
    }
</script>