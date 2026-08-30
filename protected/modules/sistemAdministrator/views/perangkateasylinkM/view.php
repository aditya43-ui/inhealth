<?php
$this->breadcrumbs=array(
	'Alat Absensi EasyLink'=>array('admin'),
	$model->perangkateasylink_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Lihat <b>Alat Absensi EasyLink</b></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                        'perangkateasylink_id',
                        'perangkat_ip',
                        'perangkat_port',
                        'perangkat_sn',
                        //'update_time',
                        //'create_loginpemakai_id',
                        //'update_loginpemakai_id',
                        //'create_ruangan',
                    ),
		)); ?>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update',array('id'=>$model->perangkateasylink_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Alat Absensi EasyLink',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>

    </div>
</div>

