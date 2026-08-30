<?php
$this->breadcrumbs = array(
    'Sapemeriksaanalatrad Ms' => array('index'),
    $model->pemeriksaanalatrad_id,
);
?>
<div class="white-container">
    <legend class="rim2">Lihat <b>Alat Radiologi</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'pemeriksaanalatrad_id',
                    'alatmedis.alatmedis_id',
                    'pemeriksaanalatrad_kode',
                    'pemeriksaanalatrad_nama',
                    //'pemeriksaanalatrad_namalain',
                    //'pemeriksaanalatrad_aetitle',
                    //'pemeriksaanalatrad_aktif',
                ),
            )); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    //'pemeriksaanalatrad_id',
                    //'alatmedis_id',
                    //'pemeriksaanalatrad_kode',
                    //'pemeriksaanalatrad_nama',
                    'pemeriksaanalatrad_namalain',
                    'pemeriksaanalatrad_aetitle',
                    'pemeriksaanalatrad_aktif',
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl('update', array('id' => $model->pemeriksaanalatrad_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Alat Radiologi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>