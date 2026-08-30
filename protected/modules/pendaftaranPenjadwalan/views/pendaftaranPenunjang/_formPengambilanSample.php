<div>   
    <?php echo $form->dropDownListRow($modPengambilanSample,'samplelab_id', CHtml::listData($modPengambilanSample->getSampleLabItems(), 'samplelab_id', 'samplelab_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
    <?php echo $form->textFieldRow($modPengambilanSample,'no_pengambilansample', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPengambilanSample,'jmlpengambilansample', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <div class='control-group'>
        <?php echo $form->labelEx($modPengambilanSample,'tempatsimpansample', array('class'=>'control-label')); ?>
        <div class='controls'>
            <?php echo $form->textField($modPengambilanSample,'tempatsimpansample', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
        <?php //echo $form->textFieldRow($modPengambilanSample,'tempatsimpansample', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textAreaRow($modPengambilanSample,'keterangansample', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
</div>