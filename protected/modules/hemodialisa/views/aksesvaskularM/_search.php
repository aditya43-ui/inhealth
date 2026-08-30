<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'aksesvaskular-m-search',
	'type'=>'horizontal',
)); ?>

	<?php // echo $form->textFieldRow($model,'aksesvaskular_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'aksesvaskular_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'aksesvaskular_namalain',array('class'=>'span3','maxlength'=>50)); ?>

	<?php // echo $form->textAreaRow($model,'aksesvaskular_deskripsi',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php // echo $form->checkBoxRow($model,'aksesvaskular_aktif'); ?>
        <div class="control-group">
            <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'aksesvaskular_aktif',array('checked'=>true)); ?> <label>Akses Vaskular Aktif</label>
            </div>
        </div>
	
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
