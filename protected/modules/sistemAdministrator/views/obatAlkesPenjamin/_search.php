<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'id' => 'sabank-rek-m-search',
	'type' => 'horizontal',
		));
?>

<div class="row-fluid">
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')); ?>
			<div class="controls">
						<?php echo $form->dropDownList($model, 'penjamin_id', CHtml::listData(PenjaminpasienM::model()->findAll(), 'penjamin_id', 'penjamin_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Jenis Obat Alkes', 'jenisobatalkes_id', array('class' => 'control-label')); ?>
			<div class="controls">
						<?php echo $form->dropDownList($model, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll(), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
			</div>
		</div>
	</div>
</div>

<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset')); ?>
</div>

<?php $this->endWidget(); ?>
