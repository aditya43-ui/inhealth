<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sertifikasipegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.'); ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-12">
        <?php echo $form->textFieldRow($model, 'sertifikasipegawai_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'sertifikasipegawai_namalainnya', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php if(!empty($model->sertifikasipegawai_id)){ ?>
			<div class="control-group ">
				<?php echo CHtml::label('','',array('class'=>'control-label')); ?>
					<div class="controls">
						<div class="checkbox">
							<?php echo $form->checkBox($model,'sertifikasipegawai_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Aktif</label>
						</div>
					</div>
			</div>
        <?php } ?>

    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
            $this->createUrl('create'),
            array('class'=>'btn btn-danger',
                    'onclick'=>'return refreshForm(this);')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Sertifikasi Karyawan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php
        $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>

<?php $this->endWidget(); ?>