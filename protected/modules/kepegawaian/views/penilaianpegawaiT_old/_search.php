<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kppenilaianpegawai-t-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'penilaianpegawai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tglpenilaian',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'periodepenilaian',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sampaidengan',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'kesetiaan',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'prestasikerja',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tanggungjawab',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ketaatan',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'kejujuran',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'kerjasama',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'prakarsa',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'kepemimpinan',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'jumlahpenilaian',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nilairatapenilaian',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'performanceindex',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'penilaianpegawai_keterangan',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'keberatanpegawai',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'tanggal_keberatanpegawai',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'tanggapanpejabat',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'tanggal_tanggapanpejabat',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'keputusanatasan',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'tanggal_keputusanatasan',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'lainlain',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'dibuattanggalpejabat',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'diterimatanggalpegawai',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'diterimatanggalatasan',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'penilainama',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'penilainip',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'penilaipangkatgol',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'penilaijabatan',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'penilaiunitorganisasi',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'pimpinannama',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'pimpinannip',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'pimpinanpangkatgol',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'pimpinanjabatan',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'pimpinanunitorganisasi',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
