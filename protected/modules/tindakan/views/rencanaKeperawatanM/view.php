<legend class='rim'>Lihat Rencana Keperawatan</legend>
<?php
$this->breadcrumbs = array(
    'Sarencana Keperawatan Ms' => array('index'),
    $model->rencanakeperawatan_id,
);

$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Rencana Keperawatan '.$model->rencanakeperawatan_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RJRencanakeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RJRencanakeperawatanM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RJRencanakeperawatanM', 'icon'=>'pencil','url'=>array('update','id'=>$model->rencanakeperawatan_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RJRencanakeperawatanM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->rencanakeperawatan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Rencana Keperawatan ', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        'rencanakeperawatan_id',
        'diagnosakeperawatan_id',
        'rencana_kode',
        'rencana_intervensi',
        'rencana_rasionalisasi',
        'iskolaborasiintervensi',
    ),
)); ?>

<div class="form-actions">
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
        $this->createUrl('update', array('id' => $model->rencanakeperawatan_id, 'modul_id' => Yii::app()->session['modul_id'])),
        array('title' => 'Ubah', 'class' => 'btn btn-danger',)
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Rencana Keperawatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('rencanaKeperawatanM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'view')); ?>
</div>