<?php
$this->breadcrumbs = array(
    'Sasuku Ms' => array('index'),
    $model->suku_id,
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'View') . ' Suku ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Suku', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Suku', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Suku', 'icon'=>'pencil','url'=>array('update','id'=>$model->suku_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Suku','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->suku_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Suku', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        'suku_id',
        'suku_nama',
        'suku_namalainnya',
        array(               // related city displayed as a link
            'name' => 'suku_aktif',
            'type' => 'raw',
            'value' => (($model->suku_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
        ),
    ),
)); ?>

<div class="form-actions">
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Suku', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/sistemAdministrator/SukuM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'view')); ?>
</div>