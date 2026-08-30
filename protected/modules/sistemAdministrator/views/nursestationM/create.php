<?php
$this->breadcrumbs=array(
	'Nurse Station'=>array('admin'),
	'Tambah',
);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Tambah <strong>Nurse Station</strong></div>
            </div>
            <div class="panel-body">
				<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
				
				<?php echo $this->renderPartial('_form', array('model'=>$model,'modelnursekamar'=>$modelnursekamar,)); ?>
			</div>
		</div>
	</div>
</div>
