<?php
$this->breadcrumbs = array(
    'Jenis Skrining Pasien' => array('admin'),
    'Lihat',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-eye"></i> Lihat <b>Jenis Srining Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row-fluid">
            <?php
            
            $model->isaktif = $model->isaktif ? "Aktif" : "Tidak Aktif";
            
            $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'jenisskriningpasien_id',
                    'jenisskriningpasien_nama',
                    'jenisskriningpasien_namalainnya',
                    'isaktif',
                ),
            ));
            ?>
        </div>
        <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')), $this->createUrl('update', array('id' => $model->jenisskriningpasien_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Skrining Pasien', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>


