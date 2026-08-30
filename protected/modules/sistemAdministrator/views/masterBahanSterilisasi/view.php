<?php
$this->breadcrumbs = array(
    'Bahan Sterilisasi' => array('admin'),
    $model->bahansterilisasi_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Master Bahan Sterilisasi</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'bahansterilisasi_id',
                    'bahansterilisasi_nama',
                    'bahansterilisasi_namalain',
                    'bahansterilisasi_jumlah',
                    //'bahansterilisasi_satuan',
                    //'bahansterilisasi_warna',
                    //'bahansterilisasi_maksuhu',
                    //'bahansterilisasi_aktif',
                ),
            )); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    //'bahansterilisasi_id',
                    //'bahansterilisasi_nama',
                    //'bahansterilisasi_namalain',
                    //'bahansterilisasi_jumlah',
                    'bahansterilisasi_satuan',
                    'bahansterilisasi_warna',
                    'bahansterilisasi_maksuhu',
                    'bahansterilisasi_aktif',
                ),
            )); ?>
        </div>
        <div class="clear"></div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->bahansterilisasi_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Master Bahan Sterilisasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>