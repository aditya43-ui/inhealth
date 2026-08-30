<?php
$this->breadcrumbs=array(
	'Detectability Ms'=>array('index'),
	$model->detectability_id=>array('view','id'=>$model->detectability_id),
	'Update',
);

?>
<div class="white-container">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"> Ubah <b> Detectability</b></div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            
            <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
        </div>
    </div>
</div>

