<?php
$this->breadcrumbs=array(
	'Spesialis/Subspesialis'=>array('admin'),
	$model->spesialissubspesialis_id,
);
?>
<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Lihat <b>Spesialis/Subspesialis</b></div>
	</div>
	<div class="panel-body">
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
			<div class="row-fluid">
			<div class="col-sm-6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
					'data'=>$model,
					'attributes'=>array(
						'spesialissubspesialis_id',
					'jenis',
					'spesialissubspesialis_nama',
					'spesialissubspesialis_namalainnya',
					'spesialissubspesialis_kode',
					'spesialissubspesialis_kodebpjs',
					'spesialis_id',
					//'spesialissubspesialis_urutan',
					//'spesialissubspesialis_aktif',
					//'create_time',
					//'update_time',
					//'create_loginpemakai_id',
					//'update_loginpemakai_id',
					),
			)); ?>
			</div>
			<div class="col-sm-6">
				<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
					'data'=>$model,
					'attributes'=>array(
						//'spesialissubspesialis_id',
					//'jenis',
					//'spesialissubspesialis_nama',
					//'spesialissubspesialis_namalainnya',
					//'spesialissubspesialis_kode',
					//'spesialissubspesialis_kodebpjs',
					//'spesialis_id',
					'spesialissubspesialis_urutan',
					'spesialissubspesialis_aktif',
					//'create_time',
					//'update_time',
					//'create_loginpemakai_id',
					//'update_loginpemakai_id',
					),
			)); ?>
			</div>
		</div>
		<div class="row-fluid">
			<div class="form-actions">
			<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->spesialissubspesialis_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Spesialis/Subspesialis',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
			<?php $this->widget('UserTips',array('content'=>''));?>
			</div>
		</div>
	</div>
</div>

