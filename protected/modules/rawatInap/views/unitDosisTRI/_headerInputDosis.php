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
                                                'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                                'maxDate' => 'd',
                                                'yearRange'=> "-60:+0",
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php echo $form->error($modUnitDosis, 'tgluntidosis'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modUnitDosis,'nounitdosis', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modUnitDosis,'nounitdosis', array('onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>false));
                    ?>
                </div>
            </div>
                    
        </td>
        
        <td width="50%">
            <?php echo $form->dropDownListRow($modUnitDosis,'pegawai_id',CHtml::listData($modUnitDosis->getDokterItems(), 'pegawai_id', 'NamaLengkap'),array('onkeypress'=>"return $(this).focusNextInputField(event)"));?>
            <?php echo $form->dropDownListRow($modUnitDosis,'ruangan_id',CHtml::listData($modUnitDosis->ApotekRawatJalan, 'ruangan_id', 'ruangan_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)"));?>
        </td>
    </tr>
</table>