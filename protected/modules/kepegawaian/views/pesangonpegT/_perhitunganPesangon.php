<fieldset id="fieldsetpesangon" class="">
        <div class="control-group">
                <?php echo CHtml::label('Pesangon', 'gajipokok', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'gajipokok',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
        <div class="control-group">
		<?php echo CHtml::label('PPh 21', 'pph21', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'pph21',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->hiddenField($model,'persentasepph21',array('class'=>'inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->hiddenField($model,'kodeptkp',array('class'=>'inputFormTabel', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->hiddenField($model,'ptkp',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
</fieldset>

<script type="text/javascript">
	function setPtkp(pegawai_id){
        $.ajax({
	        type:'POST',
	        url:'<?php echo $this->createUrl('SetPtkpNew'); ?>',
	        data: { pegawai_id: pegawai_id},
	        dataType: "json",
	        success:function(data){
	            if(data.status="ada"){
	                $('#<?php echo CHtml::activeId($model,"ptkp") ?>').val(formatNumber(data.ptkp));
                    }
	        },
	        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	    });
    }

</script>