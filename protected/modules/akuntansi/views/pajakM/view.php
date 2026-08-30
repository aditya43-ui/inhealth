<?php
$this->breadcrumbs = array(
    'Pajak' => array('index'),
    $model->pajak_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Master Pajak</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'Nama Pajak',
                    'type' => 'raw',
                    'value' => $model->pajak_nama,
                ),
                array(
                    'label' => 'Nama Lain Pajak',
                    'type' => 'raw',
                    'value' => $model->pajak_namalain,
                ),
                array(
                    'label' => 'Nama Rekening',
                    'type' => 'raw',
                    'value' => (isset($model->rekening5) ? $model->rekening5->kdrekening5 . " - " . $model->rekening5->nmrekening5 : ""),
                ),
                array(
                    'label' => 'Keterangan',
                    'type' => 'raw',
                    'value' => $model->keterangan,
                ),
                array(
                    'label' => 'Status',
                    'type' => 'raw',
                    'value' => ($model->pajak_aktif == true ? 'Aktif' : 'Tidak Aktif')
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->pajak_id, 'modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('title' => 'Ubah', 'class' => 'btn btn-danger')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Master Pajak', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('class' => 'btn btn-success')
            ); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>