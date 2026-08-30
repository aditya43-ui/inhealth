
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <strong>Brine Tank</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Brine Tank'=>array('admin'),
                $model->hd_brinetank_id=>array('view','id'=>$model->hd_brinetank_id),
                'Ubah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
    </div>
</div>

