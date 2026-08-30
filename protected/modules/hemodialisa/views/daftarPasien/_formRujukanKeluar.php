
<fieldset class="box">
    <legend class="rim">
        <?php echo CHtml::checkBox('pakeRujukan', $modelPulang->pakeRujukan, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
        Rujukan Keluar
    </legend>
    <div id="divRujukan" class="control-group toggle <?php echo ($modelPulang->pakeRujukan) ? '':'hide'; ?>">
        <table class="items">
        <tr>
            <td width="50%">
                    <div class="control-group ">
                    <?php echo  $form->labelEx($modRujukanKeluar,'tgldirujuk', array('class'=>'control-label')); ?>
                    <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modRujukanKeluar,
                                                    'attribute'=>'tgldirujuk',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
													'dateFormat'=>Params::DATE_FORMAT,
													'maxDate' => 'd',
                                                 ),
                                                 'htmlOptions'=>array('style'=>'width:130px','readonly'=>true),
                            )); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($modRujukanKeluar,'pegawai_id', CHtml::listData($modRujukanKeluar->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->dropDownListRow($modRujukanKeluar,'rujukankeluar_id', CHtml::listData($modRujukanKeluar->getRujukanItems(), 'rujukankeluar_id', 'rumahsakitrujukan'),
                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->textFieldRow($modRujukanKeluar,'nosuratrujukan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'disabled'=>true)); ?>
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
        $('#divRujukan input').removeAttr('disabled');
        $('#divRujukan select').removeAttr('disabled');
        $('#divRujukan textarea').removeAttr('disabled');
    }else {
        $('#divRujukan input').attr('disabled','true');
        $('#divRujukan select').attr('disabled','true');
        $('#divRujukan textarea').attr('disabled','true');
        $('#divRujukan #RIPasienDirujukKeluarT_tgldirujuk').val('<?php echo $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(
                                                                 CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss')); ?>');
    }
    $('#pakeRujukan').change(function(){
        if ($(this).is(':checked')){
                $('#divRujukan input').removeAttr('disabled');
                $('#divRujukan select').removeAttr('disabled');
                $('#divRujukan textarea').removeAttr('disabled');
                $('#HDPasienPulangT_carakeluar_id').val('<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>');
                $('#divRujukan #RIPasienDirujukKeluarT_tgldirujuk').val('<?php echo $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(
                                                                 CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss')); ?>');
                
        }else{
                $('#divRujukan textarea').attr('disabled','true');
                $('#divRujukan input').attr('disabled','true');
                $('#divRujukan select').attr('disabled','true');
                $('#HDPasienPulangT_carakeluar_id').val('');
        }
        $('#divRujukan').slideToggle(500);
    });
</script>