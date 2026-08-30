<?php
$this->breadcrumbs = array(
    'Komponendarah Ms' => array('index'),
    $model->komponendarah_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Komponen Darah</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'komponendarah_id',
                'namakomponendrh',
                'singkatan_komp',
                'jeniskantongdarah_id',
                array(
                    'name' => 'komponendarah_aktif',
                    'value' => ($model->komponendarah_aktif == 1) ? "Aktif" : "Tidak Aktif",
                    'filter' => array(1 => 'Aktif', 0 => 'Tidak Aktif'),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Komponen Darah', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>