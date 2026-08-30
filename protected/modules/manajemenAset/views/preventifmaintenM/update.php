<?php
$this->breadcrumbs=array(
	'Preventif Mainten'=>array('index'),
	$model->preventifmainten_id=>array('view','id'=>$model->preventifmainten_id),
	'Ubah',
);

?>
 <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><i class="far fa-edit"></i> Ubah <strong>Preventive Maintenance Barang</strong></div>
            </div>
            <div class="panel-body">

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
 </div>
