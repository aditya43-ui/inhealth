<?php
$this->breadcrumbs=array(
    'Tingkatrisiko Ms'=>array('index'),
    $model->tingkatrisiko_id=>array('view','id'=>$model->tingkatrisiko_id),
    'Update',
);

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Tingkat Risiko</b></div>
    </div>
    <div class="panel-body">

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
    </div>
</div>
