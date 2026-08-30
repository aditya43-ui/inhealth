<?php
$this->breadcrumbs = array(
    'Periode Posting' => array('admin'),
    $model->periodeposting_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Periode Posting</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'periodeposting_id',
                        //array(            
                        //	'label'=>'Konfig. Anggaran',
                        //	'type'=>'raw',
                        //	'value'=>isset($model->konfiganggaran_id) ? $model->konfiganggaran->deskripsiperiode : "Tidak diset",
                        //),
                        //				'konfiganggaran_id',
                        'periodeposting_nama',
                        array(
                            'label' => 'Tgl. Awal Periode Posting',
                            'type' => 'raw',
                            'value' => isset($model->tglperiodeposting_awal) ? MyFormatter::formatDateTimeForUser($model->tglperiodeposting_awal) : "Tidak diset",
                        ),
                        array(
                            'label' => 'Tgl. Akhir Periode Posting',
                            'type' => 'raw',
                            'value' => isset($model->tglperiodeposting_akhir) ? MyFormatter::formatDateTimeForUser($model->tglperiodeposting_akhir) : "Tidak diset",
                        ),
                        'deskripsiperiodeposting',
                        array(
                            'label' => 'Create Time',
                            'type' => 'raw',
                            'value' => isset($model->create_time) ? MyFormatter::formatDateTimeForUser($model->create_time) : "Tidak diset",
                        ),
                        //'update_time',
                        //'create_loginpemakai_id',
                        //'update_loginpemakai_id',
                        //'create_ruangan',
                        //'periodeposting_aktif',
                        //'rekperiode_id',
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        //'periodeposting_id',
                        //'konfiganggaran_id',
                        //'periodeposting_nama',
                        //'tglperiodeposting_awal',
                        //'tglperiodeposting_akhir',
                        //'deskripsiperiodeposting',
                        //'create_time',
                        array(
                            'label' => 'Update Time',
                            'type' => 'raw',
                            'value' => isset($model->update_time) ? MyFormatter::formatDateTimeForUser($model->update_time) : "Tidak diset",
                        ),
                        'create_loginpemakai_id',
                        'update_loginpemakai_id',
                        'create_ruangan',
                        array(
                            'label' => 'Aktif',
                            'type' => 'raw',
                            'value' => (($model->periodeposting_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                        ),
                        array(
                            'label' => 'Rekening Periode',
                            'type' => 'raw',
                            'value' => isset($model->rekperiode_id) ? $model->rekperiode->deskripsi : "Tidak diset",
                        ),
                        //				'rekperiode_id',
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->periodeposting_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Periode Posting', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php
            $this->widget('UserTips', array('type' => 'view'));
            ?>
        </div>
    </div>
</div>