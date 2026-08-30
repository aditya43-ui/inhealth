<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmkeadaanumum-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'keadaanumum_id',array('class'=>'span3')); ?>

	<?php echo $form->textAreaRow($model,'keadaanumum_nama',array('rows'=>6, 'cols'=>50, 'class'=>'span3')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
