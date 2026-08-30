<?php
$this->breadcrumbs=array(
	'Saanastesi Ms'=>array('index'),
	$model->anastesi_id,
);
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title judul">Lihat <b>Anestesi</b></div>
    </div>
    <div class="panel-body">
        
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
				array(
					'label'=>'ID',
					'value'=>$model->anastesi_id,
				),
				'jenisanastesi.jenisanastesi_nama',
				'anastesi_nama',
				'anastesi_namalainnya',
				//'anastesi_aktif',
				//'daftartindakan_id',
				array(
					'name'=>'anastesi_aktif',
					'type'=>'raw',
					'value'=>(($model->anastesi_aktif ==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
				),
				),
		)); ?>
		</div>
		<div class="span6">
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->anastesi_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Anestesi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
</div>
