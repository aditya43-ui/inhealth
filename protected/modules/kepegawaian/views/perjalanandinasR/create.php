
<?php
$this->breadcrumbs=array(
	'Kpperjalanandinas Rs'=>array('index'),
	'Create',
);
$id_pegawai = isset($_GET['id']) ? $_GET['id'] : null;
$this->renderPartial('_dataPegawai',array('modPegawai'=>$modPegawai));
$this->renderPartial('/_tabulasi', array('modPegawai'=>$modPegawai, 'id_pegawai'=>$id_pegawai));
$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//$arrMenu = array();
////                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KPPengorganisasiR ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
////                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPengorganisasiR', 'icon'=>'list', 'url'=>array('index'))) ;
////                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' KPPengorganisasiR', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;
//
//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'details'=>$details)); ?>
<?php //$this->widget('UserTips',array('type'=>'create'));?>