<fieldset>
    <legend>Data Keluarga Berencana</legend>
<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($modPasienKB,'pegawai_id',  CHtml::listData($modPasienKB->DokterItems, 'pegawai_id', 'nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
             <?php echo $form->labelEx($modPasienKB,'tglpelayanankb', array('class'=>'control-label')) ?>
            <div class="controls">  
                <?php $this->widget('MyDateTimePicker',array(
                                     'model'=>$modPasienKB,
                                     'attribute'=>'tglpelayanankb',
                                     'mode'=>'datetime',
                                     'options'=> array(
                                     'dateFormat'=>Params::DATE_FORMAT,
                                     'maxDate'=>'d',   
                                         ),
                                     'htmlOptions'=>array('readonly'=>true,'class'=>'isRequired',
                                     'onkeypress'=>"return $(this).focusNextInputField(event)"),
                )); ?>
            </div>
            <?php echo $form->dropDownListRow($modPasienKB,'metodekb',  LookupM::getItems('metodekb'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->dropDownListRow($modPasienKB,'jeniskb',LookupM::getItems('jeniskb'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($modPasienKB,'lama_waktu',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
        </td>
        <td>
             <?php echo $form->textAreaRow($modPasienKB,'efeksamping',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
             <?php echo $form->textAreaRow($modPasienKB,'catatan_kb',array('rows'=>2, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

        </td>
    </tr>
</table>
</fieldset>           