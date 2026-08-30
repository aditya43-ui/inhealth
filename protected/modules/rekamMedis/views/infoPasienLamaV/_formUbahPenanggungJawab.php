<div class="row">
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'pengantar', LookupM::getItems('pengantar'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'nama_pj', array('placeholder' => 'Nama', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->dropDownListRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->dropDownListRow($model, 'jenisidentitas', LookupM::getItems('jenisidentitas'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'no_identitas', array('placeholder' => 'No. Identitas', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'no_identitas_pj', array('placeholder' => 'No. Identitas Penanggung Jawab', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'hubungankeluarga', LookupM::getItems('hubungankeluarga'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'tempatlahir_pj', array('placeholder' => 'Tempat Lahir', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php //echo $form->textFieldRow($model,'tgllahir_pj', array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tgllahir_pj', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgllahir_pj',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                )); ?>
                <?php echo $form->error($model, 'tgllahir_pj'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'alamat_pj', array('placeholder' => 'Alamat', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'no_teleponpj', array('placeholder' => 'No. Telepon', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'no_mobilepj', array('placeholder' => 'No. Handphone', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>