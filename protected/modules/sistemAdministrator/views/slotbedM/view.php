
<div class="row">
<div class="col-md-12">
	<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Lihat Jadwal Bed</div>
	</div>
	<div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Jadwal Bed'=>array('index'),
            $model->slotbed_id,
    );


    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'slotbed_id',
                    'instalasi.instalasi_nama',
                    'jadwal_hari',
                    'jadwal_buka',
                    'jadwal_mulai',
                    'jadwal_tutup',
            ),
    )); ?>

    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update&id='.$model->slotbed_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jadwal Bed',array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
	</div>
	</div>
</div>
</div>