<?php
$this->breadcrumbs = array(
    'Tunjangan' => Yii::app()->request->getUrlReferrer(),
    $model->tunjangan_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Tunjangan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        /* array(
                                    'name'=>'pangkat_id',
                                    'type'=>'raw',
                                    'value'=>($model->pangkat_id)?$model->pangkat->pangkat_nama:'-'
                            ),*/
                        array(
                            'name' => 'jabatan_id',
                            'type' => 'raw',
                            'value' => ($model->jabatan_id) ? $model->jabatan->jabatan_nama : '-'
                        ),
                        array(
                            'name' => 'komponengaji_id',
                            'type' => 'raw',
                            'value' => ($model->komponengaji_id) ? $model->komponengaji->komponengaji_nama : '-'
                        ),
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'header' => 'Nominal Tunjangan (Rp)',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'name' => 'nominaltunjangan',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'type' => 'raw',
                            'value' =>  number_format($model->nominaltunjangan, 0, '', '.'),
                        ),
                        array(
                            'name' => 'tunjangan_aktif',
                            'type' => 'raw',
                            'value' => (($model->tunjangan_aktif) ? "Aktif" : "Tidak Aktif"),
                        ),
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->tunjangan_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Tunjangan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>