<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow(
            $model,
            'bank_id',
            CHtml::listData(AKBankM::model()->findAll('bank_aktif is true order by namabank asc'), 'bank_id', 'namabank'),
            array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setSaldoBank(this);')
        ); ?>
        <div class="control-group">
            <?php echo CHtml::label('Saldo pada Bank', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'rekonsiliasibank_saldobank', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Saldo Kas pada Pembukuan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'rekonsiliasibank_saldokas', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'rekonsiliasibank_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->rekonsiliasibank_tgl = (!empty($model->rekonsiliasibank_tgl) ? date("d/m/Y H:i:s", strtotime($model->rekonsiliasibank_tgl)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'rekonsiliasibank_tgl',
                    'mode' => 'datetime',
                    'options' => array(
                        'showOn' => false,
                        'minDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker2 datetimemask span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'rekonsiliasibank_tgl'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'rekonsiliasibank_no', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
    </div>
</div>