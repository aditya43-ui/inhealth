<?php
$this->breadcrumbs = array(
    'Indikatoroppekeperawatan Ms' => array('index'),
    $model->indikatoroppekeperawatan_id,
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Lihat <b>Indikator OPPE Keperawatan</b>
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
                            'indikatoroppekeperawatan_id',
                            'kode_indikator',
                            'nama_indikator',
                            'golongan_indikator',
                            'rekomendasi',
                            'standar_nilai',
                            array(
                                'name' => 'is_aktif',
                                'type' => 'raw',
                                'value' => (($model->is_aktif == 1) ? Yii::t('mds', 'Ya') : Yii::t('mds', 'Tidak')),
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
                $this->createUrl('update', array('id' => $model->indikatoroppekeperawatan_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-danger')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Indikator OPPE Keperawatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success')
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>