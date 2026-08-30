<?php
$this->breadcrumbs = array(
    'Gfkonfigfarmasi Ks' => array('index'),
    $model->konfigfarmasi_id,
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'View') . ' Konfigurasi Farmasi ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAKonfigfarmasiK', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAKonfigfarmasiK', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAKonfigfarmasiK', 'icon'=>'pencil','url'=>array('update','id'=>$model->konfigfarmasi_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAKonfigfarmasiK','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->konfigfarmasi_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Konfigurasi Farmasi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        'konfigfarmasi_id',
        'tglberlaku',
        'persenppn',
        'persenpph',
        'persehargajual',
        'totalpersenhargajual',
        //bayarlangsung',
        array(
            'name' => 'bayarlangsung',
            'value' => (empty($model->bayarlangsung) ? "Tidak" : "Ya"),
        ),
        'pesandistruk',
        'pesandifaktur',
        'formulajasadokter',
        'formulajasaparamedis',
        'hargaygdigunakan',
        'pembulatanharga',
        'konfigfarmasi_aktif',
        'admracikan',
    ),
)); ?>

<div class="form-actions">
    <?php $this->widget('UserTips', array('type' => 'view')); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Konfigurasi Farmasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/gudangFarmasi/presentasiHargaJual/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
</div>