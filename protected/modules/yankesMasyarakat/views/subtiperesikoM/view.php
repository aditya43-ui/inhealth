<?php
$this->breadcrumbs = array(
    'Subtiperesiko Ms' => array('index'),
    $model->subtiperesiko_id,
);
?>
<div class="white-container">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"> Lihat <b> Sub Tipe Risiko</b> </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            <div class="row-fluid">
                <div class="span6">
                    <?php
                    $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                        'data' => $model,
                        'attributes' => array(
                            array(
                                'label' => 'Nama Tipe Risiko',
                                'value' => $model->tiperesiko->tiperesiko_nama,
                            ),
                            'subtiperesiko_nama',
                            'subtiperesiko_keterangan',
                            'subtiperesiko_urutan',
                            array(
                                'label' => 'Status',
                                'value' => ($model->subtiperesiko_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                            ),
                        ),
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->subtiperesiko_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Sub Tipe Risiko', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success'))."&nbsp"; ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>
