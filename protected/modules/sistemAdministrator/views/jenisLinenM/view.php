<?php
$this->breadcrumbs = array(
    'Sajenislinen Ms' => array('index'),
    $model->jenislinen_id,
);
?>
<div class="white-container">
    <legend class="rim2">Lihat <b>Jenis Linen</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'jenislinen_id',
                    'jenislinen_no',
                    'jenislinen_nama',
                    array(
                        'label' => 'Tanggal Diedarkan',
                        'value' => isset($model->tgldiedarkan) ? MyFormatter::formatDateTimeForUser($model->tgldiedarkan) : '',
                    ),
                    'ukuranitem',
                    'beratitem',
                    'qtyitem',
                    'warnalinen',
                    array(
                        'label' => 'Berwarna',
                        'value' => isset($model->isberwarna) ? 'Ya' : 'Tidak',
                    ),
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl('update', array('id' => $model->jenislinen_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Ubah', 'class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Jenis Linen', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>