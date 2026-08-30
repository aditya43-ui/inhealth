<?php
$this->breadcrumbs=array(
	'Satypeanastesi Ms'=>array('index'),
	$model->typeanastesi_id,
);
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title judul">Lihat <b>Tipe Anestesi</b></div>
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
						'value'=>$model->typeanastesi_id,
					),
					array(
						'label'=>'Teknik Anestesi',
						'value'=>$model->anastesi->anastesi_nama,
					),
					'typeanastesi_nama',
					'typeanastesi_namalain',
					array(
						'name'=>'typeanastesi_aktif',
						'type'=>'raw',
						'value'=>(($model->typeanastesi_aktif ==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
					),
				),
		)); ?>
		</div>
		<div class="span6">
			
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->typeanastesi_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tipe Anestesi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
</div>
