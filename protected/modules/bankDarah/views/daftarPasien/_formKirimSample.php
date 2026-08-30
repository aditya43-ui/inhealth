<fieldset class="box2" id="kirimSample">
    <legend class="rim">
        <?php echo $form->checkBox($modKirimSample, '[' . $i . ']isKirimSample', array('onclick' => 'enableInputSample(this)')); ?>Kirim Sampel</legend>
    <?php
    echo $form->dropDownListRow($modKirimSample, '[' . $i . ']labklinikrujukan_id', CHtml::listData($modKirimSample->LabKlinikRujukanItems, 'labklinikrujukan_id', 'labklinikrujukan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
        'empty' => '-- Pilih --'));
    ?>
    <?php echo $form->textFieldRow($modKirimSample, '[' . $i . ']nokirimsample', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modKirimSample, '[' . $i . ']tglkirimsample', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $modKirimSample,
                'attribute' => '[' . $i . ']tglkirimsample',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
            <?php echo $form->error($modKirimSample, '[' . $i . ']tglkirimsample'); ?>
        </div>
    </div>
    <?php echo $form->textAreaRow($modKirimSample, '[' . $i . ']keterangan_kirim', array('rows' => 6, 'cols' => 50, 'class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
</fieldset>



