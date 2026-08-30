<?php
$this->breadcrumbs=array(
	'Perhitunganem Ms'=>array('index'),
	$model->perhitunganem_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>PerhitunganemM</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'perhitunganem_id',
				'invperalatan_id',
				'res_fungsi_nama',
				'res_fungsi_nilai',
				'res_klinis_nama',
				'res_klinis_nilai',
				'res_pemeliharaan_nama',
				'res_pemeliharaan_nilai',
				'res_insiden_nama',
				//'res_insiden_nilai',
				//'nilai_em',
				//'frekuensi_inspeksi',
				//'perhitunganem_ket',
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
					//'perhitunganem_id',
				//'invperalatan_id',
				//'res_fungsi_nama',
				//'res_fungsi_nilai',
				//'res_klinis_nama',
				//'res_klinis_nilai',
				//'res_pemeliharaan_nama',
				//'res_pemeliharaan_nilai',
				//'res_insiden_nama',
				'res_insiden_nilai',
				'nilai_em',
				'frekuensi_inspeksi',
				'perhitunganem_ket',
				'create_time',
				'update_time',
				'create_loginpemakai_id',
				'update_loginpemakai_id',
				'create_ruangan',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->perhitunganem_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan PerhitunganemM',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
