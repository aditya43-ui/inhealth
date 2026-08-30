<?php
$this->breadcrumbs = array(
    'Satipediet Ms' => array('index'),
    $model->tipediet_id,
);

$arrMenu = array();
array_push($arrMenu, array('label' => Yii::t('mds', 'View') . ' Tipe Diet ' . $model->tipediet_id, 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tipe Diet', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tipe Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Tipe Diet', 'icon'=>'pencil','url'=>array('update','id'=>$model->tipediet_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Tipe Diet','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->tipediet_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tipe Diet', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        'tipediet_id',
        'tipediet_nama',
        'tipediet_namalainnya',
        array(
            'label' => 'Aktif',
            'type' => 'raw',
            'value' => (($model->tipediet_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
        ),
    ),
)); ?>

<div class="form-actions">
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Tipe Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/sistemAdministrator/TipeDietM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'view')); ?>
</div>