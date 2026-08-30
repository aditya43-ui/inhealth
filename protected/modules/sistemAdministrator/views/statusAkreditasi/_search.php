<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gfatc-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row">
	<div class="span1"></div>
	<div class="col-sm-6">
		<?php echo CHtml::activeHiddenField($model,'lookup_type',array('class'=>'span3','value'=>'statusakreditasrs')); ?>
		<div class="control-group">
			<?php echo CHtml::label('Nama Status Akreditasi','lookup_name', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model,'lookup_name',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Nama Lain Status Akreditasi','lookup_value', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model,'lookup_value',array('class'=>'span3')); ?>
			</div>
		</div>
		<?php echo $form->checkBoxRow($model,'lookup_aktif',array('checked'=>'checked')); ?>
	</div>
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
		<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
