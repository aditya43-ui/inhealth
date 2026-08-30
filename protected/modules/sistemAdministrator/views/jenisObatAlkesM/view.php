<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jenis Obat</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Gfjenis Obat Alkes Ms' => array('index'),
            $model->jenisobatalkes_id,
        );

        $arrMenu = array();

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'jenisobatalkes_id',
                'jenisobatalkes_nama',
                'jenisobatalkes_namalain',
                array(               // related city displayed as a link
                    'name' => 'jenisobatalkes_aktif',
                    'type' => 'raw',
                    'value' => (($model->jenisobatalkes_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jenis Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl(
                    Yii::app()->controller->id . '/admin',
                    array('modul_id' => Yii::app()->session['modul_id'])
                ),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>