<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjkonsul-poli-t-formupdate',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<br/>
<table>
    <tr>
        <td width="50%" style="vertical-align: top">
            <?php echo $form->textFieldRow($modKonsul,'tglkonsulpoli',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'disabled'=>true)); ?>
            
            <?php echo $form->dropDownListRow($modKonsul,'asalpoliklinikkonsul_id', CHtml::listData($modKonsul->getRuanganInstalasiItems(''), 'ruangan_id', 'ruangan_nama'),
                                            array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
            
            <?php 
            
            if (!empty($modKonsul->ruangan_id)) {
            echo $form->dropDownListRow($modKonsul,'ruangan_id', CHtml::listData($modKonsul->getRuanganInstalasiItems('',true,$modKonsul->ruangan_id), 'ruangan_id', 'ruangan_nama'),
                                                array('empty'=>'-- Pilih --','class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); 
            } ?>
            
        </td>
        <td width="50%" style="vertical-align: top">
            <div class="control-group">
                <label class="control-label">Dokter Konsul</label>
                <div class="controls">
                    <?php echo CHtml::textField('dokter_konsul', $modKonsul->pegawai->namaLengkap ?? "-", array('readonly'=>true, 'class'=>'span4')); ?> 
                </div>
            </div>
            <?php // echo $form->dropDownListRow($modKonsul,'pegawai_id', CHtml::listData($modKonsul->getDokterItems($modKonsul->ruangan_id), 'pegawai_id', 'namaLengkap'),
                                                // array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
            <?php  //if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ){ ?>
            <?php //echo $form->textAreaRow($modKonsul,'catatan_dokter_konsul',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
            <?php //} ?>
        </td>
    </tr>
        <tr>
            <td width="50%">
                <div class="control-group">
                    <label class="control-label">Uraian Konsul</label>
                    <div class="controls" style="width: 100% !important;">
                        <?= CHtml::textArea('', preg_replace('#</?p.*?>#is', '', $modKonsul->uraian_konsul), array('class' => '', 'style' => 'text-align:left;width: 100% !important', 'readonly' => true, 'rows' => '10', 'cols' => '230')) ?>
                    </div>
                </div>
            </td>
        </tr>
</table>
    <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds','{icon} Ok',array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),'#',
                                    array('style' => 'color:#fff','class' => 'btn btn-danger', 'onclick'=>'$("#dialogDetailKonsul").dialog("close");return false;')); ?>
    </div>

<?php $this->endWidget(); ?>