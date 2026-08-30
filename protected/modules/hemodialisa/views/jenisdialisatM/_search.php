<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jenisdialisat-m-search',
	'type'=>'horizontal',
)); ?>
<br>
	<?php // echo $form->textFieldRow($model,'jenisdialisat_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->textFieldRow($model,'jenisdialisat_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'jenisdialisat_namalain',array('class'=>'span3','maxlength'=>100)); ?>

	<?php // echo $form->textAreaRow($model,'jenisdialisat_deskripsi',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
        <div class="control-group">
            <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'jenisdialisat_aktif',array('checked'=>true)); ?> <label>Jenis Dialisat Aktif</label>
            </div>
        </div>
	<?php // echo $form->checkBoxRow($model,'jenisdialisat_aktif'); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
