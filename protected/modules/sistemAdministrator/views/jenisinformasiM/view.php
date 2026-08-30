<?php
$this->breadcrumbs = array(
    'Jenis Informasi' => array('admin'),
    $model->jenisinformasi_id,
);

$model->jenisinformasi_aktif = $model->jenisinformasi_aktif ? "Aktif" : "Tidak Aktif";
$model->jenissurat_id = empty($model->jenissurat) ? "-" : $model->jenissurat->jenissurat_nama;
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jenis Informasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="span6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'jenisinformasi_id',
                        'jenissurat_id',
                        'jenisinformasi_nama',
                        'jenisinformasi_namalain',
                        'jenisinformasi_urutan',
                        'tipeinput_isiinformasi',
                        'jenisinformasi_aktif',
                        //'jenisinformasi_aktif',
                        //'create_time',
                        //'update_time',
                        //'create_loginpemakai_id',
                        //'update_loginpemakai_id',
                        //'create_ruangan',
                    ),
                )); ?>
            </div>
        </div>
        <div class="row">
            <div class="form-actions">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->jenisinformasi_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Informasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                <?php $this->widget('UserTips', array('content' => '')); ?>
            </div>
        </div>

    </div>
</div>