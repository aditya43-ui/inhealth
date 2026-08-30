<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Suku</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Ppsuku Ms' => array('index'),
            $model->suku_id,
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'suku_id',
                'suku_nama',
                'suku_namalainnya',
                //'suku_aktif',
                array(
                    'name' => 'suku_aktif',
                    'type' => 'raw',
                    'value' => (($model->suku_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No'))
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl($this->id . '/update&id=' . $model->suku_id, array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Suku', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success')
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>