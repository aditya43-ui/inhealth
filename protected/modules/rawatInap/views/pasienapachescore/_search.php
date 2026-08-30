<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ripasienapachescore-t-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'pasienapachescore_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pasien_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'apachescore_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pasienadmisi_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pendaftaran_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tglscoring',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'gagalginjalakut'); ?>

	<?php echo $form->textFieldRow($model,'point_nama',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'point_nilai',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'point_score',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'paramedis_id',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'catatanapachescore',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
