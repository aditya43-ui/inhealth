<?php
$this->breadcrumbs = array(
    'Bedahanastesilokal Intraop Ts' => array('index'),
    $model->bedahanastesilokal_intraop_id,
);
?>
<div class="white-container">
    <legend class="rim2">Lihat <b>BedahanastesilokalIntraopT</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'bedahanastesilokal_intraop_id',
                    'pasien_id',
                    'pendaftaran_id',
                    'pasienadmisi_id',
                    'pasienmasukpenunjang_id',
                    'rencanaoperasi_id',
                    'pemeriksaanke',
                    'observasi_jam',
                    'respirasi_nilai',
                    'td_systolic',
                    //'td_dyastolic',
                    //'detaknadi',
                    //'suhubadan',
                    //'status_anestesi',
                    //'status_tindakanbedah',
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
                    //'bedahanastesilokal_intraop_id',
                    //'pasien_id',
                    //'pendaftaran_id',
                    //'pasienadmisi_id',
                    //'pasienmasukpenunjang_id',
                    //'rencanaoperasi_id',
                    //'pemeriksaanke',
                    //'observasi_jam',
                    //'respirasi_nilai',
                    //'td_systolic',
                    'td_dyastolic',
                    'detaknadi',
                    'suhubadan',
                    'status_anestesi',
                    'status_tindakanbedah',
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
            $this->createUrl('update', array('id' => $model->bedahanastesilokal_intraop_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan BedahanastesilokalIntraopT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>