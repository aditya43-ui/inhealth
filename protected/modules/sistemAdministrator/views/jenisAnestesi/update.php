<?php
$this->breadcrumbs=array(
	'Jenis Anestesi'=>array('index'),
	$model->jenisanastesi_id=>array('view','id'=>$model->jenisanastesi_id),
	'Update',
);

?>
<div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title judul">Ubah <b>Jenis Anestesi</b></div>
        </div>
            <div class="panel-body">

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
	<?php echo $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model)); ?>
</div>
</div>
