<?php
$this->breadcrumbs=array(
	'Subtiperesiko Ms'=>array('index'),
	$model->subtiperesiko_id=>array('view','id'=>$model->subtiperesiko_id),
	'Update',
);

?>
<div class="white-container">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"> Ubah <b> Sub Tipe Risiko</b> </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            
            <?php echo $this->renderPartial('_form',array('model'=>$model)); ?></div>
        </div>
    </div>