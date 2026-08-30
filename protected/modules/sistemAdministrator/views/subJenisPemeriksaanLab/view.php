<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jenis Pemeriksaan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sajenispemeriksaanlab Ms' => array('index'),
            $model->subjenis_pemeriksaanlab_id,
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'subjenis_pemeriksaanlab_id',
                        'subjenis_pl_nama',
                        'subjenis_pl_namalainnya',
                        'subjenis_aktif',
                        //'jenispemeriksaanlab_namalainnya',
                        //'jenispemeriksaanlab_kelompok',
                        //'jenispemeriksaanlab_aktif',
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update&id=' . $model->subjenis_pemeriksaanlab_id, array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jenis Pemeriksaan Lab', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php
            //$content = $this->renderPartial($this->path_view.'tips/tipsView',array(),true);
            $this->widget('UserTips', array('type' => 'view'));
            ?>
        </div>
    </div>
</div>