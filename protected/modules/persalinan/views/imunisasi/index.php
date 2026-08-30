<?php $this->renderPartial('/_ringkasDataPasiendanPemeriksaanKehamilan', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,'modPeriksaKehamilan'=>$modPeriksaKehamilan)); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'pskeg-bayi-tabung-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<?php echo $form->errorSummary($modPasienImunisasi); ?>
<?php $this->renderPartial('_formRiwayatImunisasi',array('modRiwayatImunisasi'=>$modRiwayatImunisasi)); ?>
<?php $this->renderPartial('_formPasienImunisasi',array('modPasienImunisasi'=>$modPasienImunisasi,'modJadwalTTBumil'=>$modJadwalTTBumil,'form'=>$form)); ?>

<div class="form-actions">
                <?php echo CHtml::htmlButton($modPasienImunisasi->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'validasi()')); ?>
                  <div style="display: none">     
                         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan')); ?>
                  </div> 
                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/DaftarPasien/index'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
</div>
<?php $this->endWidget(); ?>

