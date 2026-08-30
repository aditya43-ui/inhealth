<?php
$this->breadcrumbs = array(
    'Pengaturan Submenu Jenis Linen' => array('admin'),
    $model->jenislinen_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Submenu Jenis Linen</b>
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
                        'jenislinen_id',
                        'jenislinen_no',
                        'jenislinen_nama',
                        'tgldiedarkan',
                        'ukuranitem',
                        //'beratitem',
                        //'qtyitem',
                        //'warnalinen',
                        //'isberwarna',
                    ),
                ));
                ?>
            </div>
            <div class="col-sm-6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        //'jenislinen_id',
                        //'jenislinen_no',
                        //'jenislinen_nama',
                        //'tgldiedarkan',
                        //'ukuranitem',
                        'beratitem',
                        'qtyitem',
                        'warnalinen',
                        'isberwarna',
                    ),
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->jenislinen_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Submenu Jenis Linen', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>