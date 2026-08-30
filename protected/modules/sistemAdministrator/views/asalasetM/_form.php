<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saasalaset-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
            'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($model,'asalaset_nama'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'asalaset_nama',array('class'=>'span2 angkahuruf-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'asalaset_singkatan',array('class'=>'span2 angkahuruf-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
            <?php echo $form->checkBoxRow($model,'asalaset_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                       '', 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
            <?php //$this->widget('UserTips',array('type'=>'create'));?>
        <?php
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Asal Aset', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-success',));
$content = $this->renderPartial($this->path_view.'.tips.tipsCreate',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
