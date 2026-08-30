

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
                'id'=>'search-form',
	'method'=>'get',
                'type'=>'horizontal',
)); ?>
		<?php // echo $form->textFieldRow($model,'esselon_id'); ?>
		<?php echo $form->textFieldRow($model,'esselon_nama',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->textFieldRow($model,'esselon_namalainnya',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->checkBoxRow($model,'esselon_aktif',array('checked'=>true)); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
