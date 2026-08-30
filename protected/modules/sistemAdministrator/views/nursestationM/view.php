<?php
$this->breadcrumbs=array(
	'Nurse Station'=>array('admin'),
	$model->nursestation_id,
);
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Lihat <strong>Nurse Station</strong></div>
            </div>
            <div class="panel-body">
				<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
					<div class="row-fluid">
					<div class="span6">
					<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
							'data'=>$model,
							'attributes'=>array(
								'nursestation_id',
							'nursestation_nama',
							'nursestation_namalain',
							'nursestation_lokasi',
							//'nursestation_telp',
							//'nursestation_pj_id',
							//'nursestation_akitf',
							),
					)); ?>
					</div>
					<div class="span6">
						<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
							'data'=>$model,
							'attributes'=>array(
								//'nursestation_id',
							//'nursestation_nama',
							//'nursestation_namalain',
							//'nursestation_lokasi',
							'nursestation_telp',
							'nursestation_pj_id',
							'nursestation_akitf',
							),
					)); ?>
					</div>
				</div>
				<div class="row-fluid">
					<div class="form-actions">
					<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->nursestation_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
					<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Nurse station',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
					<?php $this->widget('UserTips',array('content'=>''));?>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

