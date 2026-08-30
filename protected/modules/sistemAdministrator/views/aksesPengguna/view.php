<?php
$this->breadcrumbs = array(
    'saaksespengguna Ks' => array('index'),
    $model->aksespengguna_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Akses Pemakai</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'loginpemakai.nama_pemakai',
                    'value' => $model->loginpemakai->nama_pemakai,
                ),
                array(
                    'name' => 'peranpengguna.peranpenggunanama',
                    'value' => $model->peranpengguna->peranpenggunanama,
                ),
                array(
                    'name' => 'modul.modul_nama',
                    //                        'value'=>$model->modul->modul_nama,
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl($this->id . '/update&id=' . $model->aksespengguna_id, array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Akses Pemakai', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>