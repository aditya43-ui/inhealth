<?php
$this->breadcrumbs = array(
    'Saloket Ms' => array('index'),
    $model->loket_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Loket</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'loket_id',
                        'loket_nama',
                        'loket_namalain',
                        'loket_fungsi',
                        'loket_singkatan',
                        'loket_nourut',
                        'loket_formatnomor',
                        //'loket_maksantrian',
                        //'loket_aktif',
                        //'carabayar_id',
                        //'filesuara',
                        //'ispendaftaran',
                        //'iskasir',
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        //'loket_id',
                        //'loket_nama',
                        //'loket_namalain',
                        //'loket_fungsi',
                        //'loket_singkatan',
                        //'loket_nourut',
                        //'loket_formatnomor',
                        'loket_maksantrian',
                        'loket_aktif',
                        'carabayar_id',
                        'filesuara',
                        'ispendaftaran',
                        'is_penunjang',
                        'iskasir',
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->loket_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Loket', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>