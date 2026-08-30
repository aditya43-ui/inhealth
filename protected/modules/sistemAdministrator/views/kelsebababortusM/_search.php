<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pskelsebababortus-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'kelsebababortus_nama',array('class'=>'span3','maxlength'=>100)); ?> 
		<?php echo $form->checkBoxRow($model,'kelsebababortus_aktif', array('checked'=>'$data->kelsebababortus_aktif')); ?>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'kelsebababortus_namalain',array('class'=>'span3','maxlength'=>100)); ?>
	</div>
</div>
<?php //echo $form->textFieldRow($model,'kelsebababortus_id',array('class'=>'span5')); ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>
<?php $this->endWidget(); ?>
