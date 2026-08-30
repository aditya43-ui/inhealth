<?php
$this->breadcrumbs=array(
	'Sabank Rek Ms'=>array('index'),
	$model->obatalkespenjamin_id=>array('view','id'=>$model->obatalkespenjamin_id),
	'Update',
);

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Obat Alkes Penjamin</b></div>
    </div>
    <div class="panel-body">
    	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
    </div>
</div>
