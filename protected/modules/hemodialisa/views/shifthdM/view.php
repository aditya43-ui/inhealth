<?php
$this->breadcrumbs=array(
	'Shift HD'=>array('index'),
	$model->shift_hd_id,
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Shift HD</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
				'shift_hd_id',
				'shift_hd_nama',
				'shift_hd_namalainnya',
                                'shift_hd_jamawal',
                                'shift_hd_jamakhir',
                                'shift_hd_urutan',
				array(
                                'label'=>'Aktif.',
				'type'=>'raw',
				'value' => (($model->shift_hd_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
            ),
				),
		)); ?>
		</div>
		
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update',array('id'=>$model->shift_hd_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Shift HD',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
</div>
