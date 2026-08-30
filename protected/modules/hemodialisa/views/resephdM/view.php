<?php
$this->breadcrumbs=array(
	'Resephd Ms'=>array('index'),
	$model->resephd_id,
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Lihat <b>Paket HD</b></div>
    </div>
    <div class="panel-body">
		<div class="row-fluid">
			<div class="col-sm-6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
					'data'=>$model,
					'attributes'=>array(
										array(
											'name'=>'ID Paket HD',
											'value'=>$model->resephd_id
										),
										array(
											'name'=>'Nama Paket HD',
											'value'=>$model->resephd_nama
										),
	//					'resephd_id',
	//				'resephd_nama',
					'resephd_desc',
					array(
					'label'=>'Aktif.',
					'type'=>'raw',
					'value' => (($model->resephd_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
				),
					),
			)); ?>
			</div>
			<div class="span6">
				
			</div>
		</div>
		<div class="row-fluid">
			<div class="form-actions">
			<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->resephd_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Paket HD',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
			<?php $this->widget('UserTips',array('content'=>''));?>
			</div>
		</div>
	</div>
</div>

