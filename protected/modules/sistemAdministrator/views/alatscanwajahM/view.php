<?php
$this->breadcrumbs=array(
	'Alatscanwajah Ms'=>array('index'),
	$model->alatscanwajah_id,
);
?>
<div class="white-container">
	<legend class="rim2">Lihat <b>AlatscanwajahM</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'alatscanwajah_id',
				'user_ip',
				'alat_ip',
				'create_time',
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
					//'alatscanwajah_id',
				//'user_ip',
				//'alat_ip',
				//'create_time',
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
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update',array('id'=>$model->alatscanwajah_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan AlatscanwajahM',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
