<?php
$this->breadcrumbs = array(
    'Laporanoperasipasien Ts' => array('index'),
    $model->laporanoperasipasien_id,
);
?>
<div class="white-container">
    <legend class="rim2">Lihat <b>Laporan Operasi Pasien</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'laporanoperasipasien_id',
                    'pasien_id',
                    'dokterbedahPengisilaporan.nama_pegawai',
                    'pendaftaran_id',
                    'pasienadmisi_id',
                    'pasienmasukpenunjang_id',
                    'rencanaoperasi_id',
                    'tanggal_operasi',
                    'jam_mulaioperasi',
                    'jam_selesaioperasi',
                    //'lamaoperasi',
                    //'laporanoperasi',
                    //'tanggalpengisian_laporanop',
                    //'dokterbedah_pengisilaporan_id',
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
                    //'laporanoperasipasien_id',
                    //'pasien_id',
                    //'pendaftaran_id',
                    //'pasienadmisi_id',
                    //'pasienmasukpenunjang_id',
                    //'rencanaoperasi_id',
                    //'tanggal_operasi',
                    //'jam_mulaioperasi',
                    //'jam_selesaioperasi',
                    'lamaoperasi',
                    'laporanoperasi',
                    'tanggalpengisian_laporanop',
                    'dokterbedah_pengisilaporan_id',
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
            $this->createUrl('update', array('id' => $model->laporanoperasipasien_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Laporano Operasi Pasien ', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>