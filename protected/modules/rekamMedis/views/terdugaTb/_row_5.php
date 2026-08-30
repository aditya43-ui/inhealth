<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading" style="display: flex;">
                <div class="panel-title">
                    <i></i> Kesimpulan dan Tindak Lanjut
                </div>
                <div class="panel-title" style="text-align: right; margin: 3px;">
                    <i class="entypo-minus row_5" style="cursor: pointer;"></i>
                </div>
            </div>
            <div class="panel-body" id="row_5" style="display: block;">
                <div class="col-md-6">
                    <?php echo $form->dropDownListRow($modTerdugaTb, 'kesimpulan',  LookupM::getItems('kesimpulantb'), array('empty' => '-- Pilih --', 'class' => 'span4')) ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modTerdugaTb, 'tglmulaipengobatan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modTerdugaTb,
                                'attribute' => 'tglmulaipengobatan',
                                'value' => null,
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'span4',
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modTerdugaTb, 'tglselesaipengobatan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modTerdugaTb,
                                'attribute' => 'tglselesaipengobatan',
                                'value' => null,
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'span4',
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php
                    echo $form->dropDownListRow(
                        $modTerdugaTb,
                        'rujukankeluar_id',
                        CHtml::listData(RujukankeluarM::model()->findAll(array(
                            'condition' => 'rujukankeluar_aktif = true',
                            'order' => 'rumahsakitrujukan',
                        )), 'rujukankeluar_id', 'rumahsakitrujukan'),
                        array('empty' => '-- Pilih --', 'class' => 'span4')
                    );
                    ?>
                    <?php echo $form->textAreaRow($modTerdugaTb, 'keterangan', array('class' => 'span4', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?>
                </div>
            </div>
        </div>
    </div>
</div>