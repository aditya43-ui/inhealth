<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'psinterpretasiskor-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
	'focus'=>'#SAInterpretasiskorM_intepretasi_nama',
)); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="row">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'intepretasi_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
		<?php echo $form->textFieldRow($model,'interpretasijmlskor',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
		<?php echo $form->textFieldRow($model,'interpretasimin',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo $form->textFieldRow($model,'interpretasimax',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textAreaRow($model,'catatan',array('rows'=>6, 'cols'=>50, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>		
		<?php //echo $form->checkBoxRow($model,'interpretasiskor_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
</div>        
<div class="form-actions">
	<?php 
		echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
		Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
		array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
	?>
	<?php 
		echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), 
		array('class' => 'btn btn-default',
		'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
	?>
	<?php
		echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Interpretasi Skor', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
		$content = $this->renderPartial($this->path_view.'tips/tipsaddedit',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
