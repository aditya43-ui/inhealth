<?php
$this->breadcrumbs = array(
    'Jenissimpanan Ms' => array('index'),
    $model->jenissimpanan_id,
);
?>
<div class="white-container">
    <legend class="rim2">Lihat <b>JenissimpananM</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'jenissimpanan_id',
                    'kodesimpanan',
                    'jenissimpanan',
                    'jenissimpanan_namalain',
                    'jangkapenarikanbln',
                    'persenjasathn',
                    'persenpajakthn',
                    //'jns_create_time',
                    //'jns_update_time',
                    //'jns_create_login',
                    //'jns_update_login',
                    //'jenissimpanan_aktif',
                    //'jenissimpanan_singkatan',
                ),
            )); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    //'jenissimpanan_id',
                    //'kodesimpanan',
                    //'jenissimpanan',
                    //'jenissimpanan_namalain',
                    //'jangkapenarikanbln',
                    //'persenjasathn',
                    //'persenpajakthn',
                    'jns_create_time',
                    'jns_update_time',
                    'jns_create_login',
                    'jns_update_login',
                    'jenissimpanan_aktif',
                    'jenissimpanan_singkatan',
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl('update', array('id' => $model->jenissimpanan_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan JenissimpananM', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>