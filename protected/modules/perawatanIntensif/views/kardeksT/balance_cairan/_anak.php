<div class="col-sm-6">
	<?php echo $form->textFieldRow($model,'balance_konstanta',array('class'=>'span1 float2 balance_konstanta', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model,'balance_usia',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'balance_usia',array('class'=>'span1 float2 balance_usia', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <label>Tahun</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model,'balance_jmlcairan',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'balance_jmlcairan',array('class'=>'span2 float2 balance_jmlcairan', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <label>cc/Kg BB/hari</label>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'balance_iwl',array('readonly'=>true, 'class'=>'span2 float2 balance_iwl', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    
</div>
<div class="col-sm-6">
    <?php echo $form->textFieldRow($model,'balance_total_intake',array('class'=>'span2 float2 balance_total_intake', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model,'balance_total_output',array('class'=>'span2 float2 balance_total_output', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model,'balance_total_sekarang',array('readonly'=>true, 'class'=>'span2 float2 balance_total_sekarang', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model,'balance_total_sebelum',array('class'=>'span2 float2neg balance_total_sebelum', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model,'balance_total_komulatif',array('class'=>'span2 float2 balance_total_komulatif', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    
</div>
<div class="clear"></div>
<div class="col-sm-12">
    <div class="control-group">
        <?php echo $form->labelEx($model,'balance_konstanta_suhu',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'balance_konstanta_suhu',array('class'=>'span1 float2 balance_konstanta_suhu', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <label>%</label>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'balance_kenaikan_suhu',array('class'=>'span2 float2 balance_kenaikan_suhu', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($model,'balance_iwl_kenaikan_suhu',array('readonly'=>true, 'class'=>'span2 float2 balance_iwl_kenaikan_suhu', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    
</div>	