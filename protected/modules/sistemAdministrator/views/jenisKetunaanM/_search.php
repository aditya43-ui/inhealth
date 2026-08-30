<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmjenis-ketunaan-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'jenisketunaan_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'jenisketunaan_kode',array('class'=>'span3','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'jenisketunaan_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'jenisketunaan_namalainnya',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->checkBoxRow($model,'jenisketunaan_aktif',array('checked'=>'$data->jenisketunaan_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
