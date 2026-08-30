<?php
$this->breadcrumbs = array(
    'Saerekeningcolumn Ms' => array('index'),
    $model->tujuan_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Ekspektasi</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <?php
            $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'tujuan_id',
                    array(
                        'label' => 'Luaran Keperawatan',
                        'type' => 'raw',
                        'value' => isset($model->luarankeperawatan->luarankeperawatan_nama) ? $model->luarankeperawatan->luarankeperawatan_nama : "Tidak diset",
                    ),
                    array(
                        'label' => 'Ekspektasi',
                        'type' => 'raw',
                        'value' => isset($model->tujuan_nama) ? $model->tujuan_nama : "Tidak diset",
                    ),
                    array(
                        'label' => 'Status',
                        'type' => 'raw',
                        'value' => ($model->tujuan_aktif == 1) ? "Aktif" : "Tidak Aktif",
                    ),
                ),
            ));
            ?>

        </div>
        <div class="row">
            <div class="form-actions">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->tujuan_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Ekspektasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            </div>
        </div>
    </div>
</div>