<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Klasifikasi Diagnosa</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Saklasifikasidiagnosa Ms' => array('index'),
            $model->klasifikasidiagnosa_id,
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'klasifikasidiagnosa_id',
                        'klasifikasidiagnosa_kode',
                        'klasifikasidiagnosa_nama',
                        //'klasifikasidiagnosa_namalain',
                        //'klasifikasidiagnosa_aktif',
                        //'klasifikasidiagnosa_desc',
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        //'klasifikasidiagnosa_id',
                        //'klasifikasidiagnosa_kode',
                        //'klasifikasidiagnosa_nama',
                        'klasifikasidiagnosa_namalain',
                        'klasifikasidiagnosa_aktif',
                        'klasifikasidiagnosa_desc',
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->klasifikasidiagnosa_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Klasifikasi Diagnosa', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>