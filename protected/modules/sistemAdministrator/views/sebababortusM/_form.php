<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pssebababortus-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
	'focus'=>'#PSSebababortusM_kelsebababortus_id',
)); ?>
<div class="row">
	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<?php echo $form->errorSummary($model); ?>
	<div class="col-sm-6">
		<?php echo $form->dropDownListRow($model,'kelsebababortus_id',  CHtml::listData($model->KelSebabAbortusItems, 'kelsebababortus_id', 'kelsebababortus_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
		<?php echo $form->textFieldRow($model,'sebababortus_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'sebababortus_namalain',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>            
		<?php echo $form->textAreaRow($model, 'sebababortus_deskripsi'); ?>
		<?php //echo $form->checkBoxRow($model,'sebababortus_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>	
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
		echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Sebab Abortus', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
		$content = $this->renderPartial($this->path_view.'tips/tipsaddedit',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama){
        document.getElementById('PSSebababortusM_sebababortus_namalain').value = nama.value.toUpperCase();
    }
</script>