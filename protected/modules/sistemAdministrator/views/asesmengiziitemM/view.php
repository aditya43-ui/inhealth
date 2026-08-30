<?php
$this->breadcrumbs = array(
    'Asesmengiziitem Ms' => array('index'),
    $model->asesmengiziitem_id,
);
?>
<div class="white-container">
    <legend class="rim2">Lihat <b>AsesmengiziitemM</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'asesmengiziitem_id',
                    'asesmengiziitem_nama',
                    'asesmengiziitem_aktif',
                    'create_time',
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
                    //'asesmengiziitem_id',
                    //'asesmengiziitem_nama',
                    //'asesmengiziitem_aktif',
                    //'create_time',
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
            $this->createUrl('update', array('id' => $model->asesmengiziitem_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Ubah', 'class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan AsesmengiziitemM', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>