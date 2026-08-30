
<?php
$this->breadcrumbs=array(
	'Kppengangkatanpns Ts'=>array('index'),
	$model->pengangkatanpns_id=>array('view','id'=>$model->pengangkatanpns_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' KPPengangkatanpnsT #'.$model->pengangkatanpns_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPengangkatanpnsT', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPPengangkatanpnsT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' KPPengangkatanpnsT', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->pengangkatanpns_id))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' KPPengangkatanpnsT', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
<?php $this->widget('UserTips',array('type'=>'update'));?>