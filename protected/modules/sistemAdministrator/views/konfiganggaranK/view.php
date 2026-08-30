<div class="white-container">
    <legend class="rim2">Lihat <b>Konfigurasi Anggaran</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Agkonfiganggaran Ks' => array('index'),
        $model->konfiganggaran_id,
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    array(
                        'name' => 'tglanggaran',
                        'type' => 'raw',
                        'value' => MyFormatter::formatDateTimeForUser($model->tglanggaran),
                    ),
                    array(
                        'name' => 'sd_tglanggaran',
                        'type' => 'raw',
                        'value' => MyFormatter::formatDateTimeForUser($model->sd_tglanggaran),
                    ),
                    array(
                        'name' => 'deskripsiperiode',
                        'type' => 'raw',
                        'value' => $model->deskripsiperiode,
                    ),
                ),
            )); ?>
        </div>
        <div class="col-sm-6">
            <div class="block-tabel">
                <h6>Setting <b>Umum</b></h6>
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'name' => 'tglrencanaanggaran',
                            'type' => 'raw',
                            'value' => MyFormatter::formatDateTimeForUser($model->tglrencanaanggaran),
                        ),
                        array(
                            'name' => 'sd_tglrencanaanggaran',
                            'type' => 'raw',
                            'value' => MyFormatter::formatDateTimeForUser($model->sd_tglrencanaanggaran),
                        ),
                        array(
                            'name' => 'tglrevisianggaran',
                            'type' => 'raw',
                            'value' => MyFormatter::formatDateTimeForUser($model->tglrevisianggaran),
                        ),
                        array(
                            'name' => 'sd_tglrevisianggaran',
                            'type' => 'raw',
                            'value' => MyFormatter::formatDateTimeForUser($model->sd_tglrevisianggaran),
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl('update', array('id' => $model->konfiganggaran_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Ubah', 'class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Konfigurasi Anggaran', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php
        // $content = $this->renderPartial($this->path_view.'tips/view',array(),true);
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>