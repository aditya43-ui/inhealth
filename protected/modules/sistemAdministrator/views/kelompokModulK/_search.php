<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
     'id'=>'sakelompok-menu-k-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'kelompokmodul_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'kelompokmodul_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'kelompokmodul_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>

	<?php // echo $form->textAreaRow($model,'kelompokmodul_fungsi',array('rows'=>6, 'cols'=>30, 'class'=>'span4')); ?>
        <div>
            <?php echo $form->checkBoxRow($model,'kelompokmodul_aktif',array('checked'=>'kelompokmodul_aktif')); ?>
        </div>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
