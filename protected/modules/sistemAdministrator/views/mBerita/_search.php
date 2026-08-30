<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'samberita-m-search',
        'type'=>'horizontal',
)); ?>
<div class="row">

	<div class="col-sm-4">
		<?php echo $form->textFieldRow($model,'mkategoriberita_id',array('class'=>'span4')); ?>

		<?php echo $form->textFieldRow($model,'judulberita',array('class'=>'span4','maxlength'=>200)); ?>

		<?php echo $form->textFieldRow($model,'ringkasanberita',array('class'=>'span4','maxlength'=>500)); ?>

		<?php echo $form->textAreaRow($model,'isiberita',array('rows'=>6, 'cols'=>50, 'class'=>'span4')); ?>

		<?php echo $form->textFieldRow($model,'gambarberita_text',array('class'=>'span3','maxlength'=>100)); ?>
	</div>

	<div class="col-sm-4">
		<?php echo $form->textAreaRow($model,'keteranganberita',array('rows'=>6, 'cols'=>50, 'class'=>'span4')); ?>

		<?php echo $form->textAreaRow($model,'beritaterkait',array('rows'=>6, 'cols'=>50, 'class'=>'span4')); ?>

		<?php echo $form->textFieldRow($model,'waktutampilberita',array('class'=>'span4')); ?>
	</div>

	<div class="col-sm-4">
		<?php echo $form->textFieldRow($model,'waktuselesaitampil',array('class'=>'span4')); ?>

		<?php //echo $form->textFieldRow($model,'tglbuatberita',array('class'=>'span3')); ?>

		<?php //echo $form->textFieldRow($model,'create_user',array('class'=>'span3','maxlength'=>100)); ?>
	</div>
</div>

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
