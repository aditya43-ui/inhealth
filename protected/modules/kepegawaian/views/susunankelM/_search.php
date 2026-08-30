<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kpsusunankel-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'susunankel_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nourutkel',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'hubkeluarga',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'susunankel_nama',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'susunankel_jk',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'susunankel_tempatlahir',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'susunankel_tanggallahir',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pekerjaan_nama',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'pendidikan_nama',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'susunankel_tanggalpernikahan',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'susunankel_tempatpernikahan',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'susunankeluarga_nip',array('class'=>'span5','maxlength'=>30)); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
