<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppbooking-kamar-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
    <fieldset>
            <legend>Booking Kamar</legend>
            <!-- <p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p> -->
            <?php echo $form->errorSummary($model); ?>

            <table class='table'>
                <tr>
                    <td width="50%">
                        <fieldset id="booking">
                            <legend>Data Booking</legend>
                            <div class="control-group">
                                
                                <?php echo $form->labelEx($model,'no_pendaftran',array('class'=>'control-label'));?>
                                <div class="controls">
                                <?php echo CHtml::textField('no_pendaftaran',$model->pendaftaran->no_pendaftaran,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>TRUE)); ?>
                            
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($model,'bookingkamar_no',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>TRUE)); ?>
                            <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(KamarruanganM::model()->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --',
                                                                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                'ajax'=>array(
                                                                                    'type'=>'POST',
                                                                                    'url'=>Yii::app()->createUrl('ActionDynamic/GetKamarRuangan',array('encode'=>false,'namaModel'=>'PPBookingKamarT')),
                                                                                    'update'=>'#PPBookingKamarT_kamarruangan_id',),
                                                                                'onchange'=>'clearKelasPelayanan()')); 
                            ?>

                            <?php echo $form->dropDownListRow($model,'kamarruangan_id', CHtml::listData($model->getKamarRuangan(), 'kamarruangan_id', 'kamarruangan_nokamar'),array('empty'=>'-- Pilih --',
                                                                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                'ajax'=>array(
                                                                                    'type'=>'POST',
                                                                                    'url'=>Yii::app()->createUrl('ActionDynamic/GetKelasPelayanan',array('encode'=>false,'namaModel'=>'PPBookingKamarT')),
                                                                                    'update'=>'#PPBookingKamarT_kelaspelayanan_id',))); 
                            ?>

                            <?php echo $form->dropDownListRow($model,'kelaspelayanan_id', CHtml::listData($model->getKelasPelayanan(), 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                            <div class='control-group'>
                            <?php echo $form->labelEx($model,'tglbookingkamar', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$model,
                                                        'attribute'=>'tglbookingkamar',
                                                        'mode'=>'datetime',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                                            'minDate' => 'd',
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                )); ?>
                                <?php echo $form->error($model, 'tglbookingkamar'); ?>
                            </div>
                        </div>

                            <?php echo $form->dropDownListRow($model,'statusbooking', LookupM::getItems('statusbooking'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

                            <?php echo $form->textAreaRow($model,'keteranganbooking',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </fieldset>
                    </td>
                <tr>
        </table>
             <div class="form-actions">
	    <?php echo CHtml::htmlButton($modPPBuatJanjiPoli->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.bookingKamarT.'/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")) return false;')); ?>
	</div>

    </fieldset>
<?php $this->endWidget(); ?>

<?php
$idKelasPelayan=CHtml::activeId($model,'kelaspelayanan_id');
$js = <<< JS

function clearKelasPelayanan()
{
    $("#${idKelasPelayan}").html('<option value="">--Pilih--</option>');
}

JS;
Yii::app()->clientScript->registerScript('javaScript',$js,CClientScript::POS_HEAD);
?>