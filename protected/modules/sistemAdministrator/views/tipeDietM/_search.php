<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'satipediet-m-search',
                 'type'=>'horizontal',
)); ?>
		<?php /* echo $form->textField($model,'tipediet_id'); */ ?>
		<?php echo $form->textFieldRow($model,'tipediet_nama',array('class'=>'span3','size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->textFieldRow($model,'tipediet_namalainnya',array('class'=>'span3','size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->checkBoxRow($model,'tipediet_aktif', array('checked'=>'tipediet_aktif')); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>