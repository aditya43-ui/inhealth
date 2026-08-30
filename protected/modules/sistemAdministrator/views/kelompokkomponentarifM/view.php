<?php
$this->breadcrumbs = array(
    'Sakelompokkomponentarif Ms' => array('index'),
    $model->kelompokkomponentarif_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kelompok Komponen Tarif</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'label' => 'ID',
                            'name' => 'kelompokkomponentarif_id',
                        ),
                        'kelompokkomponentarif_nama',
                        //'kelompokkomponentarif_namalain',
                        //'kelompokkomponentarif_aktif',
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        //'kelompokkomponentarif_id',
                        //'kelompokkomponentarif_nama',
                        'kelompokkomponentarif_namalain',
                        array(
                            'label' => 'Aktif',
                            'value' => ($model->kelompokkomponentarif_aktif == 1) ? "Ya" : "Tidak",
                        ),
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->kelompokkomponentarif_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Kelompok Komponen Tarif', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>