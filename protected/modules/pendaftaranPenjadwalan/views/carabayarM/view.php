<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jenis Penjamin</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Ppcarabayar Ms' => array('index'),
            $model->carabayar_id,
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'carabayar_id',
                'carabayar_nama',
                'carabayar_namalainnya',
                'metode_pembayaran',

                'carabayar_loket',
                'carabayar_singkatan',
                'carabayar_nourut',
                array(
                    'name' => 'carabayar_aktif',
                    'type' => 'raw',
                    'value' => (($model->carabayar_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl($this->id . '/update&id=' . $model->carabayar_id, array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jenis Penjamin', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success')
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>