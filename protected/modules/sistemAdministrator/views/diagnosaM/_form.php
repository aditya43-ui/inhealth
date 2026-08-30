<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'sadiagnosa-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'return requiredCheck(this);'),
	'focus' => '#' . CHtml::activeId($model, 'diagnosa_kode'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<div class="row">
	<div class="col-sm-6">
		<?php
		echo $form->dropDownListRow($model, 'dtd_id', CHtml::listData(DtdM::model()->findAll("dtd_aktif = TRUE ORDER BY dtd_kode ASC"), 'dtd_id', 'dtd_kode'), array(
			'class' => 'required', 'empty' => '-- Pilih --',
			// 'ajax' => array(
			// 	'type' => 'POST',
			// 	'url' => Yii::app()->createUrl('ActionDynamic/GetKlasifikasiKode', array('encode' => false, 'model_nama' => '' . $model->getNamaModel() . '')),
			// 	'update' => '#' . CHtml::activeId($model, 'klasifikasidiagnosa_id') . ''
			// ),
			'onkeypress' => "return $(this).focusNextInputField(event)",
			// 'onchange' => 'clearKode()'
		));
		echo $form->dropDownListRow($model, 'klasifikasidiagnosa_id', CHtml::listData(KlasifikasidiagnosaM::model()->findAllByAttributes(array('klasifikasidiagnosa_aktif' => TRUE), array('order' => 'klasifikasidiagnosa_kode ASC')), 'klasifikasidiagnosa_id', 'KlasifikasiKodeNama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'class' => 'required', 'empty' => '-- Pilih --', 'onchange' => 'getKode();return false;'));

		?>
		<div class="control-group">
			<?php echo CHtml::label("Kode", 'diagnosa_kode', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model, 'kode1', array('placeholder' => '00', 'class' => 'span1 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?>
				<?php echo $form->textField($model, 'kode2', array('placeholder' => '00', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3)); ?>
			</div>
		</div>

		<?php echo $form->textFieldRow($model, 'diagnosa_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
		<?php echo $form->textFieldRow($model, 'diagnosa_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
	</div>

	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model, 'diagnosa_katakunci', array('placeholder' => 'Kata Kunci', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
		<?php echo $form->textFieldRow($model, 'diagnosa_nourut', array('placeholder' => 'No. Urut', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 9)); ?>
		<?php //echo $form->checkBoxRow($model,'diagnosa_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
		?>
		<div class="control-group">
			<?php echo CHtml::label("", 'diagnosa_aktif', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->checkBox($model, 'diagnosa_aktif', array()); ?> <label>Aktif</label>
			</div>
		</div>
		<?php //echo $form->checkBoxRow($model,'diagnosa_imunisasi', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
		?>
		<div class="control-group">
			<?php echo CHtml::label("", 'diagnosa_imunisasi', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->checkBox($model, 'diagnosa_imunisasi', array()); ?> <label>Imunisasi</label>
			</div>
		</div>
	</div>

</div>
<div class="row">
	<!--	<div class="control-group">
		<?php // echo CHtml::label('DTD Diagnosa', 'dtd_id', array('class'=>'control-label')); 
		?>
		<div class="controls">-->
	<?php
	//			$arrDTD = array();
	//			foreach($modDTDDiagnosaM as $data){
	//				$arrDTD[] = $data['dtd_id'];
	//			} 
	//			$this->widget('application.extensions.emultiselect.EMultiSelect',
	//				array('sortable'=>true, 'searchable'=>true)
	//			);
	//			echo CHtml::dropDownList(
	//				'dtd_id[]',
	//				$arrDTD,
	//				CHtml::listData(SADtdM::model()->findAll(array('order'=>'dtd_nama')), 'dtd_id', 'dtd_nama'),
	//				array('multiple'=>'multiple','key'=>'dtd_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
	//			);
	?>
	<!--		</div>
			</div>-->
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(
		$model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
			Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
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
		Yii::t('mds', '{icon} Pengaturan Diagnosa ICD 10', array('{icon}' => '<i class="entypo-folder"></i>')),
		$this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
		array('class' => 'btn btn-success',)
	); ?>
	<?php
	$content = $this->renderPartial($this->path_view . 'tips/tipsCreateUpdate', array(), true);
	$this->widget('UserTips', array('content' => $content));
	?>
</div>

<?php $this->endWidget(); ?>

<script>
	function getKode() {
		var ru = $("#SADiagnosaM_klasifikasidiagnosa_id option:selected").html();
		var data = ru.substring(0, 3);
		$("#SADiagnosaM_kode1").val(data);
	}

	function clearKode() {
		$("#SADiagnosaM_kode1").val('');
		$("#SADiagnosaM_kode2").val('');
	}
</script>