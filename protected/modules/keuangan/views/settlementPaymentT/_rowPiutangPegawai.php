<?php echo $form->checkbox($model, 'ispotonggaji', array('onclick'=>'setPotongGaji()'));?>
<label>Potong Gaji</label> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="Sisa Pengembalian Advance Payment dipotong dari gaji"></i>

<br>
<div id="potongangaji">
        <?php echo $form->textFieldRow($model,'periodegaji',array('class'=>'inputFormTabel','readonly'=>true))?>
        <div class="control-group">
                <label class="control-label">Total Potongan Gaji <span class="required">*</span></label>
                <div class="controls">
                        <?php echo $form->textField($model,'totalpotongan',array('class'=>'integer-decimal','readonly'=>true))?>
                </div>
        </div>
</div>
<div id="bayartempo">
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
                // $model->tgljatuhtempo = MyFormatter::formatDateTimeForDb($model->tgljatuhtempo);
            ?>

        </div>
    </div>
    <?php echo $form->textFieldRow($model,'totalpiutang',array('class'=>'integer-decimal','readonly'=>true))?>

</div>
