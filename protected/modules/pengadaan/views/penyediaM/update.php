<?php
$this->breadcrumbs=array(
	'Penyedia Ms'=>array('index'),
	$model->penyedia_id=>array('view','id'=>$model->penyedia_id),
	'Update',
);

?>
<div class="white-container">
    <div class="panel panel-gradient">
        <div class="panel panel-heading">
            <div class="panel-title"> Ubah <b> Penyedia </b></div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            
            <?php echo $this->renderPartial('_form',array('model'=>$model, 'modDok' => $modDok)); ?></div>
        </div>
    </div>

