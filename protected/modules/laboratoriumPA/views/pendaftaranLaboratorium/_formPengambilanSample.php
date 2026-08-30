<div>   
	<div class='control-group'>
		<?php echo $form->labelEx($modPengambilanSample,'['.$i.']samplelab_id', array('class'=>'control-label refreshable')); ?>
		<div class='controls'>
		    <?php echo $form->dropDownList($modPengambilanSample,'['.$i.']samplelab_id', CHtml::listData($modPengambilanSample->getSampleLabItems(), 'samplelab_id', 'samplelab_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
		</div>
	</div>
    <?php echo $form->textFieldRow($modPengambilanSample,'['.$i.']no_pengambilansample', array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPengambilanSample,'['.$i.']jmlpengambilansample', array('class'=>'integer','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <div class='control-group'>
        <?php echo $form->labelEx($modPengambilanSample,'['.$i.']tempatsimpansample', array('class'=>'control-label')); ?>
        <div class='controls'>
            <?php echo $form->textField($modPengambilanSample,'['.$i.']tempatsimpansample', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <?php echo $form->textAreaRow($modPengambilanSample,'['.$i.']keterangansample', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	<?php echo $form->dropDownListRow($modPengambilanSample,'['.$i.']alatmedis_id', CHtml::listData(LBAlatmedisM::getAlatLabItems(), 'alatmedis_id', 'alatmedis_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
</div>


