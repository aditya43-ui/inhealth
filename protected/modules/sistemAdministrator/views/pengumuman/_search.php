<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapengumuman-search',
        'type'=>'horizontal',
)); ?>

	<?php echo $form->textFieldRow($model,'judul',array('class'=>'span3','maxlength'=>150)); ?>

	<?php echo $form->textAreaRow($model,'isi',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="control-group">
            <?php echo $form->labelEx($model,'status_publish',array('class'=>'control-label')); ?>
                <div class="controls">
                <?php echo $form->checkBox($model,'status_publish',array('rel'=>'tooltip','title'=>'Centang untuk mengaktifkan','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
