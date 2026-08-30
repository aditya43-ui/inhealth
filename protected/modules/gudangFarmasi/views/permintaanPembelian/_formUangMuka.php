<div class="row-fluid">
    <div class = "col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Tgl. Permintaan Uang Muka <span class="required">*</span>', 'tglpermintaanuangmuka', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php
                    $model->tglpermintaanuangmuka = (!empty($model->tglpermintaanuangmuka) ? date("d/m/Y H:i:s",strtotime($model->tglpermintaanuangmuka)) : null);
                    $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpermintaanuangmuka',
                            'mode' => 'datetime',
                            'options' => array(
                                    'showOn' => false,
                                    'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly'=>true, 'placeholder' => '00/00/0000', 'class' => 'dtPicker2 span3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                    ));
                ?>
            </div>
        </div>
    </div>
    <div class = "col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Jumlah Uang Muka <span class="required">*</span>', 'jmlpermintaanuangmuka', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jmlpermintaanuangmuka', array('class' => 'span3 integer-decimal','onkeyup' => "return $(this).focusNextInputField(event)",'onblur'=>'checkuangmuka()')) ?>
            </div>
        </div>
    </div>
</div>