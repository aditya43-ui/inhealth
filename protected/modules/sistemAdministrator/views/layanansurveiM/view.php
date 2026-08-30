<?php
$this->breadcrumbs = array(
    'Layanansurvei Ms' => array('index'),
    $model->layanansurvei_id,
);

$this->menu = array(
    array('label' => 'List LayanansurveiM', 'url' => array('index')),
    array('label' => 'Create LayanansurveiM', 'url' => array('create')),
    array('label' => 'Update LayanansurveiM', 'url' => array('update', 'id' => $model->layanansurvei_id)),
    array('label' => 'Delete LayanansurveiM', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->layanansurvei_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage LayanansurveiM', 'url' => array('admin')),
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Layanan Survei</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(

                array(
                    'label' => 'Nama Instalasi',
                    'type' => 'raw',
                    'value' => $this->renderPartial('_instalasi', array('layanansurvei_id' => $model->layanansurvei_id), true),
                ),

                array(
                    'label' => 'Nama Ruangan',
                    'type' => 'raw',
                    'value' => $this->renderPartial('_ruangan', array('layanansurvei_id' => $model->layanansurvei_id), true),
                ),
                'layanansurvei_nama',
                'layanansurvei_ask',
                'layanansurvei_desc',
                array(               // related city displayed as a link
                    'name' => 'layanansurvei_aktif',
                    'type' => 'raw',
                    'value' => (($model->layanansurvei_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Layanan Survei', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>