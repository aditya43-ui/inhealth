<div class="col-sm-6">
    <?php 
        echo $form->hiddenField($model,'suratperjanjiankerja_id',array('readonly'=>true));
        echo $form->textFieldRow($model,'notadinasppk_nomor',array('readonly' => true)); ?>
    <div class="control-group">
        <?php echo CHtml::label('Termin <span class="required">*</span>', 'nomor_beritaacara', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'termin_angka', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <label> dari</label>
            <?php echo $form->textField($model, 'termin_jumlah', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->hiddenField($model, 'terminke', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->hiddenField($model, 'termin_persen', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->hiddenField($model, 'total_pembayaran', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <?php
        echo $form->textFieldRow($model,'nomor_notadinas',array()); 
        echo $form->textAreaRow($model,'kepada',array()); 
    ?>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Tanggal Nota Dinas<span class="required">*</span></label>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'notadinasppk_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
            ?>
        </div>
    </div>
    <?php         
        echo $form->textFieldRow($model,'pegppk_nama',array('readonly' => true)); 
        echo $form->textAreaRow($model,'pekerjaan',array()); 
    ?>
</div>