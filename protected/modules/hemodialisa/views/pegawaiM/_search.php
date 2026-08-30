<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapegawai-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'kelurahan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'kecamatan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'profilrs_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'gelarbelakang_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'suku_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'kelompokpegawai_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'pendkualifikasi_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'jabatan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'pendidikan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'propinsi_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'pangkat_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'kabupaten_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'no_kartupegawainegerisipil',array('class'=>'span3','maxlength'=>30)); ?>

	<?php //echo $form->textFieldRow($model,'no_karis_karsu',array('class'=>'span5','maxlength'=>30)); ?>

	<?php //echo $form->textFieldRow($model,'no_taspen',array('class'=>'span5','maxlength'=>30)); ?>

	<?php //echo $form->textFieldRow($model,'no_askes',array('class'=>'span5','maxlength'=>30)); ?>

	<?php //echo $form->textFieldRow($model,'gelardepan',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'nama_keluarga',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'tempatlahir_pegawai',array('class'=>'span5','maxlength'=>30)); ?>

	<?php //echo $form->textFieldRow($model,'tgl_lahirpegawai',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'jeniskelamin',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'statusperkawinan',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textAreaRow($model,'alamat_pegawai',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textFieldRow($model,'agama',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'golongandarah',array('class'=>'span5','maxlength'=>2)); ?>

	<?php //echo $form->textFieldRow($model,'rhesus',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'alamatemail',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'notelp_pegawai',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'nomobile_pegawai',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'warganegara_pegawai',array('class'=>'span5','maxlength'=>25)); ?>

	<?php //echo $form->textFieldRow($model,'jeniswaktukerja',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'kelompokjabatan',array('class'=>'span5','maxlength'=>30)); ?>

	<?php //echo $form->textFieldRow($model,'kategoripegawai',array('class'=>'span5','maxlength'=>10)); ?>

	<?php //echo $form->textFieldRow($model,'kategoripegawaiasal',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'photopegawai',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->checkBoxRow($model,'pegawai_aktif',array('checked'=>'pegawai_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
