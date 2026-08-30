<?php
$this->breadcrumbs=array(
	'Jenispengadaan Ms'=>array('index'),
	$model->jenispengadaan_id=>array('view','id'=>$model->jenispengadaan_id),
	'Update',
);

?>
<div class="white-container">
    <div class="panel panel-gradient">
        <div class="panel panel-heading">
            <div class="panel-title"> Ubah <b> Jenis Pengadaan </b> </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>
