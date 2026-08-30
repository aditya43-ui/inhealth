<div class="control-group ">
        <?php 
        
        $model->tgljatuhtempo =MyFormatter::formatDateTimeForUser(date('Y-m-t',strtotime($modAdvancePayment->tglpengajuan2))) ?>
        <?php echo $form->labelEx($model,'tgljatuhtempo', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker',
                array(
                        'model'=>$model,
                        'attribute'=>'tgljatuhtempo',
                        'mode'=>'date',
                        'options'=>array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array(
                            'class'=>'dtPicker3',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            // 'onchange' => '$(this).removeClass("realtime")'
                        ),
                )
            ); 
            ?>

        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Total Hutang <span class="required">*</span></label>
        <div class="controls">
            <?php echo $form->textField($model,'totalhutang',array('class'=>'integer-decimal','readonly'=>true))?>
        </div>
    </div>
