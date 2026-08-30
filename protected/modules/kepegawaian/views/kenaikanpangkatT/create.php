
<?php
$this->breadcrumbs=array(
	'Kpkenaikanpangkat Ts'=>array('index'),
	'Create',
);
$this->renderPartial('_dataPegawai',array('modPegawai'=>$modPegawai));
$this->renderPartial('/_tabulasi', array('modPegawai'=>$modPegawai));
$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPKenaikanpangkatT ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPKenaikanpangkatT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' KPKenaikanpangkatT', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'modUsulan'=>$modUsulan,'modRealisasi'=>$modRealisasi)); ?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>