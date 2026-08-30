
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo CHtml::checkBox('pakeRujukan', $modelPulang->pakeRujukan, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
            Rujukan Keluar 
        </div>
    </div>
    <div class="panel-body">
        <div id="divRujukan" class="control-group" <?php echo ($modelPulang->pakeRujukan) ? '':'hidden'; ?>>
            <table class="items">
            <tr>
                <td width="50%">
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
                                                        'htmlOptions'=>array('readonly'=>true),
                                )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Surat Berlaku <span style=color:red>*</span>','tgldirujuk', array('class'=>'control-label')); ?>
                        <div class="controls">
                                <?php   
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$modRujukanKeluar,
                                                        'attribute'=>'tglberlakusurat',
                                                        'mode'=>'datetime',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                            'maxDate' => 'd',
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true),
                                )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Sampai Dengan <span style=color:red>*</span>','tgldirujuk', array('class'=>'control-label')); ?>
                        <div class="controls">
                                <?php   
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$modRujukanKeluar,
                                                        'attribute'=>'sampaidengan',
                                                        'mode'=>'datetime',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                            'maxDate' => 'd',
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true),
                                )); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($modRujukanKeluar,'pegawai_id', CHtml::listData($modRujukanKeluar->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                                    array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                    <?php echo $form->dropDownListRow($modRujukanKeluar,'rujukankeluar_id', CHtml::listData($modRujukanKeluar->getRujukanItems(), 'rujukankeluar_id', 'rumahsakitrujukan'),
                                                    array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
                    <?php echo $form->textFieldRow($modRujukanKeluar,'nosuratrujukan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'disabled'=>true)); ?>
                    <?php // echo $form->textFieldRow($modRujukanKeluar,'kepadayth',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'disabled'=>true)); ?>
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
    </div>
</div>

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
        $('#divRujukan #PIPasienDirujukKeluarT_tgldirujuk').val('<?php echo $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(
                                                                 CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss')); ?>');
    }
    $('#pakeRujukan').change(function(){
        if ($(this).is(':checked')){
                $('#divRujukan input').removeAttr('disabled');
                $('#divRujukan select').removeAttr('disabled');
                $('#divRujukan textarea').removeAttr('disabled');
                $('#PIPasienPulangT_carakeluar_id').val('<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>');
                $('#divRujukan #PIPasienDirujukKeluarT_tgldirujuk').val('<?php echo $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(
                                                                 CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss')); ?>');
                
        }else{
                $('#divRujukan textarea').attr('disabled','true');
                $('#divRujukan input').attr('disabled','true');
                $('#divRujukan select').attr('disabled','true');
//                $('#divRujukan input').attr('value','');
//                $('#divRujukan select').attr('value','');
                $('#PIPasienPulangT_carakeluar_id').val('');
        }
        $('#divRujukan').slideToggle(500);
    });
</script>