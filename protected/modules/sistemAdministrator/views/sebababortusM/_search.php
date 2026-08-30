<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pssebababortus-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row">
	<div class="col-sm-6">
		<?php echo $form->dropDownListRow($model,'kelsebababortus_id',  CHtml::listData($model->KelSebabAbortusItems, 'kelsebababortus_id', 'kelsebababortus_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
		<?php echo $form->textFieldRow($model,'sebababortus_nama',array('class'=>'span3','maxlength'=>100)); ?>
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'sebababortus_namalain',array('class'=>'span3','maxlength'=>100)); ?>
		<?php echo $form->checkBoxRow($model,'sebababortus_aktif', array('checked'=>'$data->sebababortus_aktif')); ?>
	</div>
</div>	
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>
<?php $this->endWidget(); ?>
