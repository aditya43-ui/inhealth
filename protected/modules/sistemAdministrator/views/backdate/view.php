<?php
$this->breadcrumbs=array(
	'Backdate Ks'=>array('index'),
	$model->backdate_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>BackdateK</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'backdate_id',
				'modul_id',
				//'deskripsi_backdate',
				//'isbackdate',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'backdate_id',
				//'modul_id',
				'deskripsi_backdate',
				'isbackdate',
				),
		)); ?>
		</div>
	</div>
	<div class="row">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update',array('id'=>$model->backdate_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan BackdateK',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
