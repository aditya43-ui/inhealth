<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>


<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pindahkamar-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<?php 
    echo $this->renderPartial('_formDataPasienPulang',array('form'=>$form,'modRD'=>$modDataPasien)) 
?>
<fieldset>
    <legend>Data Pindah Kamar</legend>
        <!-- <p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p> -->

        <?php echo $form->errorSummary(array($modPindahKamar)); ?>

        <?php echo $form->dropDownListRow($modPindahKamar,'ruangan_id', CHtml::listData($modPindahKamar->getRuanganItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama') ,
                                  array('empty'=>'-- Pilih --',
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'onChange'=>'updateKamarRuangan(this.value)',
                                        'class'=>'span2')); ?>

        <?php echo $form->dropDownListRow($modPindahKamar,'kamarruangan_id', array() ,
                                  array('empty'=>'-- Pilih --',
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'class'=>'span2')); ?>

        <div class="control-group">
            <?php echo $form->labelEx($modPindahKamar,'tglpindahkamar', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$modPindahKamar,
                                        'attribute'=>'tglpindahkamar',
                                        'mode'=>'datetime',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                             'class'=>'dtPicker3',
                                                             'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                             ),
                )); ?>
                <?php echo $form->error($modPindahKamar, 'tglpindahkamar'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modPindahKamar,'jampindahkamar', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$modPindahKamar,
                                        'attribute'=>'jampindahkamar',
                                        'mode'=>'time',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                             'class'=>'tPicker3',
                                                             'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                             ),
                )); ?>
                <?php echo $form->error($modPindahKamar, 'jampindahkamar'); ?>
            </div>
        </div>

    <div class="form-actions">
         <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                               Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                                array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)')); ?>
    </div>

    <?php $this->endWidget(); ?>    
</fieldset>
    
<?php
    $url = Yii::app()->createUrl('actionAjaxRIRD/GetKamarKosong',array('encode'=>false,'namaModel'=>'PindahkamarT'));
?>
<script>
function konfirmasi()
{
    if(confirm('<?php echo Yii::t('mds','Do You want to cancel?') ?>'))
    {
        $('#dialogPindahKamar').dialog('close');
    }
    else
    {   
        $('#PasienpulangT_carakeluar').focus();
        return false;
    }
}

function updateKamarRuangan(idRuangan)
{
    jQuery.ajax({'type':'POST',
                 'url':'<?php echo $url ?>',
                 'cache':false,
                 'data':{ ruangan_id:idRuangan },
                 'success':function(html){
                     jQuery("#dialogPindahKamar #pindahkamar-t-form #PindahkamarT_kamarruangan_id").html(html)
                 }
             });
}
</script>
