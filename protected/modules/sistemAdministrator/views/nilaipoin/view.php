<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Nilai Poin</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Nilai Poin' => array('admin'),
            'Lihat',
        );

        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'nilaipoin_nama',
                'nilaipoin_namalain',
                'nilaipoin_jumlah',
                array(
                    'name' => 'nilaipoin_aktif',
                    'type' => 'raw',
                    'value' => (($model->nilaipoin_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
                array(
                    'label' => 'Tanggal',
                    'type' => 'raw',
                    'value' => MyFormatter::formatDateTimeForUser($model->nilaipoin_tgl) . ' s/d ' . MyFormatter::formatDateTimeForUser($model->nilaipoin_tgl_sd),
                ),

            ),
        )); ?>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Nilai Point', array('{icon}' => '<i class="icon-file icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            );
            ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>