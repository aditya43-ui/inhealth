<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakelompok-m-search',
        'type'=>'horizontal',
)); ?>
<div class="row">
	<div class="col-sm-6">
		<?php echo $form->dropDownListRow($model,'golongan_id',CHtml::listData($model->getGolonganItems(), 'golongan_id', 'golongan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
		<?php echo $form->textFieldRow($model,'kelompok_kode',array('class'=>'span3 angkadot-only','maxlength'=>8)); ?>
		<?php echo $form->textFieldRow($model,'kelompok_nama',array('class'=>'span3 custom-only','maxlength'=>100)); ?>		
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'kelompok_namalainnya',array('class'=>'span3 custom-only','maxlength'=>100)); ?>
		<?php echo $form->dropDownListRow($model,'bidang_id',CHtml::listData($model->getBidangItems(), 'bidang_id', 'bidang_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
		<?php echo $form->checkBoxRow($model,'kelompok_aktif',array('checked'=>'kelompok_aktif')); ?>		
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>
<?php $this->endWidget(); ?>
