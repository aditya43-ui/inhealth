<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Materi Orientasi</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Materi Orientasi' => array('admin'),
            $model->materiorientasi_id,
        );

        $arrMenu = array();
        $this->menu = $arrMenu;
        ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'materiorientasi_id',
                'materiorientasi_nama',
                'materiorientasi_namalainnya',
                'jenisorientasi',
                array(               // related city displayed as a link
                    'name' => 'Status',
                    'type' => 'raw',
                    'value' => (($model->materiorientasi_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Materi Orientasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('MateriorientasiM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>