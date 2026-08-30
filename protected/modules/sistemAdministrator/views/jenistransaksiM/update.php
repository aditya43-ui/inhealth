<?php
$this->breadcrumbs=array(
	'Jenistransaksi Ms'=>array('index'),
	$model->jenistransaksi_id=>array('view','id'=>$model->jenistransaksi_id),
	'Update',
);

?>
<div class="white-container">
	<legend class="rim2">Ubah Jenis Transaksi</legend>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?></div>
