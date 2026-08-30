<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'samkategoriberita-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'mkategoriberita_id',array('class'=>'span3')); ?>
<div class="row">

	<div class="col-sm-4">
	<?php echo $form->textFieldRow($model,'kategoriberita',array('class'=>'span4','maxlength'=>100)); ?>
	<?php echo $form->textFieldRow($model,'urutankategori',array('class'=>'span4')); ?>
	</div>

	<div class="col-sm-4">
	<?php echo $form->textAreaRow($model,'ketkategoriberita',array('rows'=>3, 'cols'=>50, 'class'=>'span4')); ?>
	</div>

	<div class="col-sm-4">
	
	<?php echo $form->checkBoxRow($model,'kategoriberita_aktif'); ?>
	</div>
</div>
	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
