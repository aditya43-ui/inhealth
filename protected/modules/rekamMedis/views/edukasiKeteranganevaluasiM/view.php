<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Lihat Keterangan dan Evaluasi Edukasi</div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php
                $model->is_aktif = $model->is_aktif ? "Aktif" : "Tidak Aktif";
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'kodeedukator',
                        'keterangan_evaluasi',
                        'urutan',
                        array(
                            'name' => 'is_aktif',
                            'label' => 'Status',
                        ),
                    //'create_time',
                    //'update_time',
                    //'create_loginpemakai_id',
                    //'update_loginpemakai_id',
                    //'create_ruangan',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->edukasi_keteranganevaluasi_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Keterangan dan Evaluasi Edukasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                <?php $this->widget('UserTips', array('content' => '')); ?>
            </div>
        </div>

    </div>
</div>

