<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jenisskriningpasien-m-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'jenisskriningpasien_nama',array('class'=>'span3','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'jenisskriningpasien_namalainnya',array('class'=>'span3','maxlength'=>255)); ?>

<div class="control-group">
    <label class="control-label">&nbsp;</label>
    <div class="controls">
	<?php echo $form->checkBox($model,'isaktif'); ?> <label>Aktif</label>
        
    </div>
</div>


	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
