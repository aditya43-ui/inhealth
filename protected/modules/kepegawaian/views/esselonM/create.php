
<?php
$this->breadcrumbs=array(
	'Esselon Ms'=>array('index'),
	'Create',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Esselon ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAGelarBelakangM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Esselon', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('_tabMenu',array());
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>