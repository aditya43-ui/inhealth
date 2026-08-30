<?php
$this->breadcrumbs = array(
    'Luluskomponendarah Ts' => array('index'),
    $model->luluskomponendarah_id,
);
?>
<div class="white-container">
    <legend class="rim2">Lihat <b>LuluskomponendarahT</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'luluskomponendarah_id',
                    'kantongdarah_id',
                    'tglpelulusan',
                    'statuspelulusan',
                    'koordinatormutu_id',
                    'kepalainstalasi_id',
                    //'keteranganpelulusan',
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
                    //'luluskomponendarah_id',
                    //'kantongdarah_id',
                    //'tglpelulusan',
                    //'statuspelulusan',
                    //'koordinatormutu_id',
                    //'kepalainstalasi_id',
                    'keteranganpelulusan',
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
            $this->createUrl('update', array('id' => $model->luluskomponendarah_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan LuluskomponendarahT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>