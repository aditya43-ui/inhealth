<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmsebab-diagnosa-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'sebabdiagnosa_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'jenissebab_id',array('class'=>'span3')); ?>
	<?php echo $form->dropDownListRow($model,'jenissebab_id',CHtml::listData($model->JenisSebabItems, 'jenissebab_id', 'jenissebab_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>

	<?php echo $form->textFieldRow($model,'sebabdiagnosa_nama',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'sebabdiagnosa_namalainnya',array('class'=>'span3','maxlength'=>100)); ?>

	<?php echo $form->checkBoxRow($model,'sebabdiagnosa_aktif',array('checked'=>'$data->sebabdiagnosa_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
