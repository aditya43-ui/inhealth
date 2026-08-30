<div class="white-container">
    <?php
    $this->breadcrumbs = array(
        'Pcobatalkesdetail Ms' => array('index'),
        $model->obatalkesdetail_id,
    );
    ?>
    <legend class="rim2">Lihat <b>Obat</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-4">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    array(
                        'name' => 'Kode Obat',
                        'value' => $model->obatalkes->obatalkes_kode,
                    ),
                    array(
                        'name' => 'Nama Obat',
                        'value' => $model->obatalkes->obatalkes_nama,
                    ),
                    array(
                        'name' => 'komposisi',
                        'type' => 'raw',
                        'value' => $model->komposisi,
                    ),
                    array(
                        'name' => 'efeksamping',
                        'type' => 'raw',
                        'value' => $model->efeksamping,
                    ),
                ),
            )); ?>
        </div>
        <div class="col-sm-4">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'obatalkesdetail_id',
                    'obatalkes_id',
                    array(
                        'name' => 'indikasi',
                        'type' => 'raw',
                        'value' => $model->indikasi,
                    ),
                    array(
                        'name' => 'kontraindikasi',
                        'type' => 'raw',
                        'value' => $model->kontraindikasi,
                    ),
                ),
            )); ?>
        </div>
        <div class="col-sm-4">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    array(
                        'name' => 'interaksiobat',
                        'type' => 'raw',
                        'value' => $model->interaksiobat,
                    ),
                    array(
                        'name' => 'carapenyimpanan',
                        'type' => 'raw',
                        'value' => $model->carapenyimpanan,
                    ),
                    array(
                        'name' => 'peringatan',
                        'type' => 'raw',
                        'value' => $model->peringatan,
                    ),
                    array(
                        'name' => 'Status',
                        'type' => 'raw',
                        'value' => isset($model->obatalkes->obatalkes_aktif) ? "Aktif" : "Tidak Aktif",
                    ),
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl($this->id . '/update&id=' . $model->obatalkesdetail_id, array('modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Ubah', 'class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Obat Alkes', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>