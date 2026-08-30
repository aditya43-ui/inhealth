<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
                <?php echo $form->labelEx($model, 'pasienblacklist_tgl', array('class' => 'control-label inline')) ?>
                <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'pasienblacklist_tgl',
                                'mode' => 'datetime',
                                'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                        ));
                        ?>

                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::activeLabel($model, 'pasienblacklist_no', array('class' => 'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textField($model, 'pasienblacklist_no', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
        </div>
        <div class='control-group'>
                <?php echo $form->labelEx($model, 'isblacklist', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->checkBox($model, 'isblacklist', array('onclick'=>'cekListBlacklist(this);','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
        </div> 
    </div>
</div>

