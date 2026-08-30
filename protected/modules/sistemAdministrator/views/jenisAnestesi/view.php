<?php
$this->breadcrumbs=array(
	'Sajenis Anastesi Ms'=>array('index'),
	$model->jenisanastesi_id,
);
?>
<div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title judul">Lihat <b>Jenis Anestesi</b></div>
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
					'value'=>$model->jenisanastesi_id,
				),
				'jenisanastesi_nama',
				'jenisanastesi_namalainnya',
//				'jenisanastesi_teknik',
				array(
					'name'=>'jenisanastesi_aktif',
					'type'=>'raw',
					'value'=>(($model->jenisanastesi_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
				),
				//'jenisanastesi_teknik',
				//'jenisanastesi_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->jenisanastesi_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Anestesi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
</div>
