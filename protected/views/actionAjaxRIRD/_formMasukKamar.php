<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>


<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'masukkamar-t-form',
	'enableAjaxValidation'=>true,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<?php 
    echo $this->renderPartial('_formDataPasienPulang',array('form'=>$form,'modRD'=>$modDataPasien)) 
?>

<?php echo $form->errorSummary(array($modMasukKamar)); ?>
<fieldset>
    <legend>Data Masuk Kamar</legend>
        <!-- <p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p> -->

        <?php echo $form->errorSummary(array($modMasukKamar)); ?>

        <div class="control-group">
            <?php echo CHtml::label('Ruangan','ruangan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('ruangan_nama',  RuanganM::model()->findByPk($modMasukKamar->ruangan_id)->ruangan_nama,array('readonly'=>true)) ?>
            </div>
         </div>


        <?php echo $form->dropDownListRow($modMasukKamar,'kamarruangan_id', CHtml::listData($modMasukKamar->getKamarKosongItems($modMasukKamar->ruangan_id), 'kamarruangan_id', 'KamarDanTempatTidur') ,
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
                                             'dateFormat'=>Params::DATE_FORMAT,
//                                             'maxDate' => 'd',
//                                             'minDate' =>'',
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
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
                                             'dateFormat'=>Params::TIME_FORMAT,
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
         <?php echo CHtml::htmlButton($modMasukKamar->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                               Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                array('class'=>'btn btn-primary','type'=>'submit','onclick'=>'kamarruangan(event);','onKeypress'=>'return formSubmit(this,event)')); ?>
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                                array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)')); ?>
    </div>

    <?php $this->endWidget(); ?>    
</fieldset>

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
function kamarruangan(event){
    var idKamarruangan = $('#MasukkamarT_kamarruangan_id').val();
    
    if(idKamarruangan ==''){
      myAlert("Pilih Kamar Ruangan Pasien Terlebih Dahulu");
      event.preventDefault();
      return false;
    }else{
         $('#PasienpulangT_carakeluar').submit();
        return true;
    }
}
</script>