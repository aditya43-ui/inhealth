<div class="row" style="margin-top: 20px;">
    <div class="col-md-6">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    Xpert MTB/RIF
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($modTerdugaTb, 'tglhasil_xpertmtbrif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modTerdugaTb,
                            'attribute' => 'tglhasil_xpertmtbrif',
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
                <?php echo $form->dropDownListRow($modTerdugaTb, 'hasil_xpertmtbrif',  LookupM::getItems('hasiltb'), array('empty' => '-- Pilih --', 'class' => 'span4')) ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    Biakan
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($modTerdugaTb, 'tglhasil_biakan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modTerdugaTb,
                            'attribute' => 'tglhasil_biakan',
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
                <?php echo $form->dropDownListRow($modTerdugaTb, 'hasil_biakan',  LookupM::getItems('hasiltb'), array('empty' => '-- Pilih --', 'class' => 'span4')) ?>
            </div>
        </div>
    </div>
</div>