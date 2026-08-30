<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'spesialissubspesialis-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "col-sm-6">
			<?php 
			
			$crList = new CDbCriteria;
			$crList->addCondition('spesialissubspesialis_aktif = true');
			$crList->order = 'spesialissubspesialis_urutan, spesialissubspesialis_nama';
			if (!$model->isNewRecord) {
				$crList->addCondition("spesialissubspesialis_id <> ".$model->spesialissubspesialis_id);
			}
			echo $form->dropDownListRow($model,'spesialis_id', CHtml::listData(
				SpesialissubspesialisM::model()->findAll($crList), 'spesialissubspesialis_id', 'spesialissubspesialis_nama'
			),
			array(
				'empty'=>'-- Pilih --',
				'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"
			)); ?>
			<?php echo $form->textFieldRow($model,'jenis',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'spesialissubspesialis_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
			<?php echo $form->textFieldRow($model,'spesialissubspesialis_namalainnya',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class = "col-sm-6">
			<?php echo $form->textFieldRow($model,'spesialissubspesialis_kode',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($model,'spesialissubspesialis_kodebpjs',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($model,'spesialissubspesialis_urutan',array('class'=>'span1 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $model->isNewRecord ? "" : $form->checkBoxRow($model,'spesialissubspesialis_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php // echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php // echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php // echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php // echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan SpesialissubspesialisM',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>
