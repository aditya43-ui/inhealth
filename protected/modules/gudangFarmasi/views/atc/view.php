<?php
$this->breadcrumbs = array(
    'Gfatc Ms' => array('index'),
    $model->atc_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>ATC</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'atc_id',
                        'atc_kode',
                        'atc_nama',
                        'atc_namalain',
                        'atc_singkatan',
                        //'atc_ddd',
                        //'atc_units',
                        //'atc_admr',
                        //'atc_note',
                        //'atc_aktif',
                    ),
                ));
                ?>
            </div>
            <div class="col-sm-6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        //'atc_id',
                        //'atc_kode',
                        //'atc_nama',
                        //'atc_namalain',
                        //'atc_singkatan',
                        'atc_ddd',
                        'atc_units',
                        'atc_admr',
                        'atc_note',
                        'atc_aktif',
                    ),
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->atc_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Atc', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>