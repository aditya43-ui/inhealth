<fieldset>
    <legend>Informasi Keluar Kamar</legend>
    <div class="control-group">
        <?php echo $form->labelEx($modMasukKamar,'tglkeluarkamar', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                                    'model'=>$modMasukKamar,
                                    'attribute'=>'tglkeluarkamar',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,
                                                         'class'=>'dtPicker3',
                                                         'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                         ),
            )); ?>
            <?php echo $form->error($modMasukKamar, 'tglkeluarkamar'); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo $form->labelEx($modMasukKamar,'jamkeluarkamar', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
                                    'model'=>$modMasukKamar,
                                    'attribute'=>'jamkeluarkamar',
                                    'mode'=>'time',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,
                                                         'class'=>'dtPicker3',
                                                         'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                         ),
            )); ?>
            <?php echo $form->error($modMasukKamar, 'jamkeluarkamar'); ?>
        </div>
    </div>
</fieldset>