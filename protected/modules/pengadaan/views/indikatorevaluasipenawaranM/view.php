<?php
$this->breadcrumbs = array(
    'Indikatorevaluasipenawaran Ms' => array('index'),
    $model->indikatorevaluasipenawaran_id,
);
?>
<div class="white-container">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> Lihat <b> Indikator Evaluasi Penawaran </b> </div>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                                'label' => 'Jenis Pengadaan',
                                'type' => 'raw',
                                'value' => $model->jenispengadaan->jenispengadaan_nama,
                                'htmlOptions' => array('style' => 'text-align:center;'),
                            ),
                        'evaluasipenawaran_jenis',
                        'evaluasipenawaran_nama',
                        'urutan',
                        array(
                            'label' => 'Aktif',
                            'value'=>($model->indikatorevaluasipenawaran_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->indikatorevaluasipenawaran_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Indikator Evaluasi Penawaran', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>
