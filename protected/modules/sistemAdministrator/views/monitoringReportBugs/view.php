<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Monitoring Error dan Bugs</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sareportbugs Rs' => array('index'),
            $model->reportbugs_id,
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'reportbugs_id',
                        'kodebugs',
                        'judul_bugs',
                        'link_bugs',
                        'type_bugs',
                        'file_bugs',
                        'line_bugs',
                        'pesan_bugs',
                        'prioritas_bugs',
                        'create_login_id',
                        //'create_pegawai_id',
                        //'create_instalasi_id',
                        //'create_ruangan_id',
                        //'create_modul_id',
                        //'create_datetime',
                        //'create_hostname_pc',
                        //'create_browser_pc',
                        //'isajax_bugs',
                        //'create_login_nama',
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        //'reportbugs_id',
                        //'kodebugs',
                        //'judul_bugs',
                        //'link_bugs',
                        //'type_bugs',
                        //'file_bugs',
                        //'line_bugs',
                        //'pesan_bugs',
                        //'prioritas_bugs',
                        //'create_login_id',
                        'create_pegawai_id',
                        'create_instalasi_id',
                        'create_ruangan_id',
                        'create_modul_id',
                        'create_datetime',
                        'create_hostname_pc',
                        'create_browser_pc',
                        array(
                            'name' => 'Bug Ajax',
                            'type' => 'raw',
                            'value' => ($model->isajax_bugs == True) ? "Ya" : "Tidak",
                        ),
                        'create_login_nama',
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl($this->id . '/update&id=' . $model->reportbugs_id, array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Monitoring Error dan Bugs', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php
            $content = $this->renderPartial('tips/view', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
    </div>
</div>