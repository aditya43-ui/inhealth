<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-credit-card"></i> Form <b>Skip</b></div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Guinvasetlain Ts'=>array('index'),
            $model->prevmainten_id=>array('view','prevmainten_id'=>$model->prevmainten_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formSkip',array('model'=>$model)); ?>
    </div>
</div>