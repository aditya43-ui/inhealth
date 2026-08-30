<?php
//$this->breadcrumbs=array(
//	'Jenismakanan Ms'=>array('index'),
//	$model->jenismakanan_id=>array('view','id'=>$model->jenismakanan_id),
//	'Update',
//);

?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Jenis Makanan</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

    </div>
</div>
