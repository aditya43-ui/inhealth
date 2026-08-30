<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jenissimpanan-m-search',
	'type'=>'horizontal',
)); ?>

	<?php // echo $form->textFieldRow($model,'jenissimpanan_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'kodesimpanan',array('class'=>'span3','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'jenissimpanan',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'jenissimpanan_namalain',array('class'=>'span3','maxlength'=>30)); ?>

	<?php /* echo $form->textFieldRow($model,'jangkapenarikanbln',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'persenjasathn',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'persenpajakthn',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'jns_create_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'jns_update_time',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'jns_create_login',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'jns_update_login',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->checkBoxRow($model,'jenissimpanan_aktif'); ?>

	<?php echo $form->textFieldRow($model,'jenissimpanan_singkatan',array('class'=>'span3','maxlength'=>4)); */ ?>

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
