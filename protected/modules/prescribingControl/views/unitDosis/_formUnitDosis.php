<table>
    <tr>
        <td width="50%">
            <div class="control-group">
                <?php $modUnitDosis->tgluntidosis = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modUnitDosis->tgluntidosis, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                <?php echo $form->labelEx($modUnitDosis,'tgluntidosis', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$modUnitDosis,
                                            'attribute'=>'tgluntidosis',
                                            'mode'=>'datetime',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                                'yearRange'=> "-60:+0",
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php echo $form->error($modUnitDosis, 'tgluntidosis'); ?>
                </div>
            </div>
			<?php echo $form->textFieldRow($modUnitDosis,'nounitdosis',array('onkeypress'=>"return $(this).focusNextInputField(event)"));?>
        </td>
        
        <td width="50%">
            <?php echo $form->dropDownListRow($modUnitDosis,'pegawai_id',CHtml::listData($modUnitDosis->DokterItems, 'pegawai_id', 'nama_pegawai'),array('onkeypress'=>"return $(this).focusNextInputField(event)"));?>
            <?php echo $form->dropDownListRow($modUnitDosis,'ruangan_id',CHtml::listData($modUnitDosis->RuanganInstalasiFarmasi, 'ruangan_id', 'ruangan_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)"));?>
        </td>
    </tr>
</table>