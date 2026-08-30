<?php
$this->breadcrumbs = array(
    'Saformasishift Ms' => array('index'),
    $model->formasishift_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Formasi Shift</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'formasishift_id',
                        'ruangan_id',
                        'shift_id',
                        'jmlformasi',
                        'create_time',
                        //'update_time',
                        //'create_loginpemakai_id',
                        //'update_loginpemakai_id',
                        //'create_ruangan',
                        //'formasishift_aktif',
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        //'formasishift_id',
                        //'ruangan_id',
                        //'shift_id',
                        //'jmlformasi',
                        //'create_time',
                        'update_time',
                        'create_loginpemakai_id',
                        'update_loginpemakai_id',
                        'create_ruangan',
                        'formasishift_aktif',
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->formasishift_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Formasi Shift', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>