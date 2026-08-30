<?php
$this->breadcrumbs=array(
	'Penyertaetilogi Ms'=>array('index'),
	$model->penyertaetilogi_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>Penyertaetilogi</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'penyertaetilogi_id',
				'penyertaetilogi_kode',
				'penyertaetilogi_nama',
				//'penyertaetilogi_namalain',
				//'penyertaetilogi_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'penyertaetilogi_id',
				//'penyertaetilogi_kode',
				//'penyertaetilogi_nama',
				'penyertaetilogi_namalain',
				'penyertaetilogi_aktif',
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->penyertaetilogi_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Penyerta etiologi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
