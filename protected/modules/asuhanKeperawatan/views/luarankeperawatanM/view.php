<?php
$this->breadcrumbs = array(
    'Luarankeperawatan Ms' => array('index'),
    $model->luarankeperawatan_id,
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Lihat <b>Luaran Keperawatan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                $this->widget(
                    'ext.bootstrap.widgets.BootDetailView',
                    array(
                        'data' => $model,
                        'attributes' => array(
                            'luarankeperawatan_kode',
                            'luarankeperawatan_nama',
                            'luarankeperawatan_deskripsi',
                            array(
                                'label' => 'Status',
                                'type' => 'raw',
                                'value' => ($model->luarankeperawatan_aktif == 1) ? "Aktif" : "Tidak Aktif",
                            ),
                        ),
                    )
                );
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')),
                $this->createUrl('update', array('id' => $model->luarankeperawatan_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-danger')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Luaran Keperawatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success')
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>