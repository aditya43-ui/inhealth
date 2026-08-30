
<div class="row">
<div class="col-md-12">
	<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Lihat Jadwal Dokter</div>
	</div>
	<div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Jadwal Dokter'=>array('admin'),
            $model->jadwaldokter_id,
    );


    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'jadwaldokter_id',
                    'instalasi.instalasi_nama',
                    'ruangan.ruangan_nama',
                    'pegawai.nama_pegawai',
                    'jadwaldokter_hari',
                    'jadwaldokter_buka',
                    'jadwaldokter_mulai',
                    'jadwaldokter_tutup',
                    'maximumantrian',
                    'maksbuatjanji',
            ),
    )); ?>

    <div class="row-fluid">
        <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update&id='.$model->jadwaldokter_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jadwal Dokter',array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
    </div>
	</div>
	</div>
</div>
</div>