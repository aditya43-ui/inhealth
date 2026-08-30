<?php
//$this->breadcrumbs=array(
//	'Jenismakanan Ms'=>array('index'),
//	'Create',
//);
?>


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tambah <b>Jenis Makanan</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

    </div>
</div>