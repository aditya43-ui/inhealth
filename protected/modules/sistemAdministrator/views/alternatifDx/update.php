<div class="white-container">
    <legend class="rim2">Ubah <b>Alternatif Diagnosa</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Bataskarakteristik Ms'=>array('index'),
            $model->alternatifdx_id=>array('view','id'=>$model->alternatifdx_id),
            'Update',
    );
    $this->menu=array(
//            array('label'=>Yii::t('mds','Update').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view. '_form',array('model'=>$model,'modDetail'=>$modDetail)); ?>
</div>