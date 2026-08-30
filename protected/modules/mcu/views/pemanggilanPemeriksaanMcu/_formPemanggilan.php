<div class="col-sm-6">
    <br>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Pemanggilan MCU', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $modPemanggilan->tglpemanggilanmcu = (!empty($modPemanggilan->tglpemanggilanmcu) ? date('d/m/Y H:i:s',  strtotime($modPemanggilan->tglpemanggilanmcu)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $modPemanggilan,
                'attribute' => 'tglpemanggilanmcu',
                'mode' => 'datetime',
                'options' => array(
                    'showOn' => false,
                    'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'class' => 'dtPicker2 datetimemask', 'placeholder' => '00/00/0000 00:00:00', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Akan Pemanggilan MCU', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $modPemanggilan->tglakanperiksamcu = (!empty($modPemanggilan->tglakanperiksamcu) ? date('d/m/Y H:i:s',  strtotime($modPemanggilan->tglakanperiksamcu)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $modPemanggilan,
                'attribute' => 'tglakanperiksamcu',
                'mode' => 'datetime',
                'options' => array(
                    'showOn' => false,
                    'minDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'class' => 'dtPicker2 datetimemask', 'placeholder' => '00/00/0000 00:00:00', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
        </div>
    </div>

</div>
<div class="col-sm-6">
    <br>
    <?php echo $form->textFieldRow($modPemanggilan, 'no_pemanggilan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
    <?php echo $form->textAreaRow($modPemanggilan, 'keterangan_pemanggilan', array('placeholder' => 'Keterangan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
</div>