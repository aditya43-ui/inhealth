<?php
$this->breadcrumbs = array(
    'Jenispengadaan Ms' => array('index'),
    $model->jenispengadaan_id,
);
?>
<div class="white-container">
    <div class="panel panel-gradient">
        <div class="panel panel-heading">
            <div class="panel-title"> Lihat <b> Jenis Pengadaan </b></div>
        </div>
        <div class="panel-body"> 
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            <div class="row-fluid">
                <div class="span6">
                    <?php
                    $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                        'data' => $model,
                        'attributes' => array(
                            'jenispengadaan_nama',
                            'jenispengadaan_namalain',
                            'jenispengadaan_ket',
                            'jenispengadaan_urutan',
                            array(
                                'label' => 'Status',
                                'type' => 'raw',
                                'value' => ($model->jenispengadaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                            ),
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="form-actions">
                    <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->jenispengadaan_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Pengadaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                    <?php $this->widget('UserTips', array('content' => '')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
