<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sadtd-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onSubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($model,'dtd_noterperinci'),
)); ?>
<div class="row">
	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<?php echo $form->errorSummary($model); ?>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'dtd_noterperinci',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
		<div class="control-group">
			<?php echo $form->labelEx($model,'tabularlist_id',array('class'=>'control-label required')); ?>
			<div class="controls inline">
				<?php echo $form->dropDownList($model,'tabularlist_id',  CHtml::listData($model->getTabularItems(), 'tabularlist_id', 'tabularlist_block'), 
				array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
				'class'=>'span3')); ?> 
			</div> 
		</div>
		<?php echo $form->textFieldRow($model,'dtd_nourut',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo $form->textFieldRow($model,'dtd_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>              
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'dtd_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
		<?php echo $form->textFieldRow($model,'dtd_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
		<?php echo $form->textFieldRow($model,'dtd_katakunci',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
		<?php //echo $form->checkBoxRow($model,'dtd_menular', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php //echo $form->checkBoxRow($model,'dtd_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<div class="control-group">
		   <?php echo CHtml::label("",'dtd_menular', array('class' => 'control-label')) ?>
		   <div class="controls">
			   <?php echo $form->checkBox($model,'dtd_menular',array()); ?> <label>Menular</label>
		   </div>				
		</div>
		<div class="control-group">
		   <?php echo CHtml::label("",'dtd_aktif', array('class' => 'control-label')) ?>
		   <div class="controls">
				<?php echo $form->checkBox($model,'dtd_aktif',array()); ?> <label>Aktif</label>
		   </div>				
		</div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
		Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
		array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrow-ccw"></i>')), 
		$this->createUrl('admin'), 
		array('class' => 'btn btn-default',
		'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan DTD', array('{icon}'=>'<i class="entypo-folder"></i>')),
		$this->createUrl('Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));?>                                          
	<?php 
		$content = $this->renderPartial($this->path_view.'tips/tipsCreateUpdate',array(),true);
		$this->widget('UserTips',array('content'=>$content)); ?>                    
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SADtdM_dtd_namalainnya').value = nama.value.toUpperCase();
    }
</script>