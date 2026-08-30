<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>


<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'masukkamar-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<?php 
    echo $this->renderPartial('_formDataPasienPulang',array('form'=>$form,'modRD'=>$modDataPasien)) 
?>
<fieldset>
    <legend>Data Masuk Kamar</legend>
        <!-- <p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p> -->

        <?php echo $form->errorSummary(array($modMasukKamar)); ?>

        <div class="control-group">
            <?php echo CHtml::label('Ruangan','ruangan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('ruangan_nama', $modDataPasien->ruangan_nama,array('readonly'=>true)) ?>
            </div>
         </div>


        <?php echo $form->dropDownListRow($modMasukKamar,'kamarruangan_id', CHtml::listData(KamarruanganM::model()->findAll(), 'kamarruangan_id', 'KamarDanTempatTidur') ,
                                  array('empty'=>'-- Pilih --',
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'class'=>'span2')); ?>

        <div class="control-group">
            <?php echo $form->labelEx($modMasukKamar,'tglmasukkamar', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$modMasukKamar,
                                        'attribute'=>'tglmasukkamar',
                                        'mode'=>'datetime',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                             'class'=>'dtPicker3',
                                                             'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                             ),
                )); ?>
                <?php echo $form->error($modMasukKamar, 'tglmasukkamar'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modMasukKamar,'jammasukkamar', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$modMasukKamar,
                                        'attribute'=>'jammasukkamar',
                                        'mode'=>'time',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                             'class'=>'tPicker3',
                                                             'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                             ),
                )); ?>
                <?php echo $form->error($modMasukKamar, 'jamkeluarkamar'); ?>
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
        $('#dialogMasukKamar').dialog('close');
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
                     jQuery("#dialogMasukKamar #masukkamar-t-form #MasukkamarT_kamarruangan_id").html(html)
                 }
             });
}
</script>