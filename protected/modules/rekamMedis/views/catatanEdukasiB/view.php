<?php
$this->breadcrumbs=array(
	'Edukasi B'=>array('admin'),
	$model->catatanedukasib_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>Edukasi B</b></legend>
		<div class="row-fluid">
		<div class="col-sm-12">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'nama_edukasi',
					'isi_edukasi',
					'urutan'
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->catatanedukasib_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Edukasi B',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('type'=>'view')); ?>
		</div>
	</div>
</div>
