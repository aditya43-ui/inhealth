<?php
$this->breadcrumbs=array(
	'Lokasi Karcis Antrian'=>array('admin'),
	$model->lokasi_karcisantrian_id,
);
?>
<!--<div class="white-container">
	<legend class="rim2">Lihat <b>Loket</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title">
            Lihat <b>Loket</b>
        </div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
                                    'lokasi_karcisantrian_id',
                                    'lokasi_karcisantrian_nama',
                                    'lokasi_karcisantrian_judul',   
                                    array(
                                        'label' => 'Status',
                                        'value' => ($model->lokasi_karcisantrian_aktif)?'Aktif':'Tidak Aktif'
                                    ),
				),
		)); ?>
		</div>		
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->lokasi_karcisantrian_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Lokasi Karcis Antrian',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('type'=>'view'));?>
		</div>
	</div>
</div>
</div>
