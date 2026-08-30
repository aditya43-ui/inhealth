<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Status Hasil Periksa</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Pengaturan Status Hasil Periksa' => Yii::app()->request->getUrlReferrer(),
            $model->lookup_id,
        );
        $arrMenu = array();
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'lookup_id',
                'lookup_name',
                'lookup_urutan',
                'lookup_kode',
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->lookup_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Status Hasil Periksa', array('{icon}' => '<i class="icon-file icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            );
            $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>