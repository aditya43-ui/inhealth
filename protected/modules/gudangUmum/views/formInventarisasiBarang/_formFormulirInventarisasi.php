<div class="row form-horizontal">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'forminvbarang_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->forminvbarang_tgl = (!empty($model->forminvbarang_tgl) ? date("d/m/Y H:i:s", strtotime($model->forminvbarang_tgl)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'forminvbarang_tgl',
                    'mode' => 'datetime',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'forminvbarang_totalvolume', array('class' => 'span3 integer2')); ?>
        <?php echo $form->textFieldRow($model, 'forminvbarang_totalharga', array('class' => 'span3 integer2')); ?>
    </div>
</div>