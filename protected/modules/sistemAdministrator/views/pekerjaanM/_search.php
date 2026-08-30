<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
        'id'=>'sajenis-pekerjaan-m-search',
)); ?>

	<?php //echo $form->textFieldRow($model,'pekerjaan_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pekerjaan_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'pekerjaan_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>
        <div>
            <?php echo $form->checkBoxRow($model,'pekerjaan_aktif',array('checked'=>'pekerjaan_aktif')); ?>
        </div>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
