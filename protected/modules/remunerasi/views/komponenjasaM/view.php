<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Komponen Jasa</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Komponenjasa Ms' => array('index'),
            $model->komponenjasa_id,
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'View') . ' KomponenjasaM #' . $model->komponenjasa_id, 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' KomponenjasaM', 'icon' => 'list', 'url' => array('index')));
        (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' KomponenjasaM', 'icon' => 'file', 'url' => array('create'))) :  '';
        (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Update') . ' KomponenjasaM', 'icon' => 'pencil', 'url' => array('update', 'id' => $model->komponenjasa_id))) :  '';
        array_push($arrMenu, array('label' => Yii::t('mds', 'Delete') . ' KomponenjasaM', 'icon' => 'trash', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->komponenjasa_id), 'confirm' => Yii::t('mds', 'Are you sure you want to delete this item?'))));
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' KomponenjasaM', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'komponenjasa_id',
                array(
                    'label' => 'Komponen Tarif',
                    'value' => $model->komponentarif->komponentarif_nama,
                ),
                array(
                    'label' => 'Jenis Tarif',
                    'value' => $model->jenistarif->jenistarif_nama,
                ),
                array(
                    'label' => 'Jenis Penjamin',
                    'value' => $model->carabayar->carabayar_nama,
                ),
                array(
                    'label' => 'Kelompok Tindakan',
                    'value' => $model->kelompoktindakan->kelompoktindakan_nama,
                ),
                array(
                    'label' => 'Ruangan',
                    'value' => $model->ruangan->ruangan_nama,
                ),
                'komponenjasa_kode',
                'komponenjasa_nama',
                'komponenjasa_singkatan',
                'besaranjasa',
                'potongan',
                'jasadireksi',
                'kuebesar',
                'jasadokter',
                'jasaparamedis',
                'jasaunit',
                'jasabalanceins',
                'jasaemergency',
                'biayaumum',
                'komponenjasa_aktif',
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Komponen Jasa', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>