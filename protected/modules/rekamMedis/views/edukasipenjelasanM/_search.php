<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'edukasipenjelasan-m-search',
	'type'=>'horizontal',
)); ?>

	<?php echo $form->dropDownListRow($model, 'kodeedukator', LookupM::getItems('kodeedukator'), array(
                                    'empty'=>'-- Pilih --', 'class'=>'span3'
    )); ?>

	<?php echo $form->textFieldRow($model,'nama_penjelasan',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'urutan',array('class'=>'span3 numbers-only')); ?>

    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'is_aktif'); ?>
            <?php echo $form->label($model,'is_aktif'); ?>
        </div>
    </div>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-default', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
