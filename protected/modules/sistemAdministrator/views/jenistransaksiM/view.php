<?php
$this->breadcrumbs = array(
    'Jenistransaksi Ms' => array('index'),
    $model->jenistransaksi_id,
);
?>
<div class="white-container">
    <legend class="rim2">Lihat <b>JenistransaksiM</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'jenistransaksi_id',
                    'namatransaksi',
                    'namatransaksilainnnya',
                    //'akundebit',
                    //'akunkredit',
                    //'jenistransaksi_aktif',
                ),
            )); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    //'jenistransaksi_id',
                    //'namatransaksi',
                    //'namatransaksilainnnya',
                    'akundebit',
                    'akunkredit',
                    'jenistransaksi_aktif',
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl('update', array('id' => $model->jenistransaksi_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan JenistransaksiM', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>