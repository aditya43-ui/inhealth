<?php
$this->breadcrumbs=array(
	'Satipeanastesi Ms'=>array('index'),
	'Create',
);

$arrMenu = array();
array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tipe Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); 
?>

<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>