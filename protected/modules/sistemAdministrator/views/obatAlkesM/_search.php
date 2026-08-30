<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
		<?php echo $form->dropDownListRow($model,'sumberdana_id',CHtml::listData(SumberdanaM::model()->findAll("sumberdana_aktif = TRUE ORDER BY sumberdana_nama ASC"),'sumberdana_id','sumberdana_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
		<?php echo $form->dropDownListRow($model, 'jnskelompok', LookupM::getItems('jnskelompok'), array('empty'=>'-- Pilih --'));  ?>
		<?php echo $form->textFieldRow($model,'harganetto',array('class'=>'span3 numbers-only','maxlength'=>20, 'style'=>'text-align:right;')); ?>  
		<?php //echo $form->dropDownListRow($model,'satuankecil_id',CHtml::listData($model->getSatuankecilItems(),'satuankecil_id','satuankecil_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
		<?php //echo CHtml::hiddenfield('SAObatalkesM[harganetto]');?>
		<?php echo CHtml::hiddenfield('SAObatalkesM[hargajual]');?>	
		<?php echo $form->dropDownListRow($model,'jenisobatalkes_id',CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
		<?php echo $form->dropDownListRow($model, 'obatalkes_kategori', ObatAlkesKategori::items(), array('empty'=>'-- Pilih --'));  ?>		
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'obatalkes_kode',array('class'=>'span3 custom-only','maxlength'=>200)); ?>            
		<?php echo $form->dropDownListRow($model, 'obatalkes_golongan', ObatAlkesGolongan::items(), array('empty'=>'-- Pilih --')) ?>
		<?php echo $form->textFieldRow($model,'obatalkes_nama',array('class'=>'span3 custom-only','maxlength'=>200)); ?>
		<?php echo $form->checkBoxRow($model,'obatalkes_aktif',array('checked'=>'obatalkes_aktif')); ?>		
	</div>
</div>
<?php //echo $form->textFieldRow($model,'obatalkes_kode',array('class'=>'span3','maxlength'=>50)); ?>

<?php //echo $form->textFieldRow($model,'obatalkes_golongan',array('class'=>'span3','maxlength'=>50)); ?>

<?php //echo $form->textFieldRow($model,'obatalkes_kategori',array('class'=>'span3','maxlength'=>50)); ?>

<?php //echo $form->textFieldRow($model,'obatalkes_kadarobat',array('class'=>'span3','maxlength'=>20)); ?>

<?php //echo $form->textFieldRow($model,'kemasanbesar',array('class'=>'span3')); ?>

<?php //echo $form->textFieldRow($model,'kekuatan',array('class'=>'span3')); ?>

<?php //echo $form->textFieldRow($model,'satuankekuatan',array('class'=>'span3','maxlength'=>20)); ?>

<?php //echo $form->textFieldRow($model,'harganetto',array('class'=>'span3')); ?>

<?php //echo $form->textFieldRow($model,'hargajual',array('class'=>'span3')); ?>

<?php //echo $form->textFieldRow($model,'discount',array('class'=>'span3')); ?>

<?php //echo $form->textFieldRow($model,'tglkadaluarsa',array('class'=>'span3')); ?>

<?php //echo $form->textFieldRow($model,'minimalstok',array('class'=>'span3')); ?>

<?php //echo $form->textFieldRow($model,'formularium',array('class'=>'span3','maxlength'=>50)); ?>

<?php //echo $form->checkBoxRow($model,'discountinue',array('checked'=>'discountinue')); ?>	
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
</div>
<?php $this->endWidget(); ?>
