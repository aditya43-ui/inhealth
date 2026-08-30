<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjkonsul-poli-t-formupdate',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<table>
    <tr>
        <td width="50%">
            <?php echo $form->textFieldRow($modKonsul,'tglkonsulpoli',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'disabled'=>true)); ?>
            
            <?php echo $form->dropDownListRow($modKonsul,'asalpoliklinikkonsul_id', CHtml::listData($modKonsul->getRuanganInstalasiItems(''), 'ruangan_id', 'ruangan_nama'),
                                            array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
            
            <?php echo $form->dropDownListRow($modKonsul,'ruangan_id', CHtml::listData($modKonsul->getRuanganInstalasiItems('',true,$modKonsul->ruangan_id), 'ruangan_id', 'ruangan_nama'),
                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
            
        </td>
        <td width="50%">
            <?php echo $form->dropDownListRow($modKonsul,'pegawai_id', CHtml::listData($modKonsul->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaPegawai'),
                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
            
            <?php echo $form->textAreaRow($modKonsul,'catatan_dokter_konsul',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
        </td>
    </tr>
</table>
    <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds','{icon} Ok',array('{icon}'=>'<i class="entypo-check"></i>')),'#',
                                    array('class' => 'btn btn-danger', 'onclick'=>'$("#dialogDetailKonsul").dialog("close");return false;')); ?>
    </div>

<?php $this->endWidget(); ?>