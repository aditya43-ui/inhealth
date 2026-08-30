
<?php
$this->breadcrumbs=array(
	'Kppengorganisasi Rs'=>array('index'),
	$model->pengorganisasi_id=>array('view','id'=>$model->pengorganisasi_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Pengorganisasian Pegawai', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPengorganisasiR', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPPengorganisasiR', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' KPPengorganisasiR', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->pengorganisasi_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pengorganisasian Pegawai', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
<?php $this->widget('UserTips',array('type'=>'update'));?>