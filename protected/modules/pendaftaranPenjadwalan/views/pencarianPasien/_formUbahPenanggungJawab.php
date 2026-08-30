 <?php echo $form->errorSummary($model); ?>
<table class="table">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'pengantar', LookupM::getItems('pengantar'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'nama_pj', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'jenisidentitas', LookupM::getItems('jenisidentitas'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'no_identitas', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'no_identitas_pj', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'hubungankeluarga', LookupM::getItems('hubungankeluarga'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'tempatlahir_pj', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php //echo $form->textFieldRow($model,'tgllahir_pj', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model,'tgllahir_pj', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgllahir_pj',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onkeypress'=>"return $(this).focusNextInputField(event)"),
                    )); ?>
                    <?php echo $form->error($model, 'tgllahir_pj'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'alamat_pj', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'no_teleponpj', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'no_mobilepj', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>
</table>
    
    