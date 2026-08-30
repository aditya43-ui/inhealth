<?php
$this->breadcrumbs=array(
	'Aksesvaskular Ms'=>array('index'),
	$model->aksesvaskular_id,
);
?>

<div class="white-container">
	<legend class="rim2">Lihat <b>Akses Vaskular</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'aksesvaskular_id',
				'aksesvaskular_nama',
				'aksesvaskular_namalain',
				//'aksesvaskular_deskripsi',
				//'aksesvaskular_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'aksesvaskular_id',
				//'aksesvaskular_nama',
				//'aksesvaskular_namalain',
				'aksesvaskular_deskripsi',
				'aksesvaskular_aktif',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->aksesvaskular_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Akses Vaskular',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
