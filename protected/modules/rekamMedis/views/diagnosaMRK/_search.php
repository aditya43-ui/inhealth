<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sadiagnosa-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'diagnosa_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'diagnosa_kode',array('class'=>'span1','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'diagnosa_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'diagnosa_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'diagnosa_katakunci',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'diagnosa_nourut',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'diagnosa_imunisasi'); ?>

	<?php echo $form->checkBoxRow($model,'diagnosa_aktif'); ?>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
