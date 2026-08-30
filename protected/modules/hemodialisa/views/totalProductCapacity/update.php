
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <strong>Total Product Capacity</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Total Product Capacity'=>array('admin'),
                $model->hd_tpc_id=>array('view','id'=>$model->hd_tpc_id),
                'Ubah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
    </div>
</div>

