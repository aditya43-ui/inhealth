<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'luluskomponendarah-t-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'luluskomponendarah_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'kantongdarah_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'tglpelulusan',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'statuspelulusan',array('class'=>'span3','maxlength'=>25)); ?>

	<?php echo $form->textFieldRow($model,'koordinatormutu_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'kepalainstalasi_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textAreaRow($model,'keteranganpelulusan',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 numbers-only')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
		<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
