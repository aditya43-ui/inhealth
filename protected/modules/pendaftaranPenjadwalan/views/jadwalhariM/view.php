<?php
$this->breadcrumbs = array(
    'Pengaturan Jadwal Hari Hemodialisa' => array('admin'),
    $model->jadwalhari_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jadwal Hari Hemodialisa</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'jadwalhari_id',
                        'jadwalhari_nama',
                        array(
                            'label' => 'Senin',
                            'type' => 'raw',
                            'value' => (($model->jadwalhari_hari_senin == TRUE) ? "Ya" : "-"),
                        ),
                        array(
                            'label' => 'Selasa',
                            'type' => 'raw',
                            'value' => (($model->jadwalhari_hari_selasa == TRUE) ? "Ya" : "-"),
                        ),
                        array(
                            'label' => 'Rabu',
                            'type' => 'raw',
                            'value' => (($model->jadwalhari_hari_rabu == TRUE) ? "Ya" : "-"),
                        ),
                        array(
                            'label' => 'Kamis',
                            'type' => 'raw',
                            'value' => (($model->jadwalhari_hari_kamis == TRUE) ? "Ya" : "-"),
                        ),
                        array(
                            'label' => 'Jumat',
                            'type' => 'raw',
                            'value' => (($model->jadwalhari_hari_jumat == TRUE) ? "Ya" : "-"),
                        ),
                        array(
                            'label' => 'Sabtu',
                            'type' => 'raw',
                            'value' => (($model->jadwalhari_hari_sabtu == TRUE) ? "Ya" : "-"),
                        ),
                        array(
                            'label' => 'Minggu',
                            'type' => 'raw',
                            'value' => (($model->jadwalhari_hari_minggu == TRUE) ? "Ya" : "-"),
                        ),
                        array(
                            'label' => 'Status',
                            'type' => 'raw',
                            'value' => (($model->jadwalhari_aktif == TRUE) ? "Aktif" : "Tidak Aktif"),
                        ),
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">

            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->jadwalhari_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jadwal Hari', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success')
            ); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>