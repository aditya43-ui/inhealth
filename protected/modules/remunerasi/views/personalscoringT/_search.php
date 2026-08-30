
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textField($model,'personalscoring_id'); ?>
		<?php echo $form->textField($model,'pegawai_id'); ?>
		<?php echo $form->textField($model,'penilaianpegawai_id'); ?>
		<?php echo $form->textField($model,'tglscoring'); ?>
		<?php echo $form->textField($model,'periodescoring'); ?>
		<?php echo $form->textField($model,'sampaidengan'); ?>
		<?php echo $form->textField($model,'gajipokok'); ?>
		<?php echo $form->textField($model,'jabatan',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->textField($model,'pendidikan',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->textField($model,'totalscore'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
		<?php echo $form->textField($model,'update_time'); ?>
		<?php echo $form->textField($model,'create_loginpemakai_id'); ?>
		<?php echo $form->textField($model,'update_loginpemakai_id'); ?>
		<?php echo $form->textField($model,'create_ruangan'); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>