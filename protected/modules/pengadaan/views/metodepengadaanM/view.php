<?php
$this->breadcrumbs=array(
	'Metodepengadaan Ms'=>array('index'),
	$model->metodepengadaan_id,
);
?>
<div class="white-container">
    <div class="panel panel-gradient">
        <div class="panel panel-heading">
            <div class="panel-title"> Lihat <b> Metode Pengadaan</b> </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
				'metodepengadaan_nama',
				'metodepengadaan_namalain',
				'metodepengadaan_ket',
				'metodepengadaan_urutan',
				array(
                                        'label' => 'Status',
                                        'type' => 'raw',
                                        'value' => ($model->metodepengadaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                                    ),
                                ),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->metodepengadaan_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Metode Pengadaan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
        </div>
    </div>
</div>
