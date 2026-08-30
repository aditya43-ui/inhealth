<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kpprestasikerja-r-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'prestasikerja_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tglprestasidiperoleh',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nourutprestasi',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'instansipemberi',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'pejabatpemberi',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'namapenghargaan',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textAreaRow($model,'keteranganprestasi',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

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
