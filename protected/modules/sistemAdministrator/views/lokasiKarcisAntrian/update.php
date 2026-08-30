<?php
$this->breadcrumbs=array(
	'Lokasi Karcis Antrian'=>array('admin'),
	$model->lokasi_karcisantrian_id=>array('view','id'=>$model->lokasi_karcisantrian_id),
	'Ubah',
);

?>
<!--<div class="white-container">
	<legend class="rim2">Ubah Loket</legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Lokasi Karcis Antrian</b></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
    </div>
</div>
<!--</div>-->
