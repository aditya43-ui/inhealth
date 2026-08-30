<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'satipeanastesi-m-search',
	'type'=>'horizontal',
)); ?>

	
	<?php echo $form->textFieldRow($model,'typeanastesi_nama',array('class'=>'span3','maxlength'=>30)); ?>
	<?php echo $form->textFieldRow($model,'typeanastesi_namalain',array('class'=>'span3','maxlength'=>30)); ?>
	<?php echo $form->checkBoxRow($model,'typeanastesi_aktif', array('checked'=>'typeanastesi_aktif')); ?>

	<div class="actions">
		<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
