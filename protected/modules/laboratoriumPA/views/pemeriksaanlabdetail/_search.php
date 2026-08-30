<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'lkpemeriksaanlabdet-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'pemeriksaanlabdet_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nilairujukan_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pemeriksaanlab_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pemeriksaanlabdet_nourut',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
