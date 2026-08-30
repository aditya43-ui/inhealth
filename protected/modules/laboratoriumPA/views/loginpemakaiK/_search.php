<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                 'type'=>'horizontal',
                 'id'=>'loginpemakai-m-search',
)); ?>

	<?php //echo $form->textFieldRow($model,'loginpemakai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nama_pemakai',array('class'=>'span3','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'katakunci_pemakai',array('class'=>'span3','maxlength'=>200)); ?>

	<?php //echo $form->textFieldRow($model,'lastlogin',array('class'=>'span2')); ?>

	<?php //echo $form->textFieldRow($model,'tglpembuatanlogin',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'tglupdatelogin',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'statuslogin'); ?>
            
	<?php echo $form->checkBoxRow($model,'loginpemakai_aktif',array('checked'=>'$data->loginpemakai_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
