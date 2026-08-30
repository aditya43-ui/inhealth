<div class="white-container">
    <legend class="rim2">Lihat <b>Kegiatan Operasi</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Bskegiatan Operasi Ms' => array('index'),
        $model->kegiatanoperasi_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kegiatan Operasi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kegiatan Operasi', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kegiatan Operasi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kegiatan Operasi', 'icon'=>'pencil','url'=>array('update','id'=>$model->kegiatanoperasi_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kegiatan Operasi','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kegiatanoperasi_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kegiatan Operasi', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            'kegiatanoperasi_id',
            'kegiatanoperasi_kode',
            'kegiatanoperasi_nama',
            'kegiatanoperasi_namalainnya',
            array(               // related city displayed as a link
                'name' => 'kegiatanoperasi_aktif',
                'type' => 'raw',
                'value' => (($model->kegiatanoperasi_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
            ),
        ),
    )); ?>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Kegiatan Operasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>