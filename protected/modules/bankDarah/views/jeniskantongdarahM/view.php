<?php
$this->breadcrumbs = array(
    'Kpindikatorpenilaianiku Ms' => array('index'),
    $model->jeniskantongdarah_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jenis Kantong Darah</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'jeniskantongdarah_id',
                'nama_jenis',
                'nama_jenis_sngkt',
                array(
                    'name' => 'jeniskantongdarah_aktif',
                    'value' => ($model->jeniskantongdarah_aktif == 1) ? "Aktif" : "Tidak Aktif",
                    'filter' => array(1 => 'Aktif', 0 => 'Tidak Aktif'),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jenis Kantong Darah', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>