<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jenis Sertifikasi Karyawan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Jenis Sertifikasi Karyawan' => array('admin'),
            $model->sertifikasipegawai_id,
        );

        $arrMenu = array();
        $this->menu = $arrMenu;
        ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'sertifikasipegawai_nama',
                'sertifikasipegawai_namalainnya',
                array(               // related city displayed as a link
                    'name' => 'Status',
                    'type' => 'raw',
                    'value' => (($model->sertifikasipegawai_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jenis Sertifikasi Karyawan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('SertifikasipegawaiM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>