<div class="white-container">
    <legend class="rim2">Lihat <b>Pabrik</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Gfpabrik Ms' => array('index'),
        $model->pabrik_id,
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'pabrik_id',
                    'pabrik_kode',
                    'pabrik_nama',
                    'pabrik_namalain',
                    //'pabrik_alamat',
                    //'pabrik_propinsi',
                    //'pabrik_kabupaten',
                    //'pabrik_aktif',
                ),
            )); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    //'pabrik_id',
                    //'pabrik_kode',
                    //'pabrik_nama',
                    //'pabrik_namalain',
                    'pabrik_alamat',
                    'pabrik_propinsi',
                    'pabrik_kabupaten',
                    array(
                        'name' => 'pabrik_aktif',
                        'type' => 'raw',
                        'value' => (($model->pabrik_aktif) ? "Aktif" : "Tidak Aktif"),
                    ),
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl('update', array('id' => $model->pabrik_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Ubah', 'class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Pabrik', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>