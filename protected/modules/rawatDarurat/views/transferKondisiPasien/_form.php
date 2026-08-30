
<?php
if(isset($_GET['sukses'])){
    Yii::app()->user->setFlash('success',"Data Early Warning Score berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjpasien-morbiditas-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>
<div class="row-fluid">
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>    
    <?php echo $form->errorSummary($model); ?>  
    <?php // echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
    <?php // echo CHtml::hiddenField('berubsah','',array('readonly'=>TRUE));?>
    <?php echo $form->hiddenField($model,'pendaftaran_id'); ?>
    <?php echo $form->hiddenField($model,'pasienadmisi_id'); ?>
    <?php echo $form->hiddenField($model,'dpjp_id'); ?>
    
    <div class="col-sm-12">
        <div class="control-group ">
            <?php echo $form->labelEx($model,'tanggalpengkajian', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'tanggalpengkajian',
                    'mode'=>'datetime',
                    'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'maxDate' => 'd',
                    ),
                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5','style'=>'width:150px;'),
                )); ?>
                <?php echo $form->error($model, 'tanggalpengkajian'); ?> 
            </div>
        </div>
        <?php echo $form->dropDownListRow($model,'petugaspengkaji_id',CHtml::listData($model->getPegawaiPengkajiItems(), 'pegawai_id', 'NamaLengkap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);"));?>
    </div>
    
    <?php $this->renderPartial($this->path_view.'_formTabulasiEws',array('model'=>$model,'modDetail'=>$modDetail,'form'=>$form,'modPasien'=>$modPasien)) ?>
    
    
</div>    


            
<div class="form-actions">
    <?php $disabledSimpan = (isset($_GET['sukses'])?true:false) ?>
       <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                               array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>$disabledSimpan)); ?>

   <?php 
echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']), 
                            array('class'=>'btn btn-danger',
                                'onclick'=>'return refreshForm(this);'));
   ?>
</div> 

<?php $this->endWidget(); ?>