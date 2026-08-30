<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sabidang-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row">
	<div class="col-sm-6">
		<?php echo $form->dropDownListRow($model,'golongan_id',CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
		<?php echo $form->textFieldRow($model,'bidang_kode',array('class'=>'span3 angkadot-only','maxlength'=>5)); ?>
		<?php echo $form->textFieldRow($model,'bidang_nama',array('class'=>'span3 custom-only','maxlength'=>100)); ?>		
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'bidang_namalainnya',array('class'=>'span3 custom-only','maxlength'=>100)); ?>		
		<?php echo $form->checkBoxRow($model,'bidang_aktif',array('checked'=>'bidang_aktif')); ?>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>
<?php $this->endWidget(); ?>
