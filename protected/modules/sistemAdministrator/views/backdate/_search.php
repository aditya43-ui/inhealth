<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'backdate-k-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->dropDownListRow($model,'modul_id',CHtml::listData(ModulK::model()->findAll('modul_aktif = true order by modul_nama asc'), 'modul_id', 'modul_nama'), array('empty' => '-- Pilih --', 'class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'deskripsi_menu',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
	<?php echo $form->textFieldRow($model,'deskripsi_backdate',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->checkBoxRow($model,'isbackdate'); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
