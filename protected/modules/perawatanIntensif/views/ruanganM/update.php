
<?php
$this->breadcrumbs=array(
	'Saruangan Ms'=>array('index'),
	$model->ruangan_id=>array('view','id'=>$model->ruangan_id),
	'Update',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Tindakan Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Ruangan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Ruangan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->ruangan_id))) ;
                //(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'Tindakan Ruangan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdateTindakan',array('model'=>$model,
//                                'modTindakanRuangan'=>$modTindakanRuangan,
//                                'modRiwayatRuangan'=>$modRiwayatRuangan,
                                'modDetails'=>$modDetails
                                )); ?>
<?php //$this->widget('UserTips',array('type'=>'update'));?>