<?php if (!$this->isFrame) : ?>
    <legend class="rim2">Lihat Kondisi Keluar</legend>
<?php else : ?>
    <legend class="rim">Lihat Kondisi Keluar</legend>
<?php endif; ?>
<?php
$this->breadcrumbs = array(
    'Kondisi Keluar Ms' => array('index'),
    $model->kondisikeluar_id,
);
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
    <div class="col-sm-6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'kondisikeluar_id',
                'carakeluar_id',
                'kondisikeluar_nama',
                //'kondisikeluar_namalain',
                //'kondisikeluar_aktif',
            ),
        )); ?>
    </div>
    <div class="col-sm-6">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                //'kondisikeluar_id',
                //'carakeluar_id',
                //'kondisikeluar_nama',
                'kondisikeluar_namalain',
                'kondisikeluar_aktif',
            ),
        )); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
        $this->createUrl($this->id . '/update&id=' . $model->kondisikeluar_id, array('modul_id' => Yii::app()->session['modul_id'])),
        array('title' => 'Ubah', 'class' => 'btn btn-danger',)
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kondisi Keluar', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'view')); ?>
</div>