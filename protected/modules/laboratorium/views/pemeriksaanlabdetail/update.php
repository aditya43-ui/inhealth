
<?php
$this->breadcrumbs=array(
	'Lkpemeriksaanlabdet Ms'=>array('index'),
	$model->pemeriksaanlabdet_id=>array('view','id'=>$model->pemeriksaanlabdet_id),
	'Update',
);

$arrMenu = array();
array_push($arrMenu,array('label'=>Yii::t('mds','Update').' LBPemeriksaanlabdetM #'.$model->pemeriksaanlabdet_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//array_push($arrMenu,array('label'=>Yii::t('mds','List').' LBPemeriksaanlabdetM', 'icon'=>'list', 'url'=>array('index'))) ;
//(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' LBPemeriksaanlabdetM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//array_push($arrMenu,array('label'=>Yii::t('mds','View').' LBPemeriksaanlabdetM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->pemeriksaanlabdet_id))) ;
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' LBPemeriksaanlabdetM', 'icon'=>'folder-open', 'url'=>array('admin','modul_id'=>Yii::app()->session['modul_id']))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model,
                                                    'modDetails'=>$modDetails,
                                                    'modPemeriksaanLab'=>$modPemeriksaanLab)); ?>