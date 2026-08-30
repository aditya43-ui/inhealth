<?php
$this->breadcrumbs=array(
	'Preventifmainten Ms'=>array('index'),
	'Create',
);
?>
<div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><i class="far fa-plus-square"></i> Tambah <strong>Preventive Maintenance Barang </strong></div>
            </div>
            <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial('_form', 
                array(
                    'model'=>$model, 
                    'modHitung' => $modHitung,
                    'models'=>$models,
                )); ?>
</div>
</div>