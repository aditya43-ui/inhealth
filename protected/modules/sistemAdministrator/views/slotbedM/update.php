
<div class="row">
<div class="col-md-12">
	<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Ubah Jadwal Bed</div>
	</div>
	<div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'slotbed Ms' => array('index'),
            $model->slotbed_id => array('view', 'id' => $model->slotbed_id),
            'Update',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>


        <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model,'listHari'=>$listHari)); ?>
	</div>
	</div>
</div>
</div>