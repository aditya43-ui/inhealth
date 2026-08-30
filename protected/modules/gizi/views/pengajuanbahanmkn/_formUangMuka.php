<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Permintaan Uang Muka <span class="required">*</span>', 'tglpermintaanuangmuka', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php
                $model->tglpermintaanuangmuka = (!empty($model->tglpermintaanuangmuka) ? MyFormatter::formatDateTimeForUser($model->tglpermintaanuangmuka) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglpermintaanuangmuka',
                    'mode' => 'datetime',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'placeholder' => '00/00/0000', 'class' => 'dtPicker2 span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jumlah Uang Muka <span class="required">*</span>', 'jmlpermintaanuangmuka', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textField(
                    $model,
                    'jmlpermintaanuangmuka',
                    array('placeholder' => 'Jumlah Uang Muka', 'class' => 'span3 integer-decimal', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'checkuangmuka()')
                ) ?>
            </div>
        </div>
    </div>
</div>