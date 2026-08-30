
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sagolongan-pegawai-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
			'onsubmit' => 'return requiredCheck(this);'),
        'focus'=>'#KPGolonganPegawaiM_golonganpegawai_nama',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'golonganpegawai_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'golonganpegawai_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php //echo $form->checkBoxRow($model,'golonganpegawai_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/golonganPegawaiM/admin'), 
                                    array('class' => 'btn btn-default',
                                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Golongan Pegawai', array('{icon}'=>'<i class="entypo-folder"></i>')),
                                                                    $this->createUrl('golonganPegawaiM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));?>
                        <?php
                            $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
        </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('KPGolonganPegawaiM_golonganpegawai_namalainnya').value = nama.value.toUpperCase();
    }
</script>