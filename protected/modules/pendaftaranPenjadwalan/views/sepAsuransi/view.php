<?php
$this->breadcrumbs = array(
    'Assep Ts' => array('index'),
    $model->sep_id,
);
?>
<div class="white-container">
    <legend class="rim2">Lihat Surat Eligibilitas Peserta <b>(SEP)</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class="span6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'sep_id',
                    'tglsep',
                    'nosep',
                    'nokartuasuransi',
                    'tglrujukan',
                    'norujukan',
                    'ppkrujukan',
                    'ppkpelayanan',
                    'jnspelayanan',
                    'catatansep',
                    //'diagnosaawal',
                    //'politujuan',
                    //'klsrawat',
                    //'tglpulang',
                    //'create_time',
                    //'update_time',
                    //'create_loginpemakai_id',
                    //'upate_loginpemakai_id',
                    //'create_ruangan',
                ),
            )); ?>
        </div>
        <div class="span6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    //'sep_id',
                    //'tglsep',
                    //'nosep',
                    //'nokartuasuransi',
                    //'tglrujukan',
                    //'norujukan',
                    //'ppkrujukan',
                    //'ppkpelayanan',
                    //'jnspelayanan',
                    //'catatansep',
                    'diagnosaawal',
                    'politujuan',
                    'klsrawat',
                    'tglpulang',
                    'create_time',
                    'update_time',
                    'create_loginpemakai_id',
                    'upate_loginpemakai_id',
                    'create_ruangan',
                ),
            )); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->sep_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan SEP', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>