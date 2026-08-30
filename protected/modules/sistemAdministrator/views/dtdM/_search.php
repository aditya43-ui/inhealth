<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sadtd-m-search',
        'type'=>'horizontal',
)); ?>

<?php //echo $form->textFieldRow($model,'dtd_id',array('class'=>'span5')); ?>

<?php //echo $form->textFieldRow($model,'diagnosa_id',array('class'=>'span3')); ?>

<?php // echo $form->textFieldRow($model,'dtd_no',array('class'=>'span1','maxlength'=>10)); ?>

<div class="row">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'dtd_noterperinci',array('class'=>'span1','maxlength'=>50)); ?>
		<?php echo $form->textFieldRow($model,'dtd_nama',array('class'=>'span3','maxlength'=>50)); ?>
		<?php //echo $form->checkBoxRow($model,'dtd_aktif',array('checked'=>'dtd_aktif')); ?>
		<div class="control-group">
				<?php echo CHtml::label("",'dtd_aktif', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'dtd_aktif',array('checked'=>'dtd_aktif')); ?> <label>Aktif</label>
				</div>				
			</div>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'dtd_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>	
		<?php echo $form->textFieldRow($model,'dtd_katakunci',array('class'=>'span3','maxlength'=>50)); ?>
	</div>
	<div class="col-sm-6">		
		<?php //echo $form->textFieldRow($model,'dtd_nourut',array('class'=>'span5')); ?>
		<?php //echo $form->checkBoxRow($model,'dtd_menular',array('checked'=>'dtd_menular')); ?>
		<div class="control-group">
				<?php echo CHtml::label("",'dtd_menular', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'dtd_menular',array('checked'=>'dtd_menular')); ?> <label>Menular</label>
				</div>				
			</div>
	</div>
</div>

<div class="form-actions">
	<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
