
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <strong>Hardness</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Hardness'=>array('admin'),
                $model->hd_hardness_id=>array('view','id'=>$model->hd_hardness_id),
                'Ubah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
    </div>
</div>

