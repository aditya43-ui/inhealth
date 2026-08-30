<div class="white-container">
     <legend class="rim2">Ubah <b>Profil</b></legend>
<?php
$this->breadcrumbs=array(
	'Sapegawai Ms'=>array('index'),
	$model->pegawai_id=>array('view','id'=>$model->pegawai_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Pegawai', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pegawai', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Pegawai', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->pegawai_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pegawai', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model,'modRuanganPegawai'=>$modRuanganPegawai)); ?>
<?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>