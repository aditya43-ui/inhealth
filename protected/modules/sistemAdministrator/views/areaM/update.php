
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="far fa-edit"></i>Ubah <strong>Area</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Area'=>array('admin'),
                $model->area_id=>array('view','id'=>$model->area_id),
                'Ubah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
    </div>
</div>

