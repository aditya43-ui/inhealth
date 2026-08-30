<?php
$this->breadcrumbs=array(
	'Tipe Risiko Ms'=>array('index'),
	$model->tiperesiko_id=>array('view','id'=>$model->tiperesiko_id),
	'Update',
);

?>
<div class="white-container">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"> Ubah <b> Tipe Risiko</b></div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            
            <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
        </div>
    </div>
</div>

