<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Periode Akuntansi <span class="required">*</span>', 'rekperiod_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'rekperiod_id', CHtml::listData(RekperiodM::model()->findAllByAttributes(array('isclosing' => false)), 'rekperiod_id', 'deskripsi'), array('empty' => '-- Pilih --', 'class' => 'span4 required', 'onkeypress' => 'return $(this).focusNextInputField(event)')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No. CALK <span class="required">*</span>', 'calk_no', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'calk_no', array('placeholder' => 'No. CALK', 'class' => 'span4 required', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'maxlength' => 25)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. CALK', 'calk_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'calk_tgl',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        //										'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onclick' => "return $(this).focusNextInputField(event)"),
                )); ?>
            </div>
        </div>
    </div>
</div>