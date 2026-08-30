<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pppendaftaran-mp-form',
	'enableAjaxValidation'=>false,
        'enableClientValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#isPasienLama',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
));
//
?>
<?php $this->widget('bootstrap.widgets.BootAlert');
$this->renderPartial('/_ringkasDataPasien',array('modPasienMasukPenunjang'=>$modPasienMasukPenunjang));
echo $form->errorSummary(array($modKirimSample,$modPengambilanSample)); ?>

<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($modPengambilanSample,'samplelab_id', CHtml::listData($modPengambilanSample->getSampleLabItems(), 'samplelab_id', 'samplelab_nama') ,array('onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
             <div class="control-group">
                <?php echo $form->labelEx($modPengambilanSample,'tglpengambilansample', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPengambilanSample,
                                                'attribute'=>'tglpengambilansample',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                   ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        <?php echo $form->error($modPengambilanSample, 'tglpengambilansample'); ?>
                    </div>
             </div>
            <?php echo $form->textFieldRow($modPengambilanSample,'no_pengambilansample',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($modPengambilanSample,'jmlpengambilansample',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($modPengambilanSample,'tempatsimpansample',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textAreaRow($modPengambilanSample,'keterangansample',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
        <td>
            <fieldset id="kirimSample">
                <legend><?php echo CHtml::checkBox('isKirimSample',$modKirimSample->isKirimSample,array('onclick'=>'enableInputSample(this)'));?>Kirim Sampel</legend>
                
                 <?php echo $form->dropDownListRow($modKirimSample,'labklinikrujukan_id',
                               CHtml::listData($modKirimSample->LabKlinikRujukanItems, 'labklinikrujukan_id', 'labklinikrujukan_nama'),
                               array('class'=>'span3','disabled'=>TRUE, 'onkeypress'=>"return $(this).focusNextInputField(event)",
                               'empty'=>'-- Pilih --')); ?>
                <?php echo $form->textFieldRow($modKirimSample,'nokirimsample',array('class'=>'span3','disabled'=>TRUE, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                <div class="control-group">
                <?php echo $form->labelEx($modKirimSample,'tglkirimsample', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modKirimSample,
                                                'attribute'=>'tglkirimsample',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                   ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        <?php echo $form->error($modKirimSample, 'tglkirimsample'); ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($modKirimSample,'keterangan_kirim',array('rows'=>6,'disabled'=>TRUE, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </fieldset>
        </td>
    </tr>
</table>

  <div class='form-actions'>
             <?php echo CHtml::htmlButton($modKirimSample->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 
                                                      'id'=>'btn_simpan',
                                                   )); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index'), array('class'=>'btn btn-danger')); ?>
    </div>
<?php $this->endWidget(); ?>

<?php
$jscript = <<< JS
function enableInputSample(obj)
{
    if(obj.checked) {
        $('#kirimSample input').removeAttr('disabled');
        $('#kirimSample select').removeAttr('disabled');
        $('#kirimSample textarea').removeAttr('disabled');
    }
    else {
        $('#kirimSample input').attr('disabled','true');
        $('#kirimSample select').attr('disabled','true');
        $('#kirimSample textarea').attr('disabled','true');
        $('#isKirimSample').removeAttr('disabled');

       
    }
}
JS;
Yii::app()->clientScript->registerScript('enabledKirimSample',$jscript, CClientScript::POS_HEAD);

$enableInputSample = ($modKirimSample->isKirimSample) ? 1 : 0;
$js = <<< JS
if(${enableInputSample}) {
        $('#kirimSample input').removeAttr('disabled');
        $('#kirimSample select').removeAttr('disabled');
        $('#kirimSample textarea').removeAttr('disabled');
}
else {
        $('#kirimSample input').attr('disabled','true');
        $('#kirimSample select').attr('disabled','true');
        $('#kirimSample textarea').attr('disabled','true');
        $('#isKirimSample').removeAttr('disabled');
  
}
JS;
Yii::app()->clientScript->registerScript('ready',$js,CClientScript::POS_READY);
?>