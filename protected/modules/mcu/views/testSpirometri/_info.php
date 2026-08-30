<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($model,'spirometri_tgl', array('class'=>'control-label', 'label'=>'Tgl. Pemeriksaan')) ?>
        <div class="controls">  
            <?php $this->widget('MyDateTimePicker',array(
                'model'=>$model,
                'attribute'=>'spirometri_tgl',
                'mode'=>'datetime',
                'options'=> array(
                    'dateFormat'=>Params::DATE_FORMAT,
                    'maxDate'=>'d',   
                ),
                'htmlOptions'=>array('readonly'=>true, 'class'=>'span3 dtPicker3',
                'onkeypress'=>"return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($modPemeriksaanFisik,'tinggibadan', array('class'=>'control-label', 'label'=>'Tinggi Badan')) ?>
        <div class="controls"> 
            <?php echo $form->textField($modPemeriksaanFisik, 'tinggibadan', array(
                'readonly'=>true,
                'class'=>'span1',
            )); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPemeriksaanFisik, 'beratbadan', array(
        'readonly'=>true,
        'class'=>'span1',
    )); ?>
</div>
<div class="clear"></div>
