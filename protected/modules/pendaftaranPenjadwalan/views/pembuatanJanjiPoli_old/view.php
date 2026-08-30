<?php
$this->breadcrumbs = array(
    'Ppbuat Janji Poli Ts' => array('index'),
    $model->buatjanjipoli_id,
);
?>
<legend class="rim2">Lihat PPBuatJanjiPoliT</legend>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
    <div class="col-sm-6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'buatjanjipoli_id',
                'pegawai_id',
                'ruangan_id',
                'pasien_id',
                'tglbuatjanji',
                'harijadwal',
                'tgljadwal',
                //'byphone',
                //'keteranganbuatjanji',
                //'create_time',
                //'update_time',
                //'create_loginpemakai_id',
                //'update_loginpemakai_id',
                //'create_ruangan',
            ),
        )); ?>
    </div>
    <div class="col-sm-6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                //'buatjanjipoli_id',
                //'pegawai_id',
                //'ruangan_id',
                //'pasien_id',
                //'tglbuatjanji',
                //'harijadwal',
                //'tgljadwal',
                'byphone',
                'keteranganbuatjanji',
                'create_time',
                'update_time',
                'create_loginpemakai_id',
                'update_loginpemakai_id',
                'create_ruangan',
            ),
        )); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
        $this->createUrl($this->id . '/update&id=' . $model->buatjanjipoli_id, array('modul_id' => Yii::app()->session['modul_id'])),
        array('title' => 'Ubah', 'class' => 'btn btn-danger')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan PPBuatJanjiPoliT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success')
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'view')); ?>
</div>