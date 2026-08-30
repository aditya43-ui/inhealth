<?php
$this->breadcrumbs = array(
    'Pengaturan Indikator Perilaku' => array('admin'),
    $model->indikatorperilaku_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Indikator Perilaku</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'indikatorperilaku_id',
                        array(
                            'header' => 'Jabatan',
                            'name' => 'jabatan_id',
                            'value' => (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : "-"),
                        ),
                        array(
                            'header' => 'Jenis Penilaian',
                            'name' => 'jenispenilaian_id',
                            'value' => (isset($model->jenispenilaian->jenispenilaian_nama) ? $model->jenispenilaian->jenispenilaian_nama : "-"),
                        ),
                        array(
                            'header' => 'Kompetensi',
                            'name' => 'kompetensi_id',
                            'value' => (isset($model->kompetensi->kompetensi_nama) ? $model->kompetensi->kompetensi_nama : "-"),
                        ),
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'indikatorperilaku_nama',
                        'indikatorperilaku_namalain',
                        array(
                            'name' => 'indikatorperilaku_aktif',
                            'value' => ($model->indikatorperilaku_aktif == 1) ? "Aktif" : "Tidak Aktif",
                            'filter' => array(1 => 'Aktif', 0 => 'Tidak Aktif'),
                        ),
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->indikatorperilaku_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Indikator Perilaku', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>