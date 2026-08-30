<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'satabular-list-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'return requiredCheck(this);'),
	'focus' => '#' . CHtml::activeId($model, 'tabularlist_chapter'),
)); ?>
<div class="row">
	<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
	<?php echo $form->errorSummary($model); ?>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model, 'tabularlist_chapter', array('placeholder' => 'Chapter', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
		<?php echo $form->textFieldRow($model, 'tabularlist_revisi', array('placeholder' => 'Block', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
		<?php echo $form->textAreaRow($model, 'tabularlist_title', array('placeholder' => 'Title', 'rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model, 'tabularlist_block', array('placeholder' => 'Revisi', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
		<?php echo $form->textFieldRow($model, 'tabularlist_versi', array('placeholder' => 'Versi', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
		<?php echo $form->textAreaRow($model, 'tabularlist_title2', array('placeholder' => 'Judul', 'rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
	</div>
	<div class="control-group">
		<?php echo CHtml::label("", 'tabularlist_aktif', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->checkBox($model, 'tabularlist_aktif', array()); ?> <label>Aktif</label>
		</div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(
		$model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
			Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
		array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
	); ?>
	<?php echo CHtml::link(
		Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
		$this->createUrl('admin'),
		array(
			'title' => 'Ulang',
			'class' => 'btn btn-default',
			'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
		)
	); ?>
	<?php echo CHtml::link(
		Yii::t('mds', '{icon} Pengaturan Tabular List', array('{icon}' => '<i class="entypo-folder"></i>')),
		$this->createUrl('Admin', array('modul_id' => Yii::app()->session['modul_id'])),
		array('class' => 'btn btn-success',)
	); ?>
	<?php
	$content = $this->renderPartial($this->path_view . 'tips/tipsCreateUpdate', array(), true);
	$this->widget('UserTips', array('content' => $content));
	?>
</div>

<?php $this->endWidget(); ?>