<?php
$this->breadcrumbs=array(
	'Tipe Risiko Ms'=>array('index'),
	'Create',
);
?>
<div class="white-container">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> Tambah <b> Tipe Risiko</b> </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            <?php echo $this->renderPartial("_jsFunctions", array('model'=>$model), true); ?>
        </div>
    </div>
</div>