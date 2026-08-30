<fieldset>
    <legend>Data Bayi Tabung</legend>
<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($modKegiatanBayiTabung,'pegawai_id',  CHtml::listData($modKegiatanBayiTabung->DokterItems, 'pegawai_id', 'nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->labelEx($modKegiatanBayiTabung,'tglkegbayitabung', array('class'=>'control-label')) ?>
            <div class="controls">  
                <?php $this->widget('MyDateTimePicker',array(
                                     'model'=>$modKegiatanBayiTabung,
                                     'attribute'=>'tglkegbayitabung',
                                     'mode'=>'datetime',
                                     'options'=> array(
                                     'dateFormat'=>Params::DATE_FORMAT,
                                     'maxDate'=>'d',   
                                         ),
                                     'htmlOptions'=>array('readonly'=>true,'class'=>'isRequired',
                                     'onkeypress'=>"return $(this).focusNextInputField(event)"),
                )); ?>
            </div>
            <?php echo $form->labelEx($modKegiatanBayiTabung,'tglkehamilan', array('class'=>'control-label')) ?>
            <div class="controls">  
                <?php $this->widget('MyDateTimePicker',array(
                                     'model'=>$modKegiatanBayiTabung,
                                     'attribute'=>'tglkehamilan',
                                     'mode'=>'date',
                                     'options'=> array(
                                     'dateFormat'=>Params::DATE_FORMAT,
                                     'maxDate'=>'d',   
                                         ),
                                     'htmlOptions'=>array('readonly'=>true,'class'=>'isRequired',
                                     'onkeypress'=>"return $(this).focusNextInputField(event)"),
                )); ?>
            </div>
            <?php echo $form->dropDownListRow($modKegiatanBayiTabung,'sikluskegiatan', LookupM::getItems('sikluskegiatanbt') ,array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($modKegiatanBayiTabung,'metodebt', LookupM::getItems('metodebt') ,array('empty'=>'-- Pilih --','class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->dropDownListRow($modKegiatanBayiTabung,'positivekehamilan', array(1=>'Ya',0=>'Tidak') ,array('empty'=>'-- Pilih --','class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->textAreaRow($modKegiatanBayiTabung,'catatankegiatan',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
</table>
    </fieldset>
