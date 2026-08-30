<?php
$this->breadcrumbs = array(
    'Agsumberanggaran Ms' => array('index'),
    $model->sumberanggaran_id,
);
?>
<div class="white-container">
    <legend class="rim2">Lihat <b>Sumber Anggaran</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'sumberanggaran_id',
                    'kodesumberanggaran',
                    'sumberanggarannama',
                    //'sumberanggarannamalain',
                    //'sumberanggaran_aktif',
                ),
            )); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    //'sumberanggaran_id',
                    //'kodesumberanggaran',
                    //'sumberanggarannama',
                    'sumberanggarannamalain',
                    'sumberanggaran_aktif',
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl('update', array('id' => $model->sumberanggaran_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Ubah', 'class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Sumber Anggaran', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>