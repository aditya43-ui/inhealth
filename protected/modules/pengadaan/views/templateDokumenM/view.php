<?php
$this->breadcrumbs = array(
    '' => array('index'),
    $model->konfigtemplatesurat_id,
);
?>
<div class="white-container">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> Lihat <b> Template Dokumen</b></div>
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
                                'label' => 'Jenis Dokumen',
                                'name' => 'jenissurat_id',
                                'type' => 'raw',
                                'value' => $model->jenissurat->jenissurat_nama,
                            ),
                            'konfigtemplatesurat_nama',
                            'nama_lain',
                            
                            array(
                                'label' => 'Isi',
                                'name' => 'konfigtemplatesurat_isi',
                                'type' => 'raw',
                                'value' => $model->konfigtemplatesurat_isi,
                            ),
                            'keterangan',
                            'urutan',
                            array(
                                'label' => 'Status',
                                'name' => 'konfigtemplatesurat_aktif',
                                'type' => 'raw',
                                'value' => (($model->konfigtemplatesurat_aktif == 1) ? Yii::t('mds', 'Aktif') : Yii::t('mds', 'Tidak Aktif')),
                            ),
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="form-actions">
                    <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->konfigtemplatesurat_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Template Dokumen', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                    <?php $this->widget('UserTips', array('content' => '')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
