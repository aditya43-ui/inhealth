<div class="panel panel-success" id="kirimSample">
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo $form->checkBox($modKirimSample, '[' . $i . ']isKirimSample', array('onclick' => 'enableInputSample(this)')); ?> Kirim Sampel
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <?php
                echo $form->dropDownListRow($modKirimSample, '[' . $i . ']labklinikrujukan_id', CHtml::listData($modKirimSample->LabKlinikRujukanItems, 'labklinikrujukan_id', 'labklinikrujukan_nama'), array(
                    'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --'
                ));
                ?>
                <?php echo $form->textFieldRow($modKirimSample, '[' . $i . ']nokirimsample', array('readonly' => true, 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
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
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'dtPicker1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'width' => '140px;'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($modKirimSample, '[' . $i . ']tglkirimsample'); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($modKirimSample, '[' . $i . ']alasan_kirim', LookupM::getItems('alasanlab_dirujuk'), array('maxlength' => 200, 'rows' => 6, 'cols' => 50, 'class' => 'span3 autogrow', 'onkeyup' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')); ?>
                <?php echo $form->textAreaRow($modKirimSample, '[' . $i . ']keterangan_kirim', array('rows' => 6, 'cols' => 50, 'class' => 'span3 autogrow', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>