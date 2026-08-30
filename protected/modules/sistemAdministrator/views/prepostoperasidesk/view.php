<?php
$this->breadcrumbs=array(
	'Checklist Pra dan Post Operasi'=>array('admin'),
	$model->prepostoperasidesk_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>Checklist Pra dan Post Operasi</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="col-sm-12">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'nama_prepostoperasidesk',
					'level_prepostoperasidesk',
					'jenischecklist',
					'urutan'
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->prepostoperasidesk_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Checklist Pra dan Post Operasi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('type'=>'view')); ?>
		</div>
	</div>
</div>
