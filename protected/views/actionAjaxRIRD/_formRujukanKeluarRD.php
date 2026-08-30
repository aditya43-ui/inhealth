
<fieldset class="">
    <legend>
        <?php echo CHtml::checkBox('pakeRujukan', $modelPulang->pakeRujukan, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
        Rujukan Keluar
    </legend>
    <div id="divRujukan" class="control-group toggle <?php echo ($modelPulang->pakeRujukan) ? '':'hide'; ?>">
        <table class="items">
        <tr>
            <td width="50%">
                <?php //echo $form->textFieldRow($modRujukanKeluar,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($modRujukanKeluar,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modRujukanKeluar,'tgldirujuk', array('class'=>'control-label')) ?>
                    <?php $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modRujukanKeluar,
                                                    'attribute'=>'tgldirujuk',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5'),
                            )); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($modRujukanKeluar,'pegawai_id', CHtml::listData($modRujukanKeluar->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php //echo $form->textFieldRow($modRujukanKeluar,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($modRujukanKeluar,'rujukankeluar_id', CHtml::listData($modRujukanKeluar->getRujukanItems(), 'rujukankeluar_id', 'rumahsakitrujukan'),
                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->textFieldRow($modRujukanKeluar,'nosuratrujukan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'disabled'=>true)); ?>
                <?php //echo $form->textFieldRow($modRujukanKeluar,'tgldirujuk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modRujukanKeluar,'kepadayth',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'disabled'=>true)); ?>
                <?php echo $form->textFieldRow($modRujukanKeluar,'dirujukkebagian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30,'disabled'=>true)); ?>
                <?php echo $form->dropDownListRow($modRujukanKeluar,'ruanganasal_id', CHtml::listData($modRujukanKeluar->getRuanganInstalasiItems(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->textAreaRow($modRujukanKeluar,'catatandokterperujuk',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->textAreaRow($modRujukanKeluar,'alasandirujuk',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
            </td>
            <td width="50%">
                <?php echo $form->textAreaRow($modRujukanKeluar,'hasilpemeriksaan_ruj',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->textAreaRow($modRujukanKeluar,'diagnosasementara_ruj',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->textAreaRow($modRujukanKeluar,'pengobatan_ruj',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->textAreaRow($modRujukanKeluar,'lainlain_ruj',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
            </td>
        </tr>
    </table>
    </div>
</fieldset>

<script>
    if(<?php echo ($modelPulang->pakeRujukan)  ?  1 :  0; ?>) {
    $('#dialogPasienPulang #divRujukan input').removeAttr('disabled');
    $('#dialogPasienPulang #divRujukan select').removeAttr('disabled');
    }
    else {
        $('#dialogPasienPulang #divRujukan input').attr('disabled','true');
        $('#dialogPasienPulang #divRujukan select').attr('disabled','true');
        $('#dialogPasienPulang #divRujukan #PasiendirujukkeluarT_tgldirujuk').val('<?php echo date('Y-m-d H:i:s') ?>');
    }
    $('#dialogPasienPulang #pakeRujukan').change(function(){
        if ($(this).is(':checked')){
                $('#dialogPasienPulang #divRujukan input').removeAttr('disabled');
                $('#dialogPasienPulang #divRujukan select').removeAttr('disabled');
                $('#dialogPasienPulang #PasienpulangT_carakeluar_id').val('<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>');
                $('#dialogPasienPulang #divRujukan #PasiendirujukkeluarT_tgldirujuk').val('<?php echo date('Y-m-d H:i:s') ?>');
                
        }else{
                $('#dialogPasienPulang #divRujukan input').attr('disabled','true');
                $('#dialogPasienPulang #divRujukan select').attr('disabled','true');
                $('#dialogPasienPulang #divRujukan input').attr('value','');
                $('#dialogPasienPulang #divRujukan select').attr('value','');
                $('#dialogPasienPulang #PasienpulangT_carakeluar_id').val('');
        }
        $('#dialogPasienPulang #divRujukan').slideToggle(500);
    });
</script>