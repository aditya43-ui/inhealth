<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'id' => 'saloket-m-search',
	'type' => 'horizontal',
)); ?>
<div class="row">
	<div class="col-sm-6">
		<?php //echo $form->textFieldRow($model,'loket_id',array('class'=>'span3')); 
		?>
		<?php echo $form->textFieldRow($model, 'loket_nourut', array('placeholder' => 'No. Urut', 'class' => 'span4')); ?>
		<?php echo $form->textFieldRow($model, 'loket_nama', array('placeholder' => 'Nama Loket', 'class' => 'span4', 'maxlength' => 50)); ?>

		<?php echo $form->textFieldRow($model, 'loket_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span4', 'maxlength' => 50)); ?>

	</div>
	<div class="col-sm-6">
		<?php echo $form->textAreaRow($model, 'loket_fungsi', array('placeholder' => 'Fungsi', 'rows' => 3, 'cols' => 30, 'class' => 'span4')); ?>
		<?php echo $form->textFieldRow($model, 'loket_singkatan', array('placeholder' => 'Singkatan', 'class' => 'span4', 'maxlength' => 1)); ?>


		<?php //echo $form->textFieldRow($model,'loket_formatnomor',array('class'=>'span3','maxlength'=>5)); 
		?>

		<?php //echo $form->textFieldRow($model,'loket_maksantrian',array('class'=>'span3')); 
		?>

	</div>
	<div class="col-sm-6">
		<?php echo $form->checkBoxRow($model, 'loket_aktif', array('checked' => 'loket_aktif')); ?>
		<?php //echo $form->textFieldRow($model,'carabayar_id',array('class'=>'span3')); 
		?>

		<?php //echo $form->textFieldRow($model,'filesuara',array('class'=>'span3','maxlength'=>500)); 
		?>

		<?php //echo $form->checkBoxRow($model,'ispendaftaran'); 
		?>

		<?php //echo $form->checkBoxRow($model,'iskasir'); 
		?>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
		array(
			'title' => 'Cari',
			'class' => 'btn btn-primary',
			'type' => 'submit'
		)
	); ?>
	<?php echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
		array(
			'title' => 'Ulang',
			'class' => 'btn btn-default',
			'type' => 'reset'
		)
	); ?>
</div>

<?php $this->endWidget(); ?>