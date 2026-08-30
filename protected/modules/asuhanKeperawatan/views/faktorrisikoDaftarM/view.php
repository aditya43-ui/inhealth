<?php
$this->breadcrumbs = array(
    'Faktorrisikodaftar Ms' => array('index'),
    $model->faktorrisiko_daftar_id,
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Lihat <b>Daftar Faktor Risiko</b>
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
                            'faktorrisiko_daftar_id',
                            'faktorrisiko_daftar_nama',
                            'faktorrisiko_daftar_namalain',
                            array(
                                'name' => 'faktorrisiko_daftar_aktif',
                                'type' => 'raw',
                                'value' => (($model->faktorrisiko_daftar_aktif == 1) ? Yii::t('mds', 'Aktif') : Yii::t('mds', 'Tidak')),
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
                $this->createUrl('update', array('id' => $model->faktorrisiko_daftar_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-danger')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Daftar Faktor Risiko', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success')
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>