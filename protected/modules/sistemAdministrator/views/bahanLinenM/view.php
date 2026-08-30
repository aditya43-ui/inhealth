<?php
$this->breadcrumbs = array(
    'Sabahanlinen Ms' => array('index'),
    $model->bahanlinen_id,
);
?>
<div class="white-container">
    <legend class="rim2">Lihat <b>Bahan Linen</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'bahanlinen_id',
                    'bahanlinen_nama',
                    'bahanlinen_namalain',
                    'suhurekomendasi',
                    array(
                        'label' => 'Aktif',
                        'value' => $model->bahanlinen_aktif ? 'Aktif' : 'Tidak Aktif',
                    ),
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl('update', array('id' => $model->bahanlinen_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Ubah', 'class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Bahan Linen', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>