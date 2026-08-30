<?php
$this->breadcrumbs=array(
	'Pencatatan Sisa Makanan',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pencatatan Sisa Makanan</div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model, 'kunjungan'=>$kunjungan), true); ?>

    </div>
</div>
