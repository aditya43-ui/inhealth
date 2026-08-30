<?php
$this->breadcrumbs=array(
	'Jenis Surat Ms',
);

$this->menu=array(
	array('label'=>'Create JenisSuratM', 'url'=>array('create')),
	array('label'=>'Manage JenisSuratM', 'url'=>array('admin')),
);
?>

<h1>Jenis Surat Ms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
