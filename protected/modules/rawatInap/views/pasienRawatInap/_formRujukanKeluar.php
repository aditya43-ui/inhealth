<fieldset class="">
    <div id="divRujukan"  style="display:<?php echo ($modelPulang->pakeRujukan) ? 'block':'none'; ?>">
        <table width="100%" class="items">
        <tr>
            <td>
				<div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Dirujuk <span style=color:red>*</span>','tgldirujuk', array('class'=>'control-label')); ?>
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
                                'htmlOptions'=>array('readonly'=>true,'class'=>'required'),
                            )); 
                        ?>
                    </div>
                </div>
                <?php 
				
				echo $form->dropDownListRow($modRujukanKeluar,'pegawai_id', CHtml::listData($modRujukanKeluar->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->dropDownListRow($modRujukanKeluar,'rujukankeluar_id', CHtml::listData($modRujukanKeluar->getRujukanItems(), 'rujukankeluar_id', 'rumahsakitrujukan'),
                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->textFieldRow($modRujukanKeluar,'nosuratrujukan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'disabled'=>true)); ?>
                <?php // echo $form->textFieldRow($modRujukanKeluar,'kepadayth',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'disabled'=>true)); ?>
                <?php echo $form->textFieldRow($modRujukanKeluar,'dirujukkebagian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30,'disabled'=>true)); ?>
                <?php echo $form->dropDownListRow($modRujukanKeluar,'ruanganasal_id', CHtml::listData($modRujukanKeluar->getRuanganInstalasiItems(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
           </div>
				
				<div class="col-sm-6">
				<?php echo $form->textAreaRow($modRujukanKeluar,'catatandokterperujuk',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->textAreaRow($modRujukanKeluar,'alasandirujuk',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->textAreaRow($modRujukanKeluar,'hasilpemeriksaan_ruj',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
				
                <?php echo $form->textAreaRow($modRujukanKeluar,'diagnosasementara_ruj',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->textAreaRow($modRujukanKeluar,'pengobatan_ruj',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                <?php echo $form->textAreaRow($modRujukanKeluar,'lainlain_ruj',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
				</div>
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

    }
    else {
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
                $('#RIPasienPulangT_carakeluar_id').val('<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>');
                $('#divRujukan #RIPasienDirujukKeluarT_tgldirujuk').val('<?php echo $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(
                                                                 CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss')); ?>');
                
        }else{
                $('#divRujukan textarea').attr('disabled','true');
                $('#divRujukan input').attr('disabled','true');
                $('#divRujukan select').attr('disabled','true');
//                $('#divRujukan input').attr('value','');
//                $('#divRujukan select').attr('value','');
                $('#RIPasienPulangT_carakeluar_id').val('');
        }
        $('#divRujukan').slideToggle(500);
    });
</script>
