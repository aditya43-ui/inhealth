<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kabupaten</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Ppkabupaten Ms' => array('index'),
            $model->kabupaten_id,
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'kabupaten_id',
                'propinsi.propinsi_nama',
                'kabupaten_nama',
                'kabupaten_namalainnya',
                'longitude',
                'latitude',
                //'kabupaten_aktif',
                array(
                    'name' => 'kabupaten_aktif',
                    'type' => 'raw',
                    'value' => (($model->kabupaten_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                )
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl($this->id . '/update&id=' . $model->kabupaten_id, array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Kabupaten', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success')
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>