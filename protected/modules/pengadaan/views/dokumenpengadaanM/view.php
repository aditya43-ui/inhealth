<?php
$this->breadcrumbs = array(
    'Dokumenpengadaan Ms' => array('index'),
    $model->dokumenpengadaan_id,
);
?>
<!--<div class="white-container">-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"> Lihat <b> Dokumen Pengadaan </b> </div>
    </div>
    <div class="panel-body">


        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row-fluid">
            <div class="span6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'jenispengadaan_id',
                        'dokumenpengadaan_nama',
                        'dokumenpengadaan_namalain',
                        'dokumenpengadaan_deskripsi',
                        'dokumenpengadaan_jenistransaksi',
                        'dokumenpengadaan_urutan',
                        array(
                            'label' => 'Aktif',
                            'type' => 'raw',
                            'value' => ($model->dokumenpengadaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'label' => 'Wajib',
                            'type' => 'raw',
                            'value' => ($model->dokumenpengadaan_wajib == 1 ) ? "Wajib" : "Tidak Wajib",
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'label' => 'PDF',
                            'type' => 'raw',
                            'value' => ($model->file_pdf == 1 ) ? "Ya" : "Tidak",
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'label' => 'Excel',
                            'type' => 'raw',
                            'value' => ($model->file_excel == 1 ) ? "Ya" : "Tidak",
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'label' => 'Gambar',
                            'type' => 'raw',
                            'value' => ($model->file_image == 1 ) ? "Ya" : "Tidak",
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'label' => 'Word',
                            'type' => 'raw',
                            'value' => ($model->file_word == 1 ) ? "Ya" : "Tidak",
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'label' => 'RAR',
                            'type' => 'raw',
                            'value' => ($model->file_rar == 1 ) ? "Ya" : "Tidak",
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'label' => 'ZIP',
                            'type' => 'raw',
                            'value' => ($model->file_zip == 1 ) ? "Ya" : "Tidak",
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->dokumenpengadaan_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Dokumen Pengadaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                <?php $this->widget('UserTips', array('type' => 'view')); ?>
            </div>
        </div>        
    </div>
</div>
<!--</div>-->