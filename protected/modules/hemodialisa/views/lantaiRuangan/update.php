<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah <b>Lantai Ruangan</b></div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Lookup Ms'=>array('index'),
            $model->lookup_id=>array('view','id'=>$model->lookup_id),
            'Update',
    );
    $this->menu=array(
//            array('label'=>Yii::t('mds','Update').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form',array('model'=>$model,'modDetail'=>$modDetail)); ?>
    </div>
</div>