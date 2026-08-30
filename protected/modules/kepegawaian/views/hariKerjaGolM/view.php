<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Hari Kerja Pegawai</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Hari Kerja Pegawai' => array('admin'),
            'Lihat'
            //$model->harikerjagol_id,
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'View') . ' Hari Kerja Golongan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        (Yii::app()->user->checkAccess('Admin')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Hari Kerja Golongan', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'harikerjagol_id',
                'kelompokpegawai.kelompokpegawai_nama',
                array(
                    'name' => 'periodeharikerjaawl',
                    // 'value' => MyFormatter::formatDateTimeForUser($model->periodeharikerjaawl),
                ),
                //  array(
                //  'name' => 'periodehariakhir',
                //  'value' => MyFormatter::formatDateTimeForUser($model->periodehariakhir),
                // ),  
                array(
                    'name' => 'periodeharikerjaakhir',
                    //'value' => MyFormatter::formatDateTimeForUser($model->periodeharikerjaakhir),
                ),

                // 'jmlharibln',
                array(
                    'name' => 'harikerjagol_aktif',
                    'type' => 'raw',
                    'value' => ($model->harikerjagol_aktif == 1) ? "Aktif" : "Tidak Aktif",
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Hari Kerja Pegawai', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('hariKerjaGolM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>