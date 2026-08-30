<?php
$this->breadcrumbs = array(
    'Sapemilikbarang Ms' => array('index'),
    $model->pemilikbarang_id,
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'View') . ' Pemilik Barang', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUPemilikbarangM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GUPemilikbarangM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' GUPemilikbarangM', 'icon'=>'pencil','url'=>array('update','id'=>$model->pemilikbarang_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' GUPemilikbarangM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pemilikbarang_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pemilik Barang', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        'pemilikbarang_id',
        'pemilikbarang_kode',
        'pemilikbarang_nama',
        'pemilikbarang_namalainnya',
        'pemilikbarang_aktif',
    ),
)); ?>

<div class="form-actions">
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Pemilik Barang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/gudangUmum/pemilikbarangM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'view')); ?>
</div>