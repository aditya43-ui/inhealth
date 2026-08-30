<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jenishd-m-search',
	'type'=>'horizontal',
)); ?>
<br>
	<?php echo $form->textFieldRow($model,'jenishd_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'jenishd_namalain',array('class'=>'span3','maxlength'=>50)); ?>

	<?php // echo $form->textFieldRow($model,'jenishd_deskripsi',array('class'=>'span3','maxlength'=>200)); ?>

	<?php // echo $form->checkBoxRow($model,'jenishd_aktif'); ?>
        <div class="control-group">
            <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'jenishd_aktif',array('checked'=>true)); ?> <label>Jenis HD Aktif</label>
            </div>
        </div>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
