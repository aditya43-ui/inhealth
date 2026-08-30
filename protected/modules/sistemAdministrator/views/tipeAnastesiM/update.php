<?php
$this->breadcrumbs=array(
	'Satipeanastesi Ms'=>array('index'),
	$model->typeanastesi_id=>array('view','id'=>$model->typeanastesi_id),
	'Update',
);

$arrMenu = array();
array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Tipe Diet '.$model->typeanastesi_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
$this->menu=$arrMenu;
$this->widget('bootstrap.widgets.BootAlert'); 
?>

<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>