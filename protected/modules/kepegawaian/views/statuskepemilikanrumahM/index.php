<?php
$this->breadcrumbs=array(
	'Statuskepemilikanrumah Ms',
);

$this->menu=array(
	array('label'=>'Create StatuskepemilikanrumahM', 'url'=>array('create')),
	array('label'=>'Manage StatuskepemilikanrumahM', 'url'=>array('admin')),
);
?>

<h1>Statuskepemilikanrumah Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
