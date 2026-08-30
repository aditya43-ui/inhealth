<?php
$this->breadcrumbs=array(
	'Satypeanastesi Ms'=>array('index'),
	$model->typeanastesi_id=>array('view','id'=>$model->typeanastesi_id),
	'Update',
);

?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title judul">Ubah <b>Tipe Anestesi</b></div>
    </div>
    <div class="panel-body">

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
	<?php echo $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model)); ?>
</div>
</div>
