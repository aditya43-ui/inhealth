<?php
$this->breadcrumbs=array(
	'Obat Alkes Penjamin'=>array('admin'),
	(!empty($model->obatalkespenjamin_id)?"Ubah":"Tambah"),
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><?php echo (!empty($model->obatalkespenjamin_id)?"Ubah":"Tambah"); ?> <b>Obat Alkes Penjamin</b></div>
    </div>
    <div class="panel-body">
    	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    	<?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
    </div>
</div>
