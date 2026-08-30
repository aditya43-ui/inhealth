<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'samberitakomentar-t-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'mberitakomentar_id',array('class'=>'span3')); ?>
<div class="row">

	<div class="col-sm-4">
	<?php echo $form->textFieldRow($model,'mberita_id',array('class'=>'span4')); ?>

	<?php echo $form->textFieldRow($model,'tglkomentar',array('class'=>'span4')); ?>

	<?php echo $form->textFieldRow($model,'namakomentar',array('class'=>'span4','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'emailkomentar',array('class'=>'span4','maxlength'=>100)); ?>
	</div>

	<div class="col-sm-4">
	<?php echo $form->textAreaRow($model,'isikomentar',array('rows'=>6, 'cols'=>50, 'class'=>'span4')); ?>
	</div>

	<div class="col-sm-4">
	
	<?php echo $form->checkBoxRow($model,'tampilkankomentar'); ?>
	</div>
</div>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
