<?php
$this->breadcrumbs=array(
	'Isiinformasi Ms'=>array('index'),
	$model->isiinformasi_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>IsiinformasiM</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'isiinformasi_id',
				'jenisinformasi_id',
				'isiinformasi_nama',
				'infosebelumcheckbox',
				'infosetelahcheckbox',
				'isiinformasi_urutan',
				//'isiinformasi_aktif',
				//'create_time',
				//'update_time',
				//'create_loginpemakai_id',
				//'update_loginpemakai_id',
				//'create_ruangan',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'isiinformasi_id',
				//'jenisinformasi_id',
				//'isiinformasi_nama',
				//'infosebelumcheckbox',
				//'infosetelahcheckbox',
				//'isiinformasi_urutan',
				'isiinformasi_aktif',
				'create_time',
				'update_time',
				'create_loginpemakai_id',
				'update_loginpemakai_id',
				'create_ruangan',
				),
		)); ?>
		</div>
	</div>
	<div class="row">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->isiinformasi_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan IsiinformasiM',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
