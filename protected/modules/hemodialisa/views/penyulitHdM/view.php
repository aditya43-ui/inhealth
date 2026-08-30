<?php
$this->breadcrumbs = array(
    'Penyulit' => array('admin'),
    $model->penyulit_hd_id,
);

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Penyulit HD</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
            <?php
            $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'penyulit_hd_id',
                    'penyulit_hd_nama',
                    'penyulit_hd_namalainnya',
                ),
            ));
            ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->penyulit_hd_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Penyulit HD', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
            <?php echo CHtml::link('<i class="entypo-back" ></i> Kembali', '#', array('class' => 'btn btn-default', 'onclick' => 'window.location ="' . $this->createUrl("penyulitHdM/admin") . '";return false;', 'style' => 'color: white;'));
            ?>
        </div>
    </div>


