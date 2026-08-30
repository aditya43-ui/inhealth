<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Lokasi Penyimpanan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Rmlokasi Raks' => array('index'),
            $model->lokasirak_id,
        );

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'lokasirak_id',
                'lokasirak_nama',
                'lokasirak_namalainnya',
                array(
                    'label' => 'Aktif',
                    'value' => (($model->lokasirak_aktif == 1) ? "Ya" : "Tidak"),
                )
            ),
        ));
        ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Lokasi Penyimpanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            );
            ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>