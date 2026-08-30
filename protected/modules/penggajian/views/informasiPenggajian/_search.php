<!--<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>-->
<div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
	</div>
	<div class="panel-body">
		<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
			'action'=>Yii::app()->createUrl($this->route),
			'method'=>'get',
			'id'=>'gjpenggajianpeg-t-search',
			'type'=>'horizontal',
			'focus'=>'#'.CHtml::activeId($model,'nomorindukpegawai'),
		)); ?>
		<div class="row">
			<div class="col-sm-6">
				<?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3')); ?>
				<?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3')); ?>				
			</div>
			<div class="col-sm-6">
				<?php echo $form->textFieldRow($model,'nopenggajian',array('class'=>'span3')); ?>				
				<?php //echo $form->textFieldRow($model,'penggajianpeg_id',array('class'=>'span5')); ?>
			</div>
		</div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
		Yii::app()->createUrl($this->module->id.'/informasiPenggajian'), 
		array('class' => 'btn btn-default',
		'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php //echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('PenggajianpegT/Informasi'), array('class'=>'btn btn-danger')); ?>
	<?php
		$content = $this->renderPartial('penggajian.views/tips/informasi_penggajianKaryawan',array('gaji'=>'gaji'),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
